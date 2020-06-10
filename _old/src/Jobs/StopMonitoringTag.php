<?php

namespace Boss\Jobs;

use Boss\Contracts\JobRepository;
use Boss\Contracts\TagRepository;

class StopMonitoringTag
{
    /**
     * The tag to stop monitoring.
     *
     * @var string
     */
    public $tag;

    /**
     * Create a new job instance.
     *
     * @param  string  $tag
     * @return void
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Execute the job.
     *
     * @param  \Boss\Contracts\JobRepository  $jobs
     * @param  \Boss\Contracts\TagRepository  $tags
     * @return void
     */
    public function handle(JobRepository $jobs, TagRepository $tags)
    {
        $tags->stopMonitoring($this->tag);

        $jobs->deleteMonitored($tags->jobs($this->tag));

        $tags->forget($this->tag);
    }
}
