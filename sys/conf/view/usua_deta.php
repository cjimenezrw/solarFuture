<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>


<style>
    .detail{
        width: 25%;
        border: none;
    }
    th {

    }

</style>
<div class="container">





    <div class="row">



        <table class=" table-condensed"style="width:100%;" >

            <tbody >
                <tr>
                    <th><b>Usuario</b></th>
                    <td colspan="3"><?php echo (isset($result['sUsuario'])) ? $result['sUsuario'] : ''; ?></td>
                </tr>



                <tr>
                    <td class="detail" colspan="4"><hr></td>
                </tr>


                <tr>
                    <th class="detail"><b>Estatus</b></th>
                    <td class="detail" ><?php echo (isset($result['skEstatus'])) ? $result['skEstatus'] : ''; ?></td>

                    <th class="detail"><b>Fecha de Creación</b></th>
                    <td class="detail"><?php echo ($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : '') ?></td>
                </tr>
                <tr>

                    <th class="detail"><b>Nombre</b></th>
                    <td class="detail"><?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?></td>

                    <th class="detail"><b>Correo Electrónico</b></th>
                    <td class="detail"><?php echo (isset($result['sCorreo'])) ? $result['sCorreo'] : ''; ?></td>
                </tr>
                <tr>
                    <th class="detail"><b>Apellido Paterno</b></th>
                    <td class="detail"><?php echo (isset($result['sApellidoPaterno'])) ? $result['sApellidoPaterno'] : ''; ?></td>

                    <th class="detail"><b>Apellido Materno</b></th>
                    <td class="detail"><?php echo (isset($result['sApellidoMaterno'])) ? $result['sApellidoMaterno'] : ''; ?></td>
                </tr>
            </tbody>

        </table>



        <!--
            <div class="col-md-12">
            <label class="col-md-3"><b>Usuario</b> </label>
            <div class="col-md-3">
              <label><?php echo (isset($result['sUsuario'])) ? $result['sUsuario'] : ''; ?></label>
            </div>
          </div>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            <label class="col-md-3"><b>Estatus</b> </label>
            <div class="col-md-3">
              <label><?php echo (isset($result['skEstatus'])) ? $result['skEstatus'] : ''; ?></label>
            </div>
            <label class="col-md-3"><b>Fecha de Creaci&oacute;n</b> </label>
            <div class="col-md-3">
              <label><?php echo ($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : '') ?></label>
            </div>
          </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            <label class="col-md-3"><b>Nombre</b> </label>
            <div class="col-md-3">
              <label><?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?></label>
            </div>
            <label class="col-md-3"><b>Correo Electr&oacute;nico</b> </label>
            <div class="col-md-3">
              <label><?php echo (isset($result['sCorreo'])) ? $result['sCorreo'] : ''; ?></label>
            </div>
          </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
            <label class="col-md-3"><b>Apellido Paterno</b> </label>
            <div class="col-md-3">
              <label><?php echo (isset($result['sApellidoPaterno'])) ? $result['sApellidoPaterno'] : ''; ?></label>
            </div>
            <label class="col-md-3"><b>Apellido Materno</b> </label>
            <div class="col-md-3">
              <label><?php echo (isset($result['sApellidoMaterno'])) ? $result['sApellidoMaterno'] : ''; ?></label>
            </div>
          </div>-->

    </div>


</div>






<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
