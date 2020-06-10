<?php

namespace Boravel\Models\Digital\Infra;

use Boravel\Models\Model;

class Service extends Model
{

    protected $organizationPerspective = false;

    protected $table = 'infra_services';       

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


    public function getDockerComposer()
    {
        return $this->belongsTo('App\Models\Gateway', 'gateway_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }
}