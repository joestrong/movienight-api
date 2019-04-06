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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return response()->json([]);
});

$router->post('auth/exchange/facebook', 'LoginController@exchangeFacebookToken');

$router->group(['middleware' => 'auth'], function(Router $router) {
    $router->get('/movies', [
        'uses' => 'MoviesController@index'
    ]);
});
