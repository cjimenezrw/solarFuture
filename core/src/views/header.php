<?php
require_once(CORE_PATH . '/src/AssetLoader.php');
$load = new AssetLoader();
?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="softlab.">
    <meta name="theme-color" content="#064480">
    <meta name="author" content="Softlab">
    <meta name="keywords" content="
logistica internacional, agencia logistica, holding, importación, exportación, agencia aduanal, fletes, almacenaje, maniobras, consolidación, desconsolidacion, de, carga, servicios, integrales, comercio, exterior, manzanillo" />
    <title><?php echo WEBTITLE; ?></title>
    <link rel="apple-touch-icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.ico">
    <link rel="shortcut icon" href="<?php echo ASSETS_PATH . 'tpl/'; ?>images/favicon.ico">


    <!-- Stylesheets -->
    <?php echo $load->getCSS('core'); ?>

    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/media-match/media.match.min.js"></script>
    <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
    <script src="<?php echo ASSETS_PATH; ?>tpl/global/vendor/jquery/jquery.js"></script>
    <script src="<?php echo ASSETS_PATH; ?>tpl/global/vendor/modernizr/modernizr.js"></script>
    <script src="<?php echo ASSETS_PATH; ?>tpl/global/vendor/breakpoints/breakpoints.js"></script>
    <!-- CORE JS !-->
    <script src="<?php echo SYS_URL; ?>core/src/views/js/<?php echo VERSION; ?>/core.js"></script>
    <script>
        Breakpoints();
        core.SYS_URL = "<?php echo SYS_URL; ?>";
        core.DIR_PATH = "<?php echo DIR_PATH; ?>";
        core.DIR_ASSETS = "<?php echo ASSETS_PATH; ?>";
        core.skUsuario = "<?php echo $_SESSION["usuario"]["skUsuario"]; ?>";
        core.skEmpresaSocio = "<?php echo $_SESSION["usuario"]["skEmpresaSocio"]; ?>";
        core.module.skModulo = '<?php echo $this->sysController; ?>';
    </script>
</head>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <!--[if lt IE 9]>
          <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/html5shiv/html5shiv.min.js"></script>
          <![endif]-->
        <!--[if lt IE 10]>
          <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/media-match/media.match.min.js"></script>
          <script src="<?php echo ASSETS_PATH . 'tpl/'; ?>global/vendor/respond/respond.min.js"></script>
          <![endif]-->
        <!-- Scripts -->
        <script src="<?php echo ASSETS_PATH; ?>tpl/global/vendor/modernizr/modernizr.js"></script>
        <script src="<?php echo ASSETS_PATH; ?>tpl/global/vendor/breakpoints/breakpoints.js"></script>
        <script>
            Breakpoints();
        </script>
    </head>
    <body>
        <!--[if lt IE 8]>
              <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
          <![endif]-->

<?php require_once(CORE_PATH . '/src/views/stage/header.php'); ?>
<?php require_once(CORE_PATH . '/src/views/stage/tableAdds.php'); ?>
<?php require_once(CORE_PATH . '/src/views/stage/menu.php'); ?>
<?php require_once(CORE_PATH . '/src/views/stage/gridMenu.php'); ?>

<!-- Page -->
        <div id="view-content">
