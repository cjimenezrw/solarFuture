<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];

    utf8($result);
}

?>

<div class="row">

        <div class="panel panel-bordered panel-primary panel-line" style="display: block;">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS GENERALES</h3>
            </div>

            <div class="panel-body container-fluid"  >
                <div class="col-md-12 same-heigth">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">NOMBRE :</h4>
                            <p><?php echo (!empty($result['sNombre'])) ? $result['sNombre'] : '';?> </p>
                        </div>
                    </div>
                    
                      <div class="col-md-4 col-lg-4">
                          <div class="form-group">
                              <h4 class="example-title">CODIGO</h4>
                              <p><?php echo (!empty($result['sCodigo'])) ? $result['sCodigo'] : 'N/D'; ?> </p>
                          </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">CLAVE PRODUCTO/ SERVICIO :</h4>
                                <p><?php echo (!empty($result['iClaveProductoServicio'])) ? $result['iClaveProductoServicio'] : '';?> </p>
                            </div>
                        </div>
                </div>

              <div class="col-md-12 same-heigth">
                
                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">UNIDAD DE MEDIDA</h4>
                          <p><?php echo (!empty($result['unidadMedida'])) ? $result['unidadMedida'] : 'N/D'; ?> </p>
                      </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">PRECIO DE COMPRA</h4>
                          <p><?php echo (!empty($result['fPrecioCompra'])) ? number_format($result['fPrecioCompra'],2) : 'N/D'; ?> </p>
                      </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">PRECIO DE VENTA</h4>
                          <p><?php echo (!empty($result['fPrecioVenta'])) ? number_format($result['fPrecioVenta'],2) : 'N/D'; ?> </p>
                      </div>
                    </div>
                </div>


                <div class="col-md-12 clearfix"><hr></div>
                <div class="col-md-12 same-heigth">
                <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">Kwh</h4>
                          <p><?php echo (!empty($result['fKwh'])) ? number_format($result['fKwh'],2) : 'N/D'; ?> </p>
                      </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">PROVEEDOR</h4>
                          <p><?php echo (!empty($result['proveedor'])) ? $result['proveedor'] : 'N/D'; ?> </p>
                      </div>
                    </div>
                </div>
                <div class="col-md-12 clearfix"><hr></div>
                <div class="col-md-12 same-heigth">
                  <div class="col-md-12 col-lg-8">
      								<div class="form-group">
      										<h4 class="example-title">DESCRIPCION:</h4>
      										<p><?php echo (!empty($result['sDescripcion'])) ? $result['sDescripcion'] : 'N/D'; ?> </p>
      								</div>
      						</div>


      			</div>

            </div>
        </div>
        
         <div class="panel panel-bordered panel-primary panel-line" style="display: block;">
            <div class="panel-heading">
                <h3 class="panel-title">CONFIGURACIONES</h3>
            </div>

            <div class="panel-body container-fluid"  >
                <div class="col-md-12 same-heigth">
                    <div class="form-group">
                            <h4 class="example-title">IMPUESTOS A APLICAR:</h4>
                      <?php
                      if (!empty($data['conceptosImpuestos'])) {

                          foreach ($data['conceptosImpuestos'] as $val) { ?>
                              <div class="col-md-4 checkbox-custom checkbox-primary">
                                    <input type="checkbox" checked disabled    />
                                    <label ><?php echo (isset($val['nombre'])) ? ($val['nombre']) : ''; ?></label>
                              </div>
                          <?php  }

                      }else{ ?>
                          <p> NO TIENE IMPUESTOS CONFIGURADOS</p>
                    <?php   }  ?>
                    </div>
                </div>
                 
            </div>
        </div>




</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    });

</script>
