<?php

namespace Boss\Tests\Feature\Fixtures;

use Boss\SupervisorProcess;

class SupervisorProcessWithFakeRestart extends SupervisorProcess
{
    public $wasRestarted = false;

    public function restart()
    {
        $this->wasRestarted = true;
    }
}
