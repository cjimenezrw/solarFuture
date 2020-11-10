<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        <div class="col-md-3">
            <input class="form-control" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>" 
                   placeholder="Nombre del servicio" autocomplete="off" type="text" >
        </div>
        <label class="col-md-2 control-label"><b>Descripcion:</b> </label>
        <div class="col-md-3">
            <textarea class="form-control"  name="sDescripcion" placeholder="Descripcion del servicio"><?php echo (isset($result['sDescripcion'])) ? ($result['sDescripcion']) : ''; ?></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <hr>
        </div>
    </div>

    <?php
    if (isset($data['empresasTipos'])) {
        
        $chk = [[], []];
        $p = true;
        
        foreach ($data['empresasTipos'] as $val) {
            $p = !$p;
            $s = (in_array($val['skEmpresaTipo'], $data['empresasTiposServicios'])) ? 'checked' : '';
            array_push($chk[(int) $p],  
            " 
                <div class=\"checkbox-custom checkbox-primary\">
                    <input type=\"checkbox\"  name='skEmpresaTipo[]' value=\"$val[skEmpresaTipo]\"  $s/>
                    <label for=\"inputUnchecked\">$val[sNombre]</label>
                </div>");
        }
        
    }
    ?>

    <div class="col-md-12">
        <label class="col-sm-2 control-label"><b>Tipo Empresa:</b> </label>
        <div class="form-group col-sm-4">
            <?php echo implode('', $chk[0]); ?>
            
        </div>        
        <div class="form-group col-sm-4">
            <?php echo implode('', $chk[1]); ?>
            
        </div>        

    </div>

</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = empr.esrv_form.validaciones;

    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
    });
</script>