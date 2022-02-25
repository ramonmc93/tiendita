@php
    $i = 1;
@endphp
{{-- Componente => card-producto --}}
@foreach ($productoRows as $rowProducto)
            
    @php
        
        $imagenDefault = "imagen_default_2.png";
        $className = "colorFondoDEFEF2";

        if( $i %2 == 0 ):
            $imagenDefault = "imagen_default_1.png";
            $className = "colorFondoFF3F9738";
        endif;
        
        $idProducto = $rowProducto["idproductos"];
        $nombreProducto = $rowProducto["nombre"];
        $precioProducto = "$".$rowProducto["precio"];
        $stockProducto = "Stock: ".$rowProducto["stock"];
        $descuentoProducto = "Dto. ".$rowProducto["descuento"]."%";
        $totalLikes = 0;

    @endphp

        <x-card-producto
        :class-name="$className"
        :nombre-producto="$nombreProducto"
        :id-producto="$idProducto"
        :precio="$precioProducto"
        :descuento="$descuentoProducto"
        :stock="$stockProducto"
        :total-likes="$totalLikes"
        :imagen-default="$imagenDefault"/>

    @php
        $i++;
    @endphp

@endforeach