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
        $apellidoPaterno = trim($request->apellidoPaterno);
        $apellidoMaterno = trim($request->apellidoMaterno);
        $telCelular = trim($request->telCelular);
        $telCasa = trim($request->telCasa);
        $email = trim($request->email);
        $fechaNacimiento = trim($request->fechaNacimiento);
        $direccion = trim($request->direccion);
        $codigoPostal = trim($request->codigoPostal);
        $idAdministrador = trim($request->idAdministrador);

        // ---- Validaciones
        $validator = Validator::make(
            [
                'nombre' => $nombre,
                'apellidoPaterno' => $apellidoPaterno,
                'telCelular' => $telCelular,
                'email' => $email
            ],
            [
                'nombre' => 'required|min:3|max:25',
                'apellidoPaterno' => 'required|min:3|max:25',
                'telCelular' => 'numeric|min:10|max:11',
                'email' => 'email|unique:administradores'
            ]
        );

        $estadoRespuesta = "";
        
        if ( !$validator->passes() ) {
            $estadoRespuesta = ["estado" => 'validaciones', "validaciones" => $validator->messages(), $telCelular];
        }

        print_r( json_encode( $estadoRespuesta ) );

        return false;

    }

}
