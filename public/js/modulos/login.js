window.addEventListener("DOMContentLoaded", function(){
    
    // Login
    $(document).on("click", ".btnAcceder", function() {

        var frmLogin = $("#frmLogin").serialize();
        recetearCamposValidaciones("#frmLogin");

        $.ajax({

            url:"/iniciar/sesion",
            data: frmLogin,
            method:"POST",
            dataType:"JSON",
            success:function(data){
                
                try {
                    
                    if( data["estado"] == false ) {
                        throw data["mensaje"];
                    }

                    if ( data[0] != undefined ) {
                        if ( data[0]["estado"] == "validaciones" ) {
                            mostrarErrorValidaciones("frmLogin", data);
                        }
                    }

                    if( data["estado"] == true ) {
                        window.location = "/";
                    }

                } catch (error) {

                    bootbox.alert({
                        message: error,
                        className: 'd-flex align-items-center'
                    });

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