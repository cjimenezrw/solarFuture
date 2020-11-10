<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}

$srvs = [];
if (isset($data['servicios']) && is_array($data['servicios'])) {
    foreach ($data['servicios'] as $row) {
        array_push($srvs, array(
            'id' => $row['skServicio'],
            'servicio' => $row['sNombre'] . "
            <input data-name=\"$row[sNombre]\" name=\"skServicio[]\" value=\"$row[skServicio]\" type=\"text\" hidden>"
        ));
    }
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">

    <div id="modelosleDIV" >
        <div class="well serviciosEmpresas-panelEdit  col-md-12">
            <p class="serviciosEmpresas-editAndo text-center"></p>
            <div id="hidenContNum">
                <label class="col-md-2 control-label"><b> Servicio</b></label>
                <div class="col-md-5">
                    <select id="skServicio" select2 data-plugin="select2" data-ajax--cache="true"></select>
                </div>
            </div>
            <div class="col-md-2">
                <button id="serviciosEmpresas-addRow" onclick="serviciosEmpresas_addNewRow();" class="btn btn-primary margin-vertical-10 pull-right"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar </button>
            </div>
        </div>

        <div class=" form-group col-md-12">
            <div class="example">
                <div id="serviciosEmpresas-toolbar">
                    <button id="serviciosEmpresas-removeRowTableMultiple"
                            class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                        <i class="fa fa-trash"></i> Borrar
                    </button>
                </div>
                <table id="serviciosEmpresas" data-toggle="table" data-toolbar="#serviciosEmpresas-toolbar"
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
    
    core.formValidaciones.fields = empr.soem_form.validaciones;

    function serviciosEmpresas_addNewRow(index) {

        if ($('#skServicio').val() === null) {
            toastr.warning("Seleccione un servicio.");
            return;
        }
        var params = {
            "servicio": {"id": "skServicio", "type": "selected"}
        };
        core.tableMultipleAddRow($('#serviciosEmpresas'), params, null, index);
    };

    $(document).ready(function () { 
        
        $('#core-guardar').formValidation(core.formValidaciones);
        core.autocomplete2('#skServicio', 'aut_servicios', window.location.href, 'Buscar servicio');
        
        core.tableMultiple($("#serviciosEmpresas"), {
            datos: {
                columns: [{
                        field: 'state',
                        checkbox: true,
                        align: 'center',
                        valign: 'middle'
                    }, {
                        field: 'servicio',
                        title: 'Servicio'
                    },  {
                        field: 'id',
                        title: 'ID'
                    }],
                data: <?php echo json_encode($srvs); ?>
            }
        });
        
    });
</script>