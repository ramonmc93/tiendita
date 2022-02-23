<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Administrador extends Model
{
    use HasFactory;

    // --- Función para crear las variables de sesión.
    public function loginCrearVariablesSesion($nombre, $apellidopaterno, $apellidomaterno, $idadministrador) {
        // Se almacenan los datos de la sesión.
        session(['nombre' => $nombre, 'apellidoPaterno' => $apellidopaterno, 'apellidoMaterno' => $apellidomaterno, 'idAdministrador' => $idadministrador]);
    }


    // --- Función para crear el usuario por default.
    public function generarAdministradorDefault() {


        $nombre = "Super";
        $apellidopaterno = "Admin";
        $apellidomaterno = "Admin";
        $fechanacimiento = date("Y-m-d H:i:s");
        $direccion = "cloud";
        $codigopostal = "01010";
        $telcelular = "01111011101";
        $telcasa = "11111011101";
        $tipousuario = "SA";
        $email = "127.0.0.1@gmail.com";
        $passw = password_hash("@123_", PASSWORD_DEFAULT);
        $nombreusuario = "superadmin";
        $fecharegistro = date("Y-m-d H:i:s");
        $estado = "A";
        $idusuarioregistro = 1;

        $estadoConsulta = DB::table('administradores')->insert([
            'nombre' => $nombre,
            'apellidopaterno' => $apellidopaterno,
            'apellidomaterno' => $apellidomaterno,
            'fechanacimiento' => $fechanacimiento,
            'direccion' => $direccion,
            'codigopostal' => $codigopostal,
            'telcelular' => $telcelular,
            'telcasa' => $telcasa,
            'tipousuario' => $tipousuario,
            'email' => $email,
            'passw' => $passw,
            'nombreusuario' => $nombreusuario,
            'fecharegistro' => $fecharegistro,
            'estado' => $estado,
            'idusuarioregistro' => $idusuarioregistro
        ]);

        $this->loginCrearVariablesSesion($nombre, $apellidopaterno, $apellidomaterno, $idusuarioregistro);

        return $estadoConsulta;
        
    }

    public static function guardarAdministrador($request) {

        $nombre = $request->nombre;
        $apellidopaterno = $request->apellidoPaterno;
        $apellidomaterno = $request->apellidoMaterno;
        $fechanacimiento = $request->fechaNacimiento;
        $direccion = $request->direccion;
        $codigopostal = $request->codigoPostal;
        $telcelular = $request->telCelular;
        $telcasa = $request->telCasa;
        $email = $request->email;
        $fecharegistro = date("Y-m-d H:i:s");
        $fecharegistro = date("Y-m-d H:i:s");
        // $idusuarioregistro = $request->idAdministrador;

        // print_r(json_encode(array($nombre, $apellidoPaterno, $apellidoMaterno, $telCelular)));
        
    }

}
