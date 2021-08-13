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
$router->get('/provinsi/laporanProv',   'ProvinsiController@laporanProv');
$router->post('/provinsi/laporanPerProv',   'ProvinsiController@laporanPerProv');

//Kabupaten
$router->post('/kabupaten/showKabupaten','KabupatenController@showKab');
$router->post('/kabupaten/showLaporanKab','KabupatenController@showKab2');
$router->get('/kabupaten/getKabupaten','KabupatenController@getKab');
$router->post('/kabupaten/storeKab',   'KabupatenController@storeKab');
$router->post('/kabupaten/updateKab',   'KabupatenController@updateKab');
$router->delete('/kabupaten/delete/{id}',   'KabupatenController@deleteKab');

//Kecamatan
$router->get('/kecamatan/getKecamatan','KecamatanController@getKec');
$router->post('/kecamatan/storeKec',   'KecamatanController@storeKec');
$router->post('/kecamatan/showKec',   'KecamatanController@showKec');
$router->post('/kecamatan/updateKec',   'KecamatanController@updateKec');
$router->delete('/kecamatan/deleteKec/{id}',   'KecamatanController@deleteKec');

//Kelurahan
$router->get('/kelurahan/getKelurahan','KelurahanController@getKel');
$router->post('/kelurahan/storeKel',   'KelurahanController@storeKel');
$router->post('/kelurahan/showKel',   'KelurahanController@showKel');
$router->post('/kelurahan/updateKel',   'KelurahanController@updateKel');
$router->delete('/kelurahan/deleteKel/{id}',   'KelurahanController@deleteKel');

//Rt
$router->post('/rt/showRt','RtController@showRt');
$router->get('/rt/getRt', 'RtController@getRt');
$router->post('/rt/storeRt',   'RtController@storeRt');
$router->post('/rt/updateRt',   'RtController@updateRt');
//$router->delete('/rt/deleteRt/{id}',   'rtController@deleteRt');

//Rw
$router->post('/rw/showRw','RwController@showRw');
$router->get('/rw/getRw', 'RwController@getRw');
$router->post('/rw/storeRw',   'RwController@storeRw');
$router->post('/rw/updateRw',   'RwController@updateRw');
//$router->delete('/rt/deleteRt/{id}',   'rtController@deleteRt');

