<?php 

$Date = date('Y-m-d');
$fechaVigencia = date('d/m/Y', strtotime($Date. ' + 15 days'));

if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}

$arrayInformacionProducto = array();

if (isset($data['cotizacionInformacionProducto'])) {
    if ($data['cotizacionInformacionProducto']) {
        foreach ($data['cotizacionInformacionProducto'] as $row) {
            $arrayInformacionProducto[] = $row['skInformacionProductoServicio'];
        }
    }
}
$arrayterminoCondicion = array();

if (isset($data['cotizacionTerminosCondiciones'])) {
    if ($data['cotizacionTerminosCondiciones']) {
        foreach ($data['cotizacionTerminosCondiciones'] as $row) {
            $arrayterminoCondicion[] = $row['skCatalogoSistemaOpciones'];
        }
    }
}
 
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
<input value="<?php echo (!empty($result['skCotizacion']) ? $result['skCotizacion'] : '');?>" name="skCotizacion" id="skCotizacion"  type="hidden">

    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos Generales</h3>
        </div>
        <div class="panel-body container-fluid">
                  <div class="row row-lg col-lg-12">
                
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger">*</b> CLIENTE:</h4>
                            <select name="skEmpresaSocioCliente" id="skEmpresaSocioCliente" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                                <?php
                                if (!empty($result['skEmpresaSocioCliente'])) {
                                    ?>
                                    <option value="<?php echo $result['skEmpresaSocioCliente']; ?>" selected="selected"><?php echo $result['cliente'] . ' (' . $result['clienteRFC'] . ')'; ?></option>
                                    <?php
                                }//ENDIF
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">NOMBRE CLIENTE:</h4>
                            <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="sNombreCliente" id="sNombreCliente" value="<?php echo (isset($result['sNombreCliente'])) ? $result['sNombreCliente'] : ''; ?>" placeholder="NOMBRE CLIENTE" autocomplete="off" type="text">
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-12 clearfix"></div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>DIRECCIÓN:</h4>
                            <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="sDireccion" id="sDireccion" value="<?php echo (isset($result['sDireccion'])) ? $result['sDireccion'] : ''; ?>" placeholder="DIRECCIÓN" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>RPU:</h4>
                            <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="sRPU" value="<?php echo (isset($result['sRPU'])) ? $result['sRPU'] : ''; ?>" placeholder="RPU" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>TELÉFONO:</h4>
                            <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="sTelefono" id="sTelefono" value="<?php echo (isset($result['sTelefono'])) ? $result['sTelefono'] : ''; ?>" placeholder="TELÉFONO" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12"><hr></div>

                  <div class="col-md-4 col-lg-4">
                         <div class="form-group">
                             <h4 class="example-title">MONEDA <span class="required text-danger">*</span></h4>
                             <select id="skDivisa"  name="skDivisa" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">Seleccionar</option>
                                 <?php
                                 if ($data['divisas']) {
                                 foreach (  $data['divisas'] as $row) {
                                     utf8($row);
                                     ?>
                                     <option <?php echo(isset($result['skDivisa']) && $result['skDivisa'] == $row['skDivisa'] ? 'selected="selected"' : (!isset($result['skDivisa']) && $row['skDivisa'] == 'MXN' ? 'selected="selected"' : '')); ?>
                                         value="<?php echo $row['skDivisa']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                     </div>
                     <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                             <h4 class="example-title">CATEGORÍA <span class="required text-danger">*</span></h4>
                             <select id="skCategoriaPrecio"  name="skCategoriaPrecio" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">Seleccionar</option>
                                 <?php
                                 if ($data['categoria']) {
                                 foreach (  $data['categoria'] as $row) {
                                     utf8($row);
                                     ?>
                                     <option <?php echo(isset($result['skCategoriaPrecio']) && $result['skCategoriaPrecio'] == $row['skCategoriaPrecio'] ? 'selected="selected"' : (!isset($result['skCategoriaPrecio']) && $row['skCategoriaPrecio'] == 'a9ee53c7-546e-11eb-8849-44a8422a117f' ? 'selected="selected"' : '')) ?>
                                         value="<?php echo $row['skCategoriaPrecio']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                   </div>
                   <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title">VIGENCIA </h4>
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="wb-calendar" aria-hidden="true"></i>
                              </span>
                              <input class="form-control input-datepicker" id="dFechaVigencia" name="dFechaVigencia" value="<?php echo (!empty($result['dFechaVigencia']) ? date('d/m/Y', strtotime($result['dFechaVigencia'])) : $fechaVigencia); ?>" placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                          </div>
                      </div>
                   </div>

                              
                                
                  </div>
                  
                 <div class="row row-lg col-lg-12">
                     <hr>
                 </div>
                 
                 
                 <div class="row row-lg col-lg-12">
                    <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                             <h4 class="example-title"> OBSERVACIONES DE COTIZACIÓN  
                             <i class="icon wb-help-circle help-text" aria-hidden="true"
                                    data-content="OBSERVACIONES DE COTIZACIÓN (APARECEN EN LA COTIZACIÓN DEBAJO DE LOS PRODUCTOS)"
                                    data-trigger="hover"></i></h4>
                             <textarea class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="sCondicion" placeholder="Condicion"><?php echo (isset($result['sCondicion'])) ? ($result['sCondicion']) : ''; ?></textarea>
                         </div>
                     </div>
                     <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                             <h4 class="example-title"> OBSERVACIONES INTERNAS   
                             <i class="icon wb-help-circle help-text" aria-hidden="true"
                                    data-content="OBSERVACIONES INTERNAS (NO APARECEN EN LA COTIZACIÓN)"
                                    data-trigger="hover"></i></h4>
                             <textarea class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="sObservaciones" placeholder="Descripcion de la Cotizacion"><?php echo (isset($result['sObservaciones'])) ? ($result['sObservaciones']) : ''; ?></textarea>
                         </div>
                     </div>
                 </div>
                 <div class="row row-lg col-lg-12">
                     <hr>
                 </div>
                 <div class="row row-lg col-lg-12">
                    <h5 class="card-title margin-bottom-20">
                    
                    <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" name="iInformacionPanel"  <?php echo (isset($result['iInformacionPanel']) && !empty($result['iInformacionPanel']) ) ? 'checked' : ''; ?> value="1" id="iInformacionPanel"    />
                                    <label for="iInformacionPanel">Informacion adicional de Panel Solar</label>
                    </div>
                        
                        
                        
                    </h5>
                 </div>
                 <div class="row row-lg col-lg-12">
                 
                 <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                        <h4 class="example-title">Kw Gastados: <i
                                    class="icon wb-help-circle help-text" aria-hidden="true"
                                    data-content="Promedio de Kw gastados por bimestre"
                                    data-trigger="hover"></i></h4>
                        <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="fKwGastados" value="<?php echo (isset($result['fKwGastados'])) ? $result['fKwGastados'] : ''; ?>" placeholder="KW Gastados" autocomplete="off" type="text" >

                    </div>
                </div>
                 <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                        <h4 class="example-title">COSTO RECIBO: <i
                                    class="icon wb-help-circle help-text" aria-hidden="true"
                                    data-content="Capturar el costo promedio del recibo Bimestral (Residencial / Comercial) ó Costo Mensual (Industrial)"
                                    data-trigger="hover"></i></h4>
                        <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="fCostoRecibo" value="<?php echo (isset($result['fCostoRecibo'])) ? $result['fCostoRecibo'] : '0'; ?>" placeholder="COSTO RECIBO" autocomplete="off" type="text" >

                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                        <h4 class="example-title">TARIFA DE CFE:</h4>
                            <select id="TARIFA"  name="TARIFA" class="form-control" data-plugin="select2" select2Simple>
                                 <option value="">- SELECCIONAR -</option>
                                 <?php
                                 if ($data['TARIFA']) {
                                 foreach ($data['TARIFA'] AS $k=>$v) {
                                     ?>
                                     <option <?php echo(isset($result['TARIFA']) && $result['TARIFA'] == $k ? 'selected="selected"' : ''); ?>
                                         value="<?php echo $k; ?>"><?php echo $k; ?> $<?php echo number_format($v,2); ?></option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                        </div>
                    </div>


                 </div>
                 <div class="row row-lg col-lg-12">
                     <hr>
                 </div>
                 <div class="row row-lg col-lg-12">
                     <div class="col-md-12 col-lg-12">
                         <div class="form-group">
                             <h4 class="example-title"> Correos</h4>
                             <select name="sCorreos[]" id="sCorreos" class="form-control select2"  autocomplete="off" multiple="multiple" data-plugin="select2">
                        <?php
                            if (isset($data['cotizacionesCorreos'])){
                                foreach ($data['cotizacionesCorreos'] as $row){
                                ?>

                                <option  value="<?php echo $row['sCorreo']; ?>"><?php echo $row['sCorreo']; ?></option>

                                <?php
                            }//ENDFOREACH
                            }//ENDIF
                            ?>
                        </select>                         </div>
                     </div>
                 </div>
                 <div class="row row-lg col-lg-12">
                    <div class=" col-md-12">
                    <div class="form-group">
                    <h4 class="example-title"> INFORMACION PRODUCTO:</h4>
                        <?php
                        if (isset($data['informacionProducto'])) {


                            foreach ($data['informacionProducto'] as $val) { ?>
                                <div class="col-md-4 checkbox-custom checkbox-primary">
                                    <input type="checkbox" name="skInformacionProductosServicios[]"  <?php echo (in_array($val['skInformacionProductoServicio'], $arrayInformacionProducto) ? 'checked' : '') ?>   value="<?php echo (isset($val['skInformacionProductoServicio'])) ? ($val['skInformacionProductoServicio']) : ''; ?>" id="<?php echo (isset($val['skInformacionProductoServicio'])) ? ($val['skInformacionProductoServicio']) : ''; ?>"    />
                                    <label for="<?php echo (isset($val['skInformacionProductoServicio'])) ? ($val['skInformacionProductoServicio']) : ''; ?>"><?php echo (isset($val['informacionProducto'])) ? ($val['informacionProducto']) : ''; ?></label>
                                </div>
                            <?php  }

                        }
                        ?>

                    </div>
                    </div>
                </div>

                <!--
                <div class="row row-lg col-lg-12">
                     <hr>
                 </div>
                <div class="row row-lg col-lg-12">
                    <div class=" col-md-12">
                    <div class="form-group">
                    <h4 class="example-title"> TERMINOS CONDICIONES:</h4>
                        <?php
                        if (isset($data['terminosCondiciones'])) {


                            foreach ($data['terminosCondiciones'] as $val) { ?>
                                <div class="col-md-12 checkbox-custom checkbox-primary">
                                    <input type="checkbox" name="terminosCondiciones[]"  <?php echo (in_array($val['skCatalogoSistemaOpciones'], $arrayterminoCondicion) ? 'checked' : '') ?>   value="<?php echo (isset($val['skCatalogoSistemaOpciones'])) ? ($val['skCatalogoSistemaOpciones']) : ''; ?>" id="<?php echo (isset($val['skCatalogoSistemaOpciones'])) ? ($val['skCatalogoSistemaOpciones']) : ''; ?>"    />
                                    <label for="<?php echo (isset($val['skCatalogoSistemaOpciones'])) ? ($val['skCatalogoSistemaOpciones']) : ''; ?>"><?php echo (isset($val['terminoCondicion'])) ? ($val['terminoCondicion']) : ''; ?></label>
                                </div>
                            <?php  }

                        }
                        ?>

                    </div>
                    </div>
                </div>
                !-->
                 
                 
                </div>
            </div>
     
<div class="panel panel-bordered panel-primary panel-line">
    <div class="panel-heading">
        <div class="panel-actions">
            <button type="button" class="btn btn-outline btn-success pull-right" id="concepto-agregar">
                <i class="icon wb-plus" aria-hidden="true"></i> Agregar
            </button>
        </div>
        <h3 class="panel-title">servicios</h3>
    </div>
    <div class="panel-body container-fluid">

    <div class="table-responsive clearfix" id="servicios" style="overflow-y:visible;font-size: 10pt;">
            <div class="col-md-12">
                <div class="col-md-1 col-lg-1">
                    <div class="form-group">
                        <h4 class="example-title">Descuento</h4>
                     </div>
                 </div>
                 <div class="col-md-1">
                         <div class="radio-custom radio-primary ">
                            <input type="radio" class="descuento" id="inputPorcentaje" name="descuento" value="porc" />
                            <label for="inputPorcentaje">Porcentaje</label>
                          </div>
                </div>
                <div class="col-md-1">
                        <div class="radio-custom radio-primary ">
                           <input type="radio" class="descuento" id="inputCantidad" name="descuento" value="cant" />
                           <label for="inputCantidad">Cantidad</label>
                         </div>
               </div>
               <div class="col-md-1">
               <input type="text" name="descuentoAplicar" id="descuentoAplicar" class="form-control " >
                </div>
               <label onclick="aplicarDescuento();" class="col-md-1 btn btn-outline btn-success">Aplicar</label>

            </div>
            <table class="table table-striped table-bordered" id="servicios">
                <thead>
                    <tr>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Unidad</th>
                        <th class="col-lg-4 col-md-4 col-xs-4 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Concepto</th>
                        <th class="col-xs-2 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Descripción</th>
                        <th class="col-xs-2 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Cantidad</th>
                        <th class="col-xs-2  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> P. Unitario</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">Importe</th>
                        <th class="col-xs-1 col-md-1 text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="searchable" id="servicios-body">

                        <?php
                        if (isset($data['cotizacionesServicios'])){
                            $cont = 1;
                            foreach ($data['cotizacionesServicios'] as $row){ ?>


                            <tr> 
                                <td>
                                    <select name="servicios[<?php echo $cont; ?>][skTipoMedida]" class="skTipoMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skTipoMedida']) ? $row['skTipoMedida'] : ''); ?>"><?php echo (isset($row['tipoMedida']) ? $row['tipoMedida'] : ''); ?></option>
                                    </select>
                                </td>
                                <td style="min-width:350px;max-width:350px;">
                                    <select style="min-width:500px;max-width:500px;" name="servicios[<?php echo $cont; ?>][skServicio]" onchange="obtenerDatos(this);" class="skServicio form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skServicio']) ? $row['skServicio'] : ''); ?>"><?php echo (isset($row['servicio']) ? $row['servicio'] : ''); ?></option>
                                    </select>
                                </td>
                                <td><input class="form-control" value="<?php echo (isset($row['sDescripcion']) ? $row['sDescripcion'] : '');?>"   name="servicios[<?php echo $cont; ?>][sDescripcion]" placeholder="Descripción" autocomplete="off" type="text"></td>
                                <td><input class="form-control" style="min-width:100px;max-width:100px;" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo (isset($row['fCantidad']) ? number_format($row['fCantidad'],2) : '');?>"  onchange="actualizarImporte(this);" name="servicios[<?php echo $cont; ?>][fCantidad]" placeholder="Cantidad" autocomplete="off" type="text"></td>
                                <td><input class="form-control" style="min-width:100px;max-width:100px;" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo  (isset($row['fPrecioUnitario']) ? str_replace(',','', number_format($row['fPrecioUnitario'],2)) : '');?>"  onchange="actualizarImporte(this);" name="servicios[<?php echo $cont; ?>][fPrecioUnitario]" placeholder="P. Unitario" autocomplete="off" type="text"></td>
                                <td><input class="form-control" value="<?php echo $row['fImporte'];?>" name="servicios[<?php echo $cont; ?>][fImporte]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImporte']) ? str_replace(',','',number_format($row['fImporte'],2)) : ''); ?> </label>  </td>
                                <td><button type="button" class="btn btn-outline btn-danger pull-right concepto-eliminar" onclick="eliminarConcepto(this);"><i class="icon wb-trash" aria-hidden="true"></i> Eliminar</button></td>
                            </tr>
                            <?php $cont++; }
                        } ?>




                </tbody>
            </table>


        </div>
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group pull-right">
              <label class="control-label">Subtotal</label>
              <label  disabled class="form-control input-sm" id="dinSubtotal"  > <?php echo (!empty($result['fImporteSubtotal'])) ? number_format($result['fImporteSubtotal'],2) : ''; ?></label>
              <input type="hidden"  id="inSubtotal" name="fImporteSubtotal"  value="<?php echo (isset($result['fImporteSubtotal'])) ? $result['fImporteSubtotal'] : ''; ?>" />
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group pull-right">
              <label class="control-label">Descuento</label>
              <label type="text" disabled class="form-control input-sm" id="dinDescuento"><?php echo (!empty($result['fDescuento'])) ? number_format($result['fDescuento'],2) : ''; ?> </label>
              <input type="hidden"  id="inDescuento" name="fDescuento" value="<?php echo (isset($result['fDescuento'])) ? $result['fDescuento'] : ''; ?>"  />
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group pull-right">
              <label class="control-label">Traslados</label>
              <label type="text" disabled class="form-control input-sm" id="dinImpuestoTrasladado"><?php echo (!empty($result['fImpuestosTrasladados'])) ? number_format($result['fImpuestosTrasladados'],2) : ''; ?></label>
              <input type="hidden"  id="inImpuestoTrasladado" name="fImpuestosTrasladados" value="<?php echo (isset($result['fImpuestosTrasladados'])) ? $result['fImpuestosTrasladados'] : ''; ?>"  />
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="form-group pull-right">
              <label class="control-label">Total</label>
              <label type="text" disabled class="form-control input-sm" id="dinTotal"><?php echo (!empty($result['fImporteTotal'])) ? number_format($result['fImporteTotal'],2) : ''; ?></label>
              <input type="hidden"  id="inTotal" name="fImporteTotal" value="<?php echo (isset($result['fImporteTotal'])) ? $result['fImporteTotal'] : ''; ?>"  />
            </div>
        </div>
            
    </div>
</div>


</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    core.formValidaciones.fields = vent.coti_form.validaciones;

    function filterFloat(evt,input){

// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
var key = window.Event ? evt.which : evt.keyCode;
  var chark = String.fromCharCode(key);
var tempValue = input.value+chark;
//console.log(evt.type);

if(key >= 48 && key <= 57  ){
    if(filter(tempValue)=== false){
        return false;
    }else{
        return true;
    }
}else{
      if(key == 8 || key == 13 || key == 46 || key == 0) {
          return true;
      }else{
          return false;
      }
}
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,4})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }

}
function addCommas(amount) {
    decimals = 2;
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}
    function aplicarDescuento(){
                    var tipo = $(".descuento:checked").val();
                    var descuentoAplicar = $("#descuentoAplicar").val();
                    var cont = $(".descuentoConcepto:checked").val();
                    var subtotal =  ($("#inSubtotal").val()  != '' ? parseFloat($("#inSubtotal").val().replace(',', '' )) : 0);

                    if(tipo =='porc'){
                            descuento =  ((descuentoAplicar*subtotal) /100);
                            $('input[name="fDescuento"]').val(descuento);
                            $("#dinDescuento").html(addCommas(descuento)); 
                     }
                    if(tipo =='cant'){
                        descuento =  descuentoAplicar;
                        $('input[name="fDescuento"]').val(descuento);
                        $("#dinDescuento").html(addCommas(descuento)); 
  
                    }
                    impuestos();

                }
                
        function obtenerDatos(obj){
        var skServicio = $(obj).closest('tr').find('td').eq(1).find('select').val();
        var tr = $(obj).parent().parent();
        var skCategoriaPrecio = $("#skCategoriaPrecio").val();
        $.post(window.location.href,
                                {
                                    axn: 'get_servicios_datos',
                                    skServicio: skServicio,
                                    skCategoriaPrecio:skCategoriaPrecio
                                },
                                function (data) {
                                    if(data){
                                        $(obj).closest('tr').find('td').eq(3).find('input').removeAttr("disabled");
                                        $(obj).closest('tr').find('td').eq(4).find('input').removeAttr("disabled");
                                        $(obj).closest('tr').find('td').eq(3).find('input').val('1');
                                        $(obj).closest('tr').find('td').eq(4).find('input').val(data.fPrecioVenta);
                                    }
                            });
           
            datosConcepto(obj);
        };
        function datosConcepto(obj){
                setTimeout(() => {
                    actualizarImporte(obj);
                }, '1000');
             };
        
 
    var tr_concepto = '';
    $(document).ready(function () {

        //componente de checkbox
            $('[data-plugin="switchery"]').each(function () {
                new Switchery(this, {
                    color: $(this).data('color'),
                    size: $(this).data('size')
                });
            });

        $('.help-text').webuiPopover();
        $('#sCorreos').tagsinput({
					    trimValue: true,
					    freeInput: true,
					    tagClass: 'label label-danger'
					});

        $(".input-datepicker").datepicker({
                format: "dd/mm/yyyy"
            });
           
     
   
        $('#core-guardar').formValidation(core.formValidaciones);
      

            eliminarConcepto = function (obj) {
                          var tr = $(obj).parent().parent();
                          $(tr).remove();
                          actualizarSubtotal();
                      };

                      actualizarImporte = function (obj) {
                    
                          var tr = $(obj).parent().parent();
                          var importe = 0;

                          var cantidad = $(obj).closest('tr').find('td').eq(3).find('input').val().replace(',', '' );
                          var precioUnitario = $(obj).closest('tr').find('td').eq(4).find('input').val().replace(',', '' );
                   
                   
                   

                          if(cantidad != '' && precioUnitario != ''){
                              importe = (cantidad * precioUnitario);
                            
                              $(obj).closest('tr').find('td').eq(5).find('input').val(importe);
                              $(obj).closest('tr').find('td').eq(5).find('label').html(addCommas(importe));
                        
                           
                              actualizarSubtotal();
                          }
                      };

                      actualizarSubtotal = function () {
                          var subtotal = 0;
                          $("#servicios tbody tr").each(function (index) {
                                   subtotal += Math.round(parseFloat($(this).closest('tr').find('td').eq(5).find('input').val())* 100) / 100;

                          }); 
                         $("#inSubtotal").val(parseFloat(subtotal));
                         $("#dinSubtotal").html(addCommas(subtotal));
                             impuestos();
                       };
                      impuestos = function () {
                            var descuento = 0;
                            var subtotal = 0;

                            var subtotal =  ($("#inSubtotal").val()  != '' ? parseFloat($("#inSubtotal").val().replace(',', '' )) : 0);
                            var descuento =  ($("#inDescuento").val()  != '' ? parseFloat($("#inDescuento").val().replace(',', '' )) : 0);
                            var impuestoTrasladado = ( (subtotal-descuento) * .16 );
                            $("#inImpuestoTrasladado").val(parseFloat(impuestoTrasladado));
                            $("#dinImpuestoTrasladado").html(addCommas(impuestoTrasladado));
 
                             actualizartotal();
                      };
                      actualizartotal = function () {
                          var total = 0;
                          var subtotal =  ($("#inSubtotal").val()  != '' ? parseFloat($("#inSubtotal").val().replace(',', '' )) : 0);
                          var impuestoTrasladado =  ($("#inImpuestoTrasladado").val() != '' ? parseFloat($("#inImpuestoTrasladado").val().replace(',', '' )) : 0);
                          var descuento =  ($("#inDescuento").val()  != '' ? parseFloat($("#inDescuento").val().replace(',', '' )) : 0);
                          total = ( (subtotal+impuestoTrasladado) - descuento);

                          $("#inTotal").val(parseFloat(total));
                          $("#dinTotal").html(addCommas(total));

                             //actualizartotal();
                      };

                      var cont = <?php echo isset($data['cotizacionesServicios'])?COUNT($data['cotizacionesServicios']):'0'; ?>;

                        //$("#skSubservicio").select2({ width: "100%" });
                    $("#concepto-agregar").click(function(event){
                            cont++;
                            tr_concepto=   '<tr>'+

                
                            '<td><select name="servicios[' + cont + '][skTipoMedida]" class="skTipoMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                            '<td style="min-width:350px;max-width:350px;"><select name="servicios[' + cont + '][skServicio]" onchange="obtenerDatos(this);" class="skServicio form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                            '<td ><input  class="form-control"  name="servicios[' + cont + '][sDescripcion]" placeholder="Descripcion" autocomplete="off" type="text"></td>'+
                            '<td fCantidad ><input style="min-width:100px;max-width:100px;"  class="form-control" disabled name="servicios[' + cont + '][fCantidad]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="Cantidad" autocomplete="off" type="text"></td>'+
                            '<td fPrecioUnitario ><input style="min-width:100px;max-width:100px;"  class="form-control" disabled name="servicios[' + cont + '][fPrecioUnitario]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="P. Unitario" autocomplete="off" type="text"></td>'+
                            '<td><input class="form-control" name="servicios[' + cont + '][fImporte]" type="hidden"> <label class="text-center" > - </label> </td>'+
                            '<td><button type="button" class="btn btn-outline btn-danger pull-right concepto-eliminar" onclick="eliminarConcepto(this);"><i class="icon wb-trash" aria-hidden="true"></i> Eliminar</button></td>'+
                            '</tr>';
                            $("#servicios-body").append(tr_concepto);
                            core.autocomplete2('.skTipoMedida', 'get_medidas', window.location.href, 'Unidad');
                            core.autocomplete2('.skServicio', 'get_servicios', window.location.href, 'Concepto',{filter:'like'});
                        });
                        core.autocomplete2('#skEmpresaSocioCliente', 'get_empresas', window.location.href, 'Cliente', { skEmpresaTipo: 'CLIE'});

                        $("#skEmpresaSocioCliente").change(function(e){
                            var data_array = $("#skEmpresaSocioCliente").select2('data')[0];
                            $("#sNombreCliente").val(data_array.data.sNombreEmpresa);
                            $("#sDireccion").val(data_array.data.sDomicilio);
                            $("#sTelefono").val(data_array.data.sTelefono);
                            $("#sCorreos").tagsinput("add", data_array.data.sCorreo);
                        });

                        core.autocomplete2('.skTipoMedida', 'get_medidas', window.location.href, 'Unidad');
                        core.autocomplete2('.skServicio', 'get_servicios', window.location.href, 'Concepto',{filter:'like'});
                        core.autocomplete2('#skProspecto', 'get_prospectos', window.location.href, 'Prospecto');
                        $("#skDivisa").select2({placeholder: "Moneda", allowClear: true });
                        $("#skCategoriaPrecio").select2({placeholder: "CATEGORIA", allowClear: true });
                        $("#TARIFA").select2({placeholder: "TARIFA", allowClear: true });
                        




   
    });
</script>
