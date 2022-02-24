<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\CategoriaController;
use App\Library\FuncionesGenerales;

class ProductoController extends Controller
{
    
    private $funcionesGenerales;
    public $modeloProducto;
    public $categoriaController;

    public function __construct() {
        $this->funcionesGenerales = new FuncionesGenerales();
        $this->modeloProducto = new Producto();
        $this->categoriaController = new CategoriaController();
    }


    // --- Función para obtener los datos de los productos.
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
            $categoriasRows = CategoriaController::obtenerDatosCategoriasSelect();
            return view("modulos.producto", ["productoRows" => $productoRows, "categoriasRows" => $categoriasRows]);
        }

    }


     // ---- Guardar nuevos productos.
     public function guardarProducto(Request $request) {

        $nombreProducto = trim($request->nombreProducto);
        $descripcionEspecificaProducto = trim($request->descripcionEspecificaProducto);
        $descripcionGeneralProducto = trim($request->descripcionGeneralProducto);
        $estadoProducto = trim($request->estadoProducto);
        $precioProducto = trim($request->precioProducto);
        $descuentoProducto = trim($request->descuentoProducto);
        $stockProducto = trim($request->stockProducto);
        $idCategoriaProducto = trim($request->categoriaProducto);
        $idProductoConsulta = trim($request->idProductoConsulta);

        // ---- Validaciones
        $arrayInputs = [
            'nombreProducto' => $nombreProducto,
            'descripcionEspecificaProducto' => $descripcionEspecificaProducto,
            'descripcionGeneralProducto' => $descripcionGeneralProducto,
            'precioProducto' => $precioProducto,
        ];

        $arrayValidations = [
            'nombreProducto' => 'required|min:3|max:50',
            'descripcionEspecificaProducto' => 'required|min:10|max:100',
            'descripcionGeneralProducto' => 'required|min:10|max:200',
            'precioProducto' => 'required|numeric'
        ];
        
        if ( !empty($descuentoProducto) ) {
            $arrayInputs['descuentoProducto'] = $descuentoProducto;
            $arrayValidations['descuentoProducto'] = 'numeric|digits_between:0,100';
        }


        /**
         * Otras validaciones
         */
        $arrayOtrasValidaciones = array();
        $hayCampoInvalido = false;
        if ( $precioProducto < 0 ) {
            $arrayOtrasValidaciones["propiedadesName"][] = "precioProducto";
            $hayCampoInvalido = true;
        }

        if ( !empty($stockProducto) && ( $stockProducto < 0 || !is_numeric($stockProducto) ) ) {
            $arrayOtrasValidaciones["propiedadesName"][] = "stockProducto";
            $hayCampoInvalido = true;
        }

        if ( $estadoProducto != "nvo" && $estadoProducto != "udo" ) {
            $arrayOtrasValidaciones["propiedadesName"][] = "estadoProducto";
            $hayCampoInvalido = true;
        }

        // --- Validar que la categoría seleccionada exista.
        $idCategoriaProductoConsulta = $this->categoriaController->obtenerDatosCategoriaValidacion($idCategoriaProducto);
        if ( empty($idCategoriaProductoConsulta) ) {
            $arrayOtrasValidaciones["propiedadesName"][] = "categoriaProducto";
            $hayCampoInvalido = true;
        }
        
        /**
         * Validaciones generales.
         */
        $validator = Validator::make($arrayInputs, $arrayValidations);

        $arrayEstadoRespuesta = array();

        if ( !$validator->passes() || $hayCampoInvalido ) {
            
            $arrayEstadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];

            /**
            * Otras validaciones
            */
            if ( $hayCampoInvalido ) {  
                $arrayOtrasValidaciones["textoValidacion"]["precioProducto"] = "El precio del producto debe se númerico mayor o igual a 0.";
                $arrayOtrasValidaciones["textoValidacion"]["stockProducto"] = "El stock para el producto debe ser numérico mayor o igual a 0.";
                $arrayOtrasValidaciones["textoValidacion"]["estadoProducto"] = "El estado del producto es incorrecto.";
                $arrayOtrasValidaciones["textoValidacion"]["categoriaProducto"] = "La categoría seleccionada es incorrecta.";
            }


            print_r( json_encode( array( $arrayEstadoRespuesta, $arrayOtrasValidaciones ) ) );

        } else {

            // --- Gurdar categoría.
            if ( empty($idAdministradorConsulta) ) {
               
                // ---- Guardado
                $estadoOperacion = Producto::guardarProducto($request);
                
                if ( $estadoOperacion ) {
                    print_r( json_encode( array( "estado" => 'registroActualizacionCorrecto', "mensaje" => "El producto fue registrado correctamente." ) ) );
                }else {
                    $arrayRespuestadoOperacion = array( "estado" => false, "mensaje" => "No fue posible registrar el producto, si el problema persiste contacte al administrador del sistema." );
                }

            } else {

                // --- Validación correo electrónico.
                // var_dump($idAdministrador, $idAdministradorConsulta, $email);
                // return;

                if ( !empty($idAdministradorCorreo) && $idAdministradorCorreo != $idAdministradorConsulta ) {
                    print_r( json_encode( array( "estado" => 'email', "mensaje" => "El correo electrónico que esta intentando actualizar no esta disponible." ) ) );
                    return;
                }

                // --- Actualización administrador.
                $estadoOperacion = Administrador::actualizarAdministrador($request);
                if ( $estadoOperacion ) {
                    $arrayRespuestadoOperacion = array( "estado" => 'registroActualizacionCorrecto', "mensaje" => "El administrador fue actualizado correctamente." );
                } else {
                    $arrayRespuestadoOperacion = array( "estado" => false, "mensaje" => "No fue posible actualizar el administrador, si el problema persiste contacte al administrador del sistema." );
                }

                print_r( json_encode( $arrayRespuestadoOperacion ) );

            }

        }

    }

}
