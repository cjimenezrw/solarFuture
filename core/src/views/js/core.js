var core = {};
core.SYS_URL = '';

/*
 * PACE - Detecta y muestra el porcentaje de las peticiones AJAX
 */
paceOptions = {
    elements: false,
    restartOnPushState: false,
    restartOnRequestAfter: false,
    document: true,
    ajax: {
        trackMethods: ['GET', 'POST', 'DELETE', 'PUT', 'PATCH'],
        ignoreURLs: ['pusher']
    }
};

/* Es para el contador de que estadistica mostrar (TEMPORAL) */
core.pedi_inde = {};


core.pedi_inde.moduloEstadisticas = 1;

core.pedi_inde.showModules = function showModules() {
    if (core.pedi_inde.moduloEstadisticas === 1) {
        core.menuLoadModule({
            skModulo: 'pedi-inde',
            skModuloPadre: 'clie-esta',
            url: '/sys/clie/pedi-inde/pedimentos/'
        });
        core.pedi_inde.moduloEstadisticas = 2;
    } else if (core.pedi_inde.moduloEstadisticas === 2) {
        core.menuLoadModule({
            skModulo: 'rect-esta',
            skModuloPadre: 'clie-esta',
            url: '/sys/clie/rect-esta/rectificaciones/'
        });
        core.pedi_inde.moduloEstadisticas = 3;
    } else if (core.pedi_inde.moduloEstadisticas === 3) {
        core.menuLoadModule({skModulo: 'firm-esta', skModuloPadre: 'clie-esta', url: '/sys/clie/firm-esta/firmantes/'});
        core.pedi_inde.moduloEstadisticas = 4;
    } else if (core.pedi_inde.moduloEstadisticas === 4) {
        core.menuLoadModule({
            skModulo: 'vaad-esta',
            skModuloPadre: 'clie-esta',
            url: '/sys/clie/vaad-esta/valor-aduana/'
        });
        core.pedi_inde.moduloEstadisticas = 5;
    } else if (core.pedi_inde.moduloEstadisticas === 5) {
        core.menuLoadModule({
            skModulo: 'cont-esta',
            skModuloPadre: 'clie-esta',
            url: '/sys/clie/cont-esta/contenedores/'
        });
        core.pedi_inde.moduloEstadisticas = 6;
    } else if (core.pedi_inde.moduloEstadisticas === 6) {
        core.menuLoadModule({
            skModulo: 'casu-esta',
            skModuloPadre: 'clie-esta',
            url: '/sys/clie/casu-esta/carga-suelta/'
        });
        core.pedi_inde.moduloEstadisticas = 1;
    } else {
        core.menuLoadModule({
            skModulo: 'pedi-inde',
            skModuloPadre: 'clie-esta',
            url: '/sys/clie/pedi-inde/pedimentos/'
        });
        core.pedi_inde.moduloEstadisticas = 2;
    }
};

core.pedi_inde.presentacion = function presentacion() {
    setInterval(function () {
        core.pedi_inde.showModules();
    }, 20000);
};

core.summernoteConf = {
    height: 300
};

core.summernote = function summernote(conf) {
    if (typeof conf != 'undefined') {
        $.each(conf, function (k, v) {
            core.summernoteConf[k] = v;
        });
    }
    $('.core-summernote').summernote(core.summernoteConf);
};

/*
 * Aquí va el Document Ready del DLOREAN
 * Usalo con sabiduría
 */

core.noti = false;
core.buttonLock = '';
core.buttonLock_action = '';

$(document).ready(function () {

    // Ver estado de la ventana (Activa o inactiva)
    $(window).on("blur focus", function (e) {
        var prevType = $(this).data("prevType");
        if (prevType != e.type) {
            switch (e.type) {
                case "blur":
                    core.window_active = false;
                    break;
                case "focus":
                    core.window_active = true;
                    if (core.noti) {
                        pageTitleNotification.off();
                    }
                    break;
            }
        }
        $(this).data("prevType", e.type);
    });

    core.chatCount();

    $(document).on('submit', '#core-guardar', function (e) {
        return false;
    });

    $(document).ajaxStart(function () {
        //$.fn.dataTable.ext.errMode = 'none';
        Pace.restart();
        $('#core-ventanaModal').on('hidden.bs.modal', function (e) {
            window.history.pushState('', '', core.lastUrl);
            currentModule = core.modulo;
            core.modulo = core.previousModule;
            core.previousModule = currentModule;
            e.stopImmediatePropagation();
        });
    });

    core.ctrlPressed = false;
    $(window).keydown(function (evt) {
        evt.stopPropagation();
        if (evt.which == 17) { // ctrl
            core.ctrlPressed = true;
        }
    }).keyup(function (evt) {
        if (evt.which == 17) { // ctrl
            core.ctrlPressed = false;
        }
    });

    // Cerrar menu al hacer click en un dispositivo mobile
    setTimeout(function () {
        $.site.menu.$instance.on('click.site.menu', '.animsition-link', function (e) {
            var breakpoint = Breakpoints.current();
            if (breakpoint.name == 'xs') {
                $.site.menubar.hide();
            }
        });
    }, 1000);

    $.fn.extend({
        animateCss: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function () {
                $(this).removeClass('animated ' + animationName);
            });
        }
    });

    //Evento global para obtener errores de ajax.
    $(document).ajaxError(
            function (e, x, settings, exception) {
                toastr.clear();
                var message;
                var statusErrorMap = {
                    '400': "Server understood the request, but request content was invalid.",
                    '401': "Unauthorized access.",
                    '403': "Forbidden resource can't be accessed.",
                    '500': "Internal server error.",
                    '503': "Service unavailable."
                };
                if (x.status) {
                    message = statusErrorMap[x.status];
                    if (!message) {
                        toastr.error('Ha ocurrido un error.', 'Notificación');
                    }
                } else if (exception == 'parsererror') {
                    toastr.error('Ha ocurrido un error, por favor vuelva a intentarlo.', 'Notificación');
                } else if (exception == 'timeout') {
                    toastr.error('Por favor revise su conexión.', 'Notificación');
                } else if (exception == 'abort') {
                    return false;
                } else {
                    toastr.error('Por favor revise su conexión.', 'Notificación');
                }
            });

    $('.animsition-link').mousedown(function(e){
        switch(e.which)
        {
            case 1:
                break;
            case 2:
                return;
                var str = this.getAttribute("onclick");
                var params = str.split("core.menuLoadModule(")[1];
                console.log(params);
                //params[params.length - 1] = params[params.length - 1].replace(");", "");
                var param = params.replace(");", "");
                var json = JSON.stringify(eval("(" + param + ")"));
                console.log(json);
                console.log(param);
                //core.menuLoadModule(param);

                //console.log(this.getAttribute("onclick").event);
                //eval(this.getAttribute("onclick"));
                break;
            case 3:
                //right Click
                break;
        }
        return true;
    });

    $(document).ajaxStop(function() {
        lockButtons();
    });

});

function lockButtons() {
    $(".core-button").on("click", function () {
        if (core.buttonLock !== '') {
            return;
        }
        core.buttonLock = this;

        var attr = $(this).attr('onclick');
        if (typeof attr === typeof undefined || attr === false) {
            core.buttonLock_action = '';
            $(this).prop('disabled', true);

            $(function () {
                function checkPendingRequest() {
                    if ($.active > 0) {
                        window.setTimeout(checkPendingRequest, 1000);
                    }
                    else {

                        $(core.buttonLock).prop('disabled', false);
                        core.buttonLock = '';
                        core.buttonLock_action = '';

                    }
                };

                window.setTimeout(checkPendingRequest, 1000);
            });

/*            setTimeout(
                function () {
                    $(core.buttonLock).prop('disabled', false);
                    core.buttonLock = '';
                    core.buttonLock_action = '';
                }, 1500);*/

        }else {
            core.buttonLock_action = $(this).attr('onclick');
            $(this).attr("onclick", "return true;");


            $(function () {
                function checkPendingRequest() {
                    if ($.active > 0) {
                        window.setTimeout(checkPendingRequest, 1000);
                    }
                    else {

                        console.log("No hay peticiones pendientes");
                        $(core.buttonLock).attr("onclick", core.buttonLock_action);
                        core.buttonLock = '';
                        core.buttonLock_action = '';

                    }
                };

                window.setTimeout(checkPendingRequest, 1000);
            });


/*            setTimeout(
                function () {
                    $(core.buttonLock).attr("onclick", core.buttonLock_action);
                    core.buttonLock = '';
                    core.buttonLock_action = '';
                }, 1500);*/
        }

    });
}

function openInNewTab(conf) {

    if (typeof conf.params !== 'undefined' && Object.keys(conf.params).length > 2 ) {

        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("target", conf.skModulo);

        $.each(conf.params, function (k, v) {

            if(Array.isArray(v)){
                var i = 0;
                $.each(v, function (key, val) {
                    var element = document.createElement("input");
                    element.setAttribute("type", "hidden");
                    console.log(val);
                    element.setAttribute("name", k+'['+i+']');
                    element.setAttribute("value", val);
                    form.appendChild(element);
                    document.body.appendChild(form);
                    i++;
                });

            }else if(typeof v === "Object"){
                var i = 0;
                $.each(v, function (key, val) {
                    var element = document.createElement("input");
                    element.setAttribute("type", "hidden");
                    element.setAttribute("name", k+'['+i+']');
                    element.setAttribute("value", val);
                    form.appendChild(element);
                    document.body.appendChild(form);
                    i++;
                });
            }else{
                var element = document.createElement("input");
                element.setAttribute("type", "hidden");
                element.setAttribute("name", k);
                element.setAttribute("value", v);
                form.appendChild(element);
                document.body.appendChild(form);
            }
        });
        var win = window.open(conf.url, conf.skModulo);
        form.submit();
        //win.focus();
    }else{
        var win = window.open(conf.url, "_blank");
        win.focus();
    }

    /*
    var win = window.open(conf.url, '_blank');
    win.focus();*/
}

/*
 * Cargar de Módulo
 */

core.module = {};
core.lastUrl = false;
core.loadingModule = false;

core.loadModule = function loadModule(conf) {
    core.ctrlPressed = false;
    var url = '';
    if (conf != null) {
        url = conf.url;
    }

    if (core.loadingModule) {
        core.loadingModule.abort();
    }


    core.previousModule = core.modulo;

    core.loadingModule = $.ajax({
        url: url,
        type: 'POST',
        data: {
            axn: 'default'
        },
        cache: false,
        processData: true,
        beforeSend: function () {
            toastr.info('Cargando Módulo. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
        },
        success: function (data) {
            toastr.clear();
            if (!core.sessionOut(data)) {
                return false;
            }
            if (data.response == false) {
                swal("¡Error " + data.datos + "!", data.message, "error");
                return false;
            }
            core.dataFilterSend = [];
            core.excelHeaders = [];
            $('#view-content').html(data);
            $('.breadcrumb').asBreadcrumbs();
            $('#filterContainer').html("");
            core.loadingModule = false;
        }
    });

};

window.onpopstate = function (e) {
    if (e.state != null) {

        core.module = eval(e.state);

        currentModule = core.modulo;

        core.loadModule(e.state);

        //core.menuLoadModule(e.state);
        core.previousModule = currentModule;
    } else {
        core.loadModule(null);
    }
};

core.abortAjaxDataTables = function abortAjaxDatatables() {
    // Cancelar request de DataTables
    if (typeof $ !== "undefined" && $.fn.dataTable) {
        var all_settings = $($.fn.dataTable.tables()).DataTable().settings();
        for (var i = 0, settings; (settings = all_settings[i]); ++i) {
            if (settings.jqXHR)
                settings.jqXHR.abort();
        }
    }
};

core.menuLoadModule = function menuLoadModule(conf) {

    core.abortAjaxDataTables();

    $(window).unbind('beforeunload');
    core.module = eval(conf);

    if (!$( "#chatSide" ).closest( ".slidePanel" ).hasClass( "slidePanel-show" )){
        $.slidePanel.hide();
    }
    $('#mowi').iziModal('close');
    core.closeContextMenu();
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        bootbox.hideAll();
    }

    if (core.loadingModule) {
        core.loadingModule.abort();
    }

    core.previousModule = core.modulo;

    /* PARÁMETROS ADICIONALES (POST) */
        var moduleParams = {
            axn: 'default',
            skComportamiento: conf.skComportamiento
        };

        if (typeof conf.params !== 'undefined') {
            $.each(conf.params, function (k, v) {
                moduleParams[k] = v;
            });
        }

        conf.params = moduleParams;

    switch (conf.skComportamiento) {
        case 'VEMO':
            if (core.ctrlPressed) {
                core.ctrlPressed = false;
                if (conf.url.indexOf("#") < 0) {
                    openInNewTab(conf);
                }
            } else {
                core.loadingModule = $.ajax({
                    url: conf.url,
                    type: 'POST',
                    data: conf.params,
                    cache: false,
                    processData: true,
                    beforeSend: function () {
                        toastr.info('Cargando Módulo. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
                    },
                    success: function (data) {
                        if (!core.sessionOut(data)) {
                            return false;
                        }
                        if (data.response == false) {
                            swal("¡Error " + data.datos + "!", data.message, "error");
                            return false;
                        }
                        /* GUARDAMOS LA URL Y CAMBIAMOS LA URL EN EL NAVEGADOR */
                        core.lastUrl = window.location.href;
                        window.history.pushState(conf, conf.skModulo, conf.url);
                        toastr.clear();
                        core.closeContextMenu();
                        var venMod = $('#core-ventanaModal');
                        venMod.html(data);
                        venMod.modal({
                            show: true
                        });
                        core.loadingModule = false;
                        /*console.log('core.modulo : ', core.modulo);
                        console.log('core.previousModule : ', core.previousModule);*/
                    }
                });
            }
            break;
        case 'PANE':
            if (core.ctrlPressed) {
                core.ctrlPressed = false;
                if (conf.url.indexOf("#") < 0) {
                    openInNewTab(conf);
                }
            } else {
                core.loadingModule = $.ajax({
                    url: conf.url,
                    type: 'POST',
                    data: conf.params,
                    cache: false,
                    processData: true,
                    beforeSend: function () {
                        toastr.info('Cargando Módulo. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
                    },
                    success: function (data) {
                        if (!core.sessionOut(data)) {
                            return false;
                        }
                        if (data.response == false) {
                            swal("¡Error " + data.datos + "!", data.message, "error");
                            return false;
                        }
                        /* GUARDAMOS LA URL Y CAMBIAMOS LA URL EN EL NAVEGADOR */
                        core.lastUrl = window.location.href;
                        window.history.pushState(conf, conf.skModulo, conf.url);
                        toastr.clear();
                        core.closeContextMenu();
                        //https://github.com/amazingSurge/jquery-slidePanel
                        $.slidePanel.show(
                                {
                                    content: data
                                }, {
                            dragTolerance: 150,
                            mouseDragHandler: null,
                            mouseDrag: false,
                            touchDrag: false,
                            pointerDrag: false,
                            beforeShow: function (coming, previous) {
                                $("#lockPanelModule").show("slide", {direction: "right"}, 250);
                            },
                            beforeHide: function (coming, previous) {
                                $("#lockPanelModule").hide("slide", {direction: "right"}, 250);
                            }
                        }
                        );
                        core.loadingModule = false;
                        /*console.log('core.modulo : ', core.modulo);
                        console.log('core.previousModule : ', core.previousModule);*/
                    }
                });
            }
            break;
        case 'MOWI':
            if (core.ctrlPressed) {
                core.ctrlPressed = false;
                if (conf.url.indexOf("#") < 0) {
                    openInNewTab(conf);
                }
            } else {
                core.loadingModule = $.ajax({
                    url: conf.url,
                    type: 'POST',
                    data: conf.params,
                    cache: false,
                    processData: true,
                    beforeSend: function () {
                        toastr.info('Cargando Módulo. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
                    },
                    success: function (data) {
                        if (!core.sessionOut(data)) {
                            return false;
                        }
                        if (data.response == false) {
                            swal("¡Error " + data.datos + "!", data.message, "error");
                            return false;
                        }
                        /* GUARDAMOS LA URL Y CAMBIAMOS LA URL EN EL NAVEGADOR */
                        core.lastUrl = window.location.href;
                        window.history.pushState(conf, conf.skModulo, conf.url);
                        toastr.clear();
                        core.closeContextMenu();
                        //core.modalWindow(data);
                        $('#mowi-div').html('<div id="mowi"></div>');
                        var mowi = $('#mowi');

                        mowi.iziModal({
                            headerColor: '#064480',
                            width: '85%',
                            title: 'Cargando',
                            subtitle: 'Módulo...',
                            overlayColor: 'rgba(255, 255, 255, 0.5)',
                            fullscreen: true,
                            transitionIn: 'fadeInUp',
                            transitionOut: 'fadeOutDown',
                            padding: 25,
                            bodyOverflow: false,
                            radius: 10,
                            restoreDefaultContent: true,
                            zindex: 99997,
                            overlayClose: false,
                            onOpening: function (modal) {
                                //$("#mowi .iziModal-content").html(data);
                                $("#mowi").iziModal('setContent', {
                                    content: data
                                });
                            },
                            onClosing: function () {
                                window.history.pushState('', '', core.lastUrl);
                                currentModule = core.modulo;
                                core.modulo = core.previousModule;
                                core.previousModule = currentModule;
                            },
                            onClosed: function () {
                                //window.history.pushState('', '', core.lastUrl);
                                //console.log('AQUI CAMBIO LA URL POR LA ANTERIOR',core.lastUrl);
                                /*currentModule = core.modulo;
                                core.modulo = core.previousModule;
                                core.previousModule = currentModule;*/
                                mowi.iziModal('resetContent');
                                $("#mowi").remove();
                                //$('#mowi .iziModal-content').html('');
                            }
                        });
                        mowi.iziModal('open');
                        $('.iziModal-header-title').html(core.modulo.titulo);
                        $('.iziModal-header-subtitle').html(core.modulo.breadcrumb);
                        mowi.iziModal('setTop', 20);
                        mowi.iziModal('setBottom', 20);
                        core.loadingModule = false;
                        /*console.log('core.modulo : ', core.modulo);
                        console.log('core.previousModule : ', core.previousModule);*/
                    }
                });
            }
            break;
        default:
            // RELO //
            if (core.ctrlPressed) {
                core.ctrlPressed = false;
                if (conf.url.indexOf("#") < 0) {
                    openInNewTab(conf);
                }
            } else {
                core.loadingModule = $.ajax({
                    url: conf.url,
                    type: 'POST',
                    data: conf.params,
                    cache: false,
                    processData: true,
                    beforeSend: function () {
                        //toastr.info('Cargando Módulo. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
                    },
                    success: function (data) {
                        if (!core.sessionOut(data)) {
                            return false;
                        }
                        if (data.response == false) {
                            swal("¡Error " + data.datos + "!", data.message, "error");
                            return false;
                        }
                        /* GUARDAMOS LA URL Y CAMBIAMOS LA URL EN EL NAVEGADOR */
                        core.lastUrl = window.location.href;
                        window.history.pushState(conf, conf.skModulo, conf.url);
                        //toastr.clear();
                        core.closeContextMenu();
                        $(".site-menu-item").removeClass("active");
                        $(".has-sub").removeClass("active");
                        $("#" + conf.skModulo).addClass("active");
                        $("#" + conf.skModuloPadre).addClass("active");
                        core.dataFilterSend = [];
                        core.excelHeaders = [];
                        $('#view-content').html(data);
                        $('.breadcrumb').asBreadcrumbs();
                        $('#filterContainer').html("");
                        core.loadingModule = false;
                        core.dataFastFilter = false;
                        /*console.log('core.modulo : ', core.modulo);
                        console.log('core.previousModule : ', core.previousModule);*/
                    }
                });
            }
    }

    return true;
};

core.closePanelModule = function closePanelModule() {
    $("#lockPanelModule").hide("slide", {direction: "right"}, 250);
    $.slidePanel.hide();
    window.history.pushState('', '', core.lastUrl);
    currentModule = core.modulo;
    core.modulo = core.previousModule;
    core.previousModule = currentModule;
};

/*
 * Botón Guardar
 */
core.guardar = function guardar(conf) {

    /*if (!core.validarFormulario(core.formValidaciones)) {
     return false;
     }*/
    validate = $('#core-guardar').data('formValidation').validate();
    if (!validate.isValid()) {
        return false;
    }

    // CKEditor //
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    if ($('.bootstrap-table').length) {
        $('table').bootstrapTable('resetSearch');
    }

    var formdata = false;
    if (window.FormData) {
        formdata = new FormData($('#core-guardar')[0]);
        formdata.append('axn', 'guardar');
        // SUMMERNOTE //
        var summernote = $('.core-summernote');
        $.each(summernote, function (k, v) {
            formdata.append($(v).attr('name'), $(v).code());
        });
    }

    // ARCHIVOS DE DIGITALIZACIÓN -> MÚLTIPLE
    if (typeof window.digiInputs !== "undefined" || window.digiInputs !== "object") {
        $.each(window.digiInputs, function (id_digi, item_digi) {
            if (typeof item_digi.getAcceptedFiles !== "undefined"){
                var files = item_digi.getAcceptedFiles();
                if (files.length > 0) {
                    var i = 0;
                    $.each(files, function (id, item) {
                        formdata.append(id_digi+'[' + i + ']', item);
                        i++;
                    });
                }
            }
        });
    }

    // ARCHIVOS DE DOCUMENTACIÓN -> MÚLTIPLE
    if (typeof window.core_docu_documents !== "undefined" || window.core_docu_documents !== "object") {
        $.each(window.core_docu_documents, function (id_digi, item_digi) {
            formdata.append(id_digi, JSON.stringify(window.core_docu_documents[id_digi]['skDocumentos']));
            if (typeof item_digi.getAcceptedFiles !== "undefined"){
                var files = item_digi.getAcceptedFiles();
                if (files.length > 0) {
                    var i = 0;
                    $.each(files, function (id, item) {
                        formdata.append(id_digi+'[' + i + ']', item);
                        i++;
                    });
                }
            }
        });
    }

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            toastr.info('Guardando Datos. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
        },
        success: function (response) {
            toastr.clear();
            if (!core.sessionOut(response)) {
                return false;
            }
            if (response.success) {
                toastr.success(response.message, 'Notificación');
                core.menuLoadModule(conf);
            } else {
                toastr.error(response.message, 'Notificación');
            }
        }
    });
};

/*
 * Menú Emergente Eliminar
 */
core.eliminar = function eliminar(obj) {
    swal({
        title: "¡Advertencia!",
        text: "¿Está seguro que desea eliminar el registro?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        closeOnConfirm: false
    },
            function () {
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    global: false,
                    data: {
                        axn: 'eliminar',
                        id: obj.id
                    },
                    cache: false,
                    processData: true,
                    success: function (response) {
                        if (response.success) {
                            swal("¡Listo!", "El registro ha sido eliminado con éxito", "success");
                            core.dataTable.sendFilters(true);
                            return true;
                        }
                        swal("¡Error!", response.message, "error");
                    }
                });

            });
};

