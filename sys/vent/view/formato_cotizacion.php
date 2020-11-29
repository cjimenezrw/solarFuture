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
            <span class="bold" style="font-size: 12px;">COTIZACION</span><br>
        </div>
    </div>
</div>
<br>
<div class="col-md-12" style="font-size:13px;">
    <div class="pull-left col-md-2"><b>FOLIO:</b> <span style="color:#000000;"></span></div>
    <div class="pull-left col-md-3"> <span style="color:#000000;"><?php echo (isset($datos['iFolio'])) ? ($datos['iFolio']) : 'N/D'; ?></span></div>
    
    <div class="col-md-offset-1 col-md-6 pull-right text-right"><small>FECHA SERVICIO:</small> <small style="text-transform: uppercase;"><?php echo (isset($datos['dFechaCreacion']) && !empty($datos['dFechaCreacion'])) ? $this->obtenerFechaEnLetra($datos['dFechaCreacion']) : 'N/D'; ?></small></div>
</div>

<div class="col-md-12" style="font-size:13px;">
    <div class="pull-left col-md-2"><b>VIGENCIA:</b> <span style="color:#000000;"></span></div>
    <div class="col-md-offset-1 col-md-6 pull-right text-right"><small>FECHA SERVICIO:</small> <small style="text-transform: uppercase;"><?php echo (isset($datos['dFechaVigencia']) && !empty($datos['dFechaVigencia'])) ? $this->obtenerFechaEnLetra($datos['dFechaVigencia']) : 'N/D'; ?></small></div>
    
</div>



<div><br></div>

<div class="col-md-6">
    <div  style="font-size:13px;" class="pull-left col-md-12"><b>CLIENTE:</b></div>
    <div  style="font-size:13px;" class="pull-left col-md-12"><span style="color:#000000;"><?php echo (isset($datos['cliente'])) ? ($datos['cliente']) : 'N/D'; ?></span></div>
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
	    if (isset($data['cotizacionConceptos'])) {
		foreach ($data['cotizacionConceptos'] AS $conceptos) {
		    ?>
		    <tr>
			<td style="text-align:center; font-size: 8px; text-transform: uppercase;" ><?php echo $i; ?></td>
			<td style="text-align:left; font-size: 8px; text-transform: uppercase;" ><?php echo $conceptos['tipoMedida']; ?></td>
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
		<td style="text-align:right; font-size: 8px; text-transform: uppercase;" >TRANSLADOS: </td>
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

<div class="col-md-12" style="display: none;">
    <p><b>Condiciones</b></p>
    <div class="condiciones" style="font-size: 12px;">
        <span>1.- CONDICION 1</span><br>
        <span>2.- CONDICION 2</span><br>
        <span>3.- CONDICION 3</span><br>
        <span>4.- CONDICION 4</span><br>
        <span>5.- CONDICION 5</span><br>
        <span>6.- CONDICION 6</span><br>
        <span>7.- CONDICION 7</span><br>
        <span>9.- CONDICION 8</span><br>
        
    </div>

</div>
<br>

<div class="col-md-12" style="text-align: center;">
    <div class="col-md-4" style="text-align: center">
	<p style='font-size: 10px'><b>CLIENTE</b></p><br>
        <label><b>_________________________</b></label><br>
        <p style='font-size: 8px'>FIRMA Y NOMBRE <br> SELLO</p><br>
    </div>
    <div class="col-md-4" style="text-align: center">&nbsp;
    </div>
    <div class="col-md-4" style="text-align: center">
	<p style='font-size: 10px'><b>MIP TERMINAL</b></p><br>
        <label><b>_________________________</b></label><br>
        <p style='font-size: 8px'><b><?php echo $data['datos']['nombreCreacion']; ?></b></p>
	<p style='font-size: 8px'>FIRMA Y NOMBRE <br> SELLO</p><br>
    </div>
    <br><br>
</div>

