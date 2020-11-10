<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>


<div class="container">
    <div class="col-md-12">
        <div class="form-group col-md-12">
            <label class="col-md-2 control-label"><b>Codigo:</b> </label>

            <div class="col-md-4">
                <label
                    class="control-label"><?php echo (isset($result['skAplicacion'])) ? ($result['skAplicacion']) : ''; ?></label>
            </div>
            <label class="col-md-2 control-label"><b>Nombre:</b> </label>

            <div class="col-md-4">
                <label
                    class="control-label"><?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?></label>
            </div>

        </div>
        <div class="form-group col-md-12">
            <label class="col-md-2 control-label"><b>Estatus</b> </label>

            <div class="col-md-4">
                <label
                    class="control-label"><?php echo (isset($result['sEstatus'])) ? $result['sEstatus'] : ''; ?></label>
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
            <div class="col-md-2">
                <label class="col-md-2 control-label"><b>Perfiles</b> </label>
            </div>
            <div class="col-md-8">

                <?php if ($data['perfiles']) { ?>
                    <ul class="list-group list-group-bordered">
                        <?php while ($row = Conn::fetch_assoc($data['perfiles'])) { ?>
                            <li class="list-group-item"><?php echo $row['sNombre']; ?></li>

                        <?php } ?>
                    </ul>
                <?php }//ENDWHILE
                ?>

            </div>
        </div>


    </div>
</div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
