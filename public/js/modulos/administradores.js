window.addEventListener("DOMContentLoaded", function(){

    $('#fechaNacimiento').datetimepicker({
        format: 'L'
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
                    
                    if ( data[0]["estado"] == "validaciones" ) {
                        mostrarErrorValidaciones("frmAdministradores", data);
                    }

                }
                
            });
            
        } catch (error) {
            alert(error);
        }

    });

});