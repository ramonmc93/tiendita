<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;

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


/**
 * Template e index.
 */
Route::get('/', function () {
    return view('index');
});

Route::get('/template', function () {
    return view('layouts/template');
});

Route::get('/admin/registrado', function() {
    return view("adminRegistradoCorrectamente");
});


/**
 * Login
 */
Route::get('/login', function(){
    return view("login");
});

Route::post('/iniciar/sesion', [AdministradorController::class, 'loginValidacion']);


/**
 * Módulos administradores
 */

// --- Administrador default.
Route::get('/admin-default', [AdministradorController::class, 'generarAdministradorDefault']);

Route::get('/modulos/administradores', function() {
    return view("modulos.administrador");
});

Route::post('/administradores/guardar-modificar', [AdministradorController::class, 'guardarAdministrador']);