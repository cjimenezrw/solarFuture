<?php
    if(isset($data['datos'])){
        $result = $data['datos'];
        utf8($result);


    }

?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
  <input type="hidden" name="skSucursalVieja"  id="skSucursalVieja" value="<?php echo (isset($result['skSucursal'])) ? $result['skSucursal'] : '' ; ?>">
  <div class="col-md-12">
    <label class="col-md-2 control-label"><b>C&oacute;digo:</b> </label>
    <div class="form-group  col-md-3">
      <input class="form-control" maxlength="4" <?php if(isset($result['skSucursal'])){ ?>disabled="disabled"<?php }//ENDIF ?>  name="skSucursal" value="<?php echo (isset($result['skSucursal'])) ? utf8_encode($result['skSucursal']) : '' ; ?>" placeholder="C&oacute;digo" autocomplete="off" type="text">
    </div>
  </div>
  <div class="form-group col-md-12">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
        <hr>
      </div>
  </div>
  <div class=" col-md-12">
    <label class="col-sm-2 control-label"><b>Estatus:</b> </label>
    <div class="form-group col-sm-3">

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
  </div>
  <div class="col-md-12">
    <label class="col-md-2 control-label"><b>Nombre:</b> </label>
    <div class="form-group col-md-3">
      <input class="form-control" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : '' ; ?>" placeholder="Nombre" autocomplete="off" type="text">
    </div>
    <label class="col-md-2 control-label"><b>Nombre Corto:</b> </label>
    <div class="form-group col-md-3">
      <input class="form-control" name="sNombreCorto" value="<?php echo (isset($result['sNombreCorto'])) ? ($result['sNombreCorto']) : '' ; ?>"  placeholder="Nombre Corto" autocomplete="off" type="text">
    </div>
  </div>
  <div class="form-group col-md-12">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
        <hr>
      </div>
  </div>
  <div class=" col-md-12">
    <label class="col-sm-2 control-label"><b>Aduana:</b> </label>
    <div class="form-group col-sm-3">

      <select  name="skAduana" class="form-control">
          <option value="">Seleccionar</option>
          <?php if ($data['aduanas']) {
                    foreach ($data['aduanas'] as $row) { ?>
                        <option <?php echo(isset($result['skAduana']) && $result['skAduana'] == $row['skAduana'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skAduana']; ?>"> <?php echo $row['sNombreCorto']." (".$row['skAduana'].")"; ?> </option>
                    <?php }
                }//ENDWHILE
          ?>
        </select>

    </div>
    <label class="col-sm-2 control-label"><b>Agente:</b> </label>
    <div class="form-group col-sm-3">

      <select  name="skEmpresaSocioAgente" class="form-control">
          <option value="">Seleccionar</option>
          <?php if ($data['agentes']) {
                    foreach ($data['agentes'] as $row) { ?>
                        <option <?php echo(isset($result['skEmpresaSocioAgente']) && $result['skEmpresaSocioAgente'] == $row['skEmpresaSocio'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skEmpresaSocio']; ?>"> <?php echo $row['sNombreCorto']." (".$row['Patente'].")"; ?> </option>
                    <?php }
                }//ENDWHILE
          ?>
        </select>

    </div>
  </div>

</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = empr.suem_form.validaciones;
    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
    });



</script>
