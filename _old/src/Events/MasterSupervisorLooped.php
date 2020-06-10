<?php

namespace Boss\Events;

use Boss\MasterSupervisor;

class MasterSupervisorLooped
{
    /**
     * The master supervisor instance.
     *
     * @var \Boss\MasterSupervisor
     */
    public $master;

    /**
     * Create a new event instance.
     *
     * @param  \Boss\MasterSupervisor  $master
     * @return void
     */
    public function __construct(MasterSupervisor $master)
    {
        $this->master = $master;
    }
}
