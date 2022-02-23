<?php
    $bg = ['fbfdfd','e8f1f8'];
    //exit("<pre>".print_r($data,1)."</pre>");
    //exit("<pre>".print_r($data['datos']['iFolio'],1)."</pre>");
?>
<div class="col-md-6">
    <table style="font-size:10px;" class="col-md-12">
        <tr>
            <th class="col-md-12" colspan="2" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;word-break: break-all;">CLIENTE</th>
        </tr>
        <tr>
            <th class="col-md-12" colspan="2" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;word-break: break-all;">
                <?php echo isset($data['datos']['cliente']) ? substr($data['datos']['cliente'],0,59) : ''; ?>
            </th>
        </tr>
        <tr>
            <th class="col-md-12" colspan="2" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;word-break: break-all;">ASUNTO</th>
        </tr>
        <tr>
            <th class="col-md-12" colspan="2" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;word-break: break-all;">
                <?php echo !empty($data['datos']['sReferencia']) ? substr($data['datos']['sReferencia'],0,59) : '-'; ?>
            </th>
        </tr>
        <!--
        <tr>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">TELÉFONO</th>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">DIRECCIÓN</th>
        </tr>
        <tr>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                <?php echo !empty($data['datos']['sTelefono']) ? $data['datos']['sTelefono'] : '-'; ?>
            </th>
            <th class="col-md-6" style="text-align:left;text-transform:normal;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                <?php echo !empty($data['datos']['sDomicilio']) ? $data['datos']['sDomicilio'] : '-'; ?>
            </th>
        </tr>
        !-->
        <tr>
            <th class="col-md-12" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">EMPRESA A FACTURAR</th>
        </tr>
        <tr>
            <th class="col-md-12" style="text-align:left;text-transform:normal;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                <?php echo !empty($data['datos']['facturacion']) ? $data['datos']['facturacion'] : '-'; ?>
            </th>
        </tr>
    </table>
</div>

<div class="col-md-6 col-md-offset-1">
    <table style="font-size:10px;" class="col-md-12">
        <tr>
            <th class="col-md-12" colspan="2" style="text-align:right;background-color: #FFFFFF;">
                <span style="color:#000000;font-size: 14px;">Folio #</span> <span style="color:#f96868;font-size: 14px;">
                    <?php echo !empty($data['datos']['iFolio']) ? $data['datos']['iFolio'] : '-'; ?>
                </span>
                <br>
                <span style="color:#000000;font-size: 10px;font-weight: normal;">
                    <?php echo !empty($data['datos']['dFechaCreacion']) ? $this->obtenerFechaEnLetra($data['datos']['dFechaCreacion']) : '-'; ?>    
                </span>
            </th>
        </tr>
        <!--
        <tr>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">ELABORÓ</th>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">FECHA</th>
        </tr>
        <tr>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                <?php echo !empty($data['datos']['usuarioCreacion']) ? $data['datos']['usuarioCreacion'] : '-'; ?>
            </th>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                <?php echo !empty($data['datos']['dFechaCreacion']) ? $this->obtenerFechaEnLetra($data['datos']['dFechaCreacion']) : '-'; ?>
            </th>
        </tr>
        !-->
        <tr>
            <th class="col-md-12" colspan="2" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">ELABORÓ</th>
        </tr>
        <tr>
            <th class="col-md-12" colspan="2" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                <?php echo !empty($data['datos']['usuarioCreacion']) ? $data['datos']['usuarioCreacion'] : '-'; ?>
            </th>
        </tr>
        <tr>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">DIVISA</th>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #cecece; color: #000000;font-weight: bold;">TIPO DE CAMBIO</th>
        </tr>
        <tr>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                <?php echo !empty($data['datos']['divisa']) ? $data['datos']['divisa'].' ('.$data['datos']['skDivisa'].')' : '-'; ?>
            </th>
            <th class="col-md-6" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;">
                $<?php echo !empty($data['datos']['fTipoCambio']) ? number_format($data['datos']['fTipoCambio'],4) : '0.00'; ?>
            </th>
        </tr>
    </table>
</div>

<div class="col-md-12 clearfix"></div>

