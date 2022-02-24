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
                                if ( empty($productoRows) ) {
                                    $hayProductos = false;
                                }
                            @endphp
                            @foreach ($productoRows as $rowProducto)
                                @php
                                    $nombreProducto = $rowProducto["nombre"];
                                    $precioProducto = $rowProducto["precio"];
                                    $stockProducto = $rowProducto["stock"];
                                    $descuentoProducto = $rowProducto["descuento"];
                                    $idProducto = $rowProducto["idproductos"];
                                @endphp
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>{{$nombreProducto}}</td>
                                    <td>{{"$".$precioProducto}}</td>
                                    <td>{{$descuentoProducto."%"}}</td>
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
                                    <td colspan="8" class="pb-0">
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
                                name="nombreProducto">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="descripcionEspecificaProducto">Descripcion específica:</label>
                                <textarea 
                                class="form-control campoFormulario obligatorio"
                                name="descripcionEspecificaProducto"></textarea>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="descripcionGeneralProducto">Descripcion general:</label>
                                <textarea 
                                class="form-control campoFormulario obligatorio"
                                name="descripcionGeneralProducto"></textarea>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="estadoProducto">Estado del producto:</label>
                                <select 
                                class="form-select campoFormulario obligatorio"
                                name="estadoProducto">
                                    <option value="0">---Seleccione---</option>
                                    <option value="nvo">Nuevo</option>
                                    <option value="udo">Usado</option>
                                </select>
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="precioProducto">Precio:</label>
                                <input
                                class="form-control campoFormulario obligatorio"
                                type="text" 
                                name="precioProducto">
                                <span class="campoObligatorio">Este campo es obligatorio</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="descuentoProducto">Descuento:</label>
                                <input 
                                class="form-control campoFormulario"
                                type="text" 
                                name="descuentoProducto">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <label for="stockProducto">Stock:</label>
                                <input 
                                class="form-control campoFormulario"
                                type="text" 
                                name="stockProducto">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="categoriaProducto">Categoría:</label>
                                <select 
                                class="form-select campoFormulario obligatorio"
                                name="categoriaProducto">
                                    <option value="0">---Seleccione---</option>
                                    @foreach ($categoriasRows as $rowCategoria)
                                        @php
                                            $idCategoria = $rowCategoria["idcategorias"];
                                            $nombreCategoria = $rowCategoria["nombre"];
                                        @endphp
                                        <option value="{{$idCategoria}}">{{$nombreCategoria}}</option>
                                    @endforeach
                                </select>
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
        <script src="{{asset('js/modulos/productos.js')}}"></script>
    @endsection