<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Library\FuncionesGenerales;

class ProductoController extends Controller
{
    
    private $funcionesGenerales;
    public $modeloProducto;

    public function __construct() {
        $this->funcionesGenerales = new FuncionesGenerales();
        $this->modeloProducto = new Producto();
    }


    // --- Función para obtener los datos de los administradores.
    public function obtenerDatosProductos( Request $request ) {
        
        $tipoPeticion = $request->tipoPeticion;

        $productoRows = DB::table('productos')
        ->select('idproductos', 'nombre', 'precio', 'descuento', 'stock')
        ->where('estado', '=', 'A')
        ->orderBy('idproductos', 'desc')
        ->get();

        $productoRows = $this->funcionesGenerales->parseQuery($productoRows);

        if ( $tipoPeticion == 'post' ) {
            print_r(json_encode($productoRows));

        } else {
            return view("modulos.producto", ["productoRows" => $productoRows]);
        }

    }

}
