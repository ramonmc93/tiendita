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
                        
            $.ajax({
                
                url:"/administradores/datos",
                method:"POST",
                dataType:"JSON",
                success:function(data){

                    console.log(data);

                }
                
            });
            
        } catch (error) {

            bootbox.alert({
                message: error,
                className: 'd-flex align-items-center'
            });

        }

    });

});