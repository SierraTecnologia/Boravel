<?php

namespace Boss\Events;

use Boss\SupervisorProcess;

class SupervisorProcessRestarting
{
    /**
     * The supervisor process instance.
     *
     * @var \Boss\SupervisorProcess
     */
    public $process;

    /**
     * Create a new event instance.
     *
     * @param  \Boss\SupervisorProcess  $process
     * @return void
     */
    public function __construct(SupervisorProcess $process)
    {
        $this->process = $process;
    }
}
