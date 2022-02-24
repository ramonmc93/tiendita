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

        try {
            
            let frmProducto = $("#frmProductos").serialize();
            recetearCamposValidaciones("#frmProductos");
            
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
                className: 'd-flex align-items-center'
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
                } else {
                    $('*[name="idProductoConsulta"]').removeAttr("value");
                    $(".btnGuardarActualizar").addClass("d-none");
                    $("#frmProductos .campoFormulario").attr("disabled", true);
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

});