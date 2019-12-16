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

    'default' => env('DB_CONNECTION', 'area'),

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
        'area' => [
            'read' => [
                'host' => env('DB_AREA_HOST_READ', '127.0.0.1'),
            ],
            'write' => [
                'host' => env('DB_AREA_HOST_WRITE', '127.0.0.1'),
            ],
            'driver' => 'mysql',
            'port' => env('DB_AREA_PORT', '3306'),
            'database' => env('DB_AREA_DATABASE', 'forge'),
            'username' => env('DB_AREA_USERNAME', 'forge'),
            'password' => env('DB_AREA_PASSWORD', ''),
            'unix_socket' => env('DB_AREA_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
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
];
