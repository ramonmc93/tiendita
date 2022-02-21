<article class="col-12 col-lg-6 ml20 mr20 mb20 prop-partes-card tarjetaPost p-r d-flex align-items-center colorFondoDEFEF2">
    <figure class="figureCatalogo">
        <div class="contenedorImagenPrincipal mt14 colorFondo81fece">
            <img src="{{asset('imagenes/imagenesDefault')}}{{"/".$imagenDefault}}" alt="Imagen default">
        </div>
        <figcaption class="colorFondo28DF99">
            {{$nombreProducto}}
        </figcaption>
        <!-- Contenedor botones -->
        <article class="contenedorBotonesPrincipales d-flex mt4">
            <button 
            type="button" 
            class="btn btn-primary borderNBR font-we-100 border-c-1 colorFondoFF80BA borde-color-c-FF80BA mr4">
                + Información
            </button>
            <button 
            type="button" 
            class="btn btn-primary borderNBR font-we-100 border-c-1 colorFondoFF80BA borde-color-c-FF80BA flex-1 btnAgregarProducto"
            data-id-producto="{{$idProducto}}">
                Agregar
            </button>
        </article>
        <article class="contenedorBotonesSecundarios d-flex mt4 colorLetradefef2 font-we-600">
            <div class="colorFondo28DF99 mr4 flex-0-5 d-flex justify-content-center align-items-center">
                {{$precio}}                                   
            </div>
            <div class="contenedorDescuentoStock flex-1 text-center">
                <div class="colorFondo28DF99 mb4">
                    {{$descuento}}                                        
                </div>
                <div class="colorFondo28DF99">
                    {{$stock}}                                      
                </div>
            </div>
            <div class="colorFondo28DF99 ml4 flex-0-4 d-flex justify-content-center align-items-center flex-wrap">
                <button 
                type="button" 
                class="colorFondoTransparente btnLike" 
                data-id-producto="{{$idProducto}}">
                    <img 
                    class="w25" 
                    src="{{asset('imagenes/corazon.svg')}}" 
                    alt="Corazón latiendita">
                </button>
                <span class="likes text-center">{{$totalLikes}}</span>
            </div>
        </article>
    </figure>
</article>