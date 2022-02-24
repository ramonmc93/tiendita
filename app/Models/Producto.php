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

    public static function actualizarProducto($request) {
        
        $estadoActualizacion = false;

        $nombreProducto = $request->nombreProducto;
        $descripcionEspecificaProducto = $request->descripcionEspecificaProducto;
        $descripcionGeneralProducto = $request->descripcionGeneralProducto;
        $estadoProducto = $request->estadoProducto;
        $precioProducto = $request->precioProducto;
        $descuentoProducto = $request->descuentoProducto;
        $stockProducto = $request->stockProducto;
        $idCategoriaProducto = $request->categoriaProducto;
        $idProductoConsulta = $request->idProductoConsulta;
        $fechaActualizacion = date("Y-m-d H:i:s");
        $estado = "A";
        $idUsuarioRegistro = session('idAdministrador');
        
        
        $arrayCamposActualizar = [
            'nombre' => $nombreProducto,
            'descripcionespecifica' => $descripcionEspecificaProducto,
            'descripciongeneral' => $descripcionGeneralProducto,
            'estadoproducto' => $estadoProducto,
            'precio' => $precioProducto,
            'descuento' => $descuentoProducto,
            'stock' => $stockProducto,
            'fechaactualizacion' => $fechaActualizacion,
            'estado' => $estado,
            'idusuarioregistro' => $idUsuarioRegistro,
        ];

        $estadoOperacion = DB::table('productos')
        ->where('idproductos', '=', $idProductoConsulta)
        ->where('estado', '=', 'A')
        ->update($arrayCamposActualizar);
        
        // --- Actualización en tabla productos_categorias
        if ( $estadoOperacion ) {

            $estadoOperacion = DB::table('productos_categorias')
            ->where('idproductosfk', '=', $idProductoConsulta)
            ->where('estado', '=', 'A')
            ->update([
                'idcategoriasfk' => $idCategoriaProducto,
                'fechaactualizacion' => $fechaActualizacion,
                'estado' => $estado,
                'idusuarioregistro' => $idUsuarioRegistro,
            ]);
            
            if ( $estadoOperacion ) {
                $estadoActualizacion = true;
            } else {
                $estadoActualizacion = false;
            }


        } else {
            $estadoActualizacion = false;
        }

        return $estadoActualizacion;
        
    }

    // --- Función para eliminar el producto seleccionado.
    public static function eliminarProducto($idProducto) {

        $fechaActualizacion = date("Y-m-d H:i:s");
        $estado = "E";
        $idUsuarioElimino = session('idAdministrador');
        
        $estadoOperacion = DB::table('productos')
        ->join('productos_categorias', 'productos.idproductos', '=', 'productos_categorias.idproductosfk')
        ->where('productos.idproductos', '=', $idProducto)
        ->update([
            'productos.fechaactualizacion' => $fechaActualizacion,
            'productos.estado' => $estado,
            'productos.idusuarioelimino' => $idUsuarioElimino,
            'productos_categorias.fechaactualizacion' => $fechaActualizacion,
            'productos_categorias.estado' => $estado,
            'productos_categorias.idusuarioelimino' => $idUsuarioElimino,
        ]);

        return $estadoOperacion;

    }

}
