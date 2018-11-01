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

// $router->get('/key', function () {
// 	return str_random(10);
// });

$router->post('/register', 'AuthController@register');
$router->post('/api/importgurus', 'GuruController@import');
$router->get('/api/allGurus', 'GuruController@getGurus');
$router->post('/login', 'AuthController@login');

$router->get('/user/{id}', 'UserController@show');
$router->get('/users', 'UserController@showAll');
$router->get('/api/menu/{role}', 'MenuController@getMenu');
$router->get('/api/profile/{id}/{role}', 'ProfileController@getProfile');
$router->post('/api/jadwal', 'JadwalController@addNew');
$router->get('/api/jadwals', 'JadwalController@getAll');

// Route Periode
$router->post('/periode', 'PengaturanController@addPeriode');
// Route Guru
// $router->get('/api/gurus', 'Guru')

// Route Praktikan
$router->get('/api/allsiswas', 'PraktikanController@getSiswas');
$router->post('/api/importsiswas', 'PraktikanController@import');
$router->delete('/api/siswa/{uname}', 'PraktikanController@delete');
$router->put('/api/siswa', 'PraktikanController@update');
$router->get('/api/siswas', 'PraktikanController@getByPeriode');
$router->get('/api/calon', 'PraktikanController@getCalons');
// $router->post('/api/calon', 'PraktikanController@regOne');

// Route Dudi
$router->post('/api/importdudis', 'DudiController@import');
$router->post('/api/dudi', 'DudiController@add');
$router->get('/api/dudis', 'DudiController@getDudis');
$router->get('/api/getlastdudi', 'DudiController@getLast');
$router->delete('/api/dudi/{id}', 'DudiController@delete');
$router->put('/api/dudi', 'DudiController@update');


// Route Penepmatan Prakerlap
$router->get('/api/lastpkl', 'PrakerlapController@getLast');
$router->get('/api/jmlterdaftar', 'PrakerlapController@countRegd');
$router->get('/api/regSiswas', 'PrakerlapController@regdSiswa');
$router->get('/api/notscored', 'PrakerlapController@notScored');
$router->put('/api/prakerlap', 'PrakerlapController@mutasi');
$router->delete('/api/prakerlap/{id}/{_siswa}', 'PrakerlapController@delOne');
$router->post('/api/newpkl', 'PrakerlapController@regNew');

// Route Akses Pembimbing
$router->get('/api/mypkl', 'PrakerlapController@getMyPkl');

// Route Pasca
$router->get('/api/headernilai', 'NilaiController@getHeaderNilai');
$router->post('/api/newnilai', 'NilaiController@addNew');
$router->get('/api/scored', 'NilaiController@scored');
$router->put('/api/nilai/{nis}', 'NilaiController@updNilai');
$router->delete('/api/nilai', 'NilaiController@deleteOne');
$router->get('/api/lastsert', 'SertifikatController@getLast');
$router->post('/api/importnilais', 'NilaiController@import');

// Route Pra Prakerlap 
// http://localhost:8000/api/updSyarat?periode=11.2
$router->get('/api/admcalons', 'PraprakerlapController@getSyarats');
$router->put('/api/updSyarat', 'PraprakerlapController@updSyarat');
$router->get('/api/pembinaan', 'PraprakerlapController@getPembinaan');
$router->post('/api/pembinaan', 'PraprakerlapController@addPembinaan');

// Route Umum
$router->get('/umum/kelas', 'UmumController@getKelases');
$router->get('/umum/periode', 'PeriodeController@getAll');
$router->delete('/umum/periode/{id}', 'PeriodeController@deleteOne');
// $router->post('/register', 'RegisterController@regMe');

