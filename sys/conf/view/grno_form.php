<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skGrupoNotificacion"  id="skGrupoNotificacion"
           value="<?php echo (isset($result['skGrupoNotificacion'])) ? $result['skGrupoNotificacion'] : ''; ?>">

    <div class="col-md-12">

        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        <div class="form-group col-md-4">
            <input class="form-control" name="sNombre"
                   value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="Nombre" autocomplete="off" type="text">
        </div>

        <label class="col-md-2 control-label"><b>Estatus:</b> </label>
        <div class="form-group col-md-4">
            <select  name="skEstatus" class="form-control">
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

    </div>

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Descripci&oacute;n:</b> </label>
        <div class="form-group col-md-4">
            <textarea class="form-control" name="sDescripcion" placeholder="Descripci&oacute;n"><?php echo (isset($result['sDescripcion'])) ? ($result['sDescripcion']) : ''; ?></textarea>
        </div>
    </div>

    <div class="col-md-12 clearfix"><hr></div>

    <!-- SE AGREGAN VALORES AL GRUPO DE USUARIOS (TABLA MULTIPLE) !-->

    <div class="form-group col-md-12 ">

        <div class="well tableMultiple1-panelEdit col-md-12">
            <p class="tableMultiple1-editAndo text-center"></p>

            <div class="form-group col-md-12">

                <label class="col-md-2 control-label"><b> Usuario</b></label>
                <div class="col-md-3">
                    <select id="skUsuario" data-plugin="select2" select2 data-ajax--cache="true"></select>
                </div>

                <div class="col-md-2">
                    <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary pull-right">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="example">
                <div id="tableMultiple1-toolbar">
                    <button id="tableMultiple1-removeRowTableMultiple" class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                        <i class="fa fa-trash"></i> Borrar
                    </button>
                </div>
                <table id="tableMultiple1" data-toggle="table" data-toolbar="#tableMultiple1-toolbar"
                       data-query-params="queryParams" data-mobile-responsive="true"
                       data-height="400" data-pagination="false" data-icon-size="outline"
                       data-search="true" data-unique-id="id">
                </table>
            </div>
        </div>

    </div>
    <div class="col-md-12 clearfix"><hr></div>
    <div class="col-md-12 clearfix"><hr></div>


        <!-- SE AGREGAN VALORES AL GRUPO DE USUARIOS (TABLA MULTIPLE) !-->

        <div class="form-group col-md-12 ">

            <div class="well tableMultiple2-panelEdit col-md-12">
                <p class="tableMultiple2-editAndo text-center"></p>

                <div class="form-group col-md-12">

                    <label class="col-md-2 control-label"><b> Mensaje</b></label>
                    <div class="col-md-3">
                        <select id="skNotificacionMensaje" data-plugin="select2" select2 data-ajax--cache="true"></select>
                    </div>

                    <div class="col-md-2">
                        <button id="tableMultiple2-addRow" onclick="tableMultiple2_addNewRow();" class="btn btn-primary pull-right">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="example">
                    <div id="tableMultiple2-toolbar">
                        <button id="tableMultiple2-removeRowTableMultiple" class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                            <i class="fa fa-trash"></i> Borrar
                        </button>
                    </div>
                    <table id="tableMultiple2" data-toggle="table" data-toolbar="#tableMultiple2-toolbar"
                           data-query-params="queryParams" data-mobile-responsive="true"
                           data-height="400" data-pagination="false" data-icon-size="outline"
                           data-search="true" data-unique-id="id">
                    </table>
                </div>
            </div>

        </div>

</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    function tableMultiple1_addNewRow(index) {

        var skU = $("#skUsuario");

        if ( skU.val() == null) {
            toastr.warning("Por favor complete los datos.");
            return;
        }

        var params1 = {
            "usuario": {"id": "skUsuario", "type": "selected"}
        };

        core.tableMultipleAddRow($('#tableMultiple1'), params1,null,index);
    }

    var params1 = {
        datos: {
            columns: [
                {
                    field: 'state',
                    checkbox: true,
                    align: 'center',
                    valign: 'middle'
                }, {
                    field: 'usuario',
                    title: 'Usuario'
                }, {
                    field: 'id',
                    title: 'ID'
                }
            ],
            data: <?php echo isset($data["gruposNotificaciones_usuarios"]) ? $data["gruposNotificaciones_usuarios"] : json_encode([]); ?>
        }
    };


        function tableMultiple2_addNewRow(index) {

            var skN = $("#skNotificacionMensaje");

            if ( skN.val() == null) {
                toastr.warning("Por favor complete los datos.");
                return;
            }

            var params2 = {
                "mensaje": {"id": "skNotificacionMensaje", "type": "selected"}
            };

            core.tableMultipleAddRow($('#tableMultiple2'), params2,null,index);
        }




    var params2 = {
        datos: {
            columns: [
                {
                    field: 'state',
                    checkbox: true,
                    align: 'center',
                    valign: 'middle'
                }, {
                    field: 'mensaje',
                    title: 'Mensaje'
                }, {
                    field: 'id',
                    title: 'ID'
                }
            ],
            data: <?php echo isset($data["gruposNotificaciones_mensajes"]) ? $data["gruposNotificaciones_mensajes"] : json_encode([]); ?>
        }
    };

    core.formValidaciones.fields = conf.grno_form.validaciones;

    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
        core.tableMultiple($("#tableMultiple1"), params1);
        core.tableMultiple($("#tableMultiple2"), params2);
        core.autocomplete2('#skUsuario', 'getUsuarios', window.location.href, 'Buscar usuario');
        core.autocomplete2('#skNotificacionMensaje', 'getMensajes', window.location.href, 'Buscar Mensaje');

    });

</script>
