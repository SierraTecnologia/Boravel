<?php

namespace Boss\SupervisorCommands;

use Boss\Supervisor;

class Balance
{
    /**
     * Process the command.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @param  array  $options
     * @return void
     */
    public function process(Supervisor $supervisor, array $options)
    {
        $supervisor->balance($options);
    }
}
