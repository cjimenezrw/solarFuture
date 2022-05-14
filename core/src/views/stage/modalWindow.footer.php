<?php if (!empty($_SESSION['modulos'][$this->sysController]['botones'])) { ?>
    <div class="modal-footer mowiMenu">
        <div class="dropdown pull-right animated bounceIn" style="z-index: 99">
            <button type="button" class="btn btn-outline btn-default dropdown-toggle" id="exampleIconsDropdown"
                    data-toggle="dropdown" aria-expanded="false">Opciones
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu bullet dropdown-menu-right" aria-labelledby="exampleIconsDropdown" role="menu"
                id="optionsBreadcrumb">
                <?php
                // OBTENEMOS LOS PARÁMETROS DE LA URL //
                $_idParams = '';
                if (isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])) {
                    $_arrayParamsUrl = explode('/', str_replace(SYS_URL, '', $_SERVER["HTTP_REFERER"]));
                    array_pop($_arrayParamsUrl);
                    $_idParams = (isset($_arrayParamsUrl[4]) ? $_arrayParamsUrl[4] . '/' : '');
                    $_idParams = (isset($_arrayParamsUrl[5]) ? $_idParams . $_arrayParamsUrl[5] . '/' : $_idParams);
                    $_idParams = (isset($_arrayParamsUrl[6]) ? $_idParams . $_arrayParamsUrl[6] . '/' : $_idParams);
                    $_idParams = (isset($_arrayParamsUrl[7]) ? $_idParams . $_arrayParamsUrl[7] . '/' : $_idParams);
                    $_idParams = (isset($_arrayParamsUrl[8]) ? $_idParams . $_arrayParamsUrl[8] . '/' : $_idParams);
                }
                ?>
                <?php foreach ($_SESSION['modulos'][$this->sysController]['botones'] as $key => $value) {
                    ?>
                    <li role="presentation"><a role="button" role="menuitem"
                                               data-original-title="<?php echo $value['sNombreBoton']; ?>"
                            <?php
                            switch ($value['sFuncion']) {
                                case "nuevo":
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'})";
                                    echo 'title=\'Alt + N\' onclick="' . $function . '"';
                                    break;
                                case "consulta":
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/" . $_idParams . "', skComportamiento: '" . $value['skComportamiento'] . "'});";
                                    echo 'onclick="' . $function . '"';
                                    break;
                                case "guardar":
                                    $function = "core.guardar({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/" . $_idParams . "', skComportamiento: '" . $value['skComportamiento'] . "'});";
                                    echo 'title=\'Alt + G\' onclick="' . $function . '"';
                                    break;
                                case "excel":
                                    $function = "core.excel({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'});";
                                    echo 'title=\'Alt + X\' onclick="' . $function . '"';
                                    break;
                                case "pdf":
                                    $function = "core.pdf({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'});";
                                    echo 'title=\'Alt + P\' onclick="' . $function . '"';
                                    break;
                                case "txt":
                                    $function = "core.txt({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'});";
                                    echo 'onclick="' . $function . '"';
                                    break;
                                default:
                                    $function = $value['sFuncion'] . "({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/" . $_idParams . "', skComportamiento: '" . $value['skComportamiento'] . "'});";
                                    echo 'onclick="' . $function . '"';
                                    //echo 'onclick="' . $value['sFuncion'] . '"';
                                    break;
                            }
                            ?>
                        ><i class="icon <?php echo $value['sIcono']; ?>"
                            aria-hidden="true"></i><?php echo $value['sNombreBoton']; ?></a></li>
                <?php }//ENDFOREACH ?>
            </ul>
        </div>
    </div>
    <?php
}//ENDIF ?>