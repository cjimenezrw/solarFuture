<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
 
    <div class="panel panel-bordered panel-info panel-line">
      <div class="panel-heading">
        <div class="panel-actions">
            <button href="javascript:void(0);" class="btn btn-primary pull-right" onclick="obtenerDatos(this);">Obtener Datos</button>
        </div>
          <h3 class="panel-title">ARCHIVOS</h3>
      </div>
      <div class="panel-body container-fluid">
        <div class="col-md-12">

        <div class="row row-lg">
            <!-- Nombre -->
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <h4 class="example-title"><span style="color:red;">* </span> Factura XML:</h4>
                    <input class="dropify " type="file" name="facturaXML" id="facturaXML"
                          data-plugin="dropify"
                          data-allowed-file-extensions="xml"
                          data-height="85"/>
                    <!--<input type="text" class="form-control" id="sNombre" name="sNombre" placeholder="Nombre del Cuestionario">-->
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <h4 class="example-title"><span style="color:red;">* </span> Factura PDF:</h4>
                    <input class="dropify " type="file" name="facturaPDF" id="facturaPDF"
                          data-plugin="dropify"
                          data-allowed-file-extensions="pdf"
                          data-height="85"/>
                    <!--<input type="text" class="form-control" id="sNombre" name="sNombre" placeholder="Nombre del Cuestionario">-->
                </div>
            </div>
        </div>

        </div>

        </div>
  </div>

