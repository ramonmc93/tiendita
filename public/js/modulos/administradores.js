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
                    console.log(data);
                }
                
            });
            
        } catch (error) {
            alert(error);
        }

    });

});