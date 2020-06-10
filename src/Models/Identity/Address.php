<?php

namespace Boravel\Models\Identity;

use App\Models\Model;
use SiObjects\Support\Traits\Models\ComplexRelationamentTrait;

class Address extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street',
        'num',
        'region',
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'number' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
    
        
    /**
     * Get all of the owning addressable models.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the business that are assigned this tag.
     */
    public function business()
    {
        return $this->morphedByMany('App\Models\Negocios\Business', 'addressable');
    }

    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany('App\Models\User', 'addressable');
    }
}
