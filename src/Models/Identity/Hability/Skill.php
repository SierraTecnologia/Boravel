<?php

namespace Boravel\Models\Identity\Hability;

use Boravel\Models\Model;

class Skill extends Model
{

    protected $organizationPerspective = false;

    protected $table = 'skills';
    
    public $incrementing = false;
    protected $casts = [
        'code' => 'string',
    ];
    protected $primaryKey = 'code';
    protected $keyType = 'string';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'code',
        'skill_code'
    ];


    protected $mappingProperties = array(

        'name' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'code' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
        
    /**
     * Get all of the owning businessable models.
     */
    public function skillable()
    {
        return $this->morphTo(); //, 'businessable_type', 'businessable_code'
    }


    /**
     * Get all of the persons that are assigned this tag.
     */
    public function persons()
    {
        return $this->morphedByMany('Boravel\Models\Identity\Person', 'skillable');
    }
}
