<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    // Dashboard Routes...
    Route::get('/stats', 'DashboardStatsController@index')->name('boss.stats.index');

    // Workload Routes...
    Route::get('/workload', 'WorkloadController@index')->name('boss.workload.index');

    // Master Supervisor Routes...
    Route::get('/masters', 'MasterSupervisorController@index')->name('boss.masters.index');

    // Monitoring Routes...
    Route::get('/monitoring', 'MonitoringController@index')->name('boss.monitoring.index');
    Route::post('/monitoring', 'MonitoringController@store')->name('boss.monitoring.store');
    Route::get('/monitoring/{tag}', 'MonitoringController@paginate')->name('boss.monitoring-tag.paginate');
    Route::delete('/monitoring/{tag}', 'MonitoringController@destroy')->name('boss.monitoring-tag.destroy');

    // Job Metric Routes...
    Route::get('/metrics/jobs', 'JobMetricsController@index')->name('boss.jobs-metrics.index');
    Route::get('/metrics/jobs/{id}', 'JobMetricsController@show')->name('boss.jobs-metrics.show');

    // Queue Metric Routes...
    Route::get('/metrics/queues', 'QueueMetricsController@index')->name('boss.queues-metrics.index');
    Route::get('/metrics/queues/{id}', 'QueueMetricsController@show')->name('boss.queues-metrics.show');

    // Job Routes...
    Route::get('/jobs/recent', 'RecentJobsController@index')->name('boss.recent-jobs.index');
    Route::get('/jobs/failed', 'FailedJobsController@index')->name('boss.failed-jobs.index');
    Route::get('/jobs/failed/{id}', 'FailedJobsController@show')->name('boss.failed-jobs.show');
    Route::post('/jobs/retry/{id}', 'RetryController@store')->name('boss.retry-jobs.show');
});

// Catch-all Route...
Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('boss.index');



/**
 * Chats
 */
Route::get('conversations', 'ConversationController@index');
Route::post('conversations', 'ConversationController@store');

Route::get('conversations/{conversation}/users', 'ConversationController@participants');
Route::post('conversations/{conversation}/users', 'ConversationController@join');
Route::delete('conversations/{conversation}/users', 'ConversationController@leaveConversation');

Route::get('conversations/{conversation}/messages', 'ConversationController@getMessages');
Route::post('conversations/{conversation}/messages', 'ConversationController@sendMessage');
Route::delete('conversations/{conversation}/messages', 'ConversationController@deleteMessages');

Route::get('/chat', 'ChatController@index')->name('chat');


