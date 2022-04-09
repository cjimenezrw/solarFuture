<?php
require_once(CORE_PATH.'/src/AssetLoader.php');

// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = GR_SITE_KEY;
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = 'es-419';
$load = new AssetLoader();
?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Red Manzanillo">
    <meta name="theme-color" content="#064480">
    <meta name="author" content="<?php echo DEVELOPER; ?>">
    <meta name="keywords" content="Red Manzanillo" />
    <title><?php echo COMPANY; ?></title>
    <link rel="apple-touch-icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.png">
    <link rel="shortcut icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.png">
    <!-- Stylesheets -->
    <?php echo $load->getCSS("login"); ?>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . 'custom/'; ?>css/login-v2.css">
    <!-- Fonts -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_PATH_CDN. 'tpl/'; ?>/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script src="<?php echo ASSETS_PATH_CDN. 'tpl/'; ?>/media-match/media.match.min.js"></script>
    <script src="<?php echo ASSETS_PATH_CDN. 'tpl/'; ?>/respond/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
    <style type="text/css">
        /*.form-control { color: #FFFFFF !important; }*/
        .page-copyright-inverse, .page-copyright-inverse .social .icon { font-weight: 600; }
    </style>
</head>

<body class="animsition page-login-v3 layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Page -->
<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
        <div class="panel">
            <div class="panel-body">
                <div class="brand">
                    <img class="brand-img" src="<?php echo ASSETS_PATH . 'tpl/'; ?>images/logoOriginal.png" draggable="false" alt="..." style="width: -webkit-fill-available; width: -moz-available;">
                    <h2 class="brand-text font-size-18"></h2>
                    <div id="message" class="bigEntrance">- SELECCIONE SU PERFIL -</div>
                </div>
                <div id="principal">
                    <form method="post" id="formSesion" action="#">
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" id="inputEmail" name="usuario"
                                   placeholder="Correo o Usuario" autofocus>
                            <label class="floating-label">Correo o Usuario</label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="password" class="form-control" id="inputPassword" name="password"
                                   placeholder="Contrase&ntilde;a" onkeypress="capLock(event)">
                            <label class="floating-label">Contrase&ntilde;a</label>
                            <div id="divMayus" class="fullw"
                                 style="visibility:hidden; color: #b4b4b4; font-size: smaller;">Mayúsculas activadas.
                            </div>
                        </div>
                        <div class="text-xs-center offset-md-6">
                            <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                        </div>
                        <script type="text/javascript"
                                src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
                        </script>
                        <div class="form-group clearfix">
                            <a class="pull-right fullw"
                               href="<?php echo SYS_URL . 'sys/inic/inic-recu/recuperar-clave/'; ?>">¿Olvidaste tu
                                contrase&ntilde;a?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg margin-top-40">Iniciar Sesión
                        </button>
                    </form>
                </div>
                <!-- Elejir perfil, si regresa exito -->
                <div id="perfiles" style="display:none;">
                    <div class="example example-buttons">
                        <form method="post" id="formIniciar" action="#">
                            <div id="elejirPerfil">
                                <div class="profilesContainer">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="page-copyright page-copyright-inverse">
            <p>Creado Por <a href="https://softlab.mx/" target="_blank" style="color:#fff;"><?php echo DEVELOPER; ?></a></p>
            <p>&copy; <?php echo date("Y")?> Derechos Reservados</p>
            <div class="social">
                <!--<a class="btn btn-icon btn-pure" href="#" target="_blank">
                    <i class="icon bd-twitter" aria-hidden="true"></i>
                </a>!-->
                <a class="btn btn-icon btn-pure" href="https://www.facebook.com/softlabmx/" target="_blank">
                    <i class="icon bd-facebook" aria-hidden="true"></i>
                </a>
                <!--<a class="btn btn-icon btn-pure" href="#" target="_blank">
                    <i class="icon bd-instagram" aria-hidden="true"></i>
                </a>!-->
            </div>
        </footer>
    </div>
</div>
<!-- End Page -->
<!-- Core  -->
<?php echo $load->getJS("login"); ?>

<!-- Plugins -->
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/global/vendor'; ?>/switchery/switchery.min.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/global/vendor'; ?>/intro-js/intro.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/global/vendor'; ?>/screenfull/screenfull.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/global/vendor'; ?>/slidepanel/jquery-slidePanel.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/global/vendor'; ?>/jquery-placeholder/jquery.placeholder.js"></script>
<!-- Scripts -->
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>global/js/core.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>js/site.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>js/sections/menu.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>js/sections/menubar.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>js/sections/gridmenu.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>js/sections/sidebar.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>global/js/configs/config-colors.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>js/configs/config-tour.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>global/js/components/asscrollable.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>global/js/components/animsition.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>global/js/components/slidepanel.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>global/js/components/switchery.js"></script>
<script src="<?php echo ASSETS_PATH_CDN . 'tpl/'; ?>global/js/components/jquery-placeholder.js"></script>

<script>

    var inic_sesi_view = 'inic_sesi_compact';

    (function(document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function() {
            Site.run();
        });
    })(document, window, jQuery);

    function loading() {
        $('#perfiles').html('<img src="<?php echo ASSETS_PATH ?>custom/img/loading-login.gif" draggable="false" style="width: -webkit-fill-available; width: -moz-available;/><div class="load_bg_anim"><div class="textLoad"> Conectando</div></div>');
        $(function () {
            var count = 0;
            var wordsArray = ["Configurando Sitio", "Espere un momento", "Configurando Perfil", "Configurando Entorno", "Casi Terminamos"];
            setInterval(function () {
                count++;
                $(".textLoad").fadeOut(500, function () {
                    $(this).text(wordsArray[count % wordsArray.length]).fadeIn(500);
                });
            }, 3500);
        });
    }
</script>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/inic.js"></script>

</body>
</html>