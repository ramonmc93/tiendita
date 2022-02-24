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

// --- Administrador default.
Route::get('/admin-default', [AdministradorController::class, 'generarAdministradorDefault']);

Route::get('/admin/registrado', function() {
    return view("adminRegistradoCorrectamente");
});


/**
 * Login
 */
Route::post('/iniciar/sesion', [AdministradorController::class, 'loginValidacion']);

Route::get('/login', function(){
    return view("login");
})->middleware(['mostrar-modulo-productos']);



/**
 * Módulos administradores
 */

 // ---- Asignación de middleware.
Route::middleware(['existe-sesion-activa'])->group(function () {
    
    Route::get('/modulos/administradores', [AdministradorController::class, 'obtenerDatosAdministradores']);

    Route::get('/modulos/productos', function() {
        return view("modulos.producto");
    });

    // --- Módulo administradores
    Route::post('/administradores/datos', [AdministradorController::class, 'obtenerDatosAdministradores']);
    Route::post('/administrador/datos', [AdministradorController::class, 'obtenerDatosAdministrador']);

});

Route::post('/administradores/guardar-modificar', [AdministradorController::class, 'guardarAdministrador']);