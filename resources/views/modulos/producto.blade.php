@php
    $claseBotonFlotanteAgregar = "btnAgregarProducto";
    $identificadorAccion = "producto";
    $idModal = "modalProducto";
    $tituloModal = "Producto nuevo/editar";
    $idFormularioModulo = "frmProductos";
    $inputHidenNameIdProducto = "idProductoConsulta";
    $idTabla = "tablaProductos";
@endphp

@extends('layouts.template')
    
    @section('title-module', 'Lista de productos registrados')
    
        @section('content-tabla-modulo')

            <article class="w-p-90 mt-4 row justify-content-center">

                <div class="table-responsive">
                    <table class="table table-striped" id="{{$idTabla}}">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Stock</th>
                                <th>Consultar</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 1;
                                $hayProductos = true;
                                if ( empty($productosRows) ) {
                                    $hayProductos = false;
                                }
                            @endphp
                            @foreach ($productosRows as $rowProducto)
                                @php
                                    $nombreProducto = $rowProducto["nombre"];
                                    $precioProducto = $rowProducto["precio"];
                                    $stockProducto = $rowProducto["stock"];
                                    $idProducto = $rowProducto["idproductos"];
                                @endphp
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>{{$nombreProducto}}</td>
                                    <td>{{$precioProducto}}</td>
                                    <td>{{$stockProducto}}</td>
                                    <td>
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btnConsultar"
                                        data-id-producto={{$idProducto}}>
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btnEditar"
                                        data-id-producto={{$idProducto}}>
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btnEliminar"
                                        data-id-producto={{$idProducto}}>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @php
                                    $index++;
                                @endphp
                            @endforeach
                            @if ( !$hayProductos )
                                <tr>
                                    <td colspan="5" class="pb-0">
                                        <div class="alert alert-info text-center">No hay productos para mostrar.</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </article>

        {{-- Modal administrador nuevo/editar --}}
        <x-modal
        id="{{$idModal}}"
        :titulo-modal="$tituloModal">
            @section('contenido-modal')
                <form id="{{$idFormularioModulo}}">
                    @csrf
                    <div class="container">
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="nombre">Nombre:</label>
                                <input 
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="nombre">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="apellidoPaterno">Apellido paterno:</label>
                                <input 
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="apellidoPaterno">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="apellidoMaterno">Apellido materno:</label>
                                <input 
                                class="form-control campoFormulario"
                                type="text" 
                                name="apellidoMaterno">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="telCelular">Teléfono celular:</label>
                                <input 
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="telCelular">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="telCasa">Teléfono casa:</label>
                                <input
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="telCasa">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="email">Email:</label>
                                <input 
                                class="form-control campoFormulario obligatorio"
                                type="email" 
                                name="email">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="fechaNacimiento">Fecha de nacimiento:</label>                                
                                <div class="input-group date" id="fechaNacimiento" data-target-input="nearest">
                                    <input 
                                    class="form-control campoFormulario datetimepicker-input obligatorio"
                                    type="text" 
                                    name="fechaNacimiento"
                                    data-target="#fechaNacimiento"
                                    placeholder="mm/dd/yyyy">
                                    <div 
                                    class="input-group-append" 
                                    data-target="#fechaNacimiento" 
                                    data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <img src="{{asset('imagenes/inputs/calendariocheck.svg')}}" alt="Imagen calendario">
                                        </div>
                                    </div>
                                </div>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="direccion">Dirección:</label>
                                <textarea
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="direccion"
                                rows="10"></textarea>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="codigoPostal">Código postal:</label>
                                <input 
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="codigoPostal">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="tipoAdministrador">Tipo de administrador:</label>                                
                                <div class="form-check">
                                    <input 
                                    class="form-check-input obligatorio" 
                                    type="radio" 
                                    id="tipoAdministrador"
                                    value="A" 
                                    name="tipoUsuario"
                                    checked="checked">
                                    <label class="form-check-label" for="tipoAdministrador">
                                        Administrador
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    value="SA" 
                                    id="tipoSuperAdministrador"
                                    name="tipoUsuario">
                                    <label class="form-check-label" for="tipoSuperAdministrador">
                                        Superadministrador
                                    </label>
                                </div>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                        </div>
                    </div>
                    <input 
                    type="hidden"
                    name="{{$inputHidenNameIdProducto}}">
                </form>
                {{-- Componente alert para mostrar información correspondiente a las validaciones. --}}
                <x-alerts.alertValidacioneForm/>
            @endsection
        </x-modal>

        {{-- Butones flotantes de acción módulo. --}}
        @section('contenedor-boton-flotante-agregar')
            <x-buttons.botonFlotanteAgregar
            :clase-boton-flotante-agregar="$claseBotonFlotanteAgregar"
            :identificador-accion="$identificadorAccion"/>
        @endsection
        
    @endsection

    {{-- Scripts módulos/otros --}}
    @section('scripts-modulos-otros')
        <script src="{{asset('js/modulos/administradores.js')}}"></script>
    @endsection

    @section('estilos-modulos-otros')
        <link rel="stylesheet" href="{{asset('js/plugins/tempusdominus/tempusdominus-bootstrap-4.min.css')}}">
    @endsection