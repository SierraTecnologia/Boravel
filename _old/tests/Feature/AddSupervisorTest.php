<?php

namespace Boss\Tests\Feature;

use Boss\PhpBinary;
use Boss\MasterSupervisor;
use Boss\SupervisorOptions;
use Boss\Tests\IntegrationTest;
use Boss\Contracts\BossCommandQueue;
use Boss\MasterSupervisorCommands\AddSupervisor;

class AddSupervisorTest extends IntegrationTest
{
    public function test_add_supervisor_command_creates_new_supervisor_on_master_process()
    {
        $master = new MasterSupervisor;
        $phpBinary = PhpBinary::path();

        $master->loop();

        new AddSupervisor;
        resolve(BossCommandQueue::class)->push($master->commandQueue(), AddSupervisor::class, (new SupervisorOptions('my-supervisor', 'redis'))->toArray());

        $this->assertCount(0, $master->supervisors);

        $master->loop();

        $this->assertCount(1, $master->supervisors);

        $this->assertEquals(
            'exec '.$phpBinary.' artisan boss:supervisor my-supervisor redis --delay=0 --memory=128 --queue="default" --sleep=3 --timeout=60 --tries=0 --balance=off --max-processes=1 --min-processes=1 --nice=0',
            $master->supervisors->first()->process->getCommandLine()
        );
    }
}
