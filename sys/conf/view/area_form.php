<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 02/11/2016
 * Time: 09:29 AM
 */
    if(isset($data['datos'])){
        $result = $data['datos'];
        utf8($result);
    }
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skAreaVieja"  id="skAreaVieja" value="<?php echo (isset($result['skArea'])) ? $result['skArea'] : '' ; ?>">
    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>C&oacute;digo:</b> </label>
        <div class="col-md-3">
            <input class="form-control" maxlength="4" <?php if(isset($result['skArea'])){ ?>disabled="disabled"<?php }//ENDIF ?>  name="skArea" value="<?php echo (isset($result['skArea'])) ? utf8_encode($result['skArea']) : '' ; ?>" placeholder="C&oacute;digo" autocomplete="off" type="text">
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
        <label class="col-md-2 control-label"><b>Estatus:</b> </label>
        <div class="col-md-3">

            <!--
              <div class="btn-group bootstrap-select">
            data-plugin="selectpicker"
            </div>-->
            <select  name="skEstatus" class="form-control">
                <option value="">Seleccionar</option>
                <?php if ($data['Estatus']) {
                    foreach ($data['Estatus'] as $row) { ?>
                        <option <?php echo(isset($result['skEstatus']) && $result['skEstatus'] == $row['skEstatus'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skEstatus']; ?>"> <?php echo $row['sNombre']; ?> </option>
                    <?php }
                }//ENDWHILE
                ?>
            </select>

        </div>
        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        <div class="col-md-3">
            <input class="form-control" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : '' ; ?>" placeholder="Nombre" autocomplete="off" type="text">
        </div>
    </div>
</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = conf.area_form.validaciones;
    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
    });
</script>