/*
 * Menú Emergente Cancelar
 */
core.cancelar = function eliminar(obj) {
    swal({
        title: "¡Advertencia!",
        text: "¿Está seguro que desea cancelar el registro?",
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Cancelar",
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
                axn: 'cancelar',
                id: obj.id,
                sObservaciones: inputValue
            },
            cache: false,
            processData: true,
            success: function (response) {
                if (response.success) {
                    swal("¡Listo!", "El registro ha sido cancelado con éxito", "success");
                    core.dataTable.sendFilters(true);
                    return true;
                }
                swal("¡Error!", response.message, "error");
            }
        });

    });
};

/*
 * Consultar los Foros de un Módulo
 */
core.foromod = function(obj){
    core.menuLoadModule({
        skModulo: obj.skModulo,
        url: obj.url + core.modulo.skModulo + '/',
        skComportamiento: 'MOWI'
    });
};


/*
 * Configuración de DataTable
 */
core.dataTableConf = {};
core.dataTablePageLength = 25;
core.dataTable = function dataTable() {
    core.dataTable.getFilters();
    core.dataTable.fastFilterLock = false;
    var size = $(document).height() - 500;
    if (size < 449) {
        size = 450;
    }

    core.dataTableConf.responsive = true;
    core.dataTableConf.deferRender = true;
    core.dataTableConf.processing = true;

    core.dataTableConf.pageLength = core.dataTablePageLength;
    core.dataTableConf.scrollY = size;
    core.dataTableConf.scrollCollapse = false;
    core.dataTableConf.searching = false;

    core.dataTableConf.initComplete = function () {

        //Evitar crear mas de un filtro rapido
        core.dataTable.fastFilterLock = true;

        core.dataTablePageLength = 25;

        $(window).resize(function () {
            var size = $(document).height() - 500;
            if (size < 449) {
                size = 450;
            }
            //$('.dataTables_scrollBody').css('height', size);
            $('.dataTables_scrollBody').css('height', '48vh');

        });
        //$("#div-table").find(".col-sm-12").addClass("height-500");
        //$("#div-table").find(".col-sm-12").css("overflow", "auto");

        var table = $('.dataTables_scrollHead');
        table.find('thead th').each(function (index) {
            $(this).attr('title', core.dataTableConf.columns[index]["tooltip"]);
        });

        table.find('thead th[title]').tooltip(
                {
                    "container": 'body'
                });

        var tabled = $("#core-dataTable_wrapper");
        tabled.find('.col-sm-5').addClass('col-xs-6 margin-top-10').removeClass('col-sm-5');
        tabled.find('.col-sm-7').addClass('col-xs-6 margin-top-10').removeClass('col-sm-7');

        tabled.find('.col-sm-6').eq(1).html('<button id="filtButt" class="btn btn-primary pull-right" ' +
                'data-target="#filterModal" data-toggle="modal" title="Ctrl + Alt + F" type="button" style="margin-left: 10px;height: 33px;padding-top: 5px;"><i class="fa fa-filter" aria-hidden="true"></i> Filtrar</button> <input type="search" data-toggle="tooltip" autocomplete="off" title="Búsqueda rápida sobre los registros mostrados en pantalla." class="searchtable form-control input-sm pull-right" placeholder="Buscar..." aria-controls="core-dataTable">');

        if (core.dataFilterSend.length > 0) {
            $('#filtButt').addClass('btn-danger');
        }

        $('[data-toggle="tooltip"]').tooltip();
        $(".searchtable").keyup(function () {
            var filter = new RegExp($(this).val(), 'i');
            $("table tbody tr").filter(function () {
                $(this).each(function () {
                    var found = false;
                    $(this).children().each(function () {
                        var content = $(this).html();
                        if (content.match(filter)) {
                            found = true
                        }
                    });
                    if (!found) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });

        if (/Android|Opera Mini/i.test(navigator.userAgent)) {
            $("tr").css({
                "-webkit-touch-callout": "none",
                "-webkit-user-selectsize": "none",
                "-khtml-user-select": "none",
                "-moz-user-select": "none",
                "-ms-user-select": "none",
                "user-select": "none"
            });
        }

    };
    core.dataTableConf.language = {
        "sSearchPlaceholder": "Buscar...",
        "lengthMenu": "Mostrando _MENU_ por página",
        "search": "_INPUT_",
        "paginate": {
            "previous": '<i class="icon wb-chevron-left-mini"></i>',
            "next": '<i class="icon wb-chevron-right-mini"></i>'
        }
    };
    core.DataTableId = $('#core-dataTable').DataTable(core.dataTableConf);
};
core.dataTableOpenFilters = function dataTableOpenFilters (){
    $("#filtButt").ready(function(){
        $("#filterModal").modal();
    });
};

/*
 * Filtro
 */

core.dataTableFiltros = {
    date: [
        {'name': 'Igual que', 'value': '='},
        {'name': 'Entre', 'value': 'BETWEEN'},
        {'name': 'Mayor que', 'value': '>'},
        {'name': 'Menor que', 'value': '<'},
        {'name': 'Vacío', 'value': 'null'}
    ],
    string: [
        {'name': 'Igual que', 'value': '='},
        {'name': 'Distinto de', 'value': '!='},
        {'name': 'Que contenga', 'value': '%LIKE%'},
        {'name': 'Que no tenga', 'value': 'NOT LIKE'},
        {'name': 'Comience con', 'value': 'LIKE%'},
        {'name': 'Termine con', 'value': '%LIKE'},
        {'name': 'Vacío', 'value': 'null'}
    ],
    int: [
        {'name': 'Igual que', 'value': '='},
        {'name': 'Distinto de', 'value': '!='},
        {'name': 'Mayor que', 'value': '>'},
        {'name': 'Menor que', 'value': '<'},
        {'name': 'Vacío', 'value': 'null'}

    ]
};

core.dataTable.selectDate = function selectDate(id) {

    var $container = $('#' + id + '-containter');

    if ($container.find("#" + id + "-2").val() == "BETWEEN") {

        $container.find(".addFilterInput").replaceWith('<div class="col-sm-4 addFilterInput">' +
                '<div class="input-daterange" data-plugin="datepicker"><div class="input-group">' +
                '<span class="input-group-addon"><i class="icon wb-calendar" aria-hidden="true"></i></span>' +
                '<input type="text" id="' + id + '-3" class="form-control modalDatePicker" name="start"></div>' +
                '<div class="input-group"> <span class="input-group-addon">a</span>' +
                '<input type="text" id="' + id + '-4" class="form-control modalDatePicker" name="end"></div> </div></div>');
    } else {
        $container.find(".addFilterInput").replaceWith('<div class="col-sm-4 addFilterInput"><div class="input-group">' +
                '<span class="input-group-addon"><i class="icon wb-calendar" aria-hidden="true"></i></span>' +
                '<input type="text" id="' + id + '-3" class="form-control modalDatePicker" data-plugin="datepicker"></div></div>');
    }

    $('.modalDatePicker').datepicker();
};

core.dataTable.enableInput = function enableInput(id) {
    $('#' + id + '-3').removeAttr('disabled');
};

core.dataTable.addCondition = function addCondition(idSelect) {
    var $index = $('#' + idSelect).val();
    var $type = core.dataTableConf.columns[$index]["dataType"];
    var $container = $('#' + idSelect + '-containter');

    switch ($type) {

        case 'string':
            $container.find(".addSelectType").replaceWith(
                    '<div class="col-sm-3 addSelectType">' +
                    '<div class="btn-group bootstrap-select">' +
                    '<select title="Seleccione Condicion" id="' + idSelect + '-2" class="filter-select" data-plugin="selectpicker"  onchange="core.dataTable.enableInput(\'' + idSelect + '\')">' +
                    '<option data-hidden="true"></option>' +
                    '</select> </div></div>');


            $.each(core.dataTableFiltros.string, function (index, contenido) {
                $('#' + idSelect + '-containter').find('select').append('<option value="' + contenido["value"] + '">' + contenido["name"] + '</option>');
            });

            // $container.find(".addFilterInput").replaceWith('' +
            //     '<div class="col-sm-4 addFilterInput"><input id="' + idSelect + '-3" type="text" class="form-control" id="inputPlaceholder" placeholder="Introduzca Palabra"></div>');

            $container.find(".addFilterInput").replaceWith('' +
                    '<div class="col-sm-4 addFilterInput"><input id="' + idSelect + '-3" type="text" class="form-control" placeholder="Introduzca Valor" disabled></div>');

            core.dataTable.ajaxInput(idSelect);

            $('.filter-select').selectpicker();
            break;

        case 'dateTime':
        case 'date':
            $container.find(".addSelectType").replaceWith(
                    '<div class="col-sm-3 addSelectType">' +
                    '<div class="btn-group bootstrap-select">' +
                    '<select title="Seleccione Condicion" id="' + idSelect + '-2" class="filter-select" data-plugin="selectpicker" onchange="core.dataTable.selectDate(\'' + idSelect + '\')">' +
                    '<option data-hidden="true"></option>' +
                    '</select> </div></div>');

            $.each(core.dataTableFiltros.date, function (index, contenido) {
                $('#' + idSelect + '-containter').find('select').append('<option value="' + contenido["value"] + '">' + contenido["name"] + '</option>');
            });

            $container.find(".addFilterInput").replaceWith('' +
                    '<div class="col-sm-4 addFilterInput"></div>');

            $('.filter-select').selectpicker();
            break;

        case 'int':
            $container.find(".addSelectType").replaceWith(
                    '<div class="col-sm-3 addSelectType">' +
                    '<div class="btn-group bootstrap-select">' +
                    '<select title="Seleccione Condicion" id="' + idSelect + '-2" class="filter-select" data-plugin="selectpicker" onchange="core.dataTable.enableInput(\'' + idSelect + '\')">' +
                    '<option data-hidden="true"></option>' +
                    '</select> </div></div>');

            var stringArr = core.dataTableFiltros.int;

            $.each(stringArr, function (index, contenido) {
                $('#' + idSelect + '-containter').find('select').append('<option value="' + contenido["value"] + '">' + contenido["name"] + '</option>');
            });

            $container.find(".addFilterInput").replaceWith('' +
                    '<div class="col-sm-4 addFilterInput"><input id="' + idSelect + '-3" type="number" class="form-control" id="inputPlaceholder" placeholder="Introduzca Valor" disabled></div>');

            $('.filter-select').selectpicker();
            break;
        default:
            break;
    }
};

core.dataTable.dataListColumns = function dataListColumns(idSelect) {
    var idS = $('#' + idSelect);
    $.each(core.dataTableConf.columns, function (index, contenido) {
        if (!contenido.hasOwnProperty("hiddenF")) {
            if (contenido.hasOwnProperty("filterT")) {
                idS.append('<option value="' + index + '">' + contenido.filterT + '</option>');
            } else {
                idS.append('<option value="' + index + '">' + contenido.title + '</option>');
            }
        }
    });
};

core.dataTable.addFilter = function addFilter() {

    var $filter = $("#filterContainer");
    var $idComp = $.now();

    if ($('.alert-mod').length == 5) {
        toastr.info('Máxima cantidad de filtros alcanzada');
        return;
    }

    $filter.append('<div id="' + $idComp + '-containter" class="alert alert-mod alert-alt alert-primary alert-dismissible margin-top-5" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>' +
            '<div class="row"><div class="col-sm-4"> <div class="btn-group bootstrap-select">' +
            '<select title="Seleccione Columna" id="' + $idComp + '" class="filter-select" data-plugin="selectpicker" onchange="core.dataTable.addCondition(\'' + $idComp + '\')"><option data-hidden="true"></option></select>' +
            '</div></div>' +
            '<div class="col-sm-3 addSelectType"></div>' +
            '<div class="col-sm-4 addFilterInput"></div>' +
            '</div></div>');

    core.dataTable.dataListColumns($idComp);
    $('.filter-select').selectpicker();
    $('.modalDatePicker').datepicker();

};

// Filtros
core.dataFilterSend = [];
core.dataFastFilter = false;

/**
 *
 * Filtros para DataTables
 *
 * @author Jonathan Topete Figueroa <jtopete@woodward.com.mx>
 *
 */
core.dataTable.sendFilters = function sendFilters(param, param2) {

    core.abortAjaxDataTables();

    var parameters = [];

    if (param == '3'){
        core.dataFastFilter = false;
        $( "#filtButt" ).prop( "disabled", false );
        param = false;
    }

    if (core.dataFastFilter){
        param = 'fast';
    }

    // Sin Filtros
    if (!param) {
        core.dataFastFilter = false;
        core.dataFilterSend = [];
        $('#core-dataTable').DataTable().ajax.reload();
        return;
    }

    // Detecta Filtros Rápidos
    if (param == 'fast') {
        var val = $('#fast-filter-input').val();
        var indexColumn = $('#fast-filter-column').val();
        var type = core.dataTableConf.columns[indexColumn]["dataType"];
        var nameColumn = core.dataTableConf.columns[indexColumn]["data"];
        var rule = '%LIKE%';

        if (val == ''){
            toastr.warning('Porfavor ingrese valor.', 'Notificación');
            return;
        }

        $( "#filtButt" ).prop( "disabled", true );
        core.dataFastFilter = true;

        parameters.push(
            {'column': nameColumn, 'rule': rule, 'value': val, 'type': type}
        );

        core.dataFilterSend = parameters;
        $('#core-dataTable').DataTable().ajax.reload();
        return;
    }


    // Detecta Filtro Predeterminado
    if ($(".filter-select2 :selected").val()) {
        core.dataFilterSend = $(".filter-select2 :selected").val();
        $('#core-dataTable').DataTable().ajax.reload();
        return;
    }

    // Arma Filtros Personalizados
    var classSelect = $('.alert');

    if (classSelect.length > 0 && param == true) {

        classSelect.each(function (index) {

            var id = $(this).attr('id');
            var specid = $('#' + id);

            var indexColumn = specid.find('#' + (id).replace('-containter', '')).val();
            var select2 = specid.find('#' + (id).replace('-containter', '-2')).val();
            var select3 = specid.find('#' + (id).replace('-containter', '-3')).val();

            var type = core.dataTableConf.columns[indexColumn]["dataType"];
            var nameColumn = core.dataTableConf.columns[indexColumn]["data"];

            //Verifica si existe el ultimo input, lo cual quiere decir que esta entre 2 fechas
            if (specid.find('#' + (id).replace('-containter', '-4')).length == 0) {

                parameters.push(
                        {'column': nameColumn, 'rule': select2, 'value': select3, 'type': type}
                );

            } else {

                var select4 = specid.find('#' + (id).replace('-containter', '-4')).val();

                parameters.push(
                        {'column': nameColumn, 'rule': select2, 'value': select3 + ',' + select4, 'type': type}
                );

            }

        });

        /*if (param2){
         return parameters;
         }
         core.dataFilterSend = parameters;
         $('#core-dataTable').DataTable().ajax.reload();*/
    }

    if (param2) {
        return parameters;
    }
    core.dataFilterSend = parameters;
    $('#core-dataTable').DataTable().ajax.reload();
};

/**
 *
 * Añade filtros rapidos a dataTables
 *
 * @author Jonathan Topete Figueroa <jtopete@woodward.com.mx>
 *
 * @param indx Indice de columna que será predeterminado.
 * @param hiddeIndex Array de indices de columnas a ocultar.
 * @param visibility true o false si se requiere que el componente sea visible por defecto.
 */
core.dataTable.fastFilters = function fastFilters(indx, hiddeIndex, visibility) {

    if (core.dataTable.fastFilterLock){
        return;
    }

    var heading = '<div class="panel-heading"> <h3 class="panel-title">Filtro Rápido</h3></div>';

    var filterColumns = '<div class="row">' +
        '<div class="col-sm-4">' +
        '<div class="btn-group bootstrap-select">' +
        '<select title="Seleccione Columna" id="fast-filter-column" data-live-search="true" class="filter-select" data-plugin="selectpicker">' +
        '<option data-hidden="true"></option>' +
        '</select>' +
        '</div>' +
        '</div>' +
        '<div class="col-sm-4"><input id="fast-filter-input" type="text" class="form-control" placeholder="Introduzca Valor" autocomplete="off"></div>' +
        '<div class="col-sm-4"><div class="btn-group btn-group-sm margin-top-5" aria-label="Small button group" role="group"> <button class="btn btn-primary btn-outline" type="button" onclick="core.dataTable.sendFilters(\'fast\');">Aplicar</button> <button class="btn btn-primary btn-outline" type="button" onclick="core.dataTable.sendFilters(3);">Ignorar</button> </div></div>' +
        '</div>';


var actionButton = '<div class="site-action" data-plugin="actionBtn">' +
    '<button type="button" class="site-action-toggle btn-raised btn btn-primary btn-floating" onclick="$(\'.fast-filter\').toggle(); $(\'#fast-filter-input\').focus();" data-toggle="tooltip" title="Mostrar / Ocultar Filtros Rápidos."> <i class="front-icon wb-eye-close animation-scale-up" aria-hidden="true"></i> <i class="back-icon wb-close animation-scale-up" aria-hidden="true"></i> </button>' +
    '</div>';


    $(".panel").before('<div class="row fast-filter" style="display: none;"><div class="col-md-12"> <div class="panel panel-primary panel-line">'+heading+'<div class="panel-body">'+filterColumns+'</div></div></div></div>');

    $("#div-table").after(actionButton);

    if (visibility == true){
        $('.fast-filter').toggle();
        $('#fast-filter-input').focus();
    }

    //Lógica

    var idS = $('#fast-filter-column');
    $.each(core.dataTableConf.columns, function (index, contenido) {
        var selected = '';
        if (indx == index){
            selected = 'selected';
        }
        if (!contenido.hasOwnProperty("hiddenF") && contenido.dataType == 'string' && !($.inArray(index, hiddeIndex) !== -1)) {
            if (contenido.hasOwnProperty("filterT")) {
                idS.append('<option value="' + index + '" '+selected+'>' + contenido.filterT + '</option>');
            } else {
                idS.append('<option value="' + index + '" '+selected+'>' + contenido.title + '</option>');
            }
        }
    });

    $('#fast-filter-column').selectpicker('refresh');
    //core.dataTable.ajaxInput('fast-filter-input', 'fastFilter');

    $("#fast-filter-input").on('keyup', function (e) {
        if (e.keyCode == 13) {
            core.dataTable.sendFilters('fast');
        }
    });

};


/**
 *
 * Oculta Columnas de Data Tables
 *
 * @author Jonathan Topete Figueroa <jtopete@woodward.com.mx>
 *
 * @param columns Array con indices de columnas a ocultar.
 * @param valueHidde valor que debe cumplirse para ocultar.
 */
core.dataTable.hiddeColumns = function hiddeColumns(columns, valueHidde) {
    $.each(columns, function( index, value ) {
        let table = $('#core-dataTable').DataTable();
        let table2 = $('#core-dataTable').dataTable(); // Es diferente a .DataTable
        let dataDataTable = table2.fnGetData(); // Obtiene array de datos de la tabla
        let nameDataColum = table.settings().init().columns[value].data; //Obtiene Nombre(data) de columna

        if (dataDataTable[0][nameDataColum] == null){
            let column = table.column(value);
            column.visible( false );
        }
    });
};

core.dataTable.saveFilter = function saveFilter() {
    if ($('.alert').length == 0) {
        return;
    }
    var filters = core.dataTable.sendFilters(true, true);
    swal({
        title: "Guardar Filtro",
        text: "Ingrese Nombre Para Filtro",
        type: "input",
        showLoaderOnConfirm: true,
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Nombre de Filtro",
        confirmButtonText: "Continuar"

    },
            function (inputValue) {
                if (inputValue === false)
                    return false;

                if (inputValue === "") {
                    swal.showInputError("Es Necesario Escribir Nombre");
                    return false;
                }

                if (inputValue.length > 30) {
                    swal.showInputError("Máximo 30 Caracteres");
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: core.SYS_URL + "sys/inic/inic-dash/save-filters/",
                    global: false,
                    data: {
                        axn: 'saveFilters',
                        sNombre: inputValue,
                        skModulo: core.module,
                        sJson: JSON.stringify(filters)
                    },
                    success: function (data) {

                        toastr.clear();

                        if (!data) {
                            swal("¡Error!", "Algo salió mal, contacte a un administrador", "error");
                        }

                        if (data) {
                            swal("Filtro Guardado", "" + inputValue, "success");
                            core.dataTable.getFilters();
                        } else {
                            swal.showInputError("Ha Ocurrido Un Error");
                            return false;
                        }
                    }
                });

            });

};

core.dataTable.removeFilter = function removeFilter() {

    var skFiltroUsuario = $(".filter-select2 :selected").attr('skFiltroUsuario');

    swal({
        title: "Eliminar Filtro",
        text: "No será posible recuperarlo",
        type: "warning",
        showLoaderOnConfirm: true,
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si, Eliminar",
        closeOnConfirm: false
    },
            function () {

                $.ajax({
                    type: "POST",
                    url: core.SYS_URL + "sys/inic/inic-dash/remove-filters/",
                    global: false,
                    data: {
                        axn: 'removeFilters',
                        skFiltroUsuario: skFiltroUsuario
                    },
                    success: function (data) {
                        if (!data) {
                            swal("¡Error!", "Algo salió mal, contacte a un administrador", "error");
                        }
                        if (data) {
                            swal("Eliminado!", "Filtro Eliminado Correctametne.", "success");
                            core.dataTable.getFilters();
                        } else {
                            swal.showInputError("Ha Ocurrido Un Error");
                            return false;
                        }
                    }
                });
            });

};

core.dataTable.getFilters = function getFilters() {
    var select = $(".filter-select2");
    $.ajax({
        type: "POST",
        url: core.SYS_URL + "sys/inic/inic-dash/get-filters/",
        global: false,
        async: false,
        data: {
            axn: 'getFilters',
            skModulo: core.module
        },
        success: function (data) {
            var pred = 0;
            select.find('option').remove().end();

            if (data.length == 0) {
                $('#saveFilter').hide();
                $('#removeFilter').hide();
                $('#filtroPredeterminado').prop('checked', false);
            }

            jQuery(data).each(function (i, item) {
                //console.log(item.sJsonFiltro, item.sNombre)
                var predeterminado = 'predeterminado="false"';
                var sel = "";
                if (item.iPredeterminado) {
                    predeterminado = 'predeterminado="true"';
                    pred = 1;
                    sel = "selected";
                    core.dataFilterSend = item.sJsonFiltro;
                }

                select.append("<option skFiltroUsuario='" + item.skFiltroUsuario + "' value='" + item.sJsonFiltro + "' " + predeterminado + " " + sel + ">" + item.sNombre + "</option>");
                select.trigger('change');
                //var newOption = new Option(item.sNombre, item.sJsonFiltro, true, true);
                //$(".filter-select").append(newOption).trigger('change');
                //$(".filter-select").selectpicker("refresh");
            });

            if (pred == 0) {
                $('.filter-select2').val(null).trigger("change");
                $('#filtroPredeterminado').prop('checked', false);
                $('#filtButt').removeClass('btn-danger');
            } else {
                core.dataFilterSend = $(".filter-select2 :selected").val();
                $('#filtroPredeterminado').prop('checked', true);
                $('#removeFilter').show();
            }

            if ($('.alert').length > 0) {
                $('#saveFilter').show();
            } else {
                $('#saveFilter').hide();
            }
        }
    });
};

core.dataTable.ajaxInput = function ajaxInput(id, fastFilter) {

    var gur = {};

    if (fastFilter == 'fastFilter'){
        var indexColumn = $('#fast-filter-column').val();
        var nameColumn = core.dataTableConf.columns[indexColumn]["data"];
        var input = $('#fast-filter-input');
    }else {
        var indexColumn = $('#' + id + '-containter').find('#' + id).val();
        var nameColumn = core.dataTableConf.columns[indexColumn]["data"];
        var input = $("#" + id + '-3');
    }


    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {

            $.ajax({
                'url': window.location.href,
                'type': "POST",
                'global': false,
                'data': {
                    axn: core.dataTableConf.axn,
                    filters: 'single',
                    value: input.val(),
                    column: nameColumn
                },
                success: function (res) {
                    strs = res[0];
                    gur = res[1];

                }
            });

            var matches = [];

            var substrRegex = new RegExp(q, 'i');

            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };


    input.typeahead({
        hint: true,
        highlight: true,
        minLength: 0
    },
            {
                name: 'paises',
                source: substringMatcher()
            });

    input.bind('typeahead:select', function (ev, suggestion) {
        $("#" + id).attr('data', gur[suggestion]);
    });

};

// Change column color :)

core.dataTable.changeColumnColor = function changeColumnColor(column, colorClass) {

    //Colores: success, info, warning, danger.

    var table = $('#core-dataTable').DataTable();

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var cell = table.cell({row: rowIdx, column: column}).node();
        $(cell).addClass(colorClass);
    });
};

// ContextMenu

core.dataTable.contextMenuCore = function contextMenuCore(params) {

    if (!params) {
        $('#context-menu').find('ul').html('');
        return;
    }

    $(document).ready(function () {

        var cont = $('tbody');
        var idTable = $('#core-dataTable');
        var table = idTable.DataTable();

        // Detecta click derecho al tr dentro de tbody
        idTable.find('tbody').on('contextmenu', 'tr', function () {
            /*            window.tablerow = table.row(this);
             window.tabledata = table.row(this).data();
             window.tableid = table.row(this).id();*/
            var data = table.row(this).data();
            core.dataSelect = data.menuEmergente;
            // Se almacena los datos del row en la siguiente variable
            core.rowDataTable = table.row(this).data();
        });

        idTable.find('tbody').on('click', 'tr', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                var data = table.row(this).data();
                console.log(table.column(this.index));
                bootbox.dialog({title: 'Seleccione una Opción', message: data.menuEmergente, closeButton: true});
            }
        });

        cont.contextmenu({
            target: '#context-menu',
            before: function (e, context) {

                if (core.dataSelect == null) {
                    e.preventDefault();
                    this.closemenu();
                    return false;
                }

                $('#context-menu').find('ul').html(core.dataSelect);
            },
            onItem: function (context, e) {
                //alert($(e.target).text());
            }
        });
    });
};

