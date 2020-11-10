<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="skNotificacionMensaje" id="skNotificacionMensaje"
           value="<?php echo (isset($result['skNotificacionMensaje'])) ? $result['skNotificacionMensaje'] : ''; ?>">

    <div class="col-md-12">

        <label class="col-md-2 control-label"><b>Nombre:</b> </label>

        <div class="form-group col-md-4">
            <input class="form-control" name="sNombre"
                   value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="Nombre"
                   autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Clave:</b> </label>

        <div class="form-group col-md-4">
            <input class="form-control" name="sClaveNotificacion"
                   value="<?php echo (isset($result['sClaveNotificacion'])) ? ($result['sClaveNotificacion']) : ''; ?>"
                   placeholder="Clave Notificacion" autocomplete="off" type="text">
        </div>

    </div>

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Estatus:</b> </label>

        <div class="form-group col-md-4">
            <select name="skEstatus" class="form-control">
                <option value="">Seleccionar</option>
                <?php
                if ($data['estatus']) {
                    foreach ($data['estatus'] as $row) {
                        ?>
                        <option <?php echo(isset($result['skEstatus']) && $result['skEstatus'] == $row['skEstatus'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skEstatus']; ?>"> <?php echo $row['sNombre']; ?> </option>
                        <?php
                    }
                }//ENDWHILE
                ?>
            </select>
        </div>

        <label class="col-md-2 control-label"><b>Tipo de Notificación:</b> </label>

        <div class="form-group col-md-4">
            <select name="skTipoNotificacion" class="form-control">
                <option value="">Seleccionar</option>
                <?php
                if ($data['tiposNotificaciones']) {
                    foreach ($data['tiposNotificaciones'] as $row) {
                        ?>
                        <option <?php echo(isset($result['skTipoNotificacion']) && $result['skTipoNotificacion'] == $row['skTipoNotificacion'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skTipoNotificacion']; ?>"> <?php echo $row['sNombre']; ?> </option>
                        <?php
                    }
                }//ENDWHILE
                ?>
            </select>
        </div>

    </div>
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Comportamiento:</b> </label>

        <div class="form-group col-md-4">
            <select name="skComportamientoModulo" class="form-control">
                <?php
                if ($data['comportamientos']) {
                    foreach ($data['comportamientos'] as $row) {
                        ?>
                        <option <?php echo(isset($result['skComportamientoModulo']) && $result['skComportamientoModulo'] == $row['skComportamientoModulo'] ? 'selected="selected"' : '') ?>
                            value="<?php echo $row['skComportamientoModulo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                        <?php
                    }
                }//ENDWHILE
                ?>
            </select>
        </div>


    </div>

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>URL:</b> </label>

        <div class="form-group col-md-4">
            <input class="form-control" name="sUrl"
                   value="<?php echo (isset($result['sUrl'])) ? ($result['sUrl']) : ''; ?>" placeholder="Url"
                   autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Imagen:</b> </label>

        <div class="form-group col-md-4">
            <input class="form-control" name="sImagen"
                   value="<?php echo (isset($result['sImagen'])) ? ($result['sImagen']) : ''; ?>" placeholder="Url"
                   autocomplete="off" type="text">
        </div>

    </div>

    <div class="col-md-12">

        <label class="col-md-2 control-label"><b>Icono:</b> </label>

        <div class="form-group col-md-4">
            <input class="form-control" name="sIcono"
                   value="<?php echo (isset($result['sIcono'])) ? ($result['sIcono']) : ''; ?>" placeholder="Icono"
                   autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Color:</b> </label>

        <div class="form-group col-md-4">
            <input class="form-control" name="sColor"
                   value="<?php echo (isset($result['sColor'])) ? ($result['sColor']) : ''; ?>" placeholder="Color"
                   autocomplete="off" type="text">
        </div>
    </div>

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Aplicaciones:</b> </label>

        <div class="form-group col-md-10">
            <div class="select2-success">
                <select class="form-control select2" multiple="multiple" data-plugin="select2" name="skAplicaciones[]">
                    <?php
                    if ($data['aplicaciones']) {
                        while ($row = Conn::fetch_assoc($data['aplicaciones'])) {
                            ?>
                            <option <?php echo (isset($data['aplicacionesMensajes']) && in_array($row['skAplicacion'], $data['aplicacionesMensajes'])) ? 'selected' : '' ?>
                                value="<?php echo $row['skAplicacion']; ?>"> <?php echo "$row[sNombre]"; ?> </option>
                            <?php
                        }
                    }//ENDWHILE
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Mensaje notificación</b> </label>
        <div class="form-group col-md-10">
            <textarea class="form-control" name="sMensaje"
                placeholder="Mensaje"><?php echo (isset($result['sMensaje'])) ? ($result['sMensaje']) : ''; ?></textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>Notificación General</b></label>

            <div class="col-md-2">
                <div class="checkbox-custom checkbox-primary">
                    <input id="iNotificacionGeneral" value="1"
                           name="iNotificacionGeneral" <?php echo (isset($result['iNotificacionGeneral']) && !empty($result['iNotificacionGeneral'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="iNotificacionGeneral"></label>
                </div>
            </div>
            <div class="col-md-12"><small>Se envia la notificación a todo el grupo</small></div>
        </div>
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>Notificación Obligatoria</b></label>

            <div class="col-md-2">
                <div class="checkbox-custom checkbox-primary">
                    <input id="sObligatorio" value="1"
                           name="sObligatorio" <?php echo (isset($result['sObligatorio']) && !empty($result['sObligatorio'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="sObligatorio"></label>
                </div>
            </div>
            <div class="col-md-12"><small>No se puede deshabilitar la notificación en el panel de notificaciones</small></div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>Enviar notificación al instante</b></label>

            <div class="col-md-2">
                <div class="checkbox-custom checkbox-primary">
                    <input id="iEnviarInstantaneo" value="1"
                           name="iEnviarInstantaneo" <?php echo (isset($result['iEnviarInstantaneo']) && !empty($result['iEnviarInstantaneo'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="iEnviarInstantaneo"></label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>NO Almacenar en Base de Datos</b></label>

            <div class="col-md-2">
                <div class="checkbox-custom checkbox-primary">
                    <input id="iNoAlmacenado" value="1"
                           name="iNoAlmacenado" <?php echo (isset($result['iNoAlmacenado']) && !empty($result['iNoAlmacenado'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="iNoAlmacenado"></label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <label class="col-md-4 control-label"><b>Enviar por correo</b></label>

            <div class="col-md-2">
                <div class="checkbox-custom checkbox-primary">
                    <input id="iEnviarCorreo" value="1"
                           name="iEnviarCorreo" <?php echo (isset($result['iEnviarCorreo']) && !empty($result['iEnviarCorreo'])) ? 'checked' : ''; ?>
                           type="checkbox">
                    <label for="iEnviarCorreo"></label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 margin-30">
        <label class="col-md-2 control-label"><b>Mensaje Correo:</b> </label>
        <div class="form-group col-md-8">
            <textarea class="core-summernote" data-plugin="summernote" id="sMensajeCorreo" name="sMensajeCorreo" >
                <?php echo (isset($result['sMensajeCorreo'])) ? ($result['sMensajeCorreo']) : ''; ?>
            </textarea>
        </div>
    </div>

    <div class="col-md-12 clearfix">
        <hr>
    </div>

    <!-- SE AGREGAN VALORES AL GRUPO DE USUARIOS (TABLA MULTIPLE) !-->

    <div class="form-group col-md-12 ">

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

    </div>

</form>
<script
    src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    function tableMultiple1_addNewRow(index) {

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
    };

    core.formValidaciones.fields = conf.meno_form.validaciones;

    $(document).ready(function () {

        $('#core-guardar').formValidation(core.formValidaciones);

        core.tableMultiple($("#tableMultiple1"), params);

        $('.select2').select2();

        core.summernote();

        core.formChage();
    });

</script>
