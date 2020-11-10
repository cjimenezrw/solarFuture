<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 28/04/2018
 * Time: 12:17 PM
 */

if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
    <!-- Datos del pedimento -->
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos Del Banco</h3>
        </div>
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <!-- Nombre Banco -->
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">Nombre:</h4>
                        <input type="text" name="sNombre" class="form-control" id="sNombre" placeholder="Nombre Del Banco" value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>">
                        <input type="hidden" name="skBanco" class="form-control" id="skBanco" value="<?php echo (isset($result['skBanco'])) ? $result['skBanco'] : ''; ?>">
                    </div>
                </div>
                <!-- Descripcion -->
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">Descripcion:</h4>
                        <input type="text" name="sDescripcion" class="form-control" id="sDescripcion" placeholder="Descripción" value="<?php echo (isset($result['sDescripcion'])) ? $result['sDescripcion'] : ''; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>

    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
        $('#core-guardar').formValidation(validation1);
    });
    //core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;

    var validation1 = {
        sNombre: {
            validators: {
                notEmpty: {
                    message: 'El nombre es requerido'
                }
            }
        }
    };

</script>