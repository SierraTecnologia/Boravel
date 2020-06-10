<?php
Route::group(['middleware' => 'auth'], function () {
    Route::get('/notifications/unread', 'NotificationsController@unread')->name('notifications.unread');
    Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
    Route::get('/notifications/count', 'NotificationsController@count')->name('notifications.count');

    Route::get('/messages', 'MessagesController@index')->name('messages.index');
    Route::get('/messages/to/{id}', 'MessagesController@create')->name('messages.create');
    Route::post('/messages', 'MessagesController@store')->name('messages.store');
    Route::get('/messages/{id}', 'MessagesController@show')->name('messages.show');
    Route::put('/messages/{id}', 'MessagesController@update')->name('messages.update');
});