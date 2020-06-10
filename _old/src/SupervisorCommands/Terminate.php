<?php

namespace Boss\SupervisorCommands;

use Boss\Contracts\Terminable;

class Terminate
{
    /**
     * Process the command.
     *
     * @param  \Boss\Contracts\Terminable  $terminable
     * @param  array  $options
     * @return void
     */
    public function process(Terminable $terminable, array $options)
    {
        $terminable->terminate($options['status'] ?? 0);
    }
}