/*
 * Jonathan Topete
 * Función para seleccionar las filas de la tabla al hacer doble clic
 */
core.dataTable.multipleSelect = function multipleSelect(colorClass) {
    var color = colorClass;
    var sel = 'rowSelected';
    var tr = $("#core-dataTable tbody tr");
    if (!color) {
        color = "selectedRow";
    }
    tr.dblclick(function () {
        $(this).toggleClass(color + ' ' + sel);
    });
    $(document).keydown(function (e) {
        if (e.keyCode == 83 && e.altKey) {
            if ($('tr.' + color).length){
                tr.removeClass(color + ' ' + sel);
            }else {
               tr.addClass(color + ' ' + sel);
            }
        }
    });

};

/*
* Jonathan Topete
 * Función para listár las filas seleccionadas en la tabla
 * Recibe id si es que es distinto al pordefecto
 */
core.dataTable.rowsSelected = function rowsSelected(idVal) {

    var id = 'idRegistro';
    if (idVal){
        id = idVal;
    }

    var table = $('#core-dataTable').DataTable();
    var dat = table.rows('.rowSelected').data();
    var total = table.rows('.rowSelected').data().length;
    var rowsSelecteds = [];
    if (total) {
        for (i = 0; i < total; i++) {
            rowsSelecteds[i] = dat[i][id];
        }
    }
    return rowsSelecteds;
};

/*
 * Funcion validar
 */
core.formValidaciones = {
    framework: 'bootstrap',
    icon: {
        valid: 'fa fa-check',
        invalid: 'fa fa-close',
        validating: 'fa fa-spinner'
    }

};


/*
 * Función para descargar por Ajax
 */
