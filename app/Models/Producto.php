<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    use HasFactory;

    public static function guardarProducto($request) {

        $nombreProducto = $request->nombreProducto;
        $descripcionEspecificaProducto = $request->descripcionEspecificaProducto;
        $descripcionGeneralProducto = $request->descripcionGeneralProducto;
        $estadoProducto = $request->estadoProducto;
        $precioProducto = $request->precioProducto;
        $descuentoProducto = $request->descuentoProducto;
        $stockProducto = $request->stockProducto;
        $idCategoriaProducto = $request->categoriaProducto;
        $idProductoConsulta = $request->idProductoConsulta;
        $fechaRegistro = date("Y-m-d H:i:s");
        $estado = "A";
        $idUsuarioRegistro = session('idAdministrador');

        $idProductoRegistrado = DB::table('productos')->insertGetId([
            'idadministradoresfk' => $idUsuarioRegistro,
            'nombre' => $nombreProducto,
            'descripcionespecifica' => $descripcionEspecificaProducto,
            'descripciongeneral' => $descripcionGeneralProducto,
            'estadoproducto' => $estadoProducto,
            'precio' => $precioProducto,
            'descuento' => $descuentoProducto,
            'stock' => $stockProducto,
            'fecharegistro' => $fechaRegistro,
            'estado' => $estado,
            'idusuarioregistro' => $idUsuarioRegistro,
        ]);
        
        // --- Insercíón en tabla productos_categorias
        if ( !empty($idProductoRegistrado) && $idProductoRegistrado > 0 ) {

            $estadoOperacion = DB::table('productos_categorias')->insert([
                'idproductosfk' => $idProductoRegistrado,
                'idcategoriasfk' => $idCategoriaProducto,
                'fecharegistro' => $fechaRegistro,
                'estado' => $estado,
                'idusuarioregistro' => $idUsuarioRegistro,
            ]);
    
            return $estadoOperacion;

        } else {
            return false;
        }
        
    }

}
