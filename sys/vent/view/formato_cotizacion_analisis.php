<?php 
    //exit('<pre>'.print_r($data['cotizacionCorreos'],1).'</pre>');
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

.dot {
  height: 90px;
  width: 90px;
  padding: 10px;
  text-align:center;
  background-color: #FBD47B;
  border: 2px solid #FE8F3C;
  border-radius: 50%;
  display: inline-block;
}

</style>

<div class="col-md-9" style="background:#e3f7ec;padding:10px;border-radius:5px;">
<span style="font-size: 16px;font-weight:bold;color:#5C5C5C;margin-top:190px;">Análsis de Consumo de Energía</span>
</div>

<div class="col-md-offset-1 col-md-2">
    <div class="col-md-offset-1 col-md-12 pull-right"><img src="<?php echo IMAGE_LOGO_PDF; ?>" width="680px"/></div>
</div>

<?php 
    if(isset($data['cotizacionInformacionProducto'])){ 
        foreach ($data['cotizacionInformacionProducto'] AS $infoProductos){ 
            if(!empty($infoProductos['sDescripcionHoja2'])){
?>
    <div class="col-md-12 clearfix" style="font-size:9px;border: 1px solid #C1C3D1;border-left: 4px solid #29ACF0;border-radius:5px;padding:10px;">
        <?php echo (isset($infoProductos['sDescripcionHoja2'])) ? html_entity_decode($infoProductos['sDescripcionHoja2'],ENT_QUOTES) : ''; ?>
    </div> 
<?php
            }//ENDIF 
        }//FOREACH
    }//ENDIF 
?>

<div class="col-md-6 clearfix">
    <div class="col-md-12" style="font-size:16px;font-weight:bold;background:#5C5C5C;padding-left:5px">
    <span style="font-size:16px;font-weight:bold;color:#FFFFFF;">Resumen últimos 12 meses</span> 
    </div>

    <table>
    <tr>
        <td style="text-align:center;"><img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/money.png'; ?>" width="44px"/></td>
        <td style="text-align:center;"><img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/energy.png'; ?>" width="64px"/></td>
        <td style="text-align:center;"><img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/coin.png'; ?>" width="44px"/></td>
    <tr>
    <tr>
        <td style="text-align:center;">
            <span style="text-align:center; font-size: 12px; font-weight:bold;"><?php echo (isset($data['datos']['gastoAnual'])) ? "$".number_format($data['datos']['gastoAnual'],2) : 'N/D'; ?></span><br>
            <span style="text-align:center; font-size: 10px;">Gasto Total</span>
        </td>
        <td style="text-align:center;">
            <span style="text-align:center; font-size: 12px; font-weight:bold;"><?php echo (isset($data['datos']['consumoAnual'])) ? number_format($data['datos']['consumoAnual'],0) : 'N/D'; ?> Kwh</span><br>
            <span style="text-align:center; font-size: 10px;">Consumo Total</span>
        </td>
        <td style="text-align:center;">
            <span style="text-align:center; font-size: 12px; font-weight:bold;"><?php echo (isset($data['datos']['precioPromedio'])) ? "$".number_format($data['datos']['precioPromedio'],2) : 'N/D'; ?>/ Kwh</span><br>
            <span style="text-align:center; font-size: 10px;">Precio Promedio</span>
        </td>
    <tr>
    </table>
</div>
<!--
<div class="col-md-offset-1 col-md-5" style="text-align:center;background:#FBD47B;border-radius:10px;height:155px;padding-top:10px;">
    <span style="text-align:center; font-size: 18px;font-weight:bold;color:#000000;margin-top:190px;">$<?php echo (isset($data['datos']['gastoAnual'])) ? number_format($data['datos']['gastoAnual'],2) : 'N/D'; ?></span><br>
    <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/graph_up_color.png'; ?>" width="98px"/><br>
    <span style="text-align:center; font-size: 11px;text-decoration:underline;font-weight:bold;color:#5C5C5C;">CONSUMO TOTAL A CFE EL ÚLTIMO AÑO<span>
</div>

<div class="col-md-12 clearfix"></div>

