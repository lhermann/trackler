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
    '/hit/domains/{domain_id:[0-9]+}[/labels/{label:[A-Za-z]+}]',
    ['uses' => 'HitController@updateOrCreate']
);

$router->group(['prefix' => 'api'], function () use ($router) {


    $router->get('domains',  ['uses' => 'DomainController@showAll']);
    $router->get('domains/{id}', ['uses' => 'DomainController@showOne']);
    $router->get('domains/{id}/labels',  ['uses' => 'DomainController@showLabels']);
    $router->get('labels/{id:[0-9]+}', ['uses' => 'LabelController@showOneById']);
    $router->get('labels/{name:[A-Za-z]+}', ['uses' => 'LabelController@showOneByName']);

    $router->post('domains', ['uses' => 'DomainController@create']);
    $router->post('domains/{id}/labels',  ['uses' => 'LabelController@create']);

    $router->delete('domains/{id}', ['uses' => 'DomainController@delete']);
    $router->delete('labels/{id}', ['uses' => 'LabelController@delete']);

    $router->put('domains/{id}', ['uses' => 'DomainController@update']);
    $router->put('labels/{id}', ['uses' => 'LabelController@update']);

});
