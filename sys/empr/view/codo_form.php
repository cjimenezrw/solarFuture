<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    $configs = $data['configDocs'];
    $resultDocumentos = $data['tipos_documentos'];
    utf8($result);
    utf8($resultDocumentos);
    utf8($configs);
}
?>
<div class="panel-heading">
    <h3 class="panel-title"><?php echo $result["sNombre"]; ?></h3><hr>
</div>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skGrupo"  id="skGrupo"
           value="<?php echo (isset($result['skGrupo'])) ? $result['skGrupo'] : ''; ?>">

    <input type="hidden" name="skEmpresaTipo"  id="skEmpresaTipo" value="<?php echo (isset($result['skEmpresaTipo'])) ? $result['skEmpresaTipo'] : ''; ?>">

    <div class="form-group col-md-12 ">

        <div class="well tableMultiple1-panelEdit col-md-12">
            <p class="tableMultiple1-editAndo text-center"></p>

            <div class="form-group col-md-12">
                <label class="col-md-2 control-label"><b> Documento:</b></label>

                <div class="col-md-2">
                    <select id="skTipoDocumento" data-plugin="select2" name="skTipoDocumento" select2Simple >
                        <option value="">Seleccionar</option>
                        <?php
                        if ($data['tipos_documentos']) {
                            foreach (  $data['tipos_documentos'] as $row) {
                                utf8($row);
                                ?>
                                <option
                                    value="<?php echo $row['skTipoDocumento']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                <?php
                            }//ENDWHILE
                        }//ENDIF
                        ?>
                    </select>
                </div>

                <label class="col-md-2 control-label"><b> Obligatorio:</b></label>
                <div class="form-group col-sm-2">
                    <select id="iObligatorio" name="iObligatorio" class="form-control" data-plugin="select2" select2Simple >
                        <option value="">Seleccionar</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>

                </div>

                <label class="col-md-2 control-label"><b> Original:</b></label>
                <div class="form-group col-sm-2">
                    <select id="iOriginal" name="iOriginal" class="form-control" data-plugin="select2" select2Simple >
                        <option value="">Seleccionar</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>

                </div>

                <label class="col-md-2 control-label"><b> Expiración:</b></label>
                <div class="form-group col-sm-2">
                    <select id="iFechaExpiracion" name="iFechaExpiracion" class="form-control" data-plugin="select2" select2Simple >
                        <option value="">Seleccionar</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>

                </div>

                <label class="col-md-2 control-label"><b> Multiplicidad:</b></label>
                <div class="form-group col-sm-2">
                    <select id="iMultiple" name="iMultiple" data-plugin="select2" class="form-control" select2Simple>
                        <option value="">Seleccionar</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>

                </div>


                <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary pull-right">
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                </button>
            </div>
        </div>

        <div class="col-md-12">
            <div class="example">
                <div id="toolbar">
                    <button id="tableMultiple1-removeRowTableMultiple" class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
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

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    function tableMultiple1_addNewRow(index) {

        var skD = $("#skTipoDocumento");
        var iO = $("#iObligatorio");
        var iOr = $("#iOriginal");
        var dFe = $("#iFechaExpiracion");
        var mul = $("#iMultiple");

        if (!skD.val().length > 0 || !iO.val().length > 0 || !iOr.val().length > 0 || !dFe.val().length > 0 || mul.val() == null) {
            toastr.warning("Por favor complete los datos.");
            return;
        }

        var params = {
            "skTipoDocumento": {"id": "skTipoDocumento", "type": "simpleSelected"},
            "iObligatorio": {"id": "iObligatorio", "type": "simpleSelected"},
            "iOriginal": {"id": "iOriginal", "type": "simpleSelected"},
            "iFechaExpiracion": {"id": "iFechaExpiracion", "type": "simpleSelected"},
            "iMultiple": {"id": "iMultiple", "type": "simpleSelected"}
        };
        core.tableMultipleAddRow($('#tableMultiple1'), params, 'skDocumentoConfig',index);
    }

    var params = {datos: {
        columns: [{
            field: 'state',
            checkbox: true,
            align: 'center',
            valign: 'middle'
        }, {
            field: 'skTipoDocumento',
            title: 'Documento'
        }, {
            field: 'iObligatorio',
            title: 'Obligatorio'
        }, {
            field: 'iOriginal',
            title: 'Original'
        }, {
            field: 'iFechaExpiracion',
            title: 'Fecha Expiración'
        },{
            field: 'iMultiple',
            title: 'Multiple'
        }, {
            field: 'id',
            title: 'ID'
        }],
        data: <?php echo isset($data["configDocs"]) ? $data['configDocs'] : json_encode(array()); ?>}};

    core.formValidaciones.fields = empr.grup_form.validaciones;

    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
        core.tableMultiple($("#tableMultiple1"), params);
        $("#skTipoDocumento").select2({
            placeholder: "Seleccione un Documento"
        });
        $("#iMultiple").select2({
            placeholder: "Seleccione una opción"
        });
    });
</script>
