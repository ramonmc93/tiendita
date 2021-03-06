window.addEventListener("DOMContentLoaded", function(){

    $('#fechaNacimiento').datetimepicker({
        format: 'L'
    });

    $(document).on("click", ".btnAgregarAdministrador", function() {
        $("#modalAdmnistrador").modal("show");
        $("input[name='idAdministradorConsulta']").removeAttr("value");
        $("#frmAdministradores .campoFormulario").val("");
        $("#tipoAdministrador")[0].checked = true;
    });

    // ---- Guardar / Modificar administrador.
    $(document).on("click", ".btnGuardarActualizar", function(){

        $("#frmAdministradores *.invalido").removeClass("invalido");
        $(".contenedorNotificaciones").empty();

        try {
            
            let campoNombreAdministrador = $("input[name='nombre']");
            let nombreAdministradorValor = campoNombreAdministrador.val().trim();
            if ( nombreAdministradorValor.length < 3 || nombreAdministradorValor.length > 25 ) {
                campoNombreAdministrador.addClass("invalido");
                throw 'El nombre no puede ser vacío y debe de tener una longitud mínima de 3 caracteres máximo 25.';
            }

            let campoApellidoPaternoAdministrador = $("input[name='apellidoPaterno']");
            let apellidoPaternoAdministradorValor = campoApellidoPaternoAdministrador.val().trim();
            if ( apellidoPaternoAdministradorValor.length < 3 || apellidoPaternoAdministradorValor.length > 25 ) {
                campoApellidoPaternoAdministrador.addClass("invalido");
                throw 'El apellido paterno no puede ser vacío y debe de tener una longitud mínima de 3 caracteres máximo 25.';
            }

            let campoApellidoMaternoAdministrador = $("input[name='apellidoMaterno']");
            let apellidoMaternoAdministradorValor = campoApellidoMaternoAdministrador.val().trim();
            if ( apellidoMaternoAdministradorValor != "" && (apellidoMaternoAdministradorValor.length < 3 || apellidoMaternoAdministradorValor.length > 25) ) {
                campoApellidoMaternoAdministrador.addClass("invalido");
                throw 'El apellido materno debe de tener una longitud mínima de 3 caracteres máximo 25.';
            }

            let campoTelefonoCelularAdministrador = $("input[name='telCelular']");
            let telefonoCelularAdministradorValor = campoTelefonoCelularAdministrador.val().trim();
            if ( telefonoCelularAdministradorValor.length < 10 || !validarNumeroEntero(telefonoCelularAdministradorValor) ) {
                campoTelefonoCelularAdministrador.addClass("invalido");
                throw 'El teléfono celulular debe ser numérico de 10 dígitos.';
            }

            let campoTelefonoCasaAdministrador = $("input[name='telCasa']");
            let telefonoCasaAdministradorValor = campoTelefonoCasaAdministrador.val().trim();
            if ( telefonoCasaAdministradorValor != "" && telefonoCasaAdministradorValor.length < 10 && !validarNumeroEntero(telefonoCasaAdministradorValor) ) {
                campoTelefonoCasaAdministrador.addClass("invalido");
                throw 'El teléfono de casa debe ser numérico de 10 dígitos.';
            }

            let campoEmailAdministrador = $("input[name='email']");
            let emailAdministradorValor = campoEmailAdministrador.val().trim();
            if ( !validacionCorreoElectronico(emailAdministradorValor) ) {
                campoEmailAdministrador.addClass("invalido");
                throw 'El correo electrónico es incorrecto.';
            }

            let campoFechaNacimientoAdministrador = $("input[name='fechaNacimiento']");
            let fechaNacimientoAdministradorValor = campoFechaNacimientoAdministrador.val().trim();
            if (fechaNacimientoAdministradorValor == "" || !( moment( new Date(fechaNacimientoAdministradorValor) ).isValid() ) ) {
                campoFechaNacimientoAdministrador.addClass("invalido");
                throw "La fecha de nacimiento es incorrecta.";
            }

            let campoDireccionAdministrador = $("textarea[name='direccion']");
            let direccionAdministradorValor = campoDireccionAdministrador.val().trim();
            if (direccionAdministradorValor == "" || direccionAdministradorValor.length < 15) {
                campoDireccionAdministrador.addClass("invalido");
                throw "La dirección debe de tener una longitud mínima de 15 caracteres.";
            }

            let campoCodigoPostalAdministrador = $("input[name='codigoPostal']");
            let codigoPostalAdministradorValor = campoCodigoPostalAdministrador.val().trim();
            if (!validarCodigoPostal(codigoPostalAdministradorValor)) {
                campoCodigoPostalAdministrador.addClass("invalido");
                throw "El código postal es incorrecto.";
            }

            let campoTipoUsuarioAdministrador = $("input[name='tipoUsuario']:checked");
            let tipoUsuarioAdministradorValor = campoTipoUsuarioAdministrador.val().trim();
            if (tipoUsuarioAdministradorValor != "SA" && tipoUsuarioAdministradorValor != "A") {
                campoTipoUsuarioAdministrador.parent().parent().addClass("invalido");
                throw "El tipo de usuario seleccionado es incorrecto.";
            }

            let campoNombreUsuarioAdministrador = $("input[name='nombreUsuario']");
            let nombreUsuarioAdministradorValor = campoNombreUsuarioAdministrador.val().trim();
            if ( nombreUsuarioAdministradorValor.length < 5 || nombreUsuarioAdministradorValor.length > 25 ) {
                campoNombreUsuarioAdministrador.addClass("invalido");
                throw "El nombre de usuario debe de tener una longitud mínima de 5 caracteres y máxima de 25 caracteres.";
            }

            let idAdministradorConsulta = $("input[name='idAdministradorConsulta']").val().trim();
            let campoPasswordAdministrador = $("input[name='passwordAdministrador']");
            let passwordAdministradorValor = campoPasswordAdministrador.val().trim();
            if ( passwordAdministradorValor.length < 5 && idAdministradorConsulta == "" ) {
                campoPasswordAdministrador.addClass("invalido");
                throw "La contraseña debe de tener una longitud mínima de 5 caracteres.";
            }

            let frmAdministrador = $("#frmAdministradores").serialize();
            
            $.ajax({
                
                url:"/administradores/guardar-modificar",
                method:"POST",
                data:frmAdministrador,
                dataType:"JSON",
                success:function(data){

                    if ( data[0] != undefined ) {
                        if ( data[0]["estado"] == "validaciones" ) {
                            mostrarErrorValidaciones("frmAdministradores", data);
                        }
                    }

                    if ( data["estado"] == "email" || data["estado"] == "nombreUsuario" ) {
                        $("input[name='"+data["estado"]+"']").addClass("invalido");
                        mostrarMensajeError( data["mensaje"] );
                    }

                    if ( data["estado"] == "registroActualizacionCorrecto" ) {

                        $("#modalAdmnistrador").modal("hide");

                        bootbox.alert({
                            message: data["mensaje"],
                            className: 'd-flex align-items-center'
                        });

                        recetearCamposValidaciones("#frmAdministradores");
                        actualizarTablaAdministradores();

                    }

                    if ( data["estado"] == false ) {

                        $("#modalAdmnistrador").modal("hide");

                        bootbox.alert({
                            message: data["mensaje"],
                            className: 'd-flex align-items-center'
                        });

                    }

                }
                
            });
            
        } catch (error) {

            bootbox.alert({
                message: error,
                className: 'd-flex align-items-center colorFondoError'
            });

        }

    });


    // --- Actualizar tabla administradores
    $(document).on("click", ".btnActualizarTabla", function(){
        actualizarTablaAdministradores();
    });

    function actualizarTablaAdministradores() {

        let tbody = $("#tablaAdministradores tbody");
            tbody.empty();

        $.ajax({
            
            url:"/administradores/datos",
            data:{"tipoPeticion":'post'},
            method:"POST",
            dataType:"JSON",
            success:function(data){

                // --- Se muestran los resultados en la tabla correpondiente.
                var index = 1;
                for (let administrador of data) {   

                    let idAdministrador = administrador.idadministradores;
                    let nombre = administrador.nombre;
                    let apellidoPaterno = administrador.apellidopaterno;
                    let apellidoMaterno = administrador.apellidomaterno;
                    let nombreCompleto = nombre+" "+apellidoPaterno+" "+apellidoMaterno;
                    let tipoUsuario = administrador.tipousuario;
                    let email = administrador.email;

                    let filaTableBody = $("<tr>");
                    
                    let totalCeldas = 1;
                    let arrayCeldas = [
                        String(index), nombreCompleto, tipoUsuario, email, 
                        $("<button>", {class:"btn btn-primary btnConsultar", "data-id-administrador":idAdministrador, type:"button"}).append( $("<i>", {class:"fa fa-search"}) ), 
                        $("<button>", {class:"btn btn-primary btnEditar", "data-id-administrador":idAdministrador, type:"button"}).append( $("<i>", {class:"fa fa-edit"}) ), 
                        $("<button>", {class:"btn btn-primary btnEliminar", "data-id-administrador":idAdministrador, type:"button"}).append( $("<i>", {class:"fa fa-trash"}) )
                    ];

                    for (let elemento of arrayCeldas) {
                        
                        let td = $("<td>");  

                        if ( elemento[0].type == "button" ) {
                            td.append(elemento);  
                        } else {
                            td.text(elemento);  
                        }

                        filaTableBody.append(td);
                        totalCeldas++;
                    }

                    tbody.append( filaTableBody );

                    index++;

                }

            }
            
        });

    }


    // --- Consultar información del administrador.
    $(document).on("click", ".btnConsultar", function(){
        mostrarInformacionFormularioAdministrador(this);
    });

    $(document).on("click", ".btnEditar", function(){
        mostrarInformacionFormularioAdministrador(this, 'editar');
    });

    function mostrarInformacionFormularioAdministrador(_this, operacion = 'consultar') {

        let idAdministrador = $(_this).data("id-administrador");
        recetearCamposValidaciones( "#frmAdministradores" );

        $.ajax({
                
            url:"/administrador/datos",
            data:{"idAdministrador":idAdministrador},
            method:"POST",
            dataType:"JSON",
            success:function(data){

                $("#modalAdmnistrador").modal("show");

                data = data[0];
                let nombre = data.nombre;
                let apellidoPaterno = data.apellidopaterno;
                let apellidoMaterno = data.apellidomaterno;
                let fechaNacimiento = data.fechanacimiento;
                let direccion = data.direccion;
                let codigoPostal = data.codigopostal;
                let telCelular = data.telcelular;
                let telCasa = data.telcasa;
                let tipoUsuario = data.tipousuario;
                let email = data.email;
                let idAdministrador = data.idadministradores;
                let nombreUsuario = data.nombreusuario;

                $('*[name="nombre"]').val(nombre);
                $('*[name="apellidoPaterno"]').val(apellidoPaterno);
                $('*[name="apellidoMaterno"]').val(apellidoMaterno);
                $('*[name="telCelular"]').val(telCelular);
                $('*[name="telCasa"]').val(telCasa);
                $('*[name="email"]').val(email);
                $('*[name="fechaNacimiento"]').val(fechaNacimiento);
                $('*[name="direccion"]').val(direccion);
                $('*[name="codigoPostal"]').val(codigoPostal);
                $('*[name="nombreUsuario"]').val(nombreUsuario);

                if ( operacion != 'consultar' ) {
                    $('*[name="idAdministradorConsulta"]').val(idAdministrador);
                    $(".btnGuardarActualizar").removeClass("d-none");
                    $("#frmAdministradores .campoFormulario").attr("disabled", false);
                } else {
                    $(".btnGuardarActualizar").addClass("d-none");
                    $("#frmAdministradores .campoFormulario").attr("disabled", true);
                }

                if ( tipoUsuario == "A" ){
                    $("#tipoAdministrador")[0].checked = true;
                } else {
                    $("#tipoSuperAdministrador")[0].checked = true;
                }

            }

        });

    }

    // --- Eliminar administrador
    $(document).on("click", ".btnEliminar", function() {

        let idAdministrador = $(this).data("id-administrador");

        bootbox.confirm({
            message: "¿En realidad desea eliminar este administrador?",
            buttons: {
                confirm: {
                    label: 'Si',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            className: 'd-flex align-items-center',
            callback: function (result) {
                if ( result ) {
                                        
                    $.ajax({
                
                        url:"/administrador/eliminar",
                        data:{"idAdministrador":idAdministrador},
                        method:"POST",
                        dataType:"JSON",
                        success:function(data){
                            
                            if ( data["estado"] == "validaciones" ) {

                                var validacionMensaje = data.validaciones.idAdministrador[0];  
                                bootbox.alert({
                                    message: validacionMensaje,
                                    className: 'd-flex align-items-center'
                                });
                                
                            }

                            if ( data["estado"] == true ) {

                                var validacionMensaje = data["mensaje"];
                                bootbox.alert({
                                    message: validacionMensaje,
                                    className: 'd-flex align-items-center'
                                });

                                console.log(1);
                                actualizarTablaAdministradores();

                            } else {

                                var validacionMensaje = data["mensaje"];
                                bootbox.alert({
                                    message: validacionMensaje,
                                    className: 'd-flex align-items-center'
                                });

                            }

                        }

                    });
                    
                }
            }
        });

    });

});