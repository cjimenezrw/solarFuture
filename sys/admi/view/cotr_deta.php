<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
}
?>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-bordered panel-danger panel-line animated slideInLeft">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS GENERALES
		    <?php
		    if (isset($result['fSaldo'])) {
			?>
    		    <small class="pull-right font-size-20">SALDO <?php echo (isset($result['fSaldo'])) ? '$' . number_format($result['fSaldo'], 2) : '$0.00'; ?></small>
		    <?php }//ENDIF ?>
                </h3>
		<?php
		if (isset($result['iFolio'])) {
		    ?>
    		<div class="alert alert-primary alert-dismissible" role="alert">
    		    <b class="red-600 font-size-20"><?php echo (isset($result['iFolio'])) ? ($result['iFolio']) : ''; ?></b>
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
                            <p><?php echo (isset($result['skDivisa'])) ? ($result['skDivisa']) : ''; ?></p>
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
                            <p><?php echo (isset($result['fImporte'])) ? number_format($result['fImporte'], 2) : ''; ?></p>
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
                            <p><?php echo (isset($result['bancoReceptor'])) ? ($result['bancoReceptor']) : '-'; ?></p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">CUENTA BANCARIA RECEPTORA:</h4>
                            <p><?php echo (isset($result['sTitularReceptor']) && !empty($result['sTitularReceptor'])) ? ($result['sTitularReceptor'] . ' (' . $result['sNumeroCuentaReceptor'] . ')') : '-'; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 clearfix"><hr></div>

                    <div class="col-md-8 col-lg-6">
                        <div class="form-group">
                            <h4 class="example-title">OBSERVACIONES:</h4>
                            <p><?php echo (isset($result['sObservaciones']) && !empty($result['sObservaciones'])) ? ($result['sObservaciones']) : '-'; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12 clearfix"><hr></div>

                    <!-- COMPROBANTE !-->
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <h4 class="example-title">COMPROBANTE:</h4>
                            <div class="col-md-12 col-lg-12" id="docu_ADMINI_COMPRO"></div>
                        </div>
                    </div>
                    <!-- COMPROBANTE !-->

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-bordered panel-danger panel-line animated slideInRight">
            <div class="panel-heading">
                <h3 class="panel-title">
                    TRANSACCIONES <?php echo (isset($data['transaccionesFacturas'])) ? '<span class="label label-danger">' . count($data['transaccionesFacturas']) . "</span>" : ''; ?>
                </h3>
            </div>
            <div class="panel-body container-fluid same-heigth">
                <div class="col-md-12 same-heigth">

                    <div class="input-group margin-top-20"> <span class="input-group-addon">FILTRAR</span>
                        <input id="filter" type="text" class="form-control" autocomplete="off" placeholder="ESCRIBE AQUÍ...">
                    </div>
                    <div class="table-responsive clearfix" id="div-table-facturas" style="height:450px;overflow-y:visible;font-size: 10pt;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span title="ESTATUS" data-toggle="tooltip" data-placement="rigth">E</span></th>
                                    <th>NÚMERO DE PAGO</th>
                                    <th>FOLIO FACTURA</th>
                                    <th>TOTAL FACTURA</th>
                                    <th>SALDO ANTERIOR FACTURA</th>
                                    <th>IMPORTE</th>
                                    <th>SALDO RESTANTE FACTURA</th>
                                    <th>FORMA DE PAGO</th>
                                    <th>MÉTODO DE PAGO</th>
                                    <th>USUARIO</th>
                                    <th>F. FACT.</th>
                                    <th>F. APLICACIÓN PAGO</th>
                                </tr>
                            </thead>
                            <tbody class="searchable" id="table-body-facturas">
                            <?php
				$i = 1;
				if (isset($data['get_transaccion_facturas']) && count($data['get_transaccion_facturas']) > 0) {
				    foreach ($data['get_transaccion_facturas'] AS $trans) {
					?>
					<tr>
					    <td><?php echo $i; ?></td>
                                            <td class="text-center" ><i class="<?php echo $trans['sIconoTransaccionFactura']; ?> <?php echo $trans['sColorTransaccionFactura']; ?>" title="<?php echo $trans['estatusTransaccionFactura']; ?>" data-toggle="tooltip" data-placement="rigth"></i></td>
					    <td class="text-center" ><?php echo $trans['iParcialidad']; ?></td>
					    <td class="text-left" ><?php echo $trans['iFolioFactura']; ?></td>
					    <!--<td class="text-left"><?php echo "$" . number_format($trans['fTotal'], 2); ?></td>
					    <td class="text-left"  ><?php echo "$" . number_format($trans['fSaldoAnteriorFactura'], 2); ?></td>
					    <td class="text-left"><?php echo "$" . number_format($trans['fImporte'], 2); ?></td>
					    <td class="text-left"><?php echo "$" . number_format($trans['fSaldoRestanteFactura'], 2); ?></td>!-->
                                            
                                            
                                            <td class="text-left"><?php echo "$" . number_format(bcdiv($trans['fTotal'],'1',2), 2); ?></td>
					    <td class="text-left"  ><?php echo "$" . number_format(bcdiv($trans['fSaldoAnteriorFactura'],'1',2), 2); ?></td>
					    <td class="text-left"><?php echo "$" . number_format(bcdiv($trans['fImporte'],'1',2), 2); ?></td>
					    <td class="text-left"><?php echo "$" . number_format(bcdiv($trans['fSaldoRestanteFactura'],'1',2), 2); ?></td>
                                            
                                            
                                            <td class="text-left"><?php echo ($trans['formaPago']) ? $trans['formaPago'] : ''; ?></td>
                                            <td class="text-left"><?php echo ($trans['metodoPago']) ? $trans['metodoPago'] : ''; ?></td>
					    <td class="text-left"><?php echo $trans['usuarioCreacion']; ?></td>
                                            <td class="text-left"><?php echo (isset($trans['dFechaFacturacion'])) ? date('d/m/Y H:i:s', strtotime($trans['dFechaFacturacion'])) : ''; ?></td>
                                            <td class="text-left"><?php echo (isset($trans['dFechaCreacion'])) ? date('d/m/Y H:i:s', strtotime($trans['dFechaCreacion'])) : ''; ?></td>
					</tr>
					<?php
					$i++;
				    }//FOREACH
                                }else{
                                    echo '<tr><td colspan="12" class="text-center"><h5>NO SE ENCONTRARON FACTURAS</h5></td></tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <br>
    <?php if (!empty($data['get_transaccionesComprobantes'])) { ?>
        <div class="col-md-12">
    	<div class="panel panel-bordered panel-danger panel-line animated slideInRight">
    	    <div class="panel-heading">
    		<div class="panel-actions">
			<?php echo (!empty($data['get_transaccionesComprobantes'])) ? '<span class="label label-danger">' . count($data['get_transaccionesComprobantes']) . "</span>" : ''; ?>
    		</div>
    		<h3 class="panel-title">COMPLEMENTOS</h3>
    	    </div>
    	    <table class="table table-hover">
    		<thead >
    		    <tr>
    			<th class="text-center">#</th>
    			<th class="text-center">Estatus</th>
    			<th class="text-center">Folio</th>
    			<th class="text-center">Usuario</th>
    			<th class="text-center">Fecha Timbrado</th>
    			<th class="text-center">XML</th>
    			<th class="text-center">PDF</th>
    		    </tr>
    		</thead>
    		<tbody>
			<?php
			$i = 1;
			if (isset($data['get_transaccionesComprobantes'])) {
			    foreach ($data['get_transaccionesComprobantes'] AS $trans) {
				?>
	    		    <tr>
	    			<td class="text-center"><?php echo $i; ?></td>
	    			<td class="text-center"><?php echo ($trans['skEstatus'] != '')?($trans['skEstatus'] == 'FA')?'TIMBRADO':'':''; ?></td>
	    			<td class="text-center"><?php echo ($trans['sFolio'] != '')?$trans['sFolio']:''; ?></td>
	    			<td class="text-center"><?php echo ($trans['nombreCreacion'] != '')?$trans['nombreCreacion']:''; ?></td>
	    			<td class="text-center"><?php echo (!empty($trans['dFechaCreacion'])) ? date('d/m/Y H:i:s', strtotime($trans['dFechaCreacion'])) : ''; ?></td>
				<td class="text-center">
				    <a type="button" href="<?php echo (isset($trans['facturaXML']) && !empty($trans['facturaXML']) ? $trans['facturaXML'] : ''); ?>" target="_blank" class="ajax-popup-link fa fa-file-pdf-o"></a>
				 	   <!--    <a style="font-size: 16px;" type="button" target="/sys/digi/dedo-serv/descargar-documento/?skDocumento=76DB8527-AFCF-4A8F-8A8B-A34111BB591A&amp;preview=1" class="ajax-popup-link fa fa-file-pdf-o" onclick="verFormatoPrevios(this.target);"></a>-->
				</td>
				<td class="text-center">
				    <a type="button" href="<?php echo (isset($trans['facturaPDF']) && !empty($trans['facturaPDF']) ? $trans['facturaPDF'] : ''); ?>" target="_blank" class="ajax-popup-link fa fa-file-pdf-o"></a>
				   <!-- <a style="font-size: 16px;" type="button" target="/sys/digi/dedo-serv/descargar-documento/?skDocumento=76DB8527-AFCF-4A8F-8A8B-A34111BB591A&amp;preview=1" class="ajax-popup-link fa fa-file-pdf-o" onclick="verFormatoPrevios(this.target);"></a>-->
				</td>
	    		    </tr>
			    <?php
			    $i++;
			    }
			    ?>
	    		</tbody>
	    	    </table>
	    	</div>
	        </div>

		<?php

		    }
		}//ENDIF
		?>

	   

	</div>
	<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">


				    $(document).ready(function () {

                        $('.ajax-popup-link').magnificPopup({
            					type: 'iframe'
            			});
					$('#mowi').iziModal('setBackground', '#f1f4f5');
					$('#filter').keyup(function () {
					    var rex = new RegExp($(this).val(), 'i');
					    $('.searchable tr').hide();
					    $('.searchable tr').filter(function () {
						return rex.test($(this).text());
					    }).show();
					});

                    // DOCUMENTO COMPROBANTE //
                    $('#docu_ADMINI_COMPRO').core_docu_component({
                        skTipoExpediente: 'ADMINI',
                        skTipoDocumento: 'COMPRO',
                        skCodigo: '<?php echo $result['skTransaccion']; ?>',
                        name: 'docu_file_ADMINI_COMPRO',
                        readOnly: true,
                        deleteCallBack: function (e) {}
                    });


				    });

				    $("#btnComplementoPago").click(function () {


					$.ajax({
					    url: window.location.href,
					    type: 'POST',
					    data: {
						axn: 'generarComplementoPago'
					    },
					    cache: false,
					    processData: true,
					    beforeSend: function () {
					    },
					    success: function (response) {
						if (response === false) {
						    toastr.warning('NO HAY CONTENEDORES DISPONIBLES..', {timeOut: false});
						    core.dataTable.sendFilters(true);
						}

						if (!core.sessionOut(response)) {
						    return false;
						}
					    }
					});

				    });
</script>
