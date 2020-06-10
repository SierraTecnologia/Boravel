<?php

namespace Boss\Listeners;

use Boss\Stopwatch;
use Boss\Events\JobReserved;

class StartTimingJob
{
    /**
     * The stopwatch instance.
     *
     * @var \Boss\Stopwatch
     */
    public $watch;

    /**
     * Create a new listener instance.
     *
     * @param  \Boss\Stopwatch  $watch
     * @return void
     */
    public function __construct(Stopwatch $watch)
    {
        $this->watch = $watch;
    }

    /**
     * Handle the event.
     *
     * @param  \Boss\Events\JobReserved  $event
     * @return void
     */
    public function handle(JobReserved $event)
    {
        $this->watch->start($event->payload->id());
    }
}
