<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="skNotificacionMensaje" id="skNotificacionMensaje" value="<?php echo (isset($result['skNotificacionMensaje'])) ? $result['skNotificacionMensaje'] : ''; ?>">
    <div class="panel panel-bordered panel-info panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS NOTIFICACIONES</h3>
            </div>
            <div class="panel-body container-fluid">

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b><span style="color:red">* </span>Nombre:</b></label> 
        <div class="col-md-4">
            <div class="form-group">
                <input class="form-control" name="sNombre"
                       value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="Nombre"
                       autocomplete="off" type="text">
            </div>
            <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>

        <label class="col-md-2 control-label"><b><span style="color:red">* </span>Clave:</b> </label>
        <div class="col-md-4">
            <div class="form-group">
               <input class="form-control" name="sClaveNotificacion"
               value="<?php echo (isset($result['sClaveNotificacion'])) ? ($result['sClaveNotificacion']) : ''; ?>"
               placeholder="Clave Notificacion" autocomplete="off" type="text">
            </div>
            <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>
    </div>

     
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Comportamiento:</b> </label>
        <div class="form-group col-md-4">
            <select name="skComportamientoModulo" id="skComportamientoModulo" class="form-control">
                <option value=""></option>
                <?php
                if ($data['comportamientos']) {
                    foreach ($data['comportamientos'] as $row) {
                        ?>
                        <option <?php echo(isset($result['skComportamiento']) && $result['skComportamiento'] == $row['skComportamientoModulo'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skComportamientoModulo']; ?>"> <?php echo $row['sNombre'].' ('.$row['skComportamientoModulo'].')'; ?> </option>
                        <?php
                    }
                }//ENDWHILE
                ?>
            </select>
        </div>


    </div>

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b><span style="color:red">* </span>URL:</b> </label>

        <div class="col-md-4">
            <div class="form-group">
                <input class="form-control" name="sUrl"
                   value="<?php echo (isset($result['sUrl'])) ? ($result['sUrl']) : ''; ?>" placeholder="Url"
                   autocomplete="off" type="text">
            </div>
            <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>
        

    </div>

    <div class="col-md-12">

        <label class="col-md-2 control-label"><b>Icono:</b> </label>

        <div class="col-md-4">
            <div class="form-group">
                <input class="form-control" name="sIcono"
                   value="<?php echo (isset($result['sIcono'])) ? ($result['sIcono']) : ''; ?>" placeholder="Icono"
                   autocomplete="off" type="text">
            </div>
            <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>
        <label class="col-md-2 control-label"><b>Color:</b> </label>

        <div class="col-md-4">
            <div class="form-group">
                <input class="form-control" name="sColor"
                   value="<?php echo (isset($result['sColor'])) ? ($result['sColor']) : ''; ?>" placeholder="Color"
                   autocomplete="off" type="text">
           </div>
           <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>
    </div>

 
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b><span style="color:red">* </span>Mensaje notificación</b> </label>
        <div class="col-md-10">
            <div class="form-group">
                <textarea class="form-control" name="sMensaje"
                placeholder="Mensaje"><?php echo (isset($result['sMensaje'])) ? ($result['sMensaje']) : ''; ?></textarea>
            </div>
            <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>

    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>Enviar por correo</b></label>

            <div class="col-md-2">
                <div class="form-group checkbox-custom checkbox-primary">
                    <input id="iEnviarCorreo" value="1"
                           name="iEnviarCorreo" <?php echo (isset($result['iEnviarCorreo']) && !empty($result['iEnviarCorreo'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="iEnviarCorreo"></label>
                </div>
            </div>
        </div>
        
         
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>Notificación General</b></label>

            <div class="col-md-2">
                <div class="form-group checkbox-custom checkbox-primary">
                    <input id="iNotificacionGeneral" value="1"
                           name="iNotificacionGeneral" <?php echo (isset($result['iNotificacionGeneral']) && !empty($result['iNotificacionGeneral'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="iNotificacionGeneral"></label>
                </div>
            </div>
            <div class="col-md-12"><span class="help-block">Se envia la notificación a todos en un solo correo.</span></div>
        </div>
        
        
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>Enviar notificación al instante</b></label>

            <div class="col-md-2">
                <div class="form-group checkbox-custom checkbox-primary">
                    <input id="iEnviarInstantaneo" value="1"
                           name="iEnviarInstantaneo" <?php echo (isset($result['iEnviarInstantaneo']) && !empty($result['iEnviarInstantaneo'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="iEnviarInstantaneo"></label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 clearfix"><hr></div>
    
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Asunto:</b> </label>
        <div class="col-md-6">
            <div class="form-group">
                <input class="form-control" name="sAsunto" id="sAsunto" value="<?php echo (isset($result['sAsunto'])) ? ($result['sAsunto']) : ''; ?>" placeholder="Asunto" autocomplete="off" type="text">
            </div>
            <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>
    </div>

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Mensaje Correo:</b> </label>
        <div class="col-md-8">
            <div class="form-group">
                <textarea class="core-summernote" data-plugin="summernote" id="sMensajeCorreo" name="sMensajeCorreo" >
                    <?php echo (isset($result['sMensajeCorreo'])) ? ($result['sMensajeCorreo']) : ''; ?>
                </textarea>
            </div>
            <span class="help-block">Se permiten [variables].</span>
            <br>
        </div>
    </div>

    <div class="col-md-12 clearfix">
        <hr>
    </div>
</div>

</div>

    <!-- SE AGREGAN VALORES AL GRUPO DE USUARIOS (TABLA MULTIPLE) !-->

    <!--<div class="form-group col-md-12 ">

        <div class="well tableMultiple1-panelEdit col-md-12">
            <p class="tableMultiple1-editAndo text-center"></p>

            <div class="form-group col-md-12">

                <label class="col-md-2 control-label"><b> Variable</b></label>

                <div class="col-md-4">
                    <input data-plugin="inputText" inputText class="form-control" id="sVariable" name="sVariable"
                           placeholder="Variable" autocomplete="off" type="text">
                </div>

                <label class="col-md-2 control-label"><b> Valor</b></label>

                <div class="col-md-4">
                    <input data-plugin="inputText" inputText class="form-control" id="sValor" name="sValor"
                           placeholder="Valor" autocomplete="off" type="text">
                </div>


                <div class="col-md-2">
                    <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();"
                            class="btn btn-primary pull-right">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="example">
                <div id="toolbar">
                    <button id="tableMultiple1-removeRowTableMultiple"
                            class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                        <i class="fa fa-trash"></i> Borrar
                    </button>
                </div>
                <table id="tableMultiple1" data-toggle="table" data-toolbar="#toolbar"
                       data-query-params="queryParams" data-mobile-responsive="true"
                       data-height="400" data-pagination="false" data-icon-size="outline"
                       data-search="true" data-unique-id="id">
                </table>
            </div>
        </div>

    </div>-->

</form>
<script
    src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    /*function tableMultiple1_addNewRow(index) {

        var sValor = $("#sValor");
        var sVariable = $("#sVariable");

        if (!sValor.val().length > 0) {
            toastr.warning("Ingrese un valor.");
            return;
        }
        if (!sVariable.val().length > 0) {
            toastr.warning("Ingrese un valor.");
            return;
        }

        var params = {
            "sValor": {"id": "sValor", "type": "val"},
            "sVariable": {"id": "sVariable", "type": "val"}
        };
        core.tableMultipleAddRow($('#tableMultiple1'), params, 'skNotificacionMensajeVariable', index);

    }

    var params = {
        datos: {
            columns: [
                {
                    field: 'state',
                    checkbox: true,
                    align: 'center',
                    valign: 'middle'
                }, {
                    field: 'sVariable',
                    title: 'Variable'
                }, {
                    field: 'sValor',
                    title: 'Valor'
                }, {
                    field: 'id',
                    title: 'ID'
                }
            ],
            data: <?php echo isset($data["variablesMensajes"]) ? json_encode($data["variablesMensajes"]) : json_encode([]); ?>
        }
    };*/

    core.formValidaciones.fields = conf.meno_form.validaciones;

    $(document).ready(function () {

        $('#core-guardar').formValidation(core.formValidaciones);

       // core.tableMultiple($("#tableMultiple1"), params);

        $('.select2').select2();

        core.summernote();

        core.formChage();

        $("#skEstatus").select2({placeholder: "Seleccionar Estatus"});
        $("#skTipoNotificacion").select2({placeholder: "Seleccionar Tipo de Notificacion"});
        $("#skComportamientoModulo").select2({placeholder: "Seleccionar Comportamiento"});
    });

</script>
