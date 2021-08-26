var docu = {};

docu.expe_inde = {};
docu.expe_form = {};

docu.expe_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consultar';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'axn': 'consultar',
    'order': [[4, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'skTipoExpediente', 'data': 'skTipoExpediente', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'}
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(1, 'success');
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
};

docu.expe_form.validaciones = {
    /*skTipoExpediente: {
        validators: {
            notEmpty: {
                message: 'DATO REQUERIDO'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'DATO REQUERIDO'
            }
        }
    },
    sDescripcion: {
        validators: {
            notEmpty: {
                message: 'DATO REQUERIDO'
            }
        }
    }*/
};