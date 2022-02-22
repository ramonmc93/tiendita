window.addEventListener("DOMContentLoaded", function(){

    $('#fechaNacimiento').datetimepicker({
        format: 'L'
    });

    // ---- Guardar / Modificar administrador.
    $(document).on("click", ".btnGuardarActualizar", function(){

        try {
            
            var frmAdministrador = $("#frmAdministradores").serialize();
            
            $.ajax({
                
                url:"/administradores/guardar-modificar",
                method:"POST",
                data:frmAdministrador,
                dataType:"JSON",
                success:function(data){
                    
                    if ( data["estado"] == "validaciones" ) {

                        var arrayPropiedadName = obtenerPropiedadNameCamposFormularios("frmAdministradores");

                        for ( let propName of arrayPropiedadName ) {   

                            var validacion = data.validaciones[propName];     
                            var campoActual = $("*[name='"+propName+"']")[0];

                            if ( validacion != undefined ) {                                
                                campoActual.classList.add("invalido");
                            } else {
                                campoActual.classList.remove("invalido");
                            }                    

                        }

                    }

                }
                
            });
            
        } catch (error) {
            alert(error);
        }

    });

});