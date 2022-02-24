<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Administrador;
use Illuminate\Support\Facades\DB;

use App\Library\FuncionesGenerales;

class AdministradorController extends Controller
{

    private $funcionesGenerales;
    public $administrador;

    public function __construct() {
        $this->funcionesGenerales = new FuncionesGenerales();
        $this->modeloAdministrador = new Administrador();
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


    // --- Login, validación de credenciales.
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
            $estadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];
            print_r( json_encode( $estadoRespuesta ) );
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

        // ---- Validaciones
        $arrayInputs = [
            'nombre' => $nombre,
            'apellidoPaterno' => $apellidoPaterno,
            'telCelular' => $telCelular,
            'email' => $email,
            'fechaNacimiento' => $fechaNacimiento,
            'direccion' => $direccion,
            'codigoPostal' => $codigoPostal
        ];

        $arrayValidations = [
            'nombre' => 'required|min:3|max:25',
            'apellidoPaterno' => 'required|min:3|max:25',
            'telCelular' => 'required|numeric|digits_between:10,10',
            'email' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'direccion' => 'required|min:15',
            'codigoPostal' => 'required|numeric|digits_between:5,5'
        ];
        
        if ( !empty($telCasa) ) {
            $arrayInputs['telCasa'] = $telCasa;
            $arrayValidations['telCasa'] = 'numeric|digits_between:10,10';
        }

        /**
         * Otras validaciones
         */
        // --- Validaciones if
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

        $estadoRespuesta = "";
        
        if ( !$validator->passes() || $hayCampoInvalido ) {
            
            $estadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];

            /**
            * Otras validaciones
            */
            if ( $hayCampoInvalido ) {  
                $arrayOtrasValidaciones["textoValidacion"]["tipoUsuario"] = "El tipo de usuario es incorrecto, los valores permitidos son, SA y A";
            }

            print_r( json_encode( array( $estadoRespuesta, $arrayOtrasValidaciones ) ) );

        } else {

            // --- Validar que el correo no exista.
            $administradorRow = DB::table('administradores')
                ->select('idadministradores')
                ->where('email', '=', $email)
                ->where('estado', '=', 'A')
                ->get();
    
            $administradorRow = $this->funcionesGenerales->parseQuery($administradorRow);
            if ( !empty($administradorRow[0]["idadministradores"]) ) {
                print_r( json_encode( array( "estado" => 'email', "mensaje" => "El correo electrónico que está intentando registrar ya existe." ) ) );
                return;
            }
            
            // --- Gurdar administrador.
            if ( empty($idAdministradorConsulta) ) {

                $estadoOperacion = Administrador::guardarAdministrador($request);
                if ( $estadoOperacion ) {
                    print_r( json_encode( array( "estado" => 'registroCorrecto', "mensaje" => "El administrador fue registrado correctamente." ) ) );
                }

            } else {
                // --- Actualización administrador.
                $estadoOperacion = Administrador::actualizarAdministrador($request);
                if ( $estadoOperacion ) {
                    print_r( json_encode( array( "estado" => 'registroCorrecto', "mensaje" => "El administrador fue actualizado correctamente." ) ) );
                }
            }

        }

    }


    // --- Función para obtener los datos de los administradores.
    public function obtenerDatosAdministradores( Request $request ) {
        
        $tipoPeticion = $request->tipoPeticion;
        $idAdministrador = $request->idAdministrador;

        // --- Validar que el correo no exista.
        $administradorRows = DB::table('administradores')
        ->select('idadministradores', 'nombre', 'apellidopaterno', 'apellidomaterno', 'tipousuario', 'email')
        ->where('estado', '=', 'A')
        ->get();

        $administradorRows = $this->funcionesGenerales->parseQuery($administradorRows);

        if ( $tipoPeticion == 'post' ) {
            print_r(json_encode($administradorRows));

        } else {
            return view("modulos.administrador", ["administradorRows" => $administradorRows ]);
        }

    }

    // --- Función para obtener la información del administrador seleccionado.
    public function obtenerDatosAdministrador( Request $request ) {

        $idAdministrador = $request->idAdministrador;

        // --- Validar que el correo no exista.
        $administradorRow = DB::table('administradores')
        ->select('idadministradores', 'nombre', 'apellidopaterno', 'apellidomaterno', 'fechanacimiento', 'direccion', 'codigopostal', 'telcelular', 'telcasa', 'tipousuario', 'email', 
        'nombreusuario')
        ->where('estado', '=', 'A')
        ->where('idadministradores', '=', $idAdministrador)
        ->get();

        $administradorRow = $this->funcionesGenerales->parseQuery($administradorRow);
        print_r(json_encode($administradorRow));

    }


}
