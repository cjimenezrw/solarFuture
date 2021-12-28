var admi = {};

admi.orse_inde = {}; 
admi.cotr_inde = {};  
admi.appa_inde = {}; 
admi.uscf_inde = {}; 
admi.cotr_form = {};
admi.orse_form = {};
admi.cofa_inde = {};
admi.cofa_suba = {};

admi.uscf_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consulta';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'axn': 'consulta',
    'order': [[1, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'CLAVE', 'data': 'sClave', 'dataType': 'string'  },
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'  }
        
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(1, 'success');
        core.dataTable.fastFilters(1, [], true);
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIcono) ? $(td).html('<i class="' + rowData.estatusIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
                ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },
        {
            "targets": [1],
            "width": '30px'
            
        }
    ]
}; 
admi.orse_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consulta';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'axn': 'consulta',
    'order': [[3, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
         {'title': 'Folio F.', 'filterT': 'Folio Factura','tooltip': 'Folio Factura','data': 'iFolioFactura', 'dataType': 'string'},
        {'title': 'Folio OS', 'data': 'iFolio','tooltip': 'Folio Orden de Servicio', 'dataType': 'string'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Folio SE.', 'data': 'folioServicio','tooltip': 'Folio del Servicio', 'dataType': 'string'},

        {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},

        {'title': 'Total', 'data': 'fImporteTotal', 'dataType': 'int'},
         {'title': 'Moneda', 'data': 'skDivisa', 'dataType': 'string'},
        {'title': 'Facturar A', 'data': 'facturacion', 'dataType': 'string'},
         {'title': 'Responsable', 'data': 'responsable', 'dataType': 'string'},
        {'title': 'Cliente', 'data': 'cliente', 'dataType': 'string'}

        
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        core.dataTable.fastFilters(2, [], true);
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIcono) ? $(td).html('<i class="' + rowData.estatusIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
                ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },
        {
            "targets": [2],
            "width": '30px'
            
        },
        {
            "targets": [3],
            "width": '70px'
            
        },
        {
            "targets": [4],
            "width": '30px'
            
        }
    ]
}; 



