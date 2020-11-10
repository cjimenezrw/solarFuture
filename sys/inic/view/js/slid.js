/**
 * Created by Jonathan on 18/02/2017.
 */

var corechat = {};

core.chatList();

// Obtener acciones
/*$.ajax({
    type: "POST",
    url: core.SYS_URL + "sys/inic/inic-slid/panel-notificacion/",
    data: {
        axn: 'actionsList'
    },
    cache: false,
    global: false,
    success: function (result) {

        if (!result.data) {
            return;
        }

        for (var i = 0; i < result.data.length; i++) {
            var object = result.data[i];

            $('.timeline-feed').append('<li class="timeline-item"> <div class="timeline-dot bg-green-600"> <i class="icon wb-plus" aria-hidden="true"></i> </div><div class="timeline-content"> <small> <time>' + object['dFechaCreacion'] + '</time> </small> <p data-toggle="tooltip" title="' + object['sDescripcion'] + '">' + object['sDescripcion'].substring(0, 45) + '...</p></div></li>');

        }

        $('[data-toggle="tooltip"]').tooltip();
        $("#connectedCount").html(' ( ' + $(".site-sidebar-tab-content .avatar-online").length + ' )');

    },
    error: function (error) {
        //console.log(error);
    }
});*/

var input = $(".messageInput");
function sendMessage() {

    var message = $.trim(input.val());

    if (!message) {
        return;
    }

    message = emojione.toShort(message);
    var messageU = emojione.unicodeToImage(message);

    var chats = $('.chats-slide');
    var sendInput = $('#sendMessageChat');
    sendInput.addClass('loadingColor');

    input.prop('disabled', true);
    $.ajax({
        type: "POST",
        url: core.SYS_URL + "sys/inic/inic-slid/panel-notificacion/",
        global: false,
        data: {
            axn: 'sendMessage',
            skUsuarioRemitente: corechat.skUsuario,
            sMensaje: message,
            messageOriginal: messageU
        },
        cache: false,
        success: function (result) {

            if (result.hasOwnProperty('sesionOut')) {
                if (result.sesionOut) {
                    core.loginRefresh();
                }
                return;
            }

            input.prop('disabled', false);
            input.focus();
            sendInput.removeClass('loadingColor');

            if (!result.data) {
                return;
            }
            message = emojione.shortnameToImage(result.data.sMensaje);
            chats.append('<div class="chat animated fadeInUp"> <div class="chat-avatar"> <a class="avatar" data-toggle="tooltip" role="button" data-placement="right"> <img src="' + result.data.img + '"> </a> </div><div class="chat-body"> <div class="chat-content"> <p> ' + message + ' </p><time class="chat-time">' + result.data.dFechaCreacion + '</time> </div></div></div>');
            input.val('');
            $(".emoji-wysiwyg-editor").html("").focus();
            chats.animate({scrollTop: chats.get(0).scrollHeight}, 700);
        },
        error: function (error) {
            toastr.error('Ha ocurrido un error', 'Notificacion');
            input.prop('disabled', false);
            input.focus();
            $(".emoji-wysiwyg-editor").focus();
            sendInput.removeClass('loadingColor');
            //console.log(error);
        }
    });
}

function openChat(data) {
    corechat.skUsuario = data.skUsuario;
    $('.conversation-title').html(data.sNombre);
    getMessages(data.skUsuario, data.sNombre);

    $('#popUp-user-details').html('<div id="user_details"><ul class="list-group list-group-bordered"><li class="list-group-item"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><strong> Area: </strong>' + data.skArea + '</li><li class="list-group-item"><i class="fa fa-home" aria-hidden="true"></i><strong> Departamento: </strong>' + data.skDepartamento + '</li><li class="list-group-item"><i class="fa fa-phone" aria-hidden="true"></i><strong> Extension: </strong>' + data.extension + '</li><li class="list-group-item text-line"><i class="fa fa-envelope" aria-hidden="true"></i><strong> C: </strong><a href="mailto:' + data.sCorreo + '" target="_top">' + data.sCorreo + '</a></li></ul> </div>');
    $('#popUp-user-details').html('<div id="user_details"><ul class="list-group list-group-bordered"><li class="list-group-item"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><strong> Area: </strong>' + data.skArea + '</li><li class="list-group-item"><i class="fa fa-home" aria-hidden="true"></i><strong> Departamento: </strong>' + data.skDepartamento + '</li><li class="list-group-item"><i class="fa fa-phone" aria-hidden="true"></i><strong> Extension: </strong>' + data.extension + '</li><li class="list-group-item text-line"><i class="fa fa-envelope" aria-hidden="true"></i><strong> : </strong><a href="mailto:' + data.sCorreo + '" target="_top">' + data.sCorreo + '</a></li></ul> </div>');

    $('.conversation-more').webuiPopover({
        url: '#user_details',
        trigger: 'click',
        style: 'primary',
        title: 'Detalles',
        dismissible: true,
        placement: 'left',
        animation: 'pop',
        cache: false,
        offsetTop: 10,
        padding: false
    });

    setTimeout(function () {
        core.chatCount();
    }, 2000);
}

