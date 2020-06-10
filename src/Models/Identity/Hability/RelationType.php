<?php

namespace Boravel\Models\Identity\Hability;

use Boravel\Models\Model;

class RelationType extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'relation_type_id'
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'relation_type_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
    
    /**
     * Get all of the relations that are assigned this tag.
     */
    public function relations()
    {
        return $this->belongsToMany('Boravel\Models\Identity\Relation');
    }
    
    /**
     * Get all of the slaves that are assigned this tag.
     */
    public function slaves()
    {
        return $this->morphedByMany('Boravel\Models\Identity\Slave', 'skillable');
    }

    /**
     * Get all of the users that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany('App\Models\User', 'skillable');
    }
}
