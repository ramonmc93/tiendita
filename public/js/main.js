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
    $("#"+idFormulario+" input[type='text'], input[type='email'], textarea").each(function(i, j){
        arrayPropiedadName[i] = j.name;
    });

    return arrayPropiedadName;

}