<?php 
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
    <input value="<?php echo (!empty($result['skContrato']) ? $result['skContrato'] : '');?>" name="skContrato"
        id="skContrato" type="hidden">

    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS GENERALES</h3>
        </div>
        <div class="panel-body container-fluid">
            <div class="row row-lg col-lg-12">

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> CLIENTE:</h4>
                        <select name="skEmpresaSocioCliente" id="skEmpresaSocioCliente" class="form-control" onchange="change_empresa(this);"
                            data-plugin="select2" data-ajax--cache="true">
                            <?php
                                    if (!empty($result['skEmpresaSocioCliente'])) {
                                        ?>
                            <option value="<?php echo $result['skEmpresaSocioCliente']; ?>" selected="selected">
                                <?php echo $result['cliente']; ?></option>
                            <?php
                                    }//ENDIF
                                    ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> TIPO DE CONTRATO:</h4>
                        <select id="skTipoContrato" name="skTipoContrato" class="form-control" data-plugin="select2" select2Simple>
                            <option value="">- SELECCIONAR -</option>
                            <?php
                                if (!empty($data['TIPCON'])) {
                                    foreach ($data['TIPCON'] AS $row) {
                            ?>
                                <option <?php echo(isset($data['datos']['skTipoContrato']) && $data['datos']['skTipoContrato'] == $row['skClave'] ? 'selected="selected"' : ''); ?>
                                value="<?php echo $row['skClave']; ?>"> <?php echo $row['sNombre']; ?> </option>
                            <?php
                                    }//ENDWHILE
                                }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> FECHA DE INSTALACIÓN:</h4>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="wb-calendar" aria-hidden="true"></i>
                            </span>
                            <input class="form-control input-datepicker" id="dFechaInstalacion" name="dFechaInstalacion"
                                value="<?php echo (!empty($result['dFechaInstalacion'])) ? date('d/m/Y', strtotime($result['dFechaInstalacion'])) : ''; ?>"
                                placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> FRECUENCIA DE MANTENIMIENTO MENSUAL:
                        </h4>
                        <select name="iFrecuenciaMantenimientoMensual" id="iFrecuenciaMantenimientoMensual"
                            class="form-control" data-plugin="select2" select2Simple>
                            <option value="">- SELECCIONAR -</option>
                            <?php
                                for($i=1;$i<=12;$i++){
                            ?>
                            <option
                                <?php echo(isset($result['iFrecuenciaMantenimientoMensual']) && $result['iFrecuenciaMantenimientoMensual'] == $i ? 'selected="selected"' : ""); ?>
                                value="<?php echo $i; ?>"><?php echo $i.($i==1 ? ' MES' : ' MESES'); ?>
                            </option>
                            <?php
                                }//ENDFOR
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> DIA DE MANTENIMIENTO:</h4>
                        <input class="form-control" name="iDiaMantenimiento"
                            value="<?php echo (isset($result['iDiaMantenimiento'])) ? $result['iDiaMantenimiento'] : ''; ?>"
                            placeholder="DIA DE MANTENIMIENTO" autocomplete="off" type="text">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">
                            FECHA DE PRÓXIMO MANTENIMIENTO:
                            <i class="icon wb-help-circle help-text" 
                            data-content="<span style='color:red;'>FECHA DE PRÓXIMO MANTENIMIENTO</span> <b>=</b> FECHA DE INSTALACIÓN <b>+</b> FRECUENCIA DE MANTENIMIENTO MENSUAL<hr>EL DIA DE MANTENIMIENTO ES EL DÍA DEL MES" 
                            aria-hidden="true" data-trigger="hover"></i>
                        </h4>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="wb-calendar" aria-hidden="true"></i>
                            </span>
                            <input class="form-control input-datepicker" id="dFechaProximoMantenimiento" name="dFechaProximoMantenimiento"
                                value="<?php echo (!empty($result['dFechaProximoMantenimiento'])) ? date('d/m/Y', strtotime($result['dFechaProximoMantenimiento'])) : ''; ?>"
                                placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                        </div>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">TELÉFONO:</h4>
                        <input class="form-control" name="sTelefono" id="sTelefono"
                            value="<?php echo (isset($result['sTelefono'])) ? $result['sTelefono'] : ''; ?>"
                            placeholder="TELÉFONO" autocomplete="off" type="text">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">CORREO:</h4>
                        <input class="form-control" name="sCorreo" id="sCorreo"
                            value="<?php echo (isset($result['sCorreo'])) ? $result['sCorreo'] : ''; ?>"
                            placeholder="CORREO" autocomplete="off" type="text">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">DOMICILIO:</h4>
                        <input class="form-control" name="sDomicilio" id="sDomicilio"
                            value="<?php echo (isset($result['sDomicilio'])) ? $result['sDomicilio'] : ''; ?>"
                            placeholder="DOMICILIO" autocomplete="off" type="text">
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <h4 class="example-title">
                            OBSERVACIONES:
                            <i class="icon wb-help-circle help-text" data-content="OBSERVACIONES" aria-hidden="true"
                                data-trigger="hover"></i>
                        </h4>
                        <textarea class="form-control" name="sObservaciones" id="sObservaciones" rows="5"
                            placeholder="OBSERVACIONES"
                            autocomplete="off"><?php echo (isset($result['sObservaciones'])) ? $result['sObservaciones'] : ''; ?></textarea>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>
            
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <h4 class="example-title">DOCUMENTOS:</h4>
                        <div class="col-md-12" id="docu_CONTRA_DOCGEN"></div>
                    </div>
                </div>

                <div class="row row-lg col-md-12 col-lg-12">
                <hr>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <h4 class="example-title">FOTOGRAFÍAS:</h4>
                        <div class="col-md-12" id="docu_CONTRA_FOTOGR"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

