<?php

namespace Boss\Tests\Feature;

use Boss\JobId;
use Boss\Tests\IntegrationTest;

class RedisJobIdTest extends IntegrationTest
{
    public function test_ids_can_be_generated()
    {
        $this->assertSame('1', JobId::generate());
        $this->assertSame('2', JobId::generate());
        $this->assertSame('3', JobId::generate());
    }

    public function test_custom_ids_can_be_generated()
    {
        JobId::generateUsing(function () {
            return 'foo';
        });

        $this->assertSame('foo', JobId::generate());

        JobId::generateUsing(null);
    }
}
