<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/librerias/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/colores.css')}}">
    <link rel="stylesheet" href="{{asset('css/estilosPersonalizados.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/estilosLogin.css')}}">
</head>
<body>
    <main class="container-fluid d-flex justify-content-center align-items-center contenedorPrincipalLogin">
        <section class="row p-2 contenedorSecundarioLogin">
            <article class="col-12">
                <form id="frmLogin" method="POST">
                    @csrf
                    <div class="contenedorNombreProyecto text-center">
                        <p class="nombrePrincipal">
                            <a href="../index.php">
                                <span>LAJITA</span>
                                <span>SHOP</span>
                            </a>
                        </p>
                    </div>
                    <div class="col-12 text-center contenedorLogo">
                        <img 
                        src="{{asset('imagenes/logo/logo.svg')}}" 
                        alt="Logotipo lajitashop" 
                        class="logo">
                    </div>
                    <div class="form-group col-12">
                        <label for="Nombre de usuario">Nombre de usuario o correo electrónico:</label>
                        <input 
                        type="text"
                        class="form-control" 
                        id="correoUsuario" 
                        name="correoUsuario"
                        placeholder="usuario/email">
                    </div>
                    <div class="form-group col-12">
                        <label for="Contraseña">Contraseña:</label>
                        <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password">
                        <button 
                        type="button" 
                        class="btn-ct-inp d-flex-center borderNBR btnPrimero btnMostrarPassword d-none" 
                        data-input-name="password" 
                        data-ocultar-password="false">
                            <li class="ico-ojo esclerotica d-flex-center">
                                <span class="iris d-flex-center">
                                    <span class="pupila"></span>
                                </span>
                            </li>
                        </button>
                    </div>
                    <div class="form-group col-12 mt-1">
                        <button 
                        type="button" 
                        class="btn btn-primary btn-accion-principal btnAcceder">Acceder</button>
                    </div>
                    <hr>
                    <div class="col-12 contenedorFooter">
                        <p class="mb-0"><a href="index.php">Volver a la página principal</a></p>
                    </div>
                </form>
                {{session('tokenUsuario')}}
            </article>
        </section>
    </main>
    <script src="{{asset('js/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/modulos/login.js')}}"></script>
</body>
</html>
