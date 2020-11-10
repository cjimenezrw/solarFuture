<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 13/08/2018
 * Time: 02:27 PM
 */
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);


}

?>
<form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="skTarjetaBanco" id="skTarjetaBanco"
           value="<?php echo (isset($result['skTarjetaBanco'])) ? $result['skTarjetaBanco'] : ''; ?>">
    <!-- Datos del pedimento -->
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos De Tarjeta</h3>
        </div>
        <div class="panel-body container-fluid">
            <div class="row row-lg">

                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">Banco:</h4>
                        <select name="skBanco" id="skBanco" class="form-control selectpicker">
                            <option value="">Seleccionar</option>
                            <?php
                            if ($data['bancos']) {
                                foreach ($data['bancos'] as $row) {
                                    ?>
                                    <option <?php echo(isset($result['skBanco']) && $result['skBanco'] == $row['skBanco'] ? 'selected="selected"' : '') ?>
                                        value="<?php echo $row['skBanco']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                }//ENDWHILE
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row row-lg">

                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">Tarjeta:</h4>
                        <input type="text" class="form-control" id="sTarjeta" name="sTarjeta"
                               value="<?php echo (isset($result['sTarjeta'])) ? $result['sTarjeta'] : ''; ?>"
                               placeholder="XXX-XXXX-XXXX-XXXXX">
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">Descripción Tarjeta:</h4>
                        <input type="text" class="form-control" id="sDescripcionTarjeta" name="sDescripcionTarjeta"
                               value="<?php echo (isset($result['sDescripcion'])) ? $result['sDescripcion'] : ''; ?>"
                               placeholder="Descripción Cuenta">
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
<script
    src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script>
    core.formValidaciones.fields = conf.cuen_form.validaciones;
    $(document).ready(function () {

        $('#core-guardar').formValidation(core.formValidaciones);
        $('#mowi').iziModal('setBackground', '#f1f4f5');
        $('.selectpicker').selectpicker();
    });

</script>
