<?php

namespace Boss\Listeners;

use Boss\Events\JobReleased;
use Boss\Contracts\JobRepository;

class MarkJobAsReleased
{
    /**
     * The job repository implementation.
     *
     * @var \Boss\Contracts\JobRepository
     */
    public $jobs;

    /**
     * Create a new listener instance.
     *
     * @param  \Boss\Contracts\JobRepository  $jobs
     * @return void
     */
    public function __construct(JobRepository $jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * Handle the event.
     *
     * @param  \Boss\Events\JobReleased  $event
     * @return void
     */
    public function handle(JobReleased $event)
    {
        $this->jobs->released($event->connectionName, $event->queue, $event->payload);
    }
}
