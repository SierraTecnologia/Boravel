<?php

namespace Boss\Tests\Feature;

use Laravel\Facades\Config;
use Boss\Boss;
use Illuminate\Support\Facades\Redis;
use Boss\Tests\IntegrationTest;

class RedisPrefixTest extends IntegrationTest
{
    public function test_prefix_can_be_configured()
    {
        config(['boss.prefix' => 'custom:']);

        Boss::use('default');

        $this->assertEquals('custom:', config('database.redis.boss.options.prefix'));
    }
}
