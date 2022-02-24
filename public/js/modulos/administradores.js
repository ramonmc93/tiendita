window.addEventListener("DOMContentLoaded", function(){

    $('#fechaNacimiento').datetimepicker({
        format: 'L'
    });

    $(document).on("click", ".btnAgregarAdministrador", function(){
        $("#modalAdmnistrador").modal("show");
    });

    // ---- Guardar / Modificar administrador.
    $(document).on("click", ".btnGuardarActualizar", function(){

        try {
            
            let frmAdministrador = $("#frmAdministradores").serialize();
            recetearCamposValidaciones("#frmAdministradores");
            
            $.ajax({
                
                url:"/administradores/guardar-modificar",
                method:"POST",
                data:frmAdministrador,
                dataType:"JSON",
                success:function(data){

                    if ( data[0] != undefined ) {
                        if ( data[0]["estado"] == "validaciones" ) {
                            mostrarErrorValidaciones("frmAdministradores", data);
                        }
                    }

                    if ( data["estado"] == "email" ) {
                        mostrarMensajeError( data["mensaje"] );
                    }

                    if ( data["estado"] == "registroCorrecto" ) {

                        $("#modalAdmnistrador").modal("hide");

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


    // --- Actualizar tabla administradores
    $(document).on("click", ".btnActualizarTabla", function(){
    
        try {
            
            let tbody = $("#tablaAdministradores tbody");
            tbody.empty();

            $.ajax({
                
                url:"/administradores/datos",
                data:{"tipoPeticion":'post'},
                method:"POST",
                dataType:"JSON",
                success:function(data){

                    // --- Se muestran los resultados en la tabla correpondiente.
                    var index = 1;
                    for (let administrador of data) {   

                        let idAdministrador = administrador.idadministradores;
                        let nombre = administrador.nombre;
                        let apellidoPaterno = administrador.apellidopaterno;
                        let apellidoMaterno = administrador.apellidomaterno;
                        let nombreCompleto = nombre+" "+apellidoPaterno+" "+apellidoMaterno;
                        let tipoUsuario = administrador.tipousuario;
                        let email = administrador.email;

                        let filaTableBody = $("<tr>");
                        
                        let totalCeldas = 1;
                        let arrayCeldas = [
                            String(index), nombreCompleto, tipoUsuario, email, 
                            $("<button>", {class:"btn btn-primary btnConsultar", "data-id-administrador":idAdministrador, type:"button"}).append( $("<i>", {class:"fa fa-search"}) ), 
                            $("<button>", {class:"btn btn-primary btnEditar", "data-id-administrador":idAdministrador, type:"button"}).append( $("<i>", {class:"fa fa-edit"}) ), 
                            $("<button>", {class:"btn btn-primary btnEliminar", "data-id-administrador":idAdministrador, type:"button"}).append( $("<i>", {class:"fa fa-trash"}) )
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
            
        } catch (error) {

            bootbox.alert({
                message: error,
                className: 'd-flex align-items-center'
            });

        }

    });


    // --- Consultar información del administrador.
    $(document).on("click", ".btnConsultar", function(){

        let idAdministrador = $(this).data("id-administrador");
        
        $.ajax({
                
            url:"/administrador/datos",
            data:{"idAdministrador":idAdministrador},
            method:"POST",
            dataType:"JSON",
            success:function(data){

                $("#modalAdmnistrador").modal("show");

                data = data[0];
                let nombre = data.nombre;
                let apellidoPaterno = data.apellidopaterno;
                let apellidoMaterno = data.apellidomaterno;
                let fechaNacimiento = data.fechanacimiento;
                let direccion = data.direccion;
                let codigoPostal = data.codigopostal;
                let telCelular = data.telcelular;
                let telCasa = data.telcasa;
                let tipoUsuario = data.tipousuario;
                let email = data.email;
                let idAdministrador = data.idadministradores;
                                
                $('*[name="nombre"]').val(nombre);
                $('*[name="apellidoPaterno"]').val(apellidoPaterno);
                $('*[name="apellidoMaterno"]').val(apellidoMaterno);
                $('*[name="telCelular"]').val(telCelular);
                $('*[name="telCasa"]').val(telCasa);
                $('*[name="email"]').val(email);
                $('*[name="fechaNacimiento"]').val(fechaNacimiento);
                $('*[name="direccion"]').val(direccion);
                $('*[name="codigoPostal"]').val(codigoPostal);
                $('*[name="idAdministradorConsulta"]').val(idAdministrador);

                if ( tipoUsuario == "A" ){
                    $("#tipoAdministrador")[0].checked = true;
                } else {
                    $("#tipoSuperAdministrador")[0].checked = true;
                }

            }

        });

    });

});