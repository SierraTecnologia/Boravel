<?php

namespace Boss\Contracts;

interface Terminable
{
    /**
     * Terminate the process.
     *
     * @param  int  $status
     * @return void
     */
    public function terminate($status = 0);
}