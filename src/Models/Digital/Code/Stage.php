<?php

namespace Boravel\Models\Digital\Code;

use Boravel\Models\Model;

class Stage extends Model
{

    protected $organizationPerspective = false;

    protected $table = 'code_stages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
}