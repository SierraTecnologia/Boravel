<?php

namespace Boss\Events;

use Boss\Supervisor;

class SupervisorLooped
{
    /**
     * The supervisor instance.
     *
     * @var \Boss\Supervisor
     */
    public $supervisor;

    /**
     * Create a new event instance.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @return void
     */
    public function __construct(Supervisor $supervisor)
    {
        $this->supervisor = $supervisor;
    }
}
