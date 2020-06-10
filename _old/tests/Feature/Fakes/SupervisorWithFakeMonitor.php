<?php

namespace Boss\Tests\Feature\Fakes;

use Boss\Supervisor;

class SupervisorWithFakeMonitor extends Supervisor
{
    public $monitoring = false;

    /**
     * {@inheritdoc}
     */
    public function monitor()
    {
        $this->monitoring = true;
    }
}
