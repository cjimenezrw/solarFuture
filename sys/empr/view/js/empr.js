var empr = {};

/*
 * Módulo usua-inde (consulta-usuarios)
 */
empr.suem_inde = {};
empr.suem_form = {};
empr.grup_inde = {};
empr.grup_form = {};
empr.empr_inde = {};
empr.tipo_inde = {};
empr.prom_inde = {};
empr.prom_form = {};
empr.tipo_form = {};
empr.asem_form = {};
empr.esrv_form = {};
empr.esrv_inde = {};
empr.asem = {};
empr.esrv = {};

empr.suem_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getSucursales';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[2, "desc"]],
    'rowId': 'skSucursal',
    'columns': [

        {'title': 'contextM', 'tooltip': 'Estatus', 'data': 'menuEmergente', 'dataType': 'hidde', 'hiddenF': '', 'excluirExcel': true},
        {'title': 'E', 'filterT': 'Estatus', 'data': 'Estatus', 'dataType': 'string'},
        {'title': 'Código', 'data': 'skSucursal', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Nombre Corto', 'data': 'sNombreCorto', 'dataType': 'string'}
    ],
    'axn': 'getSucursales',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();

    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": false
        },
        {
            "targets": [1],
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "Inactivo":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
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
            "targets": [1],
            "width": '20px'
        },
        {
            "targets": [2],
            "width": '100px'
        }
    ]
};

/**
 * Módulo consulta de configuraciones de días de almacenajes clientes y recintos (dacr-inde)
 *
 * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
 */
empr.dacr_inde = {};

empr.dacr_inde.dataTableConf = {
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
    'axn': 'dacr_inde',
    'rowId': 'skEmpresaSocioCliente',
    'order': [[1, "desc"]],
    'columns': [
        {'title': 'E', 'filterT': 'Estatus', 'tooltip': 'Estatus', 'data': 'estatus', 'dataType': 'string'},
        {'title': 'Cliente', 'data': 'sNombreCorto', 'dataType': 'string'},
        {'title': 'RFC', 'data': 'sRFC', 'dataType': 'string'}

    ],
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(1, 'success');
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "width": '1px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-info text-center');
                        $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"});
                        break;
                    case "Eliminado":
                        $(td).html('<i class="fa fa-ban"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({"title": cellData, "data-toggle": "tooltip", "data-placement": "rigth"});
                        break;
                    default:

                }

            }
        }
    ]
};

/**
 * Módulo formulario de configuraciones de días de almacenajes clientes y recintos (dacr-form)
 *
 * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
 */
empr.dacr_form = {};

empr.dacr_form.validations = {
    skEmpresaSocio: {
        validators: {
            notEmpty: {
                message: 'Este campo es obligatorio.'
            },
            remote: {
                url: window.location.href,
                type: 'POST',
                data: {
                    axn: 'validarConfiguracion'
                },
                message: 'El cliente ya está configurado.'
            }
        }
    }
};

/*
 * Módulo suem-form (sucursales-empresas)
 */
empr.suem_form = {};

empr.suem_form.validaciones = {
    skSucursal: {
        threshold: 4,
        validators: {
            notEmpty: {
                message: 'El codigo es requerido'
            },
            remote: {
                url: window.location.href,
                data: {
                    axn: 'validarCodigo'
                },
                message: 'El codigo ya existe',
                type: 'POST'
            },
            stringCase: {
                message: 'Solo letras mayusculas',
                'case': 'upper'
            }
        }

    },
    skEstatus: {
        validators: {
            notEmpty: {
                message: 'Seleccione un estatus'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'El nombre es requerido'
            }
        }
    },
    sNombreCorto: {
        validators: {
            notEmpty: {
                message: 'El nombre corto es requerido'
            }
        }
    }
};

/*
 * Módulo empr-inde (consulta-empresas)
 */


empr.empr_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getEmpresas';
            data.filters = core.dataFilterSend;
        }
    },
    'order': [[3, "desc"]],
    'rowId': 'skEmpresa',
    'columns': [
        {'title': 'contextM', 'data': 'menuEmergente', 'tooltip': 'Estatus', 'dataType': 'hidde', 'hiddenF': '', 'excluirExcel': true},
        {'title': 'E', 'data': 'estatus', 'filterT': 'Estatus', 'dataType': 'string', 'excluirExcel': true},
        {'title': 'RFC', 'data': 'sRFC', 'dataType': 'string'},
        {'title': 'Fecha Creación', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Nombre Corto', 'data': 'sNombreCorto', 'dataType': 'string'}
    ],
    'axn': 'getEmpresas',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": false
        },
        {
            "targets": [1],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "Inactivo":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    default:

                }

            }
        }
    ]
};

/*
 * Módulo emso-inde (consulta-empresas-socios)
 */
empr.emso_inde = {};

empr.emso_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getEmpresasSocios';
            data.filters = core.dataFilterSend;
        }
    },
    'order': [[3, "desc"]],
    'rowId': 'skEmpresaSocio',
    'columns': [
        {'title': 'contextM', 'data': 'menuEmergente', 'tooltip': 'Estatus', 'dataType': 'hidde', 'hiddenF': '', 'excluirExcel': true},
        {'title': 'E', 'data': 'estatus', 'filterT': 'Estatus', 'dataType': 'string', 'excluirExcel': true},
        {'title': 'RFC', 'data': 'sRFC', 'dataType': 'string'},
        {'title': 'Fecha Creación', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Empresa', 'data': 'empresa', 'dataType': 'string'},
        {'title': 'Nombre Corto', 'data': 'sNombreCorto', 'dataType': 'string'},
        {'title': 'Tipo', 'data': 'empresaTipo', 'dataType': 'string'},
        {'title': 'Propietario', 'data': 'empresaPropietario', 'dataType': 'string'}
    ],
    'axn': 'getEmpresasSocios',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": false
        },
        {
            "targets": [1],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "Inactivo":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    default:

                }

            }
        }
    ]
};

/*
 * Módulo emso-inde (agregar-empresas-socios)
 */
empr.emso_form = {};

empr.emso_form.getEmpresaSocio = function getEmpresaSocio(obj) {
    $("#skEmpresa").val('');
    $("#skEmpresaTipo").val('');
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            axn: 'validarEmpresaSocio',
            sRFC: $(obj).val()
        },
        cache: false,
        processData: true,
        success: function (data) {
            if (data.skEmpresa) {
                $("#sNombre").val('');
                $("#sNombreCorto").val('');
                $("#skEmpresaTipo").val('');

                $("#skEmpresa").val(data.skEmpresa);
                $("#sNombre").val(data.sNombre);
                $("#sNombreCorto").val(data.sNombreCorto);
            }
        }
    });
};

// Características EmpresasSocios //
empr.emso_form.change_skEmpresaTipo = function change_skEmpresaTipo(obj) {

    if ($(obj).val() == 'CLIE'){
        $(".corresponsal").show();
        $('#skClienteCorresponsal').attr('name', 'skClienteCorresponsal');
    }else {
        $(".corresponsal").hide();
        $('#skClienteCorresponsal').removeAttr('name');
    }

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            axn: 'rel_caracteristica_empesaTipo',
            skEmpresaTipo: $(obj).val()
        },
        async: true,
        cache: false,
        processData: true,
        success: function (data) {
            if (data) {
                var cad = '';
                var key_autocomplete2 = [];
                $.each(data, function (k, v) {
                    switch (v.skCaracteristicaTipo) {
                        case 'LI':
                            cad += '<div class="col-md-12">' +
                                    '<label class="col-md-2 control-label"><b>' + v.sNombre + ':</b> </label>' +
                                    '<div class="form-group col-md-3">' +
                                    '<input class="form-control" maxlength="500" id="' + v.skCaracteristicaEmpresaSocio + '" name="skCaracteristicaEmpresaSocio[' + v.skCaracteristicaEmpresaSocio + ']" value="' + v.sValorDefault + '" placeholder="' + v.sNombre + '" autocomplete="off" type="text">' +
                                    '</div>' +
                                    '</div>';
                            break;
                        case 'OP':
                            var selected = (v.sValorDefault != '') ? ' selected="selected" ' : ' ';
                            var option = (v.sValorDefault != '' && v.sCatalogoNombreDefault != '') ? ' <option value="' + v.sValorDefault + '" ' + selected + '>' + v.sValorDefault + '</option>' : ' ';
                            var option = ' ';
                            cad += '<div class="col-md-12">' +
                                    '<label class="col-md-2 control-label"><b>' + v.sNombre + ':</b> </label>' +
                                    '<div class="form-group col-md-3">' +
                                    '<select id="' + v.skCaracteristicaEmpresaSocio + '" name="skCaracteristicaEmpresaSocio[' + v.skCaracteristicaEmpresaSocio + ']" data-plugin="select2" data-ajax--cache="true">' +
                                    option +
                                    '</select>' +
                                    '</div>' +
                                    '</div>';
                            key_autocomplete2.push({
                                skCaracteristicaEmpresaSocio: v.skCaracteristicaEmpresaSocio,
                                sNombre: v.sNombre,
                                sCatalogo: v.sCatalogo,
                                sCatalogoKey: v.sCatalogoKey,
                                sCatalogoNombre: v.sCatalogoNombre
                            });
                            break;
                        case 'DE':
                            var checked = (v.sValorDefault != '') ? ' checked ' : ' ';
                            cad += '<div class="form-group col-md-12">' +
                                    '<label class="col-md-2 control-label"><b>' + v.sNombre + ':</b> </label>' +
                                    '<div class="col-md-3">' +
                                    '<div class="checkbox-custom checkbox-primary">' +
                                    '<input id="' + v.skCaracteristicaEmpresaSocio + '" value="1"' +
                                    'name="skCaracteristicaEmpresaSocio[' + v.skCaracteristicaEmpresaSocio + ']"' + checked +
                                    'type="checkbox">' +
                                    '<label for="' + v.skCaracteristicaEmpresaSocio + '"></label>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                            break;
                        default:

                    }
                });
                $("#rel_caracteristica_empesaTipo").html(cad);
                $.each(key_autocomplete2, function (k, v) {
                    core.autocomplete2('#' + v.skCaracteristicaEmpresaSocio, 'getCaracteristicaCatalogo', window.location.href + '?sCatalogo=' + v.sCatalogo + '&sCatalogoKey=' + v.sCatalogoKey + '&sCatalogoNombre=' + v.sCatalogoNombre, v.sNombre);
                });
            }
        }
    });
};

empr.emso_form.validaciones = {

    sRFC: {
        threshold: 10,
        validators: {
            notEmpty: {
                message: 'El RFC es requerido.'
            },
            remote: {
                url: window.location.href,
                type: 'POST',
                data: function (validator, $field, value) {
                    return {
                        axn: 'validarEmpresaSocio',
                        skEmpresaTipo: $('#skEmpresaTipo').val()
                    };
                },
                message: 'El RFC ya ha sido dado de alta anteriormente.'
            },
            regexp: {
                message: 'El RFC NO valido.',
                regexp: /^[A-Z]{3,4}([0-9]{2})(1[0-2]|0[1-9])([0-3][0-9])([ -]?)([A-Z0-9]{3})$/
            },
            stringCase: {
                message: 'El RFC debe de estar en Mayúsculas.',
                'case': 'upper'
            }
        }
    },
    skEstatus: {
        validators: {
            notEmpty: {
                message: 'Seleccione un estatus.'
            }
        }
    },
    skEmpresaTipo: {
        validators: {
            notEmpty: {
                message: 'Seleccione un tipo de empresa.'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'El nombre es requerido.'
            }
        }
    }

};

empr.emso_form.revalidarFormulario = function revalidarFormulario() {
    $('#core-guardar').formValidation('revalidateField', 'sRFC');
};

/*
 * Módulo grup-inde (grupos-empresas)
 */
empr.grup_inde = {};

empr.grup_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getGrupos';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[2, "desc"]],
    'rowId': 'skGrupo',
    'columns': [

        {'title': 'contextM', 'tooltip': 'Estatus', 'data': 'menuEmergente', 'dataType': 'hidde', 'hiddenF': '', 'excluirExcel': true},
        {'title': 'E', 'filterT': 'Estatus', 'data': 'skEstatus', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Fecha de creación', 'data': 'dFechaCreacion', 'dataType': 'date'}
    ],
    'axn': 'getGrupos',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();

    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": false
        },
        {
            "targets": [1],
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "AC":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "IN":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
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
            "targets": [1],
            "width": '20px'
        },
        {
            "targets": [2],
            "width": '100px'
        }
    ]
};
empr.prom_form.validaciones = {
    skEstatus: {
        validators: {
            notEmpty: {
                message: 'Seleccione un estatus'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'El nombre es requerido'
            }
        }
    }
};
empr.prom_inde.dataTableConf = {

    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'consultarPromotores';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[1, "desc"]],
    'rowId': 'skPromotor',
    'columns': [

        {'title': 'E', 'filterT': 'Estatus', 'data': 'skEstatus', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Correo', 'data': 'sCorreo', 'dataType': 'string'},
        {'title': 'Fecha Creación', 'data': 'dFechaCreacion', 'dataType': 'date'}
    ],
    'axn': 'getTiposEmpresas',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();

    },
    "columnDefs": [


        {
            "targets": [0],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "AC":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": 'Activo',
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "IN":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({
                            "title": 'Inactivo',
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    default:

                }

            }
        }
    ]
};

empr.tipo_inde.dataTableConf = {

    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getTiposEmpresas';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[2, "desc"]],
    'rowId': 'skGrupo',
    'columns': [

        {'title': 'contextM', 'tooltip': 'Estatus', 'data': 'menuEmergente', 'dataType': 'hidde', 'hiddenF': '', 'excluirExcel': true},
        {'title': 'E', 'filterT': 'Estatus', 'data': 'skEstatus', 'dataType': 'string'},
        {'title': 'Codigo', 'data': 'skEmpresaTipo', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'}
    ],
    'axn': 'getTiposEmpresas',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();

    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": false
        },

        {
            "targets": [1],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "AC":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": 'Activo',
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "IN":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({
                            "title": 'Inactivo',
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
            "width": '100px'
        }
    ]
};
empr.tipo_form.validaciones = {
    skEstatus: {
        validators: {
            notEmpty: {
                message: 'Seleccione un estatus'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'El nombre es requerido'
            }
        }
    },
    skEmpresaTipo: {
        threshold: 4,
        validators: {
            notEmpty: {
                message: 'El codigo es requerido'
            },
            remote: {
                url: window.location.href,
                data: {
                    axn: 'validarCodigo'
                },
                message: 'El codigo ya existe',
                type: 'POST'
            },
            stringCase: {
                message: 'Solo letras mayusculas',
                'case': 'upper'
            }
        }
    }
};
/*
 * Módulo grup-form (registro-de-grupos)
 */
empr.grup_form = {};

empr.grup_form.validaciones = {
    skEstatus: {
        validators: {
            notEmpty: {
                message: 'Seleccione un estatus'
            }
        }
    },
    sNombre: {
        validators: {
            notEmpty: {
                message: 'El nombre es requerido'
            }
        }
    }

};

empr.soem_inde = {};
empr.soem_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getSolicitudesEmpresas';
            data.filters = core.dataFilterSend;
        }
    },
    'order': [[3, "desc"]],
    'rowId': 'skEmpresaSocio',
    'columns': [
        {'title': 'contextM', 'data': 'menuEmergente', 'tooltip': 'Estatus', 'dataType': 'hidde', 'hiddenF': '', 'excluirExcel': true},
        {'title': 'E', 'data': 'Estatus', 'filterT': 'Estatus', 'dataType': 'string', 'excluirExcel': true},
        {'title': 'RFC', 'data': 'sRFC', 'dataType': 'string'},
        {'title': 'Empresa', 'data': 'sRazonSocial', 'dataType': 'string'},
        {'title': 'Nombre Corto', 'data': 'sAlias', 'dataType': 'string'},
        {'title': 'Tipo', 'data': 'TipoEmpresa', 'dataType': 'string'},
        {'title': 'Fecha Creación', 'data': 'dFechaCreacion', 'dataType': 'date'}
    ],
    'axn': 'getEmpresasSocios',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": false
        },
        {
            "targets": [1],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "Inactivo":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    default:

                }

            }
        }
    ]
};

empr.soem_form = {};
empr.soem_form.validaciones = {

    sRFC: {
        threshold: 10,
        validators: {
            notEmpty: {
                message: 'El RFC es requerido.'
            },
            remote: {
                url: window.location.href,
                type: 'POST',
                data: function (validator, $field, value) {
                    return {
                        axn: 'validarEmpresaSocio',
                        skEmpresaTipo: $('#skEmpresaTipo').val()
                    };
                },
                message: 'El RFC ya ha sido dado de alta anteriormente.'
            },
            regexp: {
                message: 'El RFC NO valido.',
                regexp: /^[A-Z]{3,4}([0-9]{2})(1[0-2]|0[1-9])([0-3][0-9])([ -]?)([A-Z0-9]{3})$/
            },
            stringCase: {
                message: 'El RFC debe de estar en Mayúsculas.',
                'case': 'upper'
            }
        }
    },
    skEmpresaTipo: {
        validators: {
            notEmpty: {
                message: 'Seleccione un tipo de empresa.'
            }
        }
    },
    sRazonSocial: {
        validators: {
            notEmpty: {
                message: 'Escriba el nombre de la empresa.'
            }
        }
    }
};

empr.soem = {};
empr.soem.apobar = function (obj) {

    $.ajax({
        url: window.location.href,
        type: 'POST',
        global: false,
        data: {
            axn: 'solInfo',
            skSolicitudEmpresa: obj.id
        },
        cache: false,
        processData: true,
        success: function (r) {

            if (r.success) {
                swal({
                    title: "¿Desea aprobar esta solicitud?",
                    text: "Se registrará la empresa " + r.data.sRazonSocial + " como tipo " +r.data.TipoEmpresa,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Aprobar",
                    closeOnConfirm: false
                },
                function () {
                    $.ajax({
                        url: window.location.href,
                        type: 'POST',
                        global: false,
                        data: {
                            axn: 'aprobar',
                            id: obj.id
                        },
                        cache: false,
                        processData: true,
                        success: function (response) {
                            if (response.success) {
                                swal("¡Listo!", "La solicitud se ha sido aprobada", "success");
                                core.dataTable.sendFilters(true);
                                return true;
                            }
                            swal("¡Error!", response.message, "error");
                        }
                    });

                });
            }else{
                toastr.error("Su solicitud no puede ser procesada ahora.");

            }
        }
    });



};
empr.soem.rechazar = function (obj) {
    swal({
        title: "¡Advertencia!",
        text: "¿Esta seguro que desea rechazar esta solicitud?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, rechazar",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    global: false,
                    data: {
                        axn: 'rechazar',
                        id: obj.id
                    },
                    cache: false,
                    processData: true,
                    success: function (response) {
                        if (response.success) {
                            swal("¡Listo!", "La solicitud se ha rechazado", "success");
                            core.dataTable.sendFilters(true);
                            return true;
                        }
                        swal("¡Error!", response.message, "error");
                    }
                });

            });
};

empr.esrv_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getServicios';
            data.filters = core.dataFilterSend;
        }
    },
    'order': [[3, "desc"]],
    'rowId': 'skServicio',
    'columns': [
        {'title': 'contextM', 'data': 'menuEmergente', 'tooltip': 'Estatus', 'dataType': 'hidde', 'hiddenF': '', 'excluirExcel': true},
        {'title': 'E', 'data': 'sEstatus', 'dataType': 'string', 'filterT': 'Estatus'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Fecha Creación', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Usuario Creador', 'data': 'sUsuarioCreacion', 'dataType': 'string'},
        {'title': 'Descripcion', 'data': 'sDescripcion', 'dataType': 'string'}
    ],
    'axn': 'getServicios',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(2, 'success');
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": false
        },
        {
            "targets": [1],
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "Eliminado":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    default:
                }
            }
        }
    ]
};

empr.esrv_form.validaciones = {

};
/* Módulo de consulta de configuración de correos de Empresas (coem-inde) */
empr.coem_inde = {};

empr.coem_inde.dataTableConf = {
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
    'rowId': 'skEmpresaSocio',
    'order': [[4, "ASC"]],
    'columns': [
        {'title': 'E', 'filterT': 'Estatus', 'tooltip': 'Estatus', 'data': 'estatus', 'dataType': 'string'},
        {'title': 'T.Correos', 'data': 'totalCorreos', 'dataType': 'string', 'tooltip': 'Total Correos'},
        {'title': 'T.Empresa', 'data': 'tipoEmpresa', 'dataType': 'string', 'tooltip': 'Tipo Empresa'},
        {'title': 'RFC', 'data': 'sRFC', 'dataType': 'string'},
        {'title': 'Razón Social', 'data': 'cliente', 'dataType': 'string'}
    ],
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(3, 'success');
        $('[data-toggle="tooltip"]').tooltip();
    },
    "columnDefs": [
        {
            "targets": [1,2,3],
            "width": '1px',
            "createdCell": function (td, cellData, rowData, row, col) {
                $(td).addClass('text-center');
            }
        },
        {
            "targets": [0],
            "width": '1px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({"title": cellData,"data-toggle": "tooltip","data-placement": "rigth"});
                        break;
                    default:

                }
            }
        }
    ]
};

/* Módulo de formulario de programaciones de lámina (prog-form) */
empr.coem_form = {};

empr.coem_form.validations = {
    empresa: {
        validators: {
            notEmpty: {
                message: 'Este campo es obligatorio.'
            },
            remote: {
                url: window.location.href,
                type: 'POST',
                data: {
                    axn: 'validarConfiguracion'
                },
                message: 'La empresa ya cuenta con una configuración.'
            }

        }
    }
};

empr.coem_form.changeEmpresa = function changeEmpresa(obj){
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            axn : 'getEmpresas',
            skEmpresaSocio : obj.value
        },
        cache: false,
        beforeSend: function () {
            $('#recinto').css('display','none');
            $('.copiaSimple').css('display','none');
            toastr.info('Cargando Datos <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
        },
        success: function (response) {
            toastr.clear();

            if(!response){
                toastr.error(response.message, 'Notificación');
            }

            if(response[0].skEmpresaTipo == 'CLIE'){
                $('.skEmpresaTipo').css('display','block');
            }else{
                $('.skEmpresaTipo').css('display','none');
            }
        }
    });
};
