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

$router->post('/vuser/showUser',   'VuserController@showUser');
$router->get('/vuser/getUser',  'VuserController@getUser');


//Provinsi
$router->delete('/provinsi/delete/{id}',  'ProvinsiController@deleteProv');
$router->get('/provinsi/getProvinsi', 'ProvinsiController@getProv');
$router->post('/provinsi/storeProv',   'ProvinsiController@storeProv');
$router->post('/provinsi/updateProv',   'ProvinsiController@updateProv');

//Kabupaten
$router->post('/kabupaten/showKabupaten','KabupatenController@showKab');
$router->get('/kabupaten/getKabupaten','KabupatenController@getKab');
$router->post('/kabupaten/storeKab',   'KabupatenController@storeKab');
$router->post('/kabupaten/updateKab',   'KabupatenController@updateKab');
$router->delete('/kabupaten/delete/{id}',   'KabupatenController@deleteKab');

//Kecamatan
$router->get('/kecamatan/getKecamatan','KecamatanController@getKec');
$router->post('/kecamatan/storeKec',   'KecamatanController@storeKec');
$router->post('/kecamatan/showKec',   'KecamatanController@showKec');
$router->post('/kecamatan/updateKec',   'KecamatanController@updateKec');

//Kelurahan
$router->get('/kelurahan/getKelurahan','KelurahanController@getKel');
$router->post('/kelurahan/storeKel',   'KelurahanController@storeKel');
$router->post('/kelurahan/updateKel',   'KelurahanController@updateKel');
$router->delete('/kelurahan/deleteKel/{id}',   'KelurahanController@deleteKel');

