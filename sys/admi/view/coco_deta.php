<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    //$facturas = (isset($data['facturadas'])) ? $data['facturadas'] : '';

  
    /*    echo '<pre>';
      print_r($data);
      exit(); */
}
?>
<div class="row">
    <div class="col-md-12 page-invoice font-size-12">
	<div class="col-md-12">
	    <div class="panel panel-bordered panel-primary panel-line animated slideInLeft">
		<div class="panel-heading">
		    <h3 class="panel-title">DETALLES GENERALES</h3>
		    <?php
		    if (isset($result['iFolio'])) {
			?>
    		    <div class="alert alert-primary alert-dismissible" role="alert">
    			<b class="red-600 font-size-20"><?php echo (isset($result['iFolio'])) ? ($result['iFolio']) : ''; ?></b>
    		    </div>
		    <?php }//ENDIF  ?>
		</div>
		<div class="panel-body container-fluid same-heigth">

		    <div class="col-md-12 same-heigth">
			<div class="col-md-6 col-lg-6">
			    <div class="form-group">
				<h4 class="example-title">ESTATUS:</h4>
				<p><?php echo (isset($result['estatus'])) ? $result['estatus'] : ''; ?></p>
			    </div>
			</div>
			<div class="col-md-6 col-lg-6">
			    <div class="form-group">
				<h4 class="example-title">FECHA CREACIÓN:</h4>
				<p><?php echo ($result['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($result['dFechaCreacion'])) : ''; ?></p>
			    </div>
			</div>


		    </div>

		    <div class="col-md-12 same-heigth">
			<div class="col-md-4 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">EMISOR:</h4>
				<p><?php echo (isset($result['empresaEmisor'])) ? $result['empresaEmisor'] : 'N/D'; ?> </p>
			    </div>
			</div>
			<div class="col-md-4 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">RESPONSABLE:</h4>
				<p><?php echo (isset($result['empresaResponsable'])) ? $result['empresaResponsable'] : 'N/D'; ?> </p>
			    </div>
			</div>
			<div class="col-md-4 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">CLIENTE:</h4>
				<p><?php echo (isset($result['empresaCliente'])) ? $result['empresaCliente'] : 'N/D'; ?> </p>
			    </div>
			</div>
		    </div>

		  
		    <div class="col-md-12 same-heigth">
			<div class="col-md-6 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">Divisa:</h4>
				<p><?php echo (isset($result['skDivisa'])) ? $result['skDivisa'] : 'N/D'; ?> </p>
			    </div>
			</div>
			<div class="col-md-6 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">Tipo de Cambio:</h4>
				<p><?php echo (!empty($result['fTipoCambio'])) ? number_format($result['fTipoCambio'], 4) : 'N/D'; ?> </p>
			    </div>
			</div>
		    </div>
		    <div class="col-md-12 same-heigth">
			<div class="col-md-3 col-lg-3">
			    <span class="label label-lg label-success">Datos para Facturar</span>
			</div>
			<div class="col-md-9 col-lg-9">
			    <hr>
			</div>

		    </div>
		    <div class="col-md-12 same-heigth">

			<div class="col-md-12 col-lg-12">
			    <div class="form-group">
				<h4 class="example-title">FACTURAR A:</h4>
				<p><?php echo (isset($result['facturacion'])) ? $result['facturacion'] : 'N/D'; ?> </p>
			    </div>
			</div>

		    </div>


		    <div class="col-md-12 same-heigth">
			<div class="col-md-6 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">Forma de Pago:</h4>
				<p><?php echo (isset($result['formaPago'])) ? $result['formaPago'] : 'N/D'; ?> </p>
			    </div>
			</div>
			<div class="col-md-6 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">Método de Pago:</h4>
				<p><?php echo (isset($result['metodoPago'])) ? $result['metodoPago'] : 'N/D'; ?> </p>
			    </div>
			</div>
			<div class="col-md-6 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">Uso de CFDI:</h4>
				<p><?php echo (isset($result['skUsoCFDI'])) ? $result['skUsoCFDI'] : 'N/D'; ?> </p>
			    </div>
			</div>
		    </div>
		     
		    <div class="col-md-12 same-heigth">
			<div class="col-md-2 col-lg-2">
			    <span class="label label-lg label-info">Generales</span>
			</div>
			<div class="col-md-10 col-lg-10">
			    <hr>
			</div>

		    </div>
		    <div class="col-md-12 same-heigth">
			<div class="col-md-6 col-lg-4">
			    <div class="form-group">
				<h4 class="example-title">Fecha Factura:</h4>
				<p><?php echo ($result['dFechaFactura']) ? date('d/m/Y', strtotime($result['dFechaFactura'])) : 'N/D'; ?> </p>
			    </div>
			</div>
			<div class="col-md-12">
					<?php if (isset($result['facturaXML']) && !empty($result['facturaXML'])){ ?>
					<div class="widget col-md-5 col-lg-5">
							<div class="widget-content padding-10 bg-white clearfix">
									<center>
										<a type="button" href="<?php echo (isset($result['facturaXML']) && !empty($result['facturaXML']) ? $result['facturaXML'] : ''); ?>" target="_blank">
												<div class="white" style="cursor: pointer;">
															<i style="font-size: 15px;" class="pull-center icon icon-circle icon-2x icon fa fa-file-pdf-o bg-blue-600" aria-hidden="true"></i>
													</div>
													<h3 class="panel-title text-center">XML</h3>
											</a>
									</center>
							</div>
					</div>
					<div class="col-md-2 col-lg-2">
						&nbsp;
					</div>
				<?php } ?>
				<?php if (isset($result['facturaPDF']) && !empty($result['facturaPDF'])){ ?>
					<div class="widget col-md-5 col-lg-5">
							<div class="widget-content padding-10 bg-white clearfix">
									<center>
											<a type="button" href="<?php echo (isset($result['facturaPDF']) && !empty($result['facturaPDF']) ? $result['facturaPDF'] : ''); ?>" target="_blank" class="ajax-popup-link">
													<div class="white" style="cursor: pointer;">
															<i style="font-size: 15px;" class="pull-center icon icon-circle icon-2x icon fa fa-file-pdf-o bg-blue-600" aria-hidden="true"></i>
													</div>
													<h3 class="panel-title text-center">FACTURA PDF</h3>
											</a>
									</center>
							</div>
					</div>
					<?php } ?>

				</div>
		 
			</div>

		    </div>
		   
		   



		    <div class="col-md-12 page-invoice-table table-responsive font-size-12">
			<table class="table text-right">
			    <thead>
				<tr>
				    <th class="text-center">#</th>
				    <th class="text-left" >Unidad de Medida</th>
				    <th class="text-left" >Servicio</th>
				    <th class="text-right">Cantidad</th>
				    <th class="text-right">P. Unit</th>
				    <th class="text-right">Importe </th>
				    <th class="text-right">Desc </th>
				    <th class="text-right" >Impuestos </th>
				</tr>
			    </thead>
			    <tbody>
				<?php
				$i = 1;
				if (isset($data['comprobantes_servicios'])) {
				    foreach ($data['comprobantes_servicios'] AS $servicios) {
					?>
					<tr>
					    <td style="text-align:center; text-transform: uppercase;" ><?php echo $i; ?></td>
					    <td style="text-align:left; text-transform: uppercase;" ><?php echo $servicios['skUnidadMedida']; ?></td>
					    <td style="text-align:left; text-transform: uppercase;" ><?php echo $servicios['servicio']; ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo number_format($servicios['fCantidad'], 4); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fPrecioUnitario'], 2); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fImporteTotal'], 2); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fDescuento'], 2); ?></td>
					    <td> <?php
						if (isset($servicios['impuestos'])) {
						    foreach ($servicios['impuestos'] AS $impuestos) {
							?>
							<?php echo "(" . $impuestos['impuesto'] . " %" . $impuestos['fTasa'] . ")--$" . number_format($impuestos['fImporte'], 2); ?>

							<?php
						    }//FOREACH
						}
						?>
					    </td>
					</tr>
					<?php
					$i++;
				    }//FOREACH
				}//ENDIF
				?>
			    </tbody>
			</table>
		    </div>
		    <div class="text-right clearfix">
			<div class="pull-right">
			    <p>Subtotal:
				<span><?php echo "$" . number_format($result['fImporteSubtotal'], 2); ?></span>
			    </p>
			    <p>Descuento:
				<span><?php echo "$" . number_format($result['fDescuento'], 2); ?></span>
			    </p>
			    <p>Retenciones:
				<span><?php echo "$" . number_format($result['fImpuestosRetenidos'], 2); ?></span>
			    </p>
			    <p>Traslados:
				<span><?php echo "$" . number_format($result['fImpuestosTrasladados'], 2); ?></span>
			    </p>
			    <p class="page-invoice-amount">Total:
				<span><?php echo "$" . number_format($result['fImporteTotal'], 2); ?></span>
			    </p>
			</div>
		    </div>


		</div>
	    </div>
	</div>
	<div class="col-md-6">
	     
	    <?php
	    if (!empty($data['datosFactura']['iFolioFactura'])) {
		?>
    	    <div class="panel panel-bordered panel-danger panel-line animated slideInRight">
    		<div class="panel-heading">
    		    <h3 class="panel-title">FACTURA</h3>

    		    <div class="alert alert-primary alert-dismissible" role="alert">
    			<b class="red-600 font-size-24"><?php echo (isset($data['datosFactura']['iFolioFactura'])) ? ($data['datosFactura']['iFolioFactura']) : ''; ?></b>
    		    </div>

    		</div>
    		<div class="panel-body container-fluid same-heigth">
    		    <div id="dvProceso">
    			<div class="col-md-12">

    			    <div class="col-md-6 col-lg-6">
    				<div class="form-group">
    				    <h4 class="example-title">Total Factura:</h4>
    				    <p><?php echo (isset($data['datosFactura']['fTotal'])) ? "$" . number_format($data['datosFactura']['fTotal'], 2) : ''; ?></p>
    				</div>
    			    </div>
    			    <div class="col-md-6 col-lg-6">
    				<div class="form-group">
    				    <h4 class="example-title">Fecha Facturacion:</h4>
    				    <p><?php echo ($data['datosFactura']['dFechaFacturacion']) ? date('d/m/Y H:i:s', strtotime($data['datosFactura']['dFechaFacturacion'])) : 'N/D'; ?></p>
    				</div>
    			    </div>

    			</div>
				
				 






    		    </div>

    		</div>

    	    </div>
	    <?php }//ENDIF   ?>
	</div>

	<div class="col-md-6 animated slideInRight">

	
	    

	</div>

	 
	
	 
 

</div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

				$(document).ready(function () {
				    $('#mowi').iziModal('setBackground', '#f1f4f5');
				});

			 

				 

</script>
