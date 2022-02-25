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