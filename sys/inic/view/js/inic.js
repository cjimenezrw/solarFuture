var inic = {};

/*
 * Modulo inic-sesi (iniciar-session)
 */
inic.inic_sesi = {};

//Funcion de enviar datos.
inic.inic_sesi.send = function send() {
    if (!$("#inputPassword").val().length > 0 && !$("#inputEmail").val().length > 0) {
        toastr.warning("Por favor verifique sus datos");
        return;
    }
    if (grecaptcha.getResponse().length === 0) {
        $('.text-xs-center').animateCss('shake');
        toastr.warning("Por favor verifique el captcha");
        return;
    }
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData($("#formSesion")[0]);
        formdata.append("axn", "verificarSession");

    }
    
    toastr.clear();
    toastr.info('Procesando Información. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});

    $.ajax({
        type: "POST",
        url: "",
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {

            if (data == "false") {
                toastr.clear();
                toastr.error("El usuario o la contraseña son incorrectos.");
                grecaptcha.reset();
                return;
            }

            if (data != '') {
                toastr.clear();
                toastr.success("Seleccione su Perfil.");
                $('#principal').hide();
                $('#message').show();
                $('#perfiles').show();
                var $boton = "";
                $.each(data, function (i, item) {
                    $boton += ' <div class="col-sm-12"> <div class="widget">' +
                        '<div onclick="inic.inic_sesi.iniciar(this);" id="' + data[i].skEmpresaSocio + '" class="widget-content profileSelect padding-vertical-10 padding-horizontal-30 bg-blue-600">' +
                        '<div class="widget-watermark darker font-size-60 margin-15"><i class="icon wb-users" aria-hidden="true"></i></div><div class="counter counter-md counter-inverse text-left">' +
                        '<div class="counter-number-group"> <span class="counter-number"></span> <span class="counter-number-related text-capitalize">' + data[i].sNombreEmpresa + '</span></div>' +
                        '<input type="hidden" id="skUsuario" name="skUsuario" value="' + data[i].skUsuario + '">' +
                        '<div class="counter-label text-capitalize">' + data[i].sNombreEmpresa + '</div></div></div></div></div>';
                });
                $("#elejirPerfil").append($boton);
            } else {
                toastr.error("No tiene perfiles asignados.");
                return;
            }
        }
    });
};

//Funcion de Iniciar Session.
inic.inic_sesi.iniciar = function iniciar(e) {
    $("#perfiles").addClass("disabledContent");
    toastr.clear();
    //toastr.info('Iniciando Sesión. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});

    //inic.inic_sesi.showLoad();

    var idEmpresa = $(e).attr("id");
    var password = $('#inputPassword').val();
    var skUsuario = $('#skUsuario').val();

    inic.inic_sesi.showLoad();

    $.ajax({
        type: "POST",
        url: "",
        data: {
            axn: 'iniciarSession',
            skEmpresaSocio: idEmpresa,
            password: password,
            skUsuario: skUsuario
        },
        success: function (data) {
            if (data != '') {
                location.assign(data);
            }
        }
    });

};

// Enviar datos del formulario de inicio de sesión.
$('#formSesion').submit(function () {
    inic.inic_sesi.send();
    return false;
});


$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function () {
            $(this).removeClass('animated ' + animationName);
        });
    }
});

function capLock(e) {
    var kc = e.keyCode ? e.keyCode : e.which;
    var sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true : false);
    if (((kc >= 65 && kc <= 90) && !sk) || ((kc >= 97 && kc <= 122) && sk))
        $('#divMayus').css('visibility', 'visible');
    else
        $('#divMayus').css('visibility', 'hidden');
}

inic.inic_sesi.showLoad = function showLoad() {

    if(typeof inic_sesi_view != "undefined"){

        if(inic_sesi_view == 'inic_sesi_compact'){
            $('#message').hide();
            loading();
            return true;
        }

        $('<div class="load_bg_anim" hidden><div class="textLoad"> Conectando</div><div><div class="textLoad"> Conectando</div><div class="box"> <div class="comp"></div><div class="loader_login"></div><div class="con"></div><div class="byte"></div><div class="server"></div></div>').insertBefore(".page-content");
        $('.page-content').fadeOut("slow");
        $('.load_bg_anim').fadeIn(1000);
        $(function () {
            var count = 0;
            var wordsArray = ["Configurando Portal", "Espere un momento", "Configurando Perfil", "Configurando Entorno", "Casi terminamos"];
            setInterval(function () {
                count++;
                $(".textLoad").fadeOut(500, function () {
                    $(this).text(wordsArray[count % wordsArray.length]).fadeIn(500);
                });
            }, 3500);
        });
        return true;

    }else{

        $('<div class="load_bg_anim" hidden><div class="textLoad"> Conectando</div><div><div class="textLoad"> Conectando</div><div class="box"> <div class="comp"></div><div class="loader_login"></div><div class="con"></div><div class="byte"></div><div class="server"></div></div>').insertBefore(".page-content");
        $('.page-content').fadeOut("slow");
        $('.load_bg_anim').fadeIn(1000);
        $(function () {
            var count = 0;
            var wordsArray = ["Configurando Portal", "Espere un momento", "Configurando Perfil", "Configurando Entorno", "Casi terminamos"];
            setInterval(function () {
                count++;
                $(".textLoad").fadeOut(500, function () {
                    $(this).text(wordsArray[count % wordsArray.length]).fadeIn(500);
                });
            }, 3500);
        });
        return true;
    }
    
};