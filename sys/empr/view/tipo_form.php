<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skEmpresaTipoViejo"  id="skGrupo" 
           value="<?php echo (isset($result['skEmpresaTipo'])) ? $result['skEmpresaTipo'] : ''; ?>">

    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>Codigo:</b> </label>
        <div class="col-md-3">
            <input class="form-control" maxlength="4" 
                <?php if(isset($result['skEmpresaTipo'])){ ?>disabled="disabled" disabled<?php }//ENDIF ?>  name="skEmpresaTipo" 
                value="<?php echo (isset($result['skEmpresaTipo'])) ? utf8_encode($result['skEmpresaTipo']) : '' ; ?>" placeholder="C&oacute;digo" autocomplete="off" type="text">
        </div>
        
        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        
        <div class="col-md-3">
            <input class="form-control" name="sNombre" 
                   value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="Nombre" autocomplete="off" type="text">
        </div>

    </div>
    
    <div class="form-group col-md-12">
        <label class="col-sm-2 control-label"><b>Estatus:</b> </label>
        <div class="col-sm-3">
            
            <select  name="skEstatus" class="form-control">
                <option value="">Seleccionar</option>
                <?php
                if ($data['Estatus']) {
                    foreach ( $data['Estatus'] as $row) {
                       //DLOREAN_Model::log("Le inserte?", true);
                ?>
                        <option <?php echo(isset($result['skEstatus']) && $result['skEstatus'] == $row['skEstatus'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skEstatus']; ?>"> <?php echo $row['sNombre']; ?> </option>
                <?php
                        }
                    }//ENDWHILE
                ?>
            </select>

        </div>
    </div>
</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = empr.tipo_form.validaciones;
     $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
     });
</script>
