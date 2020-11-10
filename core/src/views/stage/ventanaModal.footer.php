</div>
<div class="modal-footer">
    <?php
        // OBTENEMOS LOS PARÁMETROS DE LA URL //
        $_idParams = '';
        if(isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])){
            $_arrayParamsUrl = explode('/',str_replace(SYS_URL, '', $_SERVER["HTTP_REFERER"]));
            array_pop($_arrayParamsUrl);
            $_idParams = (isset($_arrayParamsUrl[4]) ? $_arrayParamsUrl[4].'/' : '' );
            $_idParams = (isset($_arrayParamsUrl[5]) ? $_idParams.$_arrayParamsUrl[5].'/' : $_idParams );
            $_idParams = (isset($_arrayParamsUrl[6]) ? $_idParams.$_arrayParamsUrl[6].'/' : $_idParams );
            $_idParams = (isset($_arrayParamsUrl[7]) ? $_idParams.$_arrayParamsUrl[7].'/' : $_idParams );
            $_idParams = (isset($_arrayParamsUrl[8]) ? $_idParams.$_arrayParamsUrl[8].'/' : $_idParams );
        }
    ?>
    <?php
    if (!empty($_SESSION['modulos'][$this->sysController]['botones'])) {
        foreach ($_SESSION['modulos'][$this->sysController]['botones'] as $key => $value) {
            ?>
            <a href="javascript:void(0)" type="button" class="btn btn-primary" data-toggle="tooltip"
               data-original-title="<?php echo $value['sNombreBoton']; ?>"
                <?php
                switch ($value['sFuncion']) {
                    case "nuevo":
                        $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'});";
                        echo 'onclick="' . $function . '"';
                        break;
                    case "consulta":
                        $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/".$_idParams."', skComportamiento: '" . $value['skComportamiento'] . "'});";
                        echo 'onclick="' . $function . '"';
                        break;
                    case "guardar":
                        $function = "core.guardar({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/".$_idParams."', skComportamiento: '" . $value['skComportamiento'] . "'});";
                        echo 'onclick="' . $function . '"';
                        break;
                    case "excel":
                        $function = "core.excel({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'});";
                        echo 'onclick="' . $function . '"';
                        break;
                    case "pdf":
                        $function = "core.pdf({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'});";
                        echo 'onclick="' . $function . '"';
                        break;
                    case "txt":
                        $function = "core.txt({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/', skComportamiento: '" . $value['skComportamiento'] . "'});";
                        echo 'onclick="' . $function . '"';
                        break;
                    default:
                        $function = $value['sFuncion']."({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . "/".$_idParams."', skComportamiento: '" . $value['skComportamiento'] . "'});";
                        echo 'onclick="' . $function . '"';
                        break;
                }
                ?>
            >
                <i class="<?php echo $value['sIcono']; ?>" aria-hidden="true"></i>
                <?php echo $value['sNombreBoton']; ?>
            </a>

            <?php
        }//ENDFOREACH
    }//ENDIF
    ?>
    <button type="button" class="btn btn-default" data-dismiss="modal"
            onclick="">Cerrar
    </button>
</div>
</div>