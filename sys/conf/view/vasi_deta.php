<?php

    if (isset($data['datos'])) {
        $result = $data['datos'];
    }

?>
<div class="col-md-12">
	<div class="panel panel-bordered panel-primary panel-line">
            <div class="panel-heading">
            <h3 class="panel-title">DETALLES GENERALES</h3>
            </div>

            <div class="panel-body">
                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b> Código:</b> </label>
                        <div class=" col-md-4">
                           <label class="control-label" style="">
                                   <?php echo isset($result['skVariable']) ? $result['skVariable'] : ''; ?>
                           </label>
                        </div>

                        <label class="col-md-2 control-label"><b> Estatus:</b> </label>
                        <div class=" col-md-4">
                            <label class="control-label" style="">
                                   <?php isset($result['estatus']) && $result['estatus']=='Activo' ? $color='text-success' : $color='' ?>
                                   <?php isset($result['estatus']) && $result['estatus']=='Eliminado' ? $color='text-danger' : $color=$color ?>
                                   <?php echo isset($result['estatus']) ? '<span class="'.$color.' '.$result['estatusicono'].'"</span>'.' '.$result['estatus'] : ''; ?>
                             </label>
                        </div>				 	               
                    </div>

                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b> Tipo de Variable:</b> </label>
                        <div class=" col-md-8">
                            <label class="control-label" style="">
                                   <?php echo isset($result['tipovariable']) ? $result['tipovariable'] : ''; ?>
                             </label>
                        </div>	 
                    </div>

                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b> Nombre:</b> </label>
                        <div class=" col-md-10">
                            <label class="control-label" style="">
                                   <?php echo isset($result['sNombre']) ? $result['sNombre'] : ''; ?>
                             </label>
                        </div>	 
                    </div>

                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b> Descripción:</b> </label>
                        <div class=" col-md-10">
                            <label class="control-label" style="">
                                   <?php echo isset($result['sDescripcion']) ? $result['sDescripcion'] : ''; ?>
                             </label>
                        </div>	 
                    </div>

                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b> Valor:</b> </label>
                        <div class=" col-md-10">


                                   <?php 
                                        if( isset($result['sValor']) && is_array(json_decode(html_entity_decode($result['sValor']),true,512)) ){
                                              echo('<pre style="height:400px"><code>'.print_r(json_decode(html_entity_decode($result['sValor']),true,512),1).'</pre></code>');  
                                        }else{

                                              echo isset($result['sValor']) ? '<label class="control-label" style="">'. $result['sValor']. '</label>': '';
                                        }
                                   ?>

                        </div>	 
                    </div>

                    <div class="col-md-12 clearfix"><hr></div>

                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b> Usuario Creación:</b> </label>
                        <div class=" col-md-4">
                            <label class="control-label" style="">
                                   <?php echo isset($result['usuarioCreacion']) ? $result['usuarioCreacion'] : ''; ?>
                             </label>
                        </div>
                                <label class="col-md-2 control-label"><b> Usuario Modificación:</b> </label>
                        <div class=" col-md-4">
                            <label class="control-label" style="">
                                   <?php echo isset($result['usuarioModificacion']) ? $result['usuarioModificacion'] : ''; ?>
                             </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b> Fecha Creación:</b> </label>
                        <div class=" col-md-4">
                            <label class="control-label" style="">
                                   <?php echo (isset($result['dFechaCreacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : 'N/D'; ?>
                             </label>
                        </div>

                        <label class="col-md-2 control-label"><b> Fecha Modificación:</b> </label>
                        <div class=" col-md-4">
                            <label class="control-label" style="">
                                  <?php echo (isset($result['dFechaModificacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaModificacion'])) : ''; ?>
                             </label>
                        </div>
                    </div>
                    <div class="col-md-12 clearfix"><hr></div>

                    <div class="col-md-6">
                        <div class="col-md-6" style="overflow-x: scroll; overflow-y:hidden; width: 100%;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Proyectos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['moduloProyecto'] as $key => $value) { ?> 
                                        <tr>
                                            <td><?php echo $value['sProyecto'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-6" style="overflow-x: scroll; overflow-y:hidden; width: 100%;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Modulos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['moduloVariables'] as $key => $value) { ?> 
                                        <tr>
                                            <td><?php echo $value['modulo'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
        </div>
</div>

  <!-- YOUR CODE END HERE -->


</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">


	$(document).ready(function () {
	 	

	});

</script>