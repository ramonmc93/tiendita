// --- Actualizar select categorías.
$(document).on("click", ".btnActualizarTabla", function(){

    $.ajax({
            
        url:"/producto/registrados-cargar-cards",
        data:{tipoPeticion:"post"},
        method:"POST",
        dataType:"html",
        success:function(data){
            $(".listaProductosRegistrados").empty().html(data);
        }

    });

});