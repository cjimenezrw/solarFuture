<div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu">
                    <li class="site-menu-category">MEN&Uacute;</li>

                    <?php if (!empty($_SESSION['menu']['LAT'])) { ?>

                        <?php foreach ($_SESSION['menu']['LAT'] as $modulos => $value) { ?>
                            <?php if ($value['subMenu']) { ?>
                                <li class="site-menu-item has-sub" id="<?php echo $value['skModulo']; ?>">
                            <?php } else { ?>
                                <li class="site-menu-item" id="<?php echo $value['skModulo']; ?>">
                            <?php } ?>
                            <!--<li class="site-menu-item has-sub active open">-->
                            <?php if ($value['subMenu']){ ?>
                            <a role="button">
                            <?php }else{ ?>
                            <a class="animsition-link" role="button"
                               onclick="core.menuLoadModule({ skModulo: '<?php echo $value['skModulo']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModulo'] . '/' . $value['sNombre'] . '/'; ?>' });">
                        <?php } ?>
                            <?php if ($value['sIcono']) { ?>
                                <i class="site-menu-icon <?php echo $value['sIcono']; ?>" aria-hidden="true"></i>
                            <?php } ?>
                            <span class="site-menu-title"
                                  title="<?php echo $value['sTitulo']; ?>"><?php echo $value['sTitulo']; ?></span>
                            <?php if ($value['subMenu']) { ?>
                                <span class="site-menu-arrow"></span>
                            <?php } ?>
                            </a>

                            <?php if ($value['subMenu']) { ?>
                                <ul class="site-menu-sub">
                                    <?php foreach ($_SESSION['menu']['LAT'][$value['skModulo']]['subMenu'] as $key => $valueSubmenu) { ?>
                                        <?php if ($valueSubmenu['subMenu']) { ?>
                                            <li class="site-menu-item has-sub" id="<?php echo $valueSubmenu['skModulo']; ?>">
                                        <?php } else { ?>
                                            <li class="site-menu-item" id="<?php echo $valueSubmenu['skModulo']; ?>">
                                        <?php } ?>
                                        <?php if ($valueSubmenu['subMenu']){ ?>
                                        <a role="button">
                                        <?php }else{ ?>
                                        <a class="animsition-link" role="button"
                                           onclick="core.menuLoadModule({ skModulo: '<?php echo $valueSubmenu['skModulo']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $valueSubmenu['skModuloPrincipal'] . '/' . $valueSubmenu['skModulo'] . '/' . $valueSubmenu['sNombre'] . '/'; ?>'});">
                                    <?php } ?>
                                        <i class="site-menu-icon <?php //echo $valueSubmenu['sIcono']; ?>"
                                           aria-hidden="true"></i>

                                        <span class="site-menu-title" title="<?php echo $valueSubmenu['sTitulo']; ?>"><i
                                                class="icon wb-small-point"
                                                aria-hidden="true"></i> <?php echo $valueSubmenu['sTitulo']; ?></span>
                                        <?php if ($valueSubmenu['subMenu']) { ?>
                                            <span class="site-menu-arrow"></span>
                                        <?php } ?>
                                        </a>
                                        <?php if ($valueSubmenu['subMenu']) { ?>
                                            <ul class="site-menu-sub">
                                                <?php foreach ($_SESSION['menu']['LAT'][$value['skModulo']]['subMenu'][$valueSubmenu['skModulo']]['subMenu'] as $key => $value2) { ?>
                                                    <li class="site-menu-item" id="<?php echo $value2['skModulo']; ?>">
                                                        <a class="animsition-link" role="button"
                                                           onclick="core.menuLoadModule({ skModulo: '<?php echo $value2['skModulo']; ?>', skModuloPadre: '<?php echo $value2['skModuloPadre']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $value2['skModuloPrincipal'] . '/' . $value2['skModulo'] . '/' . $value2['sNombre'] . '/'; ?>' });">
                                                            <span class="site-menu-title"
                                                                  title="<?php echo $value2['sTitulo']; ?>"><?php echo $value2['sTitulo']; ?></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            </li>
                        <?php } ?>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </div>
<!--    <div class="site-menubar-footer">
        <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
           data-original-title="Settings">
            <span class="icon wb-settings" aria-hidden="true"></span>
        </a>
        <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Perfil">
            <span class="icon wb-user" aria-hidden="true"></span>
        </a>
        <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Cerrar Sesion">
            <span class="icon wb-power" aria-hidden="true"></span>
        </a>
    </div>-->

<div class="site-menubar-footer text-center">
    <p class="margin-15"><i class="fa fa-home" aria-hidden="true"></i><b> </b> <?php echo $_SESSION["usuario"]["sEmpresa"]; ?> </p>
</div>
</div>
