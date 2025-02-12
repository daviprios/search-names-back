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

use App\Http\Controllers\NameController;

$router->get('/show', 'NameController@getNames');
$router->post('/create', 'NameController@createName');
$router->patch('/update', 'NameController@updateName');
$router->delete('/delete', 'NameController@deleteName');
