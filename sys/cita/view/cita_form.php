<?php
//exit('<pre>'.print_r($data,1).'</pre>');
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered panel-primary panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">DATOS GENERALES</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">

                        <?php 
                            if($this->verify_permissions('A')){
                        ?>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title">ORDEN DE SERVICIO:</h4>
                                <select id="skOrdenServicio"  name="skOrdenServicio" class="form-control" data-plugin="select2" select2Simple>
                                    <option value="">- SELECCIONAR -</option>
                                    <?php
                                        if (!empty($data['datos']['skOrdenServicio'])) {
                                    ?>
                                        <option selected="selected"
                                        value="<?php echo $data['datos']['skOrdenServicio']; ?>"><?php echo $row['iFolioOrdenServicio']; ?></option>
                                    <?php
                                        }//ENDIF
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"><hr></div>

                        <?php
                            }//ENDIF
                        ?>
                        
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>CATEGORÍA:</h4>
                                <select id="skCategoriaCita"  name="skCategoriaCita" class="form-control" data-plugin="select2" select2Simple>
                                    <option value="">- SELECCIONAR -</option>
                                    <?php
                                        if (!empty($data['cat_citas_categorias'])) {
                                            foreach ($data['cat_citas_categorias'] as $row) {
                                    ?>
                                        <option <?php echo(isset($data['datos']['skCategoriaCita']) && $data['datos']['skCategoriaCita'] == $row['skCategoriaCita'] ? 'selected="selected"' : ''); ?>
                                        value="<?php echo $row['skCategoriaCita']; ?>"> <?php echo $row['sNombreCategoria']; ?> </option>
                                    <?php
                                            }//ENDWHILE
                                        }//ENDIF
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>FECHA DE CITA:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="wb-calendar" aria-hidden="true"></i>
                                    </span>
                                    <input class="form-control input-datepicker" id="dFechaCita" name="dFechaCita" 
                                    value="<?php echo (!empty($data['datos']['dFechaCita']) ? date('d/m/Y', strtotime($data['datos']['dFechaCita'])) : ''); ?>" 
                                    placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>HORA:</h4>
                                <select id="tHoraInicio"  name="tHoraInicio" class="form-control" data-plugin="select2" select2Simple>
                                    <option value="">- SELECCIONAR -</option>
                                    <?php
                                        if (isset($data['datos']['tHoraInicio']) && !empty($data['datos']['tHoraInicio'])) {
                                    ?>
                                        <option selected="selected" value="<?php echo $data['datos']['tHoraInicio']; ?>"><?php echo $data['datos']['tHoraInicio']; ?></option>
                                    <?php
                                        }//ENDIF
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>NOMBRE:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa-user" aria-hidden="true"></i>
                                    </span>
                                    <input id="sNombre" name="sNombre" placeholder="NOMBRE" type="text" class="form-control" autocomplete="off"   
                                    value = "<?php echo isset($data['datos']['sNombre']) ? $data['datos']['sNombre'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>TELÉFONO:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa-phone" aria-hidden="true"></i>
                                    </span>
                                    <input id="sTelefono" name="sTelefono" placeholder="TELÉFONO" type="text" class="form-control" autocomplete="off"   
                                    value = "<?php echo isset($data['datos']['sTelefono']) ? $data['datos']['sTelefono'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>CORREO:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa-envelope" aria-hidden="true"></i>
                                    </span>
                                    <input id="sCorreo" name="sCorreo" placeholder="CORREO" type="text" class="form-control" autocomplete="off"   
                                    value = "<?php echo isset($data['datos']['sCorreo']) ? $data['datos']['sCorreo'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>ESTADO:</h4>
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
                                <h4 class="example-title"><span style="color:red;">* </span>MUNICIPIO:</h4>
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
                                <h4 class="example-title"><span style="color:red;">* </span>DOMICILIO:</h4>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa-home" aria-hidden="true"></i>
                                    </span>
                                    <input id="sDomicilio" name="sDomicilio" placeholder="DOMICILIO" type="text" class="form-control" autocomplete="off"   
                                    value = "<?php echo isset($data['datos']['sDomicilio']) ? $data['datos']['sDomicilio'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>OBSERVACIONES:</h4>
                                <textarea id="sObservaciones" name="sObservaciones" placeholder="OBSERVACIONES" class="form-control" rows="3"><?php echo isset($data['datos']['sObservaciones']) ? $data['datos']['sObservaciones'] : ''; ?></textarea>
                            </div>
                        </div>

                        <?php 
                            if($this->verify_permissions('A')){
                        ?>

                        <div class="col-lg-12 col-md-12 clearfix"></div>
                        
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>PERSONAL ASIGNADO:</h4>
                                <div class="select2-primary">
                                    <select name="skCitaPersonal_array[]" id="skCitaPersonal_array" class="form-control select2" multiple="multiple" data-plugin="select2" data-ajax--cache="true">
                                        <?php
                                            if (!empty($data['citas_personal'])) {
                                                foreach ($data['citas_personal'] as $row) {
                                        ?>
                                            <option selected="selected" value="<?php echo $row['skUsuarioPersonal']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php
                                                }//ENDWHILE
                                            }//ENDIF
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">INSTRUCCIONES DE SERVICIO:</h4>
                                <textarea id="sInstruccionesServicio" name="sInstruccionesServicio" placeholder="INSTRUCCIONES DE SERVICIO" class="form-control" rows="3"><?php echo isset($data['datos']['sInstruccionesServicio']) ? $data['datos']['sInstruccionesServicio'] : ''; ?></textarea>
                            </div>
                        </div>

                        <?php
                            }//ENDIF
                        ?>
                    
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validaciones;
    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);

        $("#skCategoriaCita").select2({placeholder: "CATEGORIA", allowClear: true });
        $("#skEstadoMX").select2({placeholder: "ESTADO", allowClear: true });
        $("#skMunicipioMX").select2({placeholder: "MUNICIPIO", allowClear: true });

        core.autocomplete2('#skOrdenServicio', 'get_ordenServicio', window.location.href, 'ORDEN SERVICIO', {});
        core.autocomplete2('#skCitaPersonal_array', 'get_personal', window.location.href, 'PERSONAL ASIGNADO', {
            skCategoriaCita: $('#skCategoriaCita'),
            skEstadoMX: $('#skEstadoMX'),
            skMunicipioMX: $('#skMunicipioMX'),
            dFechaCita: $('#dFechaCita')
        });

        $(".input-datepicker").datepicker({
            format: "dd/mm/yyyy"
        });

        $("#tHoraInicio").select2({placeholder: "HORA", allowClear: true });

        $("#dFechaCita").change(function(e){
            var dFechaCita = $("#dFechaCita").val();
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    axn: 'get_horarios_disponibles',
                    dFechaCita: dFechaCita
                },
                cache: false,
                async: false,
                beforeSend: function () {
                    toastr.info('CARGANDO HORARIOS DISPONIBLES <i class="fa fa-spinner faa-spin animated"></i>', 'NOTIFICACIÓN', {timeOut: false});
                },
                success: function (response) {
                    toastr.clear();
                    if(response.success){
                        toastr.success(response.message, 'NOTIFICACIÓN');
                        
                        // HORARIOS DE CITAS DISPONIBLES //
                            let horaInicio = response.horarios_disponibles.horaInicio;
                            let horaFin = response.horarios_disponibles.horaFin;
                            let horaDescansoInicio = response.horarios_descansos.horaInicio;
                            let horaDescansoFin = response.horarios_descansos.horaFin;

                            if(response.horarios_disponibles_excepciones.horaInicio){
                                
                                horaInicio = response.horarios_disponibles_excepciones.horaInicio;
                                horaFin = response.horarios_disponibles_excepciones.horaFin;

                                // HORARIOS DE DESCANSOS //
                                    if(response.horarios_descansos_excepciones.horaInicio){
                                        horaDescansoInicio = response.horarios_descansos_excepciones.horaInicio;
                                        horaDescansoFin = response.horarios_descansos_excepciones.horaFin;
                                    }else{
                                        horaDescansoInicio = false;
                                        horaDescansoFin = false;
                                    }

                            }
                        
                        // RECORREMOS LOS HORARIOS DISPONIBLES //
                            let option = '<option value="">- SELECCIONAR -</option>';
                            for(let hora = horaInicio; hora <= horaFin; hora++){
                                if(horaDescansoInicio && hora >= horaDescansoInicio && hora <= horaDescansoFin){
                                    //console.log('horarios_descansos: '+hora);
                                    continue;
                                }
                                //console.log('horarios_disponibles: '+hora);
                                option += '<option value="'+hora+':00:00">'+hora+':00:00</option>';
                                if(hora < horaFin){
                                    option += '<option value="'+hora+':30:00">'+hora+':30:00</option>';
                                }
                            }

                            $("#tHoraInicio").html(option);
                            $("#tHoraInicio").select2({placeholder: "HORA", allowClear: true });
                    }else{
                        toastr.error(response.message, 'NOTIFICACIÓN');
                    }
                }
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
</script>