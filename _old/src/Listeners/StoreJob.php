<?php

namespace Boss\Listeners;

use Boss\Events\JobPushed;
use Boss\Contracts\JobRepository;

class StoreJob
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
     * @param  \Boss\Events\JobPushed  $event
     * @return void
     */
    public function handle(JobPushed $event)
    {
        $this->jobs->pushed(
            $event->connectionName, $event->queue, $event->payload
        );
    }
}
