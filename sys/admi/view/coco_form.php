<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
  <input type="hidden"  id="sRFCProveedorCertificado" name="sRFCProveedorCertificado" >
  <input type="hidden"  id="sCadenaOriginalSAT" name="sCadenaOriginalSAT" >
  <input type="hidden"  id="sCertificado" name="sCertificado" >
  <input type="hidden"  id="sNumeroCertificado" name="sNumeroCertificado" >
  <input type="hidden"  id="sXML" name="sXML" >
  <!--<input type="hidden"  id="skEmpresaSocioCliente" name="skEmpresaSocioCliente" >-->
  <input type="hidden"  id="sRFCCliente" name="sRFCCliente" >
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
                <!-- Proovedor -->
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span>  Emisor</h4>
                        <label type="text" disabled class="form-control" id="sEmisorD"  ></label>
                        <input type="hidden"  id="skEmpresaSocioEmisor" name="skEmpresaSocioEmisor" >
                        <input type="hidden"  id="sRazonSocialEmisor" name="sRazonSocialEmisor" >
                    </div>
                </div>

                <!-- Proovedor -->
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span>  RFC Emisor</h4>
                        <label type="text" disabled class="form-control" id="sRFCEmisorD"  ></label>
                        <input type="hidden"  id="sRFCEmisor" name="sRFCEmisor" >

                    </div>
                </div>
                <!-- Proovedor -->
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span>  Regimen Fiscal</h4>
                        <label type="text" disabled class="form-control" id="sRegimenFiscalD"  ></label>
                        <input type="hidden"  id="sRegimenFiscal" name="sRegimenFiscal" >
                    </div>
                </div>
                <div class="col-md-2 col-lg-2">
                   <div class="form-group">
                       <h4 class="example-title"><span style="color:red;">* </span> Folio:</h4>
                       <label type="text" disabled class="form-control" id="iFolioD"  ></label>
                       <input type="hidden"  id="iFolio" name="iFolio" >
                   </div>
               </div>
               <div class="col-md-2 col-lg-2">
                   <div class="form-group">
                       <h4 class="example-title"><span style="color:red;">* </span> Tipo de Comprobante:</h4>
                       <label type="text" disabled class="form-control" id="sTipoComprobanteD"  ></label>
                       <input type="hidden"  id="sTipoComprobante" name="sTipoComprobante" >
                   </div>
               </div>
               <div class="col-md-2 col-lg-2">
                   <div class="form-group">
                       <h4 class="example-title"><span style="color:red;">* </span> Serie</h4>
                       <label type="text" disabled class="form-control" id="sSerieD"  ></label>
                       <input type="hidden"  id="sSerie" name="sSerie" >
                   </div>
               </div>
               <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Fecha Pago:</h4>
                        <label type="text" disabled class="form-control" id="dFechaPagoD"  ></label>
                        <input type="hidden"  id="dFechaPago" name="dFechaPago" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> No Operacion:</h4>
                        <label type="text" disabled class="form-control" id="sNumeroOperacionD"  ></label>
                        <input type="hidden"  id="sNumeroOperacion" name="sNumeroOperacion" >
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
                          <input type="hidden"  id="skEmpresaSocioFacturar" name="skEmpresaSocioFacturar" >
                          <input type="hidden"  id="sRazonSocialReceptor" name="sRazonSocialReceptor" >
                      </div>
                  </div>

                  <!-- Proovedor -->
                  <div class="col-md-2 col-lg-2">
                      <div class="form-group">
                          <h4 class="example-title"><span style="color:red;">* </span>  RFC Receptor</h4>
                          <label type="text" disabled class="form-control" id="sRFCReceptorD"  ></label>
                          <input type="hidden"  id="sRFCReceptor" name="sRFCReceptor" >
                      </div>
                  </div>
                  <!-- Proovedor -->
                  <div class="col-md-2 col-lg-2">
                      <div class="form-group">
                          <h4 class="example-title"><span style="color:red;">* </span>  Uso CFDI</h4>
                          <label type="text" disabled class="form-control" id="skUsoCFDID"  ></label>
                          <input type="hidden"  id="skUsoCFDI" name="skUsoCFDI" >
                      </div>
                  </div>

                </div>
            </div>
            <h5 class="card-title margin-bottom-20">
                <i class="icon wb-users"></i>
                <span>RESPONSABLE</span>
            </h5>
            <div class="col-md-12">
                <div class="row row-lg">
                    <!-- Proovedor -->
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span>  Responsable</h4>
                            <select name="skEmpresaSocioResponsable" id="skEmpresaSocioResponsable" class="form-control" data-plugin="select2" data-ajax--cache="true" >
                            
                        </select>



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
                
                  <div class="col-md-2 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Forma de Pago</h4>
                        <label type="text" disabled class="form-control" id="skFormaPagoD"  ></label>
                        <input type="hidden"  id="skFormaPago" name="skFormaPago" >
                    </div>
                </div>
                <div class="col-md-2 col-lg-4">
                  <div class="form-group">
                      <h4 class="example-title"><span style="color:red;">* </span> Metodo de Pago</h4>
                      <label type="text" disabled class="form-control" id="skMetodoPagoD"  ></label>
                      <input type="hidden"  id="skMetodoPago" name="skMetodoPago" >
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
                        <input type="hidden"  id="fTotal" name="fTotal" >
                    </div>
                </div>
            </div>
        </div>

        <h5 class="card-title margin-bottom-20">
            <i class="icon wb-layout"></i>
            <span>SAT</span>
        </h5>
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
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> No Certificado SAT:</h4>
                        <label type="text" disabled class="form-control" id="sNoCertificadoSATD"  ></label>
                        <input type="hidden"  id="sNumeroCertificadoSAT" name="sNumeroCertificadoSAT" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Version</h4>
                        <label type="text" disabled class="form-control" id="sVersionD"  ></label>
                        <input type="hidden"  id="sVersion" name="sVersion" >
                    </div>
                </div>

              </div>
        </div>
          <div class="col-md-12">
              <div class="row row-lg">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Sello CFD:</h4>
                        <label  disabled class="form-control" id="sSelloCFDD"  ></label>
                        <input type="hidden"  id="sSello" name="sSello" >
                    </div>
                </div>
              </div>
          </div>
          <div class="col-md-12">
              <div class="row row-lg">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <h4 class="example-title"><span style="color:red;">* </span> Sello SAT:</h4>
                        <label  disabled class="form-control" id="sSelloSATD"  ></label>
                        <input type="hidden"  id="sSelloSAT" name="sSelloSAT" >
                    </div>
                </div>
              </div>
          </div>



    </div>
