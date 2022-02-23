@extends('layouts.template')
    
    @section('title-module', 'Lista de productos registrados')
    
        @section('content-tabla-modulo')

            <article class="w-p-90 mt-4 row justify-content-center">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Consultar</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Jabón blacanieves</td>
                                <td>
                                    <button 
                                    type="button" 
                                    class="btn btn-primary btnConsultar"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalProducto">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </td>
                                <td>
                                    <button 
                                    type="button" 
                                    class="btn btn-primary btnEditar"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalProducto">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    <button 
                                    type="button" 
                                    class="btn btn-primary btnEliminar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>

        {{-- Modal producto nuevo/editar --}}
        @php    
            $tituloModal = "Producto nuevo/editar";
            $idFormularioModulo = "frmAdministradores";
            $nameIdProducto = "idProducto";
        @endphp
        <x-modal
        id="modalProducto"
        :titulo-modal="$tituloModal">
            @section('contenido-modal')
                <form id="{{$idFormularioModulo}}">
                    @csrf
                    <div class="container">
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="nombre">Nombre:</label>
                                <input 
                                class="form-control"
                                type="text" 
                                name="nombre">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="apellidoPaterno">Apellido paterno:</label>
                                <input 
                                class="form-control"
                                type="text" 
                                name="apellidoPaterno">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="apellidoMaterno">Apellido materno:</label>
                                <input 
                                class="form-control"
                                type="text" 
                                name="apellidoMaterno">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="telCelular">Teléfono celular:</label>
                                <input 
                                class="form-control"
                                type="text" 
                                name="telCelular">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="telCasa">Teléfono casa:</label>
                                <input
                                class="form-control"
                                type="text" 
                                name="telCasa">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="email">Email:</label>
                                <input 
                                class="form-control"
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
                                    class="form-control datetimepicker-input"
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
                                class="form-control"
                                type="text" 
                                name="direccion"
                                rows="10"></textarea>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="codigoPostal">Código postal:</label>
                                <input 
                                class="form-control"
                                type="text" 
                                name="codigoPostal">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                        </div>
                    </div>
                    <input 
                    type="hidden"
                    name="{{$nameIdProducto}}">
                </form>
                {{-- Componente alert para mostrar información correspondiente a las validaciones. --}}
                <x-alerts.alertValidacioneForm/>
            @endsection
        </x-modal>

        {{-- Butones flotantes de acción módulo. --}}
        @section('contenedor-boton-flotante-agregar')     
            @php
                $claseBotonFlotanteAgregar = "btnAgregarProducto";
                $idModal = "#modalProducto";
                $identificadorAccion = "producto";
            @endphp 
            <x-buttons.botonFlotanteAgregar
            :clase-boton-flotante-agregar="$claseBotonFlotanteAgregar"
            :id-modal="$idModal"
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

    
    