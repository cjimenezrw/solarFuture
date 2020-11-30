<?php

    if (isset($data['datos'])) {
        $result = $data['datos'];
    }

?>

  <!-- YOUR CODE GOES HERE -->
  
<div class="panel-body nav-tabs-animate nav-tabs-horizontal">
            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                <li class="active" role="presentation"><a style="font-size: 16px" data-toggle="tab" href="#general" aria-controls="general"
                                                          role="tab">General</a></li>
                <li role="presentation"><a style="font-size: 16px" data-toggle="tab" href="#botones"
                                           aria-controls="botones"
                                           role="tab">Botones</a></li>
                <li role="presentation"><a style="font-size: 16px" data-toggle="tab" href="#menuEmergente" aria-controls="menuEmergente"
                						   aria-controls="menuEmergente"
                                           role="tab">Menú Emergente</a>
                </li>
                <li role="presentation">
                    <a style="font-size: 16px" data-toggle="tab" href="#caracteristicas" aria-controls="caracteristicas" role="tab">Características</a>
                </li>
                <li role="presentation">
                    <a style="font-size: 16px" data-toggle="tab" href="#perfiles" aria-controls="perfiles" role="tab">Perfiles</a>
                </li>
            </ul>
            <div class="tab-content">

            	<!-- TAB GENERAL !-->
                <div class="tab-pane active animation-slide-bottom" id="general" role="tabpanel">
                	 	<div class="panel panel-bordered panel-primary panel-line">
				        
					        <div class="panel-body container-fluid">
				            <div class="row row-lg">
						                <div class="col-md-12">
						                	<div class="panel-heading">
									            <h3 class="panel-title"></h4>
									        </div>
								 	        <label class="col-md-2 control-label"><b> Módulo:</b> </label>
								 	        <div class=" col-md-4">
								 	            <label class="control-label" style="">
								 	                   <?php echo isset($result['skModulo']) ? $result['skModulo'] : ''; ?>
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
								 	  		<label class="col-md-2 control-label"><b> Módulo Principal:</b> </label>
								 	        <div class=" col-md-4">
								 	           <label class="control-label" style="">
								 	                   <?php echo isset($result['skModuloPrincipal']) ? $result['skModuloPrincipal'] : ''; ?>
								 	             </label>
								 	        </div>

								 	        <label class="col-md-2 control-label"><b> Módulo Padre:</b> </label>
								 	        <div class=" col-md-4">
								 	            <label class="control-label" style="">
								 	                   <?php echo isset($result['skModuloPadre']) ? $result['skModuloPadre'] : ''; ?>
								 	             </label>
								 	        </div>	        
								 	  </div>

								 	  <div class="col-md-12">
								 	  		<label class="col-md-2 control-label"><b> URI:</b> </label>
								 	        <div class=" col-md-4">
								 	            <label class="control-label" style="">
								 	                   <?php echo isset($result['sNombre']) ? $result['sNombre'] : ''; ?>
								 	             </label>
								 	        </div>

								 	        <label class="col-md-2 control-label"><b> Título:</b> </label>
								 	        <div class=" col-md-4">
								 	            <label class="control-label" style="">
								 	                   <?php echo isset($result['sTitulo']) ? $result['sTitulo'] : ''; ?>
								 	             </label>
								 	        </div>	        
								 	  </div>

							 	    <div class="col-md-12">
							 	        <label class="col-md-2 control-label"><b> Posición:</b> </label>
							 	        <div class=" col-md-4">
							 	            <label class="control-label" style="">
							 	                   <?php echo isset($result['iPosicion']) ? $result['iPosicion'] : ''; ?>
							 	             </label>
							 	        </div>

							            <label class="col-md-2 control-label"><b> Permisos:</b> </label>
							            <div class=" col-md-4">
								           
					                        <?php 
					                        if(isset($data['permisosModulo']) && !empty($data['permisosModulo']) && is_array($data['permisosModulo'])){
					                            foreach($data['permisosModulo'] AS $k=>$row) { 
					                        ?>
					                            
					                                <span>
					                                	<?php 
				                                			echo (!empty($row['permiso']) && $row['permiso']=='All') ? 'Admin' : $row['permiso'];
				                                			echo (!empty($row['skPermiso'])) ? ' ('.$row['skPermiso'].')' : ''; 
			                                			?>					                
				                                	</span>
					                                <?php 
						                                if(count($data['permisosModulo'])-1 != $k){
						                                	echo ',';
						                                }else{echo '';}
					                                ?>
					                            
					                        <?php 
					                            }//FOREACH
					                        }
					                        ?>
							            </div>
							 	    </div>

							 	    <div class="col-md-12">
								 	  		<label class="col-md-2 control-label"><b> Ícono:</b> </label>
								 	        <div class=" col-md-4">
								 	            <label class="control-label" style="">
								 	                   <?php echo isset($result['sIcono']) ? $result['sIcono'] : ''; ?>
								 	             </label>
								 	        </div>

								 	        <label class="col-md-2 control-label"><b> Color:</b> </label>
								 	        <div class=" col-md-4">
								 	            <label class="control-label" style="">
								 	                   <?php echo isset($result['sColor']) ? $result['sColor'] : ''; ?>
								 	             </label>
								 	        </div>	        
								 	  </div>



							 	  <div class="col-md-12">
							 	        <label class="col-md-2 control-label"><b> Descripción:</b> </label>
							 	        <div class=" col-md-8">
							 	            <label class="control-label" style="">
							 	                   <?php echo isset($result['sDescripcion']) ? $result['sDescripcion'] : ''; ?>
							 	             </label>
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
							 	                   <?php echo (isset($result['dFechaCreacion']) && !empty($result['dFechaCreacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : 'N/D'; ?>
							 	             </label>
							 	        </div>
							 	  	
							 	        <label class="col-md-2 control-label"><b> Fecha Modificación:</b> </label>
							 	        <div class=" col-md-4">
							 	            <label class="control-label" style="">
							 	                  <?php echo (isset($result['dFechaModificacion']) && !empty($result['dFechaModificacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaModificacion'])) : ''; ?>
							 	             </label>
							 	        </div>
							 	  </div>
							 	  <div class="col-md-12 clearfix"> <hr> </div>
						        <div class="col-md-12">
							 	  		<label class="col-md-2 control-label"><b> Menús:</b> </label>
							 	  		<div class=" col-md-4">          
					                        <?php 
					                        if(isset($data['modulosMenu']) && !empty($data['modulosMenu']) && is_array($data['modulosMenu'])){
					                            foreach($data['modulosMenu'] AS $k=>$row) { 
					                        ?>
					                                <span>
					                                	<?php 
				                                			echo (!empty($row['id']) && $row['id']=='ACR') ? 'Acceso Rápido' : '';
				                                			echo (!empty($row['id']) && $row['id']=='LAT') ? 'Lateral' : '';
				                                			echo (!empty($row['id']) && $row['id']=='MOB') ? 'Mobil' : '';
				                                			echo (!empty($row['id']) && $row['id']=='SUP') ? 'Superior' : '';
				                                			echo (!empty($row['id'])) ? ' ('.$row['id'].')' : ''; 
			                                			?>					                
				                                	</span>
					                                <?php 
						                                if(count($data['modulosMenu'])-1 != $k){
						                                	echo ',';
						                                }else{echo '';}
					                                ?>
					                            
					                        <?php 
					                            }//FOREACH
					                        }
					                        ?>
							            </div>
							 	  	</div>
				            </div>
				        </div>
				    </div>
                </div>
                <!-- TAB BOTONES !-->
                <div class="tab-pane animation-slide-bottom" id="botones" role="tabpanel">
                	<div class="panel panel-bordered panel-info panel-line">
				        
				        <div class="panel-body container-fluid">
				            <div class="row row-lg">
				            	<div class="col-md-12">
						            <div class=" col-md-12">
						            	<div class="panel-heading">
								            <h3 class="panel-title"></h3>
								        </div>
							            <div class="table-responsive clearfix" style="max-height:400px;overflow-y:visible;font-size: 10pt;">
							                <table class="table table-striped  table-hover">
							                    <thead>
							                        <tr>
							                            <th>Tipo de Bóton</th>
							                            <th>Módulo Padre</th>
							                            <th>Posición</th>
							                            <th>Nombre</th>
							                            <th>Función</th>
							                            <th>Ícono</th>
							                            <th>Comportamiento</th>
							                        </tr>
							                    </thead>
							                    <tbody class="searchable">
							                        <?php 
							                        $i=1; 
							                        if(isset($data['botones']) && !empty($data['botones']) && is_array($data['botones'])){
							                            foreach($data['botones'] AS $k=>$row) { 
							                        ?>
							                            <tr>
							                                <td><?php echo (!empty($row['boton'])) ? $row['boton'] : ''; ?></td>
							                                <td><?php echo (!empty($row['skModuloPadre'])) ? $row['skModuloPadre'] : ''; ?></td>
							                                <td><?php echo (!empty($row['iPosicion'])) ? $row['iPosicion'] : ''; ?></td>
							                                <td><?php echo (!empty($row['sNombre'])) ? $row['sNombre'] : ''; ?></td>
							                                <td><?php echo (!empty($row['sFuncion'])) ? $row['sFuncion'] : ''; ?></td>
							                                <td><?php echo (!empty($row['sIcono'])) ? $row['sIcono'] : ''; ?></td>
							                                <td><?php echo (!empty($row['sComportamiento'])) ? $row['sComportamiento'] : ''; ?></td>
							                                
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
				        </div>
				    </div>
				    
                </div>
                <!-- TAB MENÚS EMERGENTES !-->
                <div class="tab-pane animation-slide-bottom" id="menuEmergente" role="tabpanel">
                	<div class="panel panel-bordered panel-success panel-line">
				        
				        <div class="panel-body container-fluid">
				            <div class="row row-lg">
				        		<div class="col-md-12">
						            <div class=" col-md-12">
						            	<div class="panel-heading">
								            <h3 class="panel-title"></h3>
								        </div>
							            <div class="table-responsive clearfix" style="max-height:400px;overflow-y:visible;font-size: 10pt;">
							                <table class="table table-hover table-striped">
							                    <thead>
							                        <tr>
							                            <th>Módulo Padre</th>
							                            <th>Permiso</th>
							                            <th>Posición</th>
							                            <th>Título</th>
							                            <th>Función</th>
							                            <th>Ícono</th>
							                            <th>Comportamiento</th>
							                        </tr>
							                    </thead>
							                    <tbody class="searchable">
							                        <?php 
							                        $i=1; 

							                        if(isset($data['ME']) && !empty($data['ME']) && is_array($data['ME'])){
							                            foreach($data['ME'] AS $k=>$row) { 
							                        ?>
							                            <tr>
							                                <td><?php echo (!empty($row['skModuloPadre'])) ? $row['skModuloPadre'] : ''; ?></td>
							                                <td><?php echo (!empty($row['skPermiso'])) ? $row['skPermiso'] : ''; ?></td>
							                                <td><?php echo (!empty($row['iPosicion'])) ? $row['iPosicion'] : ''; ?></td>
							                                <td><?php echo (!empty($row['sTitulo'])) ? $row['sTitulo'] : ''; ?></td>
							                                <td><?php echo (!empty($row['sFuncion'])) ? $row['sFuncion'] : ''; ?></td>
							                                <td><?php echo (!empty($row['sIcono'])) ? $row['sIcono'] : ''; ?></td>
							                                <td><?php echo (!empty($row['skComportamiento'])) ? $row['skComportamiento'] : ''; ?></td>
							                                
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
				        </div>
				    </div>
                </div>

                <!-- TAB CARACTERISTICAS !-->

                <div class="tab-pane animation-slide-bottom" id="caracteristicas" role="tabpanel">
                	<div class="panel panel-bordered panel-dark panel-line">
				        
				        <div class="panel-body container-fluid">
				            <div class="row row-lg">
				            	<div class="col-md-12">
						            <div class=" col-md-12">
						            	<div class="panel-heading">
								            <h3 class="panel-title"></h3>
								        </div>
							            <div class="table-responsive clearfix" style="max-height:400px;overflow-y:visible;font-size: 10pt;">
							                <table class="table table-striped table-hover">
							                	<thead>
							                        <tr>
							                            <th>Clave</th>
							                            <th>Característica</th>
							                        </tr>
							                    </thead>
							                    <tbody class="searchable">
							                        <?php 
							                        $i=1; 

							                        if(isset($data['caracteristicasModulo']) && !empty($data['caracteristicasModulo']) && is_array($data['caracteristicasModulo'])){
							                            foreach($data['caracteristicasModulo'] AS $k=>$row) { 
							                        ?>
							                            <tr>
							                            	<td style="border: none;"><?php echo (!empty($row['skCaracteristicaModulo'])) ? $row['skCaracteristicaModulo'] : ''; ?></td>
							                                <td style="border: none;"><?php echo (!empty($row['caracteristica'])) ? $row['caracteristica'] : ''; ?></td>
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
				        </div>
				    </div>
                </div>

                <div class="tab-pane animation-slide-bottom" id="perfiles" role="tabpanel">
                	<div class="panel panel-bordered panel-warning panel-line">
				        
				        <div class="panel-body container-fluid">
				            <div class="row row-lg">
				        		<div class="col-md-12">
						            <div class=" col-md-12">
						            	<div class="panel-heading">
								            <h3 class="panel-title"></h3>
								        </div>
							            <div class="table-responsive clearfix" style="max-height:400px;overflow-y:visible;font-size: 10pt;">
							                <table class="table table-hover table-striped">
							                    <thead>
							                        <tr>
							                        	<th><?php echo (!empty($result['estatusicono']) ? '<span data-toggle="tooltip" data-placement="top" title="Estatus">E
							                                	</span>' : 'E'); ?></th>
							                            <th>Perfil</th>
							                            <th>Descripción</th>
							                            <th>Permiso</th>
							                            <th>Fecha Creación</th>
							                        </tr>
							                    </thead>
							                    <tbody class="searchable">
							                        <?php 
							                        if(isset($data['perfiles']) && !empty($data['perfiles']) && is_array($data['perfiles'])){
							                            foreach($data['perfiles'] AS $k => $row) { 
							                        ?>
							                            <tr>
							                            	<?php $row['estatusPerfil']=='Activo' ? $color='text-success' : $color='' ?>
							                                <td> <?php echo (!empty($result['estatusicono']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$row['estatusPerfil'].'">
							                                	<i class="icon '.$color.' '.$row['estatusicono'].'" aria-hidden="true"></i></span>' : $row['estatusPerfil']); ?>
							                                
							 	                   			</td>
							                                
							                                <td style="width:20%"><?php echo (!empty($row['nombrePerfil'])) ? $row['nombrePerfil'] : ''; ?></td>

							                                <td style="width:20%"><?php echo (!empty($row['descripcionPerfil'])) ? $row['descripcionPerfil'] : ''; ?></td>
							                                
							                                <td>
							                                	<?php echo (($row['nombrePermiso'])=='All') ? 'Admin' : $row['nombrePermiso']; ?> 
							                                	(<?php echo (!empty($row['skPermiso'])) ? $row['skPermiso'] : ''; ?>)
							                                </td>

							                                <td><?php echo (isset($result['dFechaCreacion']) && !empty($result['dFechaCreacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : 'N/D'; ?></td>
							                                
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
				    </div>
                </div>






            </div>
        </div>
        


  <!-- YOUR CODE END HERE -->

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">


	$(document).ready(function () {
	 	$('#mowi').iziModal('setBackground', '#f1f4f5');
	 	$('[data-toggle="tooltip"]').tooltip();
	});

</script>