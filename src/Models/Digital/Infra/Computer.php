<?php

namespace Boravel\Models\Digital\Infra;

use Boravel\Models\Model;
use SiUtils\Tools\Ssh;

class Computer extends Model
{

    public static $apresentationName = 'Servidores';

    protected $organizationPerspective = true;

    protected $table = 'infra_computers';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infra_service_account_id',
        'infra_ambiente_id',
        'infra_ssh_key_id',
    ];


    protected $mappingProperties = array(

        'customer_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'infra_ssh_key_id' => [
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

    public function getName()
    {
        return $this->instance;
    }

    public function getApresentationName()
    {
        if (!$name = $this->getName()) {
            return 'Vazio';
        }
        return $name;
    }

    public function connect()
    {
        return new Ssh($this);
    }


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