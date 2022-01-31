<?php
    if(isset($data['datos'])){
        $result = $data['datos'];
    }
?>
<div class="row">
     
    <div class="col-md-12">
        <div class="panel panel-bordered panel-danger panel-line animated slideInLeft">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS GENERALES</h3>
            </div>
            <div class="panel-body container-fluid same-heigth">
                <div class="col-md-12 same-heigth">
                    
                    <div class="row row-lg">    
                        
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">BANCO:</h4>
                                <label><?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?></label>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">NOMBRE CORTO:</h4>
                                <label><?php echo (isset($result['sNombreCorto'])) ? ($result['sNombreCorto']) : ''; ?></label>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">RFC:</h4>
                                <label><?php echo (isset($result['sRFC'])) ? ($result['sRFC']) : ''; ?></label>
                            </div>
                        </div>
                        
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <h4 class="example-title">OBSERVACIONES:</h4>
                                <label><?php echo (isset($result['sObservaciones']) && !empty($result['sObservaciones'])) ? nl2br($result['sObservaciones']) : ''; ?></label>
                            </div>
                        </div>  

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">Usuario de Creación:</h4>
                                <label><?php echo (isset($result['usuarioCreacion'])) ? ($result['usuarioCreacion']) : ''; ?></label>
                            </div>
                        </div> 
                        <br>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">Fecha de Creación:</h4>
                                 <label><?php echo (!empty($result['dFechaCreacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : ''; ?></label>
                            </div>
                        </div> 
                        <div class="col-md-12 col-lg-12 clearfix"></div>

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">Usuario de Modificación:</h4>
                                <label><?php echo (isset($result['usuarioModificacion'])) ? ($result['usuarioModificacion']) : ''; ?></label>
                            </div>
                        </div> 

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">Fecha de Modificación:</h4>
                                <label><?php echo (!empty($result['dFechaModificacion'])) ? date('d/m/Y  H:i:s', strtotime($result['dFechaModificacion'])) : ''; ?></label>
                            </div>
                        </div>

                    </div> 
                </div>
            </div>
        </div>
    </div>
    
 </div>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
     
    $(document).ready(function () {
        
     
    });
</script>