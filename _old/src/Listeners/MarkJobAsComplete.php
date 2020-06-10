<?php

namespace Boss\Listeners;

use Boss\Events\JobDeleted;
use Boss\Contracts\JobRepository;
use Boss\Contracts\TagRepository;

class MarkJobAsComplete
{
    /**
     * The job repository implementation.
     *
     * @var \Boss\Contracts\JobRepository
     */
    public $jobs;

    /**
     * The tag repository implementation.
     *
     * @var \Boss\Contracts\TagRepository
     */
    public $tags;

    /**
     * Create a new listener instance.
     *
     * @param  \Boss\Contracts\JobRepository  $jobs
     * @param  \Boss\Contracts\TagRepository  $tags
     * @return void
     */
    public function __construct(JobRepository $jobs, TagRepository $tags)
    {
        $this->jobs = $jobs;
        $this->tags = $tags;
    }

    /**
     * Handle the event.
     *
     * @param  \Boss\Events\JobDeleted  $event
     * @return void
     */
    public function handle(JobDeleted $event)
    {
        $this->jobs->completed($event->payload, $event->job->hasFailed());

        if (! $event->job->hasFailed() && count($this->tags->monitored($event->payload->tags())) > 0) {
            $this->jobs->remember($event->connectionName, $event->queue, $event->payload);
        }
    }
}
