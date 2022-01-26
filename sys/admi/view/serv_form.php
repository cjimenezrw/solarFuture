<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS GENERALES</h3>
        </div>
        <div class="panel-body container-fluid">

            <div class="row row-lg col-lg-12">
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span class="required text-danger">*</span> NOMBRE</h4>
                        <input class="form-control" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>" placeholder="NOMBRE" autocomplete="off" type="text" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span class="required text-danger">*</span> CÓDIGO</h4>
                        <input class="form-control" name="sCodigo" value="<?php echo (isset($result['sCodigo'])) ? $result['sCodigo'] : ''; ?>" placeholder="CÓDIGO" autocomplete="off" type="text" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span class="required text-danger">*</span> CLAVE PRODUCTO / SERVICIO (SAT)</h4>
                        <input class="form-control" name="iClaveProductoServicio" value="<?php echo (isset($result['iClaveProductoServicio'])) ? $result['iClaveProductoServicio'] : ''; ?>"  placeholder="CLAVE PRODUCTO / SERVICIO (SAT)" autocomplete="off" type="text" >
                    </div>
                </div>                     
            </div>

               
            <div class="row row-lg col-lg-12"><hr></div>

            <div class="row row-lg col-lg-12">
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span class="required text-danger">*</span> UNIDAD DE MEDIDA</h4>
                        <select id="skUnidadMedida"  name="skUnidadMedida" class="form-control" data-plugin="select2" select2Simple>
                            <option value="">- SELECCIONAR -</option>
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
            </div>

            <div class="row row-lg col-lg-12 clearfix"><hr></div>

            <div class="row row-lg col-lg-12">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <h4 class="example-title">DESCRIPCIÓN</h4>
                        <textarea class="form-control"  name="sDescripcion" placeholder="DESCRIPCIÓN"><?php echo (isset($result['sDescripcion'])) ? ($result['sDescripcion']) : ''; ?></textarea>
                    </div>
                </div>
            </div>
                     
        </div>
    </div>
     
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">CONFIGURACIONES</h3>
        </div>
        <div class="panel-body container-fluid">

            <div class="row row-lg">
                <div class="col-md-12">
                    <h4 class="example-title">IMPUESTOS A APLICAR</h4>
                    <div class="form-group col-md-10">
                        <div class="select2-primary container-bl">
                            <select name="skImpuesto[]" id="skImpuesto" class="form-control select2" multiple="multiple" data-plugin="select2">
                            <?php
                            if (!empty($data['serviciosImpuestos']) && is_array($data['serviciosImpuestos'])) {
                                foreach ($data['serviciosImpuestos'] AS $row) {
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
                                <td><input type="text" name="CATPRE[<?php echo $row['skCatalogoSistemaOpciones']; ?>]" id="input-<?php echo $row['skCatalogoSistemaOpciones']; ?>" class="form-control" autocomplete="off" value="<?php echo (!empty($row['fPrecio']) ? $row['fPrecio'] : ''); ?>"></td>
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


</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    core.formValidaciones.fields = admi.serv_form.validaciones;
    
    function searchFilter() {
        var rex = new RegExp($("#inputFilter").val(), 'i');
        $('.tbody_searchable tr').hide();
        $('.tbody_searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();
    }

    $(document).ready(function () {

        $("#skUnidadMedida").select2({placeholder: "UNIDAD DE MEDIDA", allowClear: true });
    
        $('#core-guardar').formValidation(core.formValidaciones);

        $("#skImpuesto").select2({
            width: "100%"
        });

       

    });

</script>
