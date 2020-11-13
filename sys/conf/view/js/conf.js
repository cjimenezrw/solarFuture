var conf = {};
 


/*
 * Módulo usua-inde (consulta-usuarios)
 */
conf.usua_inde = {};

conf.usua_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getUsuarios';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[3, "desc"]],
    'columns': [
        {'title': 'E', 'data': 'Estatus', 'tooltip': 'Estatus', 'filterT': 'Estatus', 'dataType': 'string', 'excluirExcel': true},
        {'title': 'A', 'data': 'sTipoUsuario', 'tooltip': 'Administrador', 'dataType': 'string', 'filterT': 'Administrador'},
        {'title': 'Usuario', 'data': 'sUsuario', 'dataType': 'string'},
        {'title': 'Fecha Creación', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Apellido Paterno', 'data': 'sApellidoPaterno', 'dataType': 'string'},
        {'title': 'Apellido Materno', 'data': 'sApellidoMaterno', 'dataType': 'string'},
        {'title': 'Correo', 'data': 'sCorreo', 'dataType': 'string'}

    ],
    'axn': 'getUsuarios',
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
                    case "Activo":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": cellData,
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "Nuevo":
                        $(td).html('<i class="fa fa-certificate"></i>');
                        $(td).addClass('text-info text-center');
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
                    case "Inactivo":
                        $(td).html('<i class="fa fa-ban"></i>');
                        $(td).addClass('text-warning text-center');
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
            "width": '20px',
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "A":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": 'Administrador',
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
 * Módulo usua-form (agregar-usuario)
 */
conf.usua_form = {};

conf.usua_form.validaciones = {
    sUsuario: {
        threshold: 3,
        validators: {
            notEmpty: {
                message: 'El Usuario es requerido'
            },
            remote: {
                url: window.location.href,
                data: {
                    axn: 'validarUsuario'
                },
                message: 'El nombre de Usuario ya Existe',
                type: 'POST'
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
    sApellidoPaterno: {
        validators: {
            notEmpty: {
                message: 'El Apellido Paternos es requerido'
            }
        }
    },
    sApellidoMaterno: {
        validators: {
            notEmpty: {
                message: 'El Apellido Materno es requerido'
            }
        }
    },
    sPassword: {
        validators: {
            securePassword: {
                message: 'La contrase&ntilde;a no es valida'
            }
        }

    },
    sPasswordConfirmar: {
        validators: {}
    },
    sCorreo: {
        validators: {
            notEmpty: {
                message: 'El correo es requerido'
            },
            emailAddress: {
                message: 'No es un correo valido'
            }
        }
    },
};

conf.usua_form.change_skDepartamento = function change_skDepartamento(obj) {

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            axn: 'rel_area_departamento',
            skArea: $(obj).val()
        },
        async: false,
        cache: false,
        processData: true,
        success: function (data) {
            if (data) {
                var cad = '';
                $("#departamento").empty();
                cad += '<select name="skDepartamento" class="form-control">' +
                        '<option value="">Seleccionar</option>';
                $.each(data, function (k, v) {
                    cad += '<option  value="' + v.skDepartamento + '"> ' + v.sNombre + '</option>';
                });
                cad += '</select>';
                $("#departamento").append(cad);

            }

        }
    });

};

conf.usua_form.securePassword = {
    validate: function (validator, $field, options) {
        var value = $field.val();
        if (value === '') {
            return true;
        }

        // Check the password strength
        if (value.length < 8) {
            return {
                valid: false,
                message: 'La contrase&ntilde;a debe tener m&aacute;s de 8 caracteres'
            };
        }

        // The password doesn't contain any uppercase character
        if (value === value.toLowerCase()) {
            return {
                valid: false,
                message: 'La contrase&ntilde;a debe contener al menos un carácter en may&uacute;scula'
            }
        }

        // The password doesn't contain any uppercase character
        if (value === value.toUpperCase()) {
            return {
                valid: false,
                message: 'La contrase&ntilde;a debe contener al menos un car&aacute;cter en min&uacute;scula'
            }
        }

        // The password doesn't contain any digit
        if (value.search(/[0-9]/) < 0) {
            return {
                valid: false,
                message: 'La contrase&ntilde;a debe contener al menos un numero'
            }
        }

        return true;
    }
};

 


/* Módulo de perf-inde (perfiles-de-usuarios)
 *
 */
conf.perf_inde = {};
conf.perf_form = {};

conf.perf_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'obtenerPerfiles';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[3, "desc"]],
    'rowId': 'skPerfil',
    'columns': [
        {'title': 'contextM', 'tooltip': 'Estatus', 'data': 'menuEmergente', 'dataType': 'hidde', 'excluirExcel': true},
        {'title': 'E', 'data': 'Estatus', 'filterT': 'Estatus', 'dataType': 'string'},
        {'title': 'Nombre', 'data': 'sNombre', 'dataType': 'string'},
        {'title': 'Fecha Creacion', 'data': 'dFechaCreacion', 'dataType': 'date'}
    ],
    'axn': 'obtenerPerfiles',
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
 * Módulo hica-inde (historial-de-accesos)
 */
