<?php

namespace Boravel\Models\Identity\Rotina;

use Boravel\Models\Model;

class Worker extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'time', // im segundos
        'init', // im segundos
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'time' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'init' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    /**
     * Get all of the owning workerable models.
     */
    public function workerable()
    {
        return $this->morphTo();
    }
}
