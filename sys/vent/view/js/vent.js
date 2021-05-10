var vent = {};

vent.coti_inde = {};
vent.coti_form = {};
vent.vent_coti = {};

vent.coti_inde.dataTableConf = {
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
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'Folio', 'data': 'iFolio', 'dataType': 'string','tooltip': 'Folio'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Cliente', 'data': 'cliente', 'dataType': 'string'},
         {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
         {'title': 'Total', 'data': 'fImporteTotal', 'dataType': 'string'}
        
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

vent.coti_inde.visualizarCotizacionPDF = function visualizarCotizacionPDF(obj){
    window.open(core.SYS_URL+'sys/vent/coti-deta/detalle-cotizacion/'+obj.id+'/?axn=formatoPDF');
    return true;
};

vent.coti_inde.descargarCotizacionPDF = function descargarCotizacionPDF(obj){
    core.download(window.location.href,'GET', {
        axn: 'cotizacionPDF',
        id: obj.id
    });
    return true;
};



vent.coti_form.validaciones = {
    skDivisa: {
        validators: {
            notEmpty: {
                message: 'La divisa es Requerida'
            }
        }
    } 

}; 

vent.coti_inde.clonar = function clonar(obj) {
  
    $.ajax({
        url: '/sys',
        type: 'POST',
        data: {
            axn: 'clonar',
            skCotizacion: $(obj).val()
        },
        cache: false,
        processData: true,
        success: function (data) {
             
        }
    });
};

vent.coti_inde.cancelarVenta = function cancelarVenta(obj) {
    swal({
        title: "¿Desea cancelar la venta?",
        text: "Cotizacion  # "+core.rowDataTable.iFolio+" " ,
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
                axn: 'cancelarVenta',
                skCotizacion: core.rowDataTable.skCotizacion
            },
            cache: false,
            processData: true,
            beforeSend: function () {
                toastr.info('Cancelar la Venta # '+core.rowDataTable.iFolio, 'Notificación');
            },
            success: function (response) {
                toastr.clear();

                if(!response.success){
                    toastr.error(response.message+ " Folio:" +core.rowDataTable.iFolio, 'Notificación');
                    swal.close();
                    core.dataTable.sendFilters(true);
                    return false;
                }

                toastr.success('Venta cancelada con exito # '+core.rowDataTable.iFolio, 'Notificación');
                swal("¡Notificación!", 'Venta cancelada con exito# '+core.rowDataTable.iFolio, "success");
                core.dataTable.sendFilters(true);
                 return true;
            }
        });
    });
   
};