<?php
//exit('<pre>'.print_r($data,1).'</pre>');
?>

<div class="row">
<div class="col-md-12" <?php echo (!empty($data['datos']['skEstatus']) && $data['datos']['skEstatus'] == 'CA') ? '' : 'hidden'; ?>>
    <div role="alert" class="alert dark alert-danger alert-icon alert-dismissible animated slideInDown">
        <p class="font-size-20"><b><i class="icon wb-bell" aria-hidden="true"></i> CITA CANCELADA</b></p>
        <p><b><?php echo (!empty($data['datos']['usuarioCancelacion']) ? $data['datos']['usuarioCancelacion'] : ''); ?></b> canceló la cita por la siguiente razón: <b><?php echo (!empty($data['datos']['sObservacionesCancelacion']) ? $data['datos']['sObservacionesCancelacion'] : '-'); ?></b></p>
        <p class="font-size-18"><i class="icon wb-calendar" aria-hidden="true"></i> Fecha de Cancelación: <b><?php echo (!empty($data['datos']['dFechaCancelacion'])) ? $this->obtenerFechaEnLetra($data['datos']['dFechaCancelacion']) : ''; ?></b>, Hora: <b><?php echo (!empty($data['datos']['dFechaCancelacion']) ? date('H:i:s', strtotime($data['datos']['dFechaCancelacion'])) : ''); ?></b></p>
    </div>
</div>


