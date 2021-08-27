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
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>skTipoExpediente:</h4> 
                                <input id="skTipoExpediente" name="skTipoExpediente" placeholder="skTipoExpediente" type="text" class="form-control" autocomplete="off"   
                                value = "<?php echo isset($data['datos']['skTipoExpediente']) ? $data['datos']['skTipoExpediente'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>NOMBRE:</h4> 
                                <input id="sNombre" name="sNombre" placeholder="NOMBRE" type="text" class="form-control" autocomplete="off"   
                                value = "<?php echo isset($data['datos']['sNombre']) ? $data['datos']['sNombre'] : ''; ?>">
                            </div>
                        </div>

                    </div>

                    <div class="row row-lg">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>DESCRIPCIÓN:</h4>
                                <textarea id="sDescripcion" name="sDescripcion" placeholder="DESCRIPCIÓN" class="form-control" rows="3"><?php echo isset($data['datos']['sDescripcion']) ? $data['datos']['sDescripcion'] : ''; ?></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="panel panel-bordered panel-success panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">PEDIMENTO</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class=" form-group" >
                            <h5 class="text-center"><b class="red-600">*</b> PEDIMENTO</h5>
                            <div class="col-md-12" id="docu_OPERAT_PEDIME"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-8">
            <div class="panel panel-bordered panel-success panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">BILL OF LADING</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class=" form-group" >
                            <h5 class="text-center"><b class="red-600">*</b> BILL OF LADING</h5>
                            <div class="col-md-12" id="docu_OPERAT_BILLLA"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        
        <div class="col-md-12">
            <div class="panel panel-bordered panel-success panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">FOTOGRAFÍAS</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class=" form-group" >
                            <h5 class="text-center"><b class="red-600">*</b> FOTOGRAFÍAS</h5>
                            <div class="col-md-12" id="docu_OPERAT_FOTOGR"></div>
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

        /*$('#solicitud_pdf_multiple').core_docu_component({
            skTipoExpediente: 'OPERAT',
            skTipoDocumento: 'FOTOGR',
            name: 'docu_file',
            //skDocumento: '43853bc2-0620-11ec-a128-90b11c129156',
            //skDocumento: ['43853bc2-0620-11ec-a128-90b11c129156','4384b7a0-0620-11ec-a128-90b11c129156'],
            //caracteristicas: '[{"clave":"skTipoExpediente","valor":"OPERAT"},{"clave":"skTipoDocumento","valor":"FOTOGR"}]',
            //allowDelete: true,
            //readOnly: true,
            //forceSingleFile: true,
            deleteCallBack: function (e) {
                alert('CallBack: deleteCallBack');
            }
        });*/

        $('#docu_OPERAT_PEDIME').core_docu_component({
            skTipoExpediente: 'OPERAT',
            skTipoDocumento: 'PEDIME',
            skCodigo: 'MYUUID',
            name: 'docu_file_OPERAT_PEDIME',
            deleteCallBack: function (e) {
                
            }
        });

        $('#docu_OPERAT_BILLLA').core_docu_component({
            skTipoExpediente: 'OPERAT',
            skTipoDocumento: 'BILLLA',
            skCodigo: 'MYUUID',
            name: 'docu_file_OPERAT_BILLLA',
            deleteCallBack: function (e) {
                
            }
        });

        $('#docu_OPERAT_FOTOGR').core_docu_component({
            skTipoExpediente: 'OPERAT',
            skTipoDocumento: 'FOTOGR',
            skCodigo: 'MYUUID',
            name: 'docu_file_OPERAT_FOTOGR',
            deleteCallBack: function (e) {
                
            }
        });

    });

</script>