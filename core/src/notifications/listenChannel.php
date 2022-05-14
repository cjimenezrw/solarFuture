<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 27/01/2017
 * Time: 03:22 PM
 */

$sound = ASSETS_PATH . ASSETS_VERSION . '/custom/sounds/alert.mp3';
$sound_chat = ASSETS_PATH . ASSETS_VERSION . '/custom/sounds/chat_sound.mp3';
$img_system = ASSETS_PATH . ASSETS_VERSION . '/custom/img/woodward-logo.png';
?>

<script>
    // Pusher - Notificaciones
    //Pusher.logToConsole = true;

    var pusher = new Pusher('<?php echo PUSHER_KEY; ?>', {
        encrypted: true
    });
    var channels = [];
    <?php
      if(isset($_SESSION["usuario"]["canales"])){
        foreach ($_SESSION["usuario"]["canales"] as $key => $value) {  ?>
    channels['<?php echo $key; ?>'] = pusher.subscribe('<?php echo $value; ?>');
    <?php } }?>
    channels['si'] = pusher.subscribe('si');
    var callback = function (data) {
        if (typeof data != 'object') {
            data = JSON.parse(data);
        }
        var dataJson = data;
        if (data.hasOwnProperty('iv') && data.hasOwnProperty('ct')) {
            try {
                if (typeof data == 'object') {
                    data = JSON.stringify(data);
                }
                dataJson = JSON.parse(eval(CryptoJS.AES.decrypt(data, '<?php echo $_SESSION["usuario"]["CRYKEY"]; ?>', {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8)));
            } catch (e) {
            }
        }

        if (dataJson.hasOwnProperty('excluirUsuarios')) {
            if (dataJson.excluirUsuarios.hasOwnProperty(core.skUsuario)) {
                return false;
            }
        }

        switch (dataJson.skTipoNotificacion) {
            case 'SISTEM':
                var skNotificacion = dataJson.skNotificacion;
                var sUrl = '/' + core.DIR_PATH + dataJson.sUrl;
                var comportamiento = dataJson.skComportamientoModulo;

                if (!comportamiento){
                    comportamiento = 'RELO';
                }

                var icon = dataJson.sIcono;
                var bgColor = dataJson.sColor;

                if (!bgColor){
                    bgColor = 'bg-red-600';
                }
                if (!icon){
                    icon = 'wb-order';
                }

                $('.notidelo').prepend(' <a id="' + skNotificacion + '" class="list-group-item" href="javascript:void(0)" role="menuitem" style="cursor: pointer" ' +
                    'onclick="core.menuLoadModule({ skModulo:  \'softlab\', url: \'' + sUrl + '\', skComportamiento: \'' + comportamiento + '\'}); core.notificationClick(\'' + skNotificacion + '\');">' +
                    '<div class="media"><div class="media-left padding-right-10"> <i class="icon ' + icon + ' ' + bgColor + ' white icon-circle" aria-hidden="true"></i> </div>' +
                    '<div class="media-body"> <h6 class="media-heading">' + dataJson.sNombre + '</h6> <p title="' + dataJson.sMensaje + '" ' +
                    'style="word-wrap: normal !important;white-space: nowrap !important;overflow: hidden !important;-o-text-overflow: ellipsis !important;text-overflow: ellipsis !important;' +
                    'width: 70% !important;">' + dataJson.sMensaje + '</p> <time class="media-meta">' + dataJson.dFechaCreacion + ' </time></div></div></a>');

                core.notificationCount();
                toastr.success('Nueva Notificación');
                desktopNotification(dataJson.sNombre, dataJson.sMensaje, null, sUrl, dataJson.skNotificacion, skNotificacion, comportamiento);
                return true;
                break;
            case 'CHAT':

                var chats = $('.chats-slide');
                if ($(".slidePanel ").hasClass("slidePanel-show")) {
                    core.chatList();
                }
                dataJson.message = emojione.shortnameToImage(dataJson.message);

                if (dataJson.emisor == core.skUserChat && $(".slidePanel ").hasClass("slidePanel-show")) {
                    chats.append('<div class="chat chat-left animated fadeInUp"> <div class="chat-avatar"> <a class="avatar" data-toggle="tooltip" role="button" data-placement="right">' +
                        '<img src="' + dataJson.img + '"></a></div>' +
                        '<div class="chat-body"> <div class="chat-content"> <p> ' + dataJson.message + ' </p><time class="chat-time">' + dataJson.dFechaCreacion + '</time> </div></div></div>');

                    chats.animate({scrollTop: chats.get(0).scrollHeight}, 0);
                } else {
                    core.chatCount();
                    // Si no está abierto el slide panel
                    if (!$(".slidePanel ").hasClass("slidePanel-show")) {
                        play_sound('chat');
                        iziToast.show({
                            class: 'test',
                            color: 'dark',
                            icon: 'fa fa-commenting-o',
                            title: dataJson.user,
                            message: emojione.shortnameToImage(dataJson.shortMessage),
                            position: 'bottomLeft',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX',
                            progressBarColor: '#62a8ea',
                            image: dataJson.img,
                            imageWidth: 70,
                            layout: 2,
                            onClose: function () {
                            },
                            buttons: [
                                ['<button>Abrir Chat</button>', function () {
                                    if (!$(".slidePanel ").hasClass("slidePanel-show")) {
                                        $('#slideChat').trigger("click");
                                    }
                                }]
                            ],
                            iconColor: '#fff'
                        });

                        if (!core.window_active) {
                            desktopNotification(dataJson.user, emojione.shortnameToUnicode(dataJson.shortMessage), dataJson.img, null, dataJson.emisor, null, comportamiento);
                        }
                    }
                }
                play_sound('chat');

                if (!core.window_active) {
                    pageTitleNotification.on("Nuevo Mensaje de " + dataJson.user, 1000);
                    core.noti = true;
                }
                return true;
                break;
            case 'PRVIMG':
                if (typeof prvGallery !== "undefined") {
                    var sValores = JSON.parse(dataJson.sValores);
                    prvGallery.addImage(sValores.skDocumento, sValores.skProgramacionPrevio, sValores.skModelo);
                }
                return true;
                break;
            case 'ACTION':
                break;
        }
    };

    pusher.bind('notify', callback);


    function play_sound(type) {
        switch (type) {
            case 'alert':
                document.getElementById('soundAlert').play();
                return true;
                break;
            case 'chat':
                document.getElementById('chatAlert').play();
                return true;
                break;
            default:
                return true;
                break;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (Notification.permission !== "granted")
            Notification.requestPermission();
    });

    function desktopNotification(title, message, img, url, tag, skNotificacionUsuario, comportamiento) {
        if (!Notification) {
            alert('Las notificaciones de escritorio no están disponibles en tu navegador.');
            return;
        }
        if (tag == null || tag == 'undefined') {
            tag = core.generateSerial(8);
        }

        if (Notification.permission !== "granted")
            Notification.requestPermission();
        else {
            if (img == null) {
                img = '<?php echo $img_system; ?>';
            }

            var notification = new Notification(title, {
                icon: img,
                body: message,
                requireInteraction: true,
                tag: tag,
                vibrate: [200, 100, 200, 100, 200, 100, 200]
            });

            notification.onclick = function () {
                window.focus();
                if (url != null) {
                    core.menuLoadModule({skModulo: 'softlab', url: url, skComportamiento: comportamiento});
                }

                if (skNotificacionUsuario != null) {
                    core.notificationClick(skNotificacionUsuario);
                }

                notification.close();
            };

            /*            notification.ondenied = function () {

             };*/
        }
    }

    $(document).ready(function () {
        core.notificationCount();
        core.notificationList();
    });


</script>
<audio id="soundAlert" src="<?php echo $sound; ?>" preload="auto"></audio>
<audio id="chatAlert" src="<?php echo $sound_chat; ?>" preload="auto"></audio>
