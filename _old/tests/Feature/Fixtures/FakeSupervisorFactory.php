<?php

namespace Boss\Tests\Feature\Fixtures;

use Boss\SupervisorFactory;
use Boss\SupervisorOptions;
use Boss\Tests\Feature\Fakes\SupervisorWithFakeMonitor;

class FakeSupervisorFactory extends SupervisorFactory
{
    public $supervisor;

    public function make(SupervisorOptions $options)
    {
        return $this->supervisor = new SupervisorWithFakeMonitor($options);
    }
}