// URL: https://jqueryfiledownload.apphb.com/
core.download = function download(url, requestMethod, params) {
    if (typeof requestMethod === 'undefined') {
        requestMethod = 'GET';
    }

    conf = {
        httpMethod: requestMethod,
        dataType: 'json',
        contentType: 'application/json',
        prepareCallback: function (response) {
            toastr.info('Preparando su descarga <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
        },
        successCallback: function (response) {
            toastr.clear();
            toastr.success('Descargado con éxito.', 'Notificación');
        },
        failCallback: function (response) {
            toastr.clear();
            swal("¡Error!", response, "error");
        }
    };

    if (typeof params != 'undefined') {
        conf.data = params;
    }

    $.fileDownload(url, conf);
    //toastr.clear();
};

/*
 * Función para visualizar PDF
 */
core.pdf = function pdf() {

    if (typeof core.dataTableConf.columns != 'undefined') {

        // OBTENEMOS LOS FILTROS
        dataFilterSend = core.dataFilterSend;

        // OBTENEMOS LOS ENCABEZADOS
        if (core.excelHeaders.length != 0) {
            excelHeaders = JSON.stringify(core.excelHeaders);
        } else {
            $.each(core.dataTableConf.columns, function (k, v) {
                if (!v.hasOwnProperty("excluirExcel")) {
                    if (v.hasOwnProperty("filterT")) {
                        core.excelHeaders.push({
                            title: v.filterT,
                            column: v.data,
                            dataType: v.dataType
                        });
                    } else {
                        core.excelHeaders.push({
                            title: v.title,
                            column: v.data,
                            dataType: v.dataType
                        });
                    }
                }
            });
            excelHeaders = JSON.stringify(core.excelHeaders);
        }

        $.fileDownload(window.location.href, {
            httpMethod: 'POST',
            data: {
                axn: 'pdf',
                generarExcel: true,
                title: core.modulo.titulo,
                headers: JSON.stringify(core.excelHeaders),
                filters: core.dataFilterSend,
                order: core.dataTableConf.columns[core.dataTableConf.order[0][0]].data,
                orderDir: core.dataTableConf.order[0][1]

            },
            prepareCallback: function (response) {
                toastr.info('Generando PDF. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
            },
            successCallback: function (response) {
                toastr.clear();
                toastr.success('Descargado con éxito.', 'Notificación');
            },
            failCallback: function (response) {
                var error = JSON.parse(response);
                toastr.clear();
                toastr.error(error.message, 'Notificación');
                if (!core.sessionOut(error)) {
                    return false;
                }
            }
        });
    } else {
        window.open(window.location.href + '?axn=pdf');
    }

    return false;
};

/*
 * Función para visualizar Excel
 */
core.excelHeaders = [];
core.excel = function excel(conf, caxn) {

    if (typeof core.dataTableConf.columns != 'undefined') {

        // OBTENEMOS AXN
        if (typeof caxn == 'undefined') {
            caxn = 'generarExcel';
        }

        // OBTENEMOS LOS FILTROS
        dataFilterSend = core.dataFilterSend;

        // OBTENEMOS LOS ENCABEZADOS
        if (core.excelHeaders.length != 0) {
            excelHeaders = JSON.stringify(core.excelHeaders);
        } else {
            $.each(core.dataTableConf.columns, function (k, v) {
                if (!v.hasOwnProperty("excluirExcel")) {
                    if (v.hasOwnProperty("filterT")) {
                        core.excelHeaders.push({
                            title: v.filterT,
                            column: v.data,
                            dataType: v.dataType
                        });
                    } else {
                        core.excelHeaders.push({
                            title: v.title,
                            column: v.data,
                            dataType: v.dataType
                        });
                    }
                }
            });
            excelHeaders = JSON.stringify(core.excelHeaders);
        }

        $.fileDownload(window.location.href, {
            httpMethod: 'POST',
            data: {
                axn: caxn,
                generarExcel: true,
                title: core.modulo.titulo,
                headers: excelHeaders,
                filters: core.dataFilterSend,
                order: core.dataTableConf.columns[core.dataTableConf.order[0][0]].data,
                orderDir: core.dataTableConf.order[0][1]

            },
            prepareCallback: function (response) {
                toastr.info('Generando Excel. <i class="fa fa-spinner faa-spin animated"></i>', 'Notificación', {timeOut: false});
            },
            successCallback: function (response) {
                toastr.clear();
                toastr.success('Descargado con éxito.', 'Notificación');
            },
            failCallback: function (response) {
                var error = JSON.parse(response);
                toastr.clear();
                toastr.error(error.message, 'Notificación');
                if (!core.sessionOut(error)) {
                    return false;
                }
            }
        });
    }

    return false;
};

core.autocomplete2Data = function autocomplete2Data(target) {

    var comp = $(target).select2('data')[0];

    var data = {};
    data.id = comp.id;
    data.name = comp.text;
    data.data = comp.data;

    return data;
};

core.autocomplete2 = function autocomplete2(target, axn, url, placeholder, extraParams) {
    $(document).ready(function () {
        $(target).select2({
            minimumInputLength: 2,
            tags: [],
            placeholder: placeholder,
            allowClear: true,
            ajax: {
                url: url,
                global: false,
                dataType: 'json',
                type: "POST",
                cache: true,
                delay: 250,
                data: function (term) {

                    obj = {
                        val: term.term,
                        axn: axn
                    };

                    if (typeof extraParams == 'undefined') {
                        return obj;
                    }

                    $.each(extraParams, function (index, value) {
                        if (typeof value === 'object') {
                            obj[index] = $(value).val();
                        } else {
                            obj[index] = value;
                        }
                    });

                    return obj;

                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            var dat = [];
                            if(item.hasOwnProperty('data')){
                                dat = item.data;
                            }
                            return {
                                text: item.nombre,
                                id: item.id,
                                data: dat
                            }
                        })
                    };
                }
            },

            //Traducciones
            "language": {
                errorLoading: function () {
                    return 'No se pudieron cargar los resultados';
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    return 'Por favor ingrese ' + remainingChars + ' o más caracteres';
                },
                loadingMore: function () {
                    return 'Cargando más resultados...';
                },
                maximumSelected: function (args) {
                    var message = 'Sólo puede seleccionar ' + args.maximum + ' item';

                    if (args.maximum != 1) {
                        message += 's';
                    }

                    return message;
                },
                noResults: function () {
                    return 'No se encontraron resultados';
                },
                searching: function () {
                    return 'Buscando...';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            createTag: function (params) {
                return undefined;
            }
        });
    });
};

//Multiple Data

core.tableMultiple = function (obj, conf) {

    $( "#core-buttonBreadcrum-save" ).click(function() {
        obj.bootstrapTable('resetSearch');
    });

    obj.on('click-cell.bs.table', core.tableMultipleOnClick);

    obj.bootstrapTable(conf.datos);
    obj.bootstrapTable();
    obj.bootstrapTable('hideColumn', 'id');

    var addR = $("#" + obj.attr('id') + "-addRow");
    /*    if (typeof button != 'undefined') {
     addR = $(button);
     }*/

    // Al hacer click en un tr para editar
    /*$('#core-multiple-data')*/
    obj.find('tbody').on('click', 'tr', function () {
        //var fnclick = $('#' + obj.attr('id') + '-addRow').attr('onclick');
        //console.log($(this).closest("table").attr("id"));
        window.indexID = $(this).attr("data-uniqueid");
        if ($(this).hasClass("no-records-found")) {
            return;
        }
        if ($(this).hasClass("table-multiple-edit")) {
            $(this).removeClass('table-multiple-edit');
            $('.' + obj.attr('id') + '-editAndo').html('');
            addR.html('<i class="fa fa-plus" aria-hidden="true"></i> Agregar');
            addR.attr('onclick', obj.attr('id') + '_addNewRow()');
            //addR.attr('onclick', fnclick);
            $('.' + obj.attr('id') + '-panelEdit').css({
                'background-color': '',
                'color': ''
            });
            window.indexID = undefined;
            return true;
        } else {
            // Obtiene funcion base mas indice
            //var edclick = fnclick.substr(0, fnclick.indexOf('(')) + '(' + $(this).attr('data-index') + ')';
            $('#core-multiple-data');
            obj.find('tbody > tr').each(function (i, tr) {
                $(tr).removeClass('table-multiple-edit');
            });
            $(this).addClass('table-multiple-edit');
            $('.' + obj.attr('id') + '-editAndo').html('<b>Editando fila ' + (parseInt($(this).attr('data-index')) + 1) + '</b>');
            addR.html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar');
            addR.attr('onclick', obj.attr('id') + '_addNewRow(' + $(this).attr('data-index') + ')');

            //addR.attr('onclick', edclick);
            $('.' + obj.attr('id') + '-panelEdit').css({
                'background-color': '#526069',
                'color': '#fff'
            });
            //var idTable = $(this).attr('data-uniqueid');
        }

        //var jsonObj = [];
        $('input[type=text]', this).each(function () {
            var name = $(this).attr("name").replace('[]', '');
            var valu = $(this).val();

            if (typeof $('#' + name)[0] != 'undefined') {
                if ($('#' + name)[0].hasAttribute("data-plugin")) {
                    if ($('#' + name)[0].hasAttribute("multiple")) {
                        valu = valu.replace(', ', ',');
                        $('#' + name).val(valu.split(',')).trigger('change');
                    } else if ($('#' + name)[0].hasAttribute("select2")) {
                        $('#' + name).append('<option value="' + valu + '" selected ="selected">' + $(this).attr('data-name') + '</option>').trigger('change');
                    } else if ($('#' + name)[0].hasAttribute("select2Simple")) {
                        $('#' + name).val(valu).trigger("change");
                    } else if ($('#' + name)[0].hasAttribute("inputText")) {
                        $('#' + name).val(valu).trigger("change");
                    }
                }
            }

            //var item = {};item ["name"] = name;item ["value"] = valu;jsonObj.push(item);
        });
        //console.log(jsonObj);
    });

    setTimeout(
            function () {
                obj.bootstrapTable('resetView');
            }, 2000);

    var selections = [];
    obj.on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
                $('#' + obj.attr('id') + '-removeRowTableMultiple').prop('disabled', !obj.bootstrapTable('getSelections').length);
                selections = getIdSelections();
            });

    $('#' + obj.attr('id') + '-removeRowTableMultiple').click(function () {

        swal({
            title: "¿Está seguro?",
            text: "Una vez guardado NO será posible recuperar el/los registro(s)",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar!",
            closeOnConfirm: false
        },
                function () {
                    swal("Eliminado!", "Recuerda guardar los cambios", "success");
                    var ids = getIdSelections();
                    obj.bootstrapTable('remove', {
                        field: 'id',
                        values: ids
                    });
                    $('#' + obj.attr('id') + '-removeRowTableMultiple').prop('disabled', true);
                });

    });

    function getIdSelections() {
        return $.map(obj.bootstrapTable('getSelections'), function (row) {
            return row.id;
        });
    }
};
core.tableMultiplerowId = '';
/**
 *
 * Función para añadir registros a al tabla multiple
 *
 * @param id id del objeto de la tabla
 * @param data array de objetos a añadir a la tabla
 */
core.tableMultiple.addRow = function(id, data){
    $('#'+id).bootstrapTable('removeAll');
    $('#'+id).bootstrapTable("load", data);
};

core.tableMultipleAddRow = function tableMultipleAddRow(obj, conf, id, index) {

//    var strClick = $('#' + obj.attr('id') + '-addRow').attr('onclick');
    var val = {};
    var inputs = '';
    if (id != undefined || null) {
        if (window.indexID != undefined || window.indexID != null) {
            inputs += '<input name="' + id + '[]" value="' + window.indexID + '" hidden/>';
            window.indexID = null;
        } else {
            inputs += '<input name="' + id + '[]" value="" hidden/>';
        }
    }
    $.each(conf, function (k, v) {

        var obj = $("#" + v.id);
        var objSel = $("#" + v.id + " :selected");

        switch (v.type) {
            case 'val':
                val[k] = (Array.isArray(obj.val())) ? obj.val() : obj.val().trim();
                inputs += '<input data-name="' + val[k] + '" type="text" name="' + v.id + '[]" value="' + val[k] + '" hidden/>';
                break;
            case 'text':
                val[k] = (Array.isArray(obj.val())) ? obj.text() : obj.text().trim();
                inputs += '<input data-name="' + val[k] + '" type="text" name="' + v.id + '[]" value="' + obj.val() + '" hidden/>';
                break;
            case 'selected':
                val[k] = (Array.isArray(objSel.text())) ? objSel.text() : objSel.text().trim();
                valor = (obj.val() === null) ? '' : obj.val();
                inputs += '<input data-name="' + val[k] + '" type="text" name="' + v.id + '[]" value="' + valor + '" hidden/>';
                obj.empty().trigger('change');
                break;
            case 'simpleSelected':
                val[k] = (Array.isArray(objSel.text())) ? objSel.text() : objSel.text().trim();
                inputs += '<input data-name="' + val[k] + '" type="text" name="' + v.id + '[]" value="' + obj.val() + '" hidden/>';
                obj.val('').trigger('change');
                break;
            case 'tags':
                var suc = [];
                objSel.each(function () {
                    suc.push($(this).text());
                });
                val[k] = suc.join(", ");
                inputs += '<input type="text" name="' + v.id + '[]" value="' + obj.val() + '" hidden/>';
                obj.val('').trigger('change');
                break;
            default:
                return false;
                break;
        }
    });

    val[Object.keys(val)[0]] += inputs;
    val.id = $.now();

    if (typeof index != 'undefined') {
        obj.bootstrapTable('updateRow', {
            index: index,
            row: val
        });

        $('.' + obj.attr('id') + '-editAndo').html('');
        var addR = $("#" + obj.attr('id') + "-addRow");
        addR.html('<i class="fa fa-plus" aria-hidden="true"></i> Agregar');
        addR.attr('onclick', obj.attr('id') + '_addNewRow()');
        //    addR.attr('onclick', strClick.substr(0, strClick.indexOf('(')) + '()');
        $('.' + obj.attr('id') + '-panelEdit').css({
            'background-color': '',
            'color': ''
        });

    } else {
        obj.bootstrapTable('insertRow', {
            index: 0,
            row: val
        });
    }

    clear_form_elements(obj.attr('id') + "-panelEdit");
    // $('.well').find('input').val('');
    //$(".select2-hidden-accessible").select2("val", "");
};

function clear_form_elements(class_name) {
    $("." + class_name).find(':input').each(function () {
        switch (this.type) {
            case 'password':
            case 'text':
            case 'textarea':
            case 'file':
            case 'select-one':
            case 'select-multiple':
            case 'date':
            case 'number':
            case 'tel':
            case 'email':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
                break;
        }
    });
}

core.clockpicker = function clockpicker() {

    var c = $('.clockpicker');

    c.keydown(function () {
        return false;
    });

    c.bind('paste drop', function (e) {
        e.preventDefault();
    });

    c.clockpicker({
        twelvehour: true,
        autoclose: false,
        donetext: "LISTO",
        twelvehour: false
        //autoclose: true
    });

};

core.closeContextMenu = function closeContextMenu() {
    if ($("#context-menu").length >= 1) {
        $("#context-menu").removeClass("open");
    }
};

core.notificationCount = function notificationCount() {
    $.ajax({
        url: core.SYS_URL + 'sys/noti/noti-serv/count/',
        type: "POST",
        global: false,
        data: {
            axn: 'count',
            skEstatus: 'EN'
        },
        success: function (result) {
            var q = '';
            var total = result.total;
            titlenotifier.max(99);
            titlenotifier.set(total);
            var badge = $('.badge-notifications');
            var notiCount = $('.notiCount ');

            if (total > 1) {
                q = 's';
            }
            if (total > 99) {
                total = '99+';
            }
            if (total === 0) {
                badge.addClass('badge-success').removeClass('badge-danger');
                notiCount.addClass('label-success').removeClass('label-danger');
            } else {
                badge.addClass('badge-danger').removeClass('badge-success');
                notiCount.addClass('label-danger').removeClass('label-success');
            }

            badge.html(total);
            badge.animateCss('rubberBand');
            notiCount.html(result.total + ' Nueva' + q);
        }
    });
};

core.notificationList = function notificationList() {
    $.ajax({
        url: core.SYS_URL + 'sys/noti/noti-serv/list/',
        type: "POST",
        global: false,
        data: {
            axn: 'list',
            skEstatus: 'EN'
        },
        success: function (result) {

            if (!result.data) {
                return;
            }

            $('.notidelo').html('');

            for (var i = 0; i < result.data.length; i++) {
                var object = result.data[i];

                var icon = object['sIcono'];
                var bgColor = object['sColor'];

                if (!bgColor) {
                    bgColor = 'bg-red-600';
                }
                if (!icon) {
                    icon = 'wb-order';
                }

                var skNotificacion = object['skNotificacion'];
                var skComportamientoModulo = object['skComportamiento'];
                var sUrl = '/' + core.DIR_PATH + object['sUrl'];

                if (!skComportamientoModulo){
                    skComportamientoModulo = 'RELO';
                }

                $('.notidelo').append(' <a id="' + skNotificacion + '" class="list-group-item" style="cursor: pointer" onclick="core.menuLoadModule({ skModulo:  \'Woodward\', url: \'' + sUrl + '\', skComportamiento: \'' + skComportamientoModulo + '\' }); core.notificationClick(\'' + skNotificacion + '\');" role="menuitem"> <div class="media"> <div class="media-left padding-right-10"> <i class="icon ' + icon + ' ' + bgColor + ' white icon-circle" aria-hidden="true"></i> </div><div class="media-body"> <h6 class="media-heading"> ' + object['sNombre'] + ' </h6> <p title="' + object['sMensaje'] + '" style="word-wrap: normal !important;white-space: nowrap !important;overflow: hidden !important;-o-text-overflow: ellipsis !important;text-overflow: ellipsis !important;width: 90% !important;">' + object['sMensaje'] + '</p> <time class="media-meta">' + object['dFechaCreacion'] + ' </time> </div></div></a>');

            }
        }
    });
};

core.notificationClick = function notificationClick(skNotificacion) {
    $.ajax({
        url: core.SYS_URL + 'sys/noti/noti-serv/read/',
        type: "POST",
        global: false,
        data: {
            axn: 'readNotification',
            skNotificacion: skNotificacion
        },
        success: function (result) {
            if (result.success) {
                $("#" + skNotificacion).remove();
                core.notificationCount();
                core.notificationList();
            }
        }
    });
};

