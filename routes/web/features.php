<?php

Route::prefix('features')->group(function () {
    Route::namespace('Features')->group(function () {


        include dirname(__FILE__) . DIRECTORY_SEPARATOR . "features". DIRECTORY_SEPARATOR . "components.php";
        include dirname(__FILE__) . DIRECTORY_SEPARATOR . "features". DIRECTORY_SEPARATOR . "manipule.php";




    });
});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');