window.addEventListener("DOMContentLoaded", function(){

    $(document).on("click", ".btnAgregarProducto", function() {
        $("#modalProducto").modal("show");
        $("input[name='idProductoConsulta']").removeAttr("value");
        $("#frmProductos .campoFormulario").val("");
        $("select[name='estadoProducto'] option")[0].selected = true;
        $("select[name='categoriaProducto'] option")[0].selected = true;
    });

    // ---- Guardar / Modificar producto.
    $(document).on("click", ".btnGuardarActualizar", function(){

        $("#frmProductos *.invalido").removeClass("invalido");
        $(".contenedorNotificaciones").empty();

        try {
            
            let campoNombreProducto = $("input[name='nombreProducto']");
            let nombreProductoValor = campoNombreProducto.val().trim();
            if ( nombreProductoValor.length < 3 || nombreProductoValor.length > 50 ) {
                campoNombreProducto.addClass("invalido");
                throw 'El nombre del producto es obligarorio y debe tener una longitud mínima de 3 caracteres máximo 50.';
            }

            let campoDescripcionEspecificaProducto = $("textarea[name='descripcionEspecificaProducto']");
            let descripcionEspecificaProductoValor = campoDescripcionEspecificaProducto.val().trim();
            if ( descripcionEspecificaProductoValor.length < 10 || descripcionEspecificaProductoValor.length > 100 ) {
                campoDescripcionEspecificaProducto.addClass("invalido");
                throw 'La descripción específica para el producto es obliglatoria y debe tener una longitud mínima de 10 caracteres y máxima 100 caracteres.';
            }

            let campoDescripcionGeneralProducto = $("textarea[name='descripcionGeneralProducto']");
            let descripcionGeneralProductoValor = campoDescripcionGeneralProducto.val().trim();
            if ( descripcionGeneralProductoValor.length < 10 || descripcionGeneralProductoValor.length > 200 ) {
                campoDescripcionGeneralProducto.addClass("invalido");
                throw 'La descripción general para el producto es obliglatoria y debe tener una longitud mínima de 10 caracteres y máxima 200 caracteres.';
            }

            let campoEstadoProducto = $("select[name='estadoProducto']");
            let estadoProductoValor = campoEstadoProducto.val().trim();
            if ( estadoProductoValor != "nvo" && estadoProductoValor != "udo" ) {
                campoEstadoProducto.addClass("invalido");
                throw 'El estado seleccionado para el producto es incorrecto.';
            }

            let campoPrecioProducto = $("input[name='precioProducto']");
            let precioProductoValor = campoPrecioProducto.val().trim();
            if ( precioProductoValor < 0 || !validarNumeroEntero(precioProductoValor) ) {
                campoPrecioProducto.addClass("invalido");
                throw 'El precio para el producto debe ser numérico mayor o igual a 0.';
            }

            let campoDescuentoProducto = $("input[name='descuentoProducto']");
            let descuentoProductoValor = campoDescuentoProducto.val().trim();
            if ( descuentoProductoValor != "" && ( descuentoProductoValor < 0 || !validarNumeroEntero(descuentoProductoValor) || descuentoProductoValor > 100 ) ) {
                campoDescuentoProducto.addClass("invalido");
                throw 'El descuento para el producto debe ser numérico mayor o igual a 0.';
            }

            let campoStockProducto = $("input[name='stockProducto']");
            let stockProductoValor = campoStockProducto.val().trim();
            if ( stockProductoValor != "" && ( stockProductoValor < 0 || !validarNumeroEntero(stockProductoValor) ) ) {
                campoStockProducto.addClass("invalido");
                throw 'El stock para el producto debe ser numérico mayor o igual a 0.';
            }

            let campoCategoriaProducto = $("select[name='categoriaProducto']");
            let categoriaProductoValor = campoCategoriaProducto.val().trim();
            if ( categoriaProductoValor <= 0 || !validarNumeroEntero(categoriaProductoValor) ) {
                campoCategoriaProducto.addClass("invalido");
                throw 'La categoría seleccionada es incorrecta.';
            }

            let frmProducto = $("#frmProductos").serialize();
            
            $.ajax({
                
                url:"/productos/guardar-modificar",
                method:"POST",
                data:frmProducto,
                dataType:"JSON",
                success:function(data){

                    if ( data[0] != undefined ) {
                        if ( data[0]["estado"] == "validaciones" ) {
                            mostrarErrorValidaciones("frmProductos", data);
                        }
                    }

                    if ( data["estado"] == "registroActualizacionCorrecto" ) {

                        $("#modalProducto").modal("hide");

                        bootbox.alert({
                            message: data["mensaje"],
                            className: 'd-flex align-items-center'
                        });

                        recetearCamposValidaciones("#frmProductos");
                        actualizarTablaProductos();

                    }

                    if ( data["estado"] == false ) {

                        $("#modalProducto").modal("hide");

                        bootbox.alert({
                            message: data["mensaje"],
                            className: 'd-flex align-items-center'
                        });

                    }

                }
                
            });
            
        } catch (error) {

            bootbox.alert({
                message: error,
                className: 'd-flex align-items-center colorFondoError'
            });

        }

    });


    // --- Actualizar tabla productos
    $(document).on("click", ".btnActualizarTabla", function(){
        actualizarTablaProductos();
    });

    function actualizarTablaProductos() {

        let tbody = $("#tablaProductos tbody");
            tbody.empty();

        $.ajax({
            
            url:"/productos/datos",
            data:{"tipoPeticion":'post'},
            method:"POST",
            dataType:"JSON",
            success:function(data){

                // --- Se muestran los resultados en la tabla correpondiente.
                var index = 1;
                for (let producto of data) {   

                    let idProducto = producto.idproductos;
                    let nombreProducto = producto.nombre;
                    let precioProducto = "$"+producto.precio;
                    let descuentoProducto = producto.descuento+"%";
                    let stockProducto = ""+producto.stock;

                    let filaTableBody = $("<tr>");
                    
                    let totalCeldas = 1;
                    let arrayCeldas = [
                        String(index), nombreProducto, precioProducto, descuentoProducto, stockProducto,
                        $("<button>", {class:"btn btn-primary btnConsultar", "data-id-producto":idProducto, type:"button"}).append( $("<i>", {class:"fa fa-search"}) ), 
                        $("<button>", {class:"btn btn-primary btnEditar", "data-id-producto":idProducto, type:"button"}).append( $("<i>", {class:"fa fa-edit"}) ), 
                        $("<button>", {class:"btn btn-primary btnEliminar", "data-id-producto":idProducto, type:"button"}).append( $("<i>", {class:"fa fa-trash"}) )
                    ];

                    for (let elemento of arrayCeldas) {
                        
                        let td = $("<td>");  

                        if ( elemento[0].type == "button" ) {
                            td.append(elemento);  
                        } else {
                            td.text(elemento);  
                        }

                        filaTableBody.append(td);
                        totalCeldas++;
                    }

                    tbody.append( filaTableBody );

                    index++;

                }

            }
            
        });

    }


    // --- Consultar información del producto seleccionado.
    $(document).on("click", ".btnConsultar", function(){
        mostrarInformacionFormularioProducto(this);
    });

    $(document).on("click", ".btnEditar", function(){
        mostrarInformacionFormularioProducto(this, 'editar');
    });

    function mostrarInformacionFormularioProducto(_this, operacion = 'consultar') {

        let idProducto = $(_this).data("id-producto");
        recetearCamposValidaciones( "#frmProductos" );

        $.ajax({
                
            url:"/producto/datos",
            data:{"idProducto":idProducto},
            method:"POST",
            dataType:"JSON",
            success:function(data){

                $("#modalProducto").modal("show");

                data = data[0];
                let idProducto = data.idproductos;
                let nombreProducto = data.nombre;
                let descripcionEspecifica = data.descripcionespecifica;
                let descripcionGeneral = data.descripciongeneral;
                let estadoProducto = data.estadoproducto;
                let precioProducto = data.precio;
                let descuentoProducto = data.descuento;
                let stockProducto = data.stock;
                let categoriaProducto = data.idcategoriasfk;

                $('*[name="nombreProducto"]').val(nombreProducto);
                $('*[name="descripcionEspecificaProducto"]').val(descripcionEspecifica);
                $('*[name="descripcionGeneralProducto"]').val(descripcionGeneral);
                $("select[name='estadoProducto'] option[value='"+estadoProducto+"']")[0].selected = true;
                $('*[name="precioProducto"]').val(precioProducto);
                $('*[name="descuentoProducto"]').val(descuentoProducto);
                $('*[name="stockProducto"]').val(stockProducto);
                $("select[name='categoriaProducto'] option[value='"+categoriaProducto+"']")[0].selected = true;

                if ( operacion != 'consultar' ) {
                    $('*[name="idProductoConsulta"]').val(idProducto);
                    $(".btnGuardarActualizar").removeClass("d-none");
                    $("#frmProductos .campoFormulario").attr("disabled", false);
                    $(".btnActualizarSelectCategorias").removeClass("d-none");
                } else {
                    $('*[name="idProductoConsulta"]').removeAttr("value");
                    $(".btnGuardarActualizar").addClass("d-none");
                    $("#frmProductos .campoFormulario").attr("disabled", true);
                    $(".btnActualizarSelectCategorias").addClass("d-none");
                }

            }

        });

    }

    // --- Eliminar producto
    $(document).on("click", ".btnEliminar", function() {

        let idProducto = $(this).data("id-producto");

        bootbox.confirm({
            message: "¿En realidad desea eliminar este producto?",
            buttons: {
                confirm: {
                    label: 'Si',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            className: 'd-flex align-items-center',
            callback: function (result) {
                if ( result ) {
                                        
                    $.ajax({
                
                        url:"/producto/eliminar",
                        data:{"idProducto":idProducto},
                        method:"POST",
                        dataType:"JSON",
                        success:function(data){
                            
                            if ( data["estado"] == "validaciones" ) {

                                var validacionMensaje = data.validaciones.idProducto[0];  
                                bootbox.alert({
                                    message: validacionMensaje,
                                    className: 'd-flex align-items-center'
                                });
                                
                            }

                            if ( data["estado"] == true ) {

                                var validacionMensaje = data["mensaje"];
                                bootbox.alert({
                                    message: validacionMensaje,
                                    className: 'd-flex align-items-center'
                                });

                                console.log(1);
                                actualizarTablaProductos();

                            } else {

                                var validacionMensaje = data["mensaje"];
                                bootbox.alert({
                                    message: validacionMensaje,
                                    className: 'd-flex align-items-center'
                                });

                            }

                        }

                    });
                    
                }
            }
        });

    });


    // --- Actualizar select categorías.
    $(document).on("click", ".btnActualizarSelectCategorias", function(){

        $.ajax({
                
            url:"/producto/select-categorias",
            method:"POST",
            dataType:"html",
            success:function(data){
                $(".contenedorSelectCategorias").empty().html(data);
            }

        });

    });

});