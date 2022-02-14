<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
<input type="hidden" name="skOrdenServicio"  id="skOrdenServicio" value="<?php echo (isset($result['skOrdenServicio'])) ? $result['skOrdenServicio'] : ''; ?>">

    <div class="panel panel-bordered panel-info panel-line">
        <div class="panel-heading">
            <h3 class="panel-title">DATOS GENERALES</h3>
            <?php if(!empty($result['iFolio'])){   ?>
              <div class="alert alert-primary alert-dismissible" role="alert">
                  <b class="red-600 font-size-24"><?php echo (isset($result['iFolio'])) ? ($result['iFolio']) : ''; ?></b>
              </div>
              <?php }//ENDIF ?>
        
        </div>
        <div class="panel-body container-fluid">

            <div class="row-lg col-lg-12">
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                    <h4 class="example-title"><b style="color:red;">* </b>EMPRESA RESPONSABLE:</h4>
                    <select name="skEmpresaSocioResponsable" id="skEmpresaSocioResponsable" class="form-control" data-plugin="select2" data-ajax--cache="true"  >
                        <?php
                        if (!empty($result['skEmpresaSocioResponsable'])) {
                            ?>
                            <option value="<?php echo $result['skEmpresaSocioResponsable']; ?>" selected="selected"><?php echo $result['responsable'] . ' (' . $result['sRFCResponsable'] . ')'; ?></option>
                            <?php
                        }//ENDIF
                        ?>
                    </select>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                    <h4 class="example-title">EMPRESA FACTURAR:</h4>
                    <select name="skEmpresaSocioFacturacion" id="skEmpresaSocioFacturacion" class="form-control" data-plugin="select2" data-ajax--cache="true"  >
                        <?php
                        if (!empty($result['skEmpresaSocioFacturacion'])) {
                            ?>
                            <option value="<?php echo $result['skEmpresaSocioFacturacion']; ?>" selected="selected"><?php echo $result['facturacion'] . ' (' . $result['sRFCReceptor'] . ')'; ?></option>
                            <?php
                        }//ENDIF
                        ?>
                    </select>
                    </div>
                </div>
                
            </div>
             
            
            <div class="row-lg col-lg-12" >
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <h4 class="example-title">Metodo de Pago</h4>
                        <select name="skMetodoPago" id="skMetodoPago"  class="form-control" data-plugin="select2" select2Simple>
                          <option value="">Seleccionar</option>
                          <?php
                          if ($data['metodoPago']) {
                          foreach (  $data['metodoPago'] as $row) {
                              utf8($row);
                              ?>
                              <option <?php echo(isset($result['skMetodoPago']) && $result['skMetodoPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                              <?php
                              }//ENDWHILE
                          }//ENDIF
                          ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <h4 class="example-title">Forma de Pago</h4>
                        <select name="skFormaPago" id="skFormaPago"  class="form-control" data-plugin="select2" select2Simple>
                          <option value="">Seleccionar</option>
                          <?php
                          if ($data['formaPago']) {
                          foreach (  $data['formaPago'] as $row) {
                              utf8($row);
                              ?>
                              <option <?php echo(isset($result['skFormaPago']) && $result['skFormaPago'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                              <?php
                              }//ENDWHILE
                          }//ENDIF
                          ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <h4 class="example-title">Uso de CFDI</h4>
                        <select name="skUsoCFDI" id="skUsoCFDI"  class="form-control" data-plugin="select2" select2Simple>
                          <option value="">Seleccionar</option>
                          <?php
                          if ($data['usoCFDI']) {
                          foreach (  $data['usoCFDI'] as $row) {
                              utf8($row);
                              ?>
                              <option <?php echo(isset($result['skUsoCFDI']) && $result['skUsoCFDI'] == $row['sCodigo'] ? 'selected="selected"' : '') ?> value="<?php echo $row['sCodigo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                              <?php
                              }//ENDWHILE
                          }//ENDIF
                          ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row-lg col-lg-12">
            <div class="col-md-4 col-lg-3">
                         <div class="form-group">
                             <h4 class="example-title"><b style="color:red;">* </b>Divisa</h4>
                                <select name="skDivisa" id="skDivisa"  class="form-control" data-plugin="select2" select2Simple>
                                    <option value="">Seleccionar</option>
                                <?php
                                    if ($data['divisas']) {
                                        foreach($data['divisas'] as $row) {
                                        utf8($row,FALSE);
                                ?>
                                    <option <?php echo(isset($result['skDivisa']) && $result['skDivisa'] == $row['skDivisa'] ? 'selected="selected"' : '') ?> value="<?php echo $row['skDivisa']; ?>"> <?php echo $row['skDivisa']; ?> </option>
                                <?php
                                        }//ENDFOREACH
                                    }//ENDIF
                                ?>
                                </select>
                         </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                         <div class="form-group">
                             <h4 class="example-title">Tipo de Cambio</h4>
                             <input class="form-control" name="fTipoCambio" id="fTipoCambio" value="<?php echo (isset($result['fTipoCambio'])) ? $result['fTipoCambio'] : ''; ?>" placeholder="Tipo de Cambio" autocomplete="off" type="text" >
                         </div>
                      </div>
            </div>
             
                <div class="col-md-12 clearfix"><hr></div>



                 <div class="row-lg col-lg-12" >
                     <div class="col-md-4 col-lg-3">
                         <div class="form-group">
                             <h4 class="example-title">Nombre Cliente  </h4>
                             <input class="form-control" name="sNombreCliente" id="sNombreCliente" value="<?php echo (isset($result['sNombreCliente'])) ? $result['sNombreCliente'] : $result['responsable']; ?>" placeholder="Nombre Cliente" autocomplete="off" type="text" >
                         </div>
                      </div>
                      <div class="col-md-4 col-lg-3">
                         <div class="form-group">
                             <h4 class="example-title">Referencia </h4>
                             <input class="form-control" name="sReferencia" id="sReferencia" value="<?php echo (isset($result['sReferencia'])) ? $result['sReferencia'] : ''; ?>" placeholder="Referencia" autocomplete="off" type="text" >
                         </div>
                      </div>
                 </div>
                    
 

            <div class="row-lg col-lg-12" >

                 <div class="col-md-8 col-lg-9">
                     <div class="form-group">
                         <h4 class="example-title">Observaciones</h4>
                         <textarea class="form-control"  id="sDescripcion" name="sDescripcion" placeholder="Observaciones"><?php echo (isset($result['sDescripcion'])) ? ($result['sDescripcion']) : ''; ?></textarea>
                      </div>
                  </div>

            </div>


 

 <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><b class="text-danger"></b>NO FACTURABLE:</h4>
                            <input  type="checkbox" name="iNoFacturable" id="iNoFacturable"  <?php echo (!empty($result['iNoFacturable']) ? 'checked': ''); ?> value="1"  class="js-switch-large" data-plugin="switchery" data-color="#4d94ff" />
                        </div>
                    </div>

        </div>
    </div>

    <div class="panel panel-bordered panel-success panel-line">
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
                        <th class="text-center" nowrap style="text-transform: uppercase;">SE</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Unidad</th>
                        <th class=" col-xs-2  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Concepto</th>
                        <th class="col-xs-4 text-center" style="text-transform: uppercase;">Descripcion</th>
                        <th class="col-xs-1 text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> Cantidad</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;"><b style="color:red;">*</b> P. Unitario</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">IVA</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">RET IVA</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">Importe</th>
                        <th class="col-xs-1  text-center" style="text-transform: uppercase;">Descuento</th>
                        <th class="col-xs-1 col-md-1 text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="searchable" id="servicios-body">

                        <?php
                        if (isset($data['serviciosOrdenes'])){
                            $cont = 1;
                            foreach ($data['serviciosOrdenes'] as $row){ ?>


                            <tr <?php echo (!empty($row['TRAIVA']) ? "TRAIVA = '".$row['TRAIVA']."' " : ''); ?> <?php echo (!empty($row['RETIVA']) ? "RETIVA = '".$row['RETIVA']."' " : ''); ?>>
                                <td>
                                    <div class="radio-custom radio-primary ">
                                       <input type="radio" class="descuentoConcepto" id="inputchk<?php echo $cont; ?>" name="chk" value="<?php echo $cont; ?>" />
                                       <label for="inputchk<?php echo $cont; ?>">&nbsp;</label></div>
                                </td>
                                <td>
                                    <select name="servicios[<?php echo $cont; ?>][skUnidadMedida]" class="skUnidadMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skUnidadMedida']) ? $row['skUnidadMedida'] : ''); ?>"><?php echo (isset($row['unidadMedida']) ? $row['unidadMedida'] : ''); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <select name="servicios[<?php echo $cont; ?>][skServicio]" onchange="datosConcepto(this);" class="skServicio form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">
                                        <option value="<?php echo (isset($row['skServicio']) ? $row['skServicio'] : ''); ?>"><?php echo (isset($row['servicio']) ? $row['servicio'] : ''); ?></option>
                                    </select>
                                <td><input class="form-control" value="<?php echo $row['sDescripcion'];?>" name="servicios[<?php echo $cont; ?>][sDescripcionConcepto]" placeholder="Descripcion" autocomplete="off" type="text"></td>
                                <td><input class="form-control" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo (isset($row['fCantidad']) ? number_format($row['fCantidad'],4) : '');?>"  onchange="actualizarImporte(this);" name="servicios[<?php echo $cont; ?>][fCantidad]" placeholder="Cantidad" autocomplete="off" type="text"></td>
                                <td><input class="form-control" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);" value="<?php echo  (isset($row['fPrecioUnitario']) ? number_format($row['fPrecioUnitario'],2) : '');?>"  onchange="actualizarImporte(this);" name="servicios[<?php echo $cont; ?>][fPrecioUnitario]" placeholder="P. Unitario" autocomplete="off" type="text"></td>
                                <td><input class="form-control" value="<?php echo $row['fImpuestosTrasladados'];?>" name="servicios[<?php echo $cont; ?>][fImpuestosTrasladados]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImpuestosTrasladados']) ? number_format($row['fImpuestosTrasladados'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fImpuestosRetenidos'];?>" name="servicios[<?php echo $cont; ?>][fImpuestosRetenidos]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImpuestosRetenidos']) ? number_format($row['fImpuestosRetenidos'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fImporteTotal'];?>" name="servicios[<?php echo $cont; ?>][fImporte]"  type="hidden"><label class="text-center" > <?php echo (isset($row['fImporteTotal']) ? number_format($row['fImporteTotal'],2) : ''); ?> </label>  </td>
                                <td><input class="form-control" value="<?php echo $row['fDescuento'];?>" name="servicios[<?php echo $cont; ?>][fDescuento]"  type="hidden"><label class="text-center" id="descuentoConcepto<?php echo $cont; ?>" > <?php echo (isset($row['fDescuento']) ? number_format($row['fDescuento'],2) : ''); ?> </label>  </td>
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
<script type="text/javascript" defer="defer">
      core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;
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
                    var importe = $('input[name="servicios['+cont+'][fImporte]"]').val();

                    if(tipo =='porc'){
                            descuento =  ((descuentoAplicar*importe) /100);
                            $('input[name="servicios['+cont+'][fDescuento]"]').val(descuento);
                            $('#descuentoConcepto'+cont).html(parseFloat(descuento));
                    }
                    if(tipo =='cant'){
                        descuento =  descuentoAplicar;
                        $('input[name="servicios['+cont+'][fDescuento]"]').val(descuento);
                        $('#descuentoConcepto'+cont).html(parseFloat(descuento));

                    }
                    var obj = $('input[name="servicios['+cont+'][fImporte]"]');
                     actualizarImporte(obj);

                }
                function datosConcepto(obj){

                var skServicio = $(obj).closest('tr').find('td').eq(2).find('select').val();
                var tr = $(obj).parent().parent();
                $(tr).removeAttr("traiva");
                $(tr).removeAttr("retiva");
                    if (skServicio) {
                        
                            $.post(window.location.href,
                            {
                                axn: 'get_servicio_impuestos',
                                skServicio: skServicio
                            },
                            function (data) {
                                //if (element.nodeType === ELEMENT_NODE) {
                                // return jqLite(element);
                                // }

                                //console.log(data);
                                if(data){
                                    $.each(data, function (k, v) {
                                            $(tr).attr(v.skImpuesto, v.sValor);
                                        });
                                }
                        });
                    
                actualizarImporte(obj);
                $(obj).closest('tr').find('td').eq(4).find('input').removeAttr("disabled");
                $(obj).closest('tr').find('td').eq(5).find('input').removeAttr("disabled");
                        }
                    


                };


             
                var tr_concepto = '';
				//Una vez cargada la vista carga el javascript principal del modulo
				$(document).ready(function () {

                    $('[data-plugin="switchery"]').each(function () {
                new Switchery(this, {
                    color: $(this).data('color'),
                    size: $(this).data('size')
                });
            });

                    $('#core-guardar').formValidation(core.formValidaciones);


 
                    eliminarConcepto = function (obj) {
                          var tr = $(obj).parent().parent();
                          $(tr).remove();
                          actualizarSubtotal();
                      };

                      $(".input-datepicker").datepicker({
                          format: "dd/mm/yyyy"
                      });

                      actualizarImporte = function (obj) {

                          var tr = $(obj).parent().parent();
                          var importe = 0;
                          var fImpuestoTrasladado = 0;
                          var fImpuestoRetenido = 0;
                          var traiva = 0;
                          var retiva = 0;

                          var cantidad = $(obj).closest('tr').find('td').eq(4).find('input').val().replace(',', '' );
                          var precioUnitario = $(obj).closest('tr').find('td').eq(5).find('input').val().replace(',', '' );
                          var descuento = $(obj).closest('tr').find('td').eq(9).find('input').val().replace(',', '' );
                          var traiva = $(tr).attr('traiva');
                          var retiva = $(tr).attr('retiva');

                          if(cantidad != '' && precioUnitario != ''){
                              importe = (cantidad * precioUnitario);
                              $(obj).closest('tr').find('td').eq(8).find('input').val(importe);
                              $(obj).closest('tr').find('td').eq(8).find('label').html(addCommas(importe));

                              if (typeof traiva !== typeof undefined && traiva !== false) {

                                  fImpuestoTrasladado = ((importe-descuento) * traiva / 100);
                                  fImpuestoTrasladado = Math.round(fImpuestoTrasladado * 100) / 100;
                                }

                                $(obj).closest('tr').find('td').eq(6).find('input').val(fImpuestoTrasladado);
                                $(obj).closest('tr').find('td').eq(6).find('label').html(addCommas(fImpuestoTrasladado));
                                if (typeof retiva !== typeof undefined && retiva !== false) {
                                    fImpuestoRetenido = ((importe) * retiva / 100);
                                    fImpuestoRetenido = Math.round(fImpuestoRetenido * 100) / 100;
                                }
                                $(obj).closest('tr').find('td').eq(7).find('input').val(fImpuestoRetenido);
                                $(obj).closest('tr').find('td').eq(7).find('label').html(addCommas(fImpuestoRetenido));

                              actualizarSubtotal();
                          }
                      };

                      actualizarSubtotal = function () {
                          var subtotal = 0;
                          $("#servicios tbody tr").each(function (index) {
                                   //subtotal += parseFloat($(this).closest('tr').find('td').eq(8).find('input').val());
                                   subtotal += Math.round(parseFloat($(this).closest('tr').find('td').eq(8).find('input').val())* 100) / 100;

                          });

                         $("#inSubtotal").val(parseFloat(subtotal));
                         $("#dinSubtotal").html(addCommas(subtotal));
                             impuestos();
                       };
                      impuestos = function () {
                          var impuestosTrasladados = 0;
                          var impuestosRetenciones = 0;
                          var descuento = 0;

                          $("#servicios tbody tr").each(function (index) {
                              if($(this).closest('tr').find('td').eq(6).find('input').val()){
                                   //impuestosTrasladados += parseFloat($(this).closest('tr').find('td').eq(6).find('input').val());
                                   impuestosTrasladados += Math.round(parseFloat($(this).closest('tr').find('td').eq(6).find('input').val())* 100) / 100;

                               }
                          });
                          $("#inImpuestoTrasladado").val(parseFloat(impuestosTrasladados));
                          $("#dinImpuestoTrasladado").html(addCommas(impuestosTrasladados));

                          $("#servicios tbody tr").each(function (index) {
                              if($(this).closest('tr').find('td').eq(7).find('input').val()){
                                  //impuestosRetenciones += parseFloat($(this).closest('tr').find('td').eq(7).find('input').val());
                                  impuestosRetenciones += Math.round(parseFloat($(this).closest('tr').find('td').eq(7).find('input').val())* 100) / 100;

                              }
                          });
                          $("#inImpuestoRetenido").val(parseFloat(impuestosRetenciones));
                          $("#dinImpuestoRetenido").html(addCommas(impuestosRetenciones));

                          $("#servicios tbody tr").each(function (index) {
                              if($(this).closest('tr').find('td').eq(9).find('input').val()){
                                  descuento += parseFloat($(this).closest('tr').find('td').eq(9).find('input').val());
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

                      var cont = <?php echo isset($data['pagosServicios'])?COUNT($data['pagosServicios']):'0'; ?>;

                        //$("#skSubservicio").select2({ width: "100%" });
                    $("#concepto-agregar").click(function(event){
                            cont++;
                            tr_concepto=   '<tr>'+

                            '<td><div class="radio-custom radio-primary ">'+
                               '<input type="radio" class="descuentoConcepto" id="inputchk' + cont + '" name="chk" value="' + cont + '" />'+
                               '<label for="inputchk' + cont + '">&nbsp;</label></div></td>'+
                            '<td><select name="servicios[' + cont + '][skUnidadMedida]" class="skUnidadMedida form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                            '<td><select name="servicios[' + cont + '][skServicio]" onchange="datosConcepto(this);" class="skServicio form-control js-data-example-ajax" data-plugin="select2" data-ajax--cache="true">  </select></td>'+
                            '<td><input class="form-control" name="servicios[' + cont + '][sDescripcionConcepto]" placeholder="Descripcion" autocomplete="off" type="text"></td>'+
                            '<td fCantidad ><input class="form-control" disabled name="servicios[' + cont + '][fCantidad]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="Cantidad" autocomplete="off" type="text"></td>'+
                            '<td fPrecioUnitario ><input class="form-control" disabled name="servicios[' + cont + '][fPrecioUnitario]" onpaste="return filterFloat(event,this);"  onkeypress="return filterFloat(event,this);"  onchange="actualizarImporte(this);" placeholder="P. Unitario" autocomplete="off" type="text"></td>'+
                            '<td><input class="form-control" name="servicios[' + cont + '][fImpuestosTrasladados]" type="hidden"> <label class="text-center" > - </label> </td>'+
                            '<td><input class="form-control" name="servicios[' + cont + '][fImpuestosRetenidos]" type="hidden"> <label class="text-center" > - </label> </td>'+
                            '<td><input class="form-control" name="servicios[' + cont + '][fImporte]" type="hidden"> <label class="text-center" > - </label> </td>'+
                            '<td><input class="form-control" name="servicios[' + cont + '][fDescuento]" type="hidden"> <label class="text-center" id="descuentoConcepto' + cont + '" > - </label> </td>'+
                            '<td><button type="button" class="btn btn-outline btn-danger pull-right concepto-eliminar" onclick="eliminarConcepto(this);"><i class="icon wb-trash" aria-hidden="true"></i> Eliminar</button></td>'+
                            '</tr>';
                            $("#servicios-body").append(tr_concepto);
                            core.autocomplete2('.skUnidadMedida', 'get_medidas', window.location.href, 'Unidad');
                            core.autocomplete2('.skServicio', 'get_servicios', window.location.href, 'Concepto');
                        });



                    $("#skFormaPago").select2({placeholder: "Forma de Pago", allowClear: true });
                    $("#skMetodoPago").select2({placeholder: "Metodo de Pago", allowClear: true });
                    $("#skUsoCFDI").select2({placeholder: "Uso de CFDI", allowClear: true });
                    $("#skDivisa").select2({placeholder: "Divisa", allowClear: true });
                    
 			 
 


                // Obtener Empresas (Responsable) //
                core.autocomplete2('#skEmpresaSocioResponsable', 'getEmpresas', window.location.href, 'EMPRESA RESPONSABLE',{
                    skEmpresaTipo : '["CLIE"]'
                }); 

                core.autocomplete2('#skEmpresaSocioFacturacion', 'getEmpresas', window.location.href, 'EMPRESA FACTURAR',{
                    skEmpresaTipo : '["CLIE"]'
                }); 


                core.autocomplete2('.skUnidadMedida', 'get_medidas', window.location.href, 'Unidad');
                core.autocomplete2('.skServicio', 'get_servicios', window.location.href, 'Concepto');
  
           
				});
</script>
