<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group([
    'namespace'	 => 'Api\V1',
    'middleware' => ['api', 'xss', 'access'],
    'prefix'     => 'api/v1',
], function ($router) {
    // area
    $router->group(['prefix' => 'area'], function ($router){
        $router->get('/', 'AreaController@index');
        $router->get('/insert_area', 'AreaController@insert_area');
    });

    $router->group(['prefix' => 'service'], function ($router) {
        $router->get('/province', 'ServiceController@list_province');
        $router->get('/region', 'ServiceController@list_region');
    });
});
