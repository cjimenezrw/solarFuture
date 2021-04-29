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
                    <input type="hidden" name="fCantidad[<?php echo $i;?>] " value="<?php  echo $conceptos['fCantidad']; ?>">
                    <input type="hidden" name="skCotizacionConcepto[<?php echo $i;?>] " value="<?php  echo $conceptos['skCotizacionConcepto']; ?>">
                    <input type="hidden" name="skConcepto[<?php echo $i;?>] " value="<?php  echo $conceptos['skConcepto']; ?>">
                    <?php echo number_format($conceptos['fCantidad'], 2); ?></td>    
                    <td style="text-align:left; text-transform: uppercase;" ><?php echo $conceptos['concepto'].(!empty($conceptos['sDescripcion']) ? " (".$conceptos['sDescripcion'].")" : ''); ?></td>
                    </tr>
                    <?php
                  }//FOREACH
                  $i++;
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
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    });

</script>
