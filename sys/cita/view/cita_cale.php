<div class="row">
        <input type="hidden" name="sClaveCategoriaCita"  id="sClaveCategoriaCita" value="DEFAULT">

        <!--CONSIDERACIONES-->
        <div class="panel-bordered panel-primary panel-line col-lg-12 col-md-12 col-sm-12 col-xs-12 fast-filter" hidden>
            <div class="widget widget-shadow">
                <div class="panel-heading col-md-12">
                    <div class="col-md-12">  <h3 class="panel-title">FILTROS</h3> </div>
                    <ul class="panel-actions panel-actions-keep">
                    <li>
                        <button type="button" href="javascript:void(0);" onclick="filtrarCalendario($('#DEFAULT'))" class="btn btn-squared btn-outline ajax-popup-link 
                        btn-success btn-sm"><i class="fas fa-search"></i> FILTRAR</button>
                    </li>    
                    <li>
                        <button type="button" href="javascript:void(0);" onclick="limpiarFiltro();" class="btn btn-squared btn-outline ajax-popup-link 
                        btn-info btn-sm"><i class="fas fa-eraser"></i> LIMPIAR</button>
                    </li> 
                    <!--<li>
                        <div class="form-group">    
                            <input type="checkbox" class="js-switch-large" id="iFiltroHistorico" name="iFiltroHistorico" value="1" data-plugin="switchery"  data-color="#4d94ff" />
                            <label for="iFiltroHistorico" class="text-dark"><b>HISTÓRICO</b></label>
                        </div>
                    </li>!--> 
                </ul>
                </div>
                <div class="panel-body container-fluid" id="filter">
                    <div class="row row-lg">

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">FOLIO CITA:</h4>
                                <select name="iFolioCita" id="iFolioCita" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">NOMBRE:</h4>
                                <select name="sNombre" id="sNombre" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">CLIENTE:</h4>
                                <select name="skEmpresaSocioCliente" id="skEmpresaSocioCliente" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">ESTADO:</h4>
                                <select id="skEstadoMX"  name="skEstadoMX" class="form-control" data-plugin="select2" select2Simple>
                                    <option value="">- SELECCIONAR -</option>
                                    <?php
                                        if (!empty($data['cat_estadosMX'])) {
                                            foreach (  $data['cat_estadosMX'] as $row) {
                                    ?>
                                        <option <?php echo(isset($data['datos']['skEstadoMX']) && $data['datos']['skEstadoMX'] == $row['skEstadoMX'] ? 'selected="selected"' : ''); ?>
                                        value="<?php echo $row['skEstadoMX']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                            }//ENDWHILE
                                        }//ENDIF
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">MUNICIPIO:</h4>
                                <select id="skMunicipioMX"  name="skMunicipioMX" class="form-control" data-plugin="select2" select2Simple>
                                    <option value="">- SELECCIONAR -</option>
                                    <?php
                                        if (!empty($data['cat_municipiosMX'])) {
                                            foreach (  $data['cat_municipiosMX'] as $row) {
                                    ?>
                                        <option <?php echo(isset($data['datos']['skMunicipioMX']) && $data['datos']['skMunicipioMX'] == $row['skMunicipioMX'] ? 'selected="selected"' : ''); ?>
                                        value="<?php echo $row['skMunicipioMX']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                            }//ENDWHILE
                                        }//ENDIF
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">PERSONAL ASIGNADO:</h4>
                                <div class="select2-primary">
                                    <select name="skCitaPersonal_array[]" id="skCitaPersonal_array" class="form-control select2" multiple="multiple" data-plugin="select2" data-ajax--cache="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-4 col-md-4">
                            <h4 class="example-title">HISTÓRICO</h4>
                            <div class="form-group">    
                                <input type="checkbox" class="js-switch-large" id="iFiltroHistorico" name="iFiltroHistorico" value="1" data-plugin="switchery"  data-color="#4d94ff" />
                            </div>
                        </div>   

                    </div>

                </div>
            </div>
        </div>
        
        <div class="panel-bordered panel-primary panel-line col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="widget widget-shadow">
                <div class="panel-heading">                    
                </div>
                <div class="panel-body container-fluid">
                    <div class="col-sm-12 col-xs-12 padding-horizontal-0">
                        <div class="calendar-container">
                            <div id="calendar"></div>
                         </div>
                    </div>
                    
                </div>
            </div>
        </div>

</div>

<div class="site-action" data-plugin="actionBtn"><button type="button" class="site-action-toggle btn-raised btn btn-primary btn-floating" onclick="$('.fast-filter').toggle(); $('#fast-filter-input').focus();" data-toggle="tooltip" title="" data-original-title="Mostrar / Ocultar Filtros Rápidos."> <i class="front-icon wb-eye-close animation-scale-up" aria-hidden="true"></i> <i class="back-icon wb-close animation-scale-up" aria-hidden="true"></i> </button></div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    
    cita.cita_cale.procesos = <?php echo (!empty($data['cat_citas_categorias']) ? json_encode($data['cat_citas_categorias']) : json_encode([])); ?>;
    
    function listarProcesos(){
        var procesos = '<section class="page-aside-section"><div class="list-group menuProcesoItems"><h4 class="page-aside-title"><i class="fas fa-calendar"></i> Eventos</h4><hr>';
        
        $.each(cita.cita_cale.procesos, function(k,v){
            color = '';
            iCantidadCitas = '';
            linea = '';
            switch(v.sClaveCategoriaCita){
                case 'MANTEN':
                    color = v.sColorCategoria;
                    iCantidadCitas = v.iCantidadCitas;
                    linea = '';
                break;
                case 'REVISI':
                    color = v.sColorCategoria;
                    iCantidadCitas = v.iCantidadCitas;
                    linea = '';
                break;
                case 'INSTAL':
                    color = v.sColorCategoria;
                    iCantidadCitas = v.iCantidadCitas;
                    linea = '';
                break;
                default:
                    color = 'black';
                    iCantidadCitas = 0;
                    linea = '<br>';
                break;
            }

           procesos += '<a id="'+v.sClaveCategoriaCita+'" class="list-group-item procesoItem" onclick="filtrarCalendario(this)"  href="javascript:void(0)" data-sClaveCategoriaCita="' + v.sClaveCategoriaCita + '" data-proceso="' + v.sNombreCategoria + '" ><i class="icon fa fa-circle" style="color:'+color+'" aria-hidden="true"></i> ' + v.sNombreCategoria+' (<span id="'+v.sClaveCategoriaCita+'2">'+iCantidadCitas+'</span>)' + '</a>'+linea;
        });
        procesos += '</div></section>';
        core.page_aside_content(procesos);
    }

    $(document).ready(function(){
        core.autocomplete2('#iFolioCita', 'get_iFolioCita', window.location.href, 'FOLIO CITA');
        core.autocomplete2('#sNombre', 'get_sNombre', window.location.href, 'NOMBRE');
        core.autocomplete2('#skEmpresaSocioCliente', 'get_cliente', window.location.href, 'CLIENTE');
        core.autocomplete2('#skCitaPersonal_array', 'get_personal', window.location.href, 'PERSONAL ASIGNADO', {});
        $("#skEstadoMX").select2({placeholder: "ESTADO", allowClear: true });
        $("#skMunicipioMX").select2({placeholder: "MUNICIPIO", allowClear: true });
        
        events = <?php echo (!empty($data['calendario']) ? json_encode($data['calendario']) : json_encode([])); ?>;
        
        $('#calendar').fullCalendar({
            height : 700,
            width  : 650,
            locale: 'es',
            header:{
                left: null,
                center: 'prev,title,next',
                right: 'month,agendaWeek,agendaDay'
            },
            events,
            eventClick: function(info) {
                if(typeof info.sURL !== 'undefined'){
                    core.menuLoadModule({skModulo: info.skModulo, url: info.sURL, skComportamiento: 'MOWI', id: info.id });
                }
            }
        });
        
        listarProcesos();

        $("body").delegate("a.procesoItem", "click", function() {
            $("a.procesoItem").removeClass('active');
            $(this).addClass('active');
            var proceso = this.getAttribute("data-proceso");
            var sClaveCategoriaCita = this.getAttribute("data-sClaveCategoriaCita");
            $("#sClaveCategoriaCita").val(sClaveCategoriaCita);
            $("#procesoName").html(proceso);
            $("#"+sClaveCategoriaCita).css("display","block");
        });

        $('[data-plugin="switchery"]').each(function () {
            new Switchery(this, {
                color: $(this).data('color'),
                size: $(this).data('size')
            });
        });

        $("#skEstadoMX").change(function(e){
            var skEstadoMX = $("#skEstadoMX").val();
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    axn: 'get_cat_municipiosMX',
                    skEstadoMX: skEstadoMX
                },
                cache: false,
                async: false,
                beforeSend: function () {
                    toastr.info('CARGANDO MUNICIPIOS <i class="fa fa-spinner faa-spin animated"></i>', 'NOTIFICACIÓN', {timeOut: false});
                },
                success: function (response) {
                    toastr.clear();
                    if(response.success){
                        toastr.success(response.message, 'NOTIFICACIÓN');
                        
                        // RECORREMOS LOS MUNICIPIOS //
                            $("#skMunicipioMX").html('');
                            let option = '<option value="">- SELECCIONAR -</option>';
                            $.each(response.cat_municipiosMX,function(k,v){
                                option += '<option value="'+v.skMunicipioMX+'">'+v.sNombre+'</option>';
                            });

                            $("#skMunicipioMX").html(option);
                            $("#skMunicipioMX").select2({placeholder: "MUNICIPIO", allowClear: true });
                    }else{
                        toastr.error(response.message, 'NOTIFICACIÓN');
                    }
                }
            });
        });

    });
  
    function filtrarCalendario(conf){
        var sClaveCategoriaCita = conf.id; 
        iFiltroHistorico = 0;
        if($('#iFiltroHistorico').prop('checked')){
            iFiltroHistorico = 1;
        }
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                axn: 'getDatos',
                sClaveCategoriaCita: sClaveCategoriaCita,
                iFolioCita : $("#iFolioCita").val(),
                sNombre : $("#sNombre").val(),
                skEmpresaSocioCliente : $("#skEmpresaSocioCliente").val(),
                skEstadoMX : $("#skEstadoMX").val(),
                skMunicipioMX : $("#skMunicipioMX").val(),
                skCitaPersonal_array : $("#skCitaPersonal_array").val(),
                iFiltroHistorico : iFiltroHistorico
            },
            cache: false,
            processData: true,
            beforeSend: function () {},
            success: function (response) {
                if (response.success == true) {
                    events = response.calendario;

                    swal.close();
                    toastr.success("Filtro Realizado Correctamente", 'Enviado');
                        $('#calendar').fullCalendar('destroy');
                        $('#calendar').fullCalendar({
                                height : 700,
                                width  : 650,
                                locale: 'es',
                                header:{
                                     left: null,
                                     center: 'prev,title,next',
                                     right: 'month,agendaWeek,agendaDay'
                                },
                                events,
                                eventClick: function(info) {
                                    if(typeof info.sURL !== 'undefined'){
                                       core.menuLoadModule({skModulo: info.skModulo, url: info.sURL, skComportamiento: 'MOWI', id: info.id });
                                    }
                                 }
                        });
                        //$("#AUSENCIA2").html(response.nSolicitudes.permisoAusencia.nAusencia);
                        //$("#VACACIONES2").html(response.nSolicitudes.vacaciones.nVacaciones);
                        //$("#CAPACITACIONES2").html(response.nSolicitudes.capacitaciones.nCapacitaciones);
                        //$("#INCAPACIDADES2").html(response.nSolicitudes.incapacidades.nIncapacidades);
                        //$("#DEFAULT2").html(response.nSolicitudes.permisoAusencia.nAusencia + response.nSolicitudes.vacaciones.nVacaciones + response.nSolicitudes.incapacidades.nIncapacidades + response.nSolicitudes.capacitaciones.nCapacitaciones);
                    return true;
                } else {
                    toastr.clear();
                    swal("¡Error!", 'NO SE PUDO OBTENER DATOS', "error");
                }
            }
        });
    return true; 
    }
    
    function limpiarFiltro(){
        $('#iFolioCita').empty();
        $('#sNombre').empty();
        $('#skEmpresaSocioCliente').empty();
        $('#skEstadoMX').empty();
        $('#skMunicipioMX').empty();
        filtrarCalendario($('#DEFAULT'));
    }

    
</script>
