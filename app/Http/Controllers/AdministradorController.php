<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Library\FuncionesGenerales;

use Throwable;

class AdministradorController extends Controller
{

    private $funcionesGenerales;

    public function __construct() {
        $this->funcionesGenerales = new FuncionesGenerales();
    }

    public function guardarAdministrador(Request $request) {

        $nombre = trim($request->nombre);
        $apellidoPaterno = $request->apellidoPaterno;
        $apellidoMaterno = $request->apellidoMaterno;
        $telCelular = $request->telCelular;
        $telCasa = $request->telCasa;
        $email = $request->email;
        $fechaNacimiento = $request->fechaNacimiento;
        $direccion = $request->direccion;
        $codigoPostal = $request->codigoPostal;
        $idAdministrador = $request->idAdministrador;

        // ---- Validaciones
        $validator = Validator::make(
            [
                'nombre' => $nombre,
                'apellidoPaterno' => $apellidoPaterno,
                'email' => $email
            ],
            [
                'nombre' => 'required|min:3|max:25',
                'apellidoPaterno' => 'required|min:3|max:25',
                'email' => 'email|unique:administradores'
            ]
        );

        if ( !$validator->passes() ) {
            $estadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages()];
        }

        print_r( json_encode( $estadoRespuesta ) );

        return false;

    }

}
