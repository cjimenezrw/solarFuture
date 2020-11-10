/**
 * Created by Jonathan on 21/10/2016.
 */

var inic = {};
inic.inic_recu = {};
inic.inic_recu.send = function send() {
    if (!$("#inputEmail").val().length > 0) {
        toastr.warning("Por favor verifique sus datos");
        return;
    }

    $('#sendB').button('loading');

    formdata = new FormData($("#formRecu")[0]);
    formdata.append("axn", "recoverPass");

    $.ajax({
        type: "POST",
        url: "",
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {

            $('#sendB').button('reset');

            if (data == "false") {
                toastr.error("El correo <b>" + $("#inputEmail").val() + "</b> no se encuentra en el sistema.");
                return;
            }

            if (data == 'true') {

                $(".page-content").html('<i class="icon wb-check" aria-hidden="true" style="font-size: 40px; color: #8BC34A;"></i>' +
                    '<h2>Solicitud Enviada Correctamente</h2><br><p>Por favor, <b>revise su correo electrónico</b>, se le ha enviado instrucciones.</p><br>' +
                    '<a href="'+url+'" type="button" class="btn btn-outline btn-primary">Iniciar Sesión</a>');

                toastr.success("Un nuevo correo le ha sido enviado.");
            } else {
                //ocurrio un Error en el inicio de sesion.
            }
        },
        error: function (error) {
            $('#sendB').button('reset');
            toastr.warning("Por favor, verifique su conexión");
        }
    });
};

inic.inic_recu.change = function change() {

    if (!$("#pass").val().length > 0 || !$("#passconfirm").val().length > 0 && $("#pass").val() != $("#passconfirm").val()) {
        toastr.warning("Por favor verifique sus datos");
        return;
    }
    formdata = new FormData($("#formChange")[0]);
    formdata.append("axn", "changePass");

    $.ajax({
        type: "POST",
        url: "",
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {

            if (data.success == false) {
                toastr.error("La contraseña no pudo ser modificada");
                return;
            }

            if (data.success == true) {
                $(".page-content").html('<i class="icon wb-check" aria-hidden="true" style="font-size: 40px; color: #8BC34A;"></i>' +
                    '<h2>Contraseña Restablecida</h2><br><p>Su contraseña ha sido cambiada correctamente. Ya puede iniciar sesión en su cuenta.</p><br>' +
                    '<a href="'+url+'" type="button" class="btn btn-outline btn-primary">Iniciar Sesión</a>');
            }
        },
        error: function (error) {
            toastr.warning("Por favor, verifique su conexion");
        }
    });
};

$('#formRecu').submit(function () {
    inic.inic_recu.send();
    return false;
});


function errorCode() {
    $(".page-content").html('<i class="icon wb-warning" aria-hidden="true" style="font-size: 40px; color: #607D8B;"></i>' +
        '<h2>Solicitud No Procesada</h2><br><p>Al parecer este enlace ha caducado o es inexistente.</p><br>' +
        '<a href="'+url+'" type="button" class="btn btn-outline btn-primary">Ir a Página Principal</a>');
}

function newPass(token,sUsuario) {
    $(".page-content").html('<h1>Ingrese Nueva Contraseña</h1><br><h4>Usuario: '+sUsuario+'</h4><br><p>Por favor guarde su nueva contraseña en un lugar seguro.</p>' +
        '<form id="formChange" method="post" action="#" role="form"><div class="form-group" autocomplete="off">' +
        '<input type="password" autocomplete="off" class="form-control" id="pass" name="pass" placeholder="Nueva Contraseña" data-fv-identical="true" data-fv-identical-field="passconfirm" data-fv-identical-message="Las contrase&ntilde;as no son iguales"></div>' +
        '<div class="form-group">' +
        '<input type="password" autocomplete="off" class="form-control" id="passconfirm" name="passconfirm" placeholder="Confirmar nueva Contraseña" data-fv-identical="true" data-fv-identical-field="pass" data-fv-identical-message="Las contrase&ntilde;as no son iguales"></div>' +
        '<input type="text" hidden value="'+token+'" name="token"><button type="submit" class="btn btn-block btn-primary">Cambiar Contraseña</button></form>');



    $(document).ready(function () {

        FormValidation.Validator.password = {
            validate: function(validator, $field, options) {
                var value = $field.val();
                if (value === '') {
                    return true;
                }

                // Check the password strength
                if (value.length < 8) {
                    return {
                        valid: false,
                        message: 'La contrase&ntilde;a debe tener m&aacute;s de 8 caracteres'
                    };
                }

                // The password doesn't contain any uppercase character
                if (value === value.toLowerCase()) {
                    return {
                        valid: false,
                        message: 'La contrase&ntilde;a debe contener al menos un carácter en may&uacute;scula'
                    }
                }

                // The password doesn't contain any uppercase character
                if (value === value.toUpperCase()) {
                    return {
                        valid: false,
                        message: 'La contrase&ntilde;a debe contener al menos un car&aacute;cter en min&uacute;scula'
                    }
                }

                // The password doesn't contain any digit
                if (value.search(/[0-9]/) < 0) {
                    return {
                        valid: false,
                        message: 'La contrase&ntilde;a debe contener al menos un numero'
                    }
                }

                return true;
            }
        };

        $('#formChange').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'icon wb-check',
                invalid: 'icon wb-close',
                validating: 'icon wb-time'
            },
            fields: {
                pass: {
                    validators: {
                        notEmpty: {
                            message: 'La contraseña es necesaria y no puede estar vacía'
                        },
                        password: {
                            message: 'La contraseña no es valida'
                        }
                    }
                }
            }
        });

    });


    $('#formChange').submit(function () {
        inic.inic_recu.change();
        return false;
    });
}