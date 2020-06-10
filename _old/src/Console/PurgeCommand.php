<?php

namespace Boss\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Boss\MasterSupervisor;
use Boss\ProcessInspector;
use Boss\Contracts\ProcessRepository;
use Boss\Contracts\SupervisorRepository;
use Boss\Contracts\MasterSupervisorRepository;

class PurgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boss:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Terminate any rogue Boss processes';

    /**
     * @var \Boss\Contracts\SupervisorRepository
     */
    private $supervisors;

    /**
     * @var \Boss\Contracts\ProcessRepository
     */
    private $processes;

    /**
     * @var \Boss\ProcessInspector
     */
    private $inspector;

    /**
     * Create a new command instance.
     *
     * @param  \Boss\Contracts\SupervisorRepository  $supervisors
     * @param  \Boss\Contracts\ProcessRepository  $processes
     * @param  \Boss\ProcessInspector  $inspector
     * @return void
     */
    public function __construct(
        SupervisorRepository $supervisors,
        ProcessRepository $processes,
        ProcessInspector $inspector
    ) {
        parent::__construct();

        $this->supervisors = $supervisors;
        $this->processes = $processes;
        $this->inspector = $inspector;
    }

    /**
     * Execute the console command.
     *
     * @param  \Boss\Contracts\MasterSupervisorRepository  $masters
     * @return void
     */
    public function handle(MasterSupervisorRepository $masters)
    {
        foreach ($masters->names() as $master) {
            if (Str::startsWith($master, MasterSupervisor::basename())) {
                $this->purge($master);
            }
        }
    }

    /**
     * Purge any orphan processes.
     *
     * @param  string  $master
     * @return void
     */
    public function purge($master)
    {
        $this->recordOrphans($master);

        $expired = $this->processes->orphanedFor(
            $master, $this->supervisors->longestActiveTimeout()
        );

        collect($expired)->each(function ($processId) use ($master) {
            $this->comment("Killing Process: {$processId}");

            exec("kill {$processId}");

            $this->processes->forgetOrphans($master, [$processId]);
        });
    }

    /**
     * Record the orphaned Boss processes.
     *
     * @param  string  $master
     * @return void
     */
    protected function recordOrphans($master)
    {
        $this->processes->orphaned(
            $master, $orphans = $this->inspector->orphaned()
        );

        foreach ($orphans as $processId) {
            $this->info("Observed Orphan: {$processId}");

            if (! posix_kill($processId, SIGTERM)) {
                $this->error("Failed to kill process for Orphan: {$processId} (".posix_strerror(posix_get_last_error()).')');
            }
        }
    }
}
