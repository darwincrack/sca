<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'PersonalController@index');
Route::get('/home', 'HomeController@index');


Route::get('personal', 'PersonalController@index');
Route::get('personal/data', 'PersonalController@anyData');
Route::get('personal/add', 'PersonalController@add');
Route::post('personal/add', 'PersonalController@store');
Route::get('personal/editar/{id}', 'PersonalController@editar')->where('id','[0-9]+');
Route::post('personal/editar/', 'PersonalController@store_editar');
Route::get('personal/subgrupo/{id_grupo}', 'PersonalController@select_subgrupo');





Route::get('horario/{id}', 'HorarioController@index')->where('id','[0-9]+');
Route::post('horario/add', 'HorarioController@store');
Route::post('horario/editar/', 'HorarioController@store_editar');



Route::get('grupo', 'GrupoController@index');
Route::get('grupo/data', 'GrupoController@anyData');
Route::get('grupo/add', 'GrupoController@add');
Route::post('grupo/add', 'GrupoController@store');
Route::get('grupo/editar/{id}', 'GrupoController@editar')->where('id','[0-9]+');
Route::post('grupo/editar/', 'GrupoController@store_editar');


Route::get('subgrupo', 'SubGrupoController@index');
Route::get('subgrupo/data', 'SubGrupoController@anyData');
Route::get('subgrupo/add', 'SubGrupoController@add');
Route::post('subgrupo/add', 'SubGrupoController@store');
Route::get('subgrupo/editar/{id}', 'SubGrupoController@editar')->where('id','[0-9]+');
Route::post('subgrupo/editar/', 'SubGrupoController@store_editar');


Route::get('configuracion', 'ConfiguracionController@index');
Route::post('configuracion', 'ConfiguracionController@store_editar');


Route::get('configuracion/diasferiados', 'ConfiguracionController@diasferiados');
Route::get('configuracion/diasferiados/data', 'ConfiguracionController@anyData');
Route::get('configuracion/diasferiados/add', 'ConfiguracionController@add_diasferiados');
Route::post('configuracion/diasferiados/add', 'ConfiguracionController@store_diasferiados');
Route::get('configuracion/diasferiados/editar/{id}', 'ConfiguracionController@editar_diasferiados')->where('id','[0-9]+');
Route::post('configuracion/diasferiados/editar/', 'ConfiguracionController@store_editar_diasferiados');

Route::get('configuracion/diasferiados/delete/{id}', 'ConfiguracionController@delete_diasferiados')->where('id','[0-9]+');

