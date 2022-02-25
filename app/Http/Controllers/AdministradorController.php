<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Administrador;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Library\FuncionesGenerales;

class AdministradorController extends Controller
{

    private $funcionesGenerales;
    public $modeloAdministrador;

    public function __construct() {
        $this->funcionesGenerales = new FuncionesGenerales();
        $this->modeloAdministrador = new Administrador();
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
            return view("modulos.administrador", ["administradorRows" => $administradorRows]);
        }

    }


    // ---- Guardar nuevos administradores.
    public function guardarAdministrador(Request $request) {

        $nombre = trim($request->nombre);
        $apellidoPaterno = trim($request->apellidoPaterno);
        $apellidoMaterno = trim($request->apellidoMaterno);
        $telCelular = trim($request->telCelular);
        $telCasa = trim($request->telCasa);
        $tipoUsuario = trim($request->tipoUsuario);
        $email = trim($request->email);
        $fechaNacimiento = trim($request->fechaNacimiento);
        $direccion = trim($request->direccion);
        $codigoPostal = trim($request->codigoPostal);
        $idAdministradorConsulta = trim($request->idAdministradorConsulta);
        $nombreUsuario = trim($request->nombreUsuario);
        $passwordAdministrador = trim($request->passwordAdministrador);

        if ( empty($apellidoMaterno) ) {
            $request->apellidoMaterno = "";    
        }

        // ---- Validaciones
        $arrayInputs = [
            'nombre' => $nombre,
            'apellidoPaterno' => $apellidoPaterno,
            'telCelular' => $telCelular,
            'email' => $email,
            'fechaNacimiento' => $fechaNacimiento,
            'direccion' => $direccion,
            'codigoPostal' => $codigoPostal,
            'nombreUsuario' => $nombreUsuario
        ];

        $arrayValidations = [
            'nombre' => 'required|min:3|max:25',
            'apellidoPaterno' => 'required|min:3|max:25',
            'telCelular' => 'required|numeric|digits_between:10,10',
            'email' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'direccion' => 'required|min:15',
            'codigoPostal' => 'required|numeric|digits_between:5,5',
            'nombreUsuario' => 'required|min:5|max:25'
        ];
        
        if ( empty($idAdministradorConsulta) || !empty($passwordAdministrador) ) {
            $arrayInputs["passwordAdministrador"] = $passwordAdministrador;
            $arrayValidations["passwordAdministrador"] = 'required|min:5';
        }
        
        if ( !empty($telCasa) ) {
            $arrayInputs['telCasa'] = $telCasa;
            $arrayValidations['telCasa'] = 'numeric|digits_between:10,10';
        }

        /**
         * Otras validaciones
         */
        $hayCampoInvalido = false;
        $arrayOtrasValidaciones = array();
        if ( $tipoUsuario != "SA" && $tipoUsuario != "A" ) {
            $hayCampoInvalido = true;
            $arrayOtrasValidaciones = array( "propiedadesName" => array("tipoUsuario") );
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
                $arrayOtrasValidaciones["textoValidacion"]["tipoUsuario"] = "El tipo de usuario es incorrecto, los valores permitidos son, SA y A";
            }

            print_r( json_encode( array( $arrayEstadoRespuesta, $arrayOtrasValidaciones ) ) );

        } else {

            // --- Validar que el correo no exista.
            $administradorRow = DB::table('administradores')
                ->select('idadministradores')
                ->where('email', '=', $email)
                ->where('estado', '=', 'A')
                ->get();
    
            $administradorRow = $this->funcionesGenerales->parseQuery($administradorRow);
            $idAdministradorCorreo = "";
            if ( !empty($administradorRow) ) {
                $idAdministradorCorreo = $administradorRow[0]["idadministradores"];
            }
            
            // --- Gurdar administrador.
            if ( empty($idAdministradorConsulta) ) {

                // --- Validación correo electrónico.
                if ( !empty($idAdministradorCorreo) ) {
                    print_r( json_encode( array( "estado" => 'email', "mensaje" => "El correo electrónico que esta intentando registrar no esta disponible." ) ) );
                    return;
                }
                
                // ---- Guardado
                $estadoOperacion = Administrador::guardarAdministrador($request);
                if ( $estadoOperacion ) {
                    print_r( json_encode( array( "estado" => 'registroActualizacionCorrecto', "mensaje" => "El administrador fue registrado correctamente." ) ) );
                }else {
                    $arrayRespuestadoOperacion = array( "estado" => false, "mensaje" => "No fue posible registrar el administrador, si el problema persiste contacte al administrador del sistema." );
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


    // --- Función para obtener la información del administrador seleccionado.
    public function obtenerDatosAdministrador( Request $request ) {

        $idAdministrador = $request->idAdministrador;

        $administradorRow = DB::table('administradores')
        ->select('idadministradores', 'nombre', 'apellidopaterno', 'apellidomaterno', 'fechanacimiento', 'direccion', 'codigopostal', 'telcelular', 'telcasa', 'tipousuario', 'email', 
        'nombreusuario')
        ->where('estado', '=', 'A')
        ->where('idadministradores', '=', $idAdministrador)
        ->get();

        $administradorRow = $this->funcionesGenerales->parseQuery($administradorRow);
        print_r(json_encode($administradorRow));

    }


    // --- Eliminar administrador
    public function eliminarAdministrador(Request $request) {

        $idAdministrador = $request->idAdministrador;
        $idAdministradorSesion = session('idAdministrador');

        // ---- Validaciones
        $arrayInputs = [
            'idAdministrador' => $idAdministrador
        ];

        $arrayValidations = [
            'idAdministrador' => 'required|gt:0'
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
        // ---- Validar que el administrador exista.
        $administradorRows = DB::table('administradores')
        ->select('idadministradores')
        ->where('idadministradores', '=', $idAdministrador)
        ->where('estado', '=', 'A')
        ->get();

        $idAdministradorConsulta = "";
        $idAdministrador = $this->funcionesGenerales->parseQuery($administradorRows);
        if ( !empty($idAdministrador[0]["idadministradores"]) ) {
            $idAdministradorConsulta = $idAdministrador[0]["idadministradores"];
        }

        if ( empty($idAdministradorConsulta) ) {

            $arrayTextoValidaciones["idAdministrador"][0] = "El administrador que esta intentando eliminar no existe.";
            $arrayEstadoRespuesta = ["estado" => 'validaciones', "validaciones" => $arrayTextoValidaciones];

        } elseif( $idAdministradorConsulta == $idAdministradorSesion ) {

            $arrayTextoValidaciones["idAdministrador"][0] = "No puede eliminarse así mismo, es necesario que otro administrador lo elimine.";
            $arrayEstadoRespuesta = ["estado" => 'validaciones', "validaciones" => $arrayTextoValidaciones];

        }
        
        if ( !empty($arrayEstadoRespuesta) ) {
            print_r(json_encode($arrayEstadoRespuesta));
            return;
        }

        // --- Se elimina
        $estadoEliminacion = Administrador::eliminarAdministrador($idAdministrador);

        if ( $estadoEliminacion ) {
            $arrayEstadoRespuesta = ["estado" => true, "mensaje" => "Administrador eliminado correctamente."];
        } else {
            $arrayEstadoRespuesta = ["estado" => false, "mensaje" => "No se pudo eliminar el administrador, si el problema persiste contacte al administrador del sistema."];
        }

        print_r(json_encode($arrayEstadoRespuesta ));

    }


    // --- Guardar administrador default.
    public function generarAdministradorDefault() {
        
        $ruta = '/login';

        // --- Validar que el usuario no este registrado.
        $administradorRow = DB::table('administradores')
            ->select('idadministradores')
            ->where('idadministradores', '=', 1)
            ->where('estado', '=', 'A')
            ->get();


        $administradorRow = $this->funcionesGenerales->parseQuery($administradorRow);
        
        if ( empty($administradorRow[0]["idadministradores"]) ) {

            $estadoGuardado = $this->modeloAdministrador->generarAdministradorDefault();
            
            if ( $estadoGuardado ) {
                $ruta = '/admin/registrado';
            }

        } else {
            $ruta = '/';
        }
        
        return redirect($ruta);   

    }


    /**
     * Login, validación de credenciales.
     */
    public function loginValidacion(Request $request) {

        $correoUsuario = $request->correoUsuario;
        $password = $request->password;
        $estado = 'A';
        
        /**
         * Validaciones
         */
        $arrayInputs = [
            'correoUsuario' => $correoUsuario,
            'password' => $password,
        ];

        $arrayValidations = [
            'correoUsuario' => 'required',
            'password' => 'required'
        ];
        
        $validator = Validator::make($arrayInputs, $arrayValidations);
        
        if ( !$validator->passes() ) {
            $arrayEstadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];
            print_r( json_encode( array( $arrayEstadoRespuesta ) ) );
        }
        

        /**
         * Verificar que las credenciales del administrador existan.
         */
        if ( !empty($correoUsuario) && !empty($password) ) {
            
            $usuarios = DB::select('SELECT idadministradores, passw, nombre, apellidopaterno, apellidomaterno FROM administradores 
            WHERE (email = :email OR nombreusuario = :nombreusuario) AND estado = :estado', 
            ['email' => $correoUsuario, 'nombreusuario' => $correoUsuario, 'estado' => $estado]);

            $arrayDatosUsuarios = array();

            $passwordConsulta = "";
            $usuarioEstado = "";

            if ( sizeof($usuarios) > 0 ) {

                $arrayDatosUsuarios = json_decode(json_encode($usuarios), true)[0];
                $passwordConsulta = $arrayDatosUsuarios["passw"];
                $nombre = $arrayDatosUsuarios["nombre"];
                $apellidoPaterno = $arrayDatosUsuarios["apellidopaterno"];
                $apellidoMaterno = $arrayDatosUsuarios["apellidomaterno"];
                $idAdministrador = $arrayDatosUsuarios["idadministradores"];

            }

            // Si el password ingresado es correcto, se crean las variables de sesión.
            if ( password_verify($password, $passwordConsulta) ) {
                $this->modeloAdministrador->loginCrearVariablesSesion($nombre, $apellidoPaterno, $apellidoMaterno, $idAdministrador);
                $arrayRespuestaLogin = ["estado" => true];
            } else {
                $arrayRespuestaLogin = ["estado" => false, "mensaje" => "La contraseña, correo y/o usuario son incorrectos."];
            }
            
            print_r(json_encode($arrayRespuestaLogin));

        }

    }

}
