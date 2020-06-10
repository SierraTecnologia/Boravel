<?php

namespace Boss;

class SupervisorFactory
{
    /**
     * Create a new supervisor instance.
     *
     * @param  \Boss\SupervisorOptions  $options
     * @return \Boss\Supervisor
     */
    public function make(SupervisorOptions $options)
    {
        return new Supervisor($options);
    }
}
