<?php

namespace Boravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Boravel\Models\Customer;
use Illuminate\Support\Facades\Log;

class RoutineTrackingUserDeviseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customer, $trackingType, $trackingData, $timestamp, $íp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, $trackingType, $trackingData, $timestamp = false, $ip = false)
    {
        $this->customer = $customer;
        $this->trackingType = $trackingType;
        $this->trackingData = $trackingData;
        if (!$timestamp) $timestamp = time();
        $this->timestamp = $timestamp;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->customer->tracking->create(
            TrackingType::createToTracking(
                $this->trackingType,
                $this->trackingData,
                $this->timestamp,
                $this->ip
            )
        );
    }
}
