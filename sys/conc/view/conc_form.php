<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos Generales</h3>
        </div>
        <div class="panel-body container-fluid">
                  <div class="row row-lg col-lg-12">
                              <div class="col-md-4 col-lg-4">
                                  <div class="form-group">
                                      <h4 class="example-title">Nombre <span class="required text-danger">*</span></h4>
                                      <input class="form-control" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>" placeholder="Nombre del Concepto" autocomplete="off" type="text" >
                                  </div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                  <div class="form-group">
                                      <h4 class="example-title">CODIGO <span class="required text-danger">*</span></h4>
                                      <input class="form-control" name="sCodigo" value="<?php echo (isset($result['sCodigo'])) ? $result['sCodigo'] : ''; ?>" placeholder="CODIGO" autocomplete="off" type="text" >
                                  </div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <h4 class="example-title">Clave Producto/ Servicio <span class="required text-danger">*</span></h4>
                                    <input class="form-control" name="iClaveProductoServicio" value="<?php echo (isset($result['iClaveProductoServicio'])) ? $result['iClaveProductoServicio'] : ''; ?>"  placeholder="Clave Producto/Servicio" autocomplete="off" type="text" >
                                </div>
                            </div> 
                                
                  </div>
                  <div class="row row-lg col-lg-12">
                      <hr>
                  </div>
                 <div class="row row-lg col-lg-12">
                     
                     <div class="col-md-4 col-lg-4">
                         <div class="form-group">
                             <h4 class="example-title">Unidad de Medida <span class="required text-danger">*</span></h4>
                             <select id="skUnidadMedida"  name="skUnidadMedida" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">Seleccionar</option>
                                 <?php
                                 if ($data['unidadesMedida']) {
                                 foreach (  $data['unidadesMedida'] as $row) {
                                     utf8($row);
                                     ?>
                                     <option <?php echo(isset($result['skUnidadMedida']) && $result['skUnidadMedida'] == $row['skUnidadMedida'] ? 'selected="selected"' : '') ?>
                                         value="<?php echo $row['skUnidadMedida']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                     </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">PRECIO COMPRA </h4>
                            <input class="form-control" name="fPrecioCompra" value="<?php echo (isset($result['fPrecioCompra'])) ? $result['fPrecioCompra'] : ''; ?>" placeholder="PRECIO COMPRA" autocomplete="off" type="text" >
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">PRECIO VENTA  </h4>
                            <input class="form-control" name="fPrecioVenta" value="<?php echo (isset($result['fPrecioVenta'])) ? $result['fPrecioVenta'] : ''; ?>" placeholder="PRECIO VENTA" autocomplete="off" type="text" >
                        </div>
                    </div>
                 </div>
                 <div class="row row-lg col-lg-12">
                    <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                            <h4 class="example-title">PROVEEDOR:</h4>
                            <select name="skEmpresaSocioProveedor" id="skEmpresaSocioProveedor" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                                <?php
                                if (!empty($result['skEmpresaSocioProveedor'])) {
                                    ?>
                                    <option value="<?php echo $result['skEmpresaSocioProveedor']; ?>" selected="selected"><?php echo $result['proveedor'] . ' (' . $result['proveedorRFC'] . ')'; ?></option>
                                    <?php
                                }//ENDIF
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">KHW  </h4>
                            <input class="form-control" name="fKwh" value="<?php echo (isset($result['fKwh'])) ? $result['fKwh'] : ''; ?>" placeholder="KWH" autocomplete="off" type="text" >
                        </div>
                    </div>
                 </div>
                 <div class="row row-lg col-lg-12">
                     <hr>
                 </div>
                 <div class="row row-lg col-lg-12">
                     <div class="col-md-8 col-lg-8">
                         <div class="form-group">
                             <h4 class="example-title"> Descripci&oacute;n</h4>
                             <textarea class="form-control"  name="sDescripcion" placeholder="Descripcion del Concepto"><?php echo (isset($result['sDescripcion'])) ? ($result['sDescripcion']) : ''; ?></textarea>
                         </div>
                     </div>
                 </div>
                </div>
            </div>
     
<div class="panel panel-bordered panel-primary panel-line">
    <div class="panel-heading">
        <h3 class="panel-title">Configuraciones</h3>
    </div>
    <div class="panel-body container-fluid">
            <div class="row row-lg">

                <div class="col-md-12">
                <label class="col-md-2 control-label"><b>Impuestos a Aplicar</b> </label>
                <div class="form-group col-md-10">
                    <div class="select2-primary container-bl">
                        <select name="skImpuesto[]" id="skImpuesto" class="form-control select2" multiple="multiple" data-plugin="select2">
                        <?php
                        if (isset($data['conceptosImpuestos']) && is_array($data['conceptosImpuestos'])) {
                        foreach ($data['conceptosImpuestos'] AS $row) {
                        ?>
                        <option  value="<?php echo $row['id']; ?>" <?php echo ($row['selected'] == 1) ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
                        <?php
                        }//ENDFOREACH
                        }//ENDIF
                        ?>
                        </select>
                    </div>
                    </div>
            </div>
                 
              
                 



             

        </div>
    </div>
</div>


</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    core.formValidaciones.fields = conc.conc_form.validaciones;

 
  
    $(document).ready(function () {
        $("#skUnidadMedida").select2({placeholder: "Unidad de Medida", allowClear: true });
          
       core.autocomplete2('#skEmpresaSocioProveedor', 'get_empresas', window.location.href, 'Proveedor',{
                skEmpresaTipo : '["PROV"]'
            });
   
        $('#core-guardar').formValidation(core.formValidaciones);
        $("#skImpuesto").select2({
                width: "100%"
            });

   
    });
</script>
