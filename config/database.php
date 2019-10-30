<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('EV_CONNECTION', 'evpiu'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'evpiu' => [
            'driver' => 'sqlsrv',
            'host' => env('EV_HOST'),
            'port' => env('EV_PORT'),
            'database' => env('EV_DATABASE'),
            'username' => env('EV_USERNAME'),
            'password' => env('EV_PASSWORD'),
            'charset' => 'Latin1_General_CI_AS',
            'prefix' => '',
            'prefix_indexes' => true,
            'engine' => 'InnoDB',
        ],

        'DMS' => [
            'driver' => 'sqlsrv',
            'host' => env('DMS_HOST'),
            'port' => env('DMS_PORT'),
            'database' => env('DMS_DATABASE'),
            'username' => env('DMS_USERNAME'),
            'password' => env('DMS_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'engine' => 'InnoDB',
        ],

        'MAX' => [
            'driver' => 'sqlsrv',
            'host' => env('MAX_HOST'),
            'port' => env('MAX_PORT'),
            'database' => env('MAX_DATABASE'),
            'username' => env('MAX_USERNAME'),
            'password' => env('MAX_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'engine' => 'InnoDB',
        ],

        'MAXP' => [
            'driver' => 'sqlsrv',
            'host' => env('MAXP_HOST'),
            'port' => env('MAXP_PORT'),
            'database' => env('MAXP_DATABASE'),
            'username' => env('MAXP_USERNAME'),
            'password' => env('MAXP_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'engine' => 'InnoDB',
        ],

        'FE'  => [
            'driver' => 'sqlsrv',
            'host' => env('FE_HOST'),
            'port' => env('FE_PORT'),
            'database' => env('FE_DATABASE'),
            'username' => env('FE_USERNAME'),
            'password' => env('FE_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'engine' => 'InnoDB',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
