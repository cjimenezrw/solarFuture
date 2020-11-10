<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>RFC:</b> </label>
        <div class="col-md-3">
            <input class="form-control" maxlength="13" <?php if (isset($result['sRFC'])) { ?>disabled="disabled"<?php }//ENDIF     ?>
                   name="sRFC" value="<?php echo (isset($result['sRFC'])) ? utf8_encode($result['sRFC']) : ''; ?>"
                   placeholder="RFC" autocomplete="off" type="text"
                   onblur="empr.emso_form.getEmpresaSocio(this);">
                   <div class="col-md-12"><small>Si no cuenta con el RFC, puede agregar el RFC Generico (XAXX010101000)</small></div>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <hr>
        </div>
    </div>

    <div class="col-md-12">

        <label class="col-sm-2 control-label"><b>Tipo Empresa:</b> </label>
        <input type="hidden" name="skEmpresa"  id="skEmpresa" value="<?php echo (isset($result['skEmpresa'])) ? $result['skEmpresa'] : ''; ?>">
        <div class="form-group col-sm-3">
            <select id="skEmpresaTipo" name="skEmpresaTipo" class="form-control" onchange="empr.emso_form.change_skEmpresaTipo(this);empr.emso_form.revalidarFormulario();">
                <option value="">Seleccionar</option>
                <?php
                if ($data['empresasTipos']) {
                    foreach ($data['empresasTipos'] as $row) {
                        utf8($row);
                        ?>
                        <option <?php echo(isset($result['skEmpresaTipo']) && $result['skEmpresaTipo'] == $row['skEmpresaTipo'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skEmpresaTipo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                            <?php
                        }//ENDWHILE
                    }//ENDIF
                    ?>
            </select>

        </div>
    </div>
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Razon Social:</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" id="sNombre" name="sRazonSocial" value="<?php echo (isset($result['sRazonSocial'])) ? ($result['sRazonSocial']) : ''; ?>" placeholder="Nombre" autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Nombre Corto:</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" id="sNombreCorto" name="sAlias" value="<?php echo (isset($result['sAlias'])) ? ($result['sAlias']) : ''; ?>"  placeholder="Nombre Corto" autocomplete="off" type="text">
        </div>
    </div>

</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
                                core.formValidaciones.fields = empr.soem_form.validaciones;
                                $(document).ready(function () {
                                    $('#core-guardar').formValidation(core.formValidaciones);
                                });
</script>
