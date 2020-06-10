<?php

namespace Boravel\Models\Identity;

use Boravel\Models\Model;
use SiObjects\Support\Traits\Models\ComplexRelationamentTrait;

class Account extends Model
{
    // use ComplexRelationamentTrait;
    
    // protected static $COMPLEX_RELATIONAMENT_MODELS = [
    //     \App\Models\Photo::class,
    //     \App\Models\Video::class
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'status',
        'integration_id',
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'url' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'account' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'type' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    /**
     * Get all of the owning businessable models.
     */
    public function accountable()
    {
        return $this->morphTo(); //, 'businessable_type', 'businessable_code'
    }

    /**
     * Get all of the business that are assigned this tag.
     */
    public function business()
    {
        return $this->morphedByMany('Boravel\Models\Identity\Business', 'accountable');
    }

    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany('App\Models\User', 'accountable');
    }

    /**
     * Get all of the persons that are assigned this tag.
     */
    public function persons()
    {
        return $this->morphedByMany('Boravel\Models\Identity\Person', 'accountable');
    }
}
