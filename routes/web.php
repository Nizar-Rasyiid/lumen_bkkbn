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


//User Access Survey
$router->get('/user-access-survey/get','UserAccessSurveyController@getUAS');
$router->post('/user-access-survey/showUAS','UserAccessSurveyController@showUAS');
$router->post('/user-access-survey/store','UserAccessSurveyController@storeUAS');
$router->post('/user-access-survey/update','UserAccessSurveyController@updateUAS');
$router->post('/user-access-survey/delete','UserAccessSurveyController@deleteUAS');

// V user
  $router->post('/vuser/showUser',   'VuserController@showUser');
  $router->get('/vuser/getUser',  'VuserController@getUser');
  $router->post('/vuser/storeUser',  'VuserController@storeUser');
  $router->post('/vuser/updateUser',  'VuserController@updateUser');
  $router->post('/vuser/ubahPassword',  'VuserController@ubahPassword');
  $router->post('/vuser/deleteUser',  'VuserController@deleteUser');

//   Provinsi
  $router->get('/provinsi/getProvinsi', 'ProvinsiController@getProv');
  $router->post('/provinsi/storeProv',   'ProvinsiController@storeProv');
  $router->post('/provinsi/updateProv',   'ProvinsiController@updateProv');
  $router->post('/provinsi/deleteProv', 'ProvinsiController@deleteProv');
  $router->get('/provinsi/laporanProv',   'ProvinsiController@laporanProv');
  $router->post('/provinsi/laporanPerProv',   'ProvinsiController@laporanPerProv');

//  Kabupaten
  $router->post('/kabupaten/showKabupaten','KabupatenController@showKab');
  $router->post('/kabupaten/showsKabupaten','KabupatenController@showKabs');
  $router->get('/kabupaten/getKabupaten','KabupatenController@getKab');
  $router->post('/kabupaten/storeKab',   'KabupatenController@storeKab');
  $router->post('/kabupaten/deleteKab', 'KabupatenController@deleteKab');
  $router->post('/kabupaten/updateKab',   'KabupatenController@updateKab');
  $router->get('/kabupaten/laporanKab', 'KabupatenController@laporanKab'); 
  $router->post('/kabupaten/show-per-kab', 'KabupatenController@showPerKab'); 

//  Kecamatann
  $router->post('/kecamatan/showKecamatan','KecamatanController@showKec');
  $router->post('/kecamatan/showKecamatans','KecamatanController@showKecs');
  $router->get('/kecamatan/getKecamatan','KecamatanController@getKec');
  $router->post('/kecamatan/storeKec',   'KecamatanController@storeKec');
  $router->post('/kecamatan/deleteKec', 'KecamatanController@deleteKec');
  $router->post('/kecamatan/updateKec',   'KecamatanController@updateKec');
  $router->get('/kecamatan/laporanKec', 'KecamatanController@laporanKec'); 
  $router->post('/kecamatan/show-per-kec', 'KecamatanController@ShowPerKec'); 

// Kelurahan
  $router->get('/kelurahan/getKelurahan','KelurahanController@getKel');
  $router->post('/kelurahan/storeKel',   'KelurahanController@storeKel');
  $router->post('/kelurahan/updateKel',   'KelurahanController@updateKel');
  $router->post('/kelurahan/showKel',   'KelurahanController@showKel');
  $router->post('/kelurahan/deleteKel','KelurahanController@deleteKel');
  $router->post('/kelurahan/laporanKel','KelurahanController@laporanKel');
  $router->post('/kelurahan/laporanPerKel','kelurahanController@laporanPerKel');

//Rt
$router->post('/rt/showRt','RtController@showRt');
$router->get('/rt/getRt', 'RtController@getRt');
$router->post('/rt/storeRt',   'RtController@storeRt');
$router->post('/rt/updateRt',   'RtController@updateRt');
$router->post('/rt/deleteRt',   'RtController@deleteRt');
//$router->delete('/rt/deleteRt/{id}',   'rtController@deleteRt');

//Rw
$router->post('/rw/showRw','RwController@showRw');
$router->get('/rw/getRw', 'RwController@getRw');
$router->post('/rw/storeRw',   'RwController@storeRw');
$router->post('/rw/updateRw',   'RwController@updateRw');
$router->post('/rw/deleteRw',   'RwController@deleteRw');
//$router->delete('/rt/deleteRt/{id}',   'rtController@deleteRt');
//Setting
$router->post('/setting/showSetting','SettingController@showSetting');
$router->get('/setting/getSetting', 'SettingController@getSetting');
$router->post('/setting/storeSetting',   'SettingController@storeSetting');
$router->post('/setting/updateSetting',   'SettingController@updateSetting');
$router->post('/setting/deleteSetting',   'SettingController@deleteSetting');

//Kelompok Data
$router->post('/kelompok-data/showKelompokData','KelompokDataController@showKelompokData');
$router->get('/kelompok-data/getKelompokData', 'KelompokDataController@getKelompokData');
$router->post('/kelompok-data/storeKelompokData',   'KelompokDataController@storeKelompokData');
$router->post('/kelompok-data/updateKelompokData','KelompokDataController@updateKelompokData');
$router->post('/kelompok-data/deleteKelompokData',   'KelompokDataController@deleteKelompokData');

//TargetKk
$router->post('/target-kk/showTargetKk','TargetKkController@showTargetKk');
$router->post('/target-kk/showTargetKkPerProv','TargetKkController@showTargetKkPerProv');
$router->get('/target-kk/getTargetKk', 'TargetKkController@getTargetKk');
$router->post('/target-kk/storeTargetKk',   'TargetKkController@storeTargetKk');
$router->post('/target-kk/updateTargetKk',   'TargetKkController@updateTargetKk');
$router->post('/target-kk/deleteTargetKk',   'TargetKkController@deleteTargetKk');

//LaporanSensus
$router->post('/laporan-sensus/indonesia','LaporanSensusController@showLaporanSensusID');
$router->post('/laporan-sensus/perprov','LaporanSensusController@showLaporanSensusPerProv');
$router->post('/laporan-sensus/perkab','LaporanSensusController@showLaporanSensusPerKab');
$router->post('/laporan-sensus/perkec','LaporanSensusController@showLaporanSensusPerKec');
$router->post('/laporan-sensus/perkel','LaporanSensusController@showLaporanSensusPerKel');

//Form KK
$router->post('/form-kk/showFormKK','FormKKController@showFormKK');
$router->get('/form-kk/getFormKK', 'FormKKController@getFormKK');
$router->post('/form-kk/storeFormKK','FormKKController@storeFormKK');

//Anggota KK
$router->get('/anggota-kk/getAnggotaKK','AnggotaKKController@getAnggotaKK');
$router->post('/anggota-kk/updateAnggotaKK','AnggotaKKController@updateAnggotaKK');
$router->post('/anggota-kk/showAnggotaKK','AnggotaKKController@showAnggotaKK');
$router->post('/anggota-kk/storeAnggotaKK',   'AnggotaKKController@storeAnggotaKK');


//Email
$router->get('/mail','MailController@mail');

//FormKK
$router->post('/form-kk/showFormKK', 'FormKKController@showFormKK');
$router->get('/form-kk/getFormKK', 'FormKKController@getFormKK');
$router->get('/form-kk/getIdKK','FormKKController@getIdKK');
$router->post('/form-kk/storeFormKK', 'FormKKController@storeFormKK');
$router->post('/form-kk/updateFormKK', 'FormKKController@updateFormKK');
$router->post('/form-kk/deleteFormKK', 'FormKKController@deleteFormKK');