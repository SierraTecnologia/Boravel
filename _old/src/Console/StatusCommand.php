<?php

namespace Boss\Console;

use Illuminate\Console\Command;
use Boss\Contracts\MasterSupervisorRepository;

class StatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boss:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current status of Boss';

    /**
     * Execute the console command.
     *
     * @param  \Boss\Contracts\MasterSupervisorRepository  $masterSupervisorRepository
     * @return void
     */
    public function handle(MasterSupervisorRepository $masterSupervisorRepository)
    {
        $this->line($this->currentStatus($masterSupervisorRepository));
    }

    /**
     * Get the current status of Boss.
     *
     * @param  \Boss\Contracts\MasterSupervisorRepository  $masterSupervisorRepository
     * @return string
     */
    protected function currentStatus(MasterSupervisorRepository $masterSupervisorRepository)
    {
        if (! $masters = $masterSupervisorRepository->all()) {
            return 'Boss is inactive.';
        }

        return collect($masters)->contains(function ($master) {
            return $master->status === 'paused';
        }) ? 'Boss is paused.' : 'Boss is running.';
    }
}
