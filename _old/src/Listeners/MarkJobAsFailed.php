<?php

namespace Boss\Listeners;

use Boss\Events\JobFailed;
use Boss\Contracts\JobRepository;

class MarkJobAsFailed
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
     * @param  \Boss\Events\JobFailed  $event
     * @return void
     */
    public function handle(JobFailed $event)
    {
        $this->jobs->failed(
            $event->exception, $event->connectionName,
            $event->queue, $event->payload
        );
    }
}
