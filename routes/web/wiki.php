<?php

Route::prefix('wiki')->group(function () {
    Route::namespace('Wiki')->group(function () {

        /** ============ NEUTRAL AREA ============ */

        // Main page
        Route::get('/', ['as' => 'home', 'uses' => 'HomeController@showHomePage']);

        // Change current language
        Route::get('lang/{code}', ['as' => 'language.set', 'uses' => 'HomeController@changeApplicationLanguage']);

        /** ============ ONLY GUESTS AREA ============ */

        Route::group(['https', 'middleware' => 'guest'], function () {

            // Login page
            Route::get('login', ['as' => 'login', 'uses' => 'AuthController@showLoginPage']);

            // Login with social provider
            Route::get('login/{provider}', ['as' => 'login.with', 'uses' => 'AuthController@loginWithProvider']);
        });

        /** ============ ONLY AUTHENTICATED USERS AREA ============ */

        Route::group(['https', 'middleware' => 'auth'], function () {

            // Logout
            Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

            /** ============ ONLY GRANTED USERS AREA ============ */

            Route::group(['middleware' => 'permissions'], function () {

                // RESTful resources
                Route::resource('category', 'CategoryController');
                Route::resource('language', 'LanguageController');
                Route::resource('page', 'PageController');
                Route::resource('page.version', 'VersionController', ['only' => ['index', 'show']]);
                Route::resource('provider', 'ProviderController');
                Route::resource('role', 'RoleController');
                Route::resource('user', 'UserController');

            });
        });
    });
});
