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
        $apellidoPaterno = "Admin";
        $apellidoMaterno = "Admin";
        $fechaNacimiento = date("Y-m-d H:i:s");
        $direccion = "cloud";
        $codigoPostal = "01010";
        $telCelular = "01111011101";
        $telCasa = "11111011101";
        $tipoUsuario = "SA";
        $email = "127.0.0.1@gmail.com";
        $passw = password_hash("@123_", PASSWORD_DEFAULT);
        $nombreUsuario = "superadmin";
        $fechaRegistro = date("Y-m-d H:i:s");
        $estado = "A";
        $idUsuarioRegistro = 1;

        $estadoConsulta = DB::table('administradores')->insert([
            'nombre' => $nombre,
            'apellidopaterno' => $apellidoPaterno,
            'apellidomaterno' => $apellidoMaterno,
            'fechanacimiento' => $fechaNacimiento,
            'direccion' => $direccion,
            'codigopostal' => $codigoPostal,
            'telcelular' => $telCelular,
            'telcasa' => $telCasa,
            'tipousuario' => $tipoUsuario,
            'email' => $email,
            'passw' => $passw,
            'nombreusuario' => $nombreUsuario,
            'fecharegistro' => $fechaRegistro,
            'estado' => $estado,
            'idusuarioregistro' => $idUsuarioRegistro
        ]);

        // --- Se crean las variables de sesión.
        $this->loginCrearVariablesSesion($nombre, $apellidopaterno, $apellidomaterno, $idusuarioregistro);

        return $estadoConsulta;
        
    }

    public static function guardarAdministrador($request) {

        $nombre = $request->nombre;
        $apellidoPaterno = $request->apellidoPaterno;
        $apellidoMaterno = $request->apellidoMaterno;
        $fechaNacimiento = date("Y-m-d", strtotime($request->fechaNacimiento));
        $direccion = $request->direccion;
        $codigoPostal = $request->codigoPostal;
        $telCelular = $request->telCelular;
        $telCasa = $request->telCasa;
        $tipoUsuario = $request->tipoUsuario;
        $email = $request->email;
        $passw = "";
        $nombreUsuario = "";
        $fechaRegistro = date("Y-m-d H:i:s");
        $estado = "A";
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
            'tipousuario' => $tipoUsuario,
            'email' => $email,
            'passw' => $passw,
            'nombreusuario' => $nombreUsuario,
            'fecharegistro' => $fechaRegistro,
            'estado' => $estado,
            'idusuarioregistro' => $idUsuarioRegistro,
        ]);

        return $estadoOperacion;
        
    }

    public function actualizarAdministrador($request) {
        
        $nombre = $request->nombre;
        $apellidoPaterno = $request->apellidoPaterno;
        $apellidoMaterno = $request->apellidoMaterno;
        $fechaNacimiento = date("Y-m-d", strtotime($request->fechaNacimiento));
        $direccion = $request->direccion;
        $codigoPostal = $request->codigoPostal;
        $telCelular = $request->telCelular;
        $telCasa = $request->telCasa;
        $tipoUsuario = $request->tipoUsuario;
        $email = $request->email;
        $passw = "";
        $nombreUsuario = "";
        $idAdministradorConsulta = $request->idAdministradorConsulta;
        $fechaRegistro = date("Y-m-d H:i:s");
        $estado = "A";
        $idUsuarioRegistro = session('idAdministrador');

        $estadoOperacion = DB::table('administradores')->update([
            'nombre' => $nombre,
            'apellidopaterno' => $apellidoPaterno,
            'apellidomaterno' => $apellidoMaterno,
            'fechanacimiento' => $fechaNacimiento,
            'direccion' => $direccion,
            'codigopostal' => $codigoPostal,
            'telcelular' => $telCelular,
            'telcasa' => $telCasa,
            'tipousuario' => $tipoUsuario,
            'email' => $email,
            'passw' => $passw,
            'nombreusuario' => $nombreUsuario,
            'fecharegistro' => $fechaRegistro,
            'estado' => $estado,
            'idusuarioregistro' => $idUsuarioRegistro,
        ])
        ->where('idadministradores', $idAdministradorConsulta);
            
        return $estadoOperacion;
        
    }

}
