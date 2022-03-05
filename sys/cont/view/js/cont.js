var cont = {};

// DEFINICIÓN DE VARIABLES DE MÓDULO //
cont.cont_inde = {};
cont.cont_form = {};

// FUNCIONES //

// cont.cont_inde //
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
    'order': [[8, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'Folio', 'data': 'iFolio', 'dataType': 'int','tooltip': 'Folio'},
        {'title': 'T.C.', 'data': 'tipoContrato', 'dataType': 'string', 'tooltip': 'Tipo de Contrato', 'filterT': 'Tipo de Contrato'},
        {'title': 'Cliente', 'data': 'cliente', 'dataType': 'string'},
        {'title': 'Domicilio', 'data': 'sDomicilio', 'dataType': 'string'},
        {'title': 'F. Instalación', 'data': 'dFechaInstalacion', 'dataType': 'date', 'tooltip': 'Fecha de Instalación', 'filterT': 'Fecha de Instalación'},
        {'title': 'F. Mantenimiento', 'data': 'dFechaProximoMantenimiento', 'dataType': 'date', 'tooltip': 'Fecha de Mantenimiento', 'filterT': 'Fecha de Mantenimiento'},
        {'title': 'U. Creación', 'data': 'usuarioCreacion', 'filterT': 'Usuario de Creación', 'tooltip': 'Usuario de Creación', 'dataType': 'string'},
        {'title': 'F. Creación', 'data': 'dFechaCreacion', 'dataType': 'date', 'tooltip': 'Fecha de Creación', 'filterT': 'Fecha de Creación'}
    ],

    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(1, 'success');
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
        },
        {
            "targets": [1,2],
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
    sCorreo: {
        validators: {
            callback: {
                message: 'CORREO NO VALIDO',
                callback: function (input) {
                    var RegExp = /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i;
                    if (input != '' && !RegExp.exec(input)) {
                        return false;
                    }
                    return true;
                }
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
 