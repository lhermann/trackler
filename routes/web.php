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

$router->get(
    '/hit/domains/{domain_id:[0-9]+}',
    ['uses' => 'HitController@updateOrCreate']
);

$router->group(['prefix' => 'api'], function () use ($router) {


    $router->get('domains',  ['uses' => 'DomainController@showAll']);
    $router->get('domains/{id}', ['uses' => 'DomainController@showOne']);
    $router->get('domains/{id}/events',  ['uses' => 'DomainController@showEvents']);
    $router->get('events/{id:[0-9]+}', ['uses' => 'EventController@showOne']);

    $router->get('events/{name:[A-Za-z]+}', ['uses' => 'HitController@showByEvent']);
    $router->get('identifiers/{id}', ['uses' => 'HitController@showByIdentifier']);

    $router->post('domains', ['uses' => 'DomainController@create']);
    $router->post('domains/{id}/events',  ['uses' => 'EventController@create']);

    $router->delete('domains/{id}', ['uses' => 'DomainController@delete']);
    $router->delete('events/{id}', ['uses' => 'EventController@delete']);

    $router->put('domains/{id}', ['uses' => 'DomainController@update']);
    $router->put('events/{id}', ['uses' => 'EventController@update']);

});