</div>
<div id="dvDatosConceptosFactura" hidden>
      <div class="panel panel-bordered panel-dark panel-line">
              <div class="panel-heading">
                  <h3 class="panel-title">Conceptos / Servicios</h3>
              </div>
              <div class="panel-body container-fluid">
                  <div class="row row-lg">
                    <div class="col-md-12">
                      <div class="table-responsive clearfix" style="height:400px;overflow-y:visible;font-size: 10pt;">
                          <table class="table table-bordered" id="tablaConcepts">
                              <thead>
                                  <th class="col-xs-1 col-md-1" data-override="ClaveProdServ">ClaveProdServ</th>
                                  <th class="col-xs-1 col-md-1" data-override="Cantidad">Cantidad</th>
                                  <th class="col-xs-1 col-md-1" data-override="Unidad">Unidad</th>
                                  <th class="col-xs-1 col-md-1" data-override="ClaveUnidad">ClaveUnidad</th>
                                  <th class="col-xs-1 col-md-1" data-override="NoIdentificacion">Identificacion</th>
                                  <th class="col-xs-4 col-md-4" data-override="Descripcion">Descripcion</th>
                                  <th class="col-xs-1 col-md-1" data-override="ValorUnitario">Valor Unitario</th>
                                  <th class="col-xs-1 col-md-1" data-override="Importe">Importe</th>


                              </thead>
                              <tbody id="itemsConceptos" class="searchableRef">
                              </tbody>
                          </table>
                      </div>
                    </div>
                  </div>

              </div>

            </div>
</div>

