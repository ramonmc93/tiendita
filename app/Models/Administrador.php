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

        // --- Se crean las variables de sesión.
        $this->loginCrearVariablesSesion($nombre, $apellidopaterno, $apellidomaterno, $idusuarioregistro);

        return $estadoConsulta;
        
    }

    public static function guardarAdministrador($request) {

        $nombre = $request->nombre;
        $apellidoPaterno = $request->apellidoPaterno;
        $apellidoMaterno = $request->apellidoMaterno;
        $fechaNacimiento = $request->fechaNacimiento;
        $direccion = $request->direccion;
        $codigoPostal = $request->codigoPostal;
        $telCelular = $request->telCelular;
        $telCasa = $request->telCasa;
        $email = $request->email;
        $fechaRegistro = date("Y-m-d H:i:s");
        $idUsuarioRegistro = session('idAdministrador');

        $estadoOperacion = DB::table('administradores')->insert([
            'nombre' => $nombre,
            'apellidopaterno' => $apellidoPaterno,
            'apellidomaterno' => $apellidoMaterno,
            'fechanacimiento' => $fechaNacimiento,
            'direccion' => $direccion,
            'codigopostal' => $codigoPostal,
            'telcelular' => $telCelular,
            'telcasa' => $telCasa,
            'email' => $email,
            'fecharegistro' => $fechaRegistro,
            'idusuarioregistro' => $idUsuarioRegistro,
        ]);

        return $estadoOperacion;
        
    }

}
