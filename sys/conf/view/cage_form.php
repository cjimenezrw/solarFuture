<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}

?>


<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">

    <div class="col-md-12">
        <label class="col-md-2 control-label"><b><span style="color:red;">* </span>C&oacute;digo:</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" maxlength="6" minlength="6"
                   accept="" <?php if (isset($result['skCatalogoSistema'])) { ?>disabled="disabled"<?php }//ENDIF  ?>  name="skCatalogoSistema"
                   value="<?php echo (isset($result['skCatalogoSistema'])) ? utf8_encode($result['skCatalogoSistema']) : ''; ?>" placeholder="C&oacute;digo" autocomplete="off" type="text">
        </div>

        <label class="col-md-2 control-label"><b><span style="color:red;">* </span>Nombre:</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control"
                   name="sNombre" value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>"
                   placeholder="Nombre" autocomplete="off" type="text">
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
                <label class="col-md-2 control-label"><b>Nombre</b></label>

                <div class="col-md-4">
                    <input data-plugin="inputText" inputText class="form-control" id="sNombreOpcion" name="sNombreOpcion"  placeholder="Nombre" autocomplete="off" type="text">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <label class="col-md-2 control-label"><b> Clave</b> </label>
                <div class=" col-md-4">
                    <input class="form-control" data-plugin="inputText" inputText maxlength="6" minlength="6" id="skClave" name="skClave" placeholder="Clave" autocomplete="off" type="text">  
                </div>
            </div>
            <div class="col-md-12 form-group">
                <div class=" col-md-2"></div>
                <div class=" col-md-2">
                    <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                    </button>
                </div>
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
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;
    
    
    var params = {
        datos: {
            columns: [{
                field: 'state',
                checkbox: true,
                align: 'center',
                valign: 'middle'
            },{
                field: 'sNombreOpcion',
                title: 'Nombre '
            }, {
                field: 'skClave',
                title: 'Clave '
            }, {
                field: 'id',
                title: 'ID'
            }],
            data: <?php echo isset($data["catalogosOpciones"]) ? json_encode($data["catalogosOpciones"]) : json_encode([]); ?> 
            }
        };
    
    $(document).ready(function () {
        core.tableMultiple($("#tableMultiple1"), params);
        $('#core-guardar').formValidation(core.formValidaciones);
        //Variable Global
        
        
        window.globalOption = [];
        var Option = <?php echo isset($data["catalogosOpciones"]) ? json_encode($data["catalogosOpciones"]) : json_encode([]); ?>;
        <?php 
            if(isset($_GET['p1'])){?>
                for(var i in Option){
                    window.globalOption.push(Option[i].skClave);
                }<?php }
        ?> 
                
    });
    
    
function tableMultiple1_addNewRow(index) {
    
    //Validamos si existe en el arreglo un dato similar
    if(window.globalOption.includes($("#skClave").val()) && $("#tableMultiple1-addRow").text().trim() == 'Agregar'){
        toastr.warning("No se permiten Claves similares..");
        return;
    }
    
    var sNombreOpcion = $("#sNombreOpcion");
    var skClave = $("#skClave");

    if (!sNombreOpcion.val().length > 0 ) {
        toastr.warning("Ingrese un valor.");
        return;
    }
    
    var params = {
        "sNombreOpcion": {"id": "sNombreOpcion", "type": "val"},
        "skClave": {"id": "skClave", "type": "val"}
    };
    
    //si no existe pusheamos la nueva clave al arreglo
    globalVariable($("#skClave").val());
    core.tableMultipleAddRow($('#tableMultiple1'), params,'skCatalogoSistemaOpciones',index);
}

//Función para ir generando la variable global
function globalVariable(value){
    window.globalOption.push($("#skClave").val());
    return window.globalOption;
}

</script>