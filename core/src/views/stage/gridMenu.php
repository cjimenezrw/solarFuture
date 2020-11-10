<div class="site-gridmenu">
    <div>
        <div>
            <ul>
                <?php if (!empty($_SESSION['menu']['ACR'])) { ?>
                    <?php foreach ($_SESSION['menu']['ACR'] as $modulos => $value) { ?>
                    <li>
                        <a href="javascript:void(0)"
                           onclick="core.menuLoadModule({ skModulo: '<?php echo $value['skModulo']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModulo'] . '/' . $value['sNombre'] . '/'; ?>' }); $( '.site-gridmenu-toggle' ).trigger( 'click' );">
                                <i class="icon <?php echo ($value['sIcono'] ? $value['sIcono'] : 'wb-link') ?>" aria-hidden="true"></i>
                            <span><?php echo $value['sTitulo']; ?></span>
                        </a>
                    </li>
                    <?php  }?>
                <?php  }?>

            </ul>
        </div>
    </div>
</div>