conf.hica_inde = {};
conf.hica_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getAccessHistory';
            data.filters = core.dataFilterSend
        }
    },
    'order': [[2, "desc"]],
    'rowId': 'sIP',
    'columns': [
        {'title': 'E', 'data': 'skEstatus', 'dataType': 'string'},
        {'title': 'Usuario', 'data': 'usuario', 'dataType': 'string'},
        {'title': 'Fecha Creaci&oacute;n', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'skModulo', 'data': 'skModulo', 'dataType': 'string'},
        {'title': 'Modulo', 'data': 'Modulo', 'dataType': 'string'},
        {'title': 'IP', 'data': 'sIP', 'dataType': 'string'}

    ],
    'axn': 'getAccessHistory',
    // "createdRow": function( row, data, dataIndex ) {
    //     if ( data['usuario'] == "Jonathan" ) {
    //         $(row).attr({
    //             "data-toggle": "context",
    //             "data-target": "#context-menu"
    //         });
    //     }
    // },
    "drawCallback": function () {
        core.dataTable.contextMenuCore(false);
        core.dataTable.changeColumnColor(1, 'success');
    },
    "columnDefs": [
        {
            "targets": [0],
            "visible": true
        },
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


/*
 * Módulo hino_inde (historial-de-notificaciones)
 */
conf.hino_inde = {};
conf.hino_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getNotiHistory';
            data.filters = core.dataFilterSend
        }
    },
    'order': [[2, "desc"]],
    'columns': [
        {'title': 'E', 'filterT': 'Estatus', 'data': 'skEstatus', 'tooltip': 'Estatus', 'dataType': 'string'},
        {'title': 'Mensaje', 'data': 'sMensaje', 'dataType': 'string'},
        {'title': 'Url', 'data': 'sUrl', 'dataType': 'string'},
        {'title': 'Modulo', 'data': 'skModulo', 'dataType': 'string'},
        {'title': 'Fecha Creaci&oacute;n', 'data': 'dFechaCreacion', 'dataType': 'date'}
    ],
    'axn': 'getNotiHistory',
    "drawCallback": function () {
        core.dataTable.contextMenuCore(false);
        core.dataTable.changeColumnColor(1, 'success');
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



/*
 * Módulo hiac-inde (historial-de-acciones)
 */
conf.hiac_inde = {};
conf.hiac_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getActionsHistory';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[1, "desc"]],
    'columns': [
        {'title': 'Usuario', 'data': 'usuario', 'dataType': 'string'},
        {'title': 'Fecha', 'data': 'dFechaCreacion', 'dataType': 'date'},
        {'title': 'skModulo', 'data': 'skModulo', 'dataType': 'string'},
        {'title': 'M&oacute;dulo', 'data': 'sTitulo', 'dataType': 'string'},
        {'title': 'skCodigo', 'data': 'skCodigo', 'dataType': 'string'},
        {'title': 'Tabla', 'data': 'sTabla', 'dataType': 'string'},
        {'title': 'Descripci&oacute;n', 'data': 'sDescripcion', 'dataType': 'string'},
        {'title': 'Datos Historial', 'data': 'sDatosHistorial', 'dataType': 'string'}
    ],
    'axn': 'getActionsHistory',
    // "createdRow": function( row, data, dataIndex ) {
    //     if ( data['usuario'] == "Jonathan" ) {
    //         $(row).attr({
    //             "data-toggle": "context",
    //             "data-target": "#context-menu"
    //         });
    //     }
    // },
    "drawCallback": function () {
        core.dataTable.contextMenuCore(false);
        core.dataTable.changeColumnColor(1, 'success');
    },
    "columnDefs": [
        {
            "targets": [1],
            "visible": true
        }
    ]
};

