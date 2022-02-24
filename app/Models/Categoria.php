<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    use HasFactory;

    public static function guardarCategoria($request) {

        $nombreCategoria = $request->nombreCategoria;
        $descripcionCategoria = $request->descripcionCategoria;
        $fechaRegistro = date("Y-m-d H:i:s");
        $estado = "A";
        $idUsuarioRegistro = session('idAdministrador');

        $estadoOperacion = DB::table('categorias')->insert([
            'nombre' => $nombreCategoria,
            'descripcion' => $descripcionCategoria,
            'fecharegistro' => $fechaRegistro,
            'estado' => $estado,
            'idusuarioregistro' => $idUsuarioRegistro,
        ]);

        return $estadoOperacion;
        
    }

    public static function actualizarCategoria($request) {
        
        $nombreCategoria = $request->nombreCategoria;
        $descripcionCategoria = $request->descripcionCategoria;
        $idCategoriaConsulta = $request->idCategoriaConsulta;
        $fechaActualizacion = date("Y-m-d H:i:s");
        $estado = "A";
        $idUsuarioRegistro = session('idAdministrador');

        $estadoOperacion = DB::table('administradores')
        ->where('idadministradores', '=', $idAdministradorConsulta)
        ->update([
            'nombre' => $nombreCategoria,
            'descripcion' => $descripcionCategoria,
            'fechaactualizacion' => $fechaActualizacion,
            'estado' => $estado,
            'idusuarioregistro' => $idUsuarioRegistro,
        ]);

        return $estadoOperacion;
        
    }

}
