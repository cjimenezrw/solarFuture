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


                        <div class="row row-lg col-lg-12 clearfix"><hr></div>

<div class="col-md-4 col-lg-4">
    <div class="form-group">
        <h4 class="example-title">MÉTODO DE PAGO</h4>
        <select name="skMetodoPago" id="skMetodoPago"  class="form-control" data-plugin="select2" select2Simple>
            <option value="">Seleccionar</option>
            <?php
            if ($data['metodoPago']) {
                foreach ($data['metodoPago'] as $row) {
                    utf8($row);
                    ?>
                    <option <?php echo(isset($data['datos']['skMetodoPago']) && $data['datos']['skMetodoPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
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
        <select name="skFormaPago" id="skFormaPago"  class="form-control" data-plugin="select2" select2Simple>
            <option value="">Seleccionar</option>
            <?php
            if ($data['formaPago']) {
                foreach ($data['formaPago'] as $row) {
                    utf8($row);
                    ?>
                    <option <?php echo(isset($data['datos']['skFormaPago']) && $data['datos']['skFormaPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
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
        <select name="skUsoCFDI" id="skUsoCFDI"  class="form-control" data-plugin="select2" select2Simple>
            <option value="">Seleccionar</option>
            <?php
            if ($data['usoCFDI']) {
                foreach ($data['usoCFDI'] as $row) {
                    utf8($row);
                    ?>
                    <option <?php echo(isset($data['datos']['skUsoCFDI']) && $data['datos']['skUsoCFDI'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
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
                    
                    <th class="text-left" >Servicio</th>   
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
                        <input type="hidden" name="servicio[<?php echo $i;?>][fCantidad]" value="<?php  echo $servicios['fCantidad']; ?>">
                        <input type="hidden" name="servicio[<?php echo $i;?>][skCotizacionServicio] " value="<?php  echo $servicios['skCotizacionServicio']; ?>">
                        <input type="hidden" name="servicio[<?php echo $i;?>][skServicio]" value="<?php  echo $servicios['skServicio']; ?>">
                        <input type="hidden" name="servicio[<?php echo $i;?>][iDetalle]" value="<?php  echo (!empty($servicios['iDetalle']) ? $servicios['iDetalle'] : NULL ); ?>">
                        <?php echo number_format($servicios['fCantidad'], 2); ?>
                    </td> 
                    <td style="text-align:right; text-transform: uppercase;" >
                      <?php echo $servicios['sCodigo']; ?>
                    </td> 
                    <td style="text-align:left; text-transform: uppercase;" >
                      <?php echo $servicios['servicio'].(!empty($servicios['sDescripcion']) ? " (".$servicios['sDescripcion'].")" : ''); ?>
                    </td>
                    </tr>
                    <?php if(!empty($servicios['iDetalle']) && $servicios['iDetalle'] == 1 ){  
                      // for sobre la cantidad 
                      for ($j=0; $j < $servicios['fCantidad']; $j++) {  ?> 
                         <tr>
                         <td></td>
                         <td></td>
                         <td class="text-left"> <select name="servicio[<?php echo $i;?>][skServicioInventario][<?php echo $j;?>]"  class="<?php  echo $servicios['skServicio']; ?> form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>
                         </tr>

                        
                     <?php  } //ENDFOR ?>
                     <script type="text/javascript">
 
                      core.autocomplete2('.<?php  echo $servicios['skServicio']; ?>', 'get_serviciosInventario', window.location.href, 'Servicio', { skServicio : '<?php  echo $servicios['skServicio']; ?>'});
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
