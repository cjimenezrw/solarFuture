<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
</style>

<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
  <input name="skRechazoRevalidacion" value="<?php   echo (isset($result['skRechazoRevalidacion'])) ? $result['skRechazoRevalidacion'] : '';   ?>" type="hidden">


    <div class="form-group col-md-12">

        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        <div class="col-md-3 form-group">
            <input class="form-control"   name="sNombre" value="<?php   echo (isset($result['sNombre'])) ? $result['sNombre'] : '';   ?>" placeholder="nombre" autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Estatus:</b> </label>
            <div class="col-md-3">

                <select  name="skEstatus" class="form-control">
                    <option value="">Seleccionar</option>
                    <?php if ($data['estatus']) {
                        foreach ($data['estatus'] as $row) { ?>
                            <option <?php echo(isset($result['skEstatus']) && $result['skEstatus'] == $row['skEstatus'] ? 'selected="selected"' : '') ?>
                                value="<?php echo $row['skEstatus']; ?>"> <?php echo $row['sNombre']; ?> </option>
                        <?php }
                    }//ENDWHILE
                    ?>
                </select>

            </div>
    </div>




</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = conf.rech_form.validations;


    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);

    });
</script>
