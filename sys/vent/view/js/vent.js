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
         {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
         {'title': 'Total', 'data': 'fImporteTotal', 'dataType': 'string'},
         {'title': 'Moneda', 'data': 'skDivisa', 'dataType': 'string'},
        {'title': 'F. Vigencia', 'data': 'dFechaVigencia', 'dataType': 'date'},
        {'title': 'Cliente', 'data': 'cliente', 'dataType': 'string'}
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
vent.vent_coti.validaciones = {};

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