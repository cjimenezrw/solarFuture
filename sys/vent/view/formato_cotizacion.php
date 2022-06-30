<?php 
    //exit('<pre>'.print_r($data,1).'</pre>');
?>
<style>

@page :first {
    background: url('<?php echo ASSETS_PATH . 'assets/custom/img/bgpdf3.svg'; ?>') no-repeat 0 0;
    background-image-resize: 6;
}

table {
    background: white;
    border-radius:4em;
    border-collapse: collapse;
    margin: auto;
    padding:2px;
    width: 100%;
}

th {
    color: #fff;;
    background: #313234;
    /*border-bottom:4px solid #9ea7af;
    border-right: 1px solid #343a45;*/
    font-size: 12px;
    font-weight: 300;
    padding:4px;
    text-align:center;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    vertical-align:middle;
}

th:first-child {
    /*border-top-left-radius:4em;*/
}

th:last-child {
    /*border-top-right-radius:4em;
    border-right:none;*/
}

tr {
    /*border-top: 1px solid #C1C3D1;
    border-bottom-: 1px solid #C1C3D1;*/
    color:#666B85;
    font-size: 12px;
    font-weight:normal;
    text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}

tr:hover td {
    background:#4E5066;
    color:#FFFFFF;
    /*border-top: 1px solid #22262e;*/
}

tr:first-child {
    border-top:none;
}

tr:last-child {
    /*border-bottom:none;*/
}

tr:nth-child(odd) td {
    background:#EBEBEB;
}

tr:nth-child(odd):hover td {
    background:#4E5066;
}

tr:last-child td:first-child {
    /*border-bottom-left-radius:3px;*/
}

tr:last-child td:last-child {
    /*border-bottom-right-radius:3px;*/
}

td {
    background:#FFFFFF;
    padding:10px;
    text-align:left;
    vertical-align:middle;
    font-weight:300;
    font-size: 13px;
    /*border-right: 1px solid #C1C3D1;*/
}

td:last-child {
    /*border-right: 0px;*/
}

th.text-left {
    text-align: left;
}

th.text-center {
    text-align: center;
}

th.text-right {
    text-align: right;
}

td.text-left {
    text-align: left;
}

td.text-center {
    text-align: center;
}

td.text-right {
    text-align: right;
}

.input-group {
    display: none;
}

</style>

<br>
<div class="col-md-12 " style="margin-bottom: 10px;">
    <div class="col-md-5 pull-left"><img style="margin-left:0px;" src="<?php echo IMAGE_LOGO_PDF; ?>" width="350px"></div>

 
    <div class="col-md-7" style="text-align: right; margin-left: 70px;">
        <div class="" style="color:black;">
            <span class="bold" style="font-size: 14px;text-transform: uppercase;">Cotización <?php echo (isset($data['datos']['iFolio'])) ? ($data['datos']['iFolio']) : ''; ?></span><br>
            <span class="bold" style="font-size: 14px;text-transform: uppercase;">SOLAR FUTURE MANZANILLO S.A. DE C.V.</span><br>
            <span class="bold" style="font-size: 10px;">RFC: SFM1905213C3</span><br>
            <span  style="font-size: 10px;">AV. ELIAS ZAMORA VERDUZCO  #3220 "A"</span><br>
            <span  style="font-size: 10px;">COLONIA BARRIO NUEVO, MANZANILLO, COL.</span><br>
            <span style="font-size: 10px;">TEL (314) 137 8133 CEL. (314) 129 1339</span><br>
        </div>
    </div>
</div>

<div class="col-md-12 clearfix" style="font-size:13px;">
    <div class="col-md-2"><b>RECEPTOR:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['sNombreCliente'])) ? ($data['datos']['sNombreCliente']) : '-'; ?></div>
</div>
<div class="col-md-12" style="font-size:13px;color:#000000;">
    <div class="col-md-2"><b>DIRECCIÓN:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['sDireccion'])) ? ($data['datos']['sDireccion']) : '-'; ?></div>