<div class="panel panel-bordered panel-info panel-line" id="dvDatosGeneralesFactura" hidden>
    <div class="panel-heading">

        <h3 class="panel-title">DATOS</h3>
    </div>
    <div class="panel-body container-fluid">





        <h5 class="card-title margin-bottom-20">
            <i class="icon wb-users"></i>
            <span>EMISOR</span>
        </h5>

        <div class="col-md-12">
            <div class="row row-lg">
                
                <div class="col-md-2 col-lg-2">
                   <div class="form-group">
                       <h4 class="example-title"><span style="color:red;">* </span> Folio:</h4>
                       <label type="text" disabled class="form-control" id="iFolioD"  ></label>
                       <input type="hidden"  id="sFolioFactura" name="sFolioFactura" >
                   </div>
               </div>
               
               <div class="col-md-2 col-lg-2">
                   <div class="form-group">
                       <h4 class="example-title"><span style="color:red;">* </span> Serie</h4>
                       <label type="text" disabled class="form-control" id="sSerieD"  ></label>
                    </div>
               </div>
               <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Fecha Pago:</h4>
                        <label type="text" disabled class="form-control" id="dFechaPagoD"  ></label>
                     </div>
                </div>
             
              </div>
          </div>
          <h5 class="card-title margin-bottom-20">
              <i class="icon wb-users"></i>
              <span>RECEPTOR</span>
          </h5>
          <div class="col-md-12">
              <div class="row row-lg">
                  <!-- Proovedor -->
                  <div class="col-md-4 col-lg-4">
                      <div class="form-group">
                          <h4 class="example-title"><span style="color:red;">* </span>  Receptor</h4>
                          <label type="text" disabled class="form-control" id="sReceptorD"  ></label> 
                      </div>
                  </div>

                  <!-- Proovedor -->
                  <div class="col-md-2 col-lg-2">
                      <div class="form-group">
                          <h4 class="example-title"><span style="color:red;">* </span>  RFC Receptor</h4>
                          <label type="text" disabled class="form-control" id="sRFCReceptorD"  ></label>
                       </div>
                  </div>
                  <!-- Proovedor -->
                  <div class="col-md-2 col-lg-2">
                      <div class="form-group">
                          <h4 class="example-title"><span style="color:red;">* </span>  Uso CFDI</h4>
                          <label type="text" disabled class="form-control" id="skUsoCFDID"  ></label>
                       </div>
                  </div>

                </div>
            </div>
             
         
              <h5 class="card-title margin-bottom-20">
                  <i class="icon wb-users"></i>
                  <span>GENERALES</span>
              </h5>

        <div class="col-md-12">
            <div class="row row-lg">

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Fecha Facturacion:</h4>
                        <label type="text" disabled class="form-control" id="dFechaFacturaD"  ></label>
                        <input type="hidden"  id="dFechaFactura" name="dFechaFactura" >
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> UUID</h4>
                        <label type="text" disabled class="form-control" id="skUUIDSATD"  ></label>
                        <input type="hidden"  id="skUUIDSAT" name="skUUIDSAT" >
                    </div>
                </div>
                <!-- Divisa -->
               <div class="col-md-2 col-lg-2">
                   <div class="form-group">
                       <h4 class="example-title"><span style="color:red;">* </span> Divisa:</h4>
                       <label type="text" disabled class="form-control" id="iMonedaD"  ></label>
                       <input type="hidden"  id="skDivisa" name="skDivisa" >
                   </div>
               </div>
               <!-- Tipo de Cambio -->
               <div class="col-md-2 col-lg-2">
                   <div class="form-group">
                       <h4 class="example-title"><span style="color:red;">* </span> T. C:</h4>
                       <label type="text" disabled class="form-control" id="fTipoCambioD" ></label>
                       <input type="hidden"  id="fTipoCambio" name="fTipoCambio" >
                   </div>
               </div>
            </div>

           
            <div class="row row-lg">
                <!-- Distribución -->
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Subtotal</h4>
                        <label type="text" disabled class="form-control" id="fSubtotalD"  ></label>
                        <input type="hidden"  id="fSubtotal" name="fSubtotal" >
                    </div>
                </div>
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Descuento</h4>
                        <label type="text" disabled class="form-control" id="fDescuentoD"  ></label>
                        <input type="hidden"  id="fDescuento" name="fDescuento" >
                    </div>
                </div>
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> IVA Ret.</h4>
                        <label type="text" disabled class="form-control" id="fImpuestosRetenidoD"  ></label>
                        <input type="hidden"  id="fImpuestosRetenidos" name="fImpuestosRetenidos" >
                    </div>
                </div>
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> IVA Tras.</h4>
                        <label type="text" disabled class="form-control" id="fImpuestosTrasladoD"  ></label>
                        <input type="hidden"  id="fImpuestosTrasladados" name="fImpuestosTrasladados" >
                    </div>
                </div>
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Total.</h4>
                        <label type="text" disabled class="form-control" id="fTotalD"  ></label>
                        <input type="hidden"  id="fTotalFactura" name="fTotalFactura" >
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-12">
            <div class="row row-lg">
                 <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Lugar Expedicion:</h4>
                        <label type="text" disabled class="form-control" id="sLugarExpedicionD"  ></label>
                        <input type="hidden"  id="sLugarExpedicion" name="sLugarExpedicion" >

                    </div>
                  </div>

            </div>
        </div>
        <div class="col-md-12">
            <div class="row row-lg">

                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Fecha Timbrado:</h4>
                        <label type="text" disabled class="form-control" id="dFechaTimbradoD"  ></label>
                        <input type="hidden"  id="dFechaTimbrado" name="dFechaTimbrado" >
                    </div>
                </div>  

              </div>
        </div>
         



    </div>
</div> 
 

