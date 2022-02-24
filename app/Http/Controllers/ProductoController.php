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
    public function obtenerDatosAdministradores( Request $request ) {
        
        $tipoPeticion = $request->tipoPeticion;

        $administradorRows = DB::table('administradores')
        ->select('idadministradores', 'nombre', 'apellidopaterno', 'apellidomaterno', 'tipousuario', 'email')
        ->where('estado', '=', 'A')
        ->orderBy('idadministradores', 'desc')
        ->get();

        $administradorRows = $this->funcionesGenerales->parseQuery($administradorRows);

        if ( $tipoPeticion == 'post' ) {
            print_r(json_encode($administradorRows));

        } else {
            return view("modulos.administrador", ["administradorRows" => $administradorRows ]);
        }

    }

}
