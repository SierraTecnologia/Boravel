<?php

namespace Boravel\Models\System;

use SiObjects\Support\Traits\Models\ArchiveTrait;

class Metrics extends ArchiveTrait
{
    public $table = 'metrics';

    public $primaryKey = 'id';

    public $fillable = [
        'token',
        'data',
    ];

    public static $rules = [];
}
