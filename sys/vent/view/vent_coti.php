<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];

    utf8($result);
}

?>

<div class="row">
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
<input value="<?php echo (!empty($result['skCotizacion']) ? $result['skCotizacion'] : '');?>" name="skCotizacion" id="skCotizacion"  type="hidden">
        <div class="panel panel-bordered panel-primary panel-line" style="display: block;">
          <div class="panel-heading">
            <h3 class="panel-title">DATOS GENERALES</h3>
            <?php
							if(isset($result['iFolio'])){
					?>
					<div class="alert alert-primary alert-dismissible" role="alert">
							<b class="red-600 font-size-24"><?php echo (isset($result['iFolio'])) ? ($result['iFolio']) : ''; ?></b>
					</div>
					<?php }//ENDIF ?>
           
          </div>

          <div class="panel-body container-fluid" >
          <div class="col-md-12 same-heigth">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">MONEDA :</h4>
                            <p><?php echo (!empty($result['skDivisa'])) ? $result['skDivisa'] : '';?> </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                          <div class="form-group">
                              <h4 class="example-title">CATEGORIA</h4>
                              <p><?php echo (!empty($result['categoria'])) ? $result['categoria'] : '';?></p>
                          </div>
                      </div>
						
                      <div class="col-md-4 col-lg-4">
                          <div class="form-group">
                              <h4 class="example-title">VIGENCIA</h4>
                              <p><?php echo (!empty($result['dFechaVigencia'])) ? date('d/m/Y', strtotime($result['dFechaVigencia'])) : ''; ?></p>
                          </div>
                      </div>
                        
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">CLIENTE:</h4>
                                <p><?php echo (!empty($result['cliente'])) ? $result['cliente'] : '';?> </p>
                            </div>
                        </div>
						            <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">PROSPECTO:</h4>
                                <p><?php echo (!empty($result['prospecto'])) ? $result['prospecto'] : '';?> </p>
                            </div>
                        </div>
						            <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">COSTO RECIBO:</h4>
                                <p><?php echo (!empty($result['fCostoRecibo'])) ? $result['fCostoRecibo'] : '';?> </p>
                            </div>
                        </div>
                </div>
        </div>
      </div>



        <div class="panel panel-bordered panel-primary panel-line" >
            
            <div class="panel-heading">
			        <h3 class="panel-title">servicios</h3>
		  	    </div>

            <div class="panel-body container-fluid">
              <div class="col-md-12 page-invoice-table table-responsive font-size-12">
              <table class="table text-right">
                <thead>
                  <tr> 
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">CODIGO</th>
                    
                    <th class="text-left" >Concepto</th>   
                  </tr>
                </thead>
              <tbody>
                <?php
                if (isset($data['serviciosCotizacion'])) {
                  $i=0;
                  foreach ($data['serviciosCotizacion'] AS $servicios) {
                    ?>
                    <tr> 
                    <td style="text-align:right; text-transform: uppercase;" >
                        <input type="hidden" name="concepto[<?php echo $i;?>][fCantidad]" value="<?php  echo $servicios['fCantidad']; ?>">
                        <input type="hidden" name="concepto[<?php echo $i;?>][skCotizacionConcepto] " value="<?php  echo $servicios['skCotizacionConcepto']; ?>">
                        <input type="hidden" name="concepto[<?php echo $i;?>][skServicio]" value="<?php  echo $servicios['skServicio']; ?>">
                        <input type="hidden" name="concepto[<?php echo $i;?>][iDetalle]" value="<?php  echo (!empty($servicios['iDetalle']) ? $servicios['iDetalle'] : NULL ); ?>">
                        <?php echo number_format($servicios['fCantidad'], 2); ?>
                    </td> 
                    <td style="text-align:right; text-transform: uppercase;" >
                      <?php echo $servicios['sCodigo']; ?>
                    </td> 
                    <td style="text-align:left; text-transform: uppercase;" >
                      <?php echo $servicios['concepto'].(!empty($servicios['sDescripcion']) ? " (".$servicios['sDescripcion'].")" : ''); ?>
                    </td>
                    </tr>
                    <?php if(!empty($servicios['iDetalle']) && $servicios['iDetalle'] == 1 ){  
                      // for sobre la cantidad 
                      for ($j=0; $j < $servicios['fCantidad']; $j++) {  ?> 
                         <tr>
                         <td></td>
                         <td></td>
                         <td class="text-left"> <select name="concepto[<?php echo $i;?>][skServicioInventario][<?php echo $j;?>]"  class="<?php  echo $servicios['skServicio']; ?> form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>
                         </tr>

                        
                     <?php  } //ENDFOR ?>
                     <script type="text/javascript">
 
                      core.autocomplete2('.<?php  echo $servicios['skServicio']; ?>', 'get_serviciosInventario', window.location.href, 'Concepto', { skServicio : '<?php  echo $servicios['skServicio']; ?>'});
                     </script>


                    <?php  } //ENDIF  ?>
                    <?php
                     $i++;
                  }//FOREACH
                 
                }//ENDIF
                ?>
              </tbody>
              </table>
            </div>
          </div>
    </div>

    </form>
</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
   

  
    $(document).ready(function () {
      $('#core-guardar').formValidation(core.formValidaciones);
         
    });

</script>
