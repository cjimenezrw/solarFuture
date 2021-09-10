<?php
//exit('<pre>'.print_r($data,1).'</pre>');
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered panel-primary panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">DATOS GENERALES</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>RECIBE ENTREGA:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="wb-user" aria-hidden="true"></i>
                                    </span>
                                    <input id="sRecibeEntrega" name="sRecibeEntrega" placeholder="RECIBE ENTREGA" type="text" class="form-control" autocomplete="off"   
                                    value = "<?php echo isset($data['datos']['sRecibeEntrega']) ? $data['datos']['sRecibeEntrega'] : $data['datos']['cliente']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>Fecha de Instalación:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="wb-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input class="form-control input-datepicker" id="dFechaEntregaInstalacion" name="dFechaEntregaInstalacion" 
                                    value="<?php echo (!empty($data['datos']['dFechaEntregaInstalacion']) ? date('d/m/Y', strtotime($data['datos']['dFechaEntregaInstalacion'])) : ''); ?>" 
                                    placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row row-lg">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>OBSERVACIONES DE LA INSTALACIÓN:</h4>
                                <textarea id="sObservacionesInstalacion" name="sObservacionesInstalacion" placeholder="OBSERVACIONES DE LA INSTALACIÓN" class="form-control" rows="3"><?php echo isset($data['datos']['sObservacionesInstalacion']) ? $data['datos']['sObservacionesInstalacion'] : ''; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>FOTOGRAFÍAS:</h4>
                                <div class="col-md-12" id="docu_OPERAT_FOTOGR"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validaciones;

    $(document).ready(function () {

        $('#core-guardar').formValidation(core.formValidaciones);

        $(".input-datepicker").datepicker({
            format: "dd/mm/yyyy"
        });

        $('#docu_OPERAT_FOTOGR').core_docu_component({
            skTipoExpediente: 'OPERAT',
            skTipoDocumento: 'FOTOGR',
            skCodigo: '<?php echo isset($data['datos']['skCotizacion']) ? $data['datos']['skCotizacion'] : ''; ?>',
            name: 'docu_file_OPERAT_FOTOGR',
            deleteCallBack: function (e) {
                
            }
        });

    });

</script>