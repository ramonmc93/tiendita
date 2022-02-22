window.addEventListener("DOMContentLoaded", function(){

    $('#fechaNacimiento').datetimepicker({
        format: 'L'
    });

    // ---- Guardar / Modificar administrador.
    $(document).on("click", ".btnGuardarActualizar", function(){

        try {
            
            let frmAdministrador = $("#frmAdministradores").serialize();
            let notificacionesError = $(".notificacionesError ");
            notificacionesError.addClass("d-none");
            let contenedorNotificaciones = $(".contenedorNotificaciones");
            contenedorNotificaciones.empty();

            $("#frmAdministradores *.invalido").removeClass("invalido");

            $.ajax({
                
                url:"/administradores/guardar-modificar",
                method:"POST",
                data:frmAdministrador,
                dataType:"JSON",
                success:function(data){
                    
                    if ( data["estado"] == "validaciones" ) {

                        let arrayPropiedadName = obtenerPropiedadNameCamposFormularios("frmAdministradores");
                        let hayValidaciones = false;

                        for ( let propName of arrayPropiedadName ) {   

                            let validacion = data.validaciones[propName];     
                            let campoActual = $("*[name='"+propName+"']")[0];

                            if ( validacion != undefined ) {            

                                let contenedorValidacion = $("<div>", {class:"d-flex"});
                                let span = $("<span>", {text:validacion[0], class:"ml5"});  
                                let i = $("<i>", {class:"fa fa-times"});

                                contenedorValidacion.append(span);
                                span.before(i);
                                contenedorNotificaciones.append(contenedorValidacion);          
                                campoActual.classList.add("invalido");

                                hayValidaciones = true;

                            } else {
                                campoActual.classList.remove("invalido");
                            }                    

                        }

                        if ( hayValidaciones ) {
                            notificacionesError.removeClass("d-none").addClass("d-block");
                        }

                    }

                }
                
            });
            
        } catch (error) {
            alert(error);
        }

    });

});