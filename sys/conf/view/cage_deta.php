<?php
    if (isset($data['datos'])) {
        $result = $data['datos'];
    }
?>
<div class="row">
<div class="panel panel-bordered panel-primary panel-line" style="display: block;">
    <div class="panel-heading">
        <h3 class="panel-title">DATOS GENERALES</h3>
    </div>
    <div class="panel-body container-fluid">

      <div class="col-md-12">
            <label class="col-md-2 control-label"><b> Código:</b> </label>
            <div class=" col-md-8">
                <label class="form-control" style="border:none">
                       <?php echo isset($result['skCatalogoSistema']) ? $result['skCatalogoSistema'] : ''; ?>
                 </label>
            </div>
        </div>

        <div class="col-md-12">
            <label class="col-md-2 control-label"><b> Estatus</b> </label>
            <div class=" col-md-8">
                <label class="form-control" style="border:none">
                       <?php echo isset($result['estatus']) ? $result['estatus'] : ''; ?>
                 </label>
            </div>
        </div>

      <div class="col-md-12">
            <label class="col-md-2 control-label"><b> Nombre</b> </label>
            <div class=" col-md-8">
                <label class="form-control" style="border:none">
                       <?php echo isset($result['sNombre']) ? $result['sNombre'] : ''; ?>
                 </label>
            </div>
        </div>

    	
	  <div class="col-md-12">
	        <label class="col-md-2 control-label"><b> Usuario Creación</b> </label>
	        <div class=" col-md-8">
	            <label class="form-control" style="border:none">
	                   <?php echo isset($result['usuarioCreacion']) ? $result['usuarioCreacion'] : ''; ?>
	             </label>
	        </div>
	    </div>


	     <div class="col-md-12">
	           <label class="col-md-2 control-label"><b> Fecha Creación</b> </label>
	           <div class=" col-md-8">
	               <label class="form-control" style="border:none">
	                      <?php echo (!empty($result['dFechaCreacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : ''; ?> 
	                </label>
	           </div>
	       </div>

         <div class="col-md-12">
          <label class="col-md-2 control-label"><b> Usuario Modificación</b> </label>
          <div class=" col-md-8">
              <label class="form-control" style="border:none">
                     <?php echo isset($result['usuarioModificacion']) ? $result['usuarioModificacion'] : ''; ?>
               </label>
          </div>
      </div>


       <div class="col-md-12">
             <label class="col-md-2 control-label"><b> Fecha Creación</b> </label>
             <div class=" col-md-8">
                 <label class="form-control" style="border:none">
                        <?php echo (!empty($result['dFechaModificacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaModificacion'])) : ''; ?> 
                  </label>
             </div>
         </div>
         
          <div class="col-md-12">
                <label class="col-md-2 control-label"><b> Opciones del Catálogo</b> </label>
                <div class=" col-md-8">
                  <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
                      <input id="filter_desvios" type="text" class="form-control" autocomplete="off" placeholder="Escribe aquí...">
                  </div>
                     <table class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <th>Nombre</th>
                              <th
                                <?php 
                                  echo (!empty($data['catalogoOpciones'][0]['skClave'])) ? '' : 'style="display:none"'; ?>> <?php echo (!empty($data['catalogoOpciones'][0]['skClave'])) ? ' Clave' : '';
                                ?>
                              </th>
                              <th>Usuario Creación</th>
                              <th>Fecha Creación</th>
                              <th>Usuario Modificación</th>
                              <th>Fecha Modificación</th>
                          </tr>
                      </thead>
                      <tbody class="searchable">
                          <?php 
                          if(isset($data['catalogoOpciones']) && !empty($data['catalogoOpciones']) && is_array($data['catalogoOpciones'])){
                              foreach($data['catalogoOpciones'] AS $row) { 
                          ?>
                              <tr>
                                  <td><?php echo (!empty($row['sNombre'])) ? $row['sNombre'] : ''; ?></td>
                                  <td <?php echo (!empty($row['skClave'])) ? '' : 'style="display:none"'; ?>><?php echo (!empty($row['skClave'])) ? $row['skClave'] : ''; ?></td>
                                  <td><?php echo (!empty($row['usuarioCreacion'])) ? $row['usuarioCreacion'] : ''; ?></td>
                                  <td><?php echo (!empty($row['dFechaCreacion'])) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''; ?></td>
                                  <td><?php echo (!empty($row['usuarioModificacion'])) ? $row['usuarioModificacion'] : ''; ?></td>
                                  <td><?php echo (!empty($row['dFechaModificacion'])) ? date('d/m/Y  H:i:s', strtotime($row['dFechaModificacion'])) : ''; ?></td>
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
	$(document).ready(function () {
	 	$('#filter_desvios').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });
	});
</script>