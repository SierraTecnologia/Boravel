<?php

namespace Boravel\Models\Identity\Business;

use App\Models\User;

class Business extends User
{

    public $incrementing = false;
    protected $casts = [
        'code' => 'string',
    ];
    protected $primaryKey = 'code';
    protected $keyType = 'string';


    protected $table = 'businesses';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'code'
    ];


    protected $mappingProperties = array(

        'user_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'slug' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}