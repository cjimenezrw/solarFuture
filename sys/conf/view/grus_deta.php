<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <label class="col-md-3"><b>Nombre</b> </label>
            <div class="col-md-3">
                <label><?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?></label>
            </div>

            <label class="col-md-3"><b>Fecha de Creaci&oacute;n</b> </label>
            <div class="col-md-3">
                <label><?php echo($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : '') ?></label>
            </div>
        </div>

        <div class="col-md-12">
            <label class="col-md-3"><b>Responsable</b> </label>
            <div class="col-md-3">
                <label><?php echo (isset($result['responsable'])) ? $result['responsable'] : ''; ?></label>
            </div>

            <label class="col-md-3"><b>Estatus</b> </label>
            <div class="col-md-3">
                <label><?php echo (isset($result['estatus'])) ? $result['estatus'] : ''; ?></label>
            </div>
        </div>

        <div class="col-md-12 clearfix">
            <hr>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="table-responsive" style="height:400px;overflow-y:visible;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Usuarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($data['gruposUsuarios_usuarios']){
                                while($row = Conn::fetch_assoc($data['gruposUsuarios_usuarios'])){
                                    utf8($row);
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['usuario']; ?>
                            </td>
                        </tr>
                        <?php
                                }//ENDWHILE
                            }//ENDIF
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

    });
</script>
