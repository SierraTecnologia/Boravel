<?php

namespace Boss\Listeners;

use Boss\Events\SupervisorLooped;

class PruneTerminatingProcesses
{
    /**
     * Handle the event.
     *
     * @param  \Boss\Events\SupervisorLooped  $event
     * @return void
     */
    public function handle(SupervisorLooped $event)
    {
        $event->supervisor->pruneTerminatingProcesses();
    }
}
