<?php
if (isset($data)) {
    $datos = $data['datos'];
    $result = $data['datos'];
    //exit(print_r($result['view']));
    //utf8($result);
}

/* $conteiners = $result['contenedores'];
  if (!empty($conteiners)) {
  $prefix = $conList = '';
  foreach ($conteiners as $cons) {
  $conList .= $prefix . '' . $cons['sContenedor'] . '';
  $prefix = ', ';
  }
  } */

//exit(print_r($conteiners));
//$total = $result['total'];
//print_r($result['general']);
//exit();
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
    <div class="col-md-4 pull-left"><img style="margin-left:80px;" src="<?php echo IMAGE_LOGO_PDF; ?>" width="150px"></div>

    <div class="col-md-2"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>

    <div class="col-md-6" style="text-align: center; margin-left: -70px;">
        <div class="" style=" color:black;">
            <span class="bold" style="font-size: 12px;text-transform: uppercase;"><?php echo $_SESSION['usuario']['sEmpresa'] ?></span><br>
            <span class="bold" style="font-size: 12px;">ORDEN DE SERVICIOS</span><br>
        </div>
    </div>
</div>
<br>
<div class="col-md-12" style="font-size:13px;">
    <div class="pull-left col-md-2"><b>FOLIO:</b> <span style="color:#000000;"></span></div>
    <div class="pull-left col-md-3"> <span style="color:#000000;"><?php echo (isset($datos['iFolio'])) ? ($datos['iFolio']) : 'N/D'; ?></span></div>
    
    <div class="col-md-offset-1 col-md-6 pull-right text-right"><small>FECHA SERVICIO:</small> <small style="text-transform: uppercase;"><?php echo (isset($datos['dFechaServicio']) && !empty($datos['dFechaServicio'])) ? $this->obtenerFechaEnLetra($datos['dFechaServicio']) : 'N/D'; ?></small></div>
</div>

<div class="col-md-12" style="font-size:13px;">
    <div class="pull-left col-md-2"><b>FOLIO SERVICIO:</b> <span style="color:#000000;"></span></div>
    <div class="pull-left col-md-3"> <span style="color:#000000;"><?php echo (isset($datos['folioServicio'])) ? ($datos['folioServicio']) : 'N/D'; ?></span></div>
    
</div>

<div class="col-md-12" style="font-size:13px;">
    <div class="pull-left col-md-2"><b>REFERENCÍA:</b> <span style="color:#000000;"></span></div>
    <div class="pull-left col-md-4"> <span style="color:#000000;"><?php echo (isset($datos['sReferencia'])) ? ($datos['sReferencia']) : 'N/D'; ?></span></div>

</div>

<div><br></div>

<div class="col-md-6">
    <div  style="font-size:13px;" class="pull-left col-md-12"><b>RESPONSABLE:</b></div>
    <div  style="font-size:13px;" class="pull-left col-md-12"><span style="color:#000000;"><?php echo (isset($datos['responsable'])) ? ($datos['responsable']) : 'N/D'; ?></span></div>
    <br>
</div>

<div class="col-md-offset-1 col-md-5">
    <div  style="font-size:13px;" class="pull-left col-md-12"><b>CLIENTE:</b></div>
    <div  style="font-size:13px;" class="pull-left col-md-12"><span style="color:#000000;"><?php echo (isset($datos['cliente'])) ? ($datos['cliente']) : 'N/D'; ?></span></div>
</div>

<div class="col-md-6">
    <div  style="font-size:13px;" class="pull-left col-md-12"><b>FACTURAR A:</b></div>
    <div  style="font-size:13px;" class="pull-left col-md-12"><span style="color:#000000;"><?php echo (isset($datos['facturacion'])) ? $datos['facturacion'] : 'N/D'; ?></span></div>
</div>

<div class="col-md-offset-1 col-md-5">
    <div  style="font-size:13px;" class="pull-left col-md-12"><b>PEDIMENTO:</b></div>
    <div  style="font-size:13px;" class="pull-left col-md-12"><span style="color:#000000;"><?php echo (isset($datos['sPedimento'])) ? $datos['sPedimento'] : 'N/D'; ?></span></div>
    <br>
</div>
<div class="col-md-6">
    <div  style="font-size:13px;" class="pull-left col-md-12"><b>BL:</b></div>
    <div  style="font-size:13px;" class="pull-left col-md-12"><span style="color:#000000;"><?php echo (isset($datos['sBL'])) ? ($datos['sBL']) : 'N/D'; ?></span></div>
    <br>
</div> 
 

<div class="col-md-12">
    <div  style="font-size:13px;" class="pull-left col-md-12"><b>DIRECCIÓN:</b></div>

    <div  style="font-size:13px;" class="pull-left col-md-12"><span style="color:#000000;">
    <?php echo (isset($data['domicilioReceptor']['calleReceptor'])) ? strtoupper($data['domicilioReceptor']['calleReceptor']) : ''; ?> <?php echo (isset($data['domicilioReceptor']['numeroExteriorReceptor'])) ? ", " . $data['domicilioReceptor']['numeroExteriorReceptor'] : ''; ?> <?php echo (isset($data['domicilioReceptor']['coloniaReceptor'])) ? ", " . strtoupper($data['domicilioReceptor']['coloniaReceptor']) : ''; ?> <?php echo (isset($data['domicilioReceptor']['municipioReceptor'])) ? ", " . strtoupper($data['domicilioReceptor']['municipioReceptor']) : ''; ?><?php echo (isset($data['domicilioReceptor']['estadoReceptor'])) ? ", " . strtoupper($data['domicilioReceptor']['estadoReceptor']) : ''; ?><?php echo (isset($data['domicilioReceptor']['paisReceptor'])) ? ", " . strtoupper($data['domicilioReceptor']['paisReceptor']) : ''; ?> 

    <br>
</div>

<div class="col-md-12 page-invoice-table table-responsive font-size-12">
    <table class="table text-right">
	<thead>
	    <tr>
		<th class="text-center">#</th>
		<th class="text-center" >Unidad de Medida</th>
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
	    if (isset($data['serviciosOrdenes'])) {
		foreach ($data['serviciosOrdenes'] AS $servicios) {
		    ?>
		    <tr>
			<td style="text-align:center; font-size: 8px; text-transform: uppercase;" ><?php echo $i; ?></td>
			<td style="text-align:left; font-size: 8px; text-transform: uppercase;" ><?php echo $servicios['unidadMedida']; ?></td>
			<td style="text-align:left; font-size: 8px; text-transform: uppercase;" ><?php echo $servicios['servicio']; ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo number_format($servicios['fCantidad'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fPrecioUnitario'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fImporteTotal'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo "$" . number_format($servicios['fDescuento'], 2); ?></td>
			<td style="text-align:right; font-size: 8px; text-transform: uppercase;" > <?php
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
	    <tr>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
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
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" >TRASLADOS: </td>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ><?php echo " $" . number_format($result['fImpuestosTrasladados'], 2); ?></td>
	    </tr>
	    <tr>
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" ></td>
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

<br>
 

