<?php

namespace Boss;

use Illuminate\Support\Collection;
use Boss\Contracts\MetricsRepository;
use Illuminate\Contracts\Queue\Factory as QueueFactory;

class AutoScaler
{
    /**
     * The queue factory implementation.
     *
     * @var \Illuminate\Contracts\Queue\Factory
     */
    public $queue;

    /**
     * The metrics repository implementation.
     *
     * @var \Boss\Contracts\MetricsRepository
     */
    public $metrics;

    /**
     * Create a new auto-scaler instance.
     *
     * @param  \Illuminate\Contracts\Queue\Factory  $queue
     * @param  \Boss\Contracts\MetricsRepository  $metrics
     * @return void
     */
    public function __construct(QueueFactory $queue, MetricsRepository $metrics)
    {
        $this->queue = $queue;
        $this->metrics = $metrics;
    }

    /**
     * Balance the workers on the given supervisor.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @return void
     */
    public function scale(Supervisor $supervisor)
    {
        $pools = $this->poolsByQueue($supervisor);

        $workers = $this->numberOfWorkersPerQueue(
            $supervisor, $this->timeToClearPerQueue($supervisor, $pools)
        );

        $workers->each(function ($workers, $queue) use ($supervisor, $pools) {
            $this->scalePool($supervisor, $pools[$queue], $workers);
        });
    }

    /**
     * Get the process pools keyed by their queue name.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @return \Illuminate\Support\Collection
     */
    protected function poolsByQueue(Supervisor $supervisor)
    {
        return $supervisor->processPools->mapWithKeys(function ($pool) {
            return [$pool->queue() => $pool];
        });
    }

    /**
     * Get the times in milliseconds needed to clear the queues.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @param  \Illuminate\Support\Collection  $pools
     * @return \Illuminate\Support\Collection
     */
    protected function timeToClearPerQueue(Supervisor $supervisor, Collection $pools)
    {
        return $pools->mapWithKeys(function ($pool, $queue) use ($supervisor) {
            $size = $this->queue->connection($supervisor->options->connection)->readyNow($queue);

            return [$queue => ($size * $this->metrics->runtimeForQueue($queue))];
        });
    }

    /**
     * Get the number of workers needed per queue for proper balance.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @param  \Illuminate\Support\Collection  $timeToClear
     * @return \Illuminate\Support\Collection
     */
    protected function numberOfWorkersPerQueue(Supervisor $supervisor, Collection $timeToClear)
    {
        $timeToClearAll = $timeToClear->sum();

        return $timeToClear->mapWithKeys(function ($timeToClear, $queue) use ($supervisor, $timeToClearAll) {
            return $timeToClearAll > 0 && $supervisor->options->autoScaling()
                    ? [$queue => (($timeToClear / $timeToClearAll) * $supervisor->options->maxProcesses)]
                    : [$queue => $supervisor->options->maxProcesses / count($supervisor->processPools)];
        })->sort();
    }

    /**
     * Scale the given pool to the recommended number of workers.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @param  \Boss\ProcessPool  $pool
     * @param  float  $workers
     * @return void
     */
    protected function scalePool(Supervisor $supervisor, $pool, $workers)
    {
        $supervisor->pruneTerminatingProcesses();

        $poolProcesses = $pool->totalProcessCount();

        if (round($workers) > $poolProcesses &&
            $this->wouldNotExceedMaxProcesses($supervisor)) {
            $pool->scale($poolProcesses + 1);
        } elseif (round($workers) < $poolProcesses &&
                  $poolProcesses > $supervisor->options->minProcesses) {
            $pool->scale($poolProcesses - 1);
        }
    }

    /**
     * Determine if adding another process would exceed max process limit.
     *
     * @param  \Boss\Supervisor  $supervisor
     * @return bool
     */
    protected function wouldNotExceedMaxProcesses(Supervisor $supervisor)
    {
        return ($supervisor->totalProcessCount() + 1) <= $supervisor->options->maxProcesses;
    }
}