core.skUserChat = "";
core.chatCount = function chatCount() {
    $.ajax({
        url: core.SYS_URL + 'sys/inic/inic-slid/count/',
        type: "POST",
        global: false,
        data: {
            axn: 'count'
        },
        success: function (result) {
            var total = result.total;
            var badge = $('.badge-chat');

            if (badge.html() == total) {
                return;
            }
            if (total > 99) {
                total = '99+';
            }

            if (total === 0) {
                badge.addClass('badge-success').removeClass('badge-danger');
            } else {
                badge.addClass('badge-danger').removeClass('badge-success');
            }

            badge.html(total);
            badge.animateCss('rubberBand');
        }
    });
};

//Obtener lista de contactos
core.chatList = function chatList() {
    $.ajax({
        type: "POST",
        url: core.SYS_URL + "sys/inic/inic-slid/panel-notificacion/",
        data: {
            axn: 'contactList'
        },
        cache: false,
        global: false,
        success: function (result) {

            $('.contacts').html('');

            if (!result.data) {
                return;
            }

            for (var i = 0; i < result.data.length; i++) {
                var object = result.data[i];

                var data = {};
                data['sNombre'] = object['sNombre'];
                data['skUsuario'] = object['skUsuario'];
                data['skArea'] = object['skArea'];
                data['skDepartamento'] = object['skDepartamento'];
                data['extension'] = object['extension'];
                data['sCorreo'] = object['sCorreo'];
                var json = JSON.stringify(data).replace(/"/g, "'");
                var nl = (object['NL'] > 0) ? 'nl-message' : ' na';
                var status = (object['status'] == "0") ? 'away' : 'online';

                var message = emojione.shortnameToUnicode(object['mensaje']);
                var output = emojione.shortnameToImage(object['mensaje']);

                $('.contacts').append('<a class="list-group-item ' + nl + '" role="button" data-toggle="show-chat" onclick="openChat(' + json + '); $( this ).removeClass(\'' + nl + '\');"> <div class="media"><div class="media-left"> <div class="avatar avatar-sm avatar-' + status + '"><img src="' + object['sFoto'] + '" alt="..."><i></i></div></div><div class="media-body"><h4 class="media-heading">' + object
                    ['sNombre'] + ' ' + object['sApellidoPaterno'] + '</h4><small class="text-line">' + output + '</small></div></div></a>');
            }
            $("#connectedCount").html(' ( ' + $(".site-sidebar-tab-content .avatar-online").length + ' )');
        },
        error: function (error) {
            //console.log(error);
        }
    });
};

/**
 *
 * @fileoverview    Solicita contraseña por sesion caducada
 *
 * @author         Jonathan Topete <jtopete@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 */
core.loginRefresh = function loginRefresh() {
    swal({
        title: "¡Sesión Finalizada!",
        text: "Por favor, introduzca su contraseña:",
        type: "input",
        inputType: "password",
        showLoaderOnConfirm: true,
        showCancelButton: false,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Contraseña",
        confirmButtonText: "Continuar"

    },
            function (inputValue) {
                if (inputValue === false)
                    return false;

                if (inputValue === "") {
                    swal.showInputError("Es necesario introducir la contraseña");
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: core.SYS_URL + "sys/inic/inic-sesi/iniciar-session/",
                    global: false,
                    data: {
                        axn: 'iniciarSession',
                        skEmpresaSocio: core.skEmpresaSocio,
                        skUsuario: core.skUsuario,
                        password: inputValue,
                        type: 'reingresar'
                    },
                    success: function (data) {

                        toastr.clear();

                        if (!data) {
                            swal("¡Error!", "Algo salió mal, contacte a un administrador", "error");
                        }

                        if (data.response == true) {
                            swal("¡Listo!", "Has Iniciado Sesión Correctamente", "success");
                            if (typeof pusher !== 'undefined'){
                                pusher.connect();
                            }
                        } else {
                            swal.showInputError("La contraseña es incorrecta");
                            return false;
                        }
                    }
                });
            });
};


/**
 *
 * @fileoverview    Cierre de sesión frontend
 *
 * @author         Jonathan Topete <jtopete@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 */
core.sessionOut = function sessionOut(data) {
    if (typeof data.sesionOut != "undefined") {
        if (typeof pusher !== 'undefined') {
            pusher.disconnect();
        }
        core.loginRefresh();
        return false;
    }
    return true;
};


/**
 *
 * @fileoverview    Detecta cambios en el formulario y evita perder datos
 *
 * @author         Jonathan Topete <jtopete@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 */
core.formChage = function formChage() {
    $('input, select, textarea').change(function () {
        $.ajaxSetup({
            beforeSend: function (data) {
            },
            complete: function (data) {
                if (typeof response == 'object' && !core.sessionOut(JSON.parse(data.responseText))) {
                    return false;
                }
            }
        });

        $(window).bind('beforeunload', function () {
            return '¿Está seguro que desea salir? Perderá los cambios';
        });
    });
};



/**
 *
 * @fileoverview    Genera un seríal de longitud especificada
 *
 * @author         Jonathan Topete <jtopete@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 * @param  len
 *
 */
core.generateSerial = function generateSerial(len) {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = len;
    var randomstring = '';

    for (var x = 0; x < string_length; x++) {

        var letterOrNumber = Math.floor(Math.random() * 2);
        if (letterOrNumber == 0) {
            var newNum = Math.floor(Math.random() * 9);
            randomstring += newNum;
        } else {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }

    }
    return randomstring;
};

core.digi = {};

core.digi.dedoURL = 'sys/digi/dedo-serv/descargar-documento/';
core.digi.eldoURL = 'sys/digi/eldo-serv/eliminar-documento/';
core.digi.agdoURL = 'sys/digi/agdo-serv/agregar-documento/';
core.digi.lidoURL = 'sys/digi/lido-serv/listar-documentos/';
core.digi.litdURL = 'sys/digi/litd-serv/listar-documentos/';

/*Funcionalidad antigua y descontinuada*/
core.digi.input = function (obj) {

};

