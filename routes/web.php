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

$router->get('/', function () {return [];});

$router->group(['prefix' => '{lang}', 'middleware' => 'api'], function () use ($router) {

    $router->get('/', function () {return [];});

    $router->get('/musics', 'MusicController@index');
    $router->get('/musics/{id}', 'MusicController@show');
    $router->get('/music/{id}', 'MusicController@show');

    $router->get('/categories', 'CategoryController@index');

    $router->get('/categories_albums', 'CategoryAlbumController@index');

    $router->get('/albums', 'AlbumController@index');
    $router->get('/albums/create', 'AlbumController@create_table');
    $router->get('/albums/{id}', 'AlbumController@show');
    $router->get('/album/{id}', 'AlbumController@show');

    $router->get('/albums_musics', 'AlbumMusicController@index');
    
    $router->get('/lyrics', 'LyricController@index');

    $router->get('/hymnal', 'HymnalController@index');


});
