<?php
//exit('<pre>'.print_r($data,1).'</pre>');
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered panel-primary panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">DATOS GENERALES</h3>
                </div>
                <?php
                    if(!empty($data['datos']['sMAC'])){
                ?>
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <b class="red-600 font-size-24">MAC: <?php echo (!empty($data['datos']['sMAC'])) ? $data['datos']['sMAC'] : '-'; ?></b>
                </div>
                <?php
                    }//ENDIF
                ?>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>MAC:</h4>
                                <input id="sMAC" name="sMAC" placeholder="MAC" type="text" class="form-control" autocomplete="off"   
                                    value = "<?php echo isset($data['datos']['sMAC']) ? $data['datos']['sMAC'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>NOMBRE:</h4>
                                <input id="sNombre" name="sNombre" placeholder="NOMBRE" type="text" class="form-control" autocomplete="off"   
                                    value = "<?php echo isset($data['datos']['sNombre']) ? $data['datos']['sNombre'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>TORRE:</h4>
                                <select id="skTorre" name="skTorre" class="form-control" data-plugin="select2" select2Simple>
                                    <option value="">- SELECCIONAR -</option>
                                    <?php
                                        if (!empty($data['_get_torres'])) {
                                            foreach ($data['_get_torres'] as $row) {
                                    ?>
                                        <option <?php echo(isset($data['datos']['skTorre']) && $data['datos']['skTorre'] == $row['skTorre'] ? 'selected="selected"' : ''); ?>
                                        value="<?php echo $row['skTorre']; ?>"> <?php echo $row['sNombre'].' ('.$row['sMAC'].')'; ?> </option>
                                    <?php
                                            }//ENDWHILE
                                        }//ENDIF
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">OBSERVACIONES:</h4>
                                <textarea id="sObservaciones" name="sObservaciones" placeholder="OBSERVACIONES" class="form-control" rows="3"><?php echo isset($data['datos']['sObservaciones']) ? $data['datos']['sObservaciones'] : ''; ?></textarea>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validaciones;
    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);

        $("#skTorre").select2({placeholder: "TORRE", allowClear: true });

    });
</script>