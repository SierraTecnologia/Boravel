<?php

namespace Boss\Tests\Unit\Fixtures;

class FakeEvent
{
    public function tags()
    {
        return [
            'eventTag1',
            'eventTag2',
        ];
    }
}