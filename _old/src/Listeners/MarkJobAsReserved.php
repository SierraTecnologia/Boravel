<?php

namespace Boss\Listeners;

use Boss\Events\JobReserved;
use Boss\Contracts\JobRepository;

class MarkJobAsReserved
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
     * @param  \Boss\Events\JobReserved  $event
     * @return void
     */
    public function handle(JobReserved $event)
    {
        $this->jobs->reserved($event->connectionName, $event->queue, $event->payload);
    }
}
