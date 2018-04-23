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
Route::group(['middleware' => 'cors', 'prefix' => 'api/v1'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
});

Route::group(['middleware' => 'cors', 'prefix' => 'api/v1'], function(){
    // Route::resource('clientes', 'ClientesController');
    Route::resource('usuarios', 'UsersController');
    Route::resource('areas', 'AreaController');
    Route::resource('carreras', 'CarreraController');
    Route::resource('departamentos', 'DepartamentoController');
    Route::resource('escalas', 'EscalaController');
    Route::resource('jerarquias', 'JerarquiaController');
    Route::resource('micronegocios', 'MicronegocioController');

    Route::get('usuario/login', 'UsersController@login');
    
});