function getMessages(skUsuario, sNombre) {

    core.skUserChat = skUsuario;

    var chats = $('.chats-slide');
    chats.html('<p id="loadingChats" class="text-center">Cargando mensajes... <i class="fa fa-spinner faa-spin animated"></i></p>');

    $.ajax({
        type: "POST",
        url: core.SYS_URL + "sys/inic/inic-slid/panel-notificacion/",
        data: {
            axn: 'getMessages',
            skUsuario: skUsuario
        },
        cache: false,
        global: false,
        success: function (result) {

            if (result.data.length === 0) {
                $('#loadingChats').html('Aun no hay mensajes <i class="fa fa-comments-o" aria-hidden="true"></i>');
                return;
            }

            for (var i = 0; i < result.data.length; i++) {
                var object = result.data[i];

                var chat = (object['emisor'] === 1) ? 'chat' : 'chat chat-left';
                var message = emojione.shortnameToImage(object['sMensaje']);

                chats.prepend('<div class="' + chat + '"> <div class="chat-avatar"> <a class="avatar" data-toggle="tooltip" role="button" data-placement="right"> <img src="' + object['sFoto'] + '"> </a> </div><div class="chat-body"> <div class="chat-content"> <p> ' + message + ' </p><time class="chat-time">' + object['dFechaCreacion'] + '</time> </div></div></div>');

            }

            $('#loadingChats').hide();
            chats.animate({scrollTop: chats.get(0).scrollHeight}, 0);

        },
        error: function (error) {
            //console.log(error);
        }
    });

    $(function () {
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: core.SYS_URL + 'core/assets/v1.0.1/tpl/custom/emoji/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
    });

    core.chatCount();

    $(".emoji-wysiwyg-editor").keydown(function (event) {

        $(".emoji-wysiwyg-editor").keyup(function (event) {
            if (event.keyCode == 13 && event.shiftKey) {
                event.stopImmediatePropagation();
                event.stopPropagation();
                return false;
            }
        });

        if (event.keyCode == 13 && !event.shiftKey) {
            $(".emoji-wysiwyg-editor").blur();
            sendMessage();
            event.stopPropagation();
            event.stopImmediatePropagation();
            return false;
        }
    });

}

function getCleanedString(cadena) {
    // Definimos los caracteres que queremos eliminar
    var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";

    // Los eliminamos todos
    for (var i = 0; i < specialChars.length; i++) {
        cadena = cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
    }

    // Lo queremos devolver limpio en minusculas
    cadena = cadena.toLowerCase();

    // Quitamos espacios y los sustituimos por _ porque nos gusta mas asi
    cadena = cadena.replace(/ /g, "_");

    // Quitamos acentos y "ñ". Fijate en que va sin comillas el primer parametro
    cadena = cadena.replace(/á/gi, "a");
    cadena = cadena.replace(/é/gi, "e");
    cadena = cadena.replace(/í/gi, "i");
    cadena = cadena.replace(/ó/gi, "o");
    cadena = cadena.replace(/ú/gi, "u");
    cadena = cadena.replace(/ñ/gi, "n");
    return cadena;
}

function chat_filter(val) {
    var value = getCleanedString($(val).val());
    var filter = new RegExp(value, 'i');
    $(".list-group > a > div.media > div.media-body").filter(function () {
        $(this).each(function () {            
            var found = false;
            $(this).children().each(function () {
                var content = getCleanedString($(this).html());
                if (content.match(filter)) {
                    found = true;
                }
            });
            if (!found) {
                $(this).parent().parent().hide();
            }
            else {
                $(this).parent().parent().show();
            }
        });
    });
}

// Obtener ajustes de notificaciones
/*$.ajax({
    type: "POST",
    url: core.SYS_URL + "sys/inic/inic-slid/settings-notificacion/",
    data: {
        axn: 'noti_settings'
    },
    cache: false,
    global: false,
    success: function (result) {

        if (!result.data) {
            return;
        }

        for (var i = 0; i < result.data.length; i++) {
            var object = result.data[i];
            $('.noti_settings').append('<li class="list-group-item"> <div class="pull-right margin-top-5">' +
                '<input type="checkbox" onchange="notiConfig(this);" class="js-switch-small" id="' + object['skTipoNotificacion'] + '" data-plugin="switchery" data-size="small" ' + object['val'] + '/>' +
                '</div><h5>' + object['sNombre'] + '</h5> <p>' + object['sDescripcion'] + '</h5></li>');

            var mySwitch = new Switchery($('#' + object['skTipoNotificacion'])[0], {
                size: "small",
                color: '#0D74E9'
            });

        }
    },
    error: function (error) {
        //console.log(error);
    }
});*/

function notiConfig(obj) {
    var estatus = $('#' + obj.id).prop('checked');
    var id = obj.id;

    $.ajax({
        type: "POST",
        url: core.SYS_URL + "sys/inic/inic-slid/settings-notificacion/",
        data: {
            axn: 'notiConfig',
            id: id,
            estatus: estatus
        },
        cache: false,
        global: false,
        success: function (result) {

            $.each( result.res, function( key, channel ) {
                if (estatus){
                    pusher.subscribe(channel);
                }else {
                    pusher.unsubscribe(channel);
                }
            });

            if (!result) {
                toastr.error('Ha Ocurrido Un Error');
                if (estatus) {
                    $('#' + obj.id).prop('checked', false);
                } else {
                    $('#' + obj.id).prop('checked', true);
                }
            }
        },
        error: function (error) {
            toastr.error('Ha Ocurrido Un Error');
            if (estatus) {
                $('#' + obj.id).prop('checked', false);
            } else {
                $('#' + obj.id).prop('checked', true);
            }
        }
    });
}