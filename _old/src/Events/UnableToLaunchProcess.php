<?php

namespace Boss\Events;

use Boss\WorkerProcess;

class UnableToLaunchProcess
{
    /**
     * The worker process instance.
     *
     * @var \Boss\WorkerProcess
     */
    public $process;

    /**
     * Create a new event instance.
     *
     * @param  \Boss\WorkerProcess  $process
     * @return void
     */
    public function __construct(WorkerProcess $process)
    {
        $this->process = $process;
    }
}
