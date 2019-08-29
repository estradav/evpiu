<?php
return array(
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
    'default' => 'evpiu',
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
    'connections' => array (

        //CONEXION BASE DE DATOS EVPUI
        'evpiu'  => array (
            'driver'        =>  'mysql',
            'host'          =>  env('EVPIU_HOST'),
            'database'      =>  env('EVPIU_DATABASE'),
            'username'      =>  env('EVPIU_USERNAME'),
            'password'      =>  env('EVPIU_PASSWORD'),
            'charset'       =>  'utf8',
            'collation'     =>  'utf8_unicode_ci',
            'prefix'        =>  '',
            'strict'        =>  false,
        ),
        //CONEXION A BASE DE DATOS DE DMS
        'sqlsrv_dms'     => array (
            'driver'        =>  'sqlsrv',
            'host'          =>  env('DMS_HOST'),
            'port'          =>  env('DMS_PORT'),
            'database'      =>  env('DMS_DATABASE'),
            'username'      =>  env('DMS_USERNAME'),
            'password'      =>  env('DMS_PASSWORD'),
            'charset'       =>  'utf8',
            'collation'     =>  'Modern_Spanish_CI_AS',
            'prefix'        =>  '',
            'prefix_indexes' => true,
        ),

        // CONEXION A BASEDE DATOS DE MAX
        'sqlsrv_max'     => array (
            'driver'        =>  'sqlsrv',
            'host'          =>  env('MAX_HOST'),
            'port'          =>  env('MAX_PORT'),
            'database'      =>  env('MAX_DATABASE'),
            'username'      =>  env('MAX_USERNAME'),
            'password'      =>  env('MAX_PASSWORD'),
            'charset'       =>  'utf8',
            'collation'     =>  'Modern_Spanish_CI_AS',
            'prefix'        =>  '',
            'prefix_indexes' => true,
        ),


        'migrations' => 'migrations',
    ),
);



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




//        'pgsql' => [
//            'driver' => 'pgsql',
//            'host' => env('DB_HOST', '127.0.0.1'),
//            'port' => env('DB_PORT', '5432'),
//            'database' => env('DB_DATABASE', 'forge'),
//            'username' => env('DB_USERNAME', 'forge'),
//            'password' => env('DB_PASSWORD', ''),
//            'charset' => 'utf8',
//            'prefix' => '',
//            'prefix_indexes' => true,
//            'schema' => 'public',
//            'sslmode' => 'prefer',
//        ],
//
//        'sqlite' => [
//            'driver' => 'sqlite',
//            'database' => env('DB_DATABASE', database_path('database.sqlite')),
//            'prefix' => '',
//            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
//        ],

//'redis' => [
//        'client' => 'predis',
//        'default' => [
//            'host' => env('REDIS_HOST', '127.0.0.1'),
//            'password' => env('REDIS_PASSWORD', null),
//            'port' => env('REDIS_PORT', 6379),
//            'database' => env('REDIS_DB', 0),
//        ],
//        'cache' => [
//            'host' => env('REDIS_HOST', '127.0.0.1'),
//            'password' => env('REDIS_PASSWORD', null),
//            'port' => env('REDIS_PORT', 6379),
//            'database' => env('REDIS_CACHE_DB', 1),
//        ],
