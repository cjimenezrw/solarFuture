var cita = {};

// DEFINICIÓN DE VARIABLES DE MÓDULO //
cita.cita_inde = {};
cita.cita_form = {};
cita.cita_conf = {};
cita.cita_orde = {};
cita.cita_cale = {};

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
    'order': [[16, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'Folio', 'data': 'iFolio', 'dataType': 'string','tooltip': 'Folio'},
        {'title': 'Categoría', 'data': 'sNombreCategoria', 'dataType': 'string','tooltip': 'Categoría'},
        {'title': 'F. Cita', 'data': 'dFechaCita', 'dataType': 'date','tooltip': 'Fecha Cita', 'filterT': 'Fecha Cita'},
        {'title': 'H. Cita', 'data': 'tHoraInicio', 'dataType': 'string','tooltip': 'Hora Cita', 'filterT': 'Hora Cita'},
        {'title': 'Cliente', 'data': 'empresaCliente', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombreCliente', 'dataType': 'string'},
        {'title': 'Teléfono', 'data': 'sTelefono', 'dataType': 'string'},
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
        core.dataTable.fastFilters(6, [], true);
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

cita.cita_inde.finalizar = function finalizar(obj) {
    swal({
        title: "¡Advertencia!",
        text: "¿Está¡ seguro que desea finalizar el registro?",
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Finalizar",
        closeOnConfirm: false,
        inputPlaceholder: "Observaciones"
    },
    function (inputValue) {
        if (inputValue === false) return false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            global: false,
            data: {
                axn: 'finalizar',
                id: obj.id,
                sObservaciones: inputValue
            },
            cache: false,
            processData: true,
            success: function (response) {
                if (response.success) {
                    swal("¡Listo!", "El registro ha sido finalizado con éxito", "success");
                    core.dataTable.sendFilters(true);
                    return true;
                }
                swal("¡Error!", response.message, "error");
            }
        });
    });
};

cita.cita_inde.generarFormato = function generarFormato(obj){
    window.open(core.SYS_URL+'sys/cita/cita-deta/detalles-cita/'+obj.id+'/?axn=formatoPDF');
    return true;
};

cita.cita_inde.descargarPDF = function descargarPDF(obj) {
    core.download(window.location.href,'GET', {
        axn: 'formatoPDF',
        id: obj.id
    });
    return true;
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
    /*sNombreCliente: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },*/
    sTelefono: {
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

cita.cita_conf.validaciones = {
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
    /*sNombreCliente: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },*/
    sTelefono: {
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

cita.cita_orde.validaciones = {
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
    /*sNombreCliente: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },*/
    sTelefono: {
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