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
                <?php
                    if(!empty($data['datos']['iFolio'])){
                ?>
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <b class="red-600 font-size-24"><?php echo (!empty($data['datos']['iFolio'])) ? $data['datos']['iFolio'] : '-'; ?></b>
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
        </div>
    </div>

    <!-- COMEINZA DATOS DE FACTURACIÓN !-->
    
    <div class="panel panel-bordered panel-dark panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS DE FACTURACIÓN</h3>
            <ul class="panel-actions panel-actions-keep">
                <li >
                    <h4 class="example-title">NO FACTURABLE:</h4>
                    <input type="checkbox" class="js-switch-large" data-plugin="switchery" data-color="#4d94ff" 
                    <?php echo !empty($data['datos']['iNoFacturable']) ? 'checked' : ''; ?>
                    name="iNoFacturable" id="iNoFacturable" value="1"/>
                </li>

            </ul>
        </div>
        <div class="panel-body container-fluid">
            <div class="row row-lg col-lg-12">

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><b class="text-danger">*</b> CLIENTE:</h4>
                        <select name="skEmpresaSocioCliente" id="skEmpresaSocioCliente" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                            <?php
                            if (!empty($data['datos']['skEmpresaSocioCliente'])) {
                                ?>
                                <option value="<?php echo $data['datos']['skEmpresaSocioCliente']; ?>" selected="selected"><?php echo $data['datos']['empresaCliente'] . ' (' . $data['datos']['empresaClienteRFC'] . ')'; ?></option>
                                <?php
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">EMPRESA A FACTURAR:</h4>
                        <select name="skEmpresaSocioFacturacion" id="skEmpresaSocioFacturacion" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                            <?php
                            if (!empty($data['datos']['skEmpresaSocioFacturacion'])) {
                                ?>
                                <option value="<?php echo $data['datos']['skEmpresaSocioFacturacion']; ?>" selected="selected"><?php echo $data['datos']['empresaFacturacion'] . ' (' . $data['datos']['empresaFacturacionRFC'] . ')'; ?></option>
                                <?php
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row row-lg col-lg-12 clearfix"><hr></div>

                  <div class="col-md-4 col-lg-4">
                         <div class="form-group">
                             <h4 class="example-title"><span class="required text-danger">*</span> DIVISA:</h4>
                             <select id="skDivisa"  name="skDivisa" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">- SELECCIONAR -</option>
                                 <?php
                                 if ($data['divisas']) {
                                 foreach (  $data['divisas'] as $row) {
                                     utf8($row);
                                     ?>
                                     <option <?php echo(isset($data['datos']['skDivisa']) && $data['datos']['skDivisa'] == $row['skDivisa'] ? 'selected="selected"' : (!isset($data['datos']['skDivisa']) && $row['skDivisa'] == 'MXN' ? 'selected="selected"' : '')); ?>
                                         value="<?php echo $row['skDivisa']; ?>"> <?php echo $row['sNombre'].' ('.$row['skDivisa'].')'; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                     </div>

                     <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>TIPO DE CAMBIO:</h4>
                            <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="fTipoCambio" value="<?php echo (isset($data['fTipoCambio'])) ? $data['fTipoCambio'] : $data['fTipoCambio']; ?>" placeholder="TIPO DE CAMBIO" autocomplete="off" type="text">
                        </div>
                    </div>

                     <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                             <h4 class="example-title"><span class="required text-danger">*</span> CATEGORÍA DE PRECIO:</h4>
                             <select id="skCategoriaPrecio"  name="skCategoriaPrecio" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">- SELECCIONAR -</option>
                                 <?php
                                 if ($data['categoria']) {
                                 foreach (  $data['categoria'] as $row) {
                                     utf8($row);
                                     ?>
                                     <option <?php echo(isset($data['datos']['skCategoriaPrecio']) && $data['datos']['skCategoriaPrecio'] == $row['skCategoriaPrecio'] ? 'selected="selected"' : ''); ?>
                                         value="<?php echo $row['skCategoriaPrecio']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                   </div>

                <div class="row row-lg col-lg-12 clearfix"><hr></div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">MÉTODO DE PAGO</h4>
                        <select name="skMetodoPago" id="skMetodoPago"  class="form-control" data-plugin="select2" select2Simple>
                            <option value="">Seleccionar</option>
                            <?php
                            if ($data['metodoPago']) {
                                foreach ($data['metodoPago'] as $row) {
                                    utf8($row);
                                    ?>
                                    <option <?php echo(isset($data['datos']['skMetodoPago']) && $data['datos']['skMetodoPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                }//ENDWHILE
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">FORMA DE PAGO</h4>
                        <select name="skFormaPago" id="skFormaPago"  class="form-control" data-plugin="select2" select2Simple>
                            <option value="">Seleccionar</option>
                            <?php
                            if ($data['formaPago']) {
                                foreach ($data['formaPago'] as $row) {
                                    utf8($row);
                                    ?>
                                    <option <?php echo(isset($data['datos']['skFormaPago']) && $data['datos']['skFormaPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                }//ENDWHILE
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title">USO DE CFDI</h4>
                        <select name="skUsoCFDI" id="skUsoCFDI"  class="form-control" data-plugin="select2" select2Simple>
                            <option value="">Seleccionar</option>
                            <?php
                            if ($data['usoCFDI']) {
                                foreach ($data['usoCFDI'] as $row) {
                                    utf8($row);
                                    ?>
                                    <option <?php echo(isset($data['datos']['skUsoCFDI']) && $data['datos']['skUsoCFDI'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                }//ENDWHILE
                            }//ENDIF
                            ?>
                        </select>
                    </div>
                </div>




            </div>
        </div>
    </div>

    <!-- TERMINA DATOS DE FACTURACIÓN !-->

    <!-- COMIENZA WIDGET DE SERVICIOS !-->

    <div class="panel panel-bordered panel-success panel-line">
    <div class="panel-heading">
        <div class="panel-actions">
            <button type="button" class="btn btn-outline btn-success pull-right" id="concepto-agregar">
                <i class="icon wb-plus" aria-hidden="true"></i> AGREGAR
            </button>
        </div>
        <h3 class="panel-title">PRODUCTO / SERVICIO</h3>
    </div>
    <div class="panel-body container-fluid">

        <div class="table-responsive clearfix" id="servicios" style="overflow-y:visible;font-size: 10pt;">
            <div class="col-md-12">
                <div class="col-md-1 col-lg-1">
                    <div class="form-group">
                        <h4 class="example-title">DESCUENTO</h4>
                     </div>
                 </div>
                 <div class="col-md-1">
                         <div class="radio-custom radio-primary ">
                            <input type="radio" class="descuento" id="inputPorcentaje" name="descuento" value="porc" />
                            <label for="inputPorcentaje">PROCENTAJE</label>
                          </div>
                </div>
                <div class="col-md-1">
                        <div class="radio-custom radio-primary ">
                           <input type="radio" class="descuento" id="inputCantidad" name="descuento" value="cant" />
                           <label for="inputCantidad">CANTIDAD</label>
                         </div>
               </div>
               <div class="col-md-1">
               <input type="text" name="descuentoAplicar" id="descuentoAplicar" class="form-control " >
                </div>
               <label onclick="aplicarDescuento();" class="col-md-1 btn btn-outline btn-success">APLICAR</label>

            </div>
            <table class="table table-striped table-bordered" id="servicios">
                <thead>
                    <tr>
                        <th class="text-center" nowrap style="text-transform: uppercase;">SE</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> UNIDAD</th>
                        <th class=" col-xs-2  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> PRODUCTO / SERVICIO</th>
                        <th class="col-xs-4 text-center" style="text-transform: uppercase;">DESCRIPCIÓN</th>
                        <th class="col-xs-1 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> CANTIDAD</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> P. UNITARIO</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">IVA</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">RET IVA</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">IMPORTE</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">DESCUENTO</th>
                        <th class="col-xs-1 col-md-1 text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="searchable" id="servicios-body">

                        <?php
                        if (isset($data['serviciosCita'])){
                            $cont = 1;
                            //echo('<pre>'.print_r($data['serviciosCita'],1).'</pre>');
                            foreach ($data['serviciosCita'] as $row){ ?>


                            <tr <?php echo (!empty($row['TRAIVA']) ? "TRAIVA = '".$row['TRAIVA']."' " : ''); ?> <?php echo (!empty($row['RETIVA']) ? "RETIVA = '".$row['RETIVA']."' " : ''); ?>>
                                <td>
                                    <div class="radio-custom radio-primary ">
                                       <input type="radio" class="descuentoConcepto" id="inputchk<?php echo $cont; ?>" name="chk" value="<?php echo $cont; ?>" />
                                       <label for="inputchk<?php echo $cont; ?>">&nbsp;</label></div>
                                </td>
                                <td>
                                    <select name="servicios[<?php echo $cont; ?>][skUnidadMedida]" class="skUnidadMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skUnidadMedida']) ? $row['skUnidadMedida'] : ''); ?>"><?php echo (isset($row['unidadMedida']) ? $row['unidadMedida'] : ''); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <select name="servicios[<?php echo $cont; ?>][skServicio]" onchange="datosConcepto(this);" class="skServicio form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skServicio']) ? $row['skServicio'] : ''); ?>"><?php echo (isset($row['servicio']) ? $row['servicio'] : ''); ?></option>
                                    </select>
                                <td><input class="form-control" value="<?php echo $row['sDescripcion'];?>" name="servicios[<?php echo $cont; ?>][sDescripcionConcepto]" placeholder="Descripcion" autocomplete="off" type="text"></td>
                                <td><input class="form-control" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo (isset($row['fCantidad']) ? number_format($row['fCantidad'],4) : '');?>"  onchange="actualizarImporte(this);" name="servicios[<?php echo $cont; ?>][fCantidad]" placeholder="Cantidad" autocomplete="off" type="text"></td>
                                <td><input class="form-control" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo  (isset($row['fPrecioUnitario']) ? number_format($row['fPrecioUnitario'],2) : '');?>"  onchange="actualizarImporte(this);" name="servicios[<?php echo $cont; ?>][fPrecioUnitario]" placeholder="P. Unitario" autocomplete="off" type="text"></td>
                                <td><input class="form-control" value="<?php echo $row['fImpuestosTrasladados'];?>" name="servicios[<?php echo $cont; ?>][fImpuestosTrasladados]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImpuestosTrasladados']) ? number_format($row['fImpuestosTrasladados'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fImpuestosRetenidos'];?>" name="servicios[<?php echo $cont; ?>][fImpuestosRetenidos]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImpuestosRetenidos']) ? number_format($row['fImpuestosRetenidos'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fImporte'];?>" name="servicios[<?php echo $cont; ?>][fImporte]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImporte']) ? number_format($row['fImporte'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fDescuento'];?>" name="servicios[<?php echo $cont; ?>][fDescuento]"  type="hidden"><label class="text-center" id="descuentoConcepto<?php echo $cont; ?>" > <?php echo (isset($row['fDescuento']) ? number_format($row['fDescuento'],2) : ''); ?> </label>  </td>
                                <td><button type="button" class="btn btn-outline btn-danger pull-right concepto-eliminar" onclick="eliminarConcepto(this);"><i class="icon wb-trash" aria-hidden="true"></i> Eliminar</button></td>
                            </tr>
                            <?php $cont++; }
                        } ?>




                </tbody>
            </table>


        </div>
        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Subtotal</label>
              <label  disabled class="form-control input-sm" id="dinSubtotal"  > <?php echo (!empty($data['datos']['fImporteSubtotal'])) ? number_format($data['datos']['fImporteSubtotal'],2) : ''; ?></label>
              <input type="hidden"  id="inSubtotal" name="fImporteSubtotal"  value="<?php echo (isset($data['datos']['fImporteSubtotal'])) ? $data['datos']['fImporteSubtotal'] : ''; ?>" />
            </div>
        </div>
        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Descuento</label>
              <label type="text" disabled class="form-control input-sm" id="dinDescuento"><?php echo (!empty($data['datos']['fDescuento'])) ? number_format($data['datos']['fDescuento'],2) : ''; ?> </label>
              <input type="hidden"  id="inDescuento" name="fDescuento" value="<?php echo (isset($data['datos']['fDescuento'])) ? $data['datos']['fDescuento'] : ''; ?>"  />
            </div>
        </div>
        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Traslados</label>
              <label type="text" disabled class="form-control input-sm" id="dinImpuestoTrasladado"><?php echo (!empty($data['datos']['fImpuestosTrasladados'])) ? number_format($data['datos']['fImpuestosTrasladados'],2) : ''; ?></label>
              <input type="hidden"  id="inImpuestoTrasladado" name="fImpuestosTrasladados" value="<?php echo (isset($data['datos']['fImpuestosTrasladados'])) ? $data['datos']['fImpuestosTrasladados'] : ''; ?>"  />
            </div>
        </div>
        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Retenciones</label>
              <label type="text" disabled class="form-control input-sm" id="dinImpuestoRetenido"><?php echo (!empty($data['datos']['fImpuestosRetenidos']) ? number_format($data['datos']['fImpuestosRetenidos'],2) : '0.00'); ?></label>
              <input type="hidden"  id="inImpuestoRetenido" name="fImpuestosRetenidos"  value="<?php echo (isset($data['datos']['fImpuestosRetenidos'])) ? $data['datos']['fImpuestosRetenidos'] : ''; ?>"   />
            </div>
        </div>

        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Total</label>
              <label type="text" disabled class="form-control input-sm" id="dinTotal"><?php echo (!empty($data['datos']['fImporteTotal'])) ? number_format($data['datos']['fImporteTotal'],2) : ''; ?></label>
              <input type="hidden"  id="inTotal" name="fImporteTotal" value="<?php echo (isset($data['datos']['fImporteTotal'])) ? $data['datos']['fImporteTotal'] : ''; ?>"  />
            </div>
        </div>
    </div>
</div>

<!-- TERMINA WIDGET DE SERVICIOS !-->

</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">

    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validaciones;

    function filterFloat(evt, input) {
        // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempValue = input.value + chark;
        //console.log(evt.type);
        if (key >= 48 && key <= 57) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            if (key == 8 || key == 13 || key == 46 || key == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,4})$/;
        if (preg.test(__val__) === true) {
            return true;
        } else {
            return false;
        }
    }


    function addCommas(amount) {
        decimals = 2;
        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0){
            return parseFloat(0).toFixed(decimals);
        }

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.');
        var regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0])){
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
        }

        return amount_parts.join('.');
    }


    function aplicarDescuento() {
        var tipo = $(".descuento:checked").val();
        var descuentoAplicar = $("#descuentoAplicar").val();
        var cont = $(".descuentoConcepto:checked").val();
        var importe = $('input[name="servicios[' + cont + '][fImporte]"]').val();

        if (tipo == 'porc') {
            descuento = ((descuentoAplicar * importe) / 100);
            $('input[name="servicios[' + cont + '][fDescuento]"]').val(descuento);
            $('#descuentoConcepto' + cont).html(parseFloat(descuento));
        }
        if (tipo == 'cant') {
            descuento = descuentoAplicar;
            $('input[name="servicios[' + cont + '][fDescuento]"]').val(descuento);
            $('#descuentoConcepto' + cont).html(parseFloat(descuento));

        }
        var obj = $('input[name="servicios[' + cont + '][fImporte]"]');
        actualizarImporte(obj);
    }

    function datosConcepto(obj) {

        var skServicio = $(obj).closest('tr').find('td').eq(2).find('select').val();
        var tr = $(obj).parent().parent();
        $(tr).removeAttr("traiva");
        $(tr).removeAttr("retiva");
        if (skServicio) {

            $.post(window.location.href, {
                    axn: 'get_servicio_impuestos',
                    skServicio: skServicio
                },
                function(data) {
                    //if (element.nodeType === ELEMENT_NODE) {
                    // return jqLite(element);
                    // }

                    //console.log(data);
                    if (data) {
                        $.each(data, function(k, v) {
                            $(tr).attr(v.skImpuesto, v.sValor);
                        });
                    }
                });
        }
        actualizarImporte(obj);
        $(obj).closest('tr').find('td').eq(4).find('input').removeAttr("disabled");
        $(obj).closest('tr').find('td').eq(5).find('input').removeAttr("disabled");


    }

    var tr_concepto = '';


    $(document).ready(function () {
        
        $('#core-guardar').formValidation(core.formValidaciones);

        $('[data-plugin="switchery"]').each(function () {
            new Switchery(this, {
                color: $(this).data('color'),
                size: $(this).data('size')
            });
        });

        $('.help-text').webuiPopover();

        core.autocomplete2('#skEmpresaSocioCliente', 'get_empresas', window.location.href, 'CLIENTE');
        core.autocomplete2('#skEmpresaSocioFacturacion', 'get_empresas', window.location.href, 'EMPRESA A FACTURAR');
        $("#skMetodoPago").select2({placeholder: "MÉTODO DE PAGO", allowClear: true});
        $("#skFormaPago").select2({placeholder: "FORMA DE PAGO", allowClear: true});
        $("#skUsoCFDI").select2({placeholder: "USO DE CFDI", allowClear: true});

        $("#skDivisa").select2({placeholder: "DIVISA", allowClear: true });
        $("#skCategoriaPrecio").select2({placeholder: "CATEGORÍA DE PRECIO", allowClear: true });

        $("#skCategoriaCita").select2({placeholder: "CATEGORIA", allowClear: true });
        $("#skEstadoMX").select2({placeholder: "ESTADO", allowClear: true });
        $("#skMunicipioMX").select2({placeholder: "MUNICIPIO", allowClear: true });

        $('#sCorreos').tagsinput({
            trimValue: true,
            freeInput: true,
            tagClass: 'label label-primary'
        });

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

        /* COMIENZA WIDGET DE SERVICIOS */

        eliminarConcepto = function (obj) {
            var tr = $(obj).parent().parent();
            $(tr).remove();
            actualizarSubtotal();
        };

        actualizarImporte = function(obj) {

            var tr = $(obj).parent().parent();
            var importe = 0;
            var fImpuestoTrasladado = 0;
            var fImpuestoRetenido = 0;
            var traiva = 0;
            var retiva = 0;

            var cantidad = $(obj).closest('tr').find('td').eq(4).find('input').val().replace(',', '');
            var precioUnitario = $(obj).closest('tr').find('td').eq(5).find('input').val().replace(',', '');
            var descuento = $(obj).closest('tr').find('td').eq(9).find('input').val().replace(',', '');
            var traiva = $(tr).attr('traiva');
            var retiva = $(tr).attr('retiva');

            if (cantidad != '' && precioUnitario != '') {
                importe = (cantidad * precioUnitario);
                $(obj).closest('tr').find('td').eq(8).find('input').val(importe);
                $(obj).closest('tr').find('td').eq(8).find('label').html(addCommas(importe));

                if (typeof traiva !== typeof undefined && traiva !== false) {

                    fImpuestoTrasladado = ((importe - descuento) * traiva / 100);
                    fImpuestoTrasladado = Math.round(fImpuestoTrasladado * 100) / 100;
                }

                $(obj).closest('tr').find('td').eq(6).find('input').val(fImpuestoTrasladado);
                $(obj).closest('tr').find('td').eq(6).find('label').html(addCommas(fImpuestoTrasladado));
                if (typeof retiva !== typeof undefined && retiva !== false) {
                    fImpuestoRetenido = ((importe) * retiva / 100);
                    fImpuestoRetenido = Math.round(fImpuestoRetenido * 100) / 100;
                }
                $(obj).closest('tr').find('td').eq(7).find('input').val(fImpuestoRetenido);
                $(obj).closest('tr').find('td').eq(7).find('label').html(addCommas(fImpuestoRetenido));

                actualizarSubtotal();
            }
            };

            actualizarSubtotal = function() {
            var subtotal = 0;
            $("#servicios tbody tr").each(function(index) {
                //subtotal += parseFloat($(this).closest('tr').find('td').eq(8).find('input').val());
                subtotal += Math.round(parseFloat($(this).closest('tr').find('td').eq(8).find('input').val()) * 100) / 100;

            });

            $("#inSubtotal").val(parseFloat(subtotal));
            $("#dinSubtotal").html(addCommas(subtotal));
            impuestos();
            };
            impuestos = function() {
            var impuestosTrasladados = 0;
            var impuestosRetenciones = 0;
            var descuento = 0;

            $("#servicios tbody tr").each(function(index) {
                if ($(this).closest('tr').find('td').eq(6).find('input').val()) {
                    //impuestosTrasladados += parseFloat($(this).closest('tr').find('td').eq(6).find('input').val());
                    impuestosTrasladados += Math.round(parseFloat($(this).closest('tr').find('td').eq(6).find('input').val()) * 100) / 100;

                }
            });
            $("#inImpuestoTrasladado").val(parseFloat(impuestosTrasladados));
            $("#dinImpuestoTrasladado").html(addCommas(impuestosTrasladados));

            $("#servicios tbody tr").each(function(index) {
                if ($(this).closest('tr').find('td').eq(7).find('input').val()) {
                    //impuestosRetenciones += parseFloat($(this).closest('tr').find('td').eq(7).find('input').val());
                    impuestosRetenciones += Math.round(parseFloat($(this).closest('tr').find('td').eq(7).find('input').val()) * 100) / 100;

                }
            });
            $("#inImpuestoRetenido").val(parseFloat(impuestosRetenciones));
            $("#dinImpuestoRetenido").html(addCommas(impuestosRetenciones));

            $("#servicios tbody tr").each(function(index) {
                if ($(this).closest('tr').find('td').eq(9).find('input').val()) {
                    descuento += parseFloat($(this).closest('tr').find('td').eq(9).find('input').val());
                }
            });
            $("#inDescuento").val(parseFloat(descuento));
            $("#dinDescuento").html(addCommas(descuento));

            actualizartotal();
            };
            actualizartotal = function() {
            var total = 0;
            var subtotal = ($("#inSubtotal").val() != '' ? parseFloat($("#inSubtotal").val().replace(',', '')) : 0);
            var impuestoTrasladado = ($("#inImpuestoTrasladado").val() != '' ? parseFloat($("#inImpuestoTrasladado").val().replace(',', '')) : 0);
            var impuestoRetenido = ($("#inImpuestoRetenido").val() != '' ? parseFloat($("#inImpuestoRetenido").val().replace(',', '')) : 0);
            var descuento = ($("#inDescuento").val() != '' ? parseFloat($("#inDescuento").val().replace(',', '')) : 0);
            total = ((subtotal + impuestoTrasladado - impuestoRetenido) - descuento);

            $("#inTotal").val(parseFloat(total));
            $("#dinTotal").html(addCommas(total));

            //actualizartotal();
            };

            var cont = <?php echo isset($data['serviciosCita'])? count($data['serviciosCita']):'0'; ?>;
            $("#concepto-agregar").click(function(event){
                cont++;
                tr_concepto=   '<tr>'+

                '<td><div class="radio-custom radio-primary ">'+
                    '<input type="radio" class="descuentoConcepto" id="inputchk' + cont + '" name="chk" value="' + cont + '" />'+
                    '<label for="inputchk' + cont + '">&nbsp;</label></div></td>'+
                '<td><select name="servicios[' + cont + '][skUnidadMedida]" class="skUnidadMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                '<td><select name="servicios[' + cont + '][skServicio]" onchange="datosConcepto(this);" class="skServicio form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                '<td><input class="form-control" name="servicios[' + cont + '][sDescripcionConcepto]" placeholder="Descripcion" autocomplete="off" type="text"></td>'+
                '<td fCantidad ><input class="form-control" disabled name="servicios[' + cont + '][fCantidad]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="Cantidad" autocomplete="off" type="text"></td>'+
                '<td fPrecioUnitario ><input class="form-control" disabled name="servicios[' + cont + '][fPrecioUnitario]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="P. Unitario" autocomplete="off" type="text"></td>'+
                '<td><input class="form-control" name="servicios[' + cont + '][fImpuestosTrasladados]" type="hidden"> <label class="text-center" > - </label> </td>'+
                '<td><input class="form-control" name="servicios[' + cont + '][fImpuestosRetenidos]" type="hidden"> <label class="text-center" > - </label> </td>'+
                '<td><input class="form-control" name="servicios[' + cont + '][fImporte]" type="hidden"> <label class="text-center" > - </label> </td>'+
                '<td><input class="form-control" name="servicios[' + cont + '][fDescuento]" type="hidden"> <label class="text-center" id="descuentoConcepto' + cont + '" > - </label> </td>'+
                '<td><button type="button" class="btn btn-outline btn-danger pull-right concepto-eliminar" onclick="eliminarConcepto(this);"><i class="icon wb-trash" aria-hidden="true"></i> Eliminar</button></td>'+
                '</tr>';
                $("#servicios-body").append(tr_concepto);
                core.autocomplete2('.skUnidadMedida', 'get_medidas', window.location.href, 'UNIDAD');
                core.autocomplete2('.skServicio', 'get_servicios', window.location.href, 'SERVICIO',{filter:'like'});
            });

            core.autocomplete2('.skTipoMedida', 'get_medidas', window.location.href, 'UNIDAD');
            core.autocomplete2('.skServicio', 'get_servicios', window.location.href, 'SERVICIO',{filter:'like'});

        /* TERMINA WIDGET DE SERVICIOS */
    });
</script>