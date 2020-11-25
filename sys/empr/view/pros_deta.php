<?php
    if (isset($data['datos'])) {
        $result = $data['datos'];
    }
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="panel panel-bordered panel-success panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS GENERALES</h3>
        </div>
        <?php if(isset($_GET['p1'])){ ?>
            <div class="alert dark alert-primary alert-dismissible text-left" role="alert">
                <b style="font-size:16px;"><i class="fas fa-info-circle"></i> FOLIO: <?php echo isset($result['iFolioProspecto']) ? $result['iFolioProspecto'] : ''; ?></b>
            </div>
        <?php } ?>
        <div class="panel-body container-fluid">
            <div class="row row-lg">

                <div class="col-md-6 col-lg-6">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b>NOMBRE CONTACTO:</b></h4>
                        <label><?php echo isset($result['sNombreContacto']) ? $result['sNombreContacto'] : ''; ?></label>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b>EMPRESA:</b></h4>
                        <label><?php echo isset($result['sEmpresa']) ? $result['sEmpresa'] : ''; ?></label>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-6">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b>CORREO:</b></h4>
                        <label><?php echo isset($result['sCorreo']) ? $result['sCorreo'] : ''; ?></label>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b>TELÉFONO:</b></h4>
                        <label><?php echo isset($result['sTelefono']) ? $result['sTelefono'] : ''; ?></label>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b>COMENTARIOS:</b></h4>
                        <label><?php echo isset($result['sComentarios']) ? nl2br($result['sComentarios']) : ''; ?></label>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
    
</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    });
</script>

