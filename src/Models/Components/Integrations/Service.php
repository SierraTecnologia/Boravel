<?php
/**
 * Armazena casas de cambios que aceitam trocar moedas
 */

namespace Boravel\Models\Components\Integrations;

use Boravel\Models\Model;

class Service extends Model
{

    
    protected $organizationPerspective = false;

    protected $table = 'integration_services';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status'
    ];


    protected $mappingProperties = array(

        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'status' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    // public function user()
    // {
    //     return $this->belongsTo('App\Models\User', 'user_id', 'id');
    // }
}