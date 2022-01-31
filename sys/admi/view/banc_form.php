<?php
    if(isset($data['datos'])){
        $result = $data['datos'];
    }
?>
<div class="row">
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    
    <div class="col-md-12">
        <div class="panel panel-bordered panel-danger panel-line animated slideInLeft">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS GENERALES</h3>
            </div>
            <div class="panel-body container-fluid same-heigth">
                <div class="col-md-12 same-heigth">
                    
                <div class="row row-lg">    
                    <input id="skBanco" name="skBanco" type="hidden" class="form-control" autocomplete="off" placeholder="skBanco" value="<?php echo isset($result['skBanco']) ? $result['skBanco'] : '' ?>">
                    
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> BANCO:</h4>
                            <input class="form-control" id="sNombre" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="BANCO" autocomplete="off" type="text">
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> NOMBRE CORTO:</h4>
                            <input class="form-control" id="sNombreCorto" name="sNombreCorto" value="<?php echo (isset($result['sNombreCorto'])) ? ($result['sNombreCorto']) : ''; ?>" placeholder="NOMBRE CORTO" autocomplete="off" type="text">
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> RFC:</h4>
                            <input class="form-control" id="sRFC" name="sRFC" value="<?php echo (isset($result['sRFC'])) ? ($result['sRFC']) : ''; ?>" placeholder="RFC" autocomplete="off" type="text">
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-12 clearfix"></div>
                    
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <h4 class="example-title">OBSERVACIONES:</h4>
                            <textarea class="form-control" rows="5" id="sObservaciones" name="sObservaciones" placeholder="OBSERVACIONES"><?php echo (isset($result['sObservaciones']) && !empty($result['sObservaciones'])) ? $result['sObservaciones'] : ''; ?></textarea>
                        </div>
                    </div>   
                </div>

                </div>
            </div>
        </div>
    </div>
    
</form>
</div>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;
    
    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);
    
    });
</script>