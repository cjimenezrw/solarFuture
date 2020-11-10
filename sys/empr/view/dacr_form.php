<?php
    $result = !empty($data['datos'][0]) ? $data['datos'][0] : array();
?>

<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="skEmpresaSocioCliente"  id="skEmpresaSocioCliente" value="<?php echo (!empty($result['skEmpresaSocioCliente'])) ? $result['skEmpresaSocioCliente'] : '' ; ?>">
    
    <div class="col-md-12">
        <label class="col-md-2 control-label"><b>Cliente:</b> </label>
        <div class="form-group col-md-4">
            <select name="skEmpresaSocio" id="skEmpresaSocio" class="form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true" <?php echo !empty($result['skEmpresaSocioCliente']) ? 'disabled="disabled"': '';?>>
                <?php 
                    if(!empty($result['skEmpresaSocioCliente'])){
                ?>
                <option value="<?php echo $result['skEmpresaSocioCliente']; ?>" selected="selected"><?php echo $result['clienteCorto']; ?></option>
                <?php 
                    }//ENDIF 
                ?>
            </select>
        </div>
    </div>
    
    <div class="col-md-12 clearfix"><hr></div>
    
    <!-- COMIENZA TABLA MULTIPLE PARA LA CONFIGURACIÓN DE DÍAS LIBRES DE ALMACENAS ENTRE CLIENTE Y RECINTO !-->
    <div class="well tableMultiple1-panelEdit col-md-12">
        <p class="tableMultiple1-editAndo text-center"></p>
        
        <div class="col-md-6">
            <label class="control-label"><b>Recinto</b></label>
            <select id="skEmpresaSocioRecinto" data-plugin="select2" select2Simple>
                <option value="">Seleccionar</option>
                <?php
                if($data['recintos']){
                    foreach($data['recintos'] AS $k=>$v){
                ?>
                <option value="<?php echo $v['id']; ?>"><?php echo $v['nombre']; ?></option>
                <?php
                    }//ENDFOREACH
                }//ENDIF
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="control-label"><b>Días Libres</b></label>
            <input data-plugin="inputText" inputText class="form-control" id="iDiasAlmacenajes" value="" placeholder="Días Libres" autocomplete="off" type="text">
        </div>

        <div class="col-md-12">
            <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary margin-vertical-10"> 
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar
            </button>
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
    <!-- TERMINA TABLA MULTIPLE PARA LA CONFIGURACIÓN DE DÍAS LIBRES DE ALMACENAS ENTRE CLIENTE Y RECINTO !-->
    
</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;
    
    // TABLA MULTIPLE PARA LOS SELLOS DE LA SOLICITUD //
    function tableMultiple1_addNewRow(index) {
        
        var skEmpresaSocioRecinto = $( "#skEmpresaSocioRecinto" ).val();
        var iDiasAlmacenajes = $( "#iDiasAlmacenajes" ).val();
        
        if(skEmpresaSocioRecinto == null || skEmpresaSocioRecinto == ''){
            toastr.warning("Por favor seleccione el recinto");
            return;
        }
        
        if(iDiasAlmacenajes == null || iDiasAlmacenajes == ''){
            toastr.warning("Por favor ingrese los días libres de almacenajes");
            return;
        }
        
        iDiasAlmacenajes = parseInt(iDiasAlmacenajes);
        
        if(iDiasAlmacenajes <= 0 || !Number.isInteger(iDiasAlmacenajes)){
            toastr.warning("Los día libres deben ser mayor o igual a 1");
            return;
        }
        
        if (typeof index == 'undefined') {
            // VALIDAMOS QUE NO SE REPITA EL RECINTO
            var flag = true;
            $('input[name="skEmpresaSocioRecinto[]"]').each(function(k,v){
                if(skEmpresaSocioRecinto == $(v).val()){
                    flag = false;
                    return false;
                }
            });

            if(!flag){
                toastr.warning("Ya se ha agregado el recinto");
                return;
            }
        }
        
        var params = {
            "skEmpresaSocioRecinto": {"id": "skEmpresaSocioRecinto", "type": "simpleSelected"},
            "iDiasAlmacenajes": {"id": "iDiasAlmacenajes", "type": "val"}
        };

        core.tableMultipleAddRow($('#tableMultiple1'), params, 'skDiaAlmacenaje', index);
        
    }
    
    var params = {
        datos: {
            columns: [{
                field: 'state',
                checkbox: true,
                align: 'center',
                valign: 'middle'
            }, {
                field: 'skEmpresaSocioRecinto',
                title: 'Recinto'
            }, {
                field: 'iDiasAlmacenajes',
                title: 'Días Libres'
            }, {
                field: 'id',
                title: 'ID'
            }],
            data: <?php echo (!empty($data['datos']['diasLibres'])) ? (json_encode($data['datos']['diasLibres'])) : json_encode([]); ?>
        }
    };
    
    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);
        
        core.autocomplete2('#skEmpresaSocio', 'getClientes' , window.location.href , 'Cliente');
        
        $("#skEmpresaSocioRecinto").select2({
            placeholder: "Seleccione un Recinto"
        });
        
        core.tableMultiple($("#tableMultiple1"), params);
        
    });
</script>