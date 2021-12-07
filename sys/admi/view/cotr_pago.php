<?php
    if(isset($data['datos'])){
        $result = $data['datos'];
    }
?>
<div class="row">
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    
    <div class="col-md-12">
        <div class="panel panel-bordered panel-danger panel-line animated slideInLeft">
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
            <div class="panel-body container-fluid same-heigth">
                <div class="col-md-12 same-heigth">

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <h4 class="example-title">RESPONSABLE:</h4>
                            <p><?php echo $result['empresaResponsable'] . ' (' . $result['empresaResponsableRFC'] . ')'; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <h4 class="example-title">IMPORTADOR / EXPORTADOR:</h4>
                            <p><?php echo (isset($result['empresaCliente']) && !empty($result['empresaCliente'])) ? $result['empresaCliente'] . ' (' . $result['empresaClienteRFC'] . ')' : '-'; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 clearfix"><hr></div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">DIVISA:</h4>
                            <p><?php echo (isset($result['divisa'])) ? ($result['divisa']) : ''; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">BANCO EMISOR:</h4>
                            <p><?php echo (isset($result['bancoEmisor'])) ? ($result['bancoEmisor']) : ''; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">CUENTA BANCARIA EMISORA:</h4>
                            <p><?php echo (isset($result['sBancoCuentaEmisor'])) ? $result['sBancoCuentaEmisor'] : ''; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 clearfix"><hr></div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">FECHA DE TRANSFERENCIA:</h4>
                            <p><?php echo (!empty($result['dFechaTransaccion'])) ? date('d/m/Y', strtotime($result['dFechaTransaccion'])) : ''; ?></p>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">REFERENCIA:</h4>
                            <p><?php echo (isset($result['sReferencia'])) ? ($result['sReferencia']) : ''; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">IMPORTE:</h4>
                            <p><?php echo (isset($result['fImporte'])) ? number_format($result['fImporte'],2) : ''; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 clearfix"><hr></div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">FORMA DE PAGO:</h4>
                            <p><?php echo (isset($result['formaPago'])) ? ($result['formaPago']) : ''; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">BANCO RECEPTOR:</h4>
                            <p><?php echo (isset($result['bancoReceptor'])) ? ($result['bancoReceptor']) : ''; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">CUENTA BANCARIA RECEPTORA:</h4>
                            <p><?php echo (isset($result['sTitularReceptor']) && !empty($result['sTitularReceptor'])) ? ($result['sTitularReceptor'].' ('.$result['sNumeroCuentaReceptor'].')') : ''; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 clearfix"><hr></div>

                    <div class="col-md-8 col-lg-6">
                        <div class="form-group">
                            <h4 class="example-title">OBSERVACIONES:</h4>
                            <p><?php echo (isset($result['sObservaciones']) && !empty($result['sObservaciones'])) ? ($result['sObservaciones']) : ''; ?></p>
                        </div>
                    </div>
                    
                    <!-- COMPROBANTE !-->
                    <?php
                        if(isset($result['sComprobanteArchivo']) && !empty($result['sComprobanteArchivo'])){
                    ?>
                    <div class="widget col-md-4 col-lg-6">
                        <div class="widget-content padding-10 bg-white clearfix">
                            <center>
                                <a type="button" href="javascript:void(0);" onclick="verDocumento({url:'<?php echo SYS_URL.'sys/digi/dedo-serv/descargar-documento/?preview=1&skDocumento='.(isset($result['sComprobanteArchivo']) && !empty($result['sComprobanteArchivo']) ? $result['sComprobanteArchivo'] : ''); ?>'});" class="ajax-popup-link">
                                    <div class="white" style="cursor: pointer;">
                                        <i style="font-size: 15px;" class="pull-center icon icon-circle icon-2x icon fa fa-file-pdf-o bg-red-600" aria-hidden="true"></i>
                                    </div>
                                    <h3 class="panel-title text-center">COMPROBANTE</h3>
                                </a>
                            </center>
                        </div>
                    </div>
                    <?php
                        }//ENDIF
                    ?>
                    <!-- COMPROBANTE !-->

                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="panel panel-bordered panel-danger panel-line animated slideInRight">
            <div class="panel-heading">
                <h3 class="panel-title">FACTURAS
                    <?php
                        if(isset($result['fSaldo'])){
                    ?>
                    <small class="pull-right font-size-20">SALDO <?php echo (isset($result['fSaldo'])) ? '$'. number_format($result['fSaldo'],2) : '$0.00'; ?></small>
                    <?php }//ENDIF ?>
                </h3>
            </div>
            <div class="panel-body container-fluid same-heigth">
                <div class="col-md-12 same-heigth">
                    
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <b class="red-600 font-size-15 pull-left" id="fSaldoRestanteTransaccion"></b>
                            <b class="red-600 font-size-15 pull-left" id="messageFacturas"></b>
                            <b class="red-600 font-size-15 pull-right" id="importeFacturas">$0.00</b>
                        </div>
                        <div class="input-group margin-top-20"> <span class="input-group-addon">FILTRAR</span>
                            <input id="filter" type="text" class="form-control" autocomplete="off" placeholder="ESCRIBE AQUÍ...">
                        </div>
                        <div class="table-responsive clearfix" id="div-table-facturas" style="height:450px;overflow-y:visible;font-size: 8pt;">
                            <table class="table table-striped table-bordered" id="table-facturas">
                                <thead>
                                    <tr>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input value="1" class="check_factura_all" id="check_factura_all" type="checkbox" onchange="admi.cotr_pago.check_factura_all(this);">
                                                <label for="check_factura_all"></label>
                                            </div>
                                        </th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">FOLIO</th>
                                        <th class="col-xs-3 col-md-3 text-center" style="text-align:center;">IMPORTE</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">SALDO</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">TOTAL</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">FORMA DE PAGO</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">MÉTODO DE PAGO</th>
                                        <th class="col-xs-1 col-md-1 text-center" style="text-align:center;">F. FACT.</th>
                                    </tr>
                                </thead>
                                <tbody class="searchable" id="table-body-facturas">
                                    <?php
                                        if(isset($data['comprobantes']) && is_array($data['comprobantes']) && count($data['comprobantes']) > 0){
                                            foreach($data['comprobantes'] AS $row){
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="checkbox-custom checkbox-primary">
                                                <input value="<?php echo $row['skComprobanteCFDI']; ?>" name="comprobantes[]" class="check_factura" id="check_factura_<?php echo $row['iFolio']; ?>" type="checkbox" onchange="admi.cotr_pago.check_factura(this);">
                                                <label for="check_factura_<?php echo $row['iFolio']; ?>"></label>
                                            </div>
                                        </td>
                                        <td class="text-right"><?php echo $row['iFolio']; ?></td>
                                        <td class="text-right">
                                            <input class="form-control text-right importeAplicado" onchange="admi.cotr_pago.changeImporte(this);" id="importeAplicado_<?php echo $row['skComprobanteCFDI']; ?>" name="importeAplicado[<?php echo $row['skComprobanteCFDI']; ?>]" value="" placeholder="0.00" autocomplete="off" type="text" disabled>
                                        </td>
                                        <td class="text-right"><?php echo ($row['fSaldo']) ? '$'.number_format(bcdiv($row['fSaldo'],'1',2),2) : '$0.00'; ?></td>
                                        <td class="text-right"><?php echo ($row['fTotal']) ? '$'.number_format(bcdiv($row['fTotal'],'1',2),2) : '$0.00'; ?></td>
                                        <td class="text-center"><?php echo ($row['formaPago']) ? $row['formaPago'] : ''; ?></td>
                                        <td class="text-center"><?php echo ($row['metodoPago']) ? $row['metodoPago'] : ''; ?></td>
                                        <td class="text-center"><?php echo ($row['dFechaFactura']) ? date('d/m/Y', strtotime($row['dFechaFactura'])) : '-'; ?></td>
                                    </tr>
                                    <?php
                                            }//ENDFOREACH
                                        }else{
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan="7">NO SE ENCONTRARON FACTURAS</td>
                                    </tr>
                                    <?php
                                        }//ENDIF
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
    
    var fSaldoTransaccion = <?php echo (isset($result['fSaldo'])) ? $result['fSaldo'] : 0; ?>;
    var importeFacturas = 0;
    var totalImporteAplicado = 0;
            
    function verDocumento(conf){
        $.magnificPopup.open({
            items: {
                src: conf.url
            },
            type: 'iframe'
        });
    }
    
    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);
        
        $('#mowi').iziModal('setBackground', '#f1f4f5');
        
        $('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });
        
    });
</script>