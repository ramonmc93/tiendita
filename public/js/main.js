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

    var arrayPropiedadName = [];
    $("#"+idFormulario+" .obligatorio").each(function(i, j){
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
function mostrarErrorValidaciones( frm = "", data ) {

    if ( frm != "" ) {

        let arrayPropiedadName = obtenerPropiedadNameCamposFormularios(frm);
        let notificacionesError = $(".notificacionesError ");
        let contenedorNotificaciones = $(".contenedorNotificaciones");
        let hayValidaciones = false;
        
        // --- Otras validaciones.
        let otrasValidaciones = data[1].propiedadesName;
        if ( otrasValidaciones != undefined ) {
            let validacionIniciales = data[0].validaciones;
            for (let name of otrasValidaciones) {
                data[0].validaciones[name] = [ data[1].textoValidacion[name] ];
            }
        }
        
        for ( let propName of arrayPropiedadName ) {   
    
            let validacion = data[0].validaciones[propName];     
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