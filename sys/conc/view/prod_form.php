<?php
    if (isset($data['datos'])) {
        $result = $data['datos'];
    } 
    //exit('<pre>'.print_r($result,1).'</pre>');
    //exit('<pre>'.print_r(SYS_URL.'files/conc/prod-form/'.$result['sImagen'],1).'</pre>');
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos Generales</h3>
        </div>
        <div class="panel-body container-fluid">
                  <div class="row row-lg col-lg-12">
                              <div class="col-md-6 col-lg-6">
                                  <div class="form-group">
                                      <h4 class="example-title"><span class="required text-danger">*</span> Nombre</h4>
                                      <input class="form-control" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>" placeholder="Nombre del Concepto" autocomplete="off" type="text" >
                                  </div>
                              </div>
                    </div>
                    <div class="row row-lg col-lg-12">
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title"><span class="required text-danger">*</span> Imagen</h4> 
                                <input type="hidden" name="sImagenGuardada" id="sImagenGuardada" value="<?php echo (isset($result['sImagen'])) ? $result['sImagen'] : ''; ?>">
                                <input class="dropify" type="file" name="sImagen" id="input-file-max-fs" data-plugin="dropify"
                                    data-allowed-file-extensions="pdf png jpg" data-height="325" 
                                <?php
                                    if(isset($result['sImagen']) && !empty($result['sImagen'])){
                                        echo 'data-default-file="'.SYS_URL.'files/conc/prod-form/'.$result['sImagen'].'"';
                                    }
                                ?> />
                            </div>
                        </div>
                                
                  
                  <div class="row row-lg col-lg-12">
                      <hr>
                  </div>

                 <div class="row row-lg col-lg-12">
                     
                     <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                            <h4 class="example-title"><span class="required text-danger">*</span> Descripción Hoja 1</h4>
                            <textarea class="form-control" id="sDescripcionHoja1" name="sDescripcionHoja1" placeholder="DESCRIPCIÓN HOJA 1"><?php echo (!empty($result['sDescripcionHoja1'])) ? ($result['sDescripcionHoja1']) : ''; ?></textarea>
                         </div>
                     </div>
                </div>

                <div class="row row-lg col-lg-12">
                      <hr>
                  </div>

                 <div class="row row-lg col-lg-12">
                     
                     <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                            <h4 class="example-title"><span class="required text-danger">*</span> Descripción Hoja 2</h4>
                            <textarea class="form-control" id="sDescripcionHoja2" name="sDescripcionHoja2" placeholder="DESCRIPCIÓN HOJA 2"><?php echo (!empty($result['sDescripcionHoja2'])) ? ($result['sDescripcionHoja2']) : ''; ?></textarea>
                         </div>
                     </div>
                </div>

                <div class="row row-lg col-lg-12">
                      <hr>
                  </div>

                 <div class="row row-lg col-lg-12">
                     
                     <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                            <h4 class="example-title"><span class="required text-danger">*</span> Descripción Garantía</h4>
                            <textarea class="form-control" id="sDescripcionGarantia" name="sDescripcionGarantia" placeholder="DESCRIPCIÓN GARANTÍA"><?php echo (!empty($result['sDescripcionGarantia'])) ? ($result['sDescripcionGarantia']) : ''; ?></textarea>
                         </div>
                     </div>
                </div>

            </div>
     

</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = conc.prod_form.validaciones;
    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);

        CKEDITOR.replace('sDescripcionHoja1', {
            width: '100%',
            height: 600,
            uploadUrl: window.location.href
        });

        CKEDITOR.replace('sDescripcionHoja2', {
            width: '100%',
            height: 600,
            uploadUrl: window.location.href
        });

        CKEDITOR.replace('sDescripcionGarantia', {
            width: '100%',
            height: 600,
            uploadUrl: window.location.href
        });

        $('.dropify').dropify();

    });

</script>