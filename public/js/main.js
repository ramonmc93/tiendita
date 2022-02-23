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
    $("#"+idFormulario+" input[type='text'], input[type='email'], input[type='password'], textarea").each(function(i, j){
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

        console.log(data);

        let arrayPropiedadName = obtenerPropiedadNameCamposFormularios(frm);
        let notificacionesError = $(".notificacionesError ");
        let contenedorNotificaciones = $(".contenedorNotificaciones");
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