conf.hmsg_inde = {};
conf.hmsg_inde.dataTableConf = {
    'serverSide': true,
    'ajax': {
        'url': window.location.href,
        'type': 'POST',
        'data': function (data) {
            data.axn = 'getAccessMsgHistory';
            data.filters = core.dataFilterSend;
            data.generarExcel = core.generarExcel;
        }
    },
    'order': [[8, "desc"]],
    'columns': [
        {'title': 'E', 'filterT': 'Estatus', 'data': 'skEstatus', 'tooltip': 'Estatus', 'dataType': 'string'},
        {'title': 'D', 'data': 'nDestinatarios', 'dataType': 'string', 'tooltip': 'Destinatarios', 'hiddenF': 'true'},
        {'title': 'Emisor', 'data': 'sEmisor', 'dataType': 'string'},
        {'title': 'F. Envío', 'data': 'dFechaEnvio', 'dataType': 'date', 'tooltip': 'Fecha Envío'},
        {'title': 'Asunto', 'data': 'sAsunto', 'dataType': 'string'},
        {'title': 'Para', 'data': 'sDestinatario', 'dataType': 'string'},
        {'title': 'CC', 'data': 'sCopia', 'dataType': 'string'},
        {'title': 'CCO', 'data': 'sCopiaOculta', 'dataType': 'string'},
         {'title': 'Fecha creación', 'data': 'dFechaCreacion', 'dataType': 'date'}

    ],
    'axn': 'getActionsHistory',
    // "createdRow": function( row, data, dataIndex ) {
    //     if ( data['usuario'] == "Jonathan" ) {
    //         $(row).attr({
    //             "data-toggle": "context",
    //             "data-target": "#context-menu"
    //         });
    //     }
    // },
    "drawCallback": function () {
        core.dataTable.contextMenuCore(true);
        core.dataTable.changeColumnColor(4, 'success');
        $('[data-toggle="tooltip"]').tooltip();
    },
    /*"drawCallback": function () {
     core.dataTable.contextMenuCore(false);
     core.dataTable.changeColumnColor(1, 'success');
     },*/
    "columnDefs": [
        {
            "targets": [0],
            "width": '10px',
            "visible": true,
            "createdCell": function (td, cellData, rowData, row, col) {
                switch (cellData) {
                    case "EN":
                        $(td).html('<i class="fa fa-check"></i>');
                        $(td).addClass('text-success text-center');
                        $(td).find('i').attr({
                            "title": 'Enviado',
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    case "NU":
                        $(td).html('<i class="fa fa-times"></i>');
                        $(td).addClass('text-danger text-center');
                        $(td).find('i').attr({
                            "title": 'No Enviado',
                            "data-toggle": "tooltip",
                            "data-placement": "rigth"
                        });
                        break;
                    default:

                }

            }
        },
        {
            "targets": [1,2,3,4],
            "width": '10px'
        }
    ]
};

/*
 * Módulo toke-form (token-usuario)
 */
conf.toke_form = {};

conf.toke_form.validaciones = {};



conf.perf_form = {};


 
////////////////////////////////////////////////////////
conf.perf_tree = function perf_tree(dataset,ulmaster,inputHiddenName, name) {
    this.ulmaster = ulmaster;
    this.name = name + Math.floor((Math.random() * 10) + 1);
    this.dataset = dataset;
    this.p_set = {};



    this.handler_set = function handler_set() {
        var that = this;

        $('.skWard'+that.name).click(function(event){
            that.skWard_controll($(this));
            event.stopPropagation();
        });

        $('.ward'+that.name).click(function(event){
            that.ward_controll($(this));
            event.stopPropagation();
        });

        $('#skPerfilClonar').change(function(event){
           that.change_clonar($(this));

            event.stopImmediatePropagation();
        });
    };


    this.new_item = function new_item(skModulo, sModuloPadre, sNombre, nivel, ward, p_ward, icon) {

        var that = this;
        var itm_li = $('<li class="list-group-item node-exampleExpandibleTree form-group col-md-12" data-padre="' + sModuloPadre + '" data-skmod="' + skModulo + '">');
        var itm_chkMain = $('<div class="checkbox checkbox-custom checkbox-primary pull-left mainSkdocumento">');
        var itm_chkWard = $('<div class="pull-right ward">');
        var indent = $('<span class="indent">');
        var itm_nivel = '';
        var ward_aviable = {};
        var ward_current = {};
        ward_aviable.W = (!ward.includes('W')) ? ' disabled="disabled"' : '';
        ward_aviable.A = (!ward.includes('A')) ? ' disabled="disabled"' : '';
        ward_aviable.R = (!ward.includes('R')) ? ' disabled="disabled"' : '';
        ward_aviable.D = (!ward.includes('D')) ? ' disabled="disabled"' : '';

        ward_current.W = (p_ward.includes('W')) ? ' checked' : '';
        ward_current.A = (p_ward.includes('A')) ? ' checked' : '';
        ward_current.R = (p_ward.includes('R')) ? ' checked' : '';
        ward_current.D = (p_ward.includes('D')) ? ' checked' : '';

        if (p_ward.length > 0) {
            ward_current.main = 'checked';
        } else {
            ward_current.main = '';
        }

        for (var i = 0; i < nivel; i++) {
            itm_nivel = itm_nivel + '<span class="indent"></span>';
        }


        itm_chkMain.append(
                itm_nivel,
                $('<span class="icon node-icon wb-folder">'),
                indent,
                $('<input class="styled skWard'+that.name+'" type="checkbox" ' + ward_current.main + ' data-skmodulo="' + skModulo + '">'),
                '<label >' + sNombre + '</label>'
                );


        itm_chkWard.append(
                '<div class="checkbox checkbox-custom checkbox-primary wardItemDiv" >' +
                '<input class="styled ward'+that.name+'" type="checkbox"  data-ward="A"  ' + ward_aviable.A + ' ' + ward_current.A + '>' +
                '<label>A</label>' +
                '</div>',
                '<div class="checkbox checkbox-custom checkbox-primary wardItemDiv" >' +
                '<input class="styled ward'+that.name+'" type="checkbox"  data-ward="D"  ' + ward_aviable.D + ' ' + ward_current.D + '>' +
                '<label>D</label>' +
                '</div>',
                '<div class="checkbox checkbox-custom checkbox-primary wardItemDiv" >' +
                '<input class="styled ward'+that.name+'" type="checkbox"  data-ward="W"  ' + ward_aviable.W + ' ' + ward_current.W + '>' +
                '<label>W</label>' +
                '</div>',
                '<div class="checkbox checkbox-custom checkbox-primary wardItemDiv" >' +
                '<input class="styled ward'+that.name+'" type="checkbox" data-ward="R"  ' + ward_aviable.R + ' ' + ward_current.R + '>' +
                '<label>R</label>' +
                '</div>'
                );
        return itm_li.append(itm_chkMain, itm_chkWard);
    };

    this.ancestorActivation = function ancestorActivation(r) {

        if (r !== 'prin-inic' && r.length > 0 && r !== 'mpri-inic' ) {
            //console.info("Estoy en:", r);

            /*Obtenemos su ancestro*/
            var padre = $('li[data-skmod="' + r + '"]').data('padre');

            if (padre === 'prin-inic' ||  r === 'mpri-inic') {
                return;
            }

            // Habilitamos al ancestro
            var jAncent = $('li[data-skmod="' + padre + '"]');
            jAncent.find('.mainSkdocumento').find('input').prop('checked', true);

            // Habilitamos permiso por default as R
            jAncent.find('.ward').find('.wardItemDiv').each(function () {
                var char_ward = $(this).find('input').data('ward');
                if (char_ward === 'R' && $(this).find('input').attr('disabled') !== 'disabled') {
                    $(this).find('input').prop('checked', true);
                }

                if (char_ward === 'W' && $(this).find('input').attr('disabled') !== 'disabled') {
                    $(this).find('input').prop('checked', true);
                }


            });
            return this.ancestorActivation(padre);

        } else {
            return true;
        }
    };

    this.ward_controll = function ward_controll(ref) {

        var skmodCheck = ref.parent().parent().parent().find(".mainSkdocumento").find('input');
        var wardActive = false;
        var mainUL = this.ulmaster;
        var thisSkMod = skmodCheck.data('skmodulo');
        var thisSkPadre = ref.parent().parent().parent().data('padre');

        /*Habilita como Read a todos sus ancestros*/
        //console.info(thisSkMod);
        this.ancestorActivation(thisSkMod);

        /*Selecciona el indicador del modulo si hay permisos seleccionados*/
        ref.parent().parent().find('input').each(function () {
            if ($(this).is(':checked')) {
                wardActive = true;
                return;
            }
        });

        if (wardActive) {
            skmodCheck.prop('checked', true);
        } else {
            skmodCheck.prop('checked', false);
            this.alter_tree(skmodCheck.data('skmodulo'), false);
        }

        /*Agrega banderas en estructura de permisos*/
        if (ref.is(':checked')) {
            this.p_set[skmodCheck.data('skmodulo')][ref.data('ward')] = true;
        } else {
            this.p_set[skmodCheck.data('skmodulo')][ref.data('ward')] = false;
        }

        this.update_p_set();
        return;
    };

    this.skWard_controll = function skWard_controll(ref) {
        conf.perf_form.testing = ref;
        var father = ref.parent().parent();
        var mainUl = father.parent();
        var fatherName = ref.data('skmodulo');


        ref.parent().parent().find('.ward').find('.wardItemDiv>input').each(function () {
            if ($(this).attr('disabled') !== 'disabled') {
                $(this).prop('checked', ref.is(':checked'));
            }

        });

        //this.ancestorActivation
        if (ref.is(':checked')) {

            this.ancestorActivation(ref.data('skmodulo'));
        }
        // Matar desendenca
        this.alter_tree(ref.data('skmodulo'), ref.is(':checked'));

        this.update_p_set();
        return;
    };

    this.alter_tree = function alter_tree(ref, action) {


        var black_list = this.tree_iterator(ref);
        for (var i = 0; i < black_list.length; i++) {
            var objetive = $('li[data-skmod="' + black_list[i] + '"]');

            // deselec main
            objetive.find('.mainSkdocumento>input').prop('checked', action);

            //deselect wards
            objetive.find('.ward').find('input').each(function () {
                if ($(this).attr('disabled') !== 'disabled') {
                    $(this).prop('checked', action);
                }

            });
        }
    };

    this.tree_iterator = function tree_iterator(starter) {
        var brute_list = [];
        var scaner = function (skModRef) {

            var r = $('li[data-padre="' + skModRef + '"]');
            if (r.length > 0) {
                r.each(function () {
                    if (brute_list.indexOf($(this).data('skmod')) < 0) {
                        brute_list.push($(this).data('skmod'));
                    }

                });
            }

        };

        scaner(starter);
        for (var i = 0; i < 9; i++) {
            var old_list = brute_list;

            for (var j = 0; j < old_list.length; j++) {
                scaner(old_list[j]);
            }
            ;
        }
        ;

        return brute_list;
    };

    this.update_p_set = function update_p_set() {
        var that = this;
        that.ulmaster.find('li').each(function () {
            var skModulo = $(this).find('.mainSkdocumento>input').data('skmodulo');
            $(this).find('.ward').find('.wardItemDiv').each(function () {
                var ward = $(this).find('input').data('ward');
                that.p_set[skModulo][ward] = $(this).find('input').is(':checked');
            });
        });
        this.pStore.val(JSON.stringify(this.p_set));
    };

    this.change_clonar = function change_clonar(obj) {
        //toastr.info("arrrg");
        toastr.info("Procesando");
        var that = this;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
              axn: 'consultarPerfilClonado',
              skPerfilClonar: $(obj).val()
            },
            async: true,
            cache: false,
            processData: true,
            success: function (data) {
                if (data) {
                    that.dataset = data;
                    that.run();

                    that.update_p_set();
                    toastr.clear();
                    toastr.success("Clonación Completada");
                }
            }
      });

      return;
    };

    this.run = function run() {

        var that = this;
        ulmaster.empty();

        this.pStore = $('<input type="hidden" name="'+inputHiddenName+'" id="'+inputHiddenName+'" value="">');
        ulmaster.append(this.pStore);
        this.pStore = $('#'+ inputHiddenName);

        for (var i = 0; i < that.dataset.length; i++) {
            var mod = that.dataset[i];
            var ward = ((mod.seW == '1') ? 'W' : '') + ((mod.seA == '1') ? 'A' : '') +
                    ((mod.seR == '1') ? 'R' : '') + ((mod.seD == '1') ? 'D' : '');

            var p_ward = ((mod.peW == '1') ? 'W' : '') + ((mod.peA == '1') ? 'A' : '') +
                    ((mod.peR == '1') ? 'R' : '') + ((mod.peD == '1') ? 'D' : '');


            that.p_set[mod.skModulo] = {
                "W": (mod.peW == '1') ? true : false,
                "A": (mod.peA == '1') ? true : false,
                "R": (mod.peR == '1') ? true : false,
                "D": (mod.peD == '1') ? true : false
            };


            if (mod.iNivel == 0) {
                ulmaster.append('<div class="form-group col-md-12"> <div class="col-md-2"></div><div class="col-md-8"> <hr> </div></div>');
            }


            ulmaster.append(
                    that.new_item(
                            mod.skModulo,
                            mod.sModuloPadre,
                            mod.sTitulo,
                            mod.eNivel,
                            ward,
                            p_ward,
                            mod.sIcono));
        }
        this.handler_set();
        this.update_p_set();
    };
};

$(document).ready(function () {
    $(document).on("keypress", "form", function select_parent(event) {
        return event.keyCode != 13;
    });
});
