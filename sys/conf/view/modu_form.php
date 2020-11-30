<?php
    if (isset($data['datos'])) {
        $result = $data['datos'];
    }

?>

  <!-- YOUR CODE GOES HERE -->
  <div class="row">
    <form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
        <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                <li class="active" role="presentation"><a  data-toggle="tab" href="#general" aria-controls="general"
                                                          role="tab">General</a></li>
                <li role="presentation"><a data-toggle="tab" href="#botones"
                                           aria-controls="botones"
                                           role="tab">Botones</a></li>
                <li role="presentation"><a data-toggle="tab" href="#menuEmergente" aria-controls="menuEmergente"
                                           aria-controls="menuEmergente"
                                           role="tab">Menú Emergente</a>
                </li>
                <li role="presentation">
                    <a data-toggle="tab" href="#caracteristicas" aria-controls="caracteristicas" role="tab">Características</a>
                </li>
            </ul>
            <div class="tab-content">

                <!-- TAB GENERAL !-->
                <div class="tab-pane active animation-slide-left" id="general" role="tabpanel">
                    <div class="row margin-20"> 

                            <div class="col-md-12">
                            <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Módulo:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="skModuloAlta" name="skModuloAlta" maxlength="9" autocomplete="off" type="text" placeholder="xxxx-xxxx" value="<?php echo isset($result['skModulo']) ? $result['skModulo'] : ''; ?>"> 
                            </div>
                           
                            <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Módulo Principal:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="skModuloPrincipal" maxlength="4" autocomplete="off" name="skModuloPrincipal" placeholder="MÓDULO PRINCIPAL" type="text" value="<?php echo isset($result['skModuloPrincipal']) ? $result['skModuloPrincipal'] : ''; ?>"> 
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Módulo Padre:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="skModuloPadre" maxlength="9" autocomplete="off" name="skModuloPadre" type="text" placeholder="xxxx-xxxx" value="<?php echo isset($result['skModuloPadre']) ? $result['skModuloPadre'] : ''; ?>"> 
                            </div>

                             <label class="col-md-2 control-label"><b><span style="color:red;">* </span> URI:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="sNombre" name="sNombre" autocomplete="off" type="text" placeholder="URI" value="<?php echo isset($result['sNombre']) ? $result['sNombre'] : ''; ?>"> 
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Título:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="sTitulo" name="sTitulo" autocomplete="off" type="text" placeholder="TÍTULO" value="<?php echo isset($result['sTitulo']) ? $result['sTitulo'] : ''; ?>"> 
                            </div>

                            <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Posición:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="iPosicion" name="iPosicion" autocomplete="off" placeholder="POSICIÓN" value="<?php echo isset($result['iPosicion']) ? $result['iPosicion'] : ''; ?>" type="text"> 
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b> Descripción:</b> </label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="5" id="sDescripcion" autocomplete="false" placeholder="DESCRIPCIÓN" name="sDescripcion" placeholder="Descripcion.."><?php echo isset($result['sDescripcion']) ? $result['sDescripcion'] : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b> Permisos:</b> </label>
                             <div class="form-group col-md-1">
                                <div class="checkbox-custom checkbox-primary col-md-offset-2">
                                    <input class="R" type="checkbox" id="moduloPermisos" name="moduloPermisos[]" value="R" />
                                    <label for="moduloPermisos"><b>Read</b></label>
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <div class="checkbox-custom checkbox-primary col-md-offset-2">
                                    <input class="W" type="checkbox" id="moduloPermisos2" name="moduloPermisos[]" value="W" />
                                    <label for="moduloPermisos2"><b>Write</b></label>
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <div class="checkbox-custom checkbox-primary col-md-offset-2">
                                    <input class="D" type="checkbox" id="moduloPermisos3" name="moduloPermisos[]" value="D" />
                                    <label for="moduloPermisos3"><b>Delete</b></label>
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <div class="checkbox-custom checkbox-primary col-md-offset-2">
                                    <input class="A" type="checkbox" id="moduloPermisos4" name="moduloPermisos[]" value="A" />
                                    <label for="moduloPermisos4"><b>Admin</b></label>
                                </div>
                            </div>
                            <?php 
                                if(isset($data['permisosModulo']) && !empty($data['permisosModulo'])){
                                    foreach ($data['permisosModulo'] as $row) {
                                 ?>
                                        <input hidden style="display: none;" type="text" id="<?php echo isset($row['skPermiso']) ? $row['skPermiso'] : ''; ?>" value="<?php echo isset($row['skPermiso']) ? $row['skPermiso'] : ''; ?>">
                                 <?php
                                }
                             }

                             ?>
                        </div> 
                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b> Menu:</b> </label>
                            <div class="form-group col-md-8">
                                 <div class="select2-primary">
                                        <select id="skMenu" name="skMenu[]" placeholder="MENÚ" class="form-control" multiple="multiple"  data-plugin="select2">
                                            <?php
                                                if(isset($data['menu']) && !empty($data['menu'])){
                                                    foreach ($data['menu']['id'] AS $key => $row ) {
                                                ?>
                                                        <option value="<?php echo $row; ?>" 
                                                        <?php 
                                                            if(isset($data['modulosMenu']) && !empty($data['modulosMenu'])){
                                                                foreach($data['modulosMenu'] AS $val){
                                                                    if($val['id']==$row){
                                                                        echo 'selected';
                                                                    }
                                                                }
                                                            }
                                                        ?> >
                                                        <?php echo $data['menu']['nombre'][$key] ?> ( <?php echo $data['menu']['id'][$key] ?> )
                                                        </option>                                        
                                                <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b> Ícono:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="sIcono" name="sIcono" autocomplete="off" type="text" placeholder="Ícono" value="<?php echo isset($result['sIcono']) ? $result['sIcono'] : ''; ?>"> 
                            </div>

                            <label class="col-md-2 control-label"><b> Color:</b> </label>
                            <div class="form-group col-md-4">
                                <input class="form-control" id="sColor" name="sColor" autocomplete="off" placeholder="COLOR" value="<?php echo isset($result['sColor']) ? $result['sColor'] : ''; ?>" type="text"> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TAB BOTONES !-->
                <div class="tab-pane animation-slide-left" id="botones" role="tabpanel">
                    <div class="row margin-20">
                        <div class="form-group col-md-12 ">
                        
                                    <div class="well tableMultiple-panelEdit col-md-12">
                                        <p class="tableMultiple-editAndo text-center"></p>
                                        <div class="form-group col-md-12">
                        
                                            <!-- YOUR CODE BEGIN HERE -->
                                            
                                            <div class="col-md-12">

                                                    <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Tipo de Bóton:</b> </label>
                                                    <div class="form-group col-md-4">   
                                                        <select id="skBoton" data-plugin="select2 inputtext" inputtext="">
                                                            <option value=""  selected></option>
                                                            <?php 
                                                            if (isset($data['tipoBotones']) && !empty($data['tipoBotones']) && is_array($data['tipoBotones'])) {
                                                                foreach($data['tipoBotones'] as $row){
                                                                    ?>
                                                                        <option value="<?php echo $row['skBoton']; ?>" > 
                                                                            <?php echo $row['sNombre'].' ('. $row['skBoton'] .')'; ?>
                                                                        </option>
                                                                    <?php 
                                                                }//END FOREACH
                                                            }//END IF
                                                        ?>
                                                        </select>      
                                                    </div>

                                                    <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Módulo Padre:</b> </label>
                                                          <div class="form-group col-md-4">
                                                              <input class="form-control" maxlength="9" data-plugin="inputText" inputtext="" placeholder="xxxx-xxxx" id="moduloPadreBoton"  autocomplete="off"  type="text"/>
                                                                     
                                                          </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Posición:</b> </label>
                                                    <div class="form-group col-md-4">
                                                        <input class="form-control" data-plugin="inputText" inputtext="" id="posicionBoton" placeholder="POSICIÓN" autocomplete="off" type="text"/>    
                                                    </div>

                                                    <label class="col-md-2 control-label"><b> Nombre:</b> </label>
                                                   <div class="form-group col-md-4">
                                                       <input class="form-control" data-plugin="inputText" inputtext="" id="nombreBoton" placeholder="NOMBRE" autocomplete="off"  type="text"/>   
                                                   </div>
                                                </div>

                                                <div class="col-md-12">
                                                   <label class="col-md-2 control-label"><b> Función:</b> </label>
                                                   <div class="form-group col-md-4">
                                                       <input class="form-control" data-plugin="inputText" inputtext="" id="funcionBoton" placeholder="FUNCIÓN" autocomplete="off" type="text"/>         
                                                   </div>
                                                   <label class="col-md-2 control-label"><b> Ícono:</b> </label>
                                                   <div class="form-group col-md-4">
                                                        <input class="form-control" data-plugin="inputText" inputtext="" id="iconoBoton" placeholder="ÍCONO" autocomplete="off" type="text"/>                                            
                                                   </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label"><b> Comportamiento:</b> </label>
                                                    <div class="form-group col-md-4">
                                                        <input class="form-control" data-plugin="inputText" inputtext="" placeholder="COMPORTAMIENTO" id="comportamientoBoton" autocomplete="off" type="text"/>    
                                                    </div>
                                                </div>
                                            
                        
                                            <!-- YOUR CODE END HERE -->
                        
                                            <div class="col-md-3">
                                                <button id="tableMultiple-addRow" onclick="tableMultiple_addNewRow();" class="btn btn-primary pull-right">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-12">
                                        <div class="example">
                                            <div id="toolbar">
                                                <button id="tableMultiple-removeRowTableMultiple" class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                                                    <i class="fa fa-trash"></i> Borrar
                                                </button>
                                            </div>
                                            <table id="tableMultiple" data-toggle="table" data-toolbar="#toolbar"
                                                   data-query-params="queryParams" data-mobile-responsive="true"
                                                   data-height="400" data-pagination="false" data-icon-size="outline"
                                                   data-search="true" data-unique-id="id">
                                            </table>
                                        </div>
                                    </div>
                        
                                </div>

                                

                    </div>
                </div>
                <!-- TAB MENÚS EMERGENTES !-->
                <div class="tab-pane animation-slide-left" id="menuEmergente" role="tabpanel">
                    <div class="row margin-20">
                      <div class="form-group col-md-12 ">
                      
                                  <div class="well tableMultiple1-panelEdit col-md-12">
                                      <p class="tableMultiple1-editAndo text-center"></p>
                                      <div class="form-group col-md-12">
                      
                                          <!-- YOUR CODE BEGIN HERE -->
                                                 <div class="col-md-12">
                                                        <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Módulo Padre:</b> </label>
                                                        <div class="form-group col-md-4">
                                                            <input class="form-control" maxlength="9" data-plugin="inputText" inputtext="" id="moduloPadreME" placeholder="xxxx-xxxx" type="text" autocomplete="off" value="<?php echo isset($result['moduloPadreME']) ? $result['moduloPadreME'] : ''; ?>">    
                                                        </div>

                                                        <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Permiso:</b> </label>
                                                        <div class="form-group col-md-4">
                                                            <select id="permisoME" name="permisoME" data-plugin="select2 inputtext" inputtext="">
                                                                <option value="" selected> </option>
                                                                <option value="R">Read (R)</option>
                                                                <option value="W">Write (W)</option>
                                                                <option value="D">Delete (D)</option>
                                                                <option value="A">Admin (A)</option>
                                                            </select>    
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12">
                                                        <label class="col-md-2 control-label"><b> Comportamiento:</b> </label>
                                                        <div class="form-group col-md-4">
                                                            
                                                            <select id="comportamientoME" name="comportamientoME" data-plugin="select2 inputtext" inputtext="">
                                                                <option value="" selected> </option>
                                                                 <?php 
                                                                    if (isset($data['comportamientos']) && !empty($data['comportamientos']) && is_array($data['comportamientos'])) {
                                                                        foreach($data['comportamientos'] as $row){
                                                                            ?>
                                                                                <option value="<?php echo $row['id']; ?>" > 
                                                                                    <?php echo $row['comportamiento']; ?>
                                                                                </option>
                                                                            <?php 
                                                                        }//END FOREACH
                                                                    }//END IF
                                                                ?>   
                                                            </select>  
                                                        </div>

                                                        <label class="col-md-2 control-label"><b> Título:</b> </label>
                                                        <div class="form-group col-md-4">
                                                            <input class="form-control" autocomplete="off"  data-plugin="inputText" inputtext="" id="tituloME"  placeholder="TÍTULO" type="text" value="<?php echo isset($result['tituloME']) ? $result['tituloME'] : ''; ?>">    
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-md-2 control-label"><b><span style="color:red;">* </span> Posición:</b> </label>
                                                        <div class="form-group col-md-4">
                                                            <input class="form-control" autocomplete="off" data-plugin="inputText" inputtext="" id="posicionME"  type="text" placeholder="POSICIÓN" value="<?php echo isset($result['posicionME']) ? $result['posicionME'] : ''; ?>">    
                                                        </div>

                                                        <label class="col-md-2 control-label"><b> Ícono:</b> </label>
                                                        <div class="form-group col-md-4">
                                                            <input class="form-control" autocomplete="off" data-plugin="inputText" inputtext="" id="iconoME"  placeholder="ÍCONO" type="text" value="<?php echo isset($result['iconoME']) ? $result['iconoME'] : ''; ?>">    
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="col-md-2 control-label"><b> Función:</b> </label>
                                                        <div class="form-group col-md-4">
                                                            <input class="form-control" autocomplete="off" data-plugin="inputText" inputtext="" id="funcionME"  placeholder="FUNCIÓN" type="text" value="<?php echo isset($result['funcionME']) ? $result['funcionME'] : ''; ?>">    
                                                        </div>
                                                    </div>
                                          
                      
                                          <!-- YOUR CODE END HERE -->
                      
                                          <div class="col-md-3">
                                              <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary pull-right">
                                                  <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                      
                                  <div class="col-md-12">
                                      <div class="example">
                                          <div id="toolbar2">
                                              <button id="tableMultiple1-removeRowTableMultiple" class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                                                  <i class="fa fa-trash"></i> Borrar
                                              </button>
                                          </div>
                                          <table id="tableMultiple1" data-toggle="table" data-toolbar="#toolbar2"
                                                 data-query-params="queryParams" data-mobile-responsive="true"
                                                 data-height="400" data-pagination="false" data-icon-size="outline"
                                                 data-search="true" data-unique-id="id">
                                          </table>
                                      </div>
                                  </div>
                      
                              </div>
                    </div>
                </div>

                <!-- TAB CARACTERISTICAS !-->

                <div class="tab-pane animation-slide-left" id="caracteristicas" role="tabpanel">
                    <div class="row margin-20">
                        <div class="col-md-12">
                            <label class="col-md-2"><b> Características del Módulo:</b></label>
                            <div class="form-group col-md-8">
                                 <div class="select2-primary">
                                        <select id="skCaracteristicaModulo" name="skCaracteristicaModulo[]" placeholder="CARACTERÍSTICA DEL MÓDULO" class="form-control" multiple="multiple"  data-plugin="select2">
                                            <?php
                                                if(isset($data['caracteristicas']) && !empty($data['caracteristicas'])){
                                                    foreach ($data['caracteristicas'] as $row ) {
                                                ?>
                                                        <option value="<?php echo $row['id']; ?>" 
                                                        <?php 
                                                            if(isset($data['caracteristicasModulo']) && !empty($data['caracteristicasModulo'])){
                                                                foreach($data['caracteristicasModulo'] AS $val){
                                                                    if($val['skCaracteristicaModulo']==$row['id']){
                                                                        echo 'selected';
                                                                    }
                                                                }
                                                            }
                                                        ?> >
                                                        <?php echo $row['nombre'] ?>
                                                        </option>                                        
                                                <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <table id="table"></table>
</div>
  

  <!-- YOUR CODE END HERE -->


</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;

        function tableMultiple_addNewRow(index) {
            // AQUÍ HACEMOS LAS VALIDACIONES DE LOS CAMPOS REQUERIDOS O LAS VALIDACIONES NECESARIAS //
               if (typeof index == 'undefined') {
                    // VALIDAMOS QUE NO SE REPITA EL RECINTO
                    var flag = true;
                    $('input[name="posicionBoton[]"]').each(function(k,v){
                        if($( "#posicionBoton" ).val() == $(v).val()){
                            flag = false;
                            return false;
                        }
                    });

                    if(!flag){
                        toastr.warning("YA SE HA AGREGADO LA POSICIÓN: "+$( "#posicionBoton" ).val()+"","NOTIFICACIÓN");
                        return;
                    }
                }
                
                var RegExp_modulo = /^([0-9a-z]{4}-[0-9a-z]{4})?$/g;
                if(!RegExp_modulo.exec($("#moduloPadreBoton").val())){
                    toastr.warning('EL MÓDULO PADRE NO ES VALÍDO -> FORMATO xxxx-xxxx.', 'NOTIFICACIÓN');
                    return false;
                }

                if($("#skBoton").val() == null || $("#skBoton").val() == "") {
                    toastr.warning("ES NECESARIO UN TIPO DE BÓTON");
                    return false;
                }

                if($("#moduloPadreBoton").val() == null || $("#moduloPadreBoton").val() == "") {
                    toastr.warning("ES NECESARIO INDICAR EL MODULO PADRE ","NOTIFICACIÓN");
                    return false;
                }

                if($("#posicionBoton").val() == null || $("#posicionBoton").val() == "") {
                    toastr.warning("ES NECESARIO INDICAR LA POSICION","NOTIFICACIÓN");
                    return false;
                }

                if (!/^([0-9])*$/.test($("#posicionBoton").val())){
                    toastr.warning("LA POSICIÓN SOLO ACEPTA NÚMEROS","NOTIFICACIÓN");
                    return false;
                }

    
            // AQUÍ VAN LAS CONFIGURACIÓN DE LOS COMPONENTES QUE TIENEN LA TABLA MÚLTIPLE EN SU FORMULARIO EXCEPTO EL ID //
                var params = {
                    "skBoton": {"id": "skBoton", "type": "val"},
                    "moduloPadreBoton": {"id": "moduloPadreBoton", "type": "val"},
                    "posicionBoton": {"id": "posicionBoton", "type": "val"},
                    "nombreBoton": {"id": "nombreBoton", "type": "val"},
                    "funcionBoton": {"id": "funcionBoton", "type": "val"},
                    "iconoBoton": {"id": "iconoBoton", "type": "val"},
                    "comportamientoBoton": {"id": "comportamientoBoton", "type": "val"},
                    
                };

                // AQUÍ SE AGREGA EL REGISTRO A LA TABLA MÚLTIPLE //
                    core.tableMultipleAddRow($('#tableMultiple'), params,null,index);

                    $("#skBoton").select2("destroy");
                    $("#skBoton").select2({placeholder: "SELECCIONE UN TIPO DE BÓTON"});
        }
    
        var params = {
            datos: {
                columns: [
                    {
                        // ESTE ES EL CHECKBOX PARA BORRAR EL REGISTRO DE LA TABLA MÚLTIPLE SIEMPRE TIENE QUE ESTAR
                        field: 'state',
                        checkbox: true,
                        align: 'center',
                        valign: 'middle'
                    },  
                    {
                        field: 'skBoton', // ID DEL COMPONENTE DE HTML
                        title: 'Bóton' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                    },
                    {
                        field: 'moduloPadreBoton', // ID DEL COMPONENTE DE HTML
                        title: 'Módulo Padre' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                    },
                    {
                        field: 'posicionBoton', // ID DEL COMPONENTE DE HTML
                        title: 'Posición' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                    },
                    {
                        field: 'nombreBoton', // ID DEL COMPONENTE DE HTML
                        title: 'Nombre' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                    },
                    {
                        field: 'funcionBoton', // ID DEL COMPONENTE DE HTML
                        title: 'Función' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                    },
                    {
                        field: 'iconoBoton', // ID DEL COMPONENTE DE HTML
                        title: 'Ícono' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                    },
                    {
                        field: 'comportamientoBoton', // ID DEL COMPONENTE DE HTML
                        title: 'Comportamiento' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                    },{
                        // ESTE ES EL ID DE LA TABLA MÚLTIPLE SIEMPRE TIENE QUE ESTAR
                        field: 'id',
                        title: ''
                    }
                ],
                // ESTOS SON LOS DATOS GUARDADOS EN LA BASE DE DATOS 
                data: <?php echo isset($data["botones"]) ? json_encode($data["botones"]) : json_encode([]); ?>
            }
        };
        
            function tableMultiple1_addNewRow(index) {
                // AQUÍ HACEMOS LAS VALIDACIONES DE LOS CAMPOS REQUERIDOS O LAS VALIDACIONES NECESARIAS //
                    if (typeof index == 'undefined') {
                    // VALIDAMOS QUE NO SE REPITA EL RECINTO
                    var flag = true;
                    $('input[name="posicionME[]"]').each(function(k,v){
                        if($( "#posicionME" ).val() == $(v).val()){
                            flag = false;
                            return false;
                        }
                    });

                    if(!flag){
                        toastr.warning("YA SE HA AGREGADO LA POSICIÓN: "+$( "#posicionME" ).val()+"","NOTIFICACIÓN");
                        return;
                    }
                }
                    if($("#tituloME").val() !='-'){
                        var RegExp_modulo = /^([0-9a-z]{4}-[0-9a-z]{4})?$/g;
                        if(!RegExp_modulo.exec($("#moduloPadreME").val())){
                            toastr.warning('EL MÓDULO NO ES VALÍDO -> FORMATO xxxx-xxxx.', 'NOTIFICACIÓN');
                            return false;
                        }
                
                        if($("#moduloPadreME").val() == null || $("#moduloPadreME").val() == "") {
                            toastr.warning("ES NECESARIO INDICAR EL MÓDULO PADRE","NOTIFICACIÓN");
                            return false;
                        }
                        
                        if($("#permisoME").val() == null || $("#permisoME").val() == "") {
                            toastr.warning("ES NECESARIO INDICAR UN PERMISO ","NOTIFICACIÓN");
                            return false;
                        }
                    }

                    if($("#posicionME").val() == null || $("#posicionME").val() == "") {
                        toastr.warning("ES NECESARIO INDICAR LA POSICION","NOTIFICACIÓN");
                        return false;
                    }

                    if (!/^([0-9])*$/.test($("#posicionME").val())){
                        toastr.warning("LA POSICIÓN SOLO ACEPTA NÚMEROS","NOTIFICACIÓN");
                        return false;
                    }

                // AQUÍ VAN LAS CONFIGURACIÓN DE LOS COMPONENTES QUE TIENEN LA TABLA MÚLTIPLE EN SU FORMULARIO EXCEPTO EL ID //
                    var params2 = {
                        "moduloPadreME": {"id": "moduloPadreME", "type": "val"},
                        "permisoME": {"id": "permisoME", "type": "val"},
                        "comportamientoME": {"id": "comportamientoME", "type": "val"},
                        "posicionME": {"id": "posicionME", "type": "val"},
                        "iconoME": {"id": "iconoME", "type": "val"},
                        "funcionME": {"id": "funcionME", "type": "val"},
                        "tituloME": {"id": "tituloME", "type": "val"},
                    };

                    // AQUÍ SE AGREGA EL REGISTRO A LA TABLA MÚLTIPLE //
                        core.tableMultipleAddRow($('#tableMultiple1'), params2,null,index);

                        $("#permisoME").select2("destroy");
                        $("#permisoME").select2({placeholder: "SELECCIONE UN PERMISO"});
                        $("#comportamientoME").select2("destroy");
                        $("#comportamientoME").select2({placeholder: "COMPORTAMIENTO"});
            }
        
            var params2 = {
                datos: {
                    columns: [
                        {
                            // ESTE ES EL CHECKBOX PARA BORRAR EL REGISTRO DE LA TABLA MÚLTIPLE SIEMPRE TIENE QUE ESTAR
                            field: 'state',
                            checkbox: true,
                            align: 'center',
                            valign: 'middle'
                        },
                        {
                            // ESTE ES EL ID DE LA TABLA MÚLTIPLE SIEMPRE TIENE QUE ESTAR
                            field: 'id',
                            title: ''
                        },
                        {
                            field: 'moduloPadreME', // ID DEL COMPONENTE DE HTML
                            title: 'Módulo Padre' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                        },
                        {
                            field: 'permisoME', // ID DEL COMPONENTE DE HTML
                            title: 'Permisos' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                        },
                        {
                            field: 'comportamientoME', // ID DEL COMPONENTE DE HTML
                            title: 'Comportamiento' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                        },
                        {
                        // ESTE ES EL ID DE LA TABLA MÚLTIPLE SIEMPRE TIENE QUE ESTAR
                            field: 'tituloME',
                            title: 'Título'
                        },
                        {
                            field: 'posicionME', // ID DEL COMPONENTE DE HTML
                            title: 'Posición' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                        },
                        {
                            field: 'iconoME', // ID DEL COMPONENTE DE HTML
                            title: 'Icono' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                        },
                        {
                            field: 'funcionME', // ID DEL COMPONENTE DE HTML
                            title: 'Función' // NOMBRE DE LA COLUMNA DE LA TABLA HTML
                        }
                    ],
                    // ESTOS SON LOS DATOS GUARDADOS EN LA BASE DE DATOS 
                    data: <?php echo isset($data["ME"]) ? json_encode($data["ME"]) : json_encode([]); ?>
                }
            };

    $(document).ready(function () {
        core.tableMultiple($("#tableMultiple"), params);
        core.tableMultiple($("#tableMultiple1"), params2);
        $("#skBoton").select2({placeholder: "TIPO DE BÓTON"});
        $("#skMenu").select2({placeholder: "TIPO DE MENÚ"});
        $("#permisoME").select2({placeholder: "PERMISO"});
        $("#comportamientoME").select2({placeholder: "COMPORTAMIENTO"});
        $('#core-guardar').formValidation(core.formValidaciones);
        $("#skCaracteristicaModulo").select2();

        //si el modulo tiene permisos se seleccionan
        if($("#W").val()=='W'){
            $(".W").attr("checked", '');
        }

        if($("#R").val()=='R'){
            $(".R").attr("checked", '');
        }

        if($("#D").val()=='D'){
            $(".D").attr("checked", '');
        }

        if($("#A").val()=='A'){
            $(".A").attr("checked", '');
        }

        
    });

    

</script>