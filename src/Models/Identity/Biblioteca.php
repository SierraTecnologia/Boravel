<?php

namespace Boravel\Models\Identity;

use Boravel\Models\Model;
use SiObjects\Support\Traits\Models\ComplexRelationamentTrait;

class Biblioteca extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'name', // im segundos
        'biblioteca_type_id',
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'url' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'biblioteca_type_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->bibliotecaType();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bibliotecaType()
    {
        return $this->belongsTo(BibliotecaType::class, 'biblioteca_type_id', 'id');
    }
}
