<?php

namespace Boravel\Models\Digital\Midia;

use Boravel\Models\Model;

class Video extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'actors',
        'language',
        'url',
        'time',
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    public function links()
    {
        return $this->sitios();
    }

    public function sitios()
    {
        return $this->morphToMany('Boravel\Models\Identity\Hability\Sitio', 'sitioable');
    }
        
    /**
     * Get all of the owning videoable models.
     */
    public function videoable()
    {
        return $this->morphTo(); //, 'videoable_type', 'videoable_code'
    }
}
