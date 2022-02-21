@if ( 1 == 1 )
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title-module')</title>
        <link rel="stylesheet" href="{{asset('css/bootstrap/dist/css/bootstrap.min.css')}}">
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
                    @php
                        $nombreVista = "";
                    @endphp
                    @if ( $nombreVista != "modules.base.index" )
                        <li>
                            <a href="/administradores">Módulo de administradores</a>
                        </li>
                    @endif
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
            <section class="container d-flex justify-content-center">
                <article class="w-p-90 mt-4 row justify-content-center mt20 listaProductosRegistrados">
                    @yield('content-cards-producto')
                </article>
            </section>
            {{-- Butón nuevo registro --}}
            <a href="/usuario/nuevo" class="btn-flotante {{@$identificadorBoton}}" title="Agregar nuevo {{@$identificadorAccion}}">            
                <img src="{{asset('imagenes/botones/agregar.svg')}}" alt="Agregar nuevo {{@$identificadorAccion}}">
            </a>
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
        <script src="{{ asset('css/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('js/main.js')}}"></script>
        <script src="{{ asset('js/modulos/usuarios.js') }}"></script>
        <script src="{{asset('js/modulos/login.js')}}"></script>
    </body>
    </html>
@endif