<?php

namespace Boss\Listeners;

use Boss\Events\MasterSupervisorLooped;

class MonitorMasterSupervisorMemory
{
    /**
     * Handle the event.
     *
     * @param  \Boss\Events\MasterSupervisorLooped  $event
     * @return void
     */
    public function handle(MasterSupervisorLooped $event)
    {
        $master = $event->master;

        if ($master->memoryUsage() > config('boss.memory_limit', 64)) {
            $master->terminate(12);
        }
    }
}
