<style>

/*@page :first {
    background: url('<?php echo ASSETS_PATH . 'assets/custom/img/bgpdf3.svg'; ?>') no-repeat 0 0;
    background-image-resize: 6;
}*/

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

<!--<div class="col-md-12 clearfix" style="height:10px;"></div>!-->
<!--<div class="col-md-12 clearfix" style="margin-top:90px;margin-left:50px;width:90%;border:0px solid red;">!-->
<div class="col-md-12 clearfix" style="margin-top:0px;margin-left:50px;width:90%;border:0px solid red;">

<!--<h4 style="text-align:center;">ACTA DE ENTREGA</h4>!-->

<div class="col-md-12 " style="margin-bottom: 10px;">
    <div class="col-md-5 pull-left">
    <h4 style="text-align:center;margin-top:40px;font-size:25px;color:#313234;">ACTA DE ENTREGA</h4>
    </div>

 
    <div class="col-md-7" style="text-align: right; margin-left: 70px;">
        <div class="" style="color:black;">
            <span class="bold" style="font-size: 14px;text-transform: uppercase;">Folio <?php echo (isset($data['datos']['iFolio'])) ? ($data['datos']['iFolio']) : ''; ?></span><br>
            <span  style="font-size: 10px;">AV. ELIAS ZAMORA VERDUZCO  #3220 "A"</span><br>
            <span  style="font-size: 10px;">COLONIA BARRIO NUEVO, MANZANILLO, COL.</span><br>
            <span style="font-size: 10px;">TEL (314) 137 8133 CEL. (314) 129 1339</span><br>
        </div>
    </div>
</div>

<div class="col-md-12" style="font-size:13px;">
    <div class="col-md-2"><b>CLIENTE:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['cliente'])) ? ($data['datos']['cliente']) : '-'; ?></div>
</div>
<!--
<div class="col-md-12" style="font-size:13px;color:#000000;">
    <div class="col-md-2"><b>DIRECCIÓN:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['sDireccion'])) ? ($data['datos']['sDireccion']) : '-'; ?></div>
</div>
<div class="col-md-12" style="font-size:13px;color:#000000;">
    <div class="col-md-2"><b>RPU:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['sRPU'])) ? ($data['datos']['sRPU']) : '-'; ?></div>
</div>
!-->
<div class="col-md-12" style="font-size:13px;color:#000000;">
    <div class="col-md-2"><b>TELÉFONO:</b></div> 
    <div class="col-md-9"><?php echo (isset($data['datos']['sTelefonoRecepcionEntrega'])) ? ($data['datos']['sTelefonoRecepcionEntrega']) : '-'; ?></div>
</div>

<div class="col-md-12 clearfix" style="font-size:11px;text-transform: uppercase;">
SIENDO EL DÍA <?php echo (isset($data['datos']['dFechaEntregaInstalacion']) && !empty($data['datos']['dFechaEntregaInstalacion'])) ? $this->obtenerFechaEnLetra($data['datos']['dFechaEntregaInstalacion']) : '-'; ?>, SOLAR FUTURE MANZANILLO HACE ENTREGA DE LA INSTALACIÓN DEL SISTEMA / EQUIPO QUE SE DESCRIBE A CONTINUACIÓN:
</div>

<!--
<div class="col-md-12 clearfix" style="font-size:13px;">
    <div class="col-md-offset-1 col-md-10 pull-right text-right">
        <small><b>ELABORADO POR:</b></small> <small style="text-transform: uppercase;"><?php echo (!empty($data['datos']['usuarioCreacion']) ? $data['datos']['usuarioCreacion'] : ''); ?>, EL DÍA <?php echo (isset($data['datos']['dFechaCreacion']) && !empty($data['datos']['dFechaCreacion'])) ? $this->obtenerFechaEnLetra($data['datos']['dFechaCreacion']) : '-'; ?></small>
    </div>
