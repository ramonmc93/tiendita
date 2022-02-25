<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

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
    
    
    // --- Módulo administradores
    Route::get('/modulos/administradores', [AdministradorController::class, 'obtenerDatosAdministradores']);
    Route::post('/administradores/guardar-modificar', [AdministradorController::class, 'guardarAdministrador']);
    Route::post('/administradores/datos', [AdministradorController::class, 'obtenerDatosAdministradores']);
    Route::post('/administrador/datos', [AdministradorController::class, 'obtenerDatosAdministrador']);
    Route::post('/administrador/eliminar', [AdministradorController::class, 'eliminarAdministrador']);


    // --- Módulo categorías
    Route::get('/modulos/categorias', [CategoriaController::class, 'obtenerDatosCategorias']);
    Route::post('/categorias/guardar-modificar', [CategoriaController::class, 'guardarCategoria']);
    Route::post('/categorias/datos', [CategoriaController::class, 'obtenerDatosCategorias']);
    Route::post('/categoria/datos', [CategoriaController::class, 'obtenerDatosCategoria']);
    Route::post('/categoria/eliminar', [CategoriaController::class, 'eliminarCategoria']);
    

    // --- Módulo productos
    Route::get('/modulos/productos', [ProductoController::class, 'obtenerDatosProductos']);
    Route::post('/productos/guardar-modificar', [ProductoController::class, 'guardarProducto']);
    Route::post('/productos/datos', [ProductoController::class, 'obtenerDatosProductos']);
    Route::post('/producto/datos', [ProductoController::class, 'obtenerDatosProducto']);
    Route::post('/producto/eliminar', [ProductoController::class, 'eliminarProducto']);
    Route::post('/producto/select-categorias', [CategoriaController::class, 'obtenerDatosCategoriasSelect']);

});
