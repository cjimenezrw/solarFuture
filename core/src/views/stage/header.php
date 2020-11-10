<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-inverse" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
                data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <img class="navbar-brand-logo img-rounded" src="<?php echo ASSETS_PATH ?>tpl/images/logoHeader.png"
                 title="<?php echo COMPANY;?>">
            <span class="navbar-brand-text hidden-xs"> <?php echo COMPANY; ?></span>
        </div>
        <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"
                data-toggle="collapse">
            <span class="sr-only">Toggle Search</span>
            <i class="icon wb-search" aria-hidden="true"></i>
        </button>
    </div>
    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                <li class="hidden-float" id="toggleMenubar">
                    <a data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>
                <li class="hidden-xs" id="toggleFullscreen">
                    <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li>
                <li class="hidden-float">
                    <a class="icon wb-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
                       role="button">
                        <span class="sr-only">Toggle Search</span>
                    </a>
                </li>

            </ul>
            <!-- End Navbar Toolbar -->
            <!-- Navbar Toolbar Right -->
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                <!-- Menu Cabezera -->

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                       data-animation="fade"
                       role="button"><?php echo $_SESSION["usuario"]["sNombreUsuario"] . ' ' . $_SESSION["usuario"]["sPaterno"] . ' ' . $_SESSION["usuario"]["sMaterno"]; ?></a>
                </li>

                <li class="dropdown">
                    <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
                       data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img
                    src="<?php echo($_SESSION['usuario']['sFoto'] ? ASSETS_PATH . 'profiles/' . $_SESSION['usuario']['sFoto'] : ASSETS_PATH . 'tpl/' . 'global/portraits/user.png'); ?> "
                    alt="...">
                <i></i>
              </span>
                    </a>
                    <ul class="dropdown-menu" role="menu">


                        <!--<li role="presentation">
                          <a href="javascript:void(0)" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Perfil</a>
                        </li>

                        <li role="presentation">
                          <a href="javascript:void(0)" role="menuitem"><i class="icon wb-settings" aria-hidden="true"></i> Ajustes</a>
                      </li>-->
                        <?php if (!empty($_SESSION['menu']['SUP'])) { ?>
                            <?php foreach ($_SESSION['menu']['SUP'] as $modulos => $value) { ?>
                                <li role="presentation">
                                    <a role="button"
                                       onclick="core.menuLoadModule({ skModulo: '<?php echo $value['skModulo']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModulo'] . '/' . $value['sNombre'] . '/'; ?>' });">
                                        <i class="icon <?php echo($value['sIcono'] ? $value['sIcono'] : 'wb-link') ?>"
                                           aria-hidden="true"></i>
                                        <span><?php echo $value['sTitulo']; ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <li class="divider" role="presentation"></li>
                        <li role="presentation">
                            <a href="<?php echo SYS_URL; ?>logout/" role="menuitem"><i class="icon wb-power"
                                                                                       aria-hidden="true"></i> Cerrar
                                Sesion</a>
                        </li>
                    </ul>
                </li>

                <!--          Notificaciones-->
                <li class="dropdown">
                    <a data-toggle="dropdown" href="javascript:void(0)" title="Notificaciones" aria-expanded="false"
                       data-animation="scale-up" role="button">
                        <i class="icon wb-bell" aria-hidden="true"></i>
                        <span class="badge badge-success up badge-notifications">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                        <li class="dropdown-menu-header" role="presentation">
                            <h5>NOTIFICACIONES</h5>
                            <span class="notiCount label label-round label-success">0 Nuevas</span>
                        </li>
                        <li class="list-group" role="presentation">
                            <div data-role="container">
                                <div data-role="content" class="notidelo">
                                    <!--Notificaciones-->
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-menu-footer" role="presentation">
                            <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                <i class="icon wb-settings" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:void(0)" role="menuitem">
                                Todas Las Notificaciones
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if($_SESSION['modulos']['inic-slid']['permisos']['R'] == 1 || $_SESSION['usuario']['tipoUsuario'] == 'A'){ ?>
                <li id="toggleChat">
                    <a data-toggle="site-sidebar" id="slideChat" href="javascript:void(0)" title="Chat"
                       data-url="<?php echo SYS_URL ?>sys/inic/inic-slid/panel-notificacion/">
                        <i class="icon wb-chat" aria-hidden="true"></i>
                        <span class="badge up badge-success badge-chat">0</span>
                    </a>
                </li>
                <?php }//ENDIF ?>
            </ul>
            <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
            <form action="" method="post" id="search" onsubmit="event.preventDefault();buscador();return false;">
                <div class="form-group">
                    <div class="input-search">
                        <i class="input-search-icon wb-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="site-search" id="site-search"
                               placeholder="Buscar...">
                        <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
                                data-toggle="collapse" aria-label="Close"></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Site Navbar Seach -->
    </div>
</nav>
