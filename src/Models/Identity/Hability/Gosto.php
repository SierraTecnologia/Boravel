<?php

namespace Boravel\Models\Identity\Hability;

use Boravel\Models\Model;

class Gosto extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'gosto_id'
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'gosto_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    /**
     * Get all of the businesses that are assigned this gosto.
     */
    public function businesses()
    {
        return $this->morphedByMany('App\Models\Negocios\Business', 'gostoable');
    }

    /**
     * Get all of the girls that are assigned this gosto.
     */
    public function girls()
    {
        return $this->morphedByMany('Boravel\Models\Identity\Girl', 'gostoable');
    }

    /**
     * Get all of the users that are assigned this gosto.
     */
    public function users()
    {
        return $this->morphedByMany('App\Models\User', 'gostoable');
    }
}
