<?php

namespace Boss\Console;

use Illuminate\Console\Command;
use Boss\Contracts\MasterSupervisorRepository;

class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boss:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all of the deployed machines';

    /**
     * Execute the console command.
     *
     * @param  \Boss\Contracts\MasterSupervisorRepository  $masters
     * @return void
     */
    public function handle(MasterSupervisorRepository $masters)
    {
        $masters = $masters->all();

        if (empty($masters)) {
            return $this->info('No machines are running.');
        }

        $this->table([
            'Name', 'PID', 'Supervisors', 'Status',
        ], collect($masters)->map(function ($master) {
            return [
                $master->name,
                $master->pid,
                $master->supervisors ? collect($master->supervisors)->map(function ($supervisor) {
                    return explode(':', $supervisor, 2)[1];
                })->implode(', ') : 'None',
                $master->status,
            ];
        })->all());
    }
}
