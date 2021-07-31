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

// Provinsi
$router->get('/provinsi/getProvinsi', 'ProvinsiController@getProv');
$router->post('/provinsi/storeProv',   'ProvinsiController@storeProv');
$router->post('/provinsi/updateProv',   'ProvinsiController@updateProv');
$router->delete('/provinsi/deleteProv/{id}', 'ProvinsiController@deleteProv');


//Kabupaten
$router->get('/kabupaten/getKabupaten','KabupatenController@getKab');
$router->post('/kabupaten/storeKab',   'KabupatenController@storeKab');
$router->post('/kabupaten/updateKab',   'KabupatenController@updateKab');

//Kecamatan
$router->get('/kecamatan/getKecamatan','KecamatanController@getKec');
<<<<<<< HEAD
$router->post('/kecamatan/storeKec',   'KecamatanController@storeKec');
$router->post('/kecamatan/updateKec',   'KecamatanController@updateKec');

//Kelurahan
$router->get('/kelurahan/getKelurahan','KelurahanController@getKel');
$router->post('/kelurahan/storeKel',   'KelurahanController@storeKel');
$router->post('/kelurahan/updateKel',   'KelurahanController@updateKel');
$router->delete('/kelurahan/deleteKel/{id}',   'KelurahanController@deleteKel');
=======
$router->post('/kecamatan/storeKec','KecamatanController@storeKec');
$router->post('/kecamatan/updateProv','KecamatanController@updateKec');
$router->delete('/kecamatan/deleteKec','KecamatanController@deleteKec');
>>>>>>> cafea2949e97fa665b6cfd1a80d1d19dcd912595
