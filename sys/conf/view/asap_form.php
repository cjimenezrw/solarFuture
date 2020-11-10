<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);

    $arrayPerfilesAplicaciones = array();

    if (isset($data['perfilAplicacion'])) {
        if ($data['perfilAplicacion']) {
            foreach ($data['perfilAplicacion'] as $row) {
                $arrayPerfilesAplicaciones[] = $row{'skAplicacion'};
            }
        }
    }
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skPerfil"  id="skPerfil" value="<?php echo (isset($result['skPerfil'])) ? $result['skPerfil'] : ''; ?>">
    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        <div class="col-md-4">
            <label class="control-label"><?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?></label>
        </div>
        <label class="col-md-2 control-label"><b>Estatus</b> </label>
        <div class="col-md-4">
            <label class="control-label"><?php echo (isset($result['sEstatus'])) ? $result['sEstatus'] : ''; ?></label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <hr>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>Usuario Creaci&oacute;n</b> </label>
        <div class="col-md-4">
            <label class="control-label"><?php echo (isset($result['sUsuarioCreador'])) ? $result['sUsuarioCreador'] : ' '; ?></label>
        </div>
        <label class="col-md-2 control-label"><b>Usuario Modificaci&oacute;n</b> </label>
        <div class="col-md-4">
            <label class="control-label"><?php echo (isset($result['sUsuarioModificador'])) ? $result['sUsuarioModificador'] : ' '; ?></label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <hr>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>Asignar Aplicacion</b> </label>
        <div class="col-md-8">

            <?php
            if ($data['aplicaciones']) {
                foreach ($data['aplicaciones'] as $row) {
                    ?>
                    <div class="col-md-4">
                        <div class="checkbox-custom checkbox-primary">
                            <input  value="<?php echo $row['skAplicacion']; ?>"    <?php echo (in_array($row['skAplicacion'], $arrayPerfilesAplicaciones) ? 'checked' : '') ?>   name="skAplicacion[]"   type="checkbox">
                            <label><?php echo $row['sNombre']; ?> </label>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

        </div>
    </div>


</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = conf.asap_form.validaciones;
    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
    });
</script>