<?php if(empty($data['datos']['iNoFacturable'])){ ?>
<div class="col-md-12 clearfix">
    <table style="font-size:10px;" class="col-md-12">
        <tr>
            <th class="col-md-4" style="text-align:center;background-color: #cecece; color: #000000;font-weight: bold;">MÉTODO DE PAGO</th>
            <th class="col-md-4" style="text-align:center;background-color: #cecece; color: #000000;font-weight: bold;">FORMA DE PAGO</th>
            <th class="col-md-4" style="text-align:center;background-color: #cecece; color: #000000;font-weight: bold;">USO DE CFDI</th>
        </tr>
        <tr>
            <th class="col-md-4" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;text-transform: uppercase;">
                <?php echo (!empty($data['datos']['skMetodoPago']) ? '('.$data['datos']['skMetodoPago'].') '.$data['datos']['metodoPago'] : '-'); ?>
            </th>
            <th class="col-md-4" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;text-transform: uppercase;">
                <?php echo (!empty($data['datos']['skFormaPago']) ? '('.$data['datos']['skFormaPago'].') '.$data['datos']['formaPago'] : '-'); ?>
            </th>
            <th class="col-md-4" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;text-transform: uppercase;">
                <?php echo (!empty($data['datos']['skUsoCFDI']) ? '('.$data['datos']['skUsoCFDI'].') '.$data['datos']['usoCFDI'] : '-'); ?>
            </th>
        </tr>
    </table>
</div>
<?php }//ENDIF ?>

<div class="col-md-12 clearfix"></div>

<?php
    $bg = ['fbfdfd','e8f1f8'];
?>
<div class="col-md-12">
    <table style="font-size:9px;" class="col-md-12">
        <tr>
            <th class="col-md-12" colspan="<?php echo (empty($data['datos']['iNoFacturable']) ? 9 : 7 ); ?>" style="font-size:12px;text-align:center;text-transform:uppercase;background-color: #4776a5; color: #ffffff;font-weight: bold;">PRODUCTOS / SERVICIOS</th>
        </tr>
        <tr>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">#</th>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">UNIDAD</th>
            <th class="col-md-4" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">PRODUCTO / SERVICIO</th>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">CANTIDAD</th>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">P. UNITARIO</th>
            <?php if(empty($data['datos']['iNoFacturable'])){ ?>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">IVA</th>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">RET IVA</th>
            <?php }//ENDIF ?>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">IMPORTE</th>
            <th class="col-md-1" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">DESCUENTO</th>
        </tr>
        <?php
            if(isset($data['serviciosOrdenes']) && count(($data['serviciosOrdenes'])) > 0){
                $cont = 1;
                $bg_flag = 0;
                foreach($data['serviciosOrdenes'] AS $row){
        ?>
        <tr>
            <td style="text-align:center;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;"><?php echo $cont; ?></td>
            <td style="text-align:center;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;"><?php echo (isset($row['unidadMedida']) ? $row['unidadMedida'] : ''); ?></td>
            <td style="text-align:left;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;"><?php echo (!empty($row['sDescripcion']) ? $row['sDescripcion'] : $row['servicio']); ?></td>
            <td style="text-align:right;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;"><?php echo (isset($row['fCantidad']) ? number_format($row['fCantidad'],2) : '0.00');?></td>
            <td style="text-align:right;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;">$<?php echo (isset($row['fPrecioUnitario']) ? number_format($row['fPrecioUnitario'],2) : '0.00');?></td>
            <?php if(empty($data['datos']['iNoFacturable'])){ ?>
            <td style="text-align:right;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;">$<?php echo (isset($row['fImpuestosTrasladados']) ? number_format($row['fImpuestosTrasladados'],2) : '0.00');?></td>
            <td style="text-align:right;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;">$<?php echo (isset($row['fImpuestosRetenidos']) ? number_format($row['fImpuestosRetenidos'],2) : '0.00');?></td>
            <?php }//ENDIF ?>
            <td style="text-align:right;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;">$<?php echo (isset($row['fImporteTotal']) ? number_format($row['fImporteTotal'],2) : '0.00');?></td>
            <td style="text-align:right;text-transform:uppercase;background-color:#<?php echo $bg[$bg_flag]; ?>;">$<?php echo (isset($row['fDescuento']) ? number_format($row['fDescuento'],2) : '0.00');?></td>
        </tr>
        <?php
                $bg_flag = ($bg_flag ? 0 : 1);
                $cont++;
                }//ENDFOREACH
            }else{
        ?>
        <tr>
            <td style="text-align:left;background-color:#<?php echo $bg[0]; ?>;" colspan="9">&nbsp;</td>
        </tr>
        <?php
            }//ENDIF
        ?>
        <!--
        <tr>
            <td colspan="9" style="text-align:right;font-weight: bold;border-top:2px solid #cecece;background-color:#<?php echo $bg[1]; ?>;">
                $<?php echo !empty($data['datos_cotizacion']['fGastosComprobados']) ? number_format($data['datos_cotizacion']['fGastosComprobados'],2) : '0.00'; ?>
            </td>
        </tr>
        !-->
    </table>
