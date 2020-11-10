<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skGrupo"  id="skGrupo"
           value="<?php echo (isset($result['skGrupo'])) ? $result['skGrupo'] : ''; ?>">

    <div class=" col-md-12">


        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sNombre"
                   value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="Nombre" autocomplete="off" type="text">
        </div>

        <label class="col-md-2 control-label"><b>Estatus:</b> </label>
        <div class="form-group col-md-3">

            <select  name="skEstatus" class="form-control">
                <option value="">Seleccionar</option>
<?php
if ($data['Estatus']) {
    foreach($data['Estatus'] AS $row) {
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

    <!-- SE AGREGAN VALORES AL GRUPO DE EMPRESAS (TABLA MULTIPLE) !-->

    <div class="form-group col-md-12 ">

        <div class="well tableMultiple1-panelEdit col-md-12">
            <p class="tableMultiple1-editAndo text-center"></p>

            <div class="form-group col-md-12">
                <label class="col-md-2 control-label"><b> Empresa</b></label>

                <div class="col-md-4">
                    <select id="skEmpresaSocio" data-plugin="select2" select2 data-ajax--cache="true"></select>
                </div>

                <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary">
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

                        var skE = $("#skEmpresaSocio");

                        if (!skE.val().length > 0) {
                            toastr.warning("Por favor complete los datos.");
                            return;
                        }

                        var params = {
                            "empresa": {"id": "skEmpresaSocio", "type": "selected"}
                        };
                        core.tableMultipleAddRow($('#tableMultiple1'), params,null,index);
                    }

                    var params = {datos: {
                            columns: [{
                                    field: 'state',
                                    checkbox: true,
                                    align: 'center',
                                    valign: 'middle'
                                }, {
                                    field: 'empresa',
                                    title: 'Empresa'
                                }, {
                                    field: 'id',
                                    title: 'ID'
                                }],
                            data: <?php echo isset($data["grupo_empresas"]) ? $data['grupo_empresas'] : json_encode(array()); ?>}};

    core.formValidaciones.fields = empr.grup_form.validaciones;

    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
        core.tableMultiple($("#tableMultiple1"), params);
        core.autocomplete2('#skEmpresaSocio', 'aut_empresas' , window.location.href, 'Buscar empresa');
    });

</script>
