<?php

namespace Boss\Tests\Feature\Jobs;

class LegacyJob
{
    public function fire($job, $data)
    {
        $job->delete();
    }
}