core.formValidaciones.fields = cont.cont_form.validaciones;

function change_empresa(obj){
    var data = $("#skEmpresaSocioCliente").select2('data')[0].data;
    $("#sTelefono").val(data.sTelefono);
    $("#sCorreo").val(data.sCorreo);
    $("#sDomicilio").val(data.sDomicilio);
}

$(document).ready(function() {

    $('#core-guardar').formValidation(core.formValidaciones);

    $('.help-text').webuiPopover();

    $('[data-plugin="switchery"]').each(function() {
        new Switchery(this, {
            color: $(this).data('color'),
            size: $(this).data('size')
        });
    });

    core.autocomplete2('#skEmpresaSocioCliente', 'get_empresas', window.location.href, 'CLIENTE');
    core.autocomplete2('#skEmpresaSocioFacturacion', 'get_empresas', window.location.href, 'FACTURACIÓN');

    $("#skTipoContrato").select2({placeholder: "TIPO DE CONTRATO", allowClear: true });

    $(".input-datepicker").datepicker({
        format: "dd/mm/yyyy"
    });
    
    $("#iFrecuenciaMantenimientoMensual").select2({
        placeholder: "FRECUENCIA DE MANTENIMIENTO MENSUAL",
        allowClear: true
    });


    $('#docu_CONTRA_DOCGEN').core_docu_component({
        skTipoExpediente: 'CONTRA',
        skTipoDocumento: 'DOCGEN',
        skCodigo: '<?php echo isset($data['datos']['skContrato']) ? $data['datos']['skContrato'] : ''; ?>',
        name: 'docu_file_CONTRA_DOCGEN',
        deleteCallBack: function (e) {
            
        }
    });

    $('#docu_CONTRA_FOTOGR').core_docu_component({
        skTipoExpediente: 'CONTRA',
        skTipoDocumento: 'FOTOGR',
        skCodigo: '<?php echo isset($data['datos']['skContrato']) ? $data['datos']['skContrato'] : ''; ?>',
        name: 'docu_file_CONTRA_FOTOGR',
        deleteCallBack: function (e) {
            
        }
    });

});
</script>