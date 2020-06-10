<?php

namespace Boravel\Models\Digital\Infra;

use Boravel\Models\Model;

class Ambiente extends Model
{

    protected $organizationPerspective = false;

    protected $table = 'infra_ambientes';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];


    protected $mappingProperties = array(

        'customer_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'credit_card_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'user_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'docker_compose_file' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

}