@extends('layouts.template')
    
    @section('title-module', 'Lista de productos')
    
    @section('content-cards-producto')

        {{-- Componente => card-producto --}}
        @php
            $idProducto = 1;
            $precio = 4;
            $descuento = 10;
            $stock = 1;
            $totalLikes = 4;
        @endphp

        @for ($i = 1; $i <= 4; $i++)

            @php
                $nombreProducto = "Producto ".$i;
                $imagenDefault = ( $i %2 == 0) ? "imagen_default_1.png" : "imagen_default_2.png";
            @endphp

            <x-card-producto
            :nombre-producto="$nombreProducto"
            :id-producto="$idProducto"
            :precio="$precio"
            :descuento="$descuento"
            :stock="$stock"
            :total-likes="$totalLikes"
            :imagen-default="$imagenDefault"/>

            @php
                $idProducto = $i;
                $precio += 4;
                $descuento += 10;
                $stock = $i;
                $totalLikes += 4;
            @endphp

        @endfor
        
    @endsection

