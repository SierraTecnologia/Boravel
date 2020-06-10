<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Boravel\Models\Actions\Calendar;

use SiObjects\Support\Traits\Models\ComplexRelationamentTrait;
use Boravel\Models\Model;

use Illuminate\Support\Facades\Log;

class Task extends Model
{
    use ComplexRelationamentTrait;

    protected $organizationPerspective = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'date_estimated',
        'done'
    ];


}
