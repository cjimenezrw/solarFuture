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
                        <select name="skEmpresaSocioCliente" id="skEmpresaSocioCliente" class="form-control"
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
                        <h4 class="example-title"><b class="text-danger">*</b> EMPRESA A FACTURAR:</h4>
                        <select name="skEmpresaSocioFacturacion" id="skEmpresaSocioFacturacion" class="form-control"
                            data-plugin="select2" data-ajax--cache="true">
                            <?php
                                    if (!empty($result['skEmpresaSocioFacturacion'])) {
                                        ?>
                            <option value="<?php echo $result['skEmpresaSocioFacturacion']; ?>" selected="selected">
                                <?php echo $result['cliente']; ?></option>
                            <?php
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
                                 if ($data['tipoPeriodo']) {
                                    foreach ( $data['tipoPeriodo'] as $row) {
                                     utf8($row);
                                     ?>
                            <option
                                <?php echo(isset($result['skTipoPeriodo']) && $result['skTipoPeriodo'] == $row['skTipoPeriodo'] ? 'selected="selected"' : ""); ?>
                                value="<?php echo $row['skTipoPeriodo']; ?>"> <?php echo $row['sNombre']; ?>
                            </option>
                            <?php
                                     }//ENDWHILE
                                 }//ENDIF
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

                <div class="row row-lg col-md-12 col-lg-12">
                    <hr>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> TELÉFONO:</h4>
                        <input class="form-control" name="sTelefono" id="sTelefono"
                            value="<?php echo (isset($result['sTelefono'])) ? $result['sTelefono'] : ''; ?>"
                            placeholder="TELÉFONO" autocomplete="off" type="text">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> CORREO:</h4>
                        <input class="form-control" name="sCorreo" id="sCorreo"
                            value="<?php echo (isset($result['sCorreo'])) ? $result['sCorreo'] : ''; ?>"
                            placeholder="CORREO" autocomplete="off" type="text">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> DOMICILIO:</h4>
                        <input class="form-control" name="sDomicilio" id="sDomicilio"
                            value="<?php echo (isset($result['sDireccion'])) ? $result['sDireccion'] : ''; ?>"
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

            </div>
        </div>
    </div>

    <div class="panel panel-bordered panel-dark panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS DE FACTURACIÓN</h3>
            <ul class="panel-actions panel-actions-keep">
                <li>
                    <h4 class="example-title">NO FACTURABLE:</h4>
                    <input type="checkbox" class="js-switch-large" data-plugin="switchery" data-color="#4d94ff"
                        <?php echo !empty($data['datos']['iNoFacturable']) ? 'checked' : ''; ?> name="iNoFacturable"
                        id="iNoFacturable" value="1" />
                </li>

            </ul>
        </div>
        <div class="panel-body container-fluid">
            <div class="row row-lg col-lg-12">

                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <h4 class="example-title">EMPRESA A FACTURAR:</h4>
                        <select name="skEmpresaSocioFacturacion" id="skEmpresaSocioFacturacion" class="form-control"
                            data-plugin="select2" data-ajax--cache="true">
                            <?php
                            if (!empty($data['datos']['skEmpresaSocioFacturacion'])) {
                                ?>
                            <option value="<?php echo $data['datos']['skEmpresaSocioFacturacion']; ?>"
                                selected="selected">
                                <?php echo $data['datos']['empresaFacturacion'] . ' (' . $data['datos']['empresaFacturacionRFC'] . ')'; ?>
                            </option>
                            <?php
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
                        <h4 class="example-title"><span class="required text-danger">*</span> DIVISA:</h4>
                        <select id="skDivisa" name="skDivisa" class="form-control" data-plugin="select2" select2Simple>
                            <option value="">- SELECCIONAR -</option>
                            <?php
                                 if ($data['divisas']) {
                                 foreach (  $data['divisas'] as $row) {
                                     utf8($row);
                                     ?>
                            <option
                                <?php echo(isset($data['datos']['skDivisa']) && $data['datos']['skDivisa'] == $row['skDivisa'] ? 'selected="selected"' : (!isset($data['datos']['skDivisa']) && $row['skDivisa'] == 'MXN' ? 'selected="selected"' : '')); ?>
                                value="<?php echo $row['skDivisa']; ?>">
                                <?php echo $row['sNombre'].' ('.$row['skDivisa'].')'; ?> </option>
                            <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                        </select>
                    </div>
                </div>

                <div class="row row-lg col-lg-12 clearfix">
                    <hr>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">MÉTODO DE PAGO</h4>
                        <select name="skMetodoPago" id="skMetodoPago" class="form-control" data-plugin="select2"
                            select2Simple>
                            <option value="">Seleccionar</option>
                            <?php
                            if ($data['metodoPago']) {
                                foreach ($data['metodoPago'] as $row) {
                                    utf8($row);
                                    ?>
                            <option
                                <?php echo(isset($data['datos']['skMetodoPago']) && $data['datos']['skMetodoPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?>
                                value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                            <?php
                                }//ENDWHILE
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">FORMA DE PAGO</h4>
                        <select name="skFormaPago" id="skFormaPago" class="form-control" data-plugin="select2"
                            select2Simple>
                            <option value="">Seleccionar</option>
                            <?php
                            if ($data['formaPago']) {
                                foreach ($data['formaPago'] as $row) {
                                    utf8($row);
                                    ?>
                            <option
                                <?php echo(isset($data['datos']['skFormaPago']) && $data['datos']['skFormaPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?>
                                value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                            <?php
                                }//ENDWHILE
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">USO DE CFDI</h4>
                        <select name="skUsoCFDI" id="skUsoCFDI" class="form-control" data-plugin="select2"
                            select2Simple>
                            <option value="">Seleccionar</option>
                            <?php
                            if ($data['usoCFDI']) {
                                foreach ($data['usoCFDI'] as $row) {
                                    utf8($row);
                                    ?>
                            <option
                                <?php echo(isset($data['datos']['skUsoCFDI']) && $data['datos']['skUsoCFDI'] == $row['sCodigo'] ? 'selected="selected"' : '') ?>
                                value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                            <?php
                                }//ENDWHILE
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>




            </div>
        </div>
    </div>


</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

core.formValidaciones.fields = cont.cont_form.validaciones;

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

    $("#skFormaPago").select2({
        placeholder: "Forma de Pago",
        allowClear: true
    });

    $("#skMetodoPago").select2({
        placeholder: "Metodo de Pago",
        allowClear: true
    });

    $("#skUsoCFDI").select2({
        placeholder: "Uso de CFDI",
        allowClear: true
    });

    $(".input-datepicker").datepicker({
        format: "dd/mm/yyyy"
    });
    
    $("#iFrecuenciaMantenimientoMensual").select2({
        placeholder: "FRECUENCIA DE MANTENIMIENTO MENSUAL",
        allowClear: true
    });

});
</script>