<div class="col-md-5" style="border: 1px solid #C1C3D1;border-left: 4px solid #29ACF0;border-radius:5px;padding:10px;height:185px;">
    <div class="col-md-12">
        <span style="font-size:14px;font-weight:bold;">Propuesta Solar Future</span><br><br>
        <span style="font-size:12px;color:#000000;">
            Suficientes paneles para salir de la tarifa y mantenerte 30% por debajo del límite.
        </span>
    </div>
    <div class="col-md-12 clearfix"></div>
    <div class="col-md-6" style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">
        <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/invest_money.png'; ?>" width="64px"/><span><br>
        <span style="">Inversión Mínima<span>
    </div>
    <div class="col-md-6" style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">
        <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/ROI_hands.png'; ?>" width="64px"/><span><br>
        <span style="">Retorno de Inversión<span>
    </div>
</div>
!-->
<div class="col-md-offset-1 col-md-5" style="background:#FFFFFF;border: 1px solid #C1C3D1;border-left: 4px solid #FC5555;border-radius:5px;padding:10px;height:110px;">
    <div class="col-md-12" style="text-align:center;"> 
        <span style="font-size:14px;font-weight:bold;">Pago a CFE Con y Sin Paneles Solares</span> 
    </div>
    <div class="col-md-12 clearfix"></div>
    <div class="col-md-6" style="text-align:center;border-right: 1px solid #C1C3D1;height:100px;">
        <div class="col-md-12" style="font-size:12px;font-weight:bold;">Anual</div>
        <div class="col-md-12 clearfix"></div>
        <div class="col-md-offset-1 col-md-5" style="text-align:center;background:#FC5555;height:40px;border: 1px solid #FC5555;border-radius:5px;color:#FFFFFF;font-size:10px;font-weight:bold;">$<?php echo (isset($data['datos']['gastoAnual'])) ? number_format($data['datos']['gastoAnual'],2) : 'N/D'; ?></div>
        <div class="col-md-offset-1 col-md-5" style="text-align:center;">
            <div class="col-md-12" style="text-align:center;height:20px;"></div>
            <div class="col-md-12" style="text-align:center;background:#49C526;height:20px;border: 1px solid #49C526;border-radius:5px;color:#FFFFFF;font-size:10px;font-weight:bold;">$<?php echo !empty($data['TARIFA'][$data['datos']['TARIFA']]) ? number_format(($data['TARIFA'][$data['datos']['TARIFA']] * 12),2) : ''; ?></div>
        </div>
        <div class="col-md-6" style="font-size:10px;font-weight:normal;">SIN PANEL</div>
        <div class="col-md-6" style="font-size:10px;font-weight:normal;">CON PANEL</div>
    </div>
    <div class="col-md-offset-1 col-md-5" style="text-align:center;height:100px;">
        <div class="col-md-12" style="font-size:12px;font-weight:bold;"><?php echo (isset($data['datos']['TARIFA']) && $data['datos']['TARIFA'] == 'INDUSTRIAL') ? 'Mensual' : 'Bimestral';?></div>
        <div class="col-md-12 clearfix"></div>
        <div class="col-md-offset-1 col-md-6" style="text-align:center;">
            <div class="col-md-12" style="text-align:center;height:10px;"></div>
            <div class="col-md-12" style="text-align:center;background:#FC5555;height:30px;border: 1px solid #FC5555;border-radius:5px;color:#FFFFFF;font-size:10px;font-weight:bold;">$<?php echo (isset($data['datos']['fCostoRecibo'])) ? number_format($data['datos']['fCostoRecibo'],2) : 'N/D'; ?></div>
        </div>
        <div class="col-md-offset-1 col-md-5" style="text-align:center;">
            <div class="col-md-12" style="text-align:center;height:20px;"></div>
            <div class="col-md-12" style="text-align:center;background:#49C526;height:20px;border: 1px solid #49C526;border-radius:5px;color:#FFFFFF;font-size:10px;font-weight:bold;">$<?php echo !empty($data['TARIFA'][$data['datos']['TARIFA']]) ? number_format($data['TARIFA'][$data['datos']['TARIFA']],2) : ''; ?></div>
        </div>
        <div class="col-md-6" style="font-size:10px;font-weight:normal;">SIN PANEL</div>
        <div class="col-md-6" style="font-size:10px;font-weight:normal;">CON PANEL</div>
    </div>
</div>