</div>
!-->

<div class="col-md-12 page-invoice-table table-responsive font-size-12" style="margin-top: 10px;">
    <table class="table text-right">
	<thead>
	    <tr>
		<th class="text-center" style="text-align:center; font-size: 10px;">CÓDIGO</th>
 		<th class="text-left" style="text-align:left; font-size: 10px;">PRODUCTO / SERVICIO</th>
		<th class="text-center" style="text-align:center; font-size: 10px;">CANTIDAD</th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    $i = 1;
	    if (isset($data['conceptosCotizacion'])) {
		foreach ($data['conceptosCotizacion'] AS $conceptos) {
		    ?>
		    <tr>
			<td style="text-align:center; font-size: 10px; text-transform: uppercase; word-wrap: break-word;" ><?php echo $conceptos['sCodigo']; ?></td>
 			<td style="text-align:left; font-size: 10px; text-transform: uppercase; word-wrap: break-word;" ><?php echo (!empty($conceptos['sDescripcion']) ? $conceptos['sDescripcion'] : $conceptos['concepto']); ?></td>
			<td style="text-align:right; font-size: 10px; text-transform: uppercase;" ><?php echo number_format($conceptos['fCantidad'], 2); ?></td>
		    </tr>
		    <?php
		    $i++;
		}//FOREACH
        }//ENDIF
	    ?>
	</tbody>
    </table>
</div>

<div class="col-md-12 clearfix" style="font-size:11px;text-transform: uppercase;">
DICHO TRABAJO SE ENTREGA FUNCIONANDO Y A SATISFACCIÓN PLENA DEL CLIENTE, HABIÉNDOSE EXPLICADO EL CÓMO OPERAR EL SISTEMA / PRODUCTO Y LAS RECOMENDACIONES O SUGERENCIAS PARA LA ADECUADA FUNCIONALIDAD DEL MISMO.
</div>

<?php
    if (isset($data['conceptosCotizacionInventario']) && !empty($data['conceptosCotizacionInventario'])) {
?>
<div class="col-md-12 clearfix" style="font-size:14px;text-transform: uppercase;font-weight:bold;">
1.- LISTADO Y NÚMERO DE SERIE DE LOS EQUIPOS:
</div>

<!-- AQUI VA LA INFORMACIÓN DE LOS PRODUCTOS DE INVENTARIO !-->
<div class="col-md-12 clearfix"></div>
<div class="col-md-12 page-invoice-table table-responsive font-size-12" style="margin-top: 0px;">
    <table class="table text-right">
	<thead>
    <tr>
    <th class="text-center" colspan="3" style="border-bottom: 1px solid white;">PRODUCTOS ENTREGADOS</th>
    </tr>
        <tr>
		<th class="text-center" style="text-align:center; font-size: 10px;">CÓDIGO</th>
 		<th class="text-left" style="text-align:left; font-size: 10px;">PRODUCTO</th>
		<th class="text-center" style="text-align:center; font-size: 10px;">NÚMERO DE SERIE</th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    if (isset($data['conceptosCotizacionInventario'])) {
		foreach ($data['conceptosCotizacionInventario'] AS $conceptosInventario) {
		    ?>
		    <tr>
			<td style="text-align:center; font-size: 10px; text-transform: uppercase; word-wrap: break-word;"><?php echo $conceptosInventario['sCodigo']; ?></td>
 			<td style="text-align:left; font-size: 10px; text-transform: uppercase; word-wrap: break-word;"><?php echo (!empty($conceptosInventario['sDescripcion']) ? $conceptosInventario['sDescripcion'] : $conceptosInventario['concepto']); ?></td>
            <td style="text-align:center; font-size: 10px; text-transform: uppercase; word-wrap: break-word;"><?php echo (!empty($conceptosInventario['sNumeroSerie']) ? implode(', ',$conceptosInventario['sNumeroSerie']) : ''); ?></td>
		    </tr>
		    <?php
		}//FOREACH
        }//ENDIF
	    ?>
	</tbody>
    </table>
</div>

<div style="page-break-after:always;"></div>
<?php 
    }//ENDIF
