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
                                <h4 class="example-title">CLAVE PRODUCTO / SERVICIO (SAT) :</h4>
                                <p><?php echo (!empty($result['iClaveProductoServicio'])) ? $result['iClaveProductoServicio'] : '';?> </p>
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
                      if (!empty($data['serviciosImpuestos'])) {

                          foreach ($data['serviciosImpuestos'] as $val) { ?>
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
                    <div class="col-md-12">
                        <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
                            <input id="inputFilter" onkeyup="searchFilter();" type="text" class="form-control" autocomplete="off" placeholder="ESCRIBE AQUÍ PARA BUSCAR CUALQUIER DATO DE LA TABLA...">
                        </div>
                        <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>CATEGORÍA</th>
                                <th>PRECIO</th>
                            </tr>
                        </thead>
                        <tbody class="tbody_searchable">
                            <?php 
                            if(isset($data['categorias_precios']) && !empty($data['categorias_precios']) && is_array($data['categorias_precios'])){
                                foreach($data['categorias_precios'] AS $row) { 
                            ?>
                                <tr>
                                    <td><?php echo (!empty($row['sNombre'])) ? $row['sNombre'] : ''; ?></td>
                                    <td>$<?php echo (!empty($row['fPrecio']) ? $row['fPrecio'] : ''); ?></td>
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
        </div>

         
         

</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    function searchFilter() {
        var rex = new RegExp($("#inputFilter").val(), 'i');
        $('.tbody_searchable tr').hide();
        $('.tbody_searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();
    }

    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');

         
        
    });

</script>
