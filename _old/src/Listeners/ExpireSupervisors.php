<?php

namespace Boss\Listeners;

use Boss\Events\MasterSupervisorLooped;
use Boss\Contracts\SupervisorRepository;
use Boss\Contracts\MasterSupervisorRepository;

class ExpireSupervisors
{
    /**
     * Handle the event.
     *
     * @param  \Boss\Events\MasterSupervisorLooped  $event
     * @return void
     */
    public function handle(MasterSupervisorLooped $event)
    {
        app(MasterSupervisorRepository::class)->flushExpired();

        app(SupervisorRepository::class)->flushExpired();
    }
}
