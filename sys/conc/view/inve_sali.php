<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];

    utf8($result);
}

?>

<div class="row">
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
<input value="<?php echo (!empty($result['skConcepto']) ? $result['skConcepto'] : '');?>" name="skConcepto" id="skConcepto"  type="hidden">

<div class="panel panel-bordered panel-primary panel-line" >
            
            <div class="panel-heading">
			        <h3 class="panel-title">GENERAL</h3>
		  	    </div>

            <div class="panel-body container-fluid">
              <div class="col-md-12 page-invoice-table table-responsive font-size-12">

              <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                             <h4 class="example-title">USUARIO BAJA <span class="required text-danger">*</span></h4>
                             <select id="skUsuarioBaja"  name="skUsuarioBaja" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">Seleccionar</option>
                                 <?php
                                 if ($data['usuarioBaja']) {
                                 foreach (  $data['usuarioBaja'] as $row) {
                                     utf8($row);
                                     ?>
                                     <option  value="<?php echo $row['skUsuario']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                   </div>
                   
                   <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                             <h4 class="example-title"> DESCRIPCION BAJA  
                              </h4>
                             <textarea class="form-control"  name="sDescripcionBaja" placeholder="DESCRIPCION BAJA"></textarea>
                         </div>
                     </div>
                     <?php if($result['iDetalle'] == 0){?>
                     <div class="col-md-2 col-lg-2">
                        <div class="form-group">
                        <h4 class="example-title">CANTIDAD </h4>
                        <input class="form-control" name="fCantidad" value=" " placeholder="Cantidad" autocomplete="off" type="text" >

                      </div>
                    </div>
                    <?php }?>


            </div>
          </div>
    </div>
    <?php if($result['iDetalle'] == 1){?>
        <div class="panel panel-bordered panel-primary panel-line" >
            
            <div class="panel-heading">
			        <h3 class="panel-title">INVENTARIO</h3>
		  	    </div>

            <div class="panel-body container-fluid">
              <div class="col-md-12 page-invoice-table table-responsive font-size-12">
              <table class="table text-right">
                <thead>
                  <tr> 
                    <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">CHECK</th>
                    <th class="col-xs-10 col-md-10 text-center" style="text-align:left;">NUMERO SERIE</th>
                    
                   </tr>
                </thead>
              <tbody>
                <?php
                if (isset($data['inventario'])) {
                  $i=0;
                  foreach ($data['inventario'] AS $inventario) {
                    ?>
                    <tr> 
                    <td style="text-align:center; text-transform: uppercase;" >
                    <div class="checkbox-custom checkbox-primary">
                  <input value="<?php  echo $inventario['skConceptoInventario']; ?>" name="skConceptoInventario[]" class="check_factura" id="check_factura_<?php  echo $inventario['skConceptoInventario']; ?>" type="checkbox"  > 
                  <label for="check_factura_<?php  echo $inventario['skConceptoInventario']; ?>"></label>
                  </div>
                      </td> 
                    <td style="text-align:left; text-transform: uppercase;" >
                      <?php echo $inventario['sNumeroSerie']; ?>
                    </td> 
                     
                    </tr>
                 
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
    <?php  } //ENDIF DETALLE?>

    </form>
</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
   

  
    $(document).ready(function () {
      $('#core-guardar').formValidation(core.formValidaciones);
      $("#skUsuarioBaja").select2({placeholder: "USUARIO BAJA", allowClear: true });
         
    });

</script>
