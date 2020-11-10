<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}

?>


<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>C&oacute;digo:</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" maxlength="6" <?php if (isset($result['skCatalogoSistema'])) { ?>disabled="disabled"<?php }//ENDIF  ?>  name="skCatalogoSistema" value="<?php echo (isset($result['skCatalogoSistema'])) ? utf8_encode($result['skCatalogoSistema']) : ''; ?>" placeholder="C&oacute;digo" autocomplete="off" type="text">
        </div>
    </div>

    <div class="col-md-12">



        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
        <div class="form-group col-md-2">
            <input class="form-control"
                   name="sNombre" value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>"
                   placeholder="Nombre" autocomplete="off" type="text">
        </div>

        <label class="col-md-2 control-label"><b>Estatus:</b> </label>
        <div class="form-group col-md-3">
            <select name="skEstatus" class="form-control">
                <option value="">Seleccionar</option>
                <?php
                if ($data['Estatus']) {

                    array_walk($data['Estatus'], function(&$v) use(&$result){
                        $s = ($result['skEstatus'] === $v['skEstatus'])?'selected' : '';
                        echo "<option $s value=\"$v[skEstatus]\" > $v[sNombre]</option> ";
                    });
                }
                    ?>
            </select>
        </div>
    </div>


    <div class="form-group col-md-12">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <hr>
        </div>
    </div>
    <!-- SE AGREGAN VALORES AL PUNTO DE TRACKING (TABLA MULTIPLE) !-->

    <div class="form-group col-md-12 ">

        <div class="well tableMultiple1-panelEdit col-md-12">
            <p class="tableMultiple1-editAndo text-center"></p>
            <div class="form-group col-md-12">
                <label class="col-md-2 control-label"><b> Nombre</b></label>
                <div class="col-md-4">
                    <input data-plugin="inputText" inputText class="form-control" id="sNombreOpcion" name="sNombreOpcion"  placeholder="Valor" autocomplete="off" type="text">
                </div>
                
                <label class="col-md-2 control-label"><b> Clave</b></label>
                <div class="col-md-4">
                    <input data-plugin="inputText" inputText class="form-control" id="sClave" name="sClave"  placeholder="Valor" autocomplete="off" type="text">
                </div>
            </div>
            <div class="col-md-12 clearfix"><hr></div>
            <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary pull-right">
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar
            </button>
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

    var sNombreOpcion = $("#sNombreOpcion");

    if (!sNombreOpcion.val().length > 0 ) {
        toastr.warning("Ingrese un valor.");
        return;
    }

    var params = {
        "sNombreOpcion": {"id": "sNombreOpcion", "type": "val"},
        "sClave": {"id": "sClave", "type": "val"}
    };
    core.tableMultipleAddRow($('#tableMultiple1'), params,'skCatalogoSistemaOpciones',index);
}

var params = {datos: {
    columns: [{
        field: 'state',
        checkbox: true,
        align: 'center',
        valign: 'middle'
    },{
        field: 'sNombreOpcion',
        title: 'Nombre '
    },{
        field: 'sClave',
        title: 'Clave '
    },
    {
        field: 'id',
        title: 'ID'
    }],
    data: <?php echo isset($data["catalogosOpciones"]) ? json_encode($data["catalogosOpciones"]) : json_encode(array()); ?> }};
    core.formValidaciones.fields = conf.cage_form.validations;

    $(document).ready(function () {
        core.tableMultiple($("#tableMultiple1"), params);
        $('#core-guardar').formValidation(core.formValidaciones);
    });

</script>
