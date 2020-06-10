<?php

namespace Boravel\Models\System;

use SiObjects\Support\Traits\Models\ArchiveTrait;

class Archive extends ArchiveTrait
{
    public $table = 'archives';

    public $primaryKey = 'id';

    public $fillable = [
        'token',
        'entity_id',
        'entity_type',
        'entity_data',
    ];

    public static $rules = [];
}
