<?php
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
    <div class="panel panel-bordered panel-primary panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">Datos Generales</h3>
        </div>
        <div class="panel-body container-fluid">
                  <div class="row row-lg col-lg-12">
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
                                     <option <?php echo(isset($result['skDivisa']) && $result['skDivisa'] == $row['skDivisa'] ? 'selected="selected"' : '') ?>
                                         value="<?php echo $row['skDivisa']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                     <?php
                                     }//ENDWHILE
                                 }//ENDIF
                                 ?>
                             </select>
                         </div>
                     </div>
                     <div class="col-md-4 col-lg-3">
                      <div class="form-group">
                          <h4 class="example-title">VIGENCIA </h4>
                          <div class="input-group">
                              <span class="input-group-addon">
                                  <i class="wb-calendar" aria-hidden="true"></i>
                              </span>
                              <input class="form-control input-datepicker" id="dFechaVigencia" name="dFechaVigencia" value="<?php echo (!empty($result['dFechaVigencia'])) ? date('d/m/Y', strtotime($result['dFechaVigencia'])) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" type="text" data-plugin="datepicker">
                          </div>
                      </div>
                   </div>
                   <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title">CLIENTE:</h4>
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
                        <h4 class="example-title">PROSPECTO:</h4>
                        <select name="skProspecto" id="skProspecto" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                            <?php
                            if (!empty($result['skProspecto'])) {
                                ?>
                                <option value="<?php echo $result['skProspecto']; ?>" selected="selected"><?php echo $result['prospecto']; ?></option>
                                <?php
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
                    <div class="col-md-6 col-lg-6">
                         <div class="form-group">
                             <h4 class="example-title"> Condicion</h4>
                             <textarea class="form-control"  name="sCondicion" placeholder="Condicion"><?php echo (isset($result['sCondicion'])) ? ($result['sCondicion']) : ''; ?></textarea>
                         </div>
                     </div>
                     <div class="col-md-6 col-lg-6">
                         <div class="form-group">
                             <h4 class="example-title"> Observaciones</h4>
                             <textarea class="form-control"  name="sObservaciones" placeholder="Descripcion de la Cotizacion"><?php echo (isset($result['sObservaciones'])) ? ($result['sObservaciones']) : ''; ?></textarea>
                         </div>
                     </div>
                 </div>
                 <div class="row row-lg col-lg-12">
                     <hr>
                 </div>
                 <div class="row row-lg col-lg-12">
                     <div class="col-md-8 col-lg-8">
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
                 
                 
                </div>
            </div>
     
<div class="panel panel-bordered panel-primary panel-line">
    <div class="panel-heading">
        <div class="panel-actions">
            <button type="button" class="btn btn-outline btn-success pull-right" id="concepto-agregar">
                <i class="icon wb-plus" aria-hidden="true"></i> Agregar
            </button>
        </div>
        <h3 class="panel-title">Conceptos</h3>
    </div>
    <div class="panel-body container-fluid">

    <div class="table-responsive clearfix" id="conceptos" style="overflow-y:visible;font-size: 10pt;">
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
            <table class="table table-striped table-bordered" id="conceptos">
                <thead>
                    <tr>
                        <th class="text-center" nowrap style="text-transform: uppercase;">SE</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Unidad</th>
                        <th class=" col-xs-2  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Concepto</th>
                        <th class="col-xs-1 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Cantidad</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> P. Unitario</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">IVA</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">RET IVA</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">Importe</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">Descuento</th>
                        <th class="col-xs-1 col-md-1 text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="searchable" id="conceptos-body">

                        <?php
                        if (isset($data['cotizacionesConceptos'])){
                            $cont = 1;
                            foreach ($data['cotizacionesConceptos'] as $row){ ?>


                            <tr <?php echo (!empty($row['TRAIVA']) ? "TRAIVA = '".$row['TRAIVA']."' " : ''); ?> <?php echo (!empty($row['RETIVA']) ? "RETIVA = '".$row['RETIVA']."' " : ''); ?>>
                                <td>
                                    <div class="radio-custom radio-primary ">
                                       <input type="radio" class="descuentoConcepto" id="inputchk<?php echo $cont; ?>" name="chk" value="<?php echo $cont; ?>" />
                                       <label for="inputchk<?php echo $cont; ?>">&nbsp;</label></div>
                                </td>
                                <td>
                                    <select name="conceptos[<?php echo $cont; ?>][skTipoMedida]" class="skTipoMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skTipoMedida']) ? $row['skTipoMedida'] : ''); ?>"><?php echo (isset($row['tipoMedida']) ? $row['tipoMedida'] : ''); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <select name="conceptos[<?php echo $cont; ?>][skConcepto]" onchange="obtenerDatos(this);" class="skConcepto form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skConcepto']) ? $row['skConcepto'] : ''); ?>"><?php echo (isset($row['concepto']) ? $row['concepto'] : ''); ?></option>
                                    </select>
                                <td><input class="form-control" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo (isset($row['fCantidad']) ? number_format($row['fCantidad'],4) : '');?>"  onchange="actualizarImporte(this);" name="conceptos[<?php echo $cont; ?>][fCantidad]" placeholder="Cantidad" autocomplete="off" type="text"></td>
                                <td><input class="form-control" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo  (isset($row['fPrecioUnitario']) ? number_format($row['fPrecioUnitario'],2) : '');?>"  onchange="actualizarImporte(this);" name="conceptos[<?php echo $cont; ?>][fPrecioUnitario]" placeholder="P. Unitario" autocomplete="off" type="text"></td>
                                <td><input class="form-control" value="<?php echo $row['fImpuestosTrasladados'];?>" name="conceptos[<?php echo $cont; ?>][fImpuestosTrasladados]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImpuestosTrasladados']) ? number_format($row['fImpuestosTrasladados'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fImpuestosRetenidos'];?>" name="conceptos[<?php echo $cont; ?>][fImpuestosRetenidos]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImpuestosRetenidos']) ? number_format($row['fImpuestosRetenidos'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fImporte'];?>" name="conceptos[<?php echo $cont; ?>][fImporte]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImporte']) ? number_format($row['fImporte'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fDescuento'];?>" name="conceptos[<?php echo $cont; ?>][fDescuento]"  type="hidden"><label class="text-center" id="descuentoConcepto<?php echo $cont; ?>" > <?php echo (isset($row['fDescuento']) ? number_format($row['fDescuento'],2) : ''); ?> </label>  </td>
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
              <label  disabled class="form-control input-sm" id="dinSubtotal"  > <?php echo (!empty($result['fImporteSubtotal'])) ? number_format($result['fImporteSubtotal'],2) : ''; ?></label>
              <input type="hidden"  id="inSubtotal" name="fImporteSubtotal"  value="<?php echo (isset($result['fImporteSubtotal'])) ? $result['fImporteSubtotal'] : ''; ?>" />
            </div>
        </div>
        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Descuento</label>
              <label type="text" disabled class="form-control input-sm" id="dinDescuento"><?php echo (!empty($result['fDescuento'])) ? number_format($result['fDescuento'],2) : ''; ?> </label>
              <input type="hidden"  id="inDescuento" name="fDescuento" value="<?php echo (isset($result['fDescuento'])) ? $result['fDescuento'] : ''; ?>"  />
            </div>
        </div>
        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Traslados</label>
              <label type="text" disabled class="form-control input-sm" id="dinImpuestoTrasladado"><?php echo (!empty($result['fImpuestosTrasladados'])) ? number_format($result['fImpuestosTrasladados'],2) : ''; ?></label>
              <input type="hidden"  id="inImpuestoTrasladado" name="fImpuestosTrasladados" value="<?php echo (isset($result['fImpuestosTrasladados'])) ? $result['fImpuestosTrasladados'] : ''; ?>"  />
            </div>
        </div>
        <div class="col-md-12 form-inline ">
            <div class="form-group pull-right">
              <label class="control-label">Retenciones</label>
              <label type="text" disabled class="form-control input-sm" id="dinImpuestoRetenido"><?php echo (!empty($result['fImpuestosRetenidos']) ? number_format($result['fImpuestosRetenidos'],2) : '0.00'); ?></label>
              <input type="hidden"  id="inImpuestoRetenido" name="fImpuestosRetenidos"  value="<?php echo (isset($result['fImpuestosRetenidos'])) ? $result['fImpuestosRetenidos'] : ''; ?>"   />
            </div>
        </div>

        <div class="col-md-12 form-inline ">
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
                    var importe = $('input[name="conceptos['+cont+'][fImporte]"]').val();

                    if(tipo =='porc'){
                            descuento =  ((descuentoAplicar*importe) /100);
                            $('input[name="conceptos['+cont+'][fDescuento]"]').val(descuento);
                            $('#descuentoConcepto'+cont).html(parseFloat(descuento));
                    }
                    if(tipo =='cant'){
                        descuento =  descuentoAplicar;
                        $('input[name="conceptos['+cont+'][fDescuento]"]').val(descuento);
                        $('#descuentoConcepto'+cont).html(parseFloat(descuento));

                    }
                    var obj = $('input[name="conceptos['+cont+'][fImporte]"]');
                     actualizarImporte(obj);

                }
                
        function obtenerDatos(obj){
        var skConcepto = $(obj).closest('tr').find('td').eq(2).find('select').val();
        var tr = $(obj).parent().parent();

        $.post(window.location.href,
                                {
                                    axn: 'get_conceptos_datos',
                                    skConcepto: skConcepto
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

            var skConcepto = $(obj).closest('tr').find('td').eq(2).find('select').val();
            var tr = $(obj).parent().parent();
            $(tr).removeAttr("traiva");
            $(tr).removeAttr("retiva");
                if (skConcepto) {
                    $.post(window.location.href,
                        {
                            axn: 'get_conceptos_impuestos',
                            skConcepto: skConcepto
                        },
                        function (data) {
                            if(data){
                                $.each(data, function (k, v) {
                                    $(tr).attr(v.skImpuesto, v.sValor);
                                    });
                            }
                    });
                }
                setTimeout(() => {
                    actualizarImporte(obj);
           }, '1000');
             };
        
 
    var tr_concepto = '';
    $(document).ready(function () {
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
                          var fImpuestoTrasladado = 0;
                          var fImpuestoRetenido = 0;
                          var traiva = 0;
                          var retiva = 0;

                          var cantidad = $(obj).closest('tr').find('td').eq(3).find('input').val().replace(',', '' );
                          var precioUnitario = $(obj).closest('tr').find('td').eq(4).find('input').val().replace(',', '' );
                          var descuento = $(obj).closest('tr').find('td').eq(8).find('input').val().replace(',', '' );
                          var traiva = $(tr).attr('traiva');
                          var retiva = $(tr).attr('retiva');
                   

                          if(cantidad != '' && precioUnitario != ''){
                              importe = (cantidad * precioUnitario);
                              $(obj).closest('tr').find('td').eq(7).find('input').val(importe);
                              $(obj).closest('tr').find('td').eq(7).find('label').html(addCommas(importe));

                              if (typeof traiva !== typeof undefined && traiva !== false) {

                                  fImpuestoTrasladado = ((importe-descuento) * traiva / 100);
                                  fImpuestoTrasladado = Math.round(fImpuestoTrasladado * 100) / 100;
                                }

                                $(obj).closest('tr').find('td').eq(5).find('input').val(fImpuestoTrasladado);
                                $(obj).closest('tr').find('td').eq(5).find('label').html(addCommas(fImpuestoTrasladado));
                                if (typeof retiva !== typeof undefined && retiva !== false) {
                                    fImpuestoRetenido = ((importe-descuento) * retiva / 100);
                                    fImpuestoRetenido = Math.round(fImpuestoRetenido * 100) / 100;
                                }
                                $(obj).closest('tr').find('td').eq(6).find('input').val(fImpuestoRetenido);
                                $(obj).closest('tr').find('td').eq(6).find('label').html(addCommas(fImpuestoRetenido));

                              actualizarSubtotal();
                          }
                      };

                      actualizarSubtotal = function () {
                          var subtotal = 0;
                          $("#conceptos tbody tr").each(function (index) {
                                   //subtotal += parseFloat($(this).closest('tr').find('td').eq(8).find('input').val());
                                   subtotal += Math.round(parseFloat($(this).closest('tr').find('td').eq(7).find('input').val())* 100) / 100;

                          });

                         $("#inSubtotal").val(parseFloat(subtotal));
                         $("#dinSubtotal").html(addCommas(subtotal));
                             impuestos();
                       };
                      impuestos = function () {
                          var impuestosTrasladados = 0;
                          var impuestosRetenciones = 0;
                          var descuento = 0;

                          $("#conceptos tbody tr").each(function (index) {
                              if($(this).closest('tr').find('td').eq(5).find('input').val()){
                                   //impuestosTrasladados += parseFloat($(this).closest('tr').find('td').eq(6).find('input').val());
                                   impuestosTrasladados += Math.round(parseFloat($(this).closest('tr').find('td').eq(5).find('input').val())* 100) / 100;

                               }
                          });
                          $("#inImpuestoTrasladado").val(parseFloat(impuestosTrasladados));
                          $("#dinImpuestoTrasladado").html(addCommas(impuestosTrasladados));

                          $("#conceptos tbody tr").each(function (index) {
                              if($(this).closest('tr').find('td').eq(6).find('input').val()){
                                  //impuestosRetenciones += parseFloat($(this).closest('tr').find('td').eq(7).find('input').val());
                                  impuestosRetenciones += Math.round(parseFloat($(this).closest('tr').find('td').eq(6).find('input').val())* 100) / 100;

                              }
                          });
                          $("#inImpuestoRetenido").val(parseFloat(impuestosRetenciones));
                          $("#dinImpuestoRetenido").html(addCommas(impuestosRetenciones));

                          $("#conceptos tbody tr").each(function (index) {
                              if($(this).closest('tr').find('td').eq(8).find('input').val()){
                                  descuento += parseFloat($(this).closest('tr').find('td').eq(8).find('input').val());
                              }
                          });
                          $("#inDescuento").val(parseFloat(descuento));
                          $("#dinDescuento").html(addCommas(descuento));

                             actualizartotal();
                      };
                      actualizartotal = function () {
                          var total = 0;
                          var subtotal =  ($("#inSubtotal").val()  != '' ? parseFloat($("#inSubtotal").val().replace(',', '' )) : 0);
                          var impuestoTrasladado =  ($("#inImpuestoTrasladado").val() != '' ? parseFloat($("#inImpuestoTrasladado").val().replace(',', '' )) : 0);
                          var impuestoRetenido =  ($("#inImpuestoRetenido").val()  != '' ? parseFloat($("#inImpuestoRetenido").val().replace(',', '' )) : 0);
                          var descuento =  ($("#inDescuento").val()  != '' ? parseFloat($("#inDescuento").val().replace(',', '' )) : 0);
                          total = ( (subtotal+impuestoTrasladado-impuestoRetenido) - descuento);

                          $("#inTotal").val(parseFloat(total));
                          $("#dinTotal").html(addCommas(total));

                             //actualizartotal();
                      };

                      var cont = <?php echo isset($data['cotizacionesConceptos'])?COUNT($data['cotizacionesConceptos']):'0'; ?>;

                        //$("#skSubservicio").select2({ width: "100%" });
                    $("#concepto-agregar").click(function(event){
                            cont++;
                            tr_concepto=   '<tr>'+

                            '<td><div class="radio-custom radio-primary ">'+
                               '<input type="radio" class="descuentoConcepto" id="inputchk' + cont + '" name="chk" value="' + cont + '" />'+
                               '<label for="inputchk' + cont + '">&nbsp;</label></div></td>'+
                            '<td><select name="conceptos[' + cont + '][skTipoMedida]" class="skTipoMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                            '<td><select name="conceptos[' + cont + '][skConcepto]" onchange="obtenerDatos(this);" class="skConcepto form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                            '<td fCantidad ><input class="form-control" disabled name="conceptos[' + cont + '][fCantidad]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="Cantidad" autocomplete="off" type="text"></td>'+
                            '<td fPrecioUnitario ><input class="form-control" disabled name="conceptos[' + cont + '][fPrecioUnitario]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="P. Unitario" autocomplete="off" type="text"></td>'+
                            '<td><input class="form-control" name="conceptos[' + cont + '][fImpuestosTrasladados]" type="hidden"> <label class="text-center" > - </label> </td>'+
                            '<td><input class="form-control" name="conceptos[' + cont + '][fImpuestosRetenidos]" type="hidden"> <label class="text-center" > - </label> </td>'+
                            '<td><input class="form-control" name="conceptos[' + cont + '][fImporte]" type="hidden"> <label class="text-center" > - </label> </td>'+
                            '<td><input class="form-control" name="conceptos[' + cont + '][fDescuento]" type="hidden"> <label class="text-center" id="descuentoConcepto' + cont + '" > - </label> </td>'+
                            '<td><button type="button" class="btn btn-outline btn-danger pull-right concepto-eliminar" onclick="eliminarConcepto(this);"><i class="icon wb-trash" aria-hidden="true"></i> Eliminar</button></td>'+
                            '</tr>';
                            $("#conceptos-body").append(tr_concepto);
                            core.autocomplete2('.skTipoMedida', 'get_medidas', window.location.href, 'Unidad');
                            core.autocomplete2('.skConcepto', 'get_conceptos', window.location.href, 'Concepto');
                        });
                        core.autocomplete2('#skEmpresaSocioCliente', 'get_empresas', window.location.href, 'Cliente',{
                            skEmpresaTipo : '["CLIE"]'
                        });

                        core.autocomplete2('.skTipoMedida', 'get_medidas', window.location.href, 'Unidad');
                        core.autocomplete2('.skConcepto', 'get_conceptos', window.location.href, 'Concepto');
                        core.autocomplete2('#skProspecto', 'get_prospectos', window.location.href, 'Prospecto');
                        $("#skDivisa").select2({placeholder: "Moneda", allowClear: true });




   
    });
</script>
