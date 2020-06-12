<?php

namespace Boss\Http\Controllers;

use Boss\Contracts\WorkloadRepository;

class WorkloadController extends Controller
{
    /**
     * Get the current queue workload for the application.
     *
     * @param  \Boss\Contracts\WorkloadRepository  $workload
     * @return array
     */
    public function index(WorkloadRepository $workload)
    {
        return collect($workload->get())->sortBy('name')->values()->toArray();
    }
}