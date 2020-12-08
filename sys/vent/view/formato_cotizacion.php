<?php
if (isset($data)) {
    $datos = $data['datos'];
    $result = $data['datos'];
    //utf8($result);
}


?>
<style>

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
        border-bottom:4px solid #9ea7af;
        border-right: 1px solid #343a45;
        font-size: 12px;
        font-weight: 300;
        padding:4px;
        text-align:center;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        vertical-align:middle;
    }

    th:first-child {
        border-top-left-radius:4em;
    }

    th:last-child {
        border-top-right-radius:4em;
        border-right:none;
    }

    tr {
        border-top: 1px solid #C1C3D1;
        border-bottom-: 1px solid #C1C3D1;
        color:#666B85;
        font-size: 12px;
        font-weight:normal;
        text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
    }

    tr:hover td {
        background:#4E5066;
        color:#FFFFFF;
        border-top: 1px solid #22262e;
    }

    tr:first-child {
        border-top:none;
    }

    tr:last-child {
        border-bottom:none;
    }

    tr:nth-child(odd) td {
        background:#EBEBEB;
    }

    tr:nth-child(odd):hover td {
        background:#4E5066;
    }

    tr:last-child td:first-child {
        border-bottom-left-radius:3px;
    }

    tr:last-child td:last-child {
        border-bottom-right-radius:3px;
    }

    td {
        background:#FFFFFF;
        padding:10px;
        text-align:left;
        vertical-align:middle;
        font-weight:300;
        font-size: 13px;
        border-right: 1px solid #C1C3D1;
    }

    td:last-child {
        border-right: 0px;
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
    <div class="col-md-4 pull-left"><img style="margin-left:00px;" src="<?php echo IMAGE_LOGO_PDF; ?>" width="180px"></div>

 
    <div class="col-md-8" style="text-align: right; margin-left: 70px;">
        <div class="" style=" color:black;">
            <span class="bold" style="font-size: 10px;text-transform: uppercase;">Solar Future Manzanillo S.A.S.</span><br>
            <span class="bold" style="font-size: 10px;">RFC: SFM1905213C3</span><br>
            <span  style="font-size: 10px;">AV. ELIAS ZAMORA VERDUZCO  #3220 "A"</span><br>
            <span  style="font-size: 10px;">COLONIA BARRIO NUEVO, MANZANILLO, COL.</span><br>
            <span style="font-size: 10px;">TEL (314) 1378133 CEL. 314 129 1339</span><br>
        </div>
    </div>
</div>
<br>
<div class="col-md-6">
    <div  style="font-size:13px;" class="pull-left col-md-4"><b>CLIENTE:</b></div>
    <div  style="font-size:13px;" class="pull-left col-md-8"><span style="color:#000000;"><?php echo (isset($datos['cliente'])) ? ($datos['cliente']) : 'N/D'; ?></span></div>
    <br>
</div>
<div class="col-md-12" style="font-size:13px;">
    <div class="pull-left col-md-2"><b>FOLIO:</b> <span style="color:#000000;"></span></div>
    <div class="pull-left col-md-3"> <span style="color:#000000;"><?php echo (isset($datos['iFolio'])) ? ($datos['iFolio']) : 'N/D'; ?></span></div>
    
 </div>

<div class="col-md-12" style="font-size:13px;">
    <div class="col-md-offset-1 col-md-6 pull-right text-right"><small>FECHA VIGENCIA:</small> <small style="text-transform: uppercase;"><?php echo (isset($datos['dFechaVigencia']) && !empty($datos['dFechaVigencia'])) ? $this->obtenerFechaEnLetra($datos['dFechaVigencia']) : 'N/D'; ?></small></div>
    
</div>



<div><br></div>






 

<div class="col-md-12 page-invoice-table table-responsive font-size-12">
    <table class="table text-right">
	<thead>
	    <tr>
		<th class="text-center">#</th>
 		<th class="text-center" >Servicio</th>
		<th class="text-center">Cantidad</th>
		<th class="text-center">P. Unit</th>
		<th class="text-center">Importe </th>
		<th class="text-center">Desc </th>
		<th class="text-center" >Impuestos </th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    $i = 1;
	    if (isset($data['conceptosCotizacion'])) {
		foreach ($data['conceptosCotizacion'] AS $conceptos) {
		    ?>
		    <tr>
			<td style="text-align:center; font-size: 8px; text-transform: uppercase;" ><?php echo $i; ?></td>
 			<td style="text-align:left; font-size: 8px; text-transform: uppercase;" ><?php echo $conceptos['concepto']; ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo number_format($conceptos['fCantidad'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fPrecioUnitario'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fImporte'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo "$" . number_format($conceptos['fDescuento'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" > <?php
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
	    <tr>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
 		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" >SUBTOTAL: </td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo " $" . number_format($result['fImporteSubtotal'], 2); ?></td>
	    </tr>
	    <tr>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
 		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" >DESCUENTO: </td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo " $" . number_format($result['fDescuento'], 2); ?></td>
	    </tr>
	    <tr>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
 		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" >RETENCION: </td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo " $" . number_format($result['fImpuestosRetenidos'], 2); ?></td>
	    </tr>
	    <tr>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
 		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" >TRANSLADOS: </td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo " $" . number_format($result['fImpuestosTrasladados'], 2); ?></td>
	    </tr>
	    <tr>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
 		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" >TOTAL: </td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo " $" . number_format($result['fImporteTotal'], 2); ?></td>
	    </tr>

	</tbody>
    </table>
</div>
<div class="col-md-12" >
    <div class="condiciones" style="font-size: 10px;">
        <span class="bold" ><?php echo (isset($datos['sCondicion'])) ? ($datos['sCondicion']) : 'N/D'; ?></span><br>
    </div>

</div>
 
<br>
<?php
if (isset($data['cotizacionTerminosCondiciones'])) {
    foreach ($data['cotizacionTerminosCondiciones'] AS $terminosCondiciones) {
        
        ?>
        <div class="col-md-12">
            
            <div  style="font-size:13px;" class="pull-left col-md-12"><span ><?php echo (isset($terminosCondiciones['terminoCondicion'])) ? ($terminosCondiciones['terminoCondicion']) : 'N/D'; ?></span></div>
           
        </div>

        <?php
    }//FOREACH
    }
    ?>

<br>
<br>
<?php
if (isset($data['cotizacionInformacionProducto'])) {
    foreach ($data['cotizacionInformacionProducto'] AS $infoProductos) {
        $rutaImgen = "";
        if(file_exists(SYS_URL.'files/vent/coti-deta/'.$infoProductos['sImagen'])){
            $rutaImgen = SYS_URL.'files/vent/coti-deta/'.$infoProductos['sImagen'];
        }
        ?>
        <div class="col-md-12">
            <div  style="font-size:13px;" class="pull-left col-md-4">
            <?php echo (!empty($rutaImgen)) ? '<img src="'.$rutaImgen.'" alt="'.$infoProductos['sNombre'].'" width="200" height="200">' : 'N/D'; ?>
            </div>
            <div  style="font-size:13px;" class="pull-left col-md-8"><span style="color:#000000;"><?php echo (isset($infoProductos['sNombre'])) ? ($infoProductos['sNombre']) : 'N/D'; ?></span></div>
            <br>
        </div>

        <?php
    }//FOREACH
    }
    ?>
 
<br>



