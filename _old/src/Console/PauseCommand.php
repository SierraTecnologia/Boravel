<?php

namespace Boss\Console;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Boss\MasterSupervisor;
use Boss\Contracts\MasterSupervisorRepository;

class PauseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boss:pause';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pause the master supervisor';

    /**
     * Execute the console command.
     *
     * @param  \Boss\Contracts\MasterSupervisorRepository  $masters
     * @return void
     */
    public function handle(MasterSupervisorRepository $masters)
    {
        $masters = collect($masters->all())->filter(function ($master) {
            return Str::startsWith($master->name, MasterSupervisor::basename());
        })->all();

        foreach (Arr::pluck($masters, 'pid') as $processId) {
            $this->info("Sending USR2 Signal To Process: {$processId}");

            if (! posix_kill($processId, SIGUSR2)) {
                $this->error("Failed to kill process: {$processId} (".posix_strerror(posix_get_last_error()).')');
            }
        }
    }
}