<?php

namespace Boss\Tests\Unit;

use Mockery;
use Boss\Supervisor;
use Boss\Tests\UnitTest;
use Boss\SupervisorCommands\Scale;

class ScaleCommandTest extends UnitTest
{
    public function test_scale_command_tells_supervisor_to_scale()
    {
        $supervisor = Mockery::mock(Supervisor::class);
        $supervisor->shouldReceive('scale')->once()->with(3);
        $scale = new Scale;
        $scale->process($supervisor, ['scale' => 3]);
    }
}
