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
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">ESTATUS:</h4>
                                <label><i class="fa <?php echo (!empty($data['datos']['estatusIcono']) ? $data['datos']['estatusIcono'] : '-'); ?> <?php echo (!empty($data['datos']['estatusColor']) ? $data['datos']['estatusColor'] : ''); ?>" aria-hidden="true"> <?php echo (!empty($data['datos']['estatus']) ? $data['datos']['estatus'] : ''); ?></i></label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">USUARIO CREACIÓN:</h4>
                                <span><?php echo (!empty($data['datos']['usuarioCreacion']) ? $data['datos']['usuarioCreacion'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">FECHA CREACIÓN:</h4>
                                <span><?php echo (!empty($data['datos']['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($data['datos']['dFechaCreacion'])) : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"><hr></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">CATEGORÍA:</h4>
                                <span><?php echo (!empty($data['datos']['sNombreCategoria']) ? $data['datos']['sNombreCategoria'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">FECHA DE CITA:</h4>
                                <span><?php echo (!empty($data['datos']['dFechaCita']) ? date('d/m/Y', strtotime($data['datos']['dFechaCita'])) : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">HORA:</h4>
                                <span><?php echo (!empty($data['datos']['tHoraInicio']) ? $data['datos']['tHoraInicio'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"><hr></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">NOMBRE:</h4>
                                <span><?php echo (!empty($data['datos']['sNombre']) ? $data['datos']['sNombre'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">TELÉFONO:</h4>
                                <span><?php echo (!empty($data['datos']['sTelefono']) ? $data['datos']['sTelefono'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">CORREO:</h4>
                                <span><?php echo (!empty($data['datos']['sCorreo']) ? $data['datos']['sCorreo'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">ESTADO:</h4>
                                <span><?php echo (!empty($data['datos']['estado']) ? $data['datos']['estado'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">MUNICIPIO:</h4>
                                <span><?php echo (!empty($data['datos']['municipio']) ? $data['datos']['municipio'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">DOMICILIO:</h4>
                                <span><?php echo (!empty($data['datos']['sDomicilio']) ? $data['datos']['sDomicilio'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">OBSERVACIONES:</h4>
                                <span><?php echo (!empty($data['datos']['sObservaciones']) ? $data['datos']['sObservaciones'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"><hr></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">USUARIO CONFIRMACIÓN:</h4>
                                <span><?php echo (!empty($data['datos']['usuarioConfirmacion']) ? $data['datos']['usuarioConfirmacion'] : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">FECHA CONFIRMACIÓN:</h4>
                                <span><?php echo (!empty($data['datos']['dFechaConfirmacion']) ? date('d/m/Y H:i:s', strtotime($data['datos']['dFechaConfirmacion'])) : '-'); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">INSTRUCCIONES DE SERVICIO:</h4>
                                <span><?php echo (!empty($data['datos']['sInstruccionesServicio']) ? $data['datos']['sInstruccionesServicio'] : '-'); ?></span>
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
    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    });
</script>