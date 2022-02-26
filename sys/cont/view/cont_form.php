<?php 
 
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
 

 
 
?>
<div class="row">
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
<input value="<?php echo (!empty($result['skContrato']) ? $result['skContrato'] : '');?>" name="skContrato" id="skContrato"  type="hidden">

    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos Generales</h3>
        </div>
        <div class="panel-body container-fluid">
                  <div class="row row-lg col-lg-12">
                  <div class="col-md-3 col-lg-3">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger">*</b> CLIENTE:</h4>
                                <select name="skEmpresaSocioCliente" id="skEmpresaSocioCliente" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                                    <?php
                                    if (!empty($result['skEmpresaSocioCliente'])) {
                                        ?>
                                        <option value="<?php echo $result['skEmpresaSocioCliente']; ?>" selected="selected"><?php echo $result['cliente']; ?></option>
                                        <?php
                                    }//ENDIF
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger">*</b> FECHA INICIO CONTRATO:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="wb-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input class="form-control input-datepicker" id="dFechaInicioContrato" name="dFechaInicioContrato" value="<?php echo (!empty($result['dFechaInicioContrato'])) ? date('d/m/Y', strtotime($result['dFechaInicioContrato'])) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                            </div>
                        </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger">*</b> FECHA INICIO COBRO:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="wb-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input class="form-control input-datepicker" id="dFechaInicioCobro" name="dFechaInicioCobro" value="<?php echo (!empty($result['dFechaInicioCobro'])) ? date('d/m/Y', strtotime($result['dFechaInicioCobro'])) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger">*</b> DIA DE COBRO:</h4>
                                <input class="form-control" name="iDiaCorte" value="<?php echo (isset($result['iDiaCorte'])) ? $result['iDiaCorte'] : ''; ?>" placeholder="DIA DE COBRO" autocomplete="off" type="text">
                            </div>
                        </div>

                        <div class="row col-md-12 col-lg-12"><hr></div>
                

                <div class="row col-md-12 col-lg-12"><hr></div>
                 
       
                        <div class="col-md-4 col-lg-4">
                         <div class="form-group">
                             <h4 class="example-title"><span class="required text-danger">*</span> TIPO DE PERIODO</h4>
                             <select id="skTipoPeriodo"  name="skTipoPeriodo" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">Seleccionar</option>
                                 <?php
                                 if ($data['tipoPeriodo']) {
                                    foreach ( $data['tipoPeriodo'] as $row) {
                                     utf8($row);
                                     ?>
                                     <option <?php echo(isset($result['skTipoPeriodo']) && $result['skTipoPeriodo'] == $row['skTipoPeriodo'] ? 'selected="selected"' : ""); ?>
                                         value="<?php echo $row['skTipoPeriodo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                     </div>

                        <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>DETALLE DEL SERVICIO:</h4>
                            <textarea class="form-control" id="sDetallesServicio" name="sDetallesServicio" rows="5" placeholder="DETALLES DEL SERVICIO" autocomplete="off"><?php echo (isset($result['sDetallesServicio'])) ? $result['sDetallesServicio'] : ''; ?></textarea>
                        </div>
                    </div>

                        
                    <div class="row col-md-12 col-lg-12"><hr></div>

                    <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger"></b>TELÉFONO:</h4>
                                <input class="form-control" name="sTelefono" value="<?php echo (isset($result['sTelefono'])) ? $result['sTelefono'] : ''; ?>" placeholder="TELÉFONO" autocomplete="off" type="text">
                            </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>CORREO:</h4>
                            <input class="form-control" name="sCorreo" value="<?php echo (isset($result['sCorreo'])) ? $result['sCorreo'] : ''; ?>" placeholder="CORREO" autocomplete="off" type="text">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>DIRECCIÓN:</h4>
                            <input class="form-control" name="sDireccion" value="<?php echo (isset($result['sDireccion'])) ? $result['sDireccion'] : ''; ?>" placeholder="DIRECCIÓN" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="row col-md-12 col-lg-12"><hr></div>

                    <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                             <h4 class="example-title">REPORTE DE LA INSTALACIÓN  
                             <i class="icon wb-help-circle help-text" aria-hidden="true"
                                    data-content="REPORTE DE INSTALACIÓN"
                                    data-trigger="hover"></i></h4>
                             <textarea class="form-control" id="sReporteInstalacion" name="sReporteInstalacion" rows="5" placeholder="REPORTE DE LA INSTALACIÓN" autocomplete="off"><?php echo (isset($result['sReporteInstalacion'])) ? $result['sReporteInstalacion'] : ''; ?></textarea>
                         </div>
                     </div>
                   
               

                              
                                
                  </div>
             
                 
                      
                 
    </div>
</div>
 
      


</form>
</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    core.formValidaciones.fields = cont.cont_form.validaciones;
 

     
      
  
    $(document).ready(function () {
        $("#skFormaPago").select2({placeholder: "Forma de Pago", allowClear: true });
        $("#skMetodoPago").select2({placeholder: "Metodo de Pago", allowClear: true });
        $("#skUsoCFDI").select2({placeholder: "Uso de CFDI", allowClear: true });
        $('.help-text').webuiPopover();
        $(".input-datepicker").datepicker({
                format: "dd/mm/yyyy"
            });
        $('#core-guardar').formValidation(core.formValidaciones); 
        $("#skAccessPoint").select2({placeholder: "ACCESS POINT", allowClear: true });
        $("#skTipoPeriodo").select2({placeholder: "TIPO DE PERIODO", allowClear: true });
        $('[data-plugin="switchery"]').each(function () {
                new Switchery(this, {
                    color: $(this).data('color'),
                    size: $(this).data('size')
                });
            });

        
        core.autocomplete2('#skEmpresaSocioCliente', 'get_empresas', window.location.href, 'CLIENTE');
        core.autocomplete2('#skEmpresaSocioFacturacion', 'get_empresas', window.location.href, 'FACTURACION');
        core.autocomplete2('#skAntena', 'get_servicios', window.location.href, 'ANTENA');
        core.autocomplete2('#skServicio', 'get_servicios', window.location.href, 'SERVICIOS');
        
         
       
       
    });
</script>