?>
<div class="col-md-12 clearfix" style="font-size:14px;text-transform: uppercase;font-weight:bold;">
2.- RELACIÓN DE EVIDENCIA FOTOGRÁFICA INTEGRADA AL PRESENTE FORMATO DE ENTREGA
</div>

<?php 
    if(isset($data['fotografiasEntrega'])){ 
        foreach ($data['fotografiasEntrega'] AS $fotografia){ 
?>
    <div class="col-md-5" style="padding-top: 15px;margin-left: 15px;text-align:center;">
        <img src="<?php echo $fotografia['sUbicacionPublica']; ?>" width="100%" height="140">
    </div> 
<?php
        }//FOREACH
    }//ENDIF 
?>

<div class="col-md-12 clearfix" style="font-size:14px;text-transform: uppercase;font-weight:bold;">
3.- GARANTÍAS
</div>

<?php 
    if(isset($data['cotizacionInformacionProducto'])){ 
        foreach ($data['cotizacionInformacionProducto'] AS $infoProductos){ 
            if(!empty($infoProductos['sDescripcionGarantia'])){
                $GENERACION_KW = (($infoProductos['fCantidad'] * $infoProductos['fKwh'] * 4.5 * 60) / 1000);
                $infoProductos['sDescripcionGarantia'] = str_replace('[GENERACION_KW/H]',($GENERACION_KW),$infoProductos['sDescripcionGarantia']);
?>
    <div class="col-md-12 clearfix" style="font-size:9px;">
        <?php echo (isset($infoProductos['sDescripcionGarantia'])) ? html_entity_decode($infoProductos['sDescripcionGarantia'],ENT_QUOTES) : ''; ?>
    </div> 
<?php
            }//ENDIF 
        }//FOREACH
    }//ENDIF 
?>

<div class="col-md-12 clearfix" style="font-size:14px;text-transform: uppercase;font-weight:bold;">
4.- OBSERVACIONES
</div>

<div class="col-md-12 clearfix" style="font-size:11px;text-transform: uppercase;">
DECLARAN LAS PARTES QUE LA ENTREGA DE DICHO SERVICIO, PROYECTO O PRODUCTO ES A ENTERA Y PLENA SATISFACCIÓN SIN DOLO ALGUNO, EN MANZANILLO, COLIMA EL DÍA <?php echo (isset($data['datos']['dFechaCreacion']) && !empty($data['datos']['dFechaCreacion'])) ? $this->obtenerFechaEnLetra($data['datos']['dFechaCreacion']) : '-'; ?>
</div>
 
<div class="col-md-5 clearfix" style="font-size:13px;text-transform: uppercase;margin-top:30px;">
    <p style="text-align: center;"><strong><span style="font-size: 8.0pt; font-family: 'Calibri',sans-serif;">___________________________________________</span></strong></p>
    <p style="margin-left: 14.2pt; text-align: center;">
        <span style="font-size: 14px; font-family: 'Calibri',sans-serif;">
            <?php echo (isset($data['datos']['cliente'])) ? ($data['datos']['cliente']) : '-'; ?><br>CLIENTE
        </span>
    </p>
</div>

<div class="col-md-5" style="font-size:13px;text-transform: uppercase;">
    <p style="text-align: center;"><strong><span style="font-size: 8.0pt; font-family: 'Calibri',sans-serif;">___________________________________________</span></strong></p>
    <p style="margin-left: 14.2pt; text-align: center;">
        <span style="font-size: 14px; font-family: 'Calibri',sans-serif;">
            ENTREGA<br>SOLAR FUTURE MANZANILLO S.A. DE C.V</br>
        </span>
    </p>
</div>

</div>