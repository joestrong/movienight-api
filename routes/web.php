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
    return response()->json([]);
});

$router->post('auth/exchange/facebook', 'LoginController@exchangeFacebookToken');

$router->get('/movies', [
    'middleware' => 'auth',
    'uses' => 'MoviesController@index'
]);
