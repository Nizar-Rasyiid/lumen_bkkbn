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

//   Provinsi
  $router->get('/provinsi/getProvinsi', 'ProvinsiController@getProv');
  $router->post('/provinsi/storeProv',   'ProvinsiController@storeProv');
  $router->post('/provinsi/updateProv',   'ProvinsiController@updateProv');
  $router->delete('/provinsi/deleteProv/', 'ProvinsiController@deleteProv');

//  Kabupaten
  $router->post('/kabupaten/showKabupaten','KabupatenController@showKab');
  $router->get('/kabupaten/getKabupaten','KabupatenController@getKab');
  $router->post('/kabupaten/storeKab',   'KabupatenController@storeKab');
  $router->delete('/provinsi/deleteKab/{id}', 'ProvinsiController@deleteKab');
  $router->post('/kabupaten/updateKab',   'KabupatenController@updateKab');
  $router->get('/kabupaten/laporanKab', 'KabupatenController@laporanKab'); 

//  Kecamatann
  $router->post('/kecamatan/showKecamatan','KecamatanController@showKec');
  $router->get('/kecamatan/getKecamatan','KecamatanController@getKec');
  $router->post('/kecamatan/storeKec',   'KecamatanController@storeKec');
  $router->delete('/provinsi/deleteKec/{id}', 'ProvinsiController@deleteKec');
  $router->post('/kecamatan/updateKec',   'KecamatanController@updateKec');
  $router->get('/kecamatan/laporanKec', 'KecamatanController@laporanKec'); 

// Kelurahan
  $router->get('/kelurahan/getKelurahan','KelurahanController@getKel');
  $router->post('/kelurahan/storeKel',   'KelurahanController@storeKel');
  $router->post('/kelurahan/updateKel',   'KelurahanController@updateKel');
  $router->post('/kelurahan/showKel',   'KelurahanController@showKel');
  $router->delete('/kelurahan/deleteKel/{id}','KelurahanController@deleteKel');

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