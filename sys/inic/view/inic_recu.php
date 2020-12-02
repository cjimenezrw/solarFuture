<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 21/10/2016
 * Time: 11:23 AM
 */

require_once(CORE_PATH . '/src/AssetLoader.php');
$load = new AssetLoader();

?>

<!DOCTYPE html>
<html class="no-js css-menubar" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Solar Future">
    <meta name="theme-color" content="#064480">
    <meta name="author" content="Solar Future">
    <meta name="keywords" content="Solar Future"/>
    <title><?php echo COMPANY; ?></title>
    <link rel="apple-touch-icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.png">
    <link rel="shortcut icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.png">

    <style>
        .social{
            display: none;
        }
    </style>

    <!-- Stylesheets -->
    <?php echo $load->getCSS("recover"); ?>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>


    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_PATH. 'tpl/'; ?>/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="<?php echo ASSETS_PATH. 'tpl/'; ?>/media-match/media.match.min.js"></script>
    <script src="<?php echo ASSETS_PATH. 'tpl/'; ?>/respond/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/modernizr/modernizr.min.js"></script>
    <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/breakpoints/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="page-forgot-password layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->


<!-- Page -->
<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
     data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
        <h2>¿ Olvidó su contraseña ?</h2>

        <p>Ingrese su correo electrónico para restablecer la contraseña</p>

        <form id="formRecu" method="post" action="#" role="form">
            <div class="form-group">
                <input type="email" class="form-control" id="inputEmail" name="email"
                       placeholder="Correo electrónico" autocomplete="off">
            </div>
            <div class="form-group">
                <button type="submit" id="sendB"
                        data-loading-text="<i class='fa fa-spinner faa-spin animated'></i> Enviando Solicitud..."
                        class="btn btn-primary btn-block">Restablecer Contraseña
                </button>
            </div>
            <a class="pull-center" href="<?php echo SYS_URL; ?>">Regresar</a>
        </form>

        <footer class="page-copyright">
            <p>Creado Por <?php echo COMPANY; ?></p>

            <p>© <?php echo date("Y"); ?>. Todos los derechos reservados.</p>

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

<?php echo $load->getJS("deli-serv"); ?>
<script>var url = '<?php echo SYS_URL; ?>';</script>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/recu.js"></script>


<script>
    (function (document, window, $) {
        'use strict';

        var Site = window.Site;
        $(document).ready(function () {
            Site.run();
        });
    })(document, window, jQuery);
</script>

<?php
if (isset($data["token"])) {
    if ($data["token"] != false) {
        echo '<script>newPass("' . $data["token"] . '","' . $data["sUsuario"] . '")</script>';
        echo "<script>$(document).ready(function () {  $('#core-guardar').formValidation(core.formValidaciones);  });</script>";
    } elseif ($data["token"] == false) {
        echo "<script>errorCode();</script>";
    }
}
?>

</body>
</html>
