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
        $this->administrador = new Administrador();
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

            $estadoGuardado = $this->administrador->generarAdministradorDefault();
            
            if ( $estadoGuardado ) {
                $ruta = '/admin/registrado';
            }

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
                $this->administrador->loginCrearVariablesSesion($nombre, $apellidoPaterno, $apellidoMaterno, $idAdministrador);
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
        $email = trim($request->email);
        $fechaNacimiento = trim($request->fechaNacimiento);
        $direccion = trim($request->direccion);
        $codigoPostal = trim($request->codigoPostal);
        $idAdministrador = trim($request->idAdministrador);

        // var_dump($telCelular);
        // return;

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
            'email' => 'required|email|unique:administradores',
            'fechaNacimiento' => 'required|date',
            'direccion' => 'required|min:15',
            'codigoPostal' => 'required|numeric|digits_between:5,5'
        ];
        
        if ( !empty($telCasa) ) {
            $arrayInputs['telCasa'] = $telCasa;
            $arrayValidations['telCasa'] = 'numeric|digits_between:10,10';
        }

        $validator = Validator::make($arrayInputs, $arrayValidations);

        $estadoRespuesta = "";
        
        if ( !$validator->passes() ) {
            $estadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];
            print_r( json_encode( $estadoRespuesta ) );
        }

        // --- Gurdar administrador.
        Administrador::guardarAdministrador($request);

    }

}