<div class="col-md-12 clearfix">
    <div class="col-md-12" style="font-size:16px;font-weight:bold;background:#5C5C5C;padding-left:5px">
    <span style="font-size:16px;font-weight:bold;color:#FFFFFF;">Análisis de la Inversión</span>
    </div>

    <table>
    <tr>
        <td style="text-align:center;"><img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/bills.png'; ?>" width="64px"/></td>
        <td style="text-align:center;"><img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/ROI_hand.png'; ?>" width="64px"/></td>
        <td style="text-align:center;"><img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/calendar.png'; ?>" width="64px"/></td>
        <td style="text-align:center;"><img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/savings.png'; ?>" width="64px"/></td>
    <tr>
    <tr>
        <td style="text-align:center;">
            <span style="text-align:center; font-size: 14px; font-weight:bold;">$<?php echo (isset($data['datos']['fImporteTotal'])) ? number_format($data['datos']['fImporteTotal'],2) : 'N/D'; ?></span><br>
            <span style="text-align:center; font-size: 12px;">Monto Total</span>
        </td>
        <td style="text-align:center;">
            <span style="text-align:center; font-size: 14px; font-weight:bold;"><?php echo (isset($data['datos']['recuperacionInversion'])) ? ($data['datos']['recuperacionInversion']) : 'N/D'; ?> Años</span><br>
            <span style="text-align:center; font-size: 12px;">Retorno de Inversión</span>
        </td>
        <td style="text-align:center;">
            <span style="text-align:center; font-size: 14px; font-weight:bold;">25</span><br>
            <span style="text-align:center; font-size: 12px;">Años Garantizados</span>
        </td>
        <td style="text-align:center;">
            <span style="text-align:center; font-size: 14px; font-weight:bold;"><?php echo (isset($data['datos']['porcentajeAnualCubierto'])) ? number_format($data['datos']['porcentajeAnualCubierto'],2) : 'N/D'; ?>%</span><br>
            <span style="text-align:center; font-size: 12px;">Ahorro del primer año</span>
        </td>
    <tr> 
    </table>
</div>

<div class="col-md-12 clearfix"></div>

<div class="col-md-12" style="border: 1px solid #C1C3D1;border-left: 4px solid #5C5C5C;border-radius:5px;padding:10px;height:185px;">
    <div class="col-md-7" style="border-right: 2px solid #C1C3D1;">
        <div class="col-md-12">
            <span style="font-size:14px;font-weight:bold;">Instalación Solar</span><br><br>
        </div>
        <div class="col-md-12 clearfix"></div>
        <div class="col-md-4" style="text-align:center;">
            <div class="dot">
                <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/energy_circle.png'; ?>" width="50px"/><span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">Capacidad<span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:normal;"><?php echo (isset($data['datos']['capacidad'])) ? number_format($data['datos']['capacidad'],2) : 'N/D'; ?>kW<span>
            </div>
        </div>
        <div class="col-md-4" style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">
            <div class="dot">
                <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/solar_panel.png'; ?>" width="50px"/><span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">Paneles<span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:normal;"><?php echo (isset($data['datos']['cantidadPanel'])) ? number_format($data['datos']['cantidadPanel'],0) : '0'; ?> <span>
            </div>
        </div>
        <div class="col-md-4" style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">
            <div class="dot">
                <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/roof.png'; ?>" width="64px"/><span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">Instalación<span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:normal;"><?php echo (isset($data['datos']['metros2'])) ? number_format($data['datos']['metros2'],0) : '0'; ?> m2<span>
            </div>
        </div>
    </div>
    <div class="col-md-offset-1 col-md-4">
        <div class="col-md-12">
            <span style="font-size:14px;font-weight:bold;">Producción Solar</span><br><br>
        </div>
        <div class="col-md-12 clearfix"></div>
        <div class="col-md-6" style="border-text-align:center; font-size: 10px;color:#000000;font-weight:bold;">
            <div class="dot">
                <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/battery.png'; ?>" width="40px"/><span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">Energía Producida Mensualmente<span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:normal;"><?php echo (isset($data['datos']['produccionMensual'])) ? number_format($data['datos']['produccionMensual'],0) : 'N/D'; ?> kW<span>
            </div>
        </div>
        <div class="col-md-offset-1 col-md-6" style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">
            <div class="dot">
                <img src="<?php echo ASSETS_PATH . 'assets/custom/img/icons/renewable_energy.png'; ?>" width="50px"/><span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:bold;">Consumo Total<span><br>
                <span  style="text-align:center; font-size: 10px;color:#000000;font-weight:normal;"><?php echo (isset($data['datos']['porcentajeAnualCubierto'])) ? number_format($data['datos']['porcentajeAnualCubierto'],2) : 'N/D'; ?>%<span>
            </div>
        </div>
    </div>
</div>