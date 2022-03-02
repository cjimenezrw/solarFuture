var cont = {};

// DEFINICIÓN DE VARIABLES DE MÓDULO //
cont.torr_inde = {};
cont.torr_form = {};

cont.acpo_inde = {};
cont.acpo_form = {};

cont.cont_inde = {};
cont.cont_form = {};

// FUNCIONES //

// cont.torr_inde //
cont.torr_inde.dataTableConf = {
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
        {'title': 'MAC', 'data': 'sMAC', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'U. Creación', 'data': 'usuarioCreacion', 'dataType': 'string', 'tooltip': 'Usuario Creación', 'filterT': 'Usuario Creación'},
        {'title': 'F. Creación', 'data': 'dFechaCreacion', 'dataType': 'date', 'tooltip': 'Fecha Creación', 'filterT': 'Fecha Creación'}
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
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

// cont.torr_form //
cont.torr_form.validaciones = {
    sMAC: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            },
            remote:{
                url: window.location.href,
                data: {
                    axn: 'validar_MAC'
                },
                message: 'LA MAC YA HA SIDO REGISTRADA',
                type: 'POST'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    }
};

// cont.acpo_inde //
cont.acpo_inde.dataTableConf = {
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
    'order': [[6, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'MAC', 'data': 'sMAC', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Torre', 'data': 'nombreTorre', 'dataType': 'string'},
        {'title': 'MAC Torre', 'data': 'MACtorre', 'dataType': 'string'},
        {'title': 'U. Creación', 'data': 'usuarioCreacion', 'dataType': 'string', 'tooltip': 'Usuario Creación', 'filterT': 'Usuario Creación'},
        {'title': 'F. Creación', 'data': 'dFechaCreacion', 'dataType': 'date', 'tooltip': 'Fecha Creación', 'filterT': 'Fecha Creación'}
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
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

// cont.acpo_form //
cont.acpo_form.validaciones = {
    sMAC: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            },
            remote:{
                url: window.location.href,
                data: {
                    axn: 'validar_MAC'
                },
                message: 'LA MAC YA HA SIDO REGISTRADA',
                type: 'POST'
            }
        }
    },
    skTorre: {
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
    }
};

cont.cont_inde.dataTableConf = {
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
    'order': [[6, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'E.C.', 'data': 'estatusContrato', 'dataType': 'string', 'tooltip': 'Estatus Contrato', 'filterT': 'Estatus Contrato'},
        {'title': 'Folio', 'data': 'iFolio', 'dataType': 'int','tooltip': 'Folio'},
        {'title': 'Cliente', 'data': 'cliente', 'dataType': 'string'},
        {'title': 'F. Contrato', 'data': 'dFechaInicioContrato', 'dataType': 'string'},
        {'title': 'U. Creación', 'data': 'usuarioCreacion', 'filterT': 'Usuario Creación', 'tooltip': 'Usuario Creación', 'dataType': 'string'},
        {'title': 'F. Creación', 'data': 'dFechaCreacion', 'dataType': 'date', 'tooltip': 'Fecha de Creación', 'filterT': 'Fecha de Creación'}
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        core.dataTable.fastFilters(3, [], true);
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
                ((rowData.estatusContratoIcono) ? $(td).html('<i class="' + rowData.estatusContratoIcono + '"></i>') : $(td).html(cellData));
                $(td).addClass('text-center ' + ((rowData.estatusContratoColor) ? rowData.estatusContratoColor : 'text-primary'));
                ((rowData.estatusContratoIcono) ? $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"}) : '');

            }
        },
        {
            "targets": [2,3],
            "width": '20px'
            
        }
    ]
};

cont.cont_form.validaciones = {
    skEmpresaSocioCliente: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    dFechaInstalacion: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    iFrecuenciaMantenimientoMensual: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    },
    iDiaMantenimiento: {
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
    sDomicilio: {
        validators: {
            notEmpty: {
                message: 'CAMPO REQUERIDO'
            }
        }
    }
};

cont.cont_inde.cancelarContrato = function cancelarContrato(obj) {
    swal({
        title: "¿Desea cancelar el Contrato?",
        text: "Contrato " ,
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
                axn: 'cancelar',
                skContrato: core.rowDataTable.skContrato
            },
            cache: false,
            processData: true,
            beforeSend: function () {
                toastr.info('Cancelar el Contrato # '+core.rowDataTable.iFolio, 'Notificación');
            },
            success: function (response) {
                toastr.clear();

                if(!response.success){
                    toastr.error(response.message+ " Folio:" +core.rowDataTable.iFolio, 'Notificación');
                    swal.close();
                    core.dataTable.sendFilters(true);
                    return false;
                }

                toastr.success('Contrato cancelado con exito # '+core.rowDataTable.iFolio, 'Notificación');
                swal("¡Notificación!", 'Contrato cancelado con exito# '+core.rowDataTable.iFolio, "success");
                core.dataTable.sendFilters(true);
                 return true;
            }
        });
    });
   
};
cont.cont_inde.activarContrato = function activarContrato(obj) {
    swal({
        title: "¿Desea activar el Contrato?",
        text: "Contrato " ,
        type: "success",
        confirmButtonClass: "btn-success",
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
                axn: 'activar',
                skContrato: core.rowDataTable.skContrato
            },
            cache: false,
            processData: true,
            beforeSend: function () {
                toastr.info('Activar el Contrato # '+core.rowDataTable.iFolio, 'Notificación');
            },
            success: function (response) {
                toastr.clear();

                if(!response.success){
                    toastr.error(response.message+ " Folio:" +core.rowDataTable.iFolio, 'Notificación');
                    swal.close();
                    core.dataTable.sendFilters(true);
                    return false;
                }

                toastr.success('Contrato activado con exito # '+core.rowDataTable.iFolio, 'Notificación');
                swal("¡Notificación!", 'Contrato activado con exito# '+core.rowDataTable.iFolio, "success");
                core.dataTable.sendFilters(true);
                 return true;
            }
        });
    });
   
};

cont.cont_inde.generarOrden = function generarOrden(obj) {
    swal({
        title: "¿Desea Generar la orden de cobro?",
        text: "Orden de Cobro " ,
        type: "success",
        confirmButtonClass: "btn-success",
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
                axn: 'generarOrden',
                skContrato: core.rowDataTable.skContrato
            },
            cache: false,
            processData: true,
            beforeSend: function () {
                toastr.info('Generar Orden de cobro del Contrato # '+core.rowDataTable.iFolio, 'Notificación');
            },
            success: function (response) {
                toastr.clear();

                if(!response.success){
                    toastr.error(response.message+ " Folio:" +core.rowDataTable.iFolio, 'Notificación');
                    swal.close();
                    core.dataTable.sendFilters(true);
                    return false;
                }

                toastr.success('Orden de Cobro generada con exito # '+core.rowDataTable.iFolio, 'Notificación');
                swal("¡Notificación!", 'Orden de Cobro generada con exito# '+core.rowDataTable.iFolio, "success");
                core.dataTable.sendFilters(true);
                 return true;
            }
        });
    });
   
};
 