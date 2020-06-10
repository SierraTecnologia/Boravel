<?php

namespace Boss\Listeners;

use Boss\Events\SupervisorLooped;

class MonitorSupervisorMemory
{
    /**
     * Handle the event.
     *
     * @param  \Boss\Events\SupervisorLooped  $event
     * @return void
     */
    public function handle(SupervisorLooped $event)
    {
        $supervisor = $event->supervisor;

        if ($supervisor->memoryUsage() > $supervisor->options->memory) {
            $supervisor->terminate(12);
        }
    }
}
