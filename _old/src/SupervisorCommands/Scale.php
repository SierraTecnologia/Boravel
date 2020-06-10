<?php

namespace Boss\SupervisorCommands;

use Boss\Supervisor;

class Scale
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
        $supervisor->scale($options['scale']);
    }
}
