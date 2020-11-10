<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skServidorVinculadoViejo"  id="skServidorVinculadoViejo" value="<?php echo (isset($result['skServidorVinculado'])) ? $result['skServidorVinculado'] : ''; ?>">
    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>C&oacute;digo:</b> </label>
        <div class="col-md-3">
            <input class="form-control" maxlength="4" <?php if (isset($result['skServidorVinculado'])) { ?>disabled="disabled"<?php }//ENDIF  ?>  name="skServidorVinculado" value="<?php echo (isset($result['skServidorVinculado'])) ? utf8_encode($result['skServidorVinculado']) : ''; ?>" placeholder="C&oacute;digo" autocomplete="off" type="text">
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
        <label class="col-sm-2 control-label"><b>Estatus:</b> </label>
        <div class="col-sm-3">

            <!--
              <div class="btn-group bootstrap-select">
            data-plugin="selectpicker"
            </div>-->
            <select  name="skEstatus" class="form-control">
                <option value="">Seleccionar</option>
                <?php if ($data['Estatus']) {
                    foreach ($data['Estatus'] as $row) {
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


    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Nombre</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sNombre"
                   value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>"
                   placeholder="Nombre" autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>IP</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sIP"
                   value="<?php echo (isset($result['sIP'])) ? $result['sIP'] : ''; ?>"
                   placeholder="IP" autocomplete="off" type="text">
        </div>


    </div>
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Usuario</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sUsuario"
                   value="<?php echo (isset($result['sUsuario'])) ? $result['sUsuario'] : ''; ?>"
                   placeholder="Usuario" autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Password</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sPassword"
                   value="<?php echo (isset($result['sPassword'])) ? $result['sPassword'] : ''; ?>"
                   placeholder="Password" autocomplete="off" type="text">
        </div>


    </div>
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Base de Datos</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sBDA"
                   value="<?php echo (isset($result['sBDA'])) ? $result['sBDA'] : ''; ?>"
                   placeholder="Base de Datos" autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Tipo</b> </label>
      
        <div class="form-group col-md-3">
             <select  name="sDSN" class="form-control">
                <option value="">Seleccionar</option>
                <?php if ($data['ServidoresSoportados']) {
                    foreach ($data['ServidoresSoportados'] as $row) {
                        ?>
                        <option <?php echo(isset($result['sDSN']) && trim($result['sDSN']) === trim($row['skDSN']) ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skDSN']; ?>" data-diport = "<?php echo $row['iPuertoDefault'] ;?>"> <?php echo $row['sNombre']; ?> </option>
                        <?php
                        }
                    }//ENDWHILE
                    ?>
            </select>
        </div>
    </div>
    
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Puerto</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="iPuerto"
                   value="<?php echo (isset($result['iPuerto'])) ? $result['iPuerto'] : ''; ?>"
                   placeholder="Base de Datos" autocomplete="off" type="number">
        </div>
        
        <label class="col-md-2 control-label"><b>Ruta de Vinculación</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sVinculacion"
                   value="<?php echo (isset($result['sVinculacion'])) ? $result['sVinculacion'] : ''; ?>"
                   placeholder="Base de Datos" autocomplete="off" type="text">
        </div>
    </div>
</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = conf.sevi_form.validaciones;
    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
        
    });



</script>
