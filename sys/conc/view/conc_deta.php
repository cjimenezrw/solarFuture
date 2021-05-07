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
                              <h4 class="example-title">CÓDIGO</h4>
                              <p><?php echo (!empty($result['sCodigo'])) ? $result['sCodigo'] : '-'; ?> </p>
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
                          <p><?php echo (!empty($result['unidadMedida'])) ? $result['unidadMedida'] : '-'; ?> </p>
                      </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">PRECIO DE COMPRA</h4>
                          <p><?php echo (!empty($result['fPrecioCompra'])) ? number_format($result['fPrecioCompra'],2) : '-'; ?> </p>
                      </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">PRECIO DE VENTA</h4>
                          <p><?php echo (!empty($result['fPrecioVenta'])) ? number_format($result['fPrecioVenta'],2) : '-'; ?> </p>
                      </div>
                    </div>
                </div>


                <div class="col-md-12 clearfix"><hr></div>

                <div class="col-md-12 same-heigth">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">Kwh</h4>
                            <p><?php echo (!empty($result['fKwh'])) ? number_format($result['fKwh'],2) : '-'; ?> </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">METROS 2</h4>
                            <p><?php echo (!empty($result['fMetros2'])) ? $result['fMetros2'] : '-'; ?> </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">CATEGORÍA PRODUCTO</h4>
                            <p><?php echo (!empty($result['categoriaProducto'])) ? $result['categoriaProducto'] : '-'; ?> </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 same-heigth">
                <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">PROVEEDOR</h4>
                          <p><?php echo (!empty($result['proveedor'])) ? $result['proveedor'] : '-'; ?> </p>
                      </div>
                    </div>
                </div>

                <div class="col-md-12 clearfix"><hr></div>
                <div class="col-md-12 same-heigth">
                  <div class="col-md-12 col-lg-8">
      								<div class="form-group">
      										<h4 class="example-title">DESCRIPCIÓN:</h4>
      										<p><?php echo (!empty($result['sDescripcion'])) ? $result['sDescripcion'] : '-'; ?> </p>
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

        <div class="panel panel-bordered panel-primary panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">CATEGORÍA DE PRECIOS</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
                        <input id="filter_categorias" type="text" class="form-control" autocomplete="off" placeholder="Escribe aquí...">
                    </div>
                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="col-md-2">Categoría</th>
                            <th class="col-md-11">Precio</th>
                        </tr>
                    </thead>
                    <tbody class="tbody_categorias">
                        <?php 
                        if(isset($data['categorias_precios']) && !empty($data['categorias_precios']) && is_array($data['categorias_precios'])){
                            foreach($data['categorias_precios'] AS $row) { 
                        ?>
                            <tr>
                                <td><?php echo (!empty($row['sNombre'])) ? $row['sNombre'] : ''; ?></td>
                                <td><?php echo (!empty($row['fPrecioVenta'])) ? '$'.$row['fPrecioVenta'] : '-'; ?></td>
                            </tr>
                        <?php 
                            }//FOREACH
                        }
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-bordered panel-primary panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">PRODUCTOS DE INVENTARIO</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
                        <input id="filter_inventario" type="text" class="form-control" autocomplete="off" placeholder="Escribe aquí...">
                    </div>
                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-1">Estatus</th>
                            <th class="col-md-5">Número de Serie</th>
                            <th class="col-md-5">Folio de Cotización</th>
                        </tr>
                    </thead>
                    <tbody class="tbody_inventario">
                        <?php 
                        if(isset($data['inventario']) && !empty($data['inventario']) && is_array($data['inventario'])){
                            $i=1;
                            foreach($data['inventario'] AS $k=>$v) { 
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo (!empty($v['estatus'])) ? $v['estatus'] : ''; ?></td>
                                <td><?php echo (!empty($v['sNumeroSerie'])) ? $v['sNumeroSerie'] : ''; ?></td>
                                <td><?php echo (!empty($v['iFolio'])) ? $v['iFolio'] : ''; ?></td>
                            </tr>
                        <?php 
                            $i++;
                            }//FOREACH
                        }
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');

        $('#filter_categorias').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.tbody_categorias tr').hide();
            $('.tbody_categorias tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

        $('#filter_inventario').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.tbody_inventario tr').hide();
            $('.tbody_inventario tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });
    });

</script>
