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
$router->post('auth/validate-token', 'LoginController@validateToken');

$router->group(['middleware' => 'auth'], function(Router $router) {
    $router->get('user/my-profile', [
        'uses' => 'UserController@myProfile',
    ]);
    $router->group(['prefix' => 'users'], function (Router $router) {
        $router->get('my-profile', [
            'uses' => 'UserController@myProfile',
        ]);
        $router->get('{user_id}', [
            'uses' => 'UserController@show',
        ]);
    });
    $router->group(['prefix' => 'movies'], function (Router $router) {
        $router->get('', [
            'uses' => 'MoviesController@index',
        ]);
        $router->get('{movie_id}', [
            'uses' => 'MoviesController@show',
        ]);
        $router->post('{movie_id}/seen', [
            'uses' => 'MoviesController@postSeen',
        ]);
        $router->delete('{movie_id}/seen', [
            'uses' => 'MoviesController@deleteSeen',
        ]);
        $router->get('seen/{user_id}', [
            'uses' => 'MoviesController@seenList',
        ]);
    });
});
