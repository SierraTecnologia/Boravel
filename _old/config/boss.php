<?php

/*
 * This file is part of the ricardosierra/laravel-boss
 *
 * (c) ricardosierra <contato@ricardosierra.com.br>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [

    /**
     * 
     */
    'sitec' => [
        'webhook' => [
            'secret' => '',
            'tolerance' => ''
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Boss Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Boss will be accessible from. If this
    | setting is null, Boss will reside under the same domain as the
    | application. Otherwise, this value will serve as the subdomain.
    |
    */

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Boss Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Boss will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */

    'path' => 'boss',

    /*
    |--------------------------------------------------------------------------
    | Boss Redis Connection
    |--------------------------------------------------------------------------
    |
    | This is the name of the Redis connection where Boss will store the
    | meta information required for it to function. It includes the list
    | of supervisors, failed jobs, job metrics, and other information.
    |
    */

    'use' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Boss Redis Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix will be used when storing all Boss data in Redis. You
    | may modify the prefix when you are running multiple installations
    | of Boss on the same server so that they don't have problems.
    |
    */

    'prefix' => env('BOSS_PREFIX', 'boss:'),

    /*
    |--------------------------------------------------------------------------
    | Boss Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will get attached onto each Boss route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Queue Wait Time Thresholds
    |--------------------------------------------------------------------------
    |
    | This option allows you to configure when the LongWaitDetected event
    | will be fired. Every connection / queue combination may have its
    | own, unique threshold (in seconds) before this event is fired.
    |
    */

    'waits' => [
        'redis:default' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Job Trimming Times
    |--------------------------------------------------------------------------
    |
    | Here you can configure for how long (in minutes) you desire Boss to
    | persist the recent and failed jobs. Typically, recent jobs are kept
    | for one hour while all failed jobs are stored for an entire week.
    |
    */

    'trim' => [
        'recent' => 60,
        'failed' => 10080,
        'monitored' => 10080,
    ],

    /*
    |--------------------------------------------------------------------------
    | Fast Termination
    |--------------------------------------------------------------------------
    |
    | When this option is enabled, Boss's "terminate" command will not
    | wait on all of the workers to terminate unless the --wait option
    | is provided. Fast termination can shorten deployment delay by
    | allowing a new instance of Boss to start while the last
    | instance will continue to terminate each of its workers.
    |
    */

    'fast_termination' => false,

    /*
    |--------------------------------------------------------------------------
    | Memory Limit (MB)
    |--------------------------------------------------------------------------
    |
    | This value describes the maximum amount of memory the Boss worker
    | may consume before it is terminated and restarted. You should set
    | this value according to the resources available to your server.
    |
    */

    'memory_limit' => 64,

    /*
    |--------------------------------------------------------------------------
    | Queue Worker Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the queue worker settings used by your application
    | in all environments. These supervisors and settings handle all your
    | queued jobs and will be provisioned by Boss during deployment.
    |
    */

    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default'],
                'balance' => 'simple',
                'processes' => 10,
                'tries' => 3,
            ],
        ],

        'local' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default'],
                'balance' => 'simple',
                'processes' => 3,
                'tries' => 3,
            ],
        ],
    ],


    /*
     * Namespace of models.
     */
    'model_namespace' => 'App\Models',

    /*
     * Date format for created_at.
     */
    'date_format' => 'Y-m-d H:i:s',

    /*
    * Informations about mysql tables
    */
    'tables' => [
        /*
         * Table name of users
         */
        'users' => [
            /*
             * Table name of users table.
             */
            'table_name' => 'users',
        
            /*
             * Primary key of users table.
             */
            'table_primary_key' => 'id',
        
            /*
             * Foreign key of users table.
             */
            'table_foreign_key' => 'user_id',
            /*
             * Model class name of users.
             */
            'user_model' => config('auth.providers.users.model', App\Models\User::class),
        ],
        
        /*
        * Table name of bossable relations.
        */
        'bossable' => [
            'table_name' => 'bossables',
            // Prefix of many-to-many relation fields.
            'morph_prefix' => 'bossable',
        ],
    
        /*
         * Table name of messable relations.
         */
        'messable' => [
            'table_name' => 'messables',
            // Prefix of many-to-many relation fields.
            'morph_prefix' => 'bossable',
        ],
    
        /*
         * Table name of bossable relations.
         */
        'bossable' => [
            'table_name' => 'bossables',
            // Prefix of many-to-many relation fields.
            'morph_prefix' => 'bossable',
        ]
    ],

];
