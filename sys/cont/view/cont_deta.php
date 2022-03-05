<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    
    $cobros_contratos = (isset($data['cobros_contratos'])) ? $data['cobros_contratos'] : ''; 
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
    <input value="<?php echo (!empty($data['datos']['skContrato']) ? $data['datos']['skContrato'] : '');?>" name="skContrato"
        id="skContrato" type="hidden">

    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS GENERALES</h3>
        </div>
        <div class="panel-body container-fluid">
            <div class="row row-lg col-lg-12">

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">ESTATUS:</h4>
                        <span><i><span class="<?php echo (!empty($data['datos']['estatusColor']) ? $data['datos']['estatusColor'] : '');?> <?php echo (!empty($data['datos']['estatusIcono']) ? $data['datos']['estatusIcono'] : '');?>"> <?php echo (!empty($data['datos']['estatus']) ? $data['datos']['estatus'] : '');?></span></i></span>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-calendar"></span></i> FECHA DE CREACIÓN:</h4>
                        <span><?php echo (!empty($data['datos']['dFechaCreacion']) ? date('d/m/Y', strtotime($data['datos']['dFechaCreacion'])) : '-');?></span>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-user"></span></i> USUARIO DE CREACIÓN:</h4>
                        <span><?php echo (!empty($data['datos']['usuarioCreacion']) ? $data['datos']['usuarioCreacion'] : '-');?></span>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-building"></span></i> CLIENTE:</h4>
                        <span><?php echo (!empty($data['datos']['cliente']) ? $data['datos']['cliente'] : '-');?></span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-folder-open"></span></i> TIPO DE CONTRATO:</h4>
                        <span><?php echo (!empty($data['datos']['tipoContrato']) ? $data['datos']['tipoContrato'] : '-');?></span>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-calendar"></span></i> FECHA DE INSTALACIÓN:</h4>
                        <span><?php echo (!empty($data['datos']['dFechaInstalacion']) ? date('d/m/Y', strtotime($data['datos']['dFechaInstalacion'])) : '-');?></span>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-calendar"></span></i> FRECUENCIA DE MANTENIMIENTO MENSUAL:
                        </h4>
                        <span><?php echo (!empty($data['datos']['iFrecuenciaMantenimientoMensual']) ? $data['datos']['iFrecuenciaMantenimientoMensual'] : '-');?></span>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-list-ol"></span></i> DÍA DE MANTENIMIENTO:</h4>
                        <span><?php echo (!empty($data['datos']['iDiaMantenimiento']) ? $data['datos']['iDiaMantenimiento'] : '-');?></span>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-mobile-phone"></span></i> TELÉFONO:</h4>
                        <span><?php echo (!empty($data['datos']['sTelefono']) ? $data['datos']['sTelefono'] : '-');?></span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-envelope"></span></i> CORREO:</h4>
                        <span><?php echo (!empty($data['datos']['sCorreo']) ? $data['datos']['sCorreo'] : '-');?></span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-building"></span></i> DOMICILIO:</h4>
                        <span><?php echo (!empty($data['datos']['sDomicilio']) ? $data['datos']['sDomicilio'] : '-');?></span>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <h4 class="example-title">
                            <i><span class="text-default fa fa-pencil-square"></span></i> OBSERVACIONES:
                            <i class="icon wb-help-circle help-text" data-content="OBSERVACIONES" aria-hidden="true"
                                data-trigger="hover"></i>
                        </h4>
                        <span><?php echo (!empty($data['datos']['sObservaciones']) ? nl2br($data['datos']['sObservaciones']) : '-');?></span>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-calendar"></span></i> FECHA DE MODIFICACIÓN:</h4>
                        <span><?php echo (!empty($data['datos']['dFechaModificacion']) ? date('d/m/Y', strtotime($data['datos']['dFechaModificacion'])) : '-');?></span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-user"></span></i> USUARIO DE MODIFICACIÓN:</h4>
                        <span><?php echo (!empty($data['datos']['usuarioModificacion']) ? $data['datos']['usuarioModificacion'] : '-');?></span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-calendar"></span></i> FECHA DE CANCELACIÓN:</h4>
                        <span><?php echo (!empty($data['datos']['dFechaCancelacion']) ? date('d/m/Y', strtotime($data['datos']['dFechaCancelacion'])) : '-');?></span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-user"></span></i> USUARIO DE CANCELACIÓN:</h4>
                        <span><?php echo (!empty($data['datos']['usuarioCancelacion']) ? $data['datos']['usuarioCancelacion'] : '-');?></span>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>
            
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-file"></span></i> DOCUMENTOS:</h4>
                        <div class="col-md-12" id="docu_CONTRA_DOCGEN"></div>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                <hr>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <h4 class="example-title"><i><span class="text-default fa fa-photo"></span></i> FOTOGRAFÍAS:</h4>
                        <div class="col-md-12" id="docu_CONTRA_FOTOGR"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</form>



