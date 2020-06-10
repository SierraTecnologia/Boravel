<?php

namespace Boravel\Models\System;

use Boravel\Modela\Model;

class Activation extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}