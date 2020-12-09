<?php
    if(isset($data['datos'])){
        $result = $data['datos'];
    }
?>
    <form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
        <div class="panel panel-bordered panel-info panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS VARIABLE</h3>
            </div>
            <div class="panel-body container-fluid">
            <div class="row row-lg">
                <input type="hidden" name="skVariableVieja"  id="skVariableVieja" value="<?php echo (isset($result['skVariable'])) ? $result['skVariable'] : '' ; ?>">
                <div class="form-group col-md-12">
                    <label class="col-md-2 control-label"><b>C&oacute;digo:</b> </label>
                    <div class="col-md-3">
                         <input class="form-control" maxlength="6" <?php if(isset($result['skVariable'])){ ?>disabled="disabled"<?php }//ENDIF ?>  name="skVariable" value="<?php echo (isset($result['skVariable'])) ? ($result['skVariable']) : '' ; ?>" placeholder="C&oacute;digo" autocomplete="off" type="text">
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                      <hr>
                    </div>
                </div>

                <!-- TIPO DE VARIABLE -->
                <div class=" col-md-12">
                    <label class="col-sm-2 control-label"><b>Tipo Variable</b> </label>
                    <div class="form-group col-sm-3">
                        <!--
                        <div class="btn-group bootstrap-select">
                        data-plugin="selectpicker"
                        </div>-->
                        <select  data-plugin="select2" name="skVariableTipo" id="skVariableTipo" class="form-control">
                            <option></option>
                            <?php if ($data['variableTipo']) {
                                      foreach ($data['variableTipo'] as $row) { ?>
                                            <option <?php echo(isset($result['skVariableTipo']) && $result['skVariableTipo'] == $row['skVariableTipo'] ? 'selected="selected"' : '') ?>
                                              value="<?php echo $row['skVariableTipo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                      <?php }
                                  }//ENDWHILE
                            ?>
                        </select>
                    </div>
                </div>

                <!-- NOMBRE -->
                <div class="col-md-12">
                    <label class="col-md-2 control-label"><b>Nombre</b> </label>
                    <div class="form-group col-md-8">
                        <input class="form-control" name="sNombre"
                               value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>"
                               placeholder="Nombre" autocomplete="off" type="text">
                    </div>
                </div>

                <!-- VALOR -->
                <div class="col-md-12">
                    <label class="col-md-2 control-label"><b>Valor</b> </label>
                    <div class="form-group col-md-8">
                        <textarea class="form-control" rows="5" id="sValor" name="sValor" placeholder="Valor"><?php echo isset($result['sValor']) ?  nl2br($result['sValor']) : ''; ?></textarea>
                    </div>
                </div>

                <!-- DESCRIPCION -->
                <div class="col-md-12">
                    <label class="col-md-2 control-label"><b>Descripci&oacute;n</b> </label>
                    <div class="form-group col-md-8">
                      <textarea class="form-control" rows="5" id="sDescripcion" name="sDescripcion" placeholder="Descripción"><?php echo isset($result['sDescripcion']) ?  nl2br($result['sDescripcion']) : ''; ?></textarea>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                      <hr>
                    </div>
                </div>

                <!-- PROYECTOS -->
                <div class="col-md-12">
                    <label class="col-md-2 control-label"><b>Proyectos:</b> </label>
                    <div class="form-group col-md-8">
                      <select id="sProyecto" name="sProyecto[]"
                         class="form-control select2 multiple"  autocomplete="off" multiple="multiple" data-plugin="select2">
                            <?php
                            if(isset($data['moduloProyecto']) && !empty($data['moduloProyecto'])){
                                foreach ($data['moduloProyecto'] AS $row) {
                                ?>
                                <option selected value="<?php echo $row['sProyecto']; ?>"><?php echo $row['sProyecto']; ?></option>
                                <?php
                                }
                            }//ENDFOREACH
                            ?>
                        </select>
                    </div>
                </div>

                <!-- MODULOS -->
                <div class="col-md-12">
                    <label class="col-md-2 control-label"><b>Módulos:</b> </label>
                    <div class="form-group col-md-8">
                      <select id="skModulo" name="skModulo[]" class="form-control" multiple="multiple"  data-plugin="select2">
                           <?php
                                if(isset($data['moduloVariables']) && !empty($data['moduloVariables'])){
                                    foreach ($data['moduloVariables'] as $row ) {
                                ?>
                                        <option value="<?php echo $row['skModulo']; ?>" 
                                        <?php 
                                            echo 'selected';        
                                        ?> >
                                        <?php echo $row['modulo'] ?>
                                        </option>                                        
                                <?php
                                    }
                                }
                            ?>
                        </select>
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
        $("#skVariableTipo").select2({placeholder:"Tipo Variable"});
        core.autocomplete2('#skModulo', 'getModulos', window.location.href, 'Módulos');
        
        $('.multiple').tagsinput({
            trimValue: true,
            freeInput: true,
            tagClass: 'label label-danger'
          });
    });
    
</script>