admi.cotr_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consulta';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'axn': 'consulta',
    'order': [[2, "desc"]],
    'columns': [
        {'title': 'E', 'filterT': 'Estatus', 'tooltip': 'Estatus', 'data': 'estatus', 'dataType': 'string'},
        {'title': 'TP', 'filterT': 'Tipo Transacción', 'tooltip': 'Tipo Transacción', 'data': 'tipoTransaccion', 'dataType': 'string'},
        {'title': 'Folio', 'data': 'iFolio', 'dataType': 'string'},
        {'title': 'Divisa', 'data': 'skDivisa', 'dataType': 'string'},
        {'title': 'Importe', 'data': 'fImporte', 'dataType': 'int'},
        {'title': 'Saldo', 'data': 'fSaldo', 'dataType': 'int'},
        {'title': 'Empresa Responsable', 'data': 'empresaResponsable', 'dataType': 'string'},
         {'title': 'F. Transferencia', 'data': 'dFechaTransaccion', 'dataType': 'date', 'tooltip': 'Fecha de Transacción', 'filterT': 'Fecha de Transacción'},
        {'title': 'U. Creación', 'data': 'usuarioCreacion', 'filterT': 'Usuario Creación', 'tooltip': 'Usuario Creación', 'dataType': 'string'},
        {'title': 'F. Creación', 'data': 'dFechaCreacion', 'dataType': 'date', 'tooltip': 'Fecha de Creación', 'filterT': 'Fecha de Creación'}
    
        
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        core.dataTable.fastFilters(2, [], true);
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIcono) ? $(td).html('<i class="' + rowData.estatusIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
                ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },{
            "targets": [1],
            "width": '1px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (rowData.skTipoTransaccion) {
                    case "TRAN": // Transferencia
                        $(td).html('<i class="fa fa-money"></i>');
                        $(td).addClass('text-default text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                   
                    default:
                }
            }
        },
        {
            "targets": [2],
            "width": '30px'
            
        }
    ]
};  
admi.appa_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consulta';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'axn': 'consulta',
    'order': [[3, "desc"]],
    'columns': [
        {'title': 'E', 'filterT': 'Estatus', 'tooltip': 'Estatus', 'data': 'estatus', 'dataType': 'string'},
        {'title': 'F. Transferencia', 'data': 'folioTransaccion', 'dataType': 'string', 'tooltip' : 'Folio Transferencia', 'filterT': 'Folio Transferencia'},
        {'title': 'F. Factura', 'data': 'folioFactura', 'dataType': 'string','tooltip': 'Folio Factura', 'filterT': 'Folio Factura'},
        {'title': 'F. Aplicacion Pago', 'data': 'fechaPago', 'dataType': 'date', 'tooltip': 'Fecha de Transacción', 'filterT': 'Fecha de Transacción'},
        {'title': 'Divisa', 'data': 'skDivisa', 'dataType': 'string'},
        {'title': 'M. Pago', 'data': 'codigoMetodoPago', 'dataType': 'string', 'tooltip': 'Método de Pago', 'filterT': 'Método de Pago'},
        {'title': 'F. Pago', 'data': 'codigoFormaPago', 'dataType': 'string', 'tooltip': 'Forma de Pago', 'filterT': 'Forma de Pago'},
        {'title': 'T. Factura', 'data': 'totalFactura', 'dataType': 'string', 'tooltip':'Total Factura', 'filterT':'Total Factura'},
        {'title': 'S. Anterior Factura', 'data': 'fSaldoAnteriorFactura', 'dataType': 'int', 'tooltip':'Saldo Anterior Factura', 'filterT':'Saldo Anterior Factura'},
        {'title': 'Importe', 'data': 'importeFactura', 'dataType': 'int', 'tooltip':'Importe', 'filterT':'Total Factura'},
        {'title': 'S. Restante Factura', 'data': 'fSaldoRestanteFactura', 'dataType': 'int'},
        {'title': 'Empresa Responsable', 'data': 'empresaResponsable', 'dataType': 'string'},
        {'title': 'Cliente', 'data': 'empresaCliente', 'dataType': 'string'},
        {'title': 'Usuario Creación', 'data': 'usuarioCreacion','dataType': 'string'}
        
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(1, 'success');
        core.dataTable.fastFilters(1, [], true);
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIcono) ? $(td).html('<i class="' + rowData.estatusIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
                ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },
        {
            "targets": [1],
            "width": '30px'
            
        }
    ]
}; 

admi.serv_inde = {};
admi.serv_form = {};

admi.serv_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consulta';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'axn': 'consulta',
    'order': [[4, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
         {'title': 'Código', 'data': 'sCodigo', 'dataType': 'string','tooltip': 'CODIGO'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'}
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        core.dataTable.fastFilters(2, [], true);
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIcono) ? $(td).html('<i class="' + rowData.estatusIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
                ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },
        {
            "targets": [1],
            "width": '20px'
            
        }
    ]
}

admi.serv_form.validaciones = {
    sNombre: {
        validators: {
            notEmpty: {
                message: 'El Nombre es requerido'
            }
        }
    },
    sCodigo: {
        validators: {
            notEmpty: {
                message: 'El codigo del concepto es requerido'
            }
        }
    }

};
 



admi.cotr_form.changeDivisa = function changeDivisa(obj){
    $("#fTipoCambio").val('');
    if(obj.value == 'MXN'){
        $(".fTipoCambio").hide();
    }else{
        $(".fTipoCambio").show();
    }
};
 

admi.cotr_form.changeBanco = function changeBanco(obj){
    $(".option_banco_"+obj).hide();
    $("#skBancoCuenta_"+obj).val(null).trigger("change");

    if($("#skBanco_"+obj).val() == '' || $("#skBanco_"+obj).val() == null){
        $("#skBancoCuenta_"+obj).prop('disabled',true);
        $("#skBancoCuenta_"+obj).selectpicker('refresh');
        return false;
    }

    $(".banco_"+obj+"_"+$("#skBanco_"+obj).val()).show();
    $("#skBancoCuenta_"+obj).prop('disabled',false);
    $("#skBancoCuenta_"+obj).selectpicker('refresh');
    $("#skBancoCuenta_"+obj).selectpicker('val', $("#skBancoCuenta_"+obj+" option:eq(1)").val()).trigger("change");

    $("#skBancoCuenta_"+obj+" option").each(function(){
        if($(this).css('display') == 'block' && $(this).attr('disabled') != 'disabled'){
            $("#skBancoCuenta_"+obj).selectpicker('val', $(this).val()).trigger("change");
            return false;
        }
    });

    return true;
};

