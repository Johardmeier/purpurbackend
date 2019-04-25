<?php

use Illuminate\Http\Response;
use App\User;

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
    return 'root route';
});


$router->get('/admin', function () use ($router) {
    return view('admin');
});

$router->get('/kasse', function () use ($router) {
    return view('kasse');
});

$router->group(['prefix'=>'auth'], function() use ($router) {
    $router->post('login',['uses'=> 'AuthController@authenticate']);
});

$router->group(
    ['prefix'=>'api','middleware'=>'auth'],
    function() use ($router){

        $router->get('/', function () use ($router) {
            return response()->json(Auth::user());
        });

        $router->get('/models', ['uses' => 'ApiController@getModel']);
        $router->post('/models', ['uses' => 'ApiController@setModel']);

        $router->get('/users', ['uses' => 'ApiController@getUsers']);
        $router->post('/users/roles', ['uses' => 'ApiController@updateRoles']);

        $router->get('/options', ['uses' => 'ApiController@getOptions']);

        $router->get('/{any:.*}', function ($any) use ($router) {
            return 'api - not found';
        });
});

$router->get('/seed', ['middleware'=>'auth','uses' => 'SeedController@DatabaseSeeder']);

$router->get('/{any:.*}', function ($any) use ($router) {
    return 'all the others';
});
