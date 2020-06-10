<?php

namespace Boss\Listeners;

use Boss\Events\JobFailed;
use Boss\Contracts\TagRepository;

class StoreTagsForFailedJob
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
     * @param  \Boss\Events\JobFailed  $event
     * @return void
     */
    public function handle(JobFailed $event)
    {
        $tags = collect($event->payload->tags())->map(function ($tag) {
            return 'failed:'.$tag;
        })->all();

        $this->tags->addTemporary(
            2880, $event->payload->id(), $tags
        );
    }
}
