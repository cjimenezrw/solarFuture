var vent = {};

vent.coti_inde = {};
vent.coti_form = {};

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
    'order': [[3, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'Folio', 'data': 'iFolio', 'dataType': 'string','tooltip': 'Folio'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'},
         {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
         {'title': 'Total', 'data': 'fTotal', 'dataType': 'string'},
         {'title': 'Moneda', 'data': 'skMoneda', 'dataType': 'string'},
        {'title': 'F. Vigencia', 'data': 'dFechaVigencia', 'dataType': 'date'},
        {'title': 'Proveedor', 'data': 'cliente', 'dataType': 'string'},
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
}

vent.coti_form.validaciones = {
    skDivisa: {
        validators: {
            notEmpty: {
                message: 'La divisa es Requerida'
            }
        }
    } 

};