</form>
<div class="site-action" data-plugin="actionBtn"><button type="button" class="site-action-toggle btn-raised btn btn-primary btn-floating" onclick="$('html, body').animate({scrollTop: 0}, 1000);" data-toggle="tooltip" title="" data-original-title="Volver Arriba"> <i class="front-icon wb-chevron-up animation-scale-up" aria-hidden="true"></i> <i class="back-icon wb-close animation-scale-up" aria-hidden="true"></i> </button></div>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script>
core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;
function obtenerDatos(obj){

           var formdata = false;
           if (window.FormData) {
               formdata = new FormData($('#core-guardar')[0]);
               formdata.append("axn", "obtenerDatos");
               formdata.append("facturaXML", $("#facturaXML")[0].files[0]);
           }
           $.ajax({
               url: window.location.href,
               type: "post",
               dataType: "json",
               data: formdata,
               cache: false,
               contentType: false,
               processData: false
           }).done(function(response){
               if (!response.success) {
                   swal("¡Error!", response.message, "error");
                   return false;
               }
                /* INICIO EMISOR */

                 
                /* FIN  EMISOR */

                /* INICIO RECEPTOR */

                
                /* FIN  RECEPTOR */

                $("#dvDatosGeneralesFactura").css("display", "block");


                 if (response.datos.comprobante.Folio != null) {
                     $('#iFolioD').text(response.datos.comprobante.Folio);
                     $('#sFolioFactura').val(response.datos.comprobante.Folio);
                  } else {
                     $('#iFolioD').text('N/D');
                     $('#sFolioFactura').val('');
                  } 
                  

                 if (response.datos.comprobante.Fecha != null) {
                     $('#dFechaFacturaD').text(response.datos.comprobante.Fecha);
                     $('#dFechaFactura').val(response.datos.comprobante.Fecha);
                 } else {
                     $('#dFechaFacturaD').text('N/D');
                      $('#dFechaFactura').val('');
                 }
                 if (response.datos.comprobante.Moneda != null) {
                     $('#iMonedaD').text(response.datos.comprobante.Moneda);
                     $('#skDivisa').val(response.datos.comprobante.Moneda);
                  } else {
                     $('#iMonedaD').text('N/D');
                     $('#skDivisa').val('');
                  }
                  if (response.datos.comprobante.TipoCambio != null) {
                      $('#fTipoCambioD').text(response.datos.comprobante.TipoCambio);
                      $('#fTipoCambio').val(response.datos.comprobante.TipoCambio);
                   } else {
                      $('#fTipoCambioD').text('N/D');
                      $('#fTipoCambio').val('');
                   }

                  if (response.datos.comprobante.Serie != null) {
                      $('#sSerieD').text(response.datos.comprobante.Serie);
                      $('#sSerie').val(response.datos.comprobante.Serie);
                   } else {
                      $('#sSerieD').text('N/D');
                      $('#sSerie').val('');
                   }

                   if (response.datos.comprobante.FormaPago != null) {
                       $('#skFormaPagoD').text(response.datos.comprobante.FormaPago);
                       $('#skFormaPago').val(response.datos.comprobante.skFormaPago);
                   } else {
                       $('#skFormaPagoD').text('N/D');
                        $('#skFormaPago').val('');
                   }
                   if (response.datos.comprobante.MetodoPago != null) {
                       $('#skMetodoPagoD').text(response.datos.comprobante.MetodoPago);
                       $('#skMetodoPago').val(response.datos.comprobante.skMetodoPago);
                   } else {
                       $('#skMetodoPagoD').text('N/D');
                        $('#skMetodoPago').val('');
                   }

                  if (response.datos.comprobante.SubTotal != null) {
                     $('#fSubtotalD').text(response.datos.comprobante.SubTotal);
                     $('#fSubtotal').val(response.datos.comprobante.SubTotal);
                 } else {
                     $('#fSubtotalD').text('N/D');
                     $('#fSubtotal').val('');
                 }
                 if (response.datos.comprobante.TotalImpuestosTrasladados != null) {
                     $('#fImpuestosTrasladoD').text(response.datos.comprobante.TotalImpuestosTrasladados);
                     $('#fImpuestosTrasladados').val(response.datos.comprobante.TotalImpuestosTrasladados);
                 } else {
                     $('#fImpuestosTrasladoD').text('N/D');
                     $('#fImpuestosTrasladados').val('');
                 }
                 if (response.datos.comprobante.TotalImpuestosRetenidos != null) {
                     $('#fImpuestosRetenidoD').text(response.datos.comprobante.TotalImpuestosRetenidos);
                     $('#fImpuestosRetenidos').val(response.datos.comprobante.TotalImpuestosRetenidos);
                 } else {
                     $('#fImpuestosRetenidoD').text('N/D');
                     $('#fImpuestosRetenidos').val('');
                 }
                 if (response.datos.comprobante.Total != null) {
                     $('#fTotalD').text(response.datos.comprobante.Total);
                     $('#fTotalFactura').val(response.datos.comprobante.Total);
                 } else {
                     $('#fTotalD').text('N/D');
                     $('#fTotalFactura').val('');
                 }

                 if (response.datos.comprobante.CondicionesDePago != null) {
                     $('#CondicionesDePago').text(response.datos.comprobante.CondicionesDePago);
                      $('#sCondicionPago').val(response.datos.comprobante.CondicionesDePago);

                 } else {
                     $('#CondicionesDePago').text('N/D');
                     $('#sCondicionPago').val('');
                 }
                 if (response.datos.comprobante.Version != null) {
                     $('#sVersionD').text(response.datos.comprobante.Version);
                     $('#sVersion').val(response.datos.comprobante.Version);
                  } else {
                     $('#sVersionD').text('N/D');
                     $('#sVersion').val('');
                  }
                  if (response.datos.comprobante.LugarExpedicion != null) {
                      $('#sLugarExpedicionD').text(response.datos.comprobante.LugarExpedicion);
                      $('#sLugarExpedicion').val(response.datos.comprobante.LugarExpedicion);
                   } else {
                      $('#sLugarExpedicionD').text('N/D');
                      $('#sLugarExpedicion').val('');
                   }
                   if (response.datos.comprobante.Certificado != null) {
                        $('#sCertificado').val(response.datos.comprobante.Certificado);
                    } else {
                        $('#sCertificado').val('');
                    }
                    if (response.datos.comprobante.NoCertificado != null) {
                         $('#sNumeroCertificado').val(response.datos.comprobante.NoCertificado);
                     } else {
                         $('#sNumeroCertificado').val('');
                     }
                     if (response.datos.comprobante.dFechaPago != null) {
                      $('#dFechaPagoD').text(response.datos.comprobante.dFechaPago);
                      $('#dFechaPago').val(response.datos.comprobante.dFechaPago);
                   } else {
                      $('#dFechaPagoD').text('N/D');
                      $('#dFechaPago').val('');
                   }
                   if (response.datos.comprobante.sNumeroOperacion != null) {
                      $('#sNumeroOperacionD').text(response.datos.comprobante.sNumeroOperacion);
                      $('#sNumeroOperacion').val(response.datos.comprobante.sNumeroOperacion);
                   } else {
                      $('#sNumeroOperacionD').text('N/D');
                      $('#sNumeroOperacion').val('');
                   }
                   
                  //COMPLEMENTO
                 if (response.datos.Complemento.UUID != null) {
                     $('#skUUIDSATD').text(response.datos.Complemento.UUID);
                     $('#skUUIDSAT').val(response.datos.Complemento.UUID);
                  } else {
                     $('#skUUIDSATD').text('N/D');
                     $('#skUUIDSAT').val('');
                  }
                  if (response.datos.Complemento.FechaTimbrado != null) {
                      $('#dFechaTimbradoD').text(response.datos.Complemento.FechaTimbrado);
                      $('#dFechaTimbrado').val(response.datos.Complemento.FechaTimbrado);
                   } else {
                      $('#dFechaTimbradoD').text('N/D');
                      $('#dFechaTimbrado').val('');
                   }
                  


                   if (response.datos.sXML != null) {
                        $('#sXML').val(response.datos.sXML);
                    } else {
                        $('#sXML').val('');
                    }
             

                  return true;

          });
}
$(document).ready(function () {
  $('#core-guardar').formValidation(core.formValidaciones);
 
  //core.autocomplete2('#skCentroCosto', 'getCentrosCosto', window.location.href, 'Centros de Costo');
  $('.dropify').dropify();
});
</script>
