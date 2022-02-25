window.addEventListener("DOMContentLoaded", function() {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", ".btnCerrarNotificacion", function(){
        $(".notificacionesError").addClass("d-none");
    });
    
});

function obtenerPropiedadNameCamposFormularios(idFormulario) {

    let arrayPropiedadName = [];
    $("#"+idFormulario+" .campoFormulario").each(function(i, j){
        arrayPropiedadName[i] = j.name;
    });

    return arrayPropiedadName;

}

function recetearCamposValidaciones( idFormulario = "" ) {

    if ( idFormulario != "" ) {

        // --- Mostrar validaciones.
        let notificacionesError = $(".notificacionesError ");
        notificacionesError.addClass("d-none");
        let contenedorNotificaciones = $(".contenedorNotificaciones");
        contenedorNotificaciones.empty();
    
        $(idFormulario+" *.invalido").removeClass("invalido");

    }

}

// --- Función para mostrar los errores de las validaciones del formulario correspondiente con los datos recividos.
function mostrarErrorValidaciones( frm = "", data, type = 0 ) {

    if ( frm != "" ) {

        let arrayPropiedadName = obtenerPropiedadNameCamposFormularios(frm);
        let notificacionesError = $(".notificacionesError ");
        let contenedorNotificaciones = $(".contenedorNotificaciones");
        let hayValidaciones = false;
        
        if ( type == 0 ) {
            var dataType0 = data[0];
            var dataType1 = data[1];
        } else {
            var dataType0 = data;
            var dataType1 = data;
        }

        // --- Otras validaciones.
        if ( dataType1 != undefined && Object.values(dataType1).length > 0 ) {
            if ( dataType1.propiedadesName != undefined ) {
                for (let name of dataType1.propiedadesName) {
                    dataType0.validaciones[name] = [ dataType1.textoValidacion[name] ];
                }
            }
        }
        
        for ( let propName of arrayPropiedadName ) {   
            
            // console.log(propName);

            let validacion = dataType0.validaciones[propName];     
            let campoActual = $("*[name='"+propName+"']");
    
            if ( validacion != undefined ) {            
    
                let contenedorValidacion = $("<div>", {class:"d-flex"});
                let span = $("<span>", {text:validacion[0], class:"ml5"});  
                let i = $("<i>", {class:"fa fa-times"});
    
                contenedorValidacion.append(span);
                span.before(i);
                contenedorNotificaciones.append(contenedorValidacion);          
                campoActual[0].classList.add("invalido");
    
                hayValidaciones = true;

                if ( campoActual[0].type == "radio" || campoActual[0].type == "checkbox" ) {
                    let padreElemento = campoActual.parent().parent()[0];
                    padreElemento.classList.add("invalido");
                }
    
            } else {
                campoActual[0].classList.remove("invalido");
            }                    
    
        }
        
        // --- Si hay errores se muestra la alerta.
        if ( hayValidaciones ) {
            notificacionesError.removeClass("d-none").addClass("d-block");
        }

    }

}


// --- Mostrar notificación/mensaje de error
function mostrarMensajeError( mensaje = "" ) {

    let notificacionesError = $(".notificacionesError ");
    notificacionesError.removeClass("d-none").addClass("d-block");

    let contenedorValidacion = $("<div>", {class:"d-flex"});
    let span = $("<span>", {text:mensaje, class:"ml5"});  
    let i = $("<i>", {class:"fa fa-times"});
    
    contenedorValidacion.append(span);
    span.before(i);

    let contenedorNotificaciones = $(".contenedorNotificaciones");
    contenedorNotificaciones.append(contenedorValidacion);          
    
}