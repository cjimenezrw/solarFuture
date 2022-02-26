
        <div class="row">
            <div class="col-md-12" <?php echo (!empty($data['datos']['skEstatus']) && $data['datos']['skEstatus'] == 'CA') ? '' : 'hidden'; ?>>
            <div role="alert" class="alert dark alert-danger alert-icon alert-dismissible animated slideInDown">
                <p class="font-size-20"><b><i class="icon wb-bell" aria-hidden="true"></i> ACCESS POINT CANCELADO</b></p>
                <p><b><?php echo (!empty($data['datos']['usuarioCancelacion']) ? $data['datos']['usuarioCancelacion'] : ''); ?></b> canceló el access point por la siguiente razón: <b><?php echo (!empty($data['datos']['sObservacionesCancelacion']) ? $data['datos']['sObservacionesCancelacion'] : '-'); ?></b></p>
                <p class="font-size-18"><i class="icon wb-calendar" aria-hidden="true"></i> Fecha de Cancelación: <b><?php echo (!empty($data['datos']['dFechaCancelacion'])) ? $this->obtenerFechaEnLetra($data['datos']['dFechaCancelacion']) : ''; ?></b>, Hora: <b><?php echo (!empty($data['datos']['dFechaCancelacion']) ? date('H:i:s', strtotime($data['datos']['dFechaCancelacion'])) : ''); ?></b></p>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-bordered panel-primary panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">DATOS GENERALES</h3>
                </div>
                <?php
                    if(!empty($data['datos']['sMAC'])){
                ?>
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <b class="red-600 font-size-24">MAC: <?php echo (!empty($data['datos']['sMAC'])) ? $data['datos']['sMAC'] : '-'; ?></b>
                </div>
                <?php
                    }//ENDIF
                ?>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">ESTATUS:</h4>
                                <label><i class="fa <?php echo (!empty($data['datos']['estatusIcono']) ? $data['datos']['estatusIcono'] : '-'); ?> <?php echo (!empty($data['datos']['estatusColor']) ? $data['datos']['estatusColor'] : ''); ?>" aria-hidden="true"> <?php echo (!empty($data['datos']['estatus']) ? $data['datos']['estatus'] : ''); ?></i></label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">USUARIO CREACIÓN:</h4>
                                <span><?php echo (!empty($data['datos']['usuarioCreacion']) ? $data['datos']['usuarioCreacion'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">FECHA CREACIÓN:</h4>
                                <span><?php echo (!empty($data['datos']['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($data['datos']['dFechaCreacion'])) : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"><hr></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">MAC:</h4>
                                <span><?php echo (!empty($data['datos']['sMAC']) ? $data['datos']['sMAC'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">NOMBRE:</h4>
                                <span><?php echo (!empty($data['datos']['sNombre']) ? $data['datos']['sNombre'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">TORRE:</h4>
                                <span><?php echo (!empty($data['datos']['nombreTorre']) ? '('.$data['datos']['MACtorre'].') '.$data['datos']['nombreTorre'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">OBSERVACIONES:</h4>
                                <span><?php echo (!empty($data['datos']['sObservaciones']) ? $data['datos']['sObservaciones'] : '-'); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-bordered panel-primary panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">CONTRATOS</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-lg-12 col-md-12">
                            <div class="input-group margin-top-20"> <span class="input-group-addon">FILTRAR</span>
                                <input id="inputFilter" onkeyup="searchFilter();" type="text" class="form-control" autocomplete="off" placeholder="ESCRIBE AQUÍ PARA BUSCAR CUALQUIER DATO DE LA TABLA...">
                            </div>
                            <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-2">MAC</th>
                                    <th class="col-md-9">CLIENTE</th>
                                </tr>
                            </thead>
                            <tbody class="tbody_searchable">
                                <?php 
                                if(isset($data['_get_contratos']) && !empty($data['_get_contratos']) && is_array($data['_get_contratos'])){
                                    $i = 1;
                                    foreach($data['_get_contratos'] AS $row) { 
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo (!empty($row['sMAC'])) ? $row['sMAC'] : ''; ?></td>
                                        <td><?php echo (!empty($row['cliente'])) ? $row['cliente'] : ''; ?></td>
                                    </tr>
                                <?php 
                                    $i++;
                                    }//FOREACH
                                }else{
                                ?>
                                    <tr>
                                        <td colspan="3" class="text-center"><b>- SIN DATOS PARA MOSTRAR -</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    
    function searchFilter() {
        var rex = new RegExp($("#inputFilter").val(), 'i');
        $('.tbody_searchable tr').hide();
        $('.tbody_searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();
    }

    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    });
</script>