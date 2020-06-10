<?php

namespace Boss\Tests\Feature\Jobs;

use Illuminate\Queue\InteractsWithQueue;

class ConditionallyFailingJob
{
    use InteractsWithQueue;

    public function handle()
    {
        if (isset($_SERVER['boss.fail'])) {
            return $this->fail();
        }
    }

    public function tags()
    {
        return ['first'];
    }
}
