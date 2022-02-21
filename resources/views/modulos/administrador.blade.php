@extends('layouts.template')
    
    @section('title-module', 'Lista de administradores')
    
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
                                <td>Ramón Martínez Cruz</td>
                                <td>
                                    <button 
                                    type="button" 
                                    class="btn btn-primary btnConsultar"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalAdmnistradores">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </td>
                                <td>
                                    <button 
                                    type="button" 
                                    class="btn btn-primary btnEditar"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalAdmnistradores">
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

        {{-- Modal nuevo/editar administrador --}}
        @php    
            $tituloModal = "Administrador nuevo/editar";
        @endphp
        <x-modal
        id="modalAdmnistradores"
        :titulo-modal="$tituloModal">
            @section('contenido-modal')
                <form id="frmAdministradores">
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
                                type="text" 
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
                                    data-target="#fechaNacimiento">
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
                    name="idAdministrador">
                </form>
            @endsection
        </x-modal>
        
    @endsection

    {{-- Scripts módulos/otros --}}
    @section('scripts-modulos-otros')
        <script src="{{asset('js/modulos/administradores.js')}}"></script>
    @endsection

    @section('estilos-modulos-otros')
        <link rel="stylesheet" href="{{asset('js/plugins/tempusdominus/tempusdominus-bootstrap-4.min.css')}}">
    @endsection

    
    