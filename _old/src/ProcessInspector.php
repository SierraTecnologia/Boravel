<?php

namespace Boss;

use Illuminate\Support\Arr;
use Boss\Contracts\SupervisorRepository;
use Boss\Contracts\MasterSupervisorRepository;

class ProcessInspector
{
    /**
     * The command executor.
     *
     * @var \Boss\Exec
     */
    public $exec;

    /**
     * Create a new process inspector instance.
     *
     * @param  \Boss\Exec  $exec
     * @return void
     */
    public function __construct(Exec $exec)
    {
        $this->exec = $exec;
    }

    /**
     * Get the IDs of all Boss processes running on the system.
     *
     * @return array
     */
    public function current()
    {
        return array_diff(
            $this->exec->run('pgrep -f [h]orizon'),
            $this->exec->run('pgrep -f boss:purge')
        );
    }

    /**
     * Get an array of running Boss processes that can't be accounted for.
     *
     * @return array
     */
    public function orphaned()
    {
        return array_diff($this->current(), $this->monitoring());
    }

    /**
     * Get all of the process IDs Boss is actively monitoring.
     *
     * @return array
     */
    public function monitoring()
    {
        return collect(app(SupervisorRepository::class)->all())
            ->pluck('pid')
            ->pipe(function ($processes) {
                $processes->each(function ($process) use (&$processes) {
                    $processes = $processes->merge($this->exec->run("pgrep -P {$process}"));
                });

                return $processes;
            })
            ->merge(
                Arr::pluck(app(MasterSupervisorRepository::class)->all(), 'pid')
            )->all();
    }
}
