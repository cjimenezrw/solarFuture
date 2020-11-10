<?php
    $result = $data['datos']['cliente'];
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skEmpresaSocio"  id="skEmpresaSocio" value="<?php echo (!empty($result['skEmpresaSocio'])) ? $result['skEmpresaSocio'] : '' ; ?>">

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Empresa:</b></label>
        <div class="form-group col-md-4">
            <select name="empresa" id="empresa" class="form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true" <?php echo !empty($result['skEmpresaSocio']) ? 'disabled="disabled"': '';?> onchange="empr.coem_form.changeEmpresa(this);">
                <?php
                    if(!empty($result['skEmpresaSocio'])){
                ?>
                <option value="<?php echo $result['skEmpresaSocio']; ?>" selected="selected"><?php echo $result['cliente']; ?></option>
                <?php
                    }//ENDIF
                ?>
            </select>
        </div>
        <?php
            $display = 'none';
            if(isset($result['skEmpresaTipo']) && $result['skEmpresaTipo'] == 'CLIE'){
                $display = 'block';
            }
        ?>
        
    </div>

    <div class="col-md-12 clearfix">

        <div class=" form-group col-md-12">

            <div class="well tableMultiple1-panelEdit col-md-12">
                <p class="tableMultiple1-editAndo text-center"></p>

                <div class="col-md-10">

                    <div class="col-md-3">
                        <label class="control-label "><b>Correo Electrónico</b></label>
                    </div>
                    <div class="col-md-9">
                        <input  data-plugin="inputText" inputText autocomplete="off" class="form-control" type="email" placeholder="correo@dominio.com" name="sCorreo" id="sCorreo" >
                    </div>

                </div>

                <div class="col-md-2">
                    <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar </button>
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
    </div>


</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;

    function tableMultiple1_addNewRow(index) {

        var sCorreo = $("#sCorreo").val();

        if (sCorreo == null || sCorreo == '') {
            toastr.warning("Por favor agregue un correo electrónico");
            return;
        }

        // VALIDAMOS QUE NO SE REPITA EL COLOR DEL SELLO
        if (typeof index === 'undefined') {
            var flag = true;
            $('input[name="sCorreo[]"]').each(function (k, v) {
                if (sCorreo == $(v).val()) {
                    flag = false;
                    return false;
                }
            });

            if (!flag) {
                toastr.warning("El correo electrónico ya está en la lista");
                return;
            }
        }

        var params = {
            "sCorreo": {"id": "sCorreo", "type": "val"}
        };

        core.tableMultipleAddRow($('#tableMultiple1'), params, null, index);
    }

    var params = {
        datos: {
            columns: [{
                    field: 'state',
                    checkbox: true,
                    align: 'center',
                    valign: 'middle'
                }, {
                    field: 'sCorreo',
                    title: 'Correo Electrónico'
                }, {
                    field: 'id',
                    title: 'ID'
                }],
            data: <?php echo (isset($data['datos']['correos'])) ? $data['datos']['correos'] : '[]'; ?>
        }
    };


    $(document).ready(function () {
        core.tableMultiple($("#tableMultiple1"), params);
        $('#core-guardar').formValidation(core.formValidaciones);
        core.autocomplete2('#empresa', 'getEmpresas', window.location.href, 'Empresa');
    });

</script>
