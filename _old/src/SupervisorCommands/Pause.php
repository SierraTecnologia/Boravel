<?php

namespace Boss\SupervisorCommands;

use Boss\Contracts\Pausable;

class Pause
{
    /**
     * Process the command.
     *
     * @param  \Boss\Contracts\Pausable  $pausable
     * @return void
     */
    public function process(Pausable $pausable)
    {
        $pausable->pause();
    }
}