<!--
<div class="panel panel-bordered panel-primary panel-line ">
        <div class="panel-heading">
            <h3 class="panel-title text-center">COBROS REALIZADOS</h3>
        </div>
        <div class="widget ">
            <div class="widget-content padding-35 bg-white clearfix" id="divTablaCobros">

            <table class="table table-hover table-bordered" id="core-dataTableCobros">
            <thead>
            <th class="text-center"><label data-toggle="tooltip"  title="FECHA"><b style="font-size: 14px;">Nº</b></label></th>
            <th class="text-center"><label data-toggle="tooltip"  title="FECHA"><b style="font-size: 14px;">FECHA CREACIÓN</b></label></th>
            <th class="text-center"><label data-toggle="tooltip"  title="ANIO"><b style="font-size: 14px;">AÑO</b></label></th>
            <th class="text-center"><label data-toggle="tooltip"  title="MES"><b style="font-size: 14px;">MES</b></label></th>
            <th class="text-center"><label data-toggle="tooltip"  title="DIA"><b style="font-size: 14px;">DIA</b></label></th>
            <th class="text-center"><label data-toggle="tooltip"  title="PERIODO"><b style="font-size: 14px;">PERIODO</b></label></th>
            <th class="text-center"><label data-toggle="tooltip"  title="ORDEN DE SERVICIO"><b style="font-size: 14px;">FOLIO DE ORDEN DE COBRO</b></label></th>
            <th class="text-center"><label data-toggle="tooltip"  title="TOTAL"><b style="font-size: 14px;">TOTAL</b></label></th>
            </thead>
            <tbody id="tabla_cobros" >
            <?php if (!empty($cobros_contratos)) { ?>
            <?php $i = 1; foreach ($cobros_contratos AS $cont) { ?>
                <th class="text-center" style="font-size: 14px;"><?php echo $i; ?></th>
                <th class="text-center" style="font-size: 14px;"><?php echo (!empty($cont['dFechaCreacion']) ? date('d/m/Y', strtotime($cont['dFechaCreacion'])) : ''); ?></th>
                <th class="text-center" style="font-size: 14px;"><?php echo (!empty($cont['iAnio']) ?$cont['iAnio'] : ''); ?></th> 
                <th class="text-center" style="font-size: 14px;"><?php echo (!empty($cont['iMes']) ?$cont['iMes'] : ''); ?></th>
                <th class="text-center" style="font-size: 14px;"><?php echo (!empty($cont['iDia']) ?$cont['iDia'] : ''); ?></th>
                <th class="text-center" style="font-size: 14px;"><?php echo (!empty($cont['tipoPeriodo']) ?$cont['tipoPeriodo'] : ''); ?></th>
                <th class="text-center" style="font-size: 14px;"><?php echo (!empty($cont['iFolio']) ?$cont['iFolio'] : ''); ?></th>
                <th class="text-center" style="font-size: 14px;"><?php echo (!empty($cont['fImporteTotal']) ? "$ ".number_format($cont['fImporteTotal'],2) : ''); ?></th>
            </tr>

            <?php $i++;} ?>
            <?php } ?>

            </tbody>
        </table>
        </div>
            
        </div>

    </div>


</div>  
!-->

 

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

     
    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
        
        $('[data-toggle="tooltip"]').tooltip();

        $('.ajax-popup-link').magnificPopup({
            type: 'iframe'
        });

        $('#docu_CONTRA_DOCGEN').core_docu_component({
            skTipoExpediente: 'CONTRA',
            skTipoDocumento: 'DOCGEN',
            skCodigo: '<?php echo isset($data['datos']['skContrato']) ? $data['datos']['skContrato'] : ''; ?>',
            name: 'docu_file_CONTRA_DOCGEN',
            readOnly: true,
            deleteCallBack: function (e) {
                
            }
        });

        $('#docu_CONTRA_FOTOGR').core_docu_component({
            skTipoExpediente: 'CONTRA',
            skTipoDocumento: 'FOTOGR',
            skCodigo: '<?php echo isset($data['datos']['skContrato']) ? $data['datos']['skContrato'] : ''; ?>',
            name: 'docu_file_CONTRA_FOTOGR',
            readOnly: true,
            deleteCallBack: function (e) {
                
            }
        });
      
    });

</script>
