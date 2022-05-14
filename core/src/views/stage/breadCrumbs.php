

<!--    <div class="page-aside">
        <div class="page-aside-switch">
            <i class="icon wb-chevron-left" aria-hidden="true"></i>
            <i class="icon wb-chevron-right" aria-hidden="true"></i>
        </div>

        <div class="page-aside-inner" data-plugin="pageAsideScroll">
            <div data-role="container">
                <div data-role="content">
                    <section class="page-aside-section">
                        <h5 class="page-aside-title">Main</h5>
                        <div class="list-group">
                            <a class="list-group-item active" href="javascript:void(0)"><i class="icon wb-dashboard" aria-hidden="true"></i>Overview</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-pluse" aria-hidden="true"></i>Activity</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-heart" aria-hidden="true"></i>Dearest</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-folder" aria-hidden="true"></i>Folders</a>
                        </div>
                    </section>
                    <section class="page-aside-section">
                        <h5 class="page-aside-title">Filter</h5>
                        <div class="list-group">
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-image" aria-hidden="true"></i>Images</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-volume-high" aria-hidden="true"></i>Audio</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-camera" aria-hidden="true"></i>Video</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-file" aria-hidden="true"></i>Notes</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-link-intact" aria-hidden="true"></i>Links</a>
                            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-order" aria-hidden="true"></i>Files</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>-->

    <!--    LOCK MODULE FROM MODULE SLIDE PANEL !-->
    <div id="lockPanelModule" class="lockPanel"></div>
        <div class="page animsition" style="animation-duration: 800ms; opacity: 1;">
            <?php if(isset($_SESSION['modulos'][$this->sysController]['caracteristicas']['SLID'])){ ?>
                <script>core.page_aside();</script>
                <div class="page-aside">
                    <div class="page-aside-switch">
                        <i class="icon wb-chevron-left" aria-hidden="true"></i>
                        <i class="icon wb-chevron-right" aria-hidden="true"></i>
                    </div>
                    <div class="page-aside-inner" data-plugin="pageAsideScroll">
                        <div data-role="container">
                            <div data-role="content" id="page-aside-content-portal">
<!--                                <section class="page-aside-section" hidden>
                                    <h5 class="page-aside-title">Grupos</h5>
                                    <div class="list-group">
                                        <a class="list-group-item active" href="javascript:void(0)"><i class="icon wb-dashboard" aria-hidden="true"></i>Softlab</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-pluse" aria-hidden="true"></i>Volley Ball</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-heart" aria-hidden="true"></i>Nutricion</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-folder" aria-hidden="true"></i>Carrera</a>
                                    </div>
                                </section>
                                <section class="page-aside-section" hidden>
                                    <h5 class="page-aside-title">Tipos</h5>
                                    <div class="list-group">
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-image" aria-hidden="true"></i>Imágenes</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-volume-high" aria-hidden="true"></i>Audio</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-camera" aria-hidden="true"></i>Video</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-file" aria-hidden="true"></i>Notas</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-link-intact" aria-hidden="true"></i>Links</a>
                                        <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-order" aria-hidden="true"></i>Archivos</a>
                                    </div>
                                </section>-->
                            </div>
                        </div>
                    </div>
                    <!---page-aside-inner-->
                </div>
            <?php }else{
                echo "<script>$('body').removeClass('page-aside-fixed');</script>";
            } ?>
            <div class="page-main">
                <div class="page-header page-header-bordered page-header-fixed">

                    <h1 class="page-title"><?php echo $_SESSION['modulos'][$this->sysController]['titulo']; ?></h1>
                    <div class="row breadcrumb-size col-xs-6">
                        <ol class="breadcrumb" data-plugin="breadcrumb">
                            <?php
                            $ultimo = end($_SESSION['modulos'][$this->sysController]['breadCrumb']);
                            $ultimo = $ultimo['skModulo'];

                            // PARA SABER CUANDO ESTABLECER LOS PARÁMETROS EN EL BREADCRUMB //
                            $ibreadCrumb = count($_SESSION['modulos'][$this->sysController]['breadCrumb']) - 2;
                            $penultimoBreadCrumb = 0;

                            foreach ($_SESSION['modulos'][$this->sysController]['breadCrumb'] as $key => $value) {
                                if ($ultimo != $value['skModulo']) {
                                    $tArchivo = SYS_PATH . $value['skModuloPrincipal'] . '/view/' . str_replace('-', '_', $value['skModulo']) . '.php';
                                    ?>
                                    <li>
                                        <?php if ((!file_exists($tArchivo))) { ?>
                                            <?php echo $value['sTitulo']; ?>
                                        <?php } else {
                                            // OBTENEMOS LOS PARÁMETROS DE LA URL //
                                            $_idParams = '';
                                            if(isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])){
                                                if($penultimoBreadCrumb === $ibreadCrumb){

                                                    $_arrayParamsUrl = explode('/',str_replace(SYS_URL, '', $_SERVER["HTTP_REFERER"]));
                                                    array_pop($_arrayParamsUrl);
                                                    $_idParams = (isset($_arrayParamsUrl[4]) ? $_arrayParamsUrl[4].'/' : '' );
                                                    $_idParams = (isset($_arrayParamsUrl[5]) ? $_idParams.$_arrayParamsUrl[5].'/' : $_idParams );
                                                    $_idParams = (isset($_arrayParamsUrl[6]) ? $_idParams.$_arrayParamsUrl[6].'/' : $_idParams );
                                                    $_idParams = (isset($_arrayParamsUrl[7]) ? $_idParams.$_arrayParamsUrl[7].'/' : $_idParams );
                                                    $_idParams = (isset($_arrayParamsUrl[8]) ? $_idParams.$_arrayParamsUrl[8].'/' : $_idParams );
                                                }
                                            }
                                            ?>
                                            <a role="button" href="javascript:void(0)"
                                               onclick="core.menuLoadModule({skModulo: '<?php echo $value['skModulo']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModulo'] . '/' . $value['sNombre'] . '/'.$_idParams; ?>'});">
                                                <?php echo $value['sTitulo']; ?></a>
                                        <?php } ?>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="active"><?php echo $value['sTitulo']; ?></li>
                                    <?php
                                }//ENDIF
                                $penultimoBreadCrumb++;
                            }//ENDFOREACH
                            ?>
                        </ol>
                    </div>


                    <div class="row page-header-actions col-xs-6">

                        <!-- BOTONES DEL MÓDULO -->
                        <?php require_once(CORE_PATH . '/src/views/stage/buttons.php'); ?>

                    </div>
                </div>
    <div class="page-content">

        <!-- VENTANA MODAL DEL MÓDULO -->
        <div class="modal fade example-modal-lg" id="core-ventanaModal" aria-hidden="true" aria-labelledby="core-ventanaModal" role="dialog" tabindex="-1" style="display: none;">
        </div>

        <div <?php echo(isset($_SESSION['modulos'][$this->sysController]['caracteristicas']['BPAN']) ? '' : 'class="panel"') ?>>
            <div <?php echo(isset($_SESSION['modulos'][$this->sysController]['caracteristicas']['BPAN']) ? '' : 'class="panel-body container-fluid"') ?>>