admi.cotr_form.ocultar_facturas_pendientes_pago = function ocultar_facturas_pendientes_pago(obj){
    $("#div-content-table-facturas").hide();
};

admi.cotr_form.get_facturas_pendientes_pago = function get_facturas_pendientes_pago(obj){

    var formdata = false;
    if (window.FormData) {
        formdata = new FormData($('#core-guardar')[0]);
        formdata.append('axn', 'get_facturas_pendientes_pago');
    }

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            toastr.info('Cargando Datos <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
        },
        success: function (response) {
            toastr.clear();
            if (response.success) {
                toastr.success(response.message, 'Notificación');
                $("#table-body-facturas").html('');
                if(response.facturas.length> 0){
                    var facturas = '';
                    $(response.facturas).each(function(k,v){
                        facturas += '<tr>';
                        facturas += '<td style="width:100px;">'+v.iFolio+'</td>';
                        facturas += '<td style="width:100px;">'+v.fSaldo+'</td>';
                        facturas += '<td style="width:100px;">'+v.fTotal+'</td>';
                        facturas += '<td>('+v.codigoFormaPago+') '+v.formaPago+'</td>';
                        facturas += '<td>('+v.codigoMetodoPago+') '+v.metodoPago+'</td>';
                        facturas += '<td>'+v.dFechaFacturacion+'</td>';
                        facturas += '</tr>';
                    });
                    $("#table-body-facturas").html(facturas);
                    $("#div-content-table-facturas").show();
                }
            } else {
                toastr.error(response.message, 'Notificación');
            }
        }
    });
};


admi.cotr_pago = {};
admi.cotr_pago.validations = {

};

admi.cotr_pago.guardar = function guardar(obj){

    var formdata = false;
    if (window.FormData) {
        formdata = new FormData($('#core-guardar')[0]);
        formdata.append('axn', 'guardar');
    }

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            toastr.info('Guardando Datos <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
        },
        success: function (response) {
            toastr.clear();
            if (!core.sessionOut(response)) {
                return false;
            }
            if (response.success) {
                toastr.success(response.message, 'Notificación');
                core.menuLoadModule({ skModulo: 'cotr-inde', skModuloPadre: 'fina-admi', url: '/'+core.DIR_PATH+'sys/admi/cotr-inde/transferencias/' });
            } else {
                toastr.error(response.message, 'Notificación');
            }
        }
    });
};

admi.cotr_pago.currencyFormat = function currencyFormat(num) {
  return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
};

admi.cotr_pago.changeImporte = function changeImporte(obj){
    var check_factura = $('.check_factura:checkbox:checked');
    totalImporteAplicado = 0;
    var fSaldoRestanteTransaccion = 0;
    $(check_factura).each(function(){
        var tr = $(this).parent().parent().parent();
        totalImporteAplicado += ($(".importeAplicado", tr).val() != 0 && $(".importeAplicado", tr).val() != "") ? parseFloat($(".importeAplicado", tr).val()) : 0;
    });
    $("#importeFacturas").html("Importe Aplicado: " + admi.cotr_pago.currencyFormat(totalImporteAplicado));

    fSaldoRestanteTransaccion = ((fSaldoTransaccion - totalImporteAplicado) < 0) ? 0 : (fSaldoTransaccion - totalImporteAplicado);

    $("#fSaldoRestanteTransaccion").html('');
    if(parseFloat(totalImporteAplicado.toFixed(2)) > parseFloat(fSaldoTransaccion.toFixed(2))){
        $("#messageFacturas").html('<i class="icon fa-warning" aria-hidden="true"></i> EL IMPORTE ES MAYOR AL SALDO');
    }else{
        $("#fSaldoRestanteTransaccion").html("Restan: " + admi.cotr_pago.currencyFormat(fSaldoRestanteTransaccion));
    }

    console.log('totalImporteAplicado: '+totalImporteAplicado +' > '+ fSaldoTransaccion+' fSaldoTransaccion');

    return true;

};

