<?php

Route::prefix('admin')->group(function () {

    
    // ADmin Router
    Route::get('/gerenciar/{modulo}', 'AdminController@index');
    Route::get('/gerenciar/{modulo}/{id}', 'AdminController@show');
    Route::post('/gerenciar/{modulo}/', 'AdminController@store');
    Route::get('/gerenciar/{modulo}/{id}/edit', 'AdminController@edit');
    Route::put('/gerenciar/{modulo}/{id}', 'AdminController@update');
    Route::delete('/gerenciar/{modulo}/{id}', 'AdminController@destroy');


    // Route::resource('users', 'UserController');

    // Route::resource('languages', 'LanguageController');
    // Route::resource('sectors', 'SectorController');
    // Route::resource('services', 'ServiceController');
    // Route::resource('ambientes', 'AmbienteController');

    // Route::resource('actions', 'ActionController');
    // Route::get('actions/model/{model}', 'ActionController@actionsForModel')->name('actions.model');
    // Route::get('actions/execute/{modelId}/{actionCod}', 'ActionController@executeAction')->name('actions.execute');
    
    // Route::resource('databases', 'DatabaseController');
    // Route::resource('databaseCollections', 'DatabaseCollectionsController');
    // Route::resource('projects', 'ProjectController');
    // Route::resource('collaborators', 'CollaboratorController');
    // Route::resource('runners', 'RunnerController');
    // Route::resource('loggers', 'LoggerController');
    // Route::resource('computers', 'ComputerController');
    // Route::resource('domains', 'DomainController');
    // Route::resource('settings', 'SettingController');
});