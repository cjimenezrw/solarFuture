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
                        <h4 class="example-title"><b><span style="color:red;">* </span>NOMBRE CONTACTO:</b></h4>
                        <input class="form-control" autocomplete="off" id="sNombreContacto" name="sNombreContacto" type="text" placeholder="NOMBRE CONTACTO" 
                        value = "<?php echo isset($result['sNombreContacto']) ? $result['sNombreContacto'] : ''; ?>">
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b>EMPRESA:</b></h4>
                        <input class="form-control" autocomplete="off" id="sEmpresa" name="sEmpresa" type="text" placeholder="EMPRESA" 
                        value = "<?php echo isset($result['sEmpresa']) ? $result['sEmpresa'] : ''; ?>">
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-6">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b><span style="color:red;">* </span>CORREO:</b></h4>
                        <input class="form-control" autocomplete="off" id="sCorreo" name="sCorreo" type="text" placeholder="CORREO" 
                        value = "<?php echo isset($result['sCorreo']) ? $result['sCorreo'] : ''; ?>">
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b><span style="color:red;">* </span>TELÉFONO:</b></h4>
                        <input class="form-control" autocomplete="off" id="sTelefono" name="sTelefono" type="text" placeholder="TELÉFONO" 
                        value = "<?php echo isset($result['sTelefono']) ? $result['sTelefono'] : ''; ?>">
                    </div>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="form-group margin-bottom-60">
                        <h4 class="example-title"><b>COMENTARIOS:</b></h4>
                        <textarea rows="5" class="form-control" id="sComentarios" name="sComentarios" autocomplete="off"
                        placeholder="COMENTARIOS"><?php echo isset($result['sComentarios']) ? html_entity_decode($result['sComentarios']) : ''; ?></textarea>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
    
</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;

    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
        $(".input-datepicker").datepicker({format: "dd/mm/yyyy"});
         core.autocomplete2('#skExpedienteEmpleado', 'getUsuarios', window.location.href, 'NOMBRE EMPLEADO');
         $("#skTipoIncapacidad").select2({'placeholder':'TIPO DE INCAPACIDAD'});
        $('#mowi').iziModal('setBackground', '#f1f4f5');

        // DOCUMENTO DE DIGITALIZACIÓN DOCUMENTO INCAPACIDAD (PDF) //
        rehu.inca_form.skDocumentoIncapacidadFile = new core.digi.inputShow({ 
            sDomSelector: '#skDocumentoIncapacidadFile', 
            skDocumento: '<?php echo!empty($result['skDocumentoIncapacidad']) ? $result['skDocumentoIncapacidad'] : ''; ?>', 
            allowedFiles: 'pdf', 
            inputName: 'skDocumentoIncapacidadFile', 
            maxFilesize: 5, 
            deleteCallback: function () { 
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        axn: 'eliminar_documento_incapacidad'
                    },
                    cache: false,
                    processData: true,
                    beforeSend: function () {},

                    success: function (response) {
                        if (response.success == true) {
                            swal.close();
                            toastr.success("Enviado Correctamente", 'Enviado');
                            core.dataTable.sendFilters(true);
                            return true;
                        } else {
                            toastr.clear();
                            swal("¡Error!", response.message, "error");
                            core.dataTable.sendFilters(true);
                        }
                        core.dataTable.sendFilters(true);
                    }
                });
                return true; 
            }
        });

        rehu.inca_form.skDocumentoIncapacidadFile.run(); 
    });
</script>

