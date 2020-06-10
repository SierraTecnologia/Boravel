<?php

namespace Boravel\Models\System;

use SiObjects\Support\Traits\Models\ArchiveTrait;

use SiObjects\Support\Traits\Models\BusinessTrait;

class Trackings extends ArchiveTrait
{
    use BusinessTrait;
    
    public $table = 'trackings';

    public $primaryKey = 'id';

    public $fillable = [
        'token',
        'data',
    ];

    public static $rules = [];
}