</div>
<div class="col-md-12" style="font-size:13px;color:#000000;">
    <div class="col-md-2"><b>RPU:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['sRPU'])) ? ($data['datos']['sRPU']) : '-'; ?></div>
</div>
<div class="col-md-12" style="font-size:13px;color:#000000;">
    <div class="col-md-2"><b>TELÉFONO:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['sTelefono'])) ? ($data['datos']['sTelefono']) : '-'; ?></div>
</div>

<div class="col-md-12 clearfix" style="font-size:13px;">
    <div class="col-md-offset-1 col-md-10 pull-right text-right">
        <small><b>ELABORADO POR:</b></small> <small style="text-transform: uppercase;"><?php echo (!empty($data['datos']['usuarioCreacion']) ? $data['datos']['usuarioCreacion'] : ''); ?>, EL DÍA <?php echo (isset($data['datos']['dFechaCreacion']) && !empty($data['datos']['dFechaCreacion'])) ? $this->obtenerFechaEnLetra($data['datos']['dFechaCreacion']) : '-'; ?></small><br>
        <small><b>VIGENCIA:</b></small> <small style="text-transform: uppercase;"><?php echo (isset($data['datos']['dFechaVigencia']) && !empty($data['datos']['dFechaVigencia'])) ? $this->obtenerFechaEnLetra($data['datos']['dFechaVigencia']) : '-'; ?></small>
    </div>
</div>

<div class="col-md-12 page-invoice-table table-responsive font-size-12" style="margin-top: 10px;">
    <table class="table text-right">
	<thead>
	    <tr>
		<th class="text-center">CÓDIGO</th>
 		<th class="text-left">PRODUCTO / SERVICIO</th>
		<th class="text-right">CANTIDAD</th>
		<th class="text-right">P. UNITARIO</th>
		<th class="text-right">IMPORTE </th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    $i = 1;
	    if (isset($data['serviciosCotizacion'])) {
		foreach ($data['serviciosCotizacion'] AS $servicios) {
		    ?>
		    <tr>
			<td style="text-align:center; font-size: 10px; text-transform: uppercase; word-wrap: break-word;" ><?php echo $servicios['sCodigo']; ?></td>
 			<td style="text-align:left; font-size: 10px; text-transform: uppercase; word-wrap: break-word;" ><?php echo (!empty($servicios['sDescripcion']) ? $servicios['sDescripcion'] : $servicios['servicio']); ?></td>
			<td style="text-align:right; font-size: 10px; text-transform: uppercase;" ><?php echo number_format($servicios['fCantidad'], 2); ?></td>
            <td style="text-align:right; font-size: 10px; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fPrecioUnitario'], 2); ?></td>
			<td style="text-align:right; font-size: 10px; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fImporte'], 2); ?></td>
		    </tr>
		    <?php
		    $i++;
		}//FOREACH
        }//ENDIF
            $centavos = explode('.',$data['datos']['fImporteTotal']);
            $centavos = ($centavos[1]);
	    ?>
	    <tr>
            <td colspan="4" style="text-align:right; font-size: 9px; text-transform: uppercase; font-weight:bold;" >SUBTOTAL: </td>
            <td style="text-align:right; font-size: 9px; text-transform: uppercase;" ><?php echo " $" . number_format($data['datos']['fImporteSubtotal'], 2); ?></td>
	    </tr>
        <?php
            if(!empty($data['datos']['fDescuento'])){
        ?>
            <tr>
                <td colspan="4" style="text-align:right; font-size: 9px; text-transform: uppercase; font-weight:bold;" >DESCUENTO: </td>
                <td style="text-align:right; font-size: 9px; text-transform: uppercase;" ><?php echo " $" . number_format($data['datos']['fDescuento'], 2); ?></td>
            </tr>
        <?php }//ENDIF ?>
        <tr>
		    <td colspan="4" style="text-align:right; font-size: 9px; text-transform: uppercase; font-weight:bold;" >IVA: </td>
		    <td style="text-align:right; font-size: 9px; text-transform: uppercase;" ><?php echo " $" . number_format($data['datos']['fImpuestosTrasladados'], 2); ?></td>
	    </tr>
	    <tr>
            <td colspan="4" style="text-align:right; font-size: 9px; text-transform: uppercase; font-weight:bold;" >TOTAL: </td>
            <td style="text-align:right; font-size: 9px; text-transform: uppercase;" ><?php echo " $" . number_format($data['datos']['fImporteTotal'], 2); ?></td>
	    </tr>
        <?php
            if(isset($data['datos']['skCatalogoSistemaCOTMSI']) && !empty($data['datos']['skCatalogoSistemaCOTMSI'])){
        ?>
        <tr>
            <td colspan="4" style="text-align:right; font-size: 9px; text-transform: uppercase; font-weight:bold;" >TOTAL (<?php echo $data['datos']['sMSI']; ?>): </td>
            <td style="text-align:right; font-size: 9px; text-transform: uppercase;" ><?php echo " $" . number_format($data['datos']['fImporteTotalMSI'], 2); ?></td>
	    </tr> 
        <?php
            }//ENDIF
        ?>
	</tbody> 
    </table>
    <!--
    <div class="col-md-12" style="font-size:9px;text-align:right;">
        <b>TOTAL:</b><br><?php echo NumeroALetras::convertir($data['datos']['fImporteTotal'],'PESOS','CENTAVOS',true). ' '.$centavos.'/100M.N.'; ?>
    </div>
    <div class="col-md-12" style="font-size:9px;text-align:right;">
        <b>TOTAL (<?php echo $data['datos']['sMSI']; ?>):</b><br><?php echo NumeroALetras::convertir($data['datos']['fImporteTotalMSI'],'PESOS','CENTAVOS',true). ' '.$centavos.'/100M.N.'; ?>
    </div>!-->
