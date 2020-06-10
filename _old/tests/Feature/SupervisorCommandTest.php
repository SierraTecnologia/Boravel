<?php

namespace Boss\Tests\Feature;

use Boss\SupervisorFactory;
use Boss\Tests\IntegrationTest;
use Boss\Tests\Feature\Fixtures\FakeSupervisorFactory;

class SupervisorCommandTest extends IntegrationTest
{
    public function test_supervisor_command_can_start_supervisor_monitoring()
    {
        $this->app->instance(SupervisorFactory::class, $factory = new FakeSupervisorFactory);
        $this->artisan('boss:supervisor', ['name' => 'foo', 'connection' => 'redis']);

        $this->assertTrue($factory->supervisor->monitoring);
        $this->assertTrue($factory->supervisor->working);
    }

    public function test_supervisor_command_can_start_paused_supervisors()
    {
        $this->app->instance(SupervisorFactory::class, $factory = new FakeSupervisorFactory);
        $this->artisan('boss:supervisor', ['name' => 'foo', 'connection' => 'redis', '--paused' => true]);

        $this->assertFalse($factory->supervisor->working);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_supervisor_command_can_set_process_niceness()
    {
        $this->app->instance(SupervisorFactory::class, $factory = new FakeSupervisorFactory);
        $this->artisan('boss:supervisor', ['name' => 'foo', 'connection' => 'redis', '--nice' => 10]);

        $this->assertEquals(10, $this->myNiceness());
    }

    private function myNiceness()
    {
        $pid = getmypid();

        return (int) trim(`ps -p $pid -o nice=`);
    }
}
