<?php

namespace Boss\Http\Controllers;

use Boss\Contracts\SupervisorRepository;
use Boss\Contracts\MasterSupervisorRepository;

class MasterSupervisorController extends Controller
{
    /**
     * Get all of the master supervisors and their underlying supervisors.
     *
     * @param  \Boss\Contracts\MasterSupervisorRepository  $masters
     * @param  \Boss\Contracts\SupervisorRepository  $supervisors
     * @return \Illuminate\Support\Collection
     */
    public function index(MasterSupervisorRepository $masters,
                          SupervisorRepository $supervisors)
    {
        $masters = collect($masters->all())->keyBy('name')->sortBy('name');

        $supervisors = collect($supervisors->all())->sortBy('name')->groupBy('master');

        return $masters->each(function ($master, $name) use ($supervisors) {
            $master->supervisors = $supervisors->get($name);
        });
    }
}