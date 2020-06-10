<?php

namespace Boss\Tests\Unit\Fixtures;

class FakeJobWithTagsMethod
{
    public function tags()
    {
        return [
            'first',
            'second',
        ];
    }
}
