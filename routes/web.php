<?php

/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/get', 'FinderController@search');
$router->get('/list', 'FinderController@index');
$router->delete('/remove/{id}', 'FinderController@remove');



