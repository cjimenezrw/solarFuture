<?php
    if (isset($data['datos'])) {
        $result = $data['datos'];
    }
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skModuloDetalle"  id="skModuloDetalle" value="<?php echo (isset($result['skModuloDetalle'])) ? $result['skModuloDetalle'] : ''; ?>">
    
    <div class="col-md-12">
        <label class="col-md-3"><b>Modulo:</b> </label>
        <div class="form-group col-md-3">
            <select class="form-control" id="skServidorVinculado" name="skServidorVinculado" data-plugin="select2" select2Simple onchange="traf.apre_form.getReferenciasByCuentaConsolidada(this);" <?php echo (isset($data['referenciasVinculadas'][0]['skServidorVinculado'])) ? 'disabled' : ''; ?>>
                <option value="">- Seleccionar -</option>
                <?php 
                    if($data['servidoresVinculados']){
                        foreach($data['servidoresVinculados'] AS $row){
                ?>
                        <option value="<?php echo $row['skServidorVinculado']; ?>" <?php echo (isset($data['referenciasVinculadas'][0]['skServidorVinculado']) && $data['referenciasVinculadas'][0]['skServidorVinculado'] == $row['skServidorVinculado']) ? 'selected="selected"': '';?>><?php echo $row['sNombre']; ?></option>
                <?php
                        }//FOREACH
                    }//ENDIF
                ?>
            </select>
        </div>
        <label class="col-md-3"><b>SysExpert:</b> </label>
        <div class="form-group col-md-3">
            <select class="form-control" id="skServidorVinculado" name="skServidorVinculado" data-plugin="select2" select2Simple onchange="traf.apre_form.getReferenciasByCuentaConsolidada(this);" <?php echo (isset($data['referenciasVinculadas'][0]['skServidorVinculado'])) ? 'disabled' : ''; ?>>
                <option value="">- Seleccionar -</option>
                <?php 
                    if($data['servidoresVinculados']){
                        foreach($data['servidoresVinculados'] AS $row){
                ?>
                        <option value="<?php echo $row['skServidorVinculado']; ?>" <?php echo (isset($data['referenciasVinculadas'][0]['skServidorVinculado']) && $data['referenciasVinculadas'][0]['skServidorVinculado'] == $row['skServidorVinculado']) ? 'selected="selected"': '';?>><?php echo $row['sNombre']; ?></option>
                <?php
                        }//FOREACH
                    }//ENDIF
                ?>
            </select>
        </div>
    </div>
    
    <div class="col-md-12">
        <label class="col-md-3"><b>SysExpert:</b> </label>
        <div class="form-group col-md-3">
            <select class="form-control" id="skServidorVinculado" name="skServidorVinculado" data-plugin="select2" select2Simple onchange="traf.apre_form.getReferenciasByCuentaConsolidada(this);" <?php echo (isset($data['referenciasVinculadas'][0]['skServidorVinculado'])) ? 'disabled' : ''; ?>>
                <option value="">- Seleccionar -</option>
                <?php 
                    if($data['servidoresVinculados']){
                        foreach($data['servidoresVinculados'] AS $row){
                ?>
                        <option value="<?php echo $row['skServidorVinculado']; ?>" <?php echo (isset($data['referenciasVinculadas'][0]['skServidorVinculado']) && $data['referenciasVinculadas'][0]['skServidorVinculado'] == $row['skServidorVinculado']) ? 'selected="selected"': '';?>><?php echo $row['sNombre']; ?></option>
                <?php
                        }//FOREACH
                    }//ENDIF
                ?>
                
            </select>
        </div>
    </div>
    
    <div class="col-md-12">
        <label class="col-md-3"><b>Clasificador:</b> </label>
        <div class="form-group col-md-3">
            <select class="clasificadores-select" name="skUsuarioClasificacion" data-plugin="select2" <?php echo (isset($data['referenciasVinculadas'][0]['skUsuarioClasificacion'])) ? 'disabled' : ''; ?>>
                <option value="">No Requerido</option>
                <?php
                if($data['clasificadores']){
                    foreach($data['clasificadores'] AS $k=>$v){
                        $skUsuarioClasificacion = (isset($data['referenciasVinculadas'][0]['skUsuarioClasificacion']) ? $data['referenciasVinculadas'][0]['skUsuarioClasificacion'] : FALSE);
                        $clasificador = (isset($data['referenciasVinculadas'][0]['clasificador']) ? $data['referenciasVinculadas'][0]['clasificador'] : FALSE);
                ?>
                <option value="<?php echo $v['skUsuario']; ?>" <?php echo ($skUsuarioClasificacion) ? 'selected="selected"' : ''; ?>><?php echo $v['sNombre']; ?></option>
                <?php
                    }//ENDFOREACH
                }//ENDIF
                ?>
            </select>
        </div>
    </div>
    
</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = traf.traf_form.validations;
    
    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);
        
        $("#skUsuarioDeveloper").select2({placeholder: "Desarrollador", allowClear: true});
        $("#skUsuarioDeveloper").select2({placeholder: "Desarrollador", allowClear: true});
        
        $(".clasificadores-select").select2({placeholder: "Clasificador",allowClear: true});
        
        $('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });
        
    });
</script>
