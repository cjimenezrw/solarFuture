<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    
    $cobros_contratos = (isset($data['cobros_contratos'])) ? $data['cobros_contratos'] : ''; 
    utf8($result);
}

?>

<div class="row">
   <div class="col-md-12 page-invoice ">

  <div class="panel panel-bordered panel-primary panel-line" >
      <div class="panel-heading">
        <h3 class="panel-title">DATOS GENERALES</h3>
        <?php
		    if (isset($result['sFolio'])) {
			?>
    		    <div class="alert alert-primary alert-dismissible" role="alert">
    			<b class="red-600 font-size-20"><?php echo (isset($result['sFolio'])) ? ($result['sFolio']) : ''; ?></b>
    		    </div>
		    <?php }//ENDIF  ?>
      </div>

    <div class="panel-body container-fluid"  >
        
          <div class="col-md-12 same-heigth">
          <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">CLIENTE:</h4>
                <p><?php echo (!empty($result['cliente'])) ? $result['cliente'] : '';?> </p>
              </div>
            </div>
            <div class="col-md-3 col-lg-3">
            <div class="form-group">
              <h4 class="example-title">FECHA INICIO CONTRATO </h4>
              <p><?php echo (!empty($result['dFechaInicioContrato'])) ? date('d/m/Y', strtotime($result['dFechaInicioContrato'])) : ''; ?></p>
            </div>
          </div>
            <div class="col-md-3 col-lg-3">
            <div class="form-group">
              <h4 class="example-title">FECHA INICIO COBRO </h4>
              <p><?php echo (!empty($result['dFechaInicioCobro'])) ? date('d/m/Y', strtotime($result['dFechaInicioCobro'])) : ''; ?></p>
            </div>
          </div>
          <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">DIA DE COBRO:</h4>
                <p><?php echo (!empty($result['iDiaCorte'])) ? $result['iDiaCorte'] : '';?> </p>
              </div>
            </div>
           
           
           
            
        </div>
        <div class="col-md-12 same-heigth">
          <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">FACTURACION:</h4>
                <p><?php echo (!empty($result['facturacion'])) ? $result['facturacion'] : '';?> </p>
              </div>
            </div>
            <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">USO DE CFDI:</h4>
                <p><?php echo (!empty($result['skUsoCFDI'])) ? $result['skUsoCFDI'] : '';?> </p>
              </div>
            </div>
            <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">METODO DE PAGO:</h4>
                <p><?php echo (!empty($result['skMetodoPago'])) ? $result['skMetodoPago'] : '';?> </p>
              </div>
            </div>
            <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">FORMA DE PAGO:</h4>
                <p><?php echo (!empty($result['skFormaPago'])) ? $result['skFormaPago'] : '';?> </p>
              </div>
            </div>
        </div>
        <div class="col-md-12 same-heigth">
        <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">FACTURABLE:</h4>
                <p><?php echo (!empty($result['iNoFacturable'])) ? 'NO': 'SI';?> </p>
              </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12"><hr></div>
        <div class="col-md-12 same-heigth">

        <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">TORRE:</h4>
                <p><?php echo (!empty($result['torre'])) ? $result['torre'] : '';?> </p>
              </div>
            </div> 

          <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">ACCESS POINT:</h4>
                <p><?php echo (!empty($result['accessPoint'])) ? $result['accessPoint'] : '';?> </p>
              </div>
            </div> 
            
            <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">MAC:</h4>
                <p><?php echo (!empty($result['sMAC'])) ? $result['sMAC'] : '';?> </p>
              </div>
            </div> 
            <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">TIPO DE PERIODO:</h4>
                <p><?php echo (!empty($result['tipoPeriodo'])) ? $result['tipoPeriodo'] : '';?> </p>
              </div>
            </div> 

        </div>
        <div class="col-md-12 col-lg-12"><hr></div>
        <div class="col-md-12 same-heigth">
          
          <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">SERVICIO:</h4>
                <p><?php echo (!empty($result['servicio'])) ? $result['servicio'] : '';?> </p>
              </div>
            </div> 
            <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">COSTO SERVICIO:</h4>
                <p><?php echo (!empty($result['fCostoServicio'])) ? "$ ".number_format($result['fCostoServicio'],2) : '';?> </p>
              </div>
            </div> 
            <div class="col-md-6 col-lg-6">
              <div class="form-group">
                <h4 class="example-title">DETALLES DEL SERVICIO:</h4>
                <p><?php echo (!empty($result['sDetallesServicio'])) ? $result['sDetallesServicio'] : '';?> </p>
              </div>
            </div> 

        </div>
        <div class="col-md-12 col-lg-12"><hr></div>
        <div class="col-md-12 same-heigth">
          
          <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">TELEFONO:</h4>
                <p><?php echo (!empty($result['sTelefono'])) ? $result['sTelefono'] : '';?> </p>
              </div>
            </div> 
            <div class="col-md-3 col-lg-3">
              <div class="form-group">
                <h4 class="example-title">CORREO:</h4>
                <p><?php echo (!empty($result['sCorreo'])) ? $result['sCorreo']  : '';?> </p>
              </div>
            </div> 
            <div class="col-md-6 col-lg-6">
              <div class="form-group">
                <h4 class="example-title">DIRECCION:</h4>
                <p><?php echo (!empty($result['sDireccion'])) ? $result['sDireccion'] : '';?> </p>
              </div>
            </div> 

        </div>

        <div class="col-md-12 col-lg-12"><hr></div>
        <div class="col-md-12 same-heigth">
          
          <div class="col-md-12 col-lg-12">
              <div class="form-group">
                <h4 class="example-title">REPORTE DE INSTALACION:</h4>
                <p><?php echo (!empty($result['sReporteInstalacion'])) ? $result['sReporteInstalacion'] : '';?> </p>
              </div>
            </div>  

        </div>
      </div>
    </div>

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
</div> 

 

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

     
    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
        
        $('[data-toggle="tooltip"]').tooltip();
        $('.ajax-popup-link').magnificPopup({
					type: 'iframe'
      });
      
      
           

    });

</script>
