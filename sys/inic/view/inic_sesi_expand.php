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
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#064480">
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#064480">
    <meta name="description" content="Solar Future">
    <meta name="author" content="Solar Future">
    <meta name="keywords" content="Solar Future" />
    <title><?php echo COMPANY; ?></title>
    <link rel="apple-touch-icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.png">
    <link rel="shortcut icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.png">
    <!-- Stylesheets -->
    <?php echo $load->getCSS("login"); ?>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . 'tpl/'; ?>examples/css/pages/login-v2.css">
    <!-- Fonts -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_PATH. 'tpl/'; ?>/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script src="<?php echo ASSETS_PATH. 'tpl/'; ?>/media-match/media.match.min.js"></script>
    <script src="<?php echo ASSETS_PATH. 'tpl/'; ?>/respond/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->

</head>
<body class="page-login-v2 layout-full page-dark">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Page -->


<?php


function randomPrint(){
    $msg  = array(

            array("La regla de oro de todo hombre de negocios es esta: Ponte en el lugar de tu cliente.",
                   'Orison Swett Marden'),

            array('Un hombre inteligente no es el que tiene muchas ideas, sino el que sabe sacar provecho de las pocas que tiene.',
                'Anónimo'),

            array('El trabajo que nunca se empieza es el que tarda más en finalizarse.',
                   'J.R.R. Tolkien'),

            array('El éxito no se logra sólo con cualidades especiales. Es sobre todo un trabajo de constancia, de método y organización.',
                'Victor Hugo'),

            array('Normalmente, lo que nos da más miedo hacer es lo que más necesitamos hacer.',
                   'Timothy Ferriss'),

            array('El éxito es la suma de pequeños esfuerzos repetidos un día sí y otro también.',
                   'Robert Collier'),

    );
    $p = rand(0, count($msg)-1);

    echo '<p class="font-size-20">'.$msg[$p][0].'</p><p>'.$msg[$p][1].'</p>';
}

?>


<div class="page animsition" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content">
        <div class="page-brand-info">
            <div class="brand">
                <img class="brand-img" src="<?php echo ASSETS_PATH . 'tpl/'; ?>images/logoHeader.png" alt="..." style="max-width: 450px;">
                <!--<h2 class="brand-text font-size-40"><?php /*echo COMPANY */?></h2>-->
            </div>
            <!--<p class="font-size-20">Normalmente, lo que nos da m&aacute;s miedo hacer es lo que m&aacute;s necesitamos
                hacer.</p>-->

            <?php randomPrint();?>
        </div>
        <div class="page-login-main">

            <div class="brand visible-xs">
<!--                <img class="brand-img" style="width: 80px; -webkit-filter: invert(100%); filter: invert(100%);"
                     src="<?php /*echo ASSETS_PATH . 'tpl/'; */?>images/logoW.png" alt="...">-->
                <h3 class="brand-text font-size-40"><?php echo COMPANY ?></h3>
            </div>
            <h3 class="font-size-24">Inicio de Sesión</h3>
            <p><?php echo COMPANY ?></p>
            <div id="message" class="bigEntrance">Seleccione Su Perfil</div>
            <div id="principal">
                <form method="post" id="formSesion" action="#">
                    <div class="form-group">
                        <label class="sr-only" for="inputEmail">Correo o Usuario</label>
                        <input type="text" class="form-control" id="inputEmail" name="usuario"
                               placeholder="Correo o Usuario" autofocus>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="inputPassword">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="inputPassword" name="password"
                               placeholder="Contrase&ntilde;a" onkeypress="capLock(event)">
                        <div id="divMayus" class="fullw" style="visibility:hidden; color: #b4b4b4; font-size: smaller;">Mayúsculas activadas.</div>
                    </div>
                    <div class="text-xs-center">
                        <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
                    </div>
                    <script type="text/javascript"
                            src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
                    </script>
                    <div class="form-group clearfix margin-top-10">
                        <div class="checkbox-custom checkbox-inline checkbox-primary pull-left hidden">
                            <input type="checkbox" id="remember" name="checkbox">
                            <label for="inputCheckbox">Recordar Contrase&ntilde;a</label>
                        </div>
                        <a class="pull-right fullw" href="<?php echo SYS_URL.'sys/inic/inic-recu/recuperar-clave/'; ?>">¿Olvidaste tu contrase&ntilde;a?</a>
                    </div>
                    <button class="btn btn-primary btn-block margin-top-20" type="submit">Iniciar
                        Sesi&oacute;n
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

            <footer class="page-copyright">
                <p>Creado Por <?php echo DEVELOPER; ?></p>
                <p>© <?php echo date("Y")?>. <?php echo COMPANY; ?>.</p>
                <div class="social">
                    <a class="btn btn-icon btn-round social-twitter" href="javascript:void(0)">
                        <i class="icon bd-twitter" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-icon btn-round social-facebook" href="javascript:void(0)">
                        <i class="icon bd-facebook" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-icon btn-round social-google-plus" href="javascript:void(0)">
                        <i class="icon bd-google-plus" aria-hidden="true"></i>
                    </a>
                </div>
            </footer>
        </div>
    </div>
</div>
<!-- End Page -->

<!-- Core  -->
<?php echo $load->getJS("login"); ?>

<!-- Plugins -->
<script src="<?php echo ASSETS_PATH . 'tpl/global/vendor'; ?>/switchery/switchery.min.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/global/vendor'; ?>/intro-js/intro.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/global/vendor'; ?>/screenfull/screenfull.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/global/vendor'; ?>/slidepanel/jquery-slidePanel.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/global/vendor'; ?>/jquery-placeholder/jquery.placeholder.js"></script>
<!-- Scripts -->
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/js/core.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>js/site.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>js/sections/menu.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>js/sections/menubar.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>js/sections/gridmenu.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>js/sections/sidebar.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/js/configs/config-colors.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>js/configs/config-tour.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/js/components/asscrollable.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/js/components/animsition.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/js/components/slidepanel.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/js/components/switchery.js"></script>
<script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/js/components/jquery-placeholder.js"></script>

<script>
    Breakpoints();
    var inic_sesi_view = 'inic_sesi_expand';
</script>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/inic.js"></script>

<script>

    (function (document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function () {
            Site.run();
        });
    })(document, window, jQuery);
</script>
</body>
</html>
