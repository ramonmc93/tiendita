@if ( 1 == 1 )
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title-module')</title>
        <link rel="stylesheet" href="{{asset('css/librerias/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/plugins/fontawesome/css/font-awesome.min.css')}}">
        @yield('estilos-modulos-otros')
        <link rel="stylesheet" href="{{asset('css/colores.css')}}">
        <link rel="stylesheet" href="{{asset('css/estilosPersonalizados.css')}}">
        <link rel="stylesheet" href="{{asset('css/estilosCard.css')}}">
        <link rel="stylesheet" href="{{asset('css/index.css')}}">
    </head>
    <body>
        <header>
            <section class="contenedorHeader">
                <article class="contenedorBotonHamburguesa d-flex align-items-center">
                    <button type="button" class="btnHamburguesa btnMenuHeader btnMenuPrincipal" data-ocultar="false">
                        <div class="iconoHamburguesa">
                            <div class="lineas"></div>
                            <div class="lineas"></div>
                            <div class="lineas lineacentral"></div>
                        </div>
                    </button>
                    <div class="logo logoSuperior">
                        <img src="{{ asset('imagenes/logo/logo.svg')}}" alt="Logo lagita shop">
                        <p class="m-b-0 text-center">LajitaShop</p>
                    </div>
                </article>
                <article class="contenedorBuscadorFiltros container">
                    <div class="row ml-0">
                        <label for="buscador" class="colorLetraBlanco-n font-we-300">Filtro de búsqueda:</label>
                        <div class="input-group mb-3">
                            <div class="form-group col-12 col-lg-6 d-flex">
                                <input type="text" class="form-control" name="textoBuscar">
                                <div class="contenedorBotonBuscarFiltros">
                                    <button class="btn btn-primary d-flex btnBuscarFiltroBusqueda" type="button">
                                        <img src="{{ asset('imagenes/botones/lupa.svg') }}" alt="Buscar producto" class="lupaBuscador">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </header>

        {{-- Menú --}}
        <article class="menu">
            <nav>
                <ul>
                    <li>
                        <a href="#" class="cerrarSesion">Cerrar sesión</a>
                    </li>
                    @if ( $nombreVista != "index")
                        <li>
                            <a href="/">Página principal</a>
                        </li>
                    @endif
                    @if ( $nombreVista != "modulos.administradores" )
                        <li>
                            <a href="/modulos/administradores">Módulo de administradores</a>
                        </li>
                    @endif
                    <li>
                        <a href="/modulos/productos">Módulo de productos</a>
                    </li>
                </ul>
            </nav>
        </article>
        
        {{-- Contenido principal del módulo --}}
        <main>
            <div class="contenedorTituloModulo d-flex align-items-center">
                <h1>
                    @yield('title-module')
                </h1>
            </div>
            <section class="container-fluid d-flex justify-content-center">
                @yield('content-cards-producto')
                @yield('content-tabla-modulo')
            </section>
            {{-- Butones de acción módulo. --}}
            @php
                if ( empty($identificadorBoton) ):
                    $identificadorAccion = "";
                    $identificadorBoton = "";
                endif;  
            @endphp 
            <button
            type="button"
            class="btn-flotante {{$identificadorBoton}}" 
            data-bs-toggle="modal" 
            data-bs-target="#modalAdmnistradores"
            title="Agregar nuevo {{$identificadorAccion}}">
                <img src="{{asset('imagenes/botones/agregar.svg')}}" alt="Agregar nuevo {{$identificadorAccion}}">
            </button>
        </main>
        
        <footer>
            <div class="logo w-100">
                <img 
                class="p-a"
                src="{{ asset('imagenes/logo/logo.svg')}}" 
                alt="Logo lagita shop">
                <p class="m-b-0 text-center logoInferior">LajitaShop</p>
            </div>
        </footer>

        <script src="{{asset('js/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('css/librerias/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('css/librerias/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('js/plugins/moment/locale.js')}}"></script>
        <script src="{{asset('js/plugins/tempusdominus/tempusdominus-bootstrap-4.min.js')}}"></script>
        <script src="{{asset('js/main.js')}}"></script>
        @yield('scripts-modulos-otros')
    </body>
    </html>
@endif