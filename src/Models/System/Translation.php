<?php

namespace Boravel\Models\System;

use SiObjects\Support\Traits\Models\ArchiveTrait;


/**
 * @todo Verificar compatibilidade com 
 * \RicardoSierra\Translation\Models\System\Translation
 * 
 * Aqui é para Campos do Modelo e la nao !
 */

class Translation extends ArchiveTrait
{
    public $table = 'model_translations';

    public $primaryKey = 'id';

    protected $guarded = [];

    public static $rules = [];

    protected $fillable = [
        'entity_id',
        'entity_type',
        'entity_data',
        'language',
    ];

    public function getDataAttribute()
    {
        $object = app($this->entity_type);

        $attributes = (array) json_decode($this->entity_data);
        $object->attributes = array_merge($attributes, [
            'id' => $this->entity_id,
        ]);

        return $object;
    }
}
