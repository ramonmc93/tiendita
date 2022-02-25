window.addEventListener("DOMContentLoaded", function(){

    $(document).on("click", ".btnAgregarCategoria", function() {
        $("#modalCategoria").modal("show");
        $("input[name='idCategoriaConsulta']").removeAttr("value");
        $("#frmCategorias .campoFormulario").val("");
    });

    // ---- Guardar / Modificar categoría.
    $(document).on("click", ".btnGuardarActualizar", function(){

        try {
            
            let frmCategoria = $("#frmCategorias").serialize();
            
            $.ajax({
                
                url:"/categorias/guardar-modificar",
                method:"POST",
                data:frmCategoria,
                dataType:"JSON",
                success:function(data){

                    if ( data["estado"] == "validaciones" ) {
                        mostrarErrorValidaciones("frmCategorias", data, 1);
                    }

                    if ( data["estado"] == "categoria" ) {
                        mostrarMensajeError( data["mensaje"] );
                    }

                    if ( data["estado"] == "registroActualizacionCorrecto" ) {

                        $("#modalCategoria").modal("hide");

                        bootbox.alert({
                            message: data["mensaje"],
                            className: 'd-flex align-items-center'
                        });
                        
                        recetearCamposValidaciones("#frmCategorias");
                        actualizarTablaCategorias();

                    }

                    if ( data["estado"] == false ) {

                        $("#modalCategoria").modal("hide");

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


    // --- Actualizar tabla categorías
    $(document).on("click", ".btnActualizarTabla", function(){
        actualizarTablaCategorias();
    });

    function actualizarTablaCategorias() {

        let tbody = $("#tablaCategorias tbody");
            tbody.empty();

        $.ajax({
            
            url:"/categorias/datos",
            data:{"tipoPeticion":'post'},
            method:"POST",
            dataType:"JSON",
            success:function(data){

                // --- Se muestran los resultados en la tabla correpondiente.
                var index = 1;
                for (let administrador of data) {   

                    let idCategoria = administrador.idcategorias;
                    let nombreCategoria = administrador.nombre;

                    let filaTableBody = $("<tr>");
                    
                    let totalCeldas = 1;
                    let arrayCeldas = [
                        String(index), nombreCategoria,
                        $("<button>", {class:"btn btn-primary btnConsultar", "data-id-categoria":idCategoria, type:"button"}).append( $("<i>", {class:"fa fa-search"}) ), 
                        $("<button>", {class:"btn btn-primary btnEditar", "data-id-categoria":idCategoria, type:"button"}).append( $("<i>", {class:"fa fa-edit"}) ), 
                        $("<button>", {class:"btn btn-primary btnEliminar", "data-id-categoria":idCategoria, type:"button"}).append( $("<i>", {class:"fa fa-trash"}) )
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


    // --- Consultar información de la categoría.
    $(document).on("click", ".btnConsultar", function(){
        mostrarInformacionFormularioCategoria(this);
    });

    $(document).on("click", ".btnEditar", function(){
        mostrarInformacionFormularioCategoria(this, 'editar');
    });

    function mostrarInformacionFormularioCategoria(_this, operacion = 'consultar') {

        let idCategoria = $(_this).data("id-categoria");
        recetearCamposValidaciones( "#frmCategorias" );

        $.ajax({
                
            url:"/categoria/datos",
            data:{"idCategoria":idCategoria},
            method:"POST",
            dataType:"JSON",
            success:function(data){

                $("#modalCategoria").modal("show");

                data = data[0];
                let nombreCategoria = data.nombre;
                let descripcionCategoria = data.descripcion;
                let idCategoria = data.idcategorias;
                                
                $('*[name="nombreCategoria"]').val(nombreCategoria);
                $('*[name="descripcionCategoria"]').val(descripcionCategoria);

                if ( operacion != 'consultar' ) {
                    $('*[name="idCategoriaConsulta"]').val(idCategoria);
                    $(".btnGuardarActualizar").removeClass("d-none");
                    $("#frmCategorias .campoFormulario").attr("disabled", false);
                } else {
                    $(".btnGuardarActualizar").addClass("d-none");
                    $("#frmCategorias .campoFormulario").attr("disabled", true);
                }

            }

        });

    }

    // --- Eliminar categoría
    $(document).on("click", ".btnEliminar", function() {

        let idCategoria = $(this).data("id-categoria");

        bootbox.confirm({
            message: "¿En realidad desea eliminar esta categoría?",
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
                
                        url:"/categoria/eliminar",
                        data:{"idCategoria":idCategoria},
                        method:"POST",
                        dataType:"JSON",
                        success:function(data){
                            
                            if ( data["estado"] == "validaciones" ) {

                                var validacionMensaje = data.validaciones.idCategoria[0];  
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
                                actualizarTablaCategorias();

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