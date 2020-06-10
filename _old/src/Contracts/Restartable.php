<?php

namespace Boss\Contracts;

interface Restartable
{
    /**
     * Restart the process.
     *
     * @return void
     */
    public function restart();
}