</div>


<div class="col-md-12 clearfix"></div>

<div class="col-md-6 col-md-offset-7">
    <table style="font-size:10px;" class="col-md-12">
        <tr>
            <th style="text-align:center;background-color: #<?php echo $bg[1]; ?>; color: #000000;font-weight: normal;">SUBTOTAL</th>
            <th style="text-align:right; color: #000000;font-weight: normal;background-color:#<?php echo $bg[1]; ?>;">
                $<?php echo (!empty($data['datos']['fImporteSubtotal']) ? number_format($data['datos']['fImporteSubtotal'],2) : '0.00'); ?>
            </th>
        </tr>
        <tr>
            <th style="text-align:center;background-color: #<?php echo $bg[1]; ?>; color: #000000;font-weight: normal;">DESCUENTO</th>
            <th style="text-align:right; color: #000000;font-weight: normal;background-color:#<?php echo $bg[1]; ?>;">
                $<?php echo (!empty($data['datos']['fDescuento']) ? number_format($data['datos']['fDescuento'],2) : '0.00'); ?>
            </th>
        </tr>
        <?php if(empty($data['datos']['iNoFacturable'])){ ?>
        <tr>
            <th style="text-align:center;background-color: #<?php echo $bg[1]; ?>; color: #000000;font-weight: normal;">IVA</th>
            <th style="text-align:right; color: #000000;font-weight: normal;background-color:#<?php echo $bg[1]; ?>;">
                $<?php echo (!empty($data['datos']['fImpuestosTrasladados']) ? number_format($data['datos']['fImpuestosTrasladados'],2) : '0.00'); ?>
            </th>
        </tr>
        <tr>
            <th style="text-align:center;background-color: #<?php echo $bg[1]; ?>; color: #000000;font-weight: normal;">RET IVA</th>
            <th style="text-align:right; color: #000000;font-weight: normal;background-color:#<?php echo $bg[1]; ?>;">
                $<?php echo (!empty($data['datos']['fImpuestosRetenidos']) ? number_format($data['datos']['fImpuestosRetenidos'],2) : '0.00'); ?>
            </th>
        </tr>
        <?php }//ENDIF ?>
        <?php if(!empty($data['datos']['iNoFacturable'])){ ?>
        <tr>
            <th style="text-align:center;background-color: #4776a5; color: #FFFFFF;font-weight: bold;">TOTAL SIN IVA</th>
            <th style="text-align:right; color: #f96868;font-weight: bold;background-color:#<?php echo $bg[1]; ?>;">
                <!--$<?php echo (!empty($data['datos']['fImporteTotalSinIVA']) ? number_format($data['datos']['fImporteTotalSinIVA'],2) : '0.00'); ?>!-->
                $<?php echo (!empty($data['datos']['fImporteTotalSinIva']) ? number_format($data['datos']['fImporteTotalSinIva'],2) : '0.00'); ?>
            </th>
        </tr>
        <?php }//ENDIF ?>
        <?php if(empty($data['datos']['iNoFacturable'])){ ?>
        <tr>
            <th style="text-align:center;background-color: #4776a5; color: #FFFFFF;font-weight: bold;">TOTAL IVA INCLUIDO</th>
            <th style="text-align:right; color: #f96868;font-weight: bold;background-color:#<?php echo $bg[1]; ?>;">
                $<?php echo (!empty($data['datos']['fImporteTotal']) ? number_format($data['datos']['fImporteTotal'],2) : '0.00'); ?>
            </th>
        </tr>
        <?php }//ENDIF ?>
    </table>
