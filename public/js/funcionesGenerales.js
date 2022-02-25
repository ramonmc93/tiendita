// --- Función para validar números enteros.
function validarNumeroEntero(numero) {
    var regex = new RegExp(/^[0-9]+$/);

    if ( regex.test(numero) ) {
        return true;
    } 

    return false;

}

// --- Función para validar el correo electrónico.
function validacionCorreoElectronico(email) {
    var regex = new RegExp( /^\w+([\.-]?\w+)+@\w+([\.-]?\w+)+(\.[a-zA-Z0-9]{2,3})+$/ );

    if ( regex.test(email) ) {
        return true;
    }

    return false;

}

// --- Función para validar el código postal
function validarCodigoPostal(codigoPostal) {
    var regex = new RegExp( /^[0-9]{5}?$/ );

    if ( regex.test(codigoPostal) ) {
        return true;
    }
    
    return false;
    
}


// --- Mostrar contraseña
$(document).on("click", ".btnMostrarPassword", function(){
    var boolOcultarPassword = $(this)[0].dataset.ocultarPassword;
    var inputName = $(this).data("input-name");
    var inputTypePassword = $("input[name="+inputName+"]");
    
    if ( boolOcultarPassword == "false" ) {
        inputTypePassword.attr({type:"mostrarPassword"});
        $(this).attr({"data-ocultar-password":true});

    } if ( boolOcultarPassword == "true" ) {
        inputTypePassword.attr({type:"password"});
        $(this).attr({"data-ocultar-password":false});
    }
});