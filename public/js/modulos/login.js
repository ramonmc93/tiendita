window.addEventListener("DOMContentLoaded", function(){
    
    // Login
    $(document).on("click", ".btnAcceder", function() {

        var frmLogin = $("#frmLogin").serialize();

        $.ajax({

            url:"/iniciar/sesion",
            data: frmLogin,
            method:"POST",
            success:function(data){
                
                try {
                    
                    if( data["estado"] == false ) {
                        throw data["mensaje"];
                    }

                } catch (error) {
                    alert(error);
                }

            }

        });

    });


    // Cerrar sesión
    $(document).on("click", ".cerrarSesion", function() {
        
        $.ajax({

            url:"/usuario/cerrar-sesion",
            method:"POST",
            success:function(data) {
                
                try {
                    
                    if( data["estado"] == false ) {
                        throw data["mensaje"];
                    }

                    window.location = "/login";

                } catch (error) {
                    alert(error);
                }

            }

        });

    });

});