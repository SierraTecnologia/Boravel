<?php

namespace Boravel\Traits\Actions;

use Boravel\Resources\User;

trait ManagesUsers
{
    public function me(): User
    {
        $userAttributes = $this->get('me');

        return new User($userAttributes, $this);
    }
}
