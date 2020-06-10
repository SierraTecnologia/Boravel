<?php

namespace Boravel\Models\Fisicos;

use Boravel\Models\Model;
use SiObjects\Support\Traits\Models\AsFofocavel;

class Weapon extends Model
{
    use AsFofocavel;

    protected $organizationPerspective = false;

    protected $table = 'weapons';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];


    protected $mappingProperties = array(

        'name' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
    );

    /**
     * Get all of the post's observations.
     */
    public function observations()
    {
        return $this->comments();
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

}