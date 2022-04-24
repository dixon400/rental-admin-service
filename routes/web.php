<?php

/** @var \Laravel\Lumen\Routing\Router $router */


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

$router->group(['prefix' => 'api/books'], function () use ($router) {
    $router->post('create', 'BooksController@createBook');
    $router->get('', 'BooksController@viewBooks');
    $router->delete('{id}', 'BooksController@deleteBook');
    $router->patch('{id}', 'BooksController@updateBook');
});

$router->group(['prefix' => 'api/equipment'], function () use ($router) {
    $router->post('create', 'EquipmentController@createEquipment');
    $router->get('', 'EquipmentController@viewEquipment');
    $router->patch('{id}', 'EquipmentController@updateEquipment');
    $router->delete('{id}', 'EquipmentController@deleteEquipment');
});

$router->group(['prefix' => 'api/rentals'], function () use ($router) {
    $router->get('', 'RentalsController@getStat');
    
});