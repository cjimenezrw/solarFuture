var conc = {};

conc.prod_inde = {};

conc.prod_inde.dataTableConf = {
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
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'}
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
        }
    ]
};

conc.prod_form = {};

conc.prod_form.validaciones = {
    sNombre: {
        validators: {
            notEmpty: {
                message: 'DATO REQUERIDO'
            }
        }
    }
};

conc.conc_inde = {};
conc.conc_form = {};

conc.conc_inde.dataTableConf = {
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
        {'title': 'CODIGO', 'data': 'sCodigo', 'dataType': 'string','tooltip': 'CODIGO'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Proveedor', 'data': 'proveedor', 'dataType': 'string'},
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

conc.conc_form.validaciones = {
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

conc.inve_inde = {};
conc.inve_inde.dataTableConf = {
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
        {'title': 'CODIGO', 'data': 'sCodigo', 'dataType': 'string','tooltip': 'CODIGO'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Usuario Creacion', 'data': 'usuarioCreacion', 'dataType': 'string'},
        {'title': 'F. Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Proveedor', 'data': 'proveedor', 'dataType': 'string'},
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