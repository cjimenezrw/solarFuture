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
           
          </div>

          <div class="panel-body container-fluid"  >
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

          </div>
        </div>
      </div>



        <div class="panel panel-bordered panel-primary panel-line" >
            
            <div class="panel-heading">
			        <h3 class="panel-title">CONCEPTOS</h3>
		  	    </div>

            <div class="panel-body container-fluid">
              <div class="col-md-12 page-invoice-table table-responsive font-size-12">
              <table class="table text-right">
                <thead>
                  <tr> 
                    <th class="text-right">Cantidad</th>
                    <th class="text-left" >Concepto</th>   
                  </tr>
                </thead>
              <tbody>
                <?php
                if (isset($data['conceptosCotizacion'])) {
                  $i=0;
                  foreach ($data['conceptosCotizacion'] AS $conceptos) {
                    ?>
                    <tr> 
                    <td style="text-align:right; text-transform: uppercase;" >
                    <input type="hidden" name="concepto[<?php echo $i;?>][fCantidad]" value="<?php  echo $conceptos['fCantidad']; ?>">
                    <!--<input type="hidden" name="concepto[<?php echo $i;?>][skCotizacionConcepto] " value="<?php  echo $conceptos['skCotizacionConcepto']; ?>">-->
                    <input type="hidden" name="concepto[<?php echo $i;?>][skConcepto]" value="<?php  echo $conceptos['skConcepto']; ?>">
                    <input type="hidden" name="concepto[<?php echo $i;?>][iDetalle]" value="<?php  echo (!empty($conceptos['iDetalle']) ? $conceptos['iDetalle'] : NULL ); ?>"></td>
                    <?php echo number_format($conceptos['fCantidad'], 2); ?></td>    
                    <td style="text-align:left; text-transform: uppercase;" >
                    <?php echo $conceptos['concepto'].(!empty($conceptos['sDescripcion']) ? " (".$conceptos['sDescripcion'].")" : ''); ?></td>
                    </tr>
                    <?php if(!empty($conceptos['iDetalle']) && $conceptos['iDetalle'] == 1 ){  
                      // for sobre la cantidad 
                      for ($j=0; $j < $conceptos['fCantidad']; $j++) {  ?> 
                         <tr>
                         <td>
                         <td> <select name="concepto[<?php echo $i;?>][skCotizacionConcepto][<?php echo $j;?>]"  class="<?php  echo $conceptos['skConcepto']; ?> form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>
                         </tr>

                        
                     <?php  } //ENDFOR ?>
                     <script type="text/javascript">
 
                      core.autocomplete2('.<?php  echo $conceptos['skConcepto']; ?>', 'get_conceptosInventario', window.location.href, 'Concepto', { skConcepto : '<?php  echo $conceptos['skConcepto']; ?>'});
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
core.formValidaciones.fields = vent.vent_coti.validaciones;

  
    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
        $('#core-guardar').formValidation(core.formValidaciones);
    });

</script>
