<?php

namespace Boss\SupervisorCommands;

use Boss\Contracts\Restartable;

class Restart
{
    /**
     * Process the command.
     *
     * @param  \Boss\Contracts\Restartable  $restartable
     * @return void
     */
    public function process(Restartable $restartable)
    {
        $restartable->restart();
    }
}