</div>

<?php if(!empty($data['datos']['sCondicion'])){ ?>
<div class="col-md-12 clearfix">
    <span style="font-size:13px;font-weight:bold;">OBSERVACIONES</span><br>
    <span style="font-size:9px;"><?php echo nl2br($data['datos']['sCondicion']); ?></span>
</div>
<?php }//ENDIF ?>

<?php 
    if(isset($data['cotizacionInformacionProducto'])){ 
        foreach ($data['cotizacionInformacionProducto'] AS $infoProductos){ 
            if(!empty($infoProductos['sDescripcionHoja1'])){
?>
    <div class="col-md-12 clearfix" style="font-size:9px;">
        <?php echo (isset($infoProductos['sDescripcionHoja1'])) ? html_entity_decode($infoProductos['sDescripcionHoja1'],ENT_QUOTES) : ''; ?>
    </div> 
<?php
            }//ENDIF 
        }//FOREACH
    }//ENDIF 
?>

<?php if(!empty($data['datos']['sCondicion'])){ ?>
    <div class="col-md-12" style="font-size:13px;margin-top: 10px;">
<?php foreach ($data['cotizacionTerminosCondiciones'] AS $terminosCondiciones) { ?>
    <div class="pull-left col-md-12" style="font-size:9px;">
        <span ><?php echo (isset($terminosCondiciones['terminoCondicion'])) ? ($terminosCondiciones['terminoCondicion']) : ''; ?></span>
    </div>
<?php }//FOREACH ?>
    </div>
<?php }//ENDIF ?>

<!-- AQUI VA LA INFORMACIÓN DEL PRODUCTO DE LA HOJA 1 !-->

<?php if(!empty($data['PIECOT'])){ ?>
<div class="col-md-12 clearfix" style="font-size: 9px;color:#000000;">
        <?php echo nl2br($data['PIECOT']); ?>
</div>
<?php }//ENDIF ?>

<?php if(!empty($data['BANCOT'])){ ?>
<div class="col-md-12 clearfix" style="font-size: 9px;color:#000000;">
        <?php echo nl2br($data['BANCOT']); ?>
</div>
<?php }//ENDIF ?>