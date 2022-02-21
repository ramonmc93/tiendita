<?php

use Illuminate\Support\Facades\Route;
use App\Models\Administrador;

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
    return view('index');
});

Route::get('/template', function () {
    return view('layouts/template');
});

// ---- Módulo administradores
Route::get('/modulos/administradores', function(){
    return view("modulos.administrador");
});

Route::post('/administradores/guardar', [Administrador::class], 'guardarAdministrador');