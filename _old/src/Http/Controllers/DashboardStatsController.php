<?php

namespace Boss\Http\Controllers;

use Boss\WaitTimeCalculator;
use Boss\Contracts\JobRepository;
use Boss\Contracts\MetricsRepository;
use Boss\Contracts\SupervisorRepository;
use Boss\Contracts\MasterSupervisorRepository;

class DashboardStatsController extends Controller
{
    /**
     * Get the key performance stats for the dashboard.
     *
     * @return array
     */
    public function index()
    {
        return [
            'jobsPerMinute' => app(MetricsRepository::class)->jobsProcessedPerMinute(),
            'processes' => $this->totalProcessCount(),
            'queueWithMaxRuntime' => app(MetricsRepository::class)->queueWithMaximumRuntime(),
            'queueWithMaxThroughput' => app(MetricsRepository::class)->queueWithMaximumThroughput(),
            'recentlyFailed' => app(JobRepository::class)->countRecentlyFailed(),
            'recentJobs' => app(JobRepository::class)->countRecent(),
            'status' => $this->currentStatus(),
            'wait' => collect(app(WaitTimeCalculator::class)->calculate())->take(1),
            'periods' => [
                'recentJobs' => config('boss.trim.recent'),
                'recentlyFailed' => config('boss.trim.failed'),
            ],
        ];
    }

    /**
     * Get the total process count across all supervisors.
     *
     * @return int
     */
    protected function totalProcessCount()
    {
        $supervisors = app(SupervisorRepository::class)->all();

        return collect($supervisors)->reduce(function ($carry, $supervisor) {
            return $carry + collect($supervisor->processes)->sum();
        }, 0);
    }

    /**
     * Get the current status of Boss.
     *
     * @return string
     */
    protected function currentStatus()
    {
        if (! $masters = app(MasterSupervisorRepository::class)->all()) {
            return 'inactive';
        }

        return collect($masters)->contains(function ($master) {
            return $master->status === 'paused';
        }) ? 'paused' : 'running';
    }
}
