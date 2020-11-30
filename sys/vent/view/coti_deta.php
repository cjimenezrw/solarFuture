<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];

    utf8($result);
}

?>

<div class="row">

        <div class="panel panel-bordered panel-primary panel-line" style="display: block;">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS GENERALES</h3>
            </div>

            <div class="panel-body container-fluid"  >
                <div class="col-md-12 same-heigth">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">MONEDA :</h4>
                            <p><?php echo (!empty($result['skDivisa'])) ? $result['skDivisa'] : '';?> </p>
                        </div>
                    </div>
                    
                      <div class="col-md-4 col-lg-4">
                          <div class="form-group">
                              <h4 class="example-title">VIGENCIA</h4>
                              <p><?php echo (!empty($result['dFechaVigencia'])) ? date('d/m/Y', strtotime($result['dFechaVigencia'])) : ''; ?></p>
                          </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">CLIENTE:</h4>
                                <p><?php echo (!empty($result['cliente'])) ? $result['cliente'] : '';?> </p>
                            </div>
                        </div>
                </div>
                <div class="col-md-12 clearfix"><hr></div>
                <div class="col-md-12 same-heigth">
                  <div class="col-md-12 col-lg-8">
      								<div class="form-group">
      										<h4 class="example-title">OBSERVACIONES:</h4>
      										<p><?php echo (!empty($result['sObservaciones'])) ? $result['sObservaciones'] : 'N/D'; ?> </p>
      								</div>
      						</div>


      			</div>

            </div>
        </div>
        
         <div class="panel panel-bordered panel-primary panel-line" style="display: block;">
            
            <div class="panel-heading">
			    <h3 class="panel-title">CONCEPTOS</h3>
                <ul class="panel-actions panel-actions-keep">
                    <li>
                        <a href="javascript:void(0);" class="btn btn-squared btn-outline btn-primary btn-sm" onclick="verFormato();"> Formato Cotizacion</a>
                    </li>
                </ul>

			</div>

            <div class="panel-body container-fluid">
            <div class="col-md-12 page-invoice-table table-responsive font-size-12">
			<table class="table text-right">
			    <thead>
				<tr>
				    <th class="text-center">#</th>
				    <th class="text-left" >Unidad de Medida</th>
				    <th class="text-left" >Concepto</th>
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
				if (isset($data['conceptosCotizacion'])) {
				    foreach ($data['conceptosCotizacion'] AS $conceptos) {
					?>
					<tr>
					    <td style="text-align:center; text-transform: uppercase;" ><?php echo $i; ?></td>
					    <td style="text-align:left; text-transform: uppercase;" ><?php echo $conceptos['tipoMedida']; ?></td>
					    <td style="text-align:left; text-transform: uppercase;" ><?php echo $conceptos['concepto']; ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo number_format($conceptos['fCantidad'], 4); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fPrecioUnitario'], 2); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fImporte'], 2); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fDescuento'], 2); ?></td>
					    <td> <?php
						if (isset($conceptos['impuestos'])) {
						    foreach ($conceptos['impuestos'] AS $impuestos) {
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

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    function verFormato() {
				    var skCotizacion = '<?php echo $_GET['skCotizacion'] ?>';
				    var url = core.SYS_URL + 'sys/vent/coti-deta/detalle-cotizacion/?axn=formatoPDF&skCotizacion=' + skCotizacion;
				    $.magnificPopup.open({
					items: {
					    src: url
					},
					type: 'iframe'
				    });
				}
    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    });

</script>