</div>
<div class="col-md-12 pull-right" style="font-size:10px;text-align: right;text-transform:uppercase;">
    <?php 
        if(empty($data['datos']['iNoFacturable'])){
            echo !empty($data['datos']['fImporteTotal']) ? strtolower(NumeroALetras::convertir($data['datos']['fImporteTotal'], 'PESOS', 'CENTAVOS',true)).' '.(substr((explode('.',number_format($data['datos']['fImporteTotal'],2))[1]),0,2)).'/100 M.N.' : ''; 
        }else{
            echo !empty($data['datos']['fImporteTotalSinIva']) ? strtolower(NumeroALetras::convertir($data['datos']['fImporteTotalSinIva'], 'PESOS', 'CENTAVOS',true)).' '.(substr((explode('.',number_format($data['datos']['fImporteTotalSinIva'],2))[1]),0,2)).'/100 M.N.' : ''; 
        }
    ?>
</div> 

<div class="col-md-12 clearfix">
    <table style="font-size:10px;" class="col-md-12">
        <tr>
            <th class="col-md-12" style="text-align:left;background-color: #cecece; color: #000000;font-weight: bold;">OBSERVACIONES</th>
        </tr>
        <tr>
            <th class="col-md-12" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;text-transform: uppercase;">
                <?php echo !empty($data['datos']['sObservaciones']) ? nl2br($data['datos']['sObservaciones']) : ''; ?>
            </th>
        </tr>
        <tr>
            <th class="col-md-12" style="text-align:left;text-transform:uppercase;background-color: #FFFFFF; color: #000000;font-weight: normal;text-transform: uppercase;">
                <?php echo !empty($data['PIECOT']) ? $data['PIECOT'] : ''; ?>
            </th>
        </tr>
    </table>
</div>

<?php if(isset($data['informacionProducto'])){ ?>
    <div class="col-md-12" style="color:#000000;font-size:10px;text-align:justify;text-transform:uppercase;">
        <?php
            if(isset($data['informacionProducto'])){
                foreach($data['informacionProducto'] AS $val){
        ?>
            <div class="col-md-12"><?php echo !empty($val['sDescripcionHoja1']) ? $val['sDescripcionHoja1'] : ''; ?></div>
        <?php 
                }//ENDFOREACH
            }//ENDIF
        ?>
    </div>
<?php }//ENDIF ?>

<div class="col-md-12 clearfix" style="color:#000000;font-size:7px;"><hr></div>

<div class="col-md-8 col-md-offset-2 clearfix">
    <table style="font-size:10px;" class="col-md-12">
        <tr>
            <th class="col-md-4" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">BANCO</th>
            <th class="col-md-4" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">NÚMERO DE CUENTA</th>
            <th class="col-md-4" style="text-align:center;background-color: #2c3e50; color: #ffffff;font-weight: bold;">CLABE INTERBANCARIA</th>
        </tr>
        <?php
            if(!empty($data['get_bancosCuentasReceptor']) && is_array($data['get_bancosCuentasReceptor'])){
                foreach($data['get_bancosCuentasReceptor'] AS $k_bancoCuenta=>$v_bancoCuenta){
                    foreach($v_bancoCuenta AS $k_cuenta=>$v_cuenta){
                        if($v_cuenta['bancoAlias'] == 'EFECTIVO'){
                            continue;
                        }
        ?>
        <tr>
            <td class="col-md-4" style="text-align:center;background-color:#<?php echo $bg[1]; ?>;"><?php echo $v_cuenta['bancoAlias'].' ('.$v_cuenta['skDivisa'].')'; ?></td>
            <td class="col-md-4" style="text-align:center;background-color:#<?php echo $bg[1]; ?>;"><?php echo $v_cuenta['sNumeroCuenta']; ?></td>
            <td class="col-md-4" style="text-align:center;background-color:#<?php echo $bg[1]; ?>;"><?php echo $v_cuenta['sClabeInterbancaria']; ?></td>
        </tr>
        <?php
                    }//ENDFOREACH
                }//ENDFOREACH
            }else{
        ?>
        <tr>
            <td class="col-md-12" colspan="3" style="text-align:center;background-color:#<?php echo $bg[1]; ?>;">- SIN REGISTRO DE CUENTAS BANCARIAS -</td>
        </tr>
        <?php
            }//ENDIF
        ?>
        
    </table>
    <div class="col-md-12 clearfix" style="color:#000000;font-size:10px;text-align:center;">
        FAVOR DE ENVIAR SU COMPROBANTE DE TRANSFERENCIA, INDICANDO SU REFERENCIA 
        <b>
            <?php echo !empty($data['datos']['iFolio']) ? $data['datos']['iFolio'] : '-'; ?>
        </b>
    </div>
    
</div>