<div id="dvDatosPagosFactura" hidden>
      <div class="panel panel-bordered panel-dark panel-line">
              <div class="panel-heading">
                  <h3 class="panel-title">Pagos Relacionados</h3>
              </div>
              <div class="panel-body container-fluid">
                  <div class="row row-lg">
                    <div class="col-md-12">
                      <div class="table-responsive clearfix" style="height:400px;overflow-y:visible;font-size: 10pt;">
                          <table class="table table-bordered" id="tablaPagos">
                              <thead>
 
                                  <th class="col-xs-1 col-md-1" data-override="sFolio">Folio</th>
                                  <th class="col-xs-1 col-md-1" data-override="sSerie">Serie</th>
                                  <th class="col-xs-1 col-md-1" data-override="iNumeroParcialidad">Parcialidad</th>
                                  <th class="col-xs-1 col-md-1" data-override="fImporteSaldoPago">Pago</th>
                                  <th class="col-xs-1 col-md-1" data-override="fImporteSaldoAnterior">Saldo Anterior</th>
                                  <th class="col-xs-4 col-md-4" data-override="fImporteSaldoInsoluto">Saldo Insoluto</th> 


                              </thead>
                              <tbody id="itemsPagos" class="searchablePag">
                              </tbody>
                          </table>
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

                 if (response.datos.Emisor.Nombre != null) {
                   $('#sEmisorD').text(response.datos.Emisor.Nombre);
                   $('#sRazonSocialEmisor').val(response.datos.Emisor.Nombre);
                   $('#skEmpresaSocioEmisor').val(response.datos.Emisor.skEmpresaSocioEmisor);
                  } else {
                    $('#sEmisorD').text('N/D');
                    $('#sRazonSocialEmisor').val('');
                    $('#skEmpresaSocioEmisor').val('');
                  }
                 if (response.datos.Emisor.Rfc != null) {
                     $('#sRFCEmisorD').text(response.datos.Emisor.Rfc);
                     $('#sRFCEmisor').val(response.datos.Emisor.Rfc);
                  } else {
                     $('#sRFCEmisorD').text('N/D');
                     $('#sRFCEmisor').val('');
                 }
                 if (response.datos.Emisor.RegimenFiscal != null) {
                     $('#sRegimenFiscalD').text(response.datos.Emisor.RegimenFiscal);
                     $('#sRegimenFiscal').val(response.datos.Emisor.RegimenFiscal);
                  } else {
                     $('#sRegimenFiscalD').text('N/D');
                     $('#sRegimenFiscal').val('');
                 }
                /* FIN  EMISOR */

                /* INICIO RECEPTOR */

                 if (response.datos.Receptor.Nombre != null) {
                   $('#sReceptorD').text(response.datos.Receptor.Nombre);
                   $('#sRazonSocialReceptor').val(response.datos.Receptor.Nombre);
                   $('#skEmpresaSocioFacturar').val(response.datos.Receptor.skEmpresaSocioFacturar);
                  } else {
                     $('#sReceptorD').text('N/D');
                     $('#sRazonSocialReceptor').val('');
                     $('#skEmpresaSocioFacturar').val('');
                  }
                 if (response.datos.Receptor.Rfc != null) {
                     $('#sRFCReceptorD').text(response.datos.Receptor.Rfc);
                     $('#sRFCReceptor').val(response.datos.Receptor.Rfc);
                  } else {
                     $('#sRFCReceptorD').text('N/D');
                     $('#sRFCReceptor').val('');
                 }
                 if (response.datos.Receptor.UsoCFDI != null) {
                     $('#skUsoCFDID').text(response.datos.Receptor.UsoCFDI);
                     $('#skUsoCFDI').val(response.datos.Receptor.skUsoCFDI);
                  } else {
                     $('#skUsoCFDID').text('N/D');
                     $('#skUsoCFDI').val('');
                 }
                 /*if (response.datos.Responsable.skEmpresaSocioResponsable != null) {
                     $('#sResponsable').text(response.datos.Responsable.sNombre);
                     $('#skEmpresaSocioResponsable').val(response.datos.Responsable.skEmpresaSocioResponsable);
                  } else {
                     $('#sResponsable').text('N/D');
                     $('#skEmpresaSocioResponsable').val('');
                 }*/
                 /*if (response.datos.Cliente.skEmpresaSocioCliente != null) {
                      $('#skEmpresaSocioCliente').val(response.datos.Cliente.skEmpresaSocioCliente);
                      $('#sRFCCliente').val(response.datos.Cliente.sRFCCliente);
                  } else {
                      $('#skEmpresaSocioCliente').val('');
                      $('#sRFCCliente').val('');
                 }*/
                /* FIN  RECEPTOR */

                $("#dvDatosGeneralesFactura").css("display", "block");


                 if (response.datos.comprobante.Folio != null) {
                     $('#iFolioD').text(response.datos.comprobante.Folio);
                     $('#iFolio').val(response.datos.comprobante.Folio);
                  } else {
                     $('#iFolioD').text('N/D');
                     $('#iFolio').val('');
                  }
                  if (response.datos.comprobante.TipoDeComprobante != null) {
                     $('#sTipoComprobanteD').text(response.datos.comprobante.TipoDeComprobante);
                     $('#sTipoComprobante').val(response.datos.comprobante.TipoDeComprobante);
                  } else {
                     $('#sTipoComprobanteD').text('N/D');
                     $('#sTipoComprobante').val('');
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
                     $('#fTotal').val(response.datos.comprobante.Total);
                 } else {
                     $('#fTotalD').text('N/D');
                     $('#fTotal').val('');
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
                  if (response.datos.Complemento.SelloCFD != null) {
                      $('#sSelloCFDD').text(response.datos.Complemento.SelloCFD);
                      $('#sSello').val(response.datos.Complemento.SelloCFD);
                     } else {
                      $('#sSelloCFDD').text('N/D');
                      $('#sSello').val('');
                    }
                   if (response.datos.Complemento.RfcProvCertif != null) {
                     $('#sRFCProveedorCertificado').val(response.datos.Complemento.RfcProvCertif);
                   }else{
                     $('#sRFCProveedorCertificado').val('');
                   }

                   if (response.datos.Complemento.NoCertificadoSAT != null) {
                       $('#sNoCertificadoSATD').text(response.datos.Complemento.NoCertificadoSAT);
                       $('#sNumeroCertificadoSAT').val(response.datos.Complemento.NoCertificadoSAT);
                    } else {
                       $('#sNoCertificadoSATD').text('N/D');
                       $('#sNumeroCertificadoSAT').val('');
                    }

                     if (response.datos.Complemento.SelloSAT != null) {
                        $('#sSelloSATD').text(response.datos.Complemento.SelloSAT);
                        $('#sSelloSAT').val(response.datos.Complemento.SelloSAT);
                     } else {
                        $('#sSelloSATD').text('N/D');
                        $('#sSelloSAT').val('');
                     }


                   if (response.datos.sXML != null) {
                        $('#sXML').val(response.datos.sXML);
                    } else {
                        $('#sXML').val('');
                    }
                   var conceptos = '';
                  if (response.datos.Conceptos.length > 0) {
                      $.each(response.datos.Conceptos, function (k, v) {
                        var datoConceptos = JSON.stringify(v);
                          conceptos += '<tr>'+
                          '<td><textarea name="datosConceptos[]" style="display:none">' + datoConceptos + ' </textarea>' + v.ClaveProdServ + '</td>'+
                          //'<td>' + v.ClaveProdServ + '</td>'+
                          '<td>' + v.Cantidad + '</td>'+
                          '<td>' + v.Unidad + '</td>'+
                          '<td>' + v.ClaveUnidad + '</td>'+
                          '<td>' + v.NoIdentificacion + '</td>'+
                          '<td>' + v.Descripcion + '</td>'+
                          '<td>' + v.ValorUnitario + '</td>'+
                          '<td>' + v.Importe + '</td>'+
                           '</tr>';
                      });
                      $("#itemsConceptos").append(conceptos);
                      $("#dvDatosConceptosFactura").css("display", "block");
                    
                  }
                  var pagos = '';
                  if (response.datos.Pagos) {
                      $.each(response.datos.Pagos, function (k, v) {
                        var datoPagos = JSON.stringify(v);
                          pagos += '<tr>'+
                          '<td><textarea name="datosPagos[]" style="display:none">' + datoPagos + ' </textarea>' + v.sFolio + '</td>'+
                          '<td>' + v.sSerie + '</td>'+
                          '<td>' + v.iNumeroParcialidad + '</td>'+
                          '<td>' + v.fImporteSaldoPago + '</td>'+
                          '<td>' + v.fImporteSaldoAnterior + '</td>'+
                          '<td>' + v.fImporteSaldoInsoluto + '</td>'+
                        '</tr>';
                      });
                      $("#itemsPagos").append(pagos);
                      $("#dvDatosPagosFactura").css("display", "block");
            
                  }

                  return true;

          });
}
$(document).ready(function () {
  $('#core-guardar').formValidation(core.formValidaciones);
  core.autocomplete2('#skEmpresaSocioResponsable', 'getEmpresas', window.location.href, 'EMPRESA RESPONSABLE',{
                skEmpresaTipo : '[ "AGAD" ]'
            });
  //core.autocomplete2('#skCentroCosto', 'getCentrosCosto', window.location.href, 'Centros de Costo');
  $('.dropify').dropify();
});
</script>
