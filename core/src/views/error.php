<html class="no-js css-menubar" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">

    <title>Softlab | Error</title>

    <link rel="apple-touch-icon" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/images/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/css/bootstrap.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/css/bootstrap-extend.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/css/site.min.css?v2.2.0">

    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/animsition/animsition.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/asscrollable/asScrollable.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/switchery/switchery.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/intro-js/introjs.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/slidepanel/slidePanel.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/flag-icon-css/flag-icon.min.css?v2.2.0">

    <!-- Page -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/examples/css/pages/errors.min.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/fonts/web-icons/web-icons.min.css?v2.2.0">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/fonts/brand-icons/brand-icons.min.css?v2.2.0">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/media-match/media.match.min.js"></script>
    <script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/respond/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/modernizr/modernizr.min.js"></script>
    <script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/breakpoints/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="page-error page-error-400 layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<!-- Page -->
<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
     data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
        <header>
            <h1 class="animation-slide-top"><?php echo $errorCode; ?></h1>
            <p>¡Ha Ocurrido Un Error!</p>
        </header>
        <p class="error-advise"><?php echo $message; ?></p>
        <a class="btn btn-primary btn-round" href="<?php echo SYS_URL; ?>">Regresar a Inicio</a>

        <footer class="page-copyright">
            <p>Creado Por <?php echo COMPANY; ?></p>
            <p>© <?php echo date('Y'); ?>. Derechos Reservados.</p>
            <div class="social">
                <a href="javascript:void(0)">
                    <i class="icon bd-twitter" aria-hidden="true"></i>
                </a>
                <a href="javascript:void(0)">
                    <i class="icon bd-facebook" aria-hidden="true"></i>
                </a>
                <a href="javascript:void(0)">
                    <i class="icon bd-dribbble" aria-hidden="true"></i>
                </a>
            </div>
        </footer>
    </div>
</div>
<!-- End Page -->


<!-- Core  -->
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/animsition/animsition.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/asscroll/jquery-asScroll.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/mousewheel/jquery.mousewheel.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>

<!-- Plugins -->
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/switchery/switchery.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/intro-js/intro.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/screenfull/screenfull.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/vendor/slidepanel/jquery-slidePanel.min.js"></script>

<!-- Scripts -->
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/core.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/js/site.min.js"></script>

<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/sections/menu.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/sections/menubar.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/sections/gridmenu.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/sections/sidebar.min.js"></script>

<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/configs/config-colors.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/configs/config-tour.min.js"></script>

<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/components/asscrollable.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/components/animsition.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/components/slidepanel.min.js"></script>
<script src="<?php echo ASSETS_PATH . ASSETS_VERSION; ?>/tpl/global/js/components/switchery.min.js"></script>


<script>
    (function(document, window, $) {
        'use strict';

        var Site = window.Site;
        $(document).ready(function() {
            Site.run();
        });
    })(document, window, jQuery);
</script>

</body>

</html>
