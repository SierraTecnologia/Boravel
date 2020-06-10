<?php

namespace Boss\Listeners;

use Boss\Stopwatch;
use Boss\Events\JobDeleted;
use Boss\Contracts\MetricsRepository;

class UpdateJobMetrics
{
    /**
     * The metrics repository implementation.
     *
     * @var \Boss\Contracts\MetricsRepository
     */
    public $metrics;

    /**
     * The stopwatch instance.
     *
     * @var \Boss\Stopwatch
     */
    public $watch;

    /**
     * Create a new listener instance.
     *
     * @param  \Boss\Contracts\MetricsRepository  $metrics
     * @param  \Boss\Stopwatch  $watch
     * @return void
     */
    public function __construct(MetricsRepository $metrics, Stopwatch $watch)
    {
        $this->watch = $watch;
        $this->metrics = $metrics;
    }

    /**
     * Stop gathering metrics for a job.
     *
     * @param  \Boss\Events\JobDeleted  $event
     * @return void
     */
    public function handle(JobDeleted $event)
    {
        if ($event->job->hasFailed()) {
            return;
        }

        $time = $this->watch->check($event->payload->id());

        $this->metrics->incrementQueue(
            $event->job->getQueue(), $time
        );

        $this->metrics->incrementJob(
            $event->payload->displayName(), $time
        );
    }
}
