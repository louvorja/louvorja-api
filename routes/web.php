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

$router->get('/', function () {
    return [];
});

$router->group(['prefix' => 'auth', 'middleware' => 'api'], function () use ($router) {
    $router->post('/login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/refresh-token', 'AuthController@refreshToken');
        $router->post('/refresh_token', 'AuthController@refreshToken');
        $router->get('/me', 'AuthController@me');
        $router->post('/logout', 'AuthController@logout');
        $router->post('/change-password',  'AuthController@changePassword');
    });
});

/*
middleware para senha confirmada!!!!
$router->group(['middleware' => 'confirmed_pwd'], function () use ($router) {
*/

$router->group(['prefix' => 'tasks', 'middleware' => 'api'], function () use ($router) {
    $router->get('/', 'TaskController@index');
    $router->get('/refresh_configs', 'TaskController@refresh_configs');
    $router->get('/export_database', 'TaskController@export_database');
    $router->get('/refresh_files_size', 'TaskController@refresh_files_size');
    $router->get('/import_slides', 'TaskController@import_slides');
});

$router->group(['prefix' => '{lang}', 'middleware' => 'api'], function () use ($router) {

    $router->get('/', function () {
        return [];
    });

    $router->get('/languages', 'LanguageController@index');

    $router->get('/config', 'ConfigController@index');
    $router->get('/configs', 'ConfigController@index');

    $router->get('/musics', 'MusicController@index');
    $router->get('/musics/{id}', 'MusicController@show');
    $router->get('/music/{id}', 'MusicController@show');

    $router->get('/categories', 'CategoryController@index');

    $router->get('/categories_albums', 'CategoryAlbumController@index');

    $router->get('/albums', 'AlbumController@index');
    $router->get('/albums/{id}', 'AlbumController@show');
    $router->get('/album/{id}', 'AlbumController@show');

    $router->get('/albums_musics', 'AlbumMusicController@index');

    $router->get('/lyrics', 'LyricController@index');

    $router->get('/hymnal', 'HymnalController@index');

    $router->get('/files', 'FileController@index');
});
