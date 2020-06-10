<?php

namespace Boss\Tests\Feature;

use Mockery;
use Cake\Chronos\Chronos;
use Boss\MasterSupervisor;
use Boss\Tests\IntegrationTest;
use Boss\Contracts\JobRepository;
use Boss\Listeners\TrimMonitoredJobs;
use Boss\Events\MasterSupervisorLooped;

class TrimMonitoredJobsTest extends IntegrationTest
{
    public function test_trimmer_has_a_cooldown_period()
    {
        $trim = new TrimMonitoredJobs;

        $repository = Mockery::mock(JobRepository::class);
        $repository->shouldReceive('trimMonitoredJobs')->twice();
        $this->app->instance(JobRepository::class, $repository);

        // Should not be called first time since date is initialized...
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));

        Chronos::setTestNow(Chronos::now()->addMinutes(1600));

        // Should only be called twice...
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));

        Chronos::setTestNow();
    }
}
