<?php

namespace Boss\Http\Controllers;

use Boss\Jobs\RetryFailedJob;

class RetryController extends Controller
{
    /**
     * Retry a failed job.
     *
     * @param  string  $id
     * @return void
     */
    public function store($id)
    {
        dispatch(new RetryFailedJob($id));
    }
}
