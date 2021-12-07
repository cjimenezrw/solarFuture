<?php
    if(isset($data['datos'])){
        $result = $data['datos'];
    }
?>
<div class="row">
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <input class="form-control" id="skTipoTransaccion" name="skTipoTransaccion" value="<?php echo (isset($result['skTipoTransaccion'])) ? ($result['skTipoTransaccion']) : 'TRAN'; ?>" placeholder="skTipoTransaccion" autocomplete="off" type="text" style="display: none;">
    
    <div class="panel panel-bordered panel-primary panel-line animated slideInUp">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS GENERALES</h3>
            <?php
                if(isset($result['iFolio'])){
            ?>
            <div class="alert alert-primary alert-dismissible" role="alert">
                <b class="red-600 font-size-24"><?php echo (isset($result['iFolio'])) ? ($result['iFolio']) : ''; ?></b>
            </div>
            <?php }//ENDIF ?>
        </div>
        <div class="panel-body container-fluid">
            <div class="row row-lg">
            
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> RESPONSABLE:</h4>
                        <select name="skEmpresaSocioResponsable" id="skEmpresaSocioResponsable" class="form-control" data-plugin="select2" data-ajax--cache="true" onchange="admi.cotr_form.changeResponsable(this);">
                            <?php
                            if (!empty($result['skEmpresaSocioResponsable'])) {
                                ?>
                                <option value="<?php echo $result['skEmpresaSocioResponsable']; ?>" selected="selected"><?php echo $result['empresaResponsable'] . ' (' . $result['empresaResponsableRFC'] . ')'; ?></option>
                                <?php
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-6 skEmpresaSocioCliente" <?php echo (isset($result['skEmpresaSocioResponsable'])) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                    <div class="form-group">
                        <h4 class="example-title">IMPORTADOR / EXPORTADOR:</h4>
                        <select name="skEmpresaSocioCliente" id="skEmpresaSocioCliente" class="form-control" data-plugin="select2" data-ajax--cache="true">
                            <?php
                            if (!empty($result['skEmpresaSocioCliente'])) {
                                ?>
                                <option value="<?php echo $result['skEmpresaSocioCliente']; ?>" selected="selected"><?php echo $result['empresaCliente'] . ' (' . $result['empresaClienteRFC'] . ')'; ?></option>
                                <?php
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12 clearfix"><hr></div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> DIVISA:</h4>
                        <select name="skDivisa" id="skDivisa" class="form-control selectpicker" data-live-search="true" data-plugin="selectpicker" onchange="admi.cotr_form.changeDivisa(this);">
                            <option value="" disabled="" selected="selected">DIVISA</option>
                            <?php
                                if ($data['get_divisas']) {
                                    foreach ($data['get_divisas'] as $key=>$row) {
                            ?>
                                    <option <?php echo(isset($result['skDivisa']) && $result['skDivisa'] == $row['skDivisa'] ? 'selected="selected"' : (($row['skDivisa'] == 'MXN' && !isset($result['skDivisa'])) ? 'selected="selected"' : '' )) ?>
                                        value="<?php echo $row['skDivisa']; ?>"><?php echo '('.$row['skDivisa'].') '.$row['sNombre']; ?> </option>
                            <?php
                                    }//ENDFOREACH
                                }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4 fTipoCambio" <?php echo (isset($result['skDivisa']) && $result['skDivisa'] == 'USD') ? 'style="display:block;"' : 'style="display:none;"'; ?> >
                    <div class="form-group">
                        <h4 class="example-title">TIPO DE CAMBIO:</h4>
                        <input class="form-control" id="fTipoCambio" name="fTipoCambio" value="<?php echo (isset($result['fTipoCambio'])) ? ($result['fTipoCambio']) : ''; ?>" placeholder="TIPO DE CAMBIO" autocomplete="off" type="text">
                    </div>
                </div>
                
              <!--  <div class="col-md-12 clearfix">
                    <label onclick="admi.cotr_form.get_facturas_pendientes_pago({});" class="btn btn-outline btn-success"><i class="icon fa-file-pdf-o" aria-hidden="true"></i> CONSULTAR FACTURAS</label>
                    <label onclick="admi.cotr_form.ocultar_facturas_pendientes_pago({});" class="btn btn-outline btn-warning"><i class="icon fa-eye-slash" aria-hidden="true"></i> OCULTAR FACTURAS</label>
                    <div class="col-md-12 clearfix" id="div-content-table-facturas" style="display:none;">
                        <div class="input-group margin-top-20"> <span class="input-group-addon">FILTRAR</span>
                            <input id="filter" type="text" class="form-control" autocomplete="off" placeholder="ESCRIBE AQUÍ...">
                        </div>
                        <div class="table-responsive clearfix" id="div-table-facturas" style="height:450px;overflow-y:visible;font-size: 8pt;">
                            <table class="table table-striped table-bordered" id="table-facturas">
                                <thead>
                                    <tr>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">FOLIO</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">SALDO</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">TOTAL</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">FORMA DE PAGO</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">MÉTODO DE PAGO</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">F. FACTURACIÓN.</th>
                                    </tr>
                                </thead>
                                <tbody class="searchable" id="table-body-facturas">
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>-->
                
                <div class="col-md-12 clearfix"><hr></div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> BANCO EMISOR:</h4>
                        <select name="skBancoEmisor" id="skBanco_emisor" class="form-control selectpicker" data-live-search="true" data-plugin="selectpicker">
                            <option value="" disabled="" selected="selected">BANCO EMISOR</option>
                            <?php
                                if ($data['get_bancosEmisor']) {
                                    foreach ($data['get_bancosEmisor'] as $key=>$row) {
                            ?>
                                    <option <?php echo(isset($result['skBancoEmisor']) && $result['skBancoEmisor'] == $row['skBanco'] ? 'selected="selected"' : '') ?>
                                        value="<?php echo $row['skBanco']; ?>"><?php echo $row['sNombre']; ?> </option>
                            <?php
                                    }//ENDFOREACH
                                }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">CUENTA BANCARIA EMISORA:</h4>
                        <input class="form-control" id="sBancoCuentaEmisor" name="sBancoCuentaEmisor" value="<?php echo (isset($result['sBancoCuentaEmisor'])) ? ($result['sBancoCuentaEmisor']) : ''; ?>" placeholder="CUENTA BANCARIA EMISORA" autocomplete="off" type="text">
                    </div>
                </div>
                
                <div class="col-md-12 clearfix"><hr></div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> FECHA DE TRANSFERENCIA:</h4>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="wb-calendar" aria-hidden="true"></i>
                            </span>
                            <input class="form-control input-datepicker" id="dFechaTransaccion" name="dFechaTransaccion" value="<?php echo (!empty($result['dFechaTransaccion'])) ? date('d/m/Y', strtotime($result['dFechaTransaccion'])) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                        </div>
                    </div>
                </div>
                
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> REFERENCIA:</h4>
                        <input class="form-control" id="sReferencia" name="sReferencia" value="<?php echo (isset($result['sReferencia'])) ? ($result['sReferencia']) : ''; ?>" placeholder="REFERENCIA" autocomplete="off" type="text">
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> IMPORTE:</h4>
                        <input class="form-control" id="fImporte" name="fImporte" value="<?php echo (isset($result['fImporte'])) ? ($result['fImporte']) : ''; ?>" placeholder="IMPORTE" autocomplete="off" type="text">
                    </div>
                </div>
                
                <div class="col-md-12 clearfix"><hr></div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> FORMA DE PAGO:</h4>
                        <select name="skFormaPago" id="skFormaPago" class="form-control" data-plugin="select2" select2Simple>
                            <option value="" disabled="" selected="selected">FORMA DE PAGO</option>
                            <?php
                                if ($data['get_formasPago']) {
                                    foreach ($data['get_formasPago'] as $row) {
                            ?>
                                    <option <?php echo(isset($result['skFormaPago']) && $result['skFormaPago'] == $row['skFormaPago'] ? 'selected="selected"' : (($row['sCodigo'] == '03' && !isset($result['skFormaPago'])) ? 'selected="selected"' : '' )) ?>
                                        value="<?php echo $row['skFormaPago']; ?>"><?php echo '('.$row['sCodigo'].') '.$row['sNombre']; ?> </option>
                            <?php
                                    }//ENDFOREACH
                                }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> BANCO RECEPTOR:</h4>
                        <select name="skBancoReceptor" id="skBanco_receptor" class="form-control selectpicker" data-live-search="true" data-plugin="selectpicker" onchange="admi.cotr_form.changeBanco('receptor');">
                            <option value="" disabled="" selected="selected">BANCO RECEPTOR</option>
                            <?php
                                if ($data['get_bancosReceptor']) {
                                    foreach ($data['get_bancosReceptor'] as $row) {
                            ?>
                                    <option <?php echo(isset($result['skBancoReceptor']) && $result['skBancoReceptor'] == $row['skBanco'] ? 'selected="selected"' : '') ?>
                                        value="<?php echo $row['skBanco']; ?>"><?php echo $row['banco']; ?> </option>
                            <?php
                                    }//ENDFOREACH
                                }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> CUENTA BANCARIA RECEPTORA:</h4>
                        <select name="skBancoCuentaReceptor" id="skBancoCuenta_receptor" class="form-control selectpicker" data-live-search="true" data-plugin="selectpicker" <?php echo isset($result['skBancoCuentaReceptor']) ? '': 'disabled';?>>
                            <option value="" disabled="" selected="selected">CUENTA BANCARIA RECEPTORA</option>
                            <?php
                                if ($data['get_bancosCuentasReceptor']) {
                                    foreach ($data['get_bancosCuentasReceptor'] as $cuenta) {
                                        foreach($cuenta as $row){
                            ?>
                                    <option <?php echo(isset($result['skBancoCuentaReceptor']) && $result['skBancoCuentaReceptor'] == $row['skBancoCuenta'] ? 'selected="selected"' : '') ?>
                                        class="option_banco_receptor banco_receptor_<?php echo $row['skBanco']; ?>" 
                                        <?php echo ((isset($result['skBancoReceptor']) && $result['skBancoReceptor'] == $row['skBanco']) ? 'style="display:block;"': 'style="display:none;"'); ?>
                                        value="<?php echo $row['skBancoCuenta']; ?>"><?php echo $row['sTitular'].' ('.$row['sNumeroCuenta'].') - '.$row['skDivisa']; ?> </option>
                            <?php
                                    }//ENDFOREACH
                                }//ENDFOREACH
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12 clearfix"><hr></div>
                
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <h4 class="example-title">OBSERVACIONES:</h4>
                        <textarea class="form-control" rows="5" id="sObservaciones" name="sObservaciones" placeholder="OBSERVACIONES"><?php echo (isset($result['sObservaciones']) && !empty($result['sObservaciones'])) ? ($result['sObservaciones']) : ''; ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-12 clearfix"><hr></div>
                
                <div class="col-md-12 col-lg-12">
                    <div class=" form-group" >
                        <h5 class="text-center"><b class="red-600">*</b> COMPROBANTE</h5>
                        <div class="col-md-12" id="docu_ADMINI_COMPRO"></div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    
</form>
</div>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;
    
    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);
        
        // Obtener Empresas //
            core.autocomplete2('#skEmpresaSocioResponsable', 'getEmpresas', window.location.href, 'EMPRESA RESPONSABLE',{
                skEmpresaTipo : '[ "AGAD" ]'
            });
            
            core.autocomplete2('#skEmpresaSocioCliente', 'getEmpresas', window.location.href, 'IMPORTADOR / EXPORTADOR',{
                skEmpresaTipo : '["CLIE","AGAD" ]',
                skEmpresaSocioResponsable : $("#skEmpresaSocioResponsable")
            });
            
        $("#skFormaPago").select2({
            placeholder: "FORMA DE PAGO",
            allowClear: true
        });
        
        $("#skDivisa").selectpicker();
        
        $("#skBanco_emisor").selectpicker();
        //$("#skBancoCuenta_emisor").selectpicker();
        $("#skBanco_receptor").selectpicker();
        $("#skBancoCuenta_receptor").selectpicker();
        
        $(".input-datepicker").datepicker({
            format: "dd/mm/yyyy"
        });
            
        
            
        $('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

        // DOCUMENTO COMPRONAMTE //
        $('#docu_ADMINI_COMPRO').core_docu_component({
                skTipoExpediente: 'ADMINI',
                skTipoDocumento: 'COMPRO',
                skCodigo: '<?php echo (!empty($result['skTransaccion']) ? $result['skTransaccion'] : '');?>',
                name: 'docu_file_ADMINI_COMPRO',
                deleteCallBack: function (e) {}
            });
        
    });
</script>