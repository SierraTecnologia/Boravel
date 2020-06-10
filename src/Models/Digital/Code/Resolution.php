<?php

namespace Boravel\Models\Digital\Code;

use Boravel\Models\Model;

class Resolution extends Model
{

    protected $organizationPerspective = false;

    protected $table = 'code_resolutions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
}