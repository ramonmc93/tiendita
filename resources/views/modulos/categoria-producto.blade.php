@php
    $claseBotonFlotanteAgregar = "btnAgregarCategoria";
    $identificadorAccion = "categoria";
    $nombreTabla = "tablaCategorias";
    $tituloModal = "Categorías nueva/editar";
    $idFormularioModulo = "frmCategorias";
    $inputHidenNameIdCategoria = "idCategoriaConsulta";
    $idModal = "modalCategoria";
@endphp

@extends('layouts.template')
    
    @section('title-module', 'Lista de categorías registradas')
    
        @section('content-tabla-modulo')

            <article class="w-p-90 mt-4 row justify-content-center">

                <div class="table-responsive">
                    <table class="table table-striped" id="{{$nombreTabla}}">
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
                            @php
                                $index = 1;
                                $hayCategorias = true;
                                if ( empty($categoriasRows) ) {
                                    $hayCategorias = false;
                                }
                            @endphp
                            @foreach ($categoriasRows as $rowCategoria)
                                @php
                                    $nombreCategoria = $rowCategoria["nombre"];
                                    $idCategoria = $rowCategoria["idcategorias"];
                                @endphp
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>{{$nombreCategoria}}</td>
                                    <td>
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btnConsultar"
                                        data-id-categoria={{$idCategoria}}>
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btnEditar"
                                        data-id-categoria={{$idCategoria}}>
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btnEliminar"
                                        data-id-categoria={{$idCategoria}}>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @php
                                    $index++;
                                    @endphp
                            @endforeach
                            @if ( !$hayCategorias )
                                <tr>
                                    <td colspan="5" class="pb-0">
                                        <div class="alert alert-info text-center">No hay categorías para mostrar.</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </article>

        {{-- Modal categorías nuevo/editar --}}
        <x-modal
        id="{{$idModal}}"
        :titulo-modal="$tituloModal">
            @section('contenido-modal')
                <form id="{{$idFormularioModulo}}">
                    @csrf
                    <div class="container">
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="nombreCategoria">Nombre:</label>
                                <input 
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="nombreCategoria">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-8">
                                <label for="descripcionCategoria">Descripción:</label>
                                <textarea 
                                class="form-control campoFormulario obligatorio"
                                name="descripcionCategoria"
                                rows="5"></textarea>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                        </div>
                    </div>
                    <input 
                    type="hidden"
                    name="{{$inputHidenNameIdCategoria}}">
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
        <script src="{{asset('js/modulos/categorias.js')}}"></script>
    @endsection

    @section('estilos-modulos-otros')@endsection