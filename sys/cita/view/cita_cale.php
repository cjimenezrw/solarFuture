
<?php
    if (isset($data['datos'])) {
        $result = $data['datos'];
        
    }
?>

<div class="row">
        <input type="hidden" name="skTipoProceso"  id="skTipoProceso" value="DEFAULT">

        <!--CONSIDERACIONES-->
        <div class="panel-bordered panel-primary panel-line col-lg-12 col-md-12 col-sm-12 col-xs-12 fast-filter" hidden>
            <div class="widget widget-shadow">
                <div class="panel-heading col-md-12">
                    <div class="col-md-12">  <h3 class="panel-title">Filtros</h3> </div>
                    <ul class="panel-actions panel-actions-keep">
                    <li>
                        <button type="button" href="javascript:void(0);" onclick="filtrarCalendario($('#DEFAULT'))" class="btn btn-squared btn-outline ajax-popup-link 
                        btn-success btn-sm"><i class="fas fa-search"></i> Filtrar</button>
                    </li>    
                    <li>
                        <button type="button" href="javascript:void(0);" onclick="limpiarFiltro(this)" class="btn btn-squared btn-outline ajax-popup-link 
                        btn-info btn-sm"><i class="fas fa-eraser"></i> Limpiar</button>
                    </li> 
                </ul>
                </div>
                <div class="panel-body container-fluid" id="filter">

                    <div class="col-md-4">
                        <div class="navbar-form input-search">
                            <select name="eEmpleado" id="eEmpleado">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="navbar-form input-search">
                            <select name="eJefeInmediato" id="eJefeInmediato">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="navbar-form input-search">
                            <select name="eArea" id="eArea">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="navbar-form input-search">
                            <select name="eDepartamentos" id="eDepartamentos">
                            </select>
                        </div>
                    </div>
                     <div class="col-md-4 col-lg-4"><h4 class="example-title">Histórico</h4>
                          <div class="form-group">    
                            <input type="checkbox" class="js-switch-large" data-plugin="switchery"  data-color="#4d94ff" name="historico" id="historico" value="1"/>
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
    
    rehu.cale_inde.procesos = <?php echo ($data['datos']['procesos']) ? json_encode($data['datos']['procesos']) : json_encode([]); ?>;
    
     function listarProcesos(){
        var procesos = '<section class="page-aside-section"><div class="list-group menuProcesoItems"><h4 class="page-aside-title"><i class="fas fa-calendar"></i> Eventos</h4><hr>';
        
        $.each(rehu.cale_inde.procesos, function(k,v){
            color = '';
            nSolicitudes = '';
            linea = '';
            switch(v.skTipoProceso){
                case 'MANTEN':
                    color = '#05A85C';
                    nSolicitudes = <?php echo ($data['datos']['nSolicitudes']['vacaciones']['nVacaciones']) ? json_encode($data['datos']['nSolicitudes']['vacaciones']['nVacaciones']) : json_encode([0]); ?>;
                    linea = '';
                break;
                case 'REVISI':
                    color = '#3e8ef7';
                    nSolicitudes = <?php echo ($data['datos']['nSolicitudes']['permisoAusencia']['nAusencia']) ? json_encode($data['datos']['nSolicitudes']['permisoAusencia']['nAusencia']) : json_encode([0]); ?>;
                    linea = '';
                break;
                case 'INSTAL':
                    color = '#ff4c52';
                    nSolicitudes = <?php echo ($data['datos']['nSolicitudes']['capacitaciones']['nCapacitaciones']) ? json_encode($data['datos']['nSolicitudes']['capacitaciones']['nCapacitaciones']) : json_encode([0]); ?>;
                    linea = '';
                break;
                default:
                    color = 'black';
                    nSolicitudes = <?php echo ($data['datos']['nSolicitudes']) ? json_encode($data['datos']['nSolicitudes']['capacitaciones']['nCapacitaciones']+$data['datos']['nSolicitudes']['permisoAusencia']['nAusencia']+$data['datos']['nSolicitudes']['incapacidades']['nIncapacidades']+$data['datos']['nSolicitudes']['vacaciones']['nVacaciones']) : json_encode([0]); ?>;
                    linea = '<br>';
                break;
            }

           procesos += '<a id="'+v.skTipoProceso+'" class="list-group-item procesoItem" onclick="filtrarCalendario(this)"  href="javascript:void(0)" data-skTipoProceso="' + v.skTipoProceso + '" data-proceso="' + v.sNombre + '" ><i class="icon fa fa-circle" style="color:'+color+'" aria-hidden="true"></i> ' + v.sNombre+' (<span id="'+v.skTipoProceso+'2">'+nSolicitudes+'</span>)' + '</a>'+linea;
        });
        procesos += '</div></section>';
        core.page_aside_content(procesos);
    }

    $(document).ready(function(){
        core.autocomplete2('#eDepartamentos', 'getDepartamentos', window.location.href, 'Departamentos');
        core.autocomplete2('#eArea', 'getAreas', window.location.href, 'Área');
        core.autocomplete2('#eEmpleado', 'getEmpleados', window.location.href, 'Empleado');
        core.autocomplete2('#eJefeInmediato', 'getJefeInmediato', window.location.href, 'Jefe Inmediato');
        datosDefault = <?php echo ($data['datos']['datos']) ? json_encode($data['datos']['datos']) : json_encode([]); ?>;

        events = datosDefault;

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
        $("body").delegate( "a.procesoItem", "click", function() {
            $("a.procesoItem").removeClass('active');
            $(this).addClass('active');
            var proceso = this.getAttribute("data-proceso");
            var skTipoProceso = this.getAttribute("data-skTipoProceso");
            $("#skTipoProceso").val(skTipoProceso);
            $("#procesoName").html(proceso);
            $("#"+skTipoProceso).css("display","block");
        });

        $('[data-plugin="switchery"]').each(function () {
            new Switchery(this, {
                color: $(this).data('color'),
                size: $(this).data('size')
            });
        });
    });
  
    function filtrarCalendario(conf){
        var skTipoProceso = conf.id; 
        historico = 0;
        if($('#historico').prop('checked')){
            historico = 1;
        }
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                axn: 'filtrar',
                skTipoProceso: skTipoProceso,
                eArea : $("#eArea").val(),
                eDepartamentos : $("#eDepartamentos").val(),
                eEmpleado : $("#eEmpleado").val(),
                eJefeInmediato : $("#eJefeInmediato").val(),
                historico : historico
            },
            cache: false,
            processData: true,
            beforeSend: function () {},

            success: function (response) {
                if (response.success == true) {
                    events = response.datos;

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
                        $("#AUSENCIA2").html(response.nSolicitudes.permisoAusencia.nAusencia);
                        $("#VACACIONES2").html(response.nSolicitudes.vacaciones.nVacaciones);
                        $("#CAPACITACIONES2").html(response.nSolicitudes.capacitaciones.nCapacitaciones);
                        $("#INCAPACIDADES2").html(response.nSolicitudes.incapacidades.nIncapacidades);
                        $("#DEFAULT2").html(response.nSolicitudes.permisoAusencia.nAusencia + response.nSolicitudes.vacaciones.nVacaciones + response.nSolicitudes.incapacidades.nIncapacidades + response.nSolicitudes.capacitaciones.nCapacitaciones);
                    return true;
                } else {
                    toastr.clear();
                    swal("¡Error!", 'NO SE PUDO OBTENER DATOS', "error");
                }
            }
        });
    return true; 
    }
    
    function limpiarFiltro(conf){
        $('#eDepartamentos').empty();
        $('#eArea').empty();
        $('#eEmpleado').empty();
        $('#eJefeInmediato').empty();

        filtrarCalendario($('#DEFAULT'));
    }

    
</script>
