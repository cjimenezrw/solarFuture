<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);


}

?>
<form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="skCuentaBanco" id="skCuentaBanco"
           value="<?php echo (isset($result['skCuentaBanco'])) ? $result['skCuentaBanco'] : ''; ?>">
    <!-- Datos del pedimento -->
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos De Cuenta</h3>
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
                        <h4 class="example-title">Número de Cuenta:</h4>
                        <input type="text" class="form-control" id="sCuenta" name="sCuenta"
                               value="<?php echo (isset($result['sCuenta'])) ? $result['sCuenta'] : ''; ?>"
                               placeholder="XXX-XXXX-XXXX-XXXXX">
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">Descripción Cuenta:</h4>
                        <input type="text" class="form-control" id="sDescripcionCuenta" name="sDescripcionCuenta"
                               value="<?php echo (isset($result['sDescripcionCuenta'])) ? $result['sDescripcionCuenta'] : ''; ?>"
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