core.digi.inputShow = function (obj) {

    this.domSelector = obj.sDomSelector;
    this.skDocSelector = '';
    this.selectByskDoc = '';
    this.allowedFiles = obj.allowedFiles;
    this.inputName = obj.inputName;
    this.maxFilesize = obj.maxFilesize;
    this.deleteCallback = '';
    this.uuid = Math.floor((Math.random() * 100) + 1);

    this.setInputDom = function setInputDom() {
        var that = this;
        var inputDom = $('<div class="col-md-12">').append(
                $(
                        '<input class="dropify"  type="file"' +
                        'id="input-file-max-fs" data-plugin="dropify"' +
                        'name="' + that.inputName + '" data-max-file-size="' + that.maxFilesize + 'M" ' +
                        'data-allowed-file-extensions="' + that.allowedFiles + '" />'
                        )
                );
console.log(inputDom);
        $(that.domSelector).empty().append(inputDom);

        that.handlers();
    };

    this.iconFileURL = function iconFileURL(e) {
        var r = '';
        var that = this;
        switch (e) {
            case 'pdf':
                r = core.SYS_URL + '/core/assets/tpl/global/photos/pdf.jpg';
                break;
            case 'doc':
                r = core.SYS_URL + '/core/assets/tpl/global/photos/word.jpg';
                break;
            case 'docx':
                r = core.SYS_URL + '/core/assets/tpl/global/photos/word.jpg';
                break;
            case 'xls':
                r = core.SYS_URL + '/core/assets/tpl/global/photos/excel.jpg';
                break;
            case 'xlsx':
                r = core.SYS_URL + '/core/assets/tpl/global/photos/excel.jpg';
                break;
            default:
                r = core.SYS_URL + '/core/assets/tpl/global/photos/placeholder.png';
                break;
        }
        return r;
    };

    this.setFileDom = function setFileDom(skDocumento, icon) {

        var that = this;

        var domLi = $('<li>').append(
                $('<div class="panel">').append(
                $('<figure class="overlay overlay-hover animation-hover">').append(
                $('<img class="caption-figure" src="' + icon + '" >'),
                $('<figcaption class="overlay-panel overlay-background overlay-fade text-center vertical-align">').append(
                $('<div class="btn-group">').append(
                $('<button type="button" class="btn btn-icon btn-pure btn-default btnDeleteDigiDocument' + that.uuid + that.inputName + '" title="Delete" data-digID="' + skDocumento + '">').append(
                $('<i class="icon wb-trash" aria-hidden="true">')
                )

                ),
                $('<a href="' + core.SYS_URL + core.digi.dedoURL + '?skDocumento=' + skDocumento + '&preview=1" target="_blank">').append(
                $('<button type="button" class="btn btn-outline btn-default project-button btnShowDigiDocument"  data-digiID="' + skDocumento + '">').append("Ver"))

                )
                )
                )
                );


        $(that.domSelector).empty().append($('<div class="form-group col-md-12 projects-sort">').append(
                $('<div class="col-md-10 app-projects projects-wrap" style="padding:15px; min-height: 110px;">').append(
                $('<ul style="list-style: none;" id="' + that.domSelector + 'ul' + '" data-plugin="animateList" data-child=">li">').append(domLi)
                )
                ));

        that.handlers();

    };

    this.handlers = function handlers() {
        var that = this;
        $('input[name="' + that.inputName + '"]').dropify();

        $('.btnDeleteDigiDocument' + that.uuid + that.inputName).click(function () {
            var skdoc = $(this).data('digid');
            var tipdoc = $(this).data('tdoc');

            swal({
                title: '¿Desea eliminar este documento?',
                text: 'Se eliminará el documento que seleccionó.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Aceptar',
                closeOnConfirm: false
            }, function () {
                var resp = false;

                $.ajax({
                    url: core.SYS_URL + core.digi.eldoURL,
                    type: 'POST',
                    data: {
                        skDocumento: skdoc
                    },
                    dataType: 'json',
                    async: false,
                    success: function (r) {
                        if (r.success === true) {
                            swal("Eliminado exitoso", resp.message, "success");
                            that.setInputDom();
                            that.deleteCallback();
                            delete window.digiInputs[settings.name].DocumentList[skdoc];
                        } else {
                            swal("Error al eliminar documento", resp.message, "error");
                        }
                    }

                });

            }
            );


        });


    };

    this.getInputFile = function getInputFile() {
        var that = this;

        if ($('input[name="' + that.inputName + '"]').length === 0) {
            return false;
        }

        if (typeof ($('input[name="' + that.inputName + '"]').prop('files')[0]) === 'object') {
            return  $('input[name="' + that.inputName + '"]').prop('files')[0];
        }

        return false;

    };

    this.run = function run() {


        var that = this;
        var selectionDocs = {};

        if (typeof (obj.skDocumento) === "undefined") {
            if (!obj.metadatos || 0 === obj.metadatos.length) {
                that.selectByskDoc = false;
                that.skDocSelector = false;
            } else {
                that.skDocSelector = obj.metadatos;
                that.selectByskDoc = false;
            }
        } else {
            if (!obj.skDocumento || 0 === obj.skDocumento.length) {
                that.selectByskDoc = false;
                that.skDocSelector = false;
            } else {
                that.skDocSelector = obj.skDocumento;
                that.selectByskDoc = true;
            }

        }

        if (typeof (obj.deleteCallback) === "function") {
            that.deleteCallback = obj.deleteCallback;
        } else {
            that.deleteCallback = function () {};
        }


        if (that.selectByskDoc) {
            selectionDocs.skDocumento = that.skDocSelector;
        } else {
            selectionDocs.METADATOS = that.skDocSelector;
        }

        if (that.skDocSelector === false) {
            that.setInputDom();
            return;
        }

        $.ajax({
            url: core.SYS_URL + core.digi.lidoURL,
            type: 'POST',
            data: selectionDocs,
            dataType: 'json',
            async: true,
            success: function (res) {

                if (res !== false && res.data.length > 0 && res.success === true) {
                    var extenciontl = res.data[0].sExtension;

                    that.setFileDom(res.data[0].skDocumento, that.iconFileURL(extenciontl));
                } else {
                    that.setInputDom();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error("Error al obtener los documentos");
            }
        });


    };

};

$.fn.core_docu_component = function (opt) {
    if(typeof (window.core_docu_documents) === 'undefined'){
        window.core_docu_documents = {};
    }
    
    /**
     * Opciones por default.
     * @type Object
     */
    var settings = $.extend({
        skTipoExpediente: 'EXGRAL',
        skTipoDocumento: 'DOGRAL',
        name: 'docu_file',
        skDocumento: '',
        caracteristicas: '',
        readOnly: false,
        allowDelete: true,
        forceSingleFile: false,
        deleteCallBack: function (obj) {}
    }, opt);
    
    /**
     * Establece mensaje de error en caso de no poder cargar componentes.
     *
     * @param {object} info
     * @returns {undefined}
     */
    this.errorShow = function (info) {
        console.error(info);
        this.append('<blockquote class="blockquote blockquote-danger">\n\
            <p>Hubo un error al inicializar el componente de Documentación</p>\n\
            <footer><cite title="Source Title"> Intenta nuevamente </cite></footer></blockquote>');
    };
    
    /**
     * Crea una nueva instancia de Dropzone en el namespace window.digiInput
     * y muestra los archivos que existan basados en el selector definido.
     *
     * @param {object} config
     * @returns {undefined}
     */
    this.setDropzonetl = function (config) {
        
        //console.log('config_setDropzonetl: ', config);

        var f = '';
        for (var i in config.extensiones) {

            f = f + '.' + config.extensiones[i];
            if (parseInt(i) !== config.extensiones.length - 1) {
                f = f + ',';
            }
        }
        
        var idName = config.skTipoExpediente + config.skTipoDocumento + settings.name;
        this.append('<div class="dropzone clsbox " id="' + idName + '"></div>');
        
        var dcfig = typeof (opt.dropzoneConfig) === 'object' ? opt.dropzoneConfig : {};
        var DropzoneConfig = $.extend({
            url: core.SYS_URL + 'sys/docu/docu-serv/documentos-service/?axn=guardar',
            maxFilesize: config.pesoMB,
            dictFileTooBig: 'El archivo es demasiado grande, Peso Máximo: '+ config.pesoMB + 'MB',
            addRemoveLinks: true,
            //dictRemoveFileConfirmation: true,
            replace: '<i class="icon fa-cloud-upload" aria-hidden="true"></i> Arrastre un archivo o haga clic en reemplazar <br> Solo se permiten '  + config.extensiones.join(','),
            autoProcessQueue: false,
            acceptedFiles: f,
            dictInvalidFileType: 'Archivo NO Permitido, Extensiones Permitidas: ' + config.extensiones.join(','),
            dictRemoveFile: (settings.allowDelete ? '<b><i class="icon fa-trash" aria-hidden="true"></i> Eliminar</b>' : '   '),
            dictDefaultMessage: 'Expediente: <b>'+config.tipoExpediente+'</b> | Documento: <b>'+config.tipoDocumento+'</b><br>Peso Máximo: <b>'+config.pesoMB+'MB</b> | Extensiones Permitidas: <b>' + config.extensiones.join(',') + '</b><br><i class="icon fa-cloud-upload" aria-hidden="true"></i> Arrastre y suelte archivos o haga clic',
            paramName: settings.name,
            removedfile: function (file) {
                if (!file.hasOwnProperty('skDocumento')) {
                    //file.previewElement.remove();
                    //return true;

                    swal({
                        title: '¡Notificación!',
                        text: '¿Desea eliminar este documento?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Aceptar',
                        closeOnConfirm: false
                    }, function () {
                        file.previewElement.remove();
                        swal.close();
                    });
                    return true;

                }
                swal({
                    title: '¡Notificación!',
                    text: '¿Desea eliminar este documento?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Aceptar',
                    closeOnConfirm: false
                }, function () {
                    var resp = false;
                    $.ajax({
                        url: core.SYS_URL + 'sys/docu/docu-serv/documentos-service/?axn=eliminar',
                        type: 'POST',
                        data: {
                            skDocumento: file.skDocumento
                        },
                        dataType: 'json',
                        async: true,
                        success: function (r) {
                            if (r.success === true) {
                                file.previewElement.remove();
                                settings.deleteCallBack({digiResponse: r, skDocumento: file.skDocumento});
                                var deleteoIntenso = window.core_docu_documents[settings.name].skDocumentos.indexOf(file.skDocumento);
                                if (deleteoIntenso > -1) {
                                    window.core_docu_documents[settings.name].skDocumentos.splice(deleteoIntenso, 1);
                                }
                                swal("Documento eliminado con éxito", resp.message, "success");
                            } else {
                                settings.deleteCallBack({digiResponse: r, skDocumento: file.skDocumento});
                                swal("Hubo un error al eliminar el documento", resp.message, "error");
                            }
                        }
                    });
                });

            }
        }, dcfig);
        
        
        window.core_docu_documents[settings.name] = new Dropzone("#" + idName, DropzoneConfig);
        window.core_docu_documents[settings.name].skDocumentos = [];
        window.core_docu_documents[settings.name].DocumentList = {};
        for (var ledoc in config.docs) {
            var turboDoc = config.docs[ledoc];
            var mockFile = {name: turboDoc.sUbicacion.split('/').pop(), skDocumento: turboDoc.skDocumento};
            window.core_docu_documents[settings.name].emit("addedfile", mockFile);
            window.core_docu_documents[settings.name].emit("thumbnail", mockFile, turboDoc.sUbicacionPublicaThumbnail);
            window.core_docu_documents[settings.name].emit("complete", mockFile);
            window.core_docu_documents[settings.name].skDocumentos.push(turboDoc.skDocumento);
            window.core_docu_documents[settings.name].DocumentList[turboDoc.skDocumento] = config.docs[ledoc];
        }
        
        var leSwag = 0;
        $("#" + idName + ' div.dz-size').each(function () {
            var buton = '<a href="' + config.docs[leSwag].sUbicacionPublica + '" target="_blank"> \n\
                <button style="border-radius: 5px;" type="button" class="btn btn-outline btn-default project-button "> <b>VER</b> </button>\n\
            </a>\n';
            $(this).empty().append(buton);
            leSwag = leSwag + 1;
        });
        $("#" + idName + ' div.dz-image>img').css('height', '95px');


        window.core_docu_documents[settings.name].getInputFile = function () {
            return window.core_docu_documents[settings.name].getAcceptedFiles();
        };
        
    };
    
    
    /**
     * Llama la funcion de que crea el objeto dropify o el previsualizador de
     * archivo si este posee un registro en digitalzacion.
     * @param {object} config
     * @returns {undefined}
     */
    this.setDropifytl = function (config) {
        if (config.docs.length > 0) {
            this.dropifaiFILEDOM(config);
        } else {
            this.dropifaitlDOM(config);
        }
    };
    
    /**
     * Crea el DOM necesario para ejecutar Dropify.
     *
     * @param {object} config
     * @returns {undefined}
     */
    this.dropifaitlDOM = function (config) {
        
        //console.log('config_dropifaitlDOM: ', config);

        var le = '<div class="col-md-12"> \n\
            <input class="dropify"  type="file" data-plugin="dropify" \n\
            name="' + settings.name + '" data-max-file-size="' + config.pesoMB + 'M" \n\
            data-allowed-file-extensions="' + config.extensiones.join(' ') + '" />\n\
        </div>';
        this.empty().append(le);
        $('input[name="' + settings.name + '"]').dropify({
            "messages": {
                default: "Expediente: <b>"+config.tipoExpediente+"</b> | Documento: <b>"+config.tipoDocumento+"</b><br>Peso Máximo: <b>"+config.pesoMB+"MB</b> | Extensiones Permitidas: <b>" + config.extensiones.join(',') + "</b><br>Arrastre y suelte archivos o haga clic",
                replace: "Expediente: <b>"+config.tipoExpediente+"</b> | Documento: <b>"+config.tipoDocumento+"</b><br>Peso Máximo: <b>"+config.pesoMB+"MB</b> | Extensiones Permitidas: <b>" + config.extensiones.join(',') + "</b><br>Arrastre y suelte archivos o haga clic",
                remove: '<b><i class="icon fa-trash" aria-hidden="true"></i> Eliminar</b>',
                error: 'Revise la Configuración del Componente de Documentación'
            },
            "error": {
                fileSize: '<i class="icon fa-exclamation-triangle" aria-hidden="true"></i> El archivo es demasiado grande<br> Peso Máximo: '+ config.pesoMB + 'MB',
                fileExtension: '<i class="icon fa-exclamation-triangle" aria-hidden="true"></i> Archivo NO Permitido<br> Extensiones Permitidas: ' + config.extensiones.join(','),
            }
        });

        window.core_docu_documents[settings.name] = {};
        window.core_docu_documents[settings.name].skDocumentos = [];
        window.core_docu_documents[settings.name].getInputFile = function () {

            if (typeof ($('input[name="' + settings.name + '"]').prop('files')[0]) === 'object') {
                return  $('input[name="' + settings.name + '"]').prop('files')[0];
            }

            return false;
        };


    };
    
    /**
     * Crea el DOM y los handlers para el visualizador de archivos.
     * @param {object} config
     * @returns {undefined}
     */
    this.dropifaiFILEDOM = function (config) {
        var that = this;

        window.core_docu_documents[settings.name] = {};
        window.core_docu_documents[settings.name].getInputFile = function () {
            return false;
        };
        window.core_docu_documents[settings.name].skDocumentos = [config.docs[0].skDocumento];

        var deleteoIntenso = (settings.allowDelete == true) ? '<div class="btn-group">\n\
            <button type="button" class="btn btn-icon btn-pure btn-default btnDeleteDigiDocument' + settings.name + config.skTipoExpediente + config.skTipoDocumento + '" title="Delete" data-digid="' + config.docs[0].skDocumento + '">\n\
                <i class="icon wb-trash" aria-hidden="true"></i>\n\
            </button> \n\
        </div>' : '';

        this.append('\
        <div class="form-group col-md-12 projects-sort">\n\
            <div class="col-md-10 app-projects projects-wrap" style="padding:15px; min-height: 215px;">\n\
                <ul style="list-style: none;" id="' + config.skTipoExpediente + config.skTipoDocumento + 'ul' + '" data-plugin="animateList" data-child=">li">\n\
                    <li>\n\
                        <div class="panel">  \n\
                            <figure class="overlay overlay-hover animation-hover">\n\
                                <img class="caption-figure" style="height: 150px;" src="' + config.docs[0].sUbicacionPublicaThumbnail + '" >\n\
                                <figcaption class="overlay-panel overlay-background overlay-fade text-center vertical-align"> \n\
                                    ' + deleteoIntenso + '\n\
                                    <a href="' + config.docs[0].sUbicacionPublica + '" target="_blank">\n\
                                        <button type="button" class="btn btn-outline btn-default project-button btnShowDigiDocument"  data-digiID="' + config.docs[0].skDocumento + '"> VER </button>\n\
                                    </a>\n\
                                <figure> \n\
                            <figure>\n\
                        </div>\n\
                    </li>\n\
                </ul>\n\
            </div>\n\
        </div>');

        if (settings.allowDelete == true) {

            $('.btnDeleteDigiDocument' + settings.name + config.skTipoExpediente + config.skTipoDocumento).click(function (e) {
                var skdoc = $(this).data('digid');

                swal({
                    title: '¡Notificación!',
                    text: '¿Desea eliminar este documento?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Aceptar',
                    closeOnConfirm: false
                }, function () {
                    var resp = false;
                    $.ajax({
                        url: core.SYS_URL + 'sys/docu/docu-serv/documentos-service/?axn=eliminar',
                        type: 'POST',
                        data: {
                            skDocumento: skdoc
                        },
                        dataType: 'json',
                        async: false,
                        success: function (r) {
                            if (r.success === true) {
                                that.dropifaitlDOM(config);
                                settings.deleteCallBack({digiResponse: r, skDocumento: skdoc});
                                var deleteoIntenso = window.core_docu_documents[settings.name].skDocumentos.indexOf(skdoc);
                                if (deleteoIntenso > -1) {
                                    window.core_docu_documents[settings.name].skDocumentos.splice(deleteoIntenso, 1);
                                }
                                swal("Documento eliminado con éxito", resp.message, "success");
                            } else {
                                swal("Hubo un error al eliminar el documento", resp.message, "error");
                            }
                        }
                    });
                }
                );
                e.stopPropagation();
            });
        }
    };
    
    /**
     * readOnlyItem
     *
     * Crea los elementos a visualizar.
     *
     * @param {type} doc
     * @returns {String}
     */
    this.readOnlyItem = function (doc) {
        return '<div class="dz-preview dz-complete dz-image-preview">\n\
                    <div class="dz-image">\n\
                        <img data-dz-thumbnail="" alt="Factura comercial_PDOC_007.docx" \n\
                            src="' + doc.sUbicacionPublicaThumbnail + '" \n\
                            style="height: 95px;">\n\
                    </div>\n\
                    <div class="dz-details">\n\
                        <div class="dz-size">\n\
                            <a href="' + doc.sUbicacionPublica + '" target="_blank">\n\
                                <button style="border-radius: 5px;" type="button" class="btn btn-outline btn-default project-button "> <b>VER</b> </button>\n\
                            </a>\n\
                        </div>\n\
                        <div class="dz-filename"><span data-dz-name="">' + doc.sUbicacion.split('/').pop() + '</span>\n\
                        </div>\n\
                    </div>\n\
                </div>';
    };
    
    /**
     * readOnlyDOM
     *
     * Crea el dom para almacenar los items.
     *
     * @param {type} data
     * @returns {undefined}
     */
    this.readOnlyDOM = function (data) {
        var that = this;

        var idName = settings.skTipoExpediente + settings.skTipoDocumento + settings.name;

        that.empty().append('<div class="dropzone " style="border:none; border-radius:0px; background:none; max-height: 240px; overflow-x: auto; " id="leHold' + idName + '"></div>');

        for (var i in data) {
            var intemtl = data[i];
            $('#leHold' + idName).append(that.readOnlyItem(intemtl));
        }

    };
    
    this.loadComposer = function () {
        var ledatinis = {};

        if(settings.skDocumento != ''){
            ledatinis['skDocumento'] = settings.skDocumento;
        }else if(settings.caracteristicas != ''){
            ledatinis['caracteristicas'] = settings.caracteristicas;
        }else{
            ledatinis['skTipoExpediente'] = settings.skTipoExpediente;
            ledatinis['skTipoDocumento'] = settings.skTipoDocumento;
        }

        // LISTAMOS LOS DOCUMENTOS RECIBIDOS DESDE LA VISTA //
        if (!jQuery.isEmptyObject(settings.lidoDataSet)) {
            that.empty();
            var conf = {
                skTipoExpediente: settings.skTipoExpediente,
                tipoExpediente: settings.expeData.tipoExpediente,
                skTipoDocumento: settings.skTipoDocumento,
                tipoDocumento: settings.expeData.tipoDocumento,
                pesoMB: settings.expeData.caracteristicas.SIZEDO.sValor,
                extensiones: settings.expeData.extensiones,
                docs: []
            };

            if (settings.readOnly) {
                that.readOnlyDOM(settings.lidoDataSet.data);
            } else {
                if (typeof (settings.expeData.caracteristicas.MULTIP) != 'undefined') {
                    if (settings.expeData.caracteristicas.MULTIP.sValor && !settings.forceSingleFile) {
                        that.setDropzonetl(conf);
                    } else {
                        that.setDropifytl(conf);
                    }
                }else{
                    that.setDropifytl(conf);
                }
            }

            return;
        }

        // OBTENEMOS LOS DOCUMENTOS GUARDADOS PREVIAMENTE //
        $.ajax({
            url: core.SYS_URL + 'sys/docu/docu-serv/documentos-service/?axn=get_documentos',
            type: 'POST',
            data: ledatinis,
            dataType: 'json',
            async: true,
            success: function (res) {
                that.empty();
                var conf = {
                    skTipoExpediente: settings.skTipoExpediente,
                    tipoExpediente: settings.expeData.tipoExpediente,
                    skTipoDocumento: settings.skTipoDocumento,
                    tipoDocumento: settings.expeData.tipoDocumento,
                    extensiones: settings.expeData.extensiones,
                    pesoMB: settings.expeData.caracteristicas.SIZEDO.sValor,
                    docs: res.data
                };

                if (settings.readOnly) {
                    that.readOnlyDOM(res.data);
                } else {
                    if (typeof (settings.expeData.caracteristicas.MULTIP) != 'undefined') {
                        if (settings.expeData.caracteristicas.MULTIP.sValor && !settings.forceSingleFile) {
                            that.setDropzonetl(conf);
                        } else {
                            that.setDropifytl(conf);
                        }
                    }else{
                        that.setDropifytl(conf);
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                that.errorShow({
                    paramAjaxInfo: {
                        skTipoExpediente: settings.skTipoExpediente,
                        skTipoDocumento: settings.skTipoDocumento
                    },
                    jqXHR: jqXHR,
                    textStatus: textStatus,
                    errorThrown: errorThrown
                });
            }
        });
        
    };
    
    // OBTENEMOS LA CONFIGURACIÓN DEL DOCUMENTO //
    this.getExpeData = function(){
        var that = this;
        $.ajax({
            url: core.SYS_URL + 'sys/docu/docu-serv/documentos-service/?axn=configuracion_tipoExpediente_tipoDocumento',
            type: 'POST',
            data: {
                skTipoExpediente: settings.skTipoExpediente,
                skTipoDocumento: settings.skTipoDocumento
            },
            dataType: 'json',
            async: true,
            success: function (res) {
                settings.expeData = res.data;
                that.loadComposer();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                
                that.errorShow({
                    paramAjaxInfo: {
                        skTipoExpediente: settings.skTipoExpediente,
                        skTipoDocumento: settings.skTipoDocumento
                    },
                    jqXHR: jqXHR,
                    textStatus: textStatus,
                    errorThrown: errorThrown
                });
            }
        });

    };

    var that = this;
    this.empty();
    this.getExpeData();

    return this;
    
};

/**
 * Plugin de digitalizacion.
 *
 * Crea una instancia de dropify (Input unico) o Dropzone(Input multiple)
 * para un tipo de documento especifico de digitalizacion.
 *
 * USO:
 *
 * $('selector').digiInput({
 *  name: 'NombreDeObjetoEinputs',
 *  expediente: 'EXPED',
 *  tipdoc: 'LEDOC',
 *  selector: '[{ le metadatos de seleccion para digitalizacion}]'
 *  skDocumento: 'Char 36 de un documentotl',
 *  allowDelete: true, // Pedmitir eliminar documento(s)
 *  lidoDataSet: {}, // Puedes proveer los datos si ya los tienes
 *  readOnly: false, // Modo de solo lectura.
 *  forceSingleFile: false, // Forza a cargar el input unico
 *  deleteCallBack : function(obj){
 *      console.info('Turbo funcion para despues de eliminado.');
 *  }
 * });
 *
 * En caso de crear un objeto Dropzone para multiples archivos, su instancia se
 * almacena en la super-global window.digiInputs.NOMBRE, dicho NOMBRE se obtiene
 * de la combinacion de expediente con tipo de documento, ejemplo:
 *
 * Expediente > PREV + Tipo documento > FCOM = PREVFCOM
 *
 *
 * @param {object} opt objeto de configuracion
 * @returns {$.fn.digiInput}
 */
$.fn.digiInput = function (opt) {


    if (typeof (window.digiInputs) === 'undefined') {
        window.digiInputs = {};
    }

    /**
     * Opciones por default.
     * @type Object
     */
    var settings = $.extend({
        name: 'NombreZukistrukis',
        expediente: 'TURBOERRORDELASIT',
        tipdoc: 'TURBOERRORDELASIT',
        selector: '[{"clave":"TIPDOC","valor":"0"},{"clave":"EXPEDI","valor":"0"}]',
        lidoDataSet: {},
        skDocumento: '',
        allowDelete: false,
        forceSingleFile: false,
        readOnly: false,
        _expeData: false,
        deleteCallBack: function (obj) {}
    }, opt);

    /**
     * Establece mensaje de error en caso de no poder cargar componentes.
     *
     * @param {object} info
     * @returns {undefined}
     */
    this.errorShow = function (info) {
        console.error(info);
        this.append('<blockquote class="blockquote blockquote-danger">\n\
            <p>No se pueden cargar y mostrar estos archivos en éste momento.</p>\n\
            <footer><cite title="Source Title"> Intente mas tarde </cite></footer></blockquote>');
    };

    /**
     * Crea una nueva instancia de Dropzone en el namespace window.digiInput
     * y muestra los archivos que existan basados en el selector definido.
     *
     * @param {object} config
     * @returns {undefined}
     */
    this.setDropzonetl = function (config) {

        var f = '';
        for (var i in config.extensiones) {

            f = f + '.' + config.extensiones[i];
            if (parseInt(i) !== config.extensiones.length - 1) {
                f = f + ',';
            }
        }
        var idName = config.expedi + config.tipdoc + settings.name;
        this.append('<div class="dropzone clsbox " id="' + idName + '"></div>');


        var dcfig = typeof (opt.dropzoneConfig) === 'object' ? opt.dropzoneConfig : {};
        var DropzoneConfig = $.extend({
            url: core.SYS_URL + core.digi.agdoURL,
            maxFilesize: (config.peso / 1024),
            addRemoveLinks: true,
            autoProcessQueue: false,
            acceptedFiles: f,
            dictRemoveFile: (settings.allowDelete ? 'Eliminar' : '   '),
            dictDefaultMessage: "<b> Arrastre y suelte archivos o haga clic.<b><br>Solo se permiten: " + f,
            paramName: settings.name,
            removedfile: function (file) {
                if (!file.hasOwnProperty('skDocumento')) {
                    file.previewElement.remove();
                    return true;
                }
                swal({
                    title: '¿Desea eliminar este documento?',
                    text: 'Se eliminará el documento que seleccionó.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Aceptar',
                    closeOnConfirm: false
                }, function () {
                    var resp = false;
                    $.ajax({
                        url: core.SYS_URL + core.digi.eldoURL,
                        type: 'POST',
                        data: {
                            skDocumento: file.skDocumento
                        },
                        dataType: 'json',
                        async: true,
                        success: function (r) {
                            if (r.success === true) {
                                file.previewElement.remove();
                                settings.deleteCallBack({digiResponse: r, skDocumento: file.skDocumento});
                                var deleteoIntenso = window.digiInputs[settings.name].skDocumentos.indexOf(file.skDocumento);
                                if (deleteoIntenso > -1) {
                                    window.digiInputs[settings.name].skDocumentos.splice(deleteoIntenso, 1);
                                }

                                swal("Eliminado exitoso", resp.message, "success");
                            } else {
                                settings.deleteCallBack({digiResponse: r, skDocumento: file.skDocumento});
                                swal("Error al eliminar documento", resp.message, "error");
                            }
                        }
                    });
                }
                );

            }
        }, dcfig);

        window.digiInputs[settings.name] = new Dropzone("#" + idName, DropzoneConfig);
        window.digiInputs[settings.name].skDocumentos = [];
        window.digiInputs[settings.name].DocumentList = {};
        for (var ledoc in config.docs) {
            var turboDoc = config.docs[ledoc];
            var mockFile = {name: turboDoc.sUbicacion.split('/').pop(), skDocumento: turboDoc.skDocumento};
            window.digiInputs[settings.name].emit("addedfile", mockFile);
            window.digiInputs[settings.name].emit("thumbnail", mockFile, core.SYS_URL + core.digi.dedoURL + '?preview=1&thumbnail=1&skDocumento=' + turboDoc.skDocumento);
            window.digiInputs[settings.name].emit("complete", mockFile);
            window.digiInputs[settings.name].skDocumentos.push(turboDoc.skDocumento);
            window.digiInputs[settings.name].DocumentList[turboDoc.skDocumento] = config.docs[ledoc];
        }

        var leSwag = 0;
        $("#" + idName + ' div.dz-size').each(function () {
            var buton = '<a href="' + core.SYS_URL + core.digi.dedoURL + '?skDocumento=' + config.docs[leSwag].skDocumento + '&preview=1" target="_blank"> \n\
                <button style="border-radius: 5px;" type="button" class="btn btn-outline btn-default project-button "> <b>VER</b> </button>\n\
            </a>\n';
            $(this).empty().append(buton);
            //$(this).empty().append('<strong class="multiDigiDocView" data-skdocumento="' + config.docs[leSwag].skDocumento + '" >VER<strong>');
            leSwag = leSwag + 1;
        });
        $("#" + idName + ' div.dz-image>img').css('height', '95px');


        window.digiInputs[settings.name].getInputFile = function () {
            return window.digiInputs[settings.name].getAcceptedFiles();
        };

    };

    /**
     * Llama la funcion de que crea el objeto dropify o el previsualizador de
     * archivo si este posee un registro en digitalzacion.
     * @param {object} config
     * @returns {undefined}
     */
    this.setDropifytl = function (config) {
        if (config.docs.length > 0) {
            this.dropifaiFILEDOM(config);
        } else {
            this.dropifaitlDOM(config);
        }
    };

    /**
     * Crea el DOM necesario para ejecutar Dropify.
     *
     * @param {object} config
     * @returns {undefined}
     */
    this.dropifaitlDOM = function (config) {
        var le = '<div class="col-md-12"> \n\
            <input class="dropify"  type="file" data-plugin="dropify" \n\
            name="' + settings.name + '" data-max-file-size="' + (config.peso / 1024) + 'M" \n\
            data-allowed-file-extensions="' + config.extensiones.join(' ') + '" />\n\
        </div>';
        this.empty().append(le);
        $('input[name="' + settings.name + '"]').dropify({
            "messages": {
                default: 'Arrastre un archivo o haga clic aquí. <br> Solo se permiten ' + config.extensiones.join(','),
                replace: 'Arrastre un archivo o haga clic en reemplazar. <br> Solo se permiten '  + config.extensiones.join(','),
                remove: 'Eliminar',
                error: 'Lo sentimos, el archivo demasiado grande. <br> El limite de peso: '+ (config.peso / 1024) + 'mb'
            }
        });

        window.digiInputs[settings.name] = {};
        window.digiInputs[settings.name].skDocumentos = [];
        window.digiInputs[settings.name].getInputFile = function () {

            if (typeof ($('input[name="' + settings.name + '"]').prop('files')[0]) === 'object') {
                return  $('input[name="' + settings.name + '"]').prop('files')[0];
            }

            return false;
        };


    };

    /**
     * Crea el DOM y los handlers para el visualizador de archivos.
     * @param {object} config
     * @returns {undefined}
     */
    this.dropifaiFILEDOM = function (config) {
        var that = this;

        window.digiInputs[settings.name] = {};
        window.digiInputs[settings.name].getInputFile = function () {
            return false;
        };
        window.digiInputs[settings.name].skDocumentos = [config.docs[0].skDocumento];

        var deleteoIntenso = (settings.allowDelete == true) ? '<div class="btn-group">\n\
            <button type="button" class="btn btn-icon btn-pure btn-default btnDeleteDigiDocument' + settings.name + config.expedi + config.tipdoc + '" title="Delete" data-digid="' + config.docs[0].skDocumento + '">\n\
                <i class="icon wb-trash" aria-hidden="true"></i>\n\
            </button> \n\
        </div>' : '';

        this.append('\
        <div class="form-group col-md-12 projects-sort">\n\
            <div class="col-md-10 app-projects projects-wrap" style="padding:15px; min-height: 215px;">\n\
                <ul style="list-style: none;" id="' + config.expedi + config.tipdoc + 'ul' + '" data-plugin="animateList" data-child=">li">\n\
                    <li>\n\
                        <div class="panel">  \n\
                            <figure class="overlay overlay-hover animation-hover">\n\
                                <img class="caption-figure" style="height: 150px;" src="' + core.SYS_URL + core.digi.dedoURL + '?preview=1&thumbnail=1&skDocumento=' + config.docs[0].skDocumento + '" >\n\
                                <figcaption class="overlay-panel overlay-background overlay-fade text-center vertical-align"> \n\
                                    ' + deleteoIntenso + '\n\
                                    <a href="' + core.SYS_URL + core.digi.dedoURL + '?skDocumento=' + config.docs[0].skDocumento + '&preview=1" target="_blank">\n\
                                        <button type="button" class="btn btn-outline btn-default project-button btnShowDigiDocument"  data-digiID="' + config.docs[0].skDocumento + '"> VER </button>\n\
                                    </a>\n\
                                <figure> \n\
                            <figure>\n\
                        </div>\n\
                    </li>\n\
                </ul>\n\
            </div>\n\
        </div>');

        if (settings.allowDelete == true) {

            $('.btnDeleteDigiDocument' + settings.name + config.expedi + config.tipdoc).click(function (e) {
                var skdoc = $(this).data('digid');

                swal({
                    title: '¿Desea eliminar este documento?',
                    text: 'Se eliminará el documento que seleccionó.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Aceptar',
                    closeOnConfirm: false
                }, function () {
                    var resp = false;
                    $.ajax({
                        url: core.SYS_URL + core.digi.eldoURL,
                        type: 'POST',
                        data: {
                            skDocumento: skdoc
                        },
                        dataType: 'json',
                        async: false,
                        success: function (r) {
                            if (r.success === true) {
                                that.dropifaitlDOM(config);
                                settings.deleteCallBack({digiResponse: r, skDocumento: skdoc});
                                var deleteoIntenso = window.digiInputs[settings.name].skDocumentos.indexOf(skdoc);
                                if (deleteoIntenso > -1) {
                                    window.digiInputs[settings.name].skDocumentos.splice(deleteoIntenso, 1);
                                }
                                swal("Eliminado exitoso", resp.message, "success");
                            } else {
                                swal("Error al eliminar documento", resp.message, "error");
                            }
                        }
                    });
                }
                );
                e.stopPropagation();
            });
        }
    };

    /**
     * readOnlyItem
     *
     * Crea los elementos a visualizar.
     *
     * @param {type} doc
     * @returns {String}
     */
    this.readOnlyItem = function (doc) {
        return '<div class="dz-preview dz-complete dz-image-preview">\n\
                    <div class="dz-image">\n\
                        <img data-dz-thumbnail="" alt="Factura comercial_PDOC_007.docx" \n\
                            src="' + core.SYS_URL + core.digi.dedoURL + '?preview=1&thumbnail=1&skDocumento=' + doc.skDocumento + '" \n\
                            style="height: 95px;">\n\
                    </div>\n\
                    <div class="dz-details">\n\
                        <div class="dz-size">\n\
                            <a href="' + core.SYS_URL + core.digi.dedoURL + '?skDocumento=' + doc.skDocumento + '&preview=1" target="_blank">\n\
                                <button style="border-radius: 5px;" type="button" class="btn btn-outline btn-default project-button "> <b>VER</b> </button>\n\
                            </a>\n\
                        </div>\n\
                        <div class="dz-filename"><span data-dz-name="">' + doc.sUbicacion.split('/').pop() + '</span>\n\
                        </div>\n\
                    </div>\n\
                </div>';
    };

    /**
     * readOnlyDOM
     *
     * Crea el dom para almacenar los items.
     *
     * @param {type} data
     * @returns {undefined}
     */
    this.readOnlyDOM = function (data) {
        var that = this;

        var idName = settings.expediente + settings.tipdoc + settings.name;

        that.empty().append('<div class="dropzone " style="border:none; border-radius:0px; background:none; max-height: 240px; overflow-x: auto; " id="leHold' + idName + '"></div>');

        for (var i in data) {
            var intemtl = data[i];
            $('#leHold' + idName).append(that.readOnlyItem(intemtl));
        }

    };

    this.loadComposer = function () {
        var ledatinis = {};

        if (settings.skDocumento.length === 36) {
            ledatinis['skDocumento'] = settings.skDocumento;
        } else {
            ledatinis['metadatos'] = settings.selector;
        }

        if (!jQuery.isEmptyObject(settings.lidoDataSet)) {

            that.empty();
            var conf = {
                expedi: settings.expediente,
                tipdoc: settings.tipdoc,
                extensiones: settings.expeData.extensiones,
                peso: settings.expeData.peso,
                docs: settings.lidoDataSet.data
            };

            if (settings.readOnly) {
                that.readOnlyDOM(settings.lidoDataSet.data);
            } else {
                if (settings.expeData.data.multiple && !settings.forceSingleFile) {
                    that.setDropzonetl(conf);
                } else {
                    that.setDropifytl(conf);
                }
            }

            return;
        }

        $.ajax({// Consulta de documento(s) existentes basado en selector o skDocumento
            url: core.SYS_URL + core.digi.lidoURL,
            type: 'POST',
            data: ledatinis,
            dataType: 'json',
            async: true,
            success: function (r) {
                that.empty();
                var conf = {
                    expedi: settings.expediente,
                    tipdoc: settings.tipdoc,
                    extensiones: settings.expeData.extensiones,
                    peso: settings.expeData.peso,
                    docs: r.data
                };

                if (settings.readOnly) {
                    that.readOnlyDOM(r.data);
                } else {
                    if (settings.expeData.multiple && !settings.forceSingleFile) {
                        that.setDropzonetl(conf);
                    } else {
                        that.setDropifytl(conf);
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                that.errorShow({
                    paramAjaxInfo: {
                        skTipoExpediente: settings.expediente,
                        skTipoDocumento: settings.tipdoc
                    },
                    jqXHR: jqXHR,
                    textStatus: textStatus,
                    errorThrown: errorThrown
                });
            }
        });
    };

    this.getExpeData = function(){
        var that = this;
        $.ajax({// Consulta de datos de expediente y tipo de documento
            url: core.SYS_URL + core.digi.litdURL,
            type: 'POST',
            data: {
                skTipoExpediente: settings.expediente,
                skTipoDocumento: settings.tipdoc
            },
            dataType: 'json',
            async: true,
            success: function (res) {
                settings.expeData = res.data;
                that.loadComposer();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                that.errorShow({
                    paramAjaxInfo: {
                        skTipoExpediente: settings.expediente,
                        skTipoDocumento: settings.tipdoc
                    },
                    jqXHR: jqXHR,
                    textStatus: textStatus,
                    errorThrown: errorThrown
                });
            }
        });

    };

    var that = this;
    this.empty();
    this.getExpeData();

    return this;
};

core.digi.foroServ = 'sys/inic/inic-serv/lcd/';
core.digi.weaVotante = 'sys/foro/foro-serv/voto/';

/**
 * Plugin de comentarios
 *
 * Añade DOM para mostrar comentarios y los formularios para comentar y
 * responder. Recibe un objeto con parametros:
 * {
 *  allowNewComents: true|false     #Bloquea o permite nuevos comentarios
 *  skPublicacion: CHAR36           #Publicacion
 *  skIdentificador: CHAR36         #Cualquier elemento char 36
 *  sComentProssesingLink: URL      #URL a enviar comentario, default: window.location.href
 *  sResponseProssesingLink: URL    #URL a enviar respuesta, default: window.location.href
 * }
 *
 * @param {type} opt
 * @returns {$.fn.CommentPool}
 */
$.fn.CommentPool = function (opt) {

    /**
     * Establece las opciones por default y sobreescribe las que
     * provea el usuario
     * @type Object
     */
    var settings = $.extend({
        autoloadComents: false,
        allowNewComents: true,
        skPublicacion: '',
        sComentProssesingLink: window.location.href,
        sResponseProssesingLink: window.location.href,
        skIdentificador: '',
        skID: '',
        customCommentDom: function (d) {},
        customFormDom: function (d) {}
    }, opt);

    /**
     * loadComments
     *
     * Consulta comentarios y los imprime, en caso de no haber comentarios,
     * inserta la empty splash
     *
     * @returns {undefined}
     */
    this.loadComments = function () {
        var that = this;

        $.ajax({
            url: core.SYS_URL + core.digi.foroServ,
            type: 'POST',
            data: {
                axn: 'listarComentarios',
                skIdentificador: settings.skID
            },
            dataType: 'json',
            async: true,
            success: function (res) {
                if (!res.success) {
                    that.errorSplash();
                    return;
                }

                if (Object.keys(res.data).length === 0) {
                    that.emptySplash();
                    return;
                }
                that.printComments(res.data);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                that.errorSplash();
            }
        });
    };

    /**
     * printComments
     *
     * Inserta el DOM para los comentarios y sus respuestas.
     *
     * @param {type} data
     * @returns {undefined}
     */
    this.printComments = function (data) {
        var that = this;
        var containerID = 'cmContainer' + settings.skID;

        this.empty().append(' \n\
        <div class=" DComments comments margin-horizontal-20 " id="' + containerID + '">\n\
        <h3>Comentarios</h3></div>');

        for (var i in data) {
            var c = data[i];
            $('#' + containerID).append(that.commentDOM(c));

            $('#comentCounter' + settings.skID).empty().append(c.totalComments);
            if (c.respuestas.length > 0) {
                for (var h in c.respuestas) {
                    var rsp = c.respuestas[h];
                    $('#replyHolder' + c.skComentario).append(that.replyDOM(rsp));
                }
            }

            $('.replyFormTrigger').click(function (e) {
                that.setReplyForm($(this).data('skcom'));
                e.stopPropagation();
            });

        }

        that.setRootForm();

    };

    /**
     * sendComment
     *
     *
     * @param {string} skId Char36 identificador
     * @param {string} comm Comentario a enviar
     * @param {function} leCallBack Funcion callback
     * @returns {undefined}
     */
    this.sendComment = function (skId, comm, leCallBack) {
        var that = this;
        var sendeable = {
            axn: 'guardarComentario',
            sComentario: comm
        };

        if (settings.skPublicacion.length === 36) {
            sendeable.skPublicacion = skId;
        } else {
            sendeable.skIdentificador = skId;
        }

        $.ajax({
            url: settings.sComentProssesingLink,// core.SYS_URL + core.digi.foroServ,
            type: 'POST',
            data: sendeable,
            dataType: 'json',
            async: true,
            success: function (res) {
                if (!res.success) {
                    toastr.error('No se pudo enviar tu comentario.');
                    return;
                }
                leCallBack();
                that.loadComments();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('No se pudo enviar tu comentario.');
                leCallBack();
            }
        });
    };

    /**
     * sendReply
     *
     * Envia respuesta a comentario
     *
     * @param {string} skCom CHAR36 de  Comentario a responder
     * @param {string} repl Respuesta a enviar
     * @returns {undefined}
     */
    this.sendReply = function (skCom, repl) {
        var that = this;
        var sendeable = {
            axn: 'responderComentario',
            sComentario: repl,
            skComentarioPadre: skCom
        };

        if (settings.skPublicacion.length === 36) {
            sendeable.skPublicacion = settings.skID;
        } else {
            sendeable.skIdentificador = settings.skID;
        }

        console.info(sendeable);

        $.ajax({
            url: settings.sResponseProssesingLink,
            type: 'POST',
            data: sendeable,
            dataType: 'json',
            async: true,
            success: function (res) {
                if (!res.success) {
                    that.errorSplash();
                    return;
                }

                that.loadComments();

            },
            error: function (jqXHR, textStatus, errorThrown) {
                that.errorSplash();
            }
        });
    };

    /**
     * commentDOM
     *
     * Genera el DOM para mostrar un comentario
     *
     * @param {type} data
     * @returns {window.$.fn.CommentPool.commentDOM.si|String}
     */
    this.commentDOM = function (data) {

        var isNiuAllow = settings.allowNewComents ? '<a href="javascript:void(0)" class="replyFormTrigger" data-skcom="' + data.skComentario + '" data-skid="' + settings.skID + '"  role="button"><b><i class=" icon fa-reply"></i> RESPONDER</b></i></a>' : '';

        var si =
                '<div class="comment media">\n\
                <div class="media-left">\n\
                    <a class="avatar avatar-lg" href="javascript:void(0)">\n\
                        <img src="' + data.fotoPerfil + '" alt="...">\n\
                    </a>\n\
                </div>\n\
                    \n\
                <div class="media-body">\n\
                    <div class="comment-body">\n\
                        <a class="comment-author" href="javascript:void(0)">' + data.sNombres + '</a>\n\
                        <div class="comment-meta">\n\
                            <span class="date">' + data.dFechaCreacion + '</span>\n\
                        </div>\n\
                        <div class="comment-content">\n\
                            <p>' + data.sComentario + '</p>\n\
                        </div>\n\
                        <div class="comment-actions">\n\
                            <!-- <a class="text-like" href="javascript:void(0)" role="button"><i class="icon fa-chevron-up"></i> <span></span> </a> -->\n\
                           ' + isNiuAllow + ' \n\
                        </div>\n\
                    </div>\n\
                    <div class="comments" id="replyHolder' + data.skComentario + '"></div>\n\
                </div>\n\
                \n\
            </div>';
        return si;
    };

    /**
     * replyDOM
     *
     * Genera el DOM para mostrar la respuesta de un comentario
     *
     * @param {type} data
     * @returns {window.$.fn.CommentPool.replyDOM.lerespuesta|String}
     */
    this.replyDOM = function (data) {
        var lerespuesta =
                '<div class="comment media">\n\
                <div class="media-left">\n\
                    <a class="avatar avatar-lg" href="javascript:void(0)">\n\
                        <img src="' + data.fotoPerfil + '" alt="...">\n\
                    </a>\n\
                </div>\n\
                <div class="comment-body media-body">\n\
                    <a class="comment-author" href="javascript:void(0)">' + data.sNombres + '</a>\n\
                    <div class="comment-meta">\n\
                        <span class="date">' + data.dFechaCreacion + '</span>\n\
                    </div>\n\
                    <div class="comment-content">\n\
                        <p>' + data.sComentario + '</p>\n\
                    </div>\n\
                    <div class="comment-actions">\n\
                        <!-- <a class="text-like icon fa-chevron-up" href="javascript:void(0)" role="button"></a> -->\n\
                    </div>\n\
                </div>\n\
            </div>';

        return lerespuesta;
    };

    /**
     * errorSplash
     *
     * Genera el DOM para una pantalla de error.
     * @returns {undefined}
     */
    this.errorSplash = function () {
        this.empty().append('<div class="vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out" style="animation-duration: 800ms; opacity: 1;" id="mensajeParaIrAFirmar" >\n\
        <div class="page-content vertical-align-middle">\n\
            <i class="icon fa fa-exclamation-circle page-maintenance-icon text-danger" aria-hidden="true" style="font-size: 32px"></i>\n\
          <p>Ha ocurrido un error al cargar comentarios. </p>\n\
        </div>\n\
      </div>');
    };

    /**
     * emptySplash
     *
     * Genera el DOM para mostrar que no hay comentarios
     * @returns {Boolean}
     */
    this.emptySplash = function () {
        var that = this;

        if (!settings.allowNewComents) {
            return true;
        }

        this.empty().append('<div class="text-center" data-animsition-in="fade-in" data-animsition-out="fade-out" style="animation-duration: 800ms; opacity: 1;" id="mensajeParaIrAFirmar" >\n\
        <div>\n\
            <i class="icon fa-comment-o page-maintenance-icon text-info" aria-hidden="true" style="font-size: 64px"></i>\n\
          <h4>Aun no hay comentarios</h4>\n\
          <p>¡Se el primero en comentar!</p>\n\
          </div>\n\
      </div>');

        that.setRootForm();

    };

    /**
     * setLoadInitDom
     *
     * Carga el DOM inicial para los comentarios
     *
     * @returns {undefined|Boolean}
     */
    this.setLoadInitDom = function () {
        var that = this;

        if (!settings.allowNewComents) {
            return;
        }

        if (settings.skPublicacion.length === 36) {
            settings.skID = settings.skPublicacion;
        } else {
            settings.skID = settings.skIdentificador;
        }

        if (settings.autoloadComents) {
            this.empty();
            that.loadComments();
            return true;
        }

        this.empty().append('<a class="btn btn-block btn-default profile-readMore" id="detonatorCommentLoader' + settings.skID + '" data-cmmpuuid="' + settings.skID + '" href="javascript:void(0)" role="button">Mostrar comentarios</a>');

        $('#detonatorCommentLoader' + settings.skID).click(function (e) {
            that.loadComments();
            e.stopPropagation();
        });

    };

    /**
     * setReplyForm
     *
     * Crea el DOM de un formulario para responder un comentario existente
     *
     * @param {type} skComm
     * @returns {undefined}
     */
    this.setReplyForm = function (skComm) {
        var that = this;

        $('#replyFormtl' + settings.skID).remove();
        $('#replyHolder' + skComm).append('<div class="comment-reply" id="replyFormtl' + settings.skID + '" hidden>\n\
            <div class="form-group">\n\
                <textarea class="form-control" id="replayTextArea' + settings.skID + '" rows="2" placeholder="Responde aquí"></textarea>\n\
            </div>\n\
            <div class="form-group">\n\
                <button type="submit" class="btn btn-primary" data-skcom="' + skComm + '" id="saveReplay' + settings.skID + '">Responder</button>\n\
                <button type="button" id="leCerrarFormularioDeRespuesta' + settings.skID + '" class="btn btn-link blue-grey-500">Cerrar</button>\n\
            </div>\n\
        </div>');

        $('#replyFormtl' + settings.skID).show(750);

        $('#leCerrarFormularioDeRespuesta' + settings.skID).click(function (e) {
            $('#replyFormtl' + settings.skID).hide(550, function () {
                $('#replyFormtl' + settings.skID).remove();
            });
        });

        $('#replayTextArea' + settings.skID).focus();

        $('#saveReplay' + settings.skID).click(function (e) {
            that.sendReply($(this).data('skcom'), $('#replayTextArea' + settings.skID).val());
        });



    };

    /**
     * setRootForm
     *
     * Crea el DOM para el fomulario principal del componente, el que envia
     * nuevos comentarios
     *
     * @returns {undefined}
     */
    this.setRootForm = function () {

        var that = this;

        if (!settings.allowNewComents) {
            return;
        }

        this.append('<div class="comments-add margin-top-35" >\n\
                    <h3 class="margin-bottom-35">Deja un comentario</h3>\n\
                    <div class="form-group">\n\
                        <textarea class="form-control" id="comentText' + settings.skID + '" rows="2" placeholder="Comenta aquí."></textarea>\n\
                    </div>\n\
                    <div class="form-group">\n\
                        <button type="button" class="btn btn-primary core-button" id="rootComentTrigger' + settings.skID + '" data-skidcom="' + settings.skID + '">Comentar</button>\n\
                    </div>\n\
                </div>');

        $("#rootComentTrigger" + settings.skID).click(function () {

            if ($("#comentText" + settings.skID).val().length === 0) {
                return true;
            }

            $("#rootComentTrigger" + settings.skID).prop("disabled", true);
            that.sendComment($(this).data('skidcom'), $("#comentText" + settings.skID).val(), function () {
                $("#rootComentTrigger" + settings.skID).prop("disabled", false);
            });
        });

    };

    this.setLoadInitDom();

    return this;

};

/**
 *
 * @fileoverview    Inicializa slide panel con su contenido
 *
 * @author         Jonathan Topete <jtopete@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 * @param  data
 *
 */
core.page_aside = function page_aside(data) {
    $(document).ready(function () {

        /*        $('.page-aside-inner').asScrollable({
         namespace: 'scrollable',
         contentSelector: '> div',
         containerSelector: '> div'
         });*/
        $('body').addClass('page-aside-fixed');
        var $body = $(document.body);

        var pageAsideScroll = $('[data-plugin="pageAsideScroll"]');

        if (pageAsideScroll.length > 0) {
            pageAsideScroll.asScrollable({
                namespace: "scrollable",
                contentSelector: "> [data-role='content']",
                containerSelector: "> [data-role='container']"
            });

            var pageAside = $(".page-aside");
            var scrollable = pageAsideScroll.data('asScrollable');

            if (scrollable) {
                if ($body.is('.page-aside-fixed') || $body.is('.page-aside-scroll')) {
                    $(".page-aside").on("transitionend", function () {
                        scrollable.update();
                    });
                }

                Breakpoints.on('change', function () {
                    var current = Breakpoints.current().name;

                    if (!$body.is('.page-aside-fixed') && !$body.is('.page-aside-scroll')) {
                        if (current === 'xs') {
                            scrollable.enable();
                            pageAside.on("transitionend", function () {
                                scrollable.update();
                            });
                        } else {
                            pageAside.off("transitionend");
                            scrollable.disable();
                        }
                    }
                });

                $(document).on('click.pageAsideScroll', '.page-aside-switch', function () {
                    var isOpen = pageAside.hasClass('open');

                    if (isOpen) {
                        pageAside.removeClass('open');
                    } else {
                        scrollable.update();
                        pageAside.addClass('open');
                    }
                });

                $(document).on('click.pageAsideScroll', '[data-toggle="collapse"]', function (e) {
                    var $trigger = $(e.target);
                    if (!$trigger.is('[data-toggle="collapse"]')) {
                        $trigger = $trigger.parents('[data-toggle="collapse"]');
                    }
                    var href;
                    var target = $trigger.attr('data-target') || (href = $trigger.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '');
                    var $target = $(target);

                    if ($target.attr('id') === 'site-navbar-collapse') {
                        scrollable.update();
                    }
                });
            }
        }

        $("#page-aside-content-portal a").click(function (event) {
            $("#page-aside-content-portal a").removeClass("active");
            var target = $(event.target);
            target.addClass('active');
        });

    });
};

/**
 *
 * @fileoverview   Carga el widget de Servicios
 *
 * @author         Christian Jiménez <cjimenez@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 * @param  conf
 *
 */
core.serviciosWidget = function serviciosWidget(conf){
    
    $.each(conf.params, function (k, v) {
        conf.params[k] = $(v).val();
    });
    
    conf.params.axn = 'serviciosWidget';
    
    $.ajax({
        url: conf.url,
        type: "POST",
        global: false,
        data: conf.params,
        success: function (response) {
            if (!response.success) {
                toastr.error(response.message, 'Notificación');
                return false;
            }
            $("#serviciosWidget").html(response.servicios);
        }
    });
};

/**
 *
 * @fileoverview    Reemplaza contenido del SlidePanel
 *
 * @author         Jonathan Topete <jtopete@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 * @param  data
 *
 */
core.page_aside_content = function page_aside_content(data) {
    if (data) {
        $('#page-aside-content-portal').html(data);
    }
};

core.validarContenedor = function validarContenedor(contenedorOriginal) {
    contenedorOriginal = contenedorOriginal.trim();
    var desglosado = contenedorOriginal.replace(/-/g, "");
    var suma = 0;
    for (p = 0; p < 10; p++) {
        suma += ((p < 4) ? valorLetra(desglosado.substr(p, 1)) : desglosado.substr(p, 1)) * (Math.pow(2, p));
    }
    suma = Math.round(((suma / parseInt(desglosado.length)) - parseInt(suma / parseInt(desglosado.length))) * 11);
    verificador = ((suma > 9) ? 0 : suma);
    if (desglosado[10] == verificador) {
        return true;
    } else {
        return false;
    }

    function valorLetra(letra) {
        arrLetras = new Array("", "", "", "", "", "", "", "", "", "", "A", "", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "", "V", "W", "X", "Y", "Z");
        for (i = 0; i < arrLetras.length; i++) {
            if (arrLetras[i] == letra.toUpperCase())
                return i;
        }
        return 0;
    }

};


/**

 * @fileoverview Añade funcionalidad de búsqueda al componente
 *
 * @author         Jonathan Topete <jtopete@woodward.com.mx>
 *
 * @copyright      woodward.com.mx
 *
 * @param  id
 *
 */

core.searchMultiSelect = function searchMultiSelect(id) {
    $('#'+id).multiSelect({
        selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar Servicio'>",
        selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar Servicio'>",
        afterInit: function (ms) {
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function (e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function (e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function () {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function () {
            this.qs1.cache();
            this.qs2.cache();
        }
    });
};


/*
 * Objeto global de conexion al WebSocket SSL de notificaciones
 *
 * @type Boolean|WebSocket
 */
core.WSS = false;
core.WSS_binded = {};
core.WSS_url = ''; // Valor cambia segun entorno; Archivo core/src/notifications/listenChannel.php
core.WSS_port = '8080';
core.wss_initChannels = [];
core.WSS_RECONNECT_LOOPMAXITERATIONS = 3;
core.WSS_RECONNECT_LOOPCURRENTITERATION = 0;
core.WSS_RECONNECT_TIMER = 5;
core.WSS_RECONNECT_MINTIME = 5;
core.WSS_RECONNECT_TOPTIME = 30;
core.WSS_WATCHDOG_PID = false;
core.WSS_LOG_STR_MSG = false;
core.WSS_LOG_OBJ_MSG = false;
core.WSS_CLEAR_CONSOLE = false;
core.WSS_SHOW_LOGS = false;

core.WSS_watchDog = function () {
    if (typeof (core.WSS) !== 'boolean') {
        return true;
    }
    core.WSS_RECONNECT_LOOPCURRENTITERATION += 1;
    if(core.WSS_SHOW_LOGS){
        console.info('Intento de reconexion', core.WSS_RECONNECT_LOOPCURRENTITERATION);
    }
    core.socketInit();
};

core.wss_reconnectLoop = function () {

    if (typeof (core.WSS) !== 'boolean') {
        return true;
    }

    if (typeof (core.WSS_WATCHDOG_PID) !== 'boolean') {
        return true;
    }
    if(core.WSS_SHOW_LOGS){
        console.log("Intentando conectar cada " + core.WSS_RECONNECT_TIMER + 's');
    }
    core.WSS_WATCHDOG_PID = window.setInterval(core.WSS_watchDog, core.WSS_RECONNECT_TIMER * 1000);
};

core.channelBind = function (chnn, bfunction) {
    core.WSS_binded[chnn] = bfunction;
};

core.eventBind = function (evt, evtfunction) {
    core.WSS_binded[evt] = evtfunction;
};

core.subscribe = function (channels) {
    core.WSS.send(JSON.stringify({
        "axn": "subscribe",
        "channels": channels
    }));
};

core.unsubscribe = function (channels) {
    core.WSS.send(JSON.stringify({
        "axn": "unsubscribe",
        "channels": channels
    }));
};

core.sendMessage = function (data, channels) {
    core.WSS.send(JSON.stringify({
        "axn": "sendMessage",
        "channels": channels,
        "data": data
    }));
};

core.getSoketStats = function () {
    core.WSS.send(JSON.stringify({
        "axn": "socketInfo"
    }));
};

core.socketInit = function () {

    core.WSS = new WebSocket('wss://' + core.WSS_url + ':' + core.WSS_port);

    core.WSS.onopen = function (e) {
        core.subscribe(core.wss_initChannels);
        if(core.WSS_SHOW_LOGS){
            console.info("Deteniendo loop de conexion:" + core.WSS_WATCHDOG_PID);
        }
        window.clearInterval(core.WSS_WATCHDOG_PID);
        core.WSS_WATCHDOG_PID = false;
        core.WSS_RECONNECT_TIMER = core.WSS_RECONNECT_MINTIME;

        core.WSS.onmessage = function (e) {

            if (core.WSS_LOG_STR_MSG) {
                console.log('Mensaje recibido:', e);
            }

            var o = JSON.parse(e.data);

            if (core.WSS_LOG_OBJ_MSG) {
                console.info(o);
            }

            if (typeof (core.WSS_binded[o.channel]) === 'function') {
                core.WSS_binded[o.channel](o);
            }

            if (typeof (core.WSS_binded[o.event]) === 'function') {
                if(core.WSS_SHOW_LOGS){
                    console.info('Ejecutando evento ' + o.event);
                }
                core.WSS_binded[o.event](o);
            }

        };

        core.WSS.onclose = function (e) {
            if(core.WSS_SHOW_LOGS){
                console.error('onclose', 'Conexion cerrada');
            }

            core.WSS = false;
            core.wss_reconnectLoop();
        };

        if (core.WSS_CLEAR_CONSOLE) {
            console.clear();
        }

        if(core.WSS_SHOW_LOGS){
            console.info('Conexion exitosa');
        }


    };

    core.WSS.onerror = function (e) {
        if(core.WSS_SHOW_LOGS){
            console.error('Error', 'No se pudo conectar con servidor');
        }

        if (typeof (core.WSS) !== 'boolean') {
            core.WSS = false;
        }

        var stepIteration = core.WSS_RECONNECT_LOOPMAXITERATIONS - core.WSS_RECONNECT_LOOPCURRENTITERATION;

        if (stepIteration < 0) {
            window.clearInterval(core.WSS_WATCHDOG_PID);
            core.WSS_WATCHDOG_PID = false;
            if (core.WSS_RECONNECT_TIMER < core.WSS_RECONNECT_TOPTIME) {
                core.WSS_RECONNECT_TIMER += 5;
            }
            core.WSS_RECONNECT_LOOPCURRENTITERATION = 0;
        }

        core.WSS = false;
        core.wss_reconnectLoop();
    };

};
