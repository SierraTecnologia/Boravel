<?php

namespace Boss\Listeners;

use Boss\Events\JobPushed;
use Boss\Contracts\TagRepository;

class StoreMonitoredTags
{
    /**
     * The tag repository implementation.
     *
     * @var \Boss\Contracts\TagRepository
     */
    public $tags;

    /**
     * Create a new listener instance.
     *
     * @param  \Boss\Contracts\TagRepository  $tags
     * @return void
     */
    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Handle the event.
     *
     * @param  \Boss\Events\JobPushed  $event
     * @return void
     */
    public function handle(JobPushed $event)
    {
        $monitoring = $this->tags->monitored($event->payload->tags());

        if (! empty($monitoring)) {
            $this->tags->add($event->payload->id(), $monitoring);
        }
    }
}
