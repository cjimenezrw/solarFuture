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
                <ul class="panel-actions panel-actions-keep">
                    <li>
                        <a href="javascript:void(0);" class="btn btn-squared btn-outline btn-primary btn-sm" onclick="formatoPDF();"> Formato Cotizacion</a>
                    </li>
                </ul>
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
                              <h4 class="example-title">CATEGORIA</h4>
                              <p><?php echo (!empty($result['categoria'])) ? $result['categoria'] : '';?></p>
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
						<div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">PROSPECTO:</h4>
                                <p><?php echo (!empty($result['prospecto'])) ? $result['prospecto'] : '';?> </p>
                            </div>
                        </div>
						<div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">COSTO RECIBO:</h4>
                                <p><?php echo (!empty($result['fCostoRecibo'])) ? $result['fCostoRecibo'] : '';?> </p>
                            </div>
                        </div>
                </div>
				<div class="col-md-12 same-heigth">
				
					<div class="col-md-8">
					<div class="form-group">
						<h4 class="example-title">EMAILS:</h4>
						<?php
						$sCorreo = "";
						if (isset($data['cotizacionCorreos'])) {
						 
							foreach ($data['cotizacionCorreos'] AS $correos) {
								if(empty($sCorreo)){
									$sCorreo .= $correos['sCorreo'];
								}else{
									$sCorreo .= ",".$correos['sCorreo'];
								}
							
								}
							}
							?>
						<p><?php echo (isset($sCorreo) && !empty($sCorreo)) ? $sCorreo : 'N/D' ?></p>
					</div>
					</div>
				</div>
				<div class="col-md-12 clearfix"><hr></div>
				<div class="col-md-12 same-heigth">
                  <div class="col-md-12 col-lg-12">
      								<div class="form-group">
      										<h4 class="example-title">CONDICION:</h4>
      										<p><?php echo (!empty($result['sCondicion'])) ? $result['sCondicion'] : 'N/D'; ?> </p>
      								</div>
      						</div>
							  <div class="col-md-12 col-lg-12">
      								<div class="form-group">
      										<h4 class="example-title">RETORNO DE INVERSION:</h4>
      										<p><?php echo (!empty($result['recuperacionInversion'])) ? $result['recuperacionInversion'] : 'N/D'; ?> ANOS </p>
      								</div>
      						</div>


      			</div>
                <div class="col-md-12 clearfix"><hr></div>
                <div class="col-md-12 same-heigth">
                  <div class="col-md-12 col-lg-12">
      								<div class="form-group">
      										<h4 class="example-title">OBSERVACIONES:</h4>
      										<p><?php echo (!empty($result['sObservaciones'])) ? $result['sObservaciones'] : 'N/D'; ?> </p>
      								</div>
      						</div>


      			</div>

            </div>
        </div>
		<?php if(!empty($result['iInformacionPanel'])){ ?>
        <div class="row">
          <!-- First Row -->
          <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-warning">
                  <i class="icon fa-credit-card"></i>
                </button>
                <span class="ml-15 font-weight-400">Gasto Total</span>
                <div class="content-text text-center mb-0">
                  <span class="font-size-20 font-weight-100"><?php echo (!empty($result['gastoAnual'])) ? "$".number_format($result['gastoAnual'],2) : '0';?></span>
                </div>
              </div>
            </div>
          </div>
		  <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-danger">
                  <i class="icon fa-bolt"></i>
                </button>
                <span class="ml-15 font-weight-400">Consumo Total</span>
                <div class="content-text text-center mb-0">
                  <span class="font-size-20 font-weight-100"><?php echo (!empty($result['consumoAnual'])) ? number_format($result['consumoAnual'],2)." Kwh" : '0';?></span>
                </div>
              </div>
            </div>
          </div>
		  <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-success">
                  <i class="icon fa-credit-card"></i>
                </button>
                <span class="ml-15 font-weight-400">Produccion Total</span>
                <div class="content-text text-center mb-0">
                  <span class="font-size-20 font-weight-100"><?php echo (!empty($result['produccionAnual'])) ? number_format($result['produccionAnual'],2)." Kwh" : '0';?></span>
                </div>
              </div>
            </div>
          </div>
		  <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-success">
                  <i class="icon fa-bolt"></i>
                </button>
                <span class="ml-15 font-weight-400">Porcentaje Cubierto</span>
                <div class="content-text text-center mb-0">
                  <span class="font-size-20 font-weight-100"><?php echo (!empty($result['porcentajeAnualCubierto'])) ? number_format($result['porcentajeAnualCubierto'],2)."%" : '0';?></span>
                </div>
              </div>
            </div>
          </div>
          </div>
		  <?php } ?>
         <div class="panel panel-bordered panel-primary panel-line" style="display: block;">
            
            <div class="panel-heading">
			    <h3 class="panel-title">CONCEPTOS</h3>
                <ul class="panel-actions panel-actions-keep">
                    <li>
                        <a href="javascript:void(0);" class="btn btn-squared btn-outline btn-primary btn-sm" onclick="formatoPDF();"> Formato Cotizacion</a>
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
					    <td style="text-align:left; text-transform: uppercase;" >
              <?php echo $conceptos['concepto'].(!empty($conceptos['sDescripcion']) ? " (".$conceptos['sDescripcion'].")" : ''); ?>
              <?php if(!empty($conceptos['venta'])){ ?>
                  <table class="table table-responsive">
                  <tbody>
                  <?php $j=1; foreach ($conceptos['venta'] AS $venta) { ?>

                    <tr>
                    <td><?php echo $j; ?></td>
                    <td  style="text-align:left; " > <?php echo $venta['sNumeroSerie']; ?> </td>
                    </tr>
                    <?php $j++; } ?>
                  </tbody>
                  </table>
                <?php } ?>
              </td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo number_format($conceptos['fCantidad'], 4); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fPrecioUnitario'], 2); ?></td>
					    <td style="text-align:right; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fImporte'], 2); ?></td>
					    
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
				<span><?php echo (!empty($result['fDescuento']) ? "$" . number_format($result['fDescuento'], 2) : "$0.00"); ?></span>
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

    function formatoPDF(){
				    var skCotizacion = '<?php echo $_GET['p1']; ?>';
				    var url = core.SYS_URL + 'sys/vent/coti-deta/detalle-cotizacion/'+skCotizacion+'/?axn=formatoPDF';
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
