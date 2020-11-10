<?php
    $result = array();
    if(isset($data['datos'])){
        $result= $data['datos'];
        utf8($result);
    }
?>


<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">



    <div class="form-group">
    <div class="col-md-12">
    <label class="col-md-3"><b>Nombre</b> </label>
    <div class="col-md-3">
      <label><?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : '' ; ?></label>
    </div>
    <label class="col-md-3"><b>Estatus</b> </label>
    <div class="col-md-3">
      <label><?php echo (isset($result['sEstatus'])) ? $result['sEstatus'] : '' ; ?></label>
    </div>
  </div>
</div>
  <div class="col-md-12">
    <hr>
  </div>
  <div class="form-group">
    <div class="col-md-12">
    <label class="col-md-3"><b>Usuario Creaci&oacute;n</b> </label>
    <div class="col-md-3">
      <label><?php echo (isset($result['sUsuarioCreador'])) ? $result['sUsuarioCreador'] : ' ' ; ?></label>
    </div>
    <label class="col-md-3"><b>Usuario Modificaci&oacute;n</b> </label>
    <div class="col-md-3">
      <label><?php echo (isset($result['sUsuarioModificador'])) ? $result['sUsuarioModificador'] : ' ' ; ?></label>
    </div>
  </div>
  </div>

  <div class="form-group">
    <div class="col-md-12">
    <label class="col-md-3"><b>Fecha de Creaci&oacute;n</b> </label>
    <div class="col-md-3">
      <label><?php echo ($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])): '') ?></label>
    </div>
  </div>
  </div>





</form>



<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