<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered panel-primary panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">DATOS GENERALES</h3>
                </div>
                <?php
                    if(!empty($data['datos']['iFolio'])){
                ?>
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <b class="red-600 font-size-24"><?php echo (!empty($data['datos']['iFolio'])) ? $data['datos']['iFolio'] : '-'; ?></b>
                    <button type="button" class="btn btn-danger pull-right" onclick="formatoPDF();"><i class="icon fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
                </div>
                <?php
                    }//ENDIF
                ?>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger">*</b> CLIENTE:</h4>
                                <span><?php echo (isset($data['datos']['empresaCliente'])) ? $data['datos']['empresaCliente'].' ('.$data['datos']['empresaClienteRFC'].')' : ''; ?></span>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title"><span class="required text-danger">*</span> NOMBRE CLIENTE:</h4>
                                <span><?php echo (isset($data['datos']['sNombreCliente'])) ? $data['datos']['sNombreCliente'] : ''; ?></span>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">ASUNTO:</h4>
                                <span><?php echo (isset($data['datos']['sAsunto'])) ? $data['datos']['sAsunto'] : ''; ?></span>
                            </div>
                        </div>
                        
                        <div class="row row-lg col-lg-12 clearfix"><hr></div>

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger"></b>TELÉFONO:</h4>
                                <span><?php echo (isset($data['datos']['sTelefono'])) ? $data['datos']['sTelefono'] : ''; ?></span>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title"><b class="text-danger"></b>DOMICILIO:</h4>
                                <span><?php echo (isset($data['datos']['sDomicilio'])) ? $data['datos']['sDomicilio'] : ''; ?></span>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <h4 class="example-title">CORREOS:</h4>
                                <span><?php echo !empty($data['citas_correos']) ? implode(', ',array_column($data['citas_correos'],'sCorreo')) : ''; ?></span>
                            </div>
                        </div>

                        <div class="row row-lg col-lg-12 clearfix"><hr></div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>ESTADO:</h4>
                                <span><?php echo $data['datos']['estado']; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>MUNICIPIO:</h4>
                                <span><?php echo $data['datos']['municipio']; ?></span>
                            </div>
                        </div>

                        <div class="row row-lg col-lg-12 clearfix"><hr></div>
                        
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>CATEGORÍA:</h4>
                                <span><?php echo $data['datos']['sNombreCategoria']; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>FECHA DE CITA:</h4>
                                <span><?php echo (!empty($data['datos']['dFechaCita']) ? date('d/m/Y', strtotime($data['datos']['dFechaCita'])) : ''); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <h4 class="example-title"><span style="color:red;">* </span>HORA:</h4>
                                <span><?php echo $data['datos']['tHoraInicio']; ?></span>
                            </div>
                        </div>

                        <div class="row row-lg col-lg-12 clearfix"><hr></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">OBSERVACIONES:</h4>
                                <span><?php echo isset($data['datos']['sObservaciones']) ? $data['datos']['sObservaciones'] : ''; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 clearfix"></div>
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">PERSONAL ASIGNADO:</h4>
                                <span><?php echo !empty($data['citas_personal']) ? implode(', ',array_column($data['citas_personal'],'nombre')) : ''; ?></span>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 clearfix"></div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <h4 class="example-title">INSTRUCCIONES DE SERVICIO:</h4>
                                <span><?php echo isset($data['datos']['sInstruccionesServicio']) ? $data['datos']['sInstruccionesServicio'] : ''; ?></span>
                            </div>
                        </div>
                    
                    </div>

                </div>
            </div>

            <div class="panel panel-bordered panel-dark panel-line">
              <div class="panel-heading">
                  <h3 class="panel-title">DATOS DE FACTURACIÓN</h3>
                  <ul class="panel-actions panel-actions-keep">
                      <li >
                          <h4 class="example-title">NO FACTURABLE:</h4>
                          <input type="checkbox" class="js-switch-large" data-plugin="switchery" data-color="#4d94ff" 
                          <?php echo !empty($data['datos']['iNoFacturable']) ? 'checked disabled' : 'disabled'; ?>
                          name="iNoFacturable" id="iNoFacturable" value="1"/>
                      </li>
                      
                  </ul>
              </div>
              <div class="panel-body container-fluid">
                <div class="row row-lg col-lg-12">
                    
                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> CLIENTE:</h4>
                        <span><?php echo $data['datos']['empresaCliente'] . ' (' . $data['datos']['empresaClienteRFC'] . ')'; ?></span>
                      </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                        <h4 class="example-title">EMPRESA A FACTURAR:</h4>
                        <span><?php echo (!empty($data['datos']['empresaFacturacion']) ? $data['datos']['empresaFacturacion'] . ' (' . $data['datos']['empresaFacturacionRFC'] . ')' : '-'); ?></span>
                      </div>
                    </div>

                <div class="row row-lg col-lg-12 clearfix"><hr></div>

                    <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">MÉTODO DE PAGO</h4>
                        <span><?php echo (!empty($data['datos']['skMetodoPago']) ? '('.$data['datos']['skMetodoPago'].') '.$data['datos']['metodoPago'] : '-'); ?></span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">FORMA DE PAGO</h4>
                        <span><?php echo (!empty($data['datos']['skFormaPago']) ? '('.$data['datos']['skFormaPago'].') '.$data['datos']['formaPago'] : '-'); ?></span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">USO DE CFDI</h4>
                        <span><?php echo (!empty($data['datos']['skUsoCFDI']) ? '('.$data['datos']['skUsoCFDI'].') '.$data['datos']['usoCFDI'] : '-'); ?></span>
                    </div>
                </div>




                </div>
              </div>
            </div>


                        <!-- COMIENZA SERVICIOS !-->
                        <div class="panel panel-bordered panel-success panel-line">
    <div class="panel-heading">
        <div class="panel-actions"></div>
        <h3 class="panel-title">PRODUCTO / SERVICIO</h3>
    </div>
    <div class="panel-body container-fluid">

        <div class="table-responsive clearfix" id="servicios" style="overflow-y:visible;font-size: 10pt;">
            
            <table class="table table-striped table-bordered" id="servicios">
                <thead>
                    <tr>
                        <th class="col-md-1 text-center" nowrap style="text-transform: uppercase;">#</th>
                        <th class="col-md-1 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> UNIDAD</th>
                        <th class="col-md-2  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> PRODUCTO / SERVICIO</th>
                        <th class="col-md-1 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> CANTIDAD</th>
                        <th class="col-md-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> P. UNITARIO</th>
                        <th class="col-md-1  text-center" style="text-transform: uppercase;">IVA</th>
                        <th class="col-md-1  text-center" style="text-transform: uppercase;">RET IVA</th>
                        <th class="col-md-1  text-center" style="text-transform: uppercase;">IMPORTE</th>
                        <th class="col-md-1  text-center" style="text-transform: uppercase;">DESCUENTO</th>
                    </tr>
                </thead>
                <tbody class="searchable" id="servicios-body">
                        <?php
                        if (isset($data['serviciosCita'])){
                            $cont = 1;
                            foreach ($data['serviciosCita'] AS $row){ ?>
                            <tr <?php echo (!empty($row['TRAIVA']) ? "TRAIVA = '".$row['TRAIVA']."' " : ''); ?> <?php echo (!empty($row['RETIVA']) ? "RETIVA = '".$row['RETIVA']."' " : ''); ?>>
                                <td><?php echo $cont; ?></td>
                                <td><?php echo (isset($row['unidadMedida']) ? $row['unidadMedida'] : ''); ?></td>
                                <td><?php echo (!empty($row['sDescripcion']) ? $row['sDescripcion'] : $row['servicio']); ?></td>
                                <td><?php echo (isset($row['fCantidad']) ? number_format($row['fCantidad'],2) : '0.00');?></td>
                                <td>$<?php echo (isset($row['fPrecioUnitario']) ? number_format($row['fPrecioUnitario'],2) : '0.00');?></td>
                                <td>$<?php echo (isset($row['fImpuestosTrasladados']) ? number_format($row['fImpuestosTrasladados'],2) : '0.00');?></td>
                                <td>$<?php echo (isset($row['fImpuestosRetenidos']) ? number_format($row['fImpuestosRetenidos'],2) : '0.00');?></td>
                                <td>$<?php echo (isset($row['fImporte']) ? number_format($row['fImporte'],2) : '0.00');?></td>
                                <td>$<?php echo (isset($row['fDescuento']) ? number_format($row['fDescuento'],2) : '0.00');?></td>
                            </tr>
                        <?php 
                              $cont++; 
                            }//ENDFOREACH
                          }//ENDIF 
                        ?>
                </tbody>
            </table>
        </div>

        <div class="text-right clearfix">
			<div class="pull-right">
			    <p>SUBTOTAL:
        <span>$<?php echo (!empty($data['datos']['fImporteSubtotal']) ? number_format($data['datos']['fImporteSubtotal'],2) : '0.00'); ?></span>
			    </p>
			    <p>DESCUENTO:
        <span>$<?php echo (!empty($data['datos']['fDescuento']) ? number_format($data['datos']['fDescuento'],2) : '0.00'); ?></span>
			    </p>
			    <p>IVA:
				<span>$<?php echo (!empty($data['datos']['fImpuestosTrasladados']) ? number_format($data['datos']['fImpuestosTrasladados'],2) : '0.00'); ?></span>
			    </p>
          <p>RET IVA:
				<span>$<?php echo (!empty($data['datos']['fImpuestosRetenidos']) ? number_format($data['datos']['fImpuestosRetenidos'],2) : '0.00'); ?></span>
			    </p>
                <p class="page-invoice-amount"><b>TOTAL SIN IVA:</b>
                <span class="red-600 font-weight-bold">$<?php echo (!empty($data['datos']['fImporteTotalSinIVA']) ? number_format($data['datos']['fImporteTotalSinIVA'],2) : '0.00'); ?></span>
			    </p>
			    <p class="page-invoice-amount"><b>TOTAL IVA INCLUIDO:</b>
        <span class="red-600 font-weight-bold">$<?php echo (!empty($data['datos']['fImporteTotal']) ? number_format($data['datos']['fImporteTotal'],2) : '0.00'); ?></span>
			    </p>
			</div>
        </div>


    </div>

            <!-- TERMINA SERVICIOS !-->


    </div>

    </div>



<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    function formatoPDF(){
        var skCita = '<?php echo $_GET['p1']; ?>';
        var url = core.SYS_URL + 'sys/cita/cita-deta/detalles-cita/'+skCita+'/?axn=formatoPDF';
        $.magnificPopup.open({
        items: {
            src: url
        },
        type: 'iframe'
        });
    }
    
    $(document).ready(function () {
        $('[data-plugin="switchery"]').each(function () {
            new Switchery(this, {
                color: $(this).data('color'),
                size: $(this).data('size')
            });
        });
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    });

    function searchFilter() {
        var rex = new RegExp($("#inputFilter").val(), 'i');
        $('.searchable tr').hide();
        $('.searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();
    }
</script>