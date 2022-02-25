<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categoria;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Library\FuncionesGenerales;

class CategoriaController extends Controller
{
    
    private $funcionesGenerales;
    public $modeloCategoria;

    public function __construct() {
        $this->funcionesGenerales = new FuncionesGenerales();
        $this->modeloCategoria = new Categoria();
    }

    // --- Función para obtener los datos de las categorías.
    public function obtenerDatosCategorias( Request $request ) {
    
        $tipoPeticion = $request->tipoPeticion;

        $categoriasRows = DB::table('categorias')
        ->select('idcategorias', 'nombre')
        ->where('estado', '=', 'A')
        ->orderBy('idcategorias', 'desc')
        ->get();

        $categoriasRows = $this->funcionesGenerales->parseQuery($categoriasRows);

        if ( $tipoPeticion == 'post' ) {
            print_r(json_encode($categoriasRows));

        } else {
            return view("modulos.categoria-producto", ["categoriasRows" => $categoriasRows ]);
        }

    }


    // --- Función para obtener los datos de las categorías.
    public static function obtenerDatosCategoriasSelect($metodo = "post") {
    
        $categoriasRows = DB::table('categorias')
        ->select('idcategorias', 'nombre')
        ->where('estado', '=', 'A')
        ->orderBy('idcategorias', 'desc')
        ->get();

        $categoriasRows = FuncionesGenerales::parseQuery($categoriasRows);

        if ( $metodo == 'get' ) {
            return $categoriasRows;
        } else {
           return view('select-categorias', ["categoriasRows" => $categoriasRows]); 
        }

    }


    // --- Función para buscar la categoría seleccionada.
    public function obtenerDatosCategoriaSeleccionada() {
    
        $categoriasRows = DB::table('categorias')
        ->select('idcategorias', 'nombre')
        ->where('estado', '=', 'A')
        ->orderBy('idcategorias', 'desc')
        ->get();

        $categoriasRows = FuncionesGenerales::parseQuery($categoriasRows);
        return $categoriasRows;

    }


    // ---- Guardar nuevas categorías.
    public function guardarCategoria(Request $request) {

        $nombreCategoria = trim($request->nombreCategoria);
        $descripcionCategoria = trim($request->descripcionCategoria);
        $idCategoriaConsulta = trim($request->idCategoriaConsulta);

        // ---- Validaciones
        $arrayInputs = [
            'nombreCategoria' => $nombreCategoria,
            'descripcionCategoria' => $descripcionCategoria
        ];

        $arrayValidations = [
            'nombreCategoria' => 'required|string|min:5|max:25',
            'descripcionCategoria' => 'required|string|min:10|max:150',
        ];
        

        /**
         * Validaciones generales.
         */
        $validator = Validator::make($arrayInputs, $arrayValidations);

        $arrayEstadoRespuesta = array();
        
        if ( !$validator->passes() ) {
            
            $arrayEstadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];
            print_r( json_encode( $arrayEstadoRespuesta ) );

        } else {

            // --- Validar que el correo no exista.
            $categoriaRow = DB::table('categorias')
                ->select('nombre', 'idcategorias')
                ->where('nombre', '=', $nombreCategoria)
                ->where('estado', '=', 'A')
                ->get();
    
            $categoriaRow = $this->funcionesGenerales->parseQuery($categoriaRow);
            $nombreCategoriaConsulta = "";
            if ( !empty($categoriaRow) ) {
                $nombreCategoriaConsulta = $categoriaRow[0]["nombre"];
                $idCategoriaConsultaValidacion = $categoriaRow[0]["idcategorias"];
            }
            
            // --- Gurdar categoría.
            if ( empty($idCategoriaConsulta) ) {

                // --- Validación categoría.
                if ( !empty($nombreCategoriaConsulta) ) {
                    print_r( json_encode( array( "estado" => 'categoria', "mensaje" => "La categoría que esta intentando registrar ya existe." ) ) );
                    return;
                }
                
                // ---- Guardado
                $estadoOperacion = Categoria::guardarCategoria($request);
                if ( $estadoOperacion ) {
                    print_r( json_encode( array( "estado" => 'registroActualizacionCorrecto', "mensaje" => "La categoría fue registrada correctamente." ) ) );
                }else {
                    $arrayRespuestadoOperacion = array( "estado" => false, "mensaje" => "No fue posible registrar la categoría, si el problema persiste contacte al administrador del sistema." );
                }

            } else {

                if ( !empty($nombreCategoriaConsulta) && $idCategoriaConsultaValidacion != $idCategoriaConsulta ) {
                    print_r( json_encode( array( "estado" => 'email', "mensaje" => "La categoría que esta intentando registrar ya existe." ) ) );
                    return;
                }

                // --- Actualización de categoría.
                $estadoOperacion = Categoria::actualizarCategoria($request);
                if ( $estadoOperacion ) {
                    $arrayRespuestadoOperacion = array( "estado" => 'registroActualizacionCorrecto', "mensaje" => "La categoría fue actualizado correctamente." );
                } else {
                    $arrayRespuestadoOperacion = array( "estado" => false, "mensaje" => "No fue posible actualizar La categoría, si el problema persiste contacte al administrador del sistema." );
                }

                print_r( json_encode( $arrayRespuestadoOperacion ) );

            }

        }

    }


    // --- Función para obtener la información de la categoría seleccionada.
    public function obtenerDatosCategoria( Request $request ) {

        $idCategoria = $request->idCategoria;

        $categoriaRow = DB::table('categorias')
        ->select('idcategorias', 'nombre', 'descripcion')
        ->where('estado', '=', 'A')
        ->where('idcategorias', '=', $idCategoria)
        ->get();

        $categoriaRow = $this->funcionesGenerales->parseQuery($categoriaRow);
        print_r(json_encode($categoriaRow));

    }


    // --- Función para obtener la información de la categoría seleccionada.
    public function obtenerDatosCategoriaValidacion( $idCategoriaProducto ) {

        $categoriaRow = DB::table('categorias')
        ->select('idcategorias')
        ->where('estado', '=', 'A')
        ->where('idcategorias', '=', $idCategoriaProducto)
        ->get();

        $categoriaRow = $this->funcionesGenerales->parseQuery($categoriaRow);
        return $categoriaRow;

    }


    // --- Eliminar categoría
    public function eliminarCategoria(Request $request) {

        $idCategoria = $request->idCategoria;
        $idAdministradorSesion = session('idAdministrador');

        // ---- Validaciones
        $arrayInputs = [
            'idCategoria' => $idCategoria
        ];

        $arrayValidations = [
            'idCategoria' => 'required|gt:0'
        ];

        $validator = Validator::make($arrayInputs, $arrayValidations);
        $arrayEstadoRespuesta = array();
        if ( !$validator->passes() ) {
            $arrayEstadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];
            print_r(json_encode($arrayEstadoRespuesta));
            return;
        }
        
        /**
        * Otras validaciones
        */
        // ---- Validar que la categoría exista.
        $categoriasRows = DB::table('categorias')
        ->select('idcategorias')
        ->where('idcategorias', '=', $idCategoria)
        ->where('estado', '=', 'A')
        ->get();

        $idCategoriaConsulta = "";
        $idCategoria = $this->funcionesGenerales->parseQuery($categoriasRows);
        if ( !empty($idCategoria[0]["idcategorias"]) ) {
            $idCategoriaConsulta = $idCategoria[0]["idcategorias"];
        }

        if ( empty($idCategoriaConsulta) ) {
            $arrayTextoValidaciones["idCategoria"][0] = "La categoría que esta intentando eliminar no existe.";
            $arrayEstadoRespuesta = ["estado" => 'validaciones', "validaciones" => $arrayTextoValidaciones];
        }
        
        if ( !empty($arrayEstadoRespuesta) ) {
            print_r(json_encode($arrayEstadoRespuesta));
            return;
        }

        // --- Se elimina
        $estadoEliminacion = Categoria::eliminarCategoria($idCategoria);

        if ( $estadoEliminacion ) {
            $arrayEstadoRespuesta = ["estado" => true, "mensaje" => "Categoría eliminada correctamente."];
        } else {
            $arrayEstadoRespuesta = ["estado" => false, "mensaje" => "No se pudo eliminar la categoría, si el problema persiste contacte al administrador del sistema."];
        }

        print_r(json_encode($arrayEstadoRespuesta ));

    }

}
