<?php

namespace Boss\Listeners;

use Boss\Events\JobsMigrated;
use Boss\Contracts\JobRepository;

class MarkJobsAsMigrated
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
     * @param  \Boss\Events\JobsMigrated  $event
     * @return void
     */
    public function handle(JobsMigrated $event)
    {
        $this->jobs->migrated($event->connectionName, $event->queue, $event->payloads);
    }
}
