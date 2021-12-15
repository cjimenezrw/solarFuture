var cita = {};

// DEFINICIÓN DE VARIABLES DE MÓDULO //
cita.cita_inde = {};
cita.cita_form = {};

// CÓDIGO //

cita.cita_inde.dataTableConf = {
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
    'order': [[17, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'Folio', 'data': 'iFolioCita', 'dataType': 'string','tooltip': 'Folio'},
        {'title': 'Categoría', 'data': 'sNombreCategoria', 'dataType': 'string','tooltip': 'Categoría'},
        {'title': 'F. Cita', 'data': 'dFechaCita', 'dataType': 'date','tooltip': 'Fecha Cita', 'filterT': 'Fecha Cita'},
        {'title': 'H. Cita', 'data': 'tHoraInicio', 'dataType': 'string','tooltip': 'Hora Cita', 'filterT': 'Hora Cita'},
        {'title': 'Cliente', 'data': 'empresaCliente', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Teléfono', 'data': 'sTelefono', 'dataType': 'string'},
        {'title': 'Correo', 'data': 'sCorreo', 'dataType': 'string'},
        {'title': 'Estado', 'data': 'estado', 'dataType': 'string'},
        {'title': 'Municipio', 'data': 'municipio', 'dataType': 'string'},
        {'title': 'Dirección', 'data': 'sDomicilio', 'dataType': 'string'},
        {'title': 'Observaciones', 'data': 'sObservaciones', 'dataType': 'string'},
        {'title': 'Intrucción Servicio', 'data': 'sInstruccionesServicio', 'dataType': 'string'},
        {'title': 'U. Confirmación', 'data': 'usuarioConfirmacion', 'dataType': 'string', 'tooltip': 'Usuario Confirmación', 'filterT': 'Usuario Confirmación'},
        {'title': 'F. Confirmación', 'data': 'dFechaConfirmacion', 'dataType': 'date', 'tooltip': 'Fecha Confirmación', 'filterT': 'Fecha Confirmación'},
        {'title': 'U. Creación', 'data': 'usuarioCreacion', 'dataType': 'string', 'tooltip': 'Usuario Creación', 'filterT': 'Usuario Creación'},
        {'title': 'F. Creación', 'data': 'dFechaCreacion', 'dataType': 'date', 'tooltip': 'Fecha Creación', 'filterT': 'Fecha Creación'}
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
            "width": '10px',
            "createdCell": function (td, cellData, rowData, row, col) {
                ((rowData.estatusIcono) ? $(td).html('<i class="' + rowData.estatusIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusColor) ? rowData.estatusColor : 'text-primary'));
                ((rowData.estatusIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');
            }
        },
        {
            "targets": [1],
            "width": '10px'
        }
    ]
};

cita.cita_form.validaciones = {
    skCategoriaCita: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    dFechaCita: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    tHoraInicio: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    sTelefono: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    sCorreo: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    skEstadoMX: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    skMunicipioMX: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    sDomicilio: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    }
};