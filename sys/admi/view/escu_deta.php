<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<div class="page-profile">

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Panel -->
                <div class="panel">
                    <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
			<ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
			   <li class="active" role="presentation"><a data-toggle="tab" href="#publicUserProfile" aria-controls="publicUserProfile" role="tab" aria-expanded="true">Detalles Empresa Socio</a></li>
                <li  role="presentation" class=""><a data-toggle="tab" href="#estadoCuenta" aria-controls="estadoCuenta" role="tab" aria-expanded="false">Estado de Cuenta</a></li>
                             <li class="dropdown" role="presentation" style="display: none;">
                            <li class="dropdown" role="presentation" style="display: none;">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <span class="caret"></span>Menu </a>
                                <ul class="dropdown-menu" role="menu">
                    <li role="presentation" style="display: none;"><a data-toggle="tab" href="#publicUserProfile" aria-controls="publicUserProfile" role="tab">Detalles Empresa Socio <span class="badge label-danger">5</span></a></li>
                    <li  role="presentation" class=""><a data-toggle="tab" href="#estadoCuenta" aria-controls="estadoCuenta" role="tab" aria-expanded="false">Estado de Cuenta</a></li>
                                     <!--<li role="presentation"><a data-toggle="tab" href="#messages" aria-controls="messages" role="tab">Messages</a></li>-->
                                </ul>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active animation-slide-left" id="publicUserProfile" role="tabpanel">
                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <br>
                                        </div>
					<div class="col-md-12">
                                            <label class="col-md-2"><b>Nombre:</b> </label>
                                            <div class="col-md-4">
                                                <label><?php echo (($result['sNombre'] != "")) ? $result['sNombre'] : 'N/D'; ?></label>
                                            </div>
					    <label class="col-md-2"><b>Nombre corto:</b> </label>
                                            <div class="col-md-4">
                                                <label><?php echo (($result['sNombreCorto'] != "")) ? $result['sNombreCorto'] : 'N/D'; ?></label>
                                            </div>
                                        </div>
					<div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="col-md-2"><b>RFC:</b> </label>
                                            <div class="col-md-4">
                                                <label><?php echo (($result['sRFC'] != "")) ? $result['sRFC'] : 'N/D'; ?></label>
                                            </div>
                                            <label class="col-md-2"><b>Estatus:</b> </label>
                                            <div class="col-md-4">
						<label><?php echo (($result['skEstatus'] != "")) ? $result['skEstatus'] : 'N/D'; ?></label>
					    </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="col-md-2"><b>Tipo empresa:</b> </label>
                                            <div class="col-md-4">
						<?php echo (($result['nombreTipo'] != "")) ? $result['nombreTipo'] : 'N/D'; ?>
                                            </div>
                                            <label class="col-md-2"><b>Fecha Creación:</b> </label>
                                            <div class="col-md-4">
						<?php echo (($result['dFechaCreacion'] != "" )) ? $result['dFechaCreacion'] : 'N/D'; ?>
                                            </div>
                                        </div>
				    </div>
                                </div>
                            </div>
                                <!-- tab estados de cuenta-->
                                <div class="tab-pane animation-slide-left" id="estadoCuenta" role="tabpanel">
                                    <div class="container" >
                                    <br><br>
                                        <div class="row" >
                                                <button class="btn btn-warning" id="btn_facturasPendientes"><i class="icon fa fa-clock-o"></i>Facturas Pendientes</button>
                                                <button class="btn btn-success" id="btn_facturasPagadas"><i class="icon fa fa-check"></i>Facturas Pagadas</button>
                                                <button class="btn btn-danger" id="btn_facturasCanceladas"><i class="icon fa fa-ban"></i>Facturas Cancelar</button>

                                            <div style="" id="facturasPendientes">
                                                <br>
                                                <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
                                                    <input id="filter_facturaPendiente" type="text" class="form-control" autocomplete="off" placeholder="Escribe aquí...">
                                                </div>
                                                <div class="" style="height: 400px;overflow-x:hidden; overflow-y:scroll; width: 100%;">
                                                <table class="table table-bordered table-hover table-default table-responsive">
                                                    <thead>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Estatus">E
                                                                </span>'; ?></th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Estatus Pago">EP
                                                                </span>'; ?></th>
                                                        <th>Folio</th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Fecha Factura">F. Factura
                                                                </span>'; ?></th>
                                                        
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Método de Pago">M. Pago
                                                                </span>'; ?></th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Forma de Pago">F. Pago
                                                                </span>'; ?></th>
                                                        <th>Usos CFDI</th>
                                                        <th>Responsable</th>
                                                        <th>Total</th>
                                                        <th>Saldo</th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Fecha de Creación">F. Creación
                                                                </span>'; ?></th>
                                                    </thead>
                                                    <tbody class="searchable2">
                                                        <?php
                                                        if(isset($data['facturasPendientes']) && !empty($data['facturasPendientes'])){
                                                            foreach ($data['facturasPendientes'] AS $value) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo !empty($value['skEstatus']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['estatus'].'">'.'
                                                                </span><span data-toggle="tooltip" data-placement="top" title="'.$value['estatus'].'">
                                                                <i class="icon '.$value['estatusColor'].' '.$value['estatusIcono'].'" aria-hidden="true"></i></span>': $value['skEstatus']; ?></td>
                                                                <td><?php echo !empty($value['skEstatusPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['estatusPago'].'">'.'
                                                                </span><span data-toggle="tooltip" data-placement="top" title="'.$value['estatusPago'].'">
                                                                <i class="icon '.$value['estatusPagoColor'].' '.$value['estatusPagoIcono'].'" aria-hidden="true"></i></span>': $value['skEstatusPago']; ?></td>
                                                                <td><?php echo !empty($value['iFolio']) ? $value['iFolio'] :''; ?></td>
                                                                <td><?php echo !empty($value['dFechaFacturacion']) ? date('d/m/Y  H:i:s', strtotime($value['dFechaFacturacion'])) :''; ?></td>
                                                                
                                                                <td><?php echo !empty($value['metodoPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreMetodoPago'].'">'.$value['metodoPago'].'
                                                                </span>': $value['metodoPago']; ?></td>
                                                                <td><?php echo !empty($value['formaPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreFormaPago'].'">'.$value['formaPago'].'
                                                                </span>': $value['formaPago']; ?></td>
                                                                <td><?php echo !empty($value['usoCFDI']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreCFDI'].'">'.$value['usoCFDI'].'
                                                                </span>': $value['usoCFDI']; ?></td>
                                                                <td><?php echo !empty($value['responsable']) ? $value['responsable'] :''; ?></td>
                                                                <td><?php echo !empty($value['fTotal']) ? $value['fTotal'] :''; ?></td>
                                                                <td><?php echo !empty($value['fSaldo']) ? $value['fSaldo'] :''; ?></td>
                                                                <td><?php echo !empty($value['dFechaCreacion']) ?  date('d/m/Y  H:i:s', strtotime($value['dFechaCreacion'])) :''; ?></td>
                                                             </tr>
                                                            <?php
                                                            }
                                                        }
                                                            ?>
                                                    </tbody>
                                                </table></div>
                                            </div>

                                            <div style="display: none;"  id="facturasPagadas">
                                                <br>
                                                <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
                                                    <input id="filter_facturaPagada" type="text" class="form-control" autocomplete="off" placeholder="Escribe aquí...">
                                                </div>
                                                <div class="" style="height: 400px;overflow-x:hidden; overflow-y:scroll; width: 100%;">
                                                <table class="table table-bordered table-hover table-default table-responsive">
                                                    <thead>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Estatus">E
                                                                </span>'; ?></th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Estatus Pago">EP
                                                                </span>'; ?></th>
                                                        <th>Folio</th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Fecha Factura">F. Factura
                                                                </span>'; ?></th>
                                                        
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Método de Pago">M. Pago
                                                                </span>'; ?></th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Forma de Pago">F. Pago
                                                                </span>'; ?></th>
                                                        <th>Usos CFDI</th>
                                                        <th>Responsable</th>
                                                        <th>Total</th>
                                                        <th>Saldo</th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Fecha de Creación">F. Creación
                                                                </span>'; ?></th>
                                                    </thead>
                                                    <tbody class="searchable3">

                                                            <?php
                                                        if(isset($data['facturasPagadas']) && !empty($data['facturasPagadas'])){
                                                            foreach ($data['facturasPagadas'] AS $value) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo !empty($value['skEstatus']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['estatus'].'">'.'
                                                                </span><span data-toggle="tooltip" data-placement="top" title="'.$value['estatus'].'">
                                                                <i class="icon '.$value['estatusColor'].' '.$value['estatusIcono'].'" aria-hidden="true"></i></span>': $value['skEstatus']; ?></td>
                                                                <td><?php echo !empty($value['skEstatusPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['estatusPago'].'">'.'
                                                                </span><span data-toggle="tooltip" data-placement="top" title="'.$value['estatusPago'].'">
                                                                <i class="icon '.$value['estatusPagoColor'].' '.$value['estatusPagoIcono'].'" aria-hidden="true"></i></span>': $value['skEstatusPago']; ?></td>
                                                                <td><?php echo !empty($value['iFolio']) ? $value['iFolio'] :''; ?></td>
                                                                <td><?php echo !empty($value['dFechaFacturacion']) ? date('d/m/Y  H:i:s', strtotime($value['dFechaFacturacion'])) :''; ?></td>
                                                                
                                                                <td><?php echo !empty($value['metodoPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreMetodoPago'].'">'.$value['metodoPago'].'
                                                                </span>': $value['metodoPago']; ?></td>
                                                                <td><?php echo !empty($value['formaPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreFormaPago'].'">'.$value['formaPago'].'
                                                                </span>': $value['formaPago']; ?></td>
                                                                <td><?php echo !empty($value['usoCFDI']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreCFDI'].'">'.$value['usoCFDI'].'
                                                                </span>': $value['usoCFDI']; ?></td>
                                                                <td><?php echo !empty($value['responsable']) ? $value['responsable'] :''; ?></td>
                                                                <td><?php echo !empty($value['fTotal']) ? $value['fTotal'] :''; ?></td>
                                                                <td><?php echo !empty($value['fSaldo']) ? $value['fSaldo'] :''; ?></td>
                                                                <td><?php echo !empty($value['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($value['dFechaCreacion'])) :''; ?></td>
                                                             </tr>
                                                            <?php
                                                            }
                                                        }
                                                            ?>

                                                    </tbody>
                                                </table></div>
                                            </div>

                                            <div style="display: none;"  id="facturasCanceladas">
                                                <br>
                                                <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
                                                    <input id="filter_facturaCancelada" type="text" class="form-control" autocomplete="off" placeholder="Escribe aquí...">
                                                </div>
                                                <div class="" style="height: 400px;overflow-x:hidden; overflow-y:scroll; width: 100%;">
                                                <table class="table table-bordered table-hover table-default table-responsive">
                                                    <thead>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Estatus">E
                                                                </span>'; ?></th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Estatus Pago">EP
                                                                </span>'; ?></th>
                                                        <th>Folio</th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Fecha Factura">F. Factura
                                                                </span>'; ?></th>
                                                        
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Método de Pago">M. Pago
                                                                </span>'; ?></th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Forma de Pago">F. Pago
                                                                </span>'; ?></th>
                                                        <th>Usos CFDI</th>
                                                        <th>Responsable</th>
                                                        <th>Total</th>
                                                        <th>Saldo</th>
                                                        <th><?php echo '<span data-toggle="tooltip" data-placement="top" title="Fecha de Creación">F. Creación
                                                                </span>'; ?></th>
                                                    </thead>
                                                    <tbody class="searchable4">
                                                        <?php
                                                        if(isset($data['facturasCanceladas']) && !empty($data['facturasCanceladas'])){
                                                            foreach ($data['facturasCanceladas'] AS $value) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo !empty($value['skEstatus']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['estatus'].'">'.'
                                                                </span><span data-toggle="tooltip" data-placement="top" title="'.$value['estatus'].'">
                                                                <i class="icon '.$value['estatusColor'].' '.$value['estatusIcono'].'" aria-hidden="true"></i></span>': $value['skEstatus']; ?></td>
                                                                <td><?php echo !empty($value['skEstatusPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['estatusPago'].'">'.'
                                                                </span><span data-toggle="tooltip" data-placement="top" title="'.$value['estatusPago'].'">
                                                                <i class="icon '.$value['estatusPagoColor'].' '.$value['estatusPagoIcono'].'" aria-hidden="true"></i></span>': $value['skEstatusPago']; ?></td>
                                                                <td><?php echo !empty($value['iFolio']) ? $value['iFolio'] :''; ?></td>
                                                                <td><?php echo !empty($value['dFechaFacturacion']) ? date('d/m/Y  H:i:s', strtotime($value['dFechaFacturacion'])) :''; ?></td>
                                                                
                                                                <td><?php echo !empty($value['metodoPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreMetodoPago'].'">'.$value['metodoPago'].'
                                                                </span>': $value['metodoPago']; ?></td>
                                                                <td><?php echo !empty($value['formaPago']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreFormaPago'].'">'.$value['formaPago'].'
                                                                </span>': $value['formaPago']; ?></td>
                                                                <td><?php echo !empty($value['usoCFDI']) ? '<span data-toggle="tooltip" data-placement="top" title="'.$value['nombreCFDI'].'">'.$value['usoCFDI'].'
                                                                </span>': $value['usoCFDI']; ?></td>
                                                                <td><?php echo !empty($value['responsable']) ? $value['responsable'] :''; ?></td>
                                                                <td><?php echo !empty($value['fTotal']) ? $value['fTotal'] :''; ?></td>
                                                                <td><?php echo !empty($value['fSaldo']) ? $value['fSaldo'] :''; ?></td>
                                                                <td><?php echo !empty($value['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($value['dFechaCreacion']))  :''; ?></td>
                                                             </tr>
                                                            <?php
                                                            }
                                                        }
                                                            ?>
                                                    </tbody>
                                                </table></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                 
                            </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</div>

<!-- ¨************************************************************************* -->

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script>
    $(document).ready(function () {
        $('#mowi').iziModal('setBackground', '#f1f4f5');
    	$('#filter').keyup(function () {
    	    var rex = new RegExp($(this).val(), 'i');
    	    $('.searchable tr td').hide();
    	    $('.searchable tr td').filter(function () {
    		return rex.test($(this).text());
    	    }).show();
    	});

        $('#filter_facturaPendiente').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable2 tr').hide();
            $('.searchable2 tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

        $('#filter_facturaPagada').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable3 tr').hide();
                $('.searchable3 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            });

        $('#filter_facturaCancelada').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable4 tr').hide();
            $('.searchable4 tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

        $('#filterProductos').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchableProductos tr').hide();
            $('.searchableProductos tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

        $('#btn_facturasPendientes').click(function () {
            $("#facturasPendientes").fadeIn();
            $("#facturasCanceladas").hide();
            $("#facturasPagadas").hide();
        });

        $('#btn_facturasCanceladas').click(function () {
            $("#facturasPendientes").hide();
            $("#facturasCanceladas").fadeIn();
            $("#facturasPagadas").hide();
        });

        $('#btn_facturasPagadas').click(function () {
            $("#facturasPendientes").hide();
            $("#facturasCanceladas").hide();
            $("#facturasPagadas").fadeIn();
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