admi.cotr_pago.check_factura_all = function check_factura_all(obj){
    admi.cotr_pago.changeImporte({});
    $('.importeAplicado').val('');
    $('.check_factura').prop('checked', obj.checked);
    $(".importeAplicado").prop('disabled', (obj.checked ? false : true));

    var importeAplicado = 0;
    importeFacturas = parseFloat(0);
    var check_factura = $('.check_factura:checkbox:checked');
    $(check_factura).each(function(){
        var tr = $(this).parent().parent().parent();
        $(".importeAplicado", tr).prop('disabled',false);
        var total = $("td:eq(3)", tr).text().replace('$','').replace(',','').trim();
        importeFacturas += parseFloat(total);

        importeAplicado += ($(".importeAplicado", tr).val() != 0 && $(".importeAplicado", tr).val() != "") ? parseFloat($(".importeAplicado", tr).val()) : 0;

        if($(".importeAplicado", tr).val() == ""){
            if((fSaldoTransaccion - importeFacturas) < 0){
                if((fSaldoTransaccion - importeAplicado) < 0){
                    $(".importeAplicado", tr).val('');
                }else{
                    if(parseFloat(total) - (fSaldoTransaccion - importeAplicado) < 0){
                        if((totalImporteAplicado - importeAplicado) < 0){
                            $(".importeAplicado", tr).val((fSaldoTransaccion - totalImporteAplicado));
                        }else{
                            $(".importeAplicado", tr).val(total);
                        }
                    }else{
                        $(".importeAplicado", tr).val(parseFloat(fSaldoTransaccion - importeAplicado).toFixed(2));
                    }
                }
            }else{
                $(".importeAplicado", tr).val(total);
            }
        }

    });

    admi.cotr_pago.changeImporte({});
    //console.log('**totalImporteAplicado** '+totalImporteAplicado);
    //console.log('**Saldo** '+(fSaldoTransaccion - importeFacturas)+' **importeFacturas** '+importeFacturas);


    return true;
};

admi.cotr_pago.check_factura = function check_factura(obj){
    admi.cotr_pago.changeImporte({});
    var tr = $(obj).parent().parent().parent();
    $(".importeAplicado", tr).val('');
    $(".importeAplicado", tr).prop('disabled', (obj.checked ? false : true));

    var importeAplicado = 0;
    importeFacturas = parseFloat(0);
    var check_factura = $('.check_factura:checkbox:checked');
    $(check_factura).each(function(){
        var tr = $(this).parent().parent().parent();
        $(".importeAplicado", tr).prop('disabled',false);
        var total = $("td:eq(3)", tr).text().replace('$','').replace(',','').trim();
        importeFacturas += parseFloat(total);

        importeAplicado += ($(".importeAplicado", tr).val() != 0 && $(".importeAplicado", tr).val() != "") ? parseFloat($(".importeAplicado", tr).val()) : 0;

        if($(".importeAplicado", tr).val() == ""){
            if((fSaldoTransaccion - importeFacturas) < 0){
                if((fSaldoTransaccion - importeAplicado) < 0){
                    $(".importeAplicado", tr).val('');
                }else{
                    if(parseFloat(total) - (fSaldoTransaccion - importeAplicado) < 0){
                        if((totalImporteAplicado - importeAplicado) < 0){
                            $(".importeAplicado", tr).val((fSaldoTransaccion - totalImporteAplicado));
                        }else{
                            $(".importeAplicado", tr).val(total);
                        }
                    }else{
                        $(".importeAplicado", tr).val(parseFloat(fSaldoTransaccion - importeAplicado).toFixed(2));
                    }
                }
            }else{
                $(".importeAplicado", tr).val(total);
            }
        }
    });

    admi.cotr_pago.changeImporte({});


    //console.log('**totalImporteAplicado** '+totalImporteAplicado);
    //console.log('**Saldo** '+(fSaldoTransaccion - importeFacturas)+' **importeFacturas** '+importeFacturas);

    return true;
};

admi.orse_inde.autorizarOrden = function autorizarOrden(obj) {
    swal({
        title: "¿Desea confirmar la Orden de Servicio?",
        text: "Orden de Servicio " ,
        type: "warning",
        confirmButtonClass: "btn-warning",
        confirmButtonText: "SI",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        animation: "slide-from-top"
    },
    function () {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                axn: 'autorizarOrden',
                skOrdenServicio: core.rowDataTable.skOrdenServicio
            },
            cache: false,
            processData: true,
            beforeSend: function () {
                toastr.info('Confirmar la Orden # '+core.rowDataTable.iFolio, 'Notificación');
            },
            success: function (response) {
                toastr.clear();

                if(!response.success){
                    toastr.error(response.message+ " Folio:" +core.rowDataTable.iFolio, 'Notificación');
                    swal.close();
                    core.dataTable.sendFilters(true);
                    return false;
                }

                toastr.success('Orden de Servicio autorizada con exito # '+core.rowDataTable.iFolio, 'Notificación');
                swal("¡Notificación!", 'Orden de Servicio autorizada con exito# '+core.rowDataTable.iFolio, "success");
                core.dataTable.sendFilters(true);
                 return true;
            }
        });
    });
   
};

admi.orse_inde.enviarFacturacion = function enviarFacturacion(){

    swal({
        title: "Enviar Orden de Servicio a Facturar?",
        text: "Estas Seguro de Enviar la orden a Facturar?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Enviar",
        closeOnConfirm: false
    },
    function () {
        $.ajax({
      url: window.location.href,
      type: 'POST',
      data: {
          axn: 'enviarFacturacion',
          skOrdenServicio: core.rowDataTable.skOrdenServicio
      },
      cache: false,
      processData: true,
      beforeSend: function () {},

      success: function (response) {
                  if (response.success == true) {
                    swal.close();
                    toastr.success("Enviado Correctamente", 'Enviado');
                    core.dataTable.sendFilters(true);
                    return true;
                } else {
                    toastr.clear();
                    swal("Alerta!", response.message, "error");
                    core.dataTable.sendFilters(true);
                  }
        }
        });
    });
    };

admi.orse_inde.cancelarOrden = function cancelarOrden(obj) {
    swal({
        title: "¿Desea cancelar la Orden de Servicio?",
        text: "Orden de Servicio " ,
        type: "warning",
        confirmButtonClass: "btn-warning",
        confirmButtonText: "SI",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        animation: "slide-from-top"
    },
    function () {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                axn: 'cancelarOrden',
                skOrdenServicio: core.rowDataTable.skOrdenServicio
            },
            cache: false,
            processData: true,
            beforeSend: function () {
                toastr.info('Cancelar la Orden # '+core.rowDataTable.iFolio, 'Notificación');
            },
            success: function (response) {
                toastr.clear();

                if(!response.success){
                    toastr.error(response.message+ " Folio:" +core.rowDataTable.iFolio, 'Notificación');
                    swal.close();
                    core.dataTable.sendFilters(true);
                    return false;
                }

                toastr.success('Orden de Servicio cancelada con exito # '+core.rowDataTable.iFolio, 'Notificación');
                swal("¡Notificación!", 'Orden de Servicio cancelada con exito# '+core.rowDataTable.iFolio, "success");
                core.dataTable.sendFilters(true);
                 return true;
            }
        });
    });
   
};
admi.orse_form.validations = {
 

};

admi.cofa_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consulta';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'axn': 'consulta',
    'order': [[3, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'E.P', 'data': 'estatusPago', 'dataType': 'string', 'tooltip': 'Estatus Pago', 'filterT': 'Estatus Pago'},
         {'title': 'Folio ', 'filterT': 'Folio ','tooltip': 'Folio ','data': 'iFolio', 'dataType': 'string'},
         {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},

        {'title': 'SubTotal', 'data': 'fSubtotal', 'dataType': 'int'},
        {'title': 'Total', 'data': 'fTotal', 'dataType': 'int'},
         {'title': 'Moneda', 'data': 'skDivisa', 'dataType': 'string'},
        {'title': 'Facturar A', 'data': 'facturacion', 'dataType': 'string'}
 
        
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        core.dataTable.fastFilters(2, [], true);
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIcono) ? $(td).html('<i class="' + rowData.estatusIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
                ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },{
            "targets": [1],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIconoPago) ? $(td).html('<i class="' + rowData.estatusIconoPago + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColorPago) ? rowData.estatusColorPago : 'text-primary'));
                ((rowData.estatusIconoPago) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },
        {
            "targets": [2],
            "width": '30px'
            
        },
        {
            "targets": [3],
            "width": '30px'
            
        }
    ]
}; 


admi.escu_inde = {};

admi.escu_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consulta';
            data.filters = core.dataFilterSend;
        }
    },
    'order': [[1, "asc"]],
    'rowId': 'skEmpresaSocio',
    'columns': [
         {'title': 'E', 'data': 'estatus', 'filterT': 'Estatus','tooltip': 'Estatus', 'dataType': 'string'}, 
        {'title': 'RFC', 'data': 'sRFC', 'dataType': 'string'},
        {'title': 'Razón Social', 'data': 'empresa', 'dataType': 'string'}, 
        {'title': 'Deuda 1 Dias ', 'data': 'fDeuda1Dias', 'dataType': 'string'},
        {'title': 'Deuda 2-15 Dias ', 'data': 'fDeuda2_15Dias', 'dataType': 'string'},
        {'title': 'Deuda 16-30 Dias ', 'data': 'fDeuda16_30Dias', 'dataType': 'string'},
        {'title': 'Deuda 31-45 Dias ', 'data': 'fDeuda31_45Dias', 'dataType': 'string'},
        {'title': 'Deuda +45 Dias ', 'data': 'fDeuda46Dias', 'dataType': 'string'},
        {'title': 'Deuda Total ', 'data': 'fDeudaTotal', 'dataType': 'string'}
    ],
    'axn': 'consulta',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();
        core.dataTable.fastFilters(3, [], true);
    },
    "columnDefs": [
      {
        "targets": [0],
        "width": '20px',
        "createdCell": function (td, cellData, rowData, row, col) {

          ((rowData.estatusIcono) ? $(td).html('<i class="'+rowData.estatusIcono+'"></i>') : $(td).html(cellData));
          $(td).addClass('text-center '+((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
          ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData,"data-toggle": "tooltip","data-placement": "rigth"}) : '');
        }
    },
    {
        "targets": [1],
        "width": '25px' 
    },{
        "targets": [2],
        "width": '25px' 
    }
    ]
};

admi.cofa_suba.validations = {
 

};
admi.cofa_inde.noAplica = function noAplica(obj) {
    swal({
        title: "¿La pre-factura no requiere factura?",
        text: "Factura " ,
        type: "warning",
        confirmButtonClass: "btn-warning",
        confirmButtonText: "SI",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        animation: "slide-from-top"
    },
    function () {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                axn: 'noAplica',
                skFactura: core.rowDataTable.skFactura
            },
            cache: false,
            processData: true,
            beforeSend: function () {
                toastr.info('Guardar factura # '+core.rowDataTable.iFolio, 'Notificación');
            },
            success: function (response) {
                toastr.clear();

                if(!response.success){
                    toastr.error(response.message+ " Folio:" +core.rowDataTable.iFolio, 'Notificación');
                    swal.close();
                    core.dataTable.sendFilters(true);
                    return false;
                }

                toastr.success('Factura finalizada con exito# '+core.rowDataTable.iFolio, 'Notificación');
                swal("¡Notificación!", 'Factura finalizada con exirto# '+core.rowDataTable.iFolio, "success");
                core.dataTable.sendFilters(true);
                 return true;
            }
        });
    });
   
};