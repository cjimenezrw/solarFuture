var empr = {};

empr.empr_inde = {};
empr.tipo_inde = {};
empr.tipo_form = {}; 


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

empr.pros_inde = [];
empr.pros_inde.dataTableConf = {
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
    'order': [[7, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'estatus', 'dataType': 'string', 'tooltip': 'Estatus', 'filterT': 'Estatus'},
        {'title': 'Folio', 'data': 'iFolioProspecto', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombreContacto', 'dataType': 'string'},
        {'title': 'Empresa', 'data': 'sEmpresa', 'dataType': 'string'},
        {'title': 'Correo', 'data': 'sCorreo', 'dataType': 'string'},
        {'title': 'Teléfono', 'data': 'sTelefono', 'dataType': 'string'},
        {'title': 'U.Creación', 'data': 'usuarioCreacion', 'dataType': 'string', 'tooltip': 'Usuario Creación'},
        {'title': 'F.Creación', 'data': 'dFechaCreacion', 'tooltip': 'Fecha Creación', 'dataType': 'date'}
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
        }
    ]
};

empr.pros_form = [];
empr.pros_form.validaciones = {
    sNombreContacto: {
        validators: {
            notEmpty: {
                message: 'Este dato el requerido'
            }
        }
    },
    sCorreo: {
        validators: {
            notEmpty: {
                message: 'Este dato el requerido'
            }
        }
    },
    sTelefono: {
        validators: {
            notEmpty: {
                message: 'Este dato el requerido'
            }
        }
    }
};