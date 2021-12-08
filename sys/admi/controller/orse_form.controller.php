<?php

Class Orse_form_Controller Extends Admi_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //

    private $data = array();
    private $idTran;

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_ordenServicio';
    }

    public function __destruct() {

    }

    public function consultarOrdenServicio() {
        $this->data['formaPago'] = parent::consultar_formasPago();
        $this->data['metodoPago'] = parent::consultar_metodosPago();
        $this->data['usoCFDI'] = parent::consultar_usosCFDI(); 

        $this->data['Estatus'] = parent::consultar_core_estatus(['AC', 'IN'], true);
        //$this->log($MENSAGE, $FORZAR_ESCRITURA,$LIMPIAR_ANTES);

        if (isset($_GET['p1'])) {
            $this->admi['skOrdenServicio'] = $_GET['p1'];
 
            $this->data['datos'] = parent::_getOrdenServicio();
            $this->data['serviciosOrdenes'] = parent::_getOrdenServicioServicios(); 
          

         



        }
        return $this->data;
    }
  

    public function guardar() {
        
        $this->data['success'] = FALSE;
        $this->data['message'] = 'No se recibieron los datos.';
        $this->data['datos'] = FALSE;

            Conn::begin($this->idTran);

        // Obtener datos de Orden de servicio de información
            if(!$this->getInputData()){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // Validamos los datos de Orden de servicio
            if(!$this->validar_datos_ordenes()){
                Conn::rollback($this->idTran);
                return $this->data;
            }

 

            $facturas = $this->ordenes();
            if(!$facturas['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }



        // Guardar facturas Servicios
            if(isset($this->admi['conceptos']) && !empty($this->admi['conceptos'])){
                $ordenes_servicios = $this->ordenes_servicios();
                if(!$ordenes_servicios['success']){
                    Conn::rollback($this->idTran);
                    return $this->data;
                }
            }
            //if(isset($this->admi['skCodigo']) && !empty($this->admi['skCodigo'])){
                $ordenes_procesos = $this->ordenes_procesos();
                if(!$ordenes_procesos['success']){
                    Conn::rollback($this->idTran);
                    return $this->data;
                }
            //}

      
            


          Conn::commit($this->idTran);
          $this->data['success'] = TRUE;
          $this->data['message'] = 'Registro insertado con éxito.';
        return $this->data;
    }

        /**
         * getInputData
         *
         * Obtener datos de entrada de información
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Boolean TRUE | FALSE
         */
        private function getInputData(){

            if(!$_POST && !$_GET){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'NO SE RECIBIERON DATOS.';
                return FALSE;
            }

            if($_POST){
                foreach($_POST AS $key=>$val){
                    if(!is_array($val)){
                        $this->admi[$key] = $val;
                        continue;
                    }else{
                        $this->admi[$key] = $val;
                        continue;
                    }
                }
            }

            if($_GET){
                foreach($_GET AS $key=>$val){
                    if(!is_array($val)){
                        $this->admi[$key] = $val;
                        continue;
                    }else{
                        $this->admi[$key] = $val;
                        continue;
                    }
                }
            }

            return TRUE;
        }

        /**
     * validar_datos_facturas
     *
     * Valida los datos de ordenes
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function validar_datos_ordenes(){
        $validations = [
            'skEmpresaSocioResponsable'=>['message'=>'EMPRESA RESPONSABLE','requerido' => true],
            //'skDivisa'=>['message'=>'DIVISA','requerido' => true],
            //'skCentroCosto'=>['message'=>'CENTRO DE COSTO','requerido' => true],
            //'skEmpresaSocioCliente'=>['message'=>'CLIENTE','requerido' => true],
            //'skEmpresaSocioFacturacion'=>['message'=>'FACTURACION','requerido' => true],
            'fImporteSubtotal'=>['message'=>'SUBTOTAL','requerido' => true,'validations'=>['decimal']],
            'fImporteTotal'=>['message'=>'TOTAL','requerido' => false,'validations'=>['decimal']],
            'fDescuento'=>['message'=>'DESCUENTO','requerido' => false,'validations'=>['decimal']],
            //'fTipoCambio'=>['message'=>'TIPO DE CAMBIO','requerido' => false,'validations'=>['decimal']],
            'fImpuestosRetenidos'=>['message'=>'IMPUESTOS RETENIDOS','requerido' => false,'validations'=>['decimal']],
            'fImpuestosTrasladados'=>['message'=>'IMPUESTOS TRASLADADOS','requerido' => false,'validations'=>['decimal']]
            //'dFechaServicio'=>['message'=>'FECHA DE TRANSACCIÓN','requerido' => false,'validations'=>['date']]

        ];

        foreach($validations AS $k=>$v){
            if((!isset($this->admi[$k]) || empty(trim($this->admi[$k]))) && (isset($v['requerido']) && ($v['requerido']) )){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return FALSE;
            }
            if(isset($v['validations']) && (isset($this->admi[$k]) && !empty(trim($this->admi[$k])))){
                foreach($v['validations'] AS $valid){
                    switch ($valid) {
                        case 'integer':
                            $this->admi[$k] = str_replace(',','',$this->admi[$k]);
                            if(!preg_match('/^[0-9]+$/', $this->admi[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                return FALSE;
                            }
                        break;
                        case 'decimal':
                            $this->admi[$k] = str_replace(',','',$this->admi[$k]);
                            if(!preg_match('/^[0-9.]+$/', $this->admi[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                return FALSE;
                            }
                        break;
                        case 'date':
                            $this->admi[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->admi[$k])));
                            if(!preg_match('/^[0-9\/-]+$/', $this->admi[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - FECHA NO VALIDA';
                                return FALSE;
                            }
                        break;
                    }
                }
            }
        }
        return $this->data;
    }


                /**
             * ordenes
             *
             * Guardar ordenes
             *
             * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
             * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
             */
            private function ordenes(){
                 $this->admi['skEmpresaSocioCliente'] = $this->admi['skEmpresaSocioResponsable'];
                $this->admi['skEmpresaSocioFacturar'] = $this->admi['skEmpresaSocioResponsable'];
                $this->admi['skDivisa'] ='MXN';
                $this->admi['fTipoCambio'] =1;
                $this->admi['skEstatus'] = 'PE';
                

                $this->admi['axn'] = 'guardar';



                $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();

                if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
                    Conn::rollback($this->idTran);
                      $this->data['success'] = FALSE;
                      $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS GENERALES DE ORDEN DE SERVICIO.';
                    return $this->data;
                } 
                $this->admi['skOrdenServicio'] = $stpCUD_ordenServicio['skOrdenServicio'];

                $this->data['datos']['skOrdenServicio'] = $stpCUD_ordenServicio['skOrdenServicio'];

                $this->data['success'] = TRUE;
                $this->data['message'] = 'GENERALES DE ORDENES GUARDADO.';
                return $this->data;
            }

    /**
     * ordenes_servicios
     *
     * Guardar Ordenes Servicios
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function ordenes_servicios(){

        $this->admi['axn'] = "ordenes_servicios_delete";
        $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();
        if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL PROCESAR LOS SERVICIOS.';
            return $this->data;
        }

 
        foreach ($this->admi['conceptos'] AS $srv){
            $this->admi['axn'] = "ordenes_servicios";

            // AQUI VAN LOS SERVICIOS NORMALES.
            $this->admi['skServicio']           = (isset($srv['skServicio']) ? $srv['skServicio'] : NULL);
            $this->admi['sDescripcion']         = (isset($srv['sDescripcionConcepto']) ? $srv['sDescripcionConcepto'] : NULL);
            $this->admi['fCantidad']            = (isset($srv['fCantidad']) ? str_replace(',','',$srv['fCantidad']) : NULL);
            $this->admi['skUnidadMedida']         = (isset($srv['skUnidadMedida']) ? str_replace(',','',$srv['skUnidadMedida']) : NULL);
            $this->admi['fPrecioUnitario']      = (isset($srv['fPrecioUnitario']) ? str_replace(',','',$srv['fPrecioUnitario']) : NULL);
            $this->admi['fImporteTotal']        = (isset($srv['fImporte']) ? str_replace(',','',$srv['fImporte']) : NULL);
            $this->admi['fDescuento']           = (isset($srv['fDescuento']) ? str_replace(',','',$srv['fDescuento']) : NULL);
            $this->admi['fImpuestosTrasladados']  = (isset($srv['fImpuestosTrasladados']) ? str_replace(',','',$srv['fImpuestosTrasladados']) : NULL);
            $this->admi['fImpuestosRetenidos']    = (isset($srv['fImpuestosRetenidos']) ? str_replace(',','',$srv['fImpuestosRetenidos']) : NULL);

            //VALIDACION DE DATOS
            if(empty($this->admi['skUnidadMedida']) || empty($this->admi['fCantidad']) || empty($this->admi['skServicio']) ){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'FALTA LLENAR CAMPO REQUERIDO EN CONCEPTO.';
                return $this->data;
            }

            $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();
            if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL CONCEPTO.';
                return $this->data;
            }
            $this->admi['skOrdenServicioServicio'] = $stpCUD_ordenServicio['skOrdenServicioServicio'];

            if(!empty($this->admi['fImpuestosTrasladados'])){
                    $this->admi['axn'] = "ordenes_servicios_impuestos";
                    $this->admi['fImporteTotal']        = (isset($this->admi['fImpuestosTrasladados']) ? str_replace(',','',$this->admi['fImpuestosTrasladados']) : NULL);
                    $this->admi['skImpuesto'] = "TRAIVA";
                    $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();
                    if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                        return $this->data;
                    }
            }
            if(!empty($this->admi['fImpuestosRetenidos'])){
                    $this->admi['axn'] = "ordenes_servicios_impuestos";
                    $this->admi['fImporteTotal']        = (isset($this->admi['fImpuestosRetenidos']) ? str_replace(',','',$this->admi['fImpuestosRetenidos']) : NULL);
                    $this->admi['skImpuesto'] = "RETIVA";
                    $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();
                    if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                        return $this->data;
                    }
            }





        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'SERVICIOS DE ORDENES GUARDADOS.';
        return $this->data;
    }

    /**
     * ordenes_impuestos
     *
     * ordenes_impuestos
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function ordenes_impuestos(){
        $this->admi['axn'] = 'ordenes_impuestos';

        foreach ($this->admi['impuestos'] AS $imp){
            // AQUI VAN LOS SERVICIOS NORMALES.

            $this->admi['skImpuesto']           = (isset($imp['skImpuesto']) ? $imp['skImpuesto'] : NULL);
            $this->admi['skTipoImpuesto']       = (isset($imp['skTipoImpuesto']) ? $imp['skTipoImpuesto'] : NULL);
            $this->admi['fTasa']                = (isset($imp['fTasa']) ? $imp['fTasa'] : NULL);
            $this->admi['fImporte']             = (isset($imp['fImporte']) ? $imp['fImporte'] : NULL);

            $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();
            if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO.';
                return $this->data;
            }


        }

        $this->data['success'] = TRUE;
        $this->data['message'] = ' IMPUESTOS GUARDADOS CORRECTAMENTE EN ORDEN DE SERVICIO.';
        return $this->data;
    }
    /**
    * ordenes_procesos
    *
    * ordenes_procesos
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
    * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
    */
    private function ordenes_procesos(){

        $this->admi['axn'] = "ordenes_procesos_delete";
        $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();
        if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL ELIMINAR LOS PROCESOS.';
            return $this->data;
        }

        $this->admi['axn'] = 'ordenes_procesos';
        $this->admi['skServicioProceso']                = (isset($_POST['skServicioProceso']) ? $_POST['skServicioProceso'] : NULL);
        $this->admi['skCodigo']             = (isset($_POST['skCodigo']) ? $_POST['skCodigo'] : NULL);

        $stpCUD_ordenServicio = parent::stpCUD_ordenServicio();

    
        if(!$stpCUD_ordenServicio || isset($stpCUD_ordenServicio['success']) && $stpCUD_ordenServicio['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS PROCESOS.';
            return $this->data;
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = ' IMPUESTOS GUARDADOS CORRECTAMENTE EN ORDEN DE SERVICIO.';
        return $this->data;
    }

    public function getEmpresas(){
        $this->admi['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        if(isset($_POST['skEmpresaTipo']) && !empty($_POST['skEmpresaTipo'])){
            $skEmpresaTipo = json_decode($_POST['skEmpresaTipo'], true, 512);
            if(!is_array($skEmpresaTipo)){
                $skEmpresaTipo = $_POST['skEmpresaTipo'];
            }
            $this->admi['skEmpresaTipo'] = $skEmpresaTipo;
        }
        return parent::get_empresas();
    }


  public function get_medidas(){
      return parent::consultar_tiposMedidas();
  }
  public function get_servicios(){
      return parent::consultar_servicios();
  }

  public function get_configuracion_socios(){
      $this->admi['skEmpresaSocioCliente'] = (isset($_POST['skEmpresaSocioCliente']) ? $_POST['skEmpresaSocioCliente'] : NULL);
      $this->admi['skEmpresaSocioResponsable'] = (isset($_POST['skEmpresaSocioResponsable']) ? $_POST['skEmpresaSocioResponsable'] : NULL);
      return parent::consultar_configuracion_socios();

  }

  public function get_servicio_impuestos(){
      $this->admi['skServicio'] = (isset($_POST['skServicio']) ? $_POST['skServicio'] : NULL);
      return parent::consultar_servicio_impuestos();

  }


  public function getDomicilios() {
      $this->admi['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
      $this->admi['skEmpresaSocioResponsable'] = (isset($_POST['skEmpresaSocioResponsable']) ? $_POST['skEmpresaSocioResponsable'] : NULL);
      $this->admi['skEmpresaSocioCliente'] = (isset($_POST['skEmpresaSocioCliente']) ? $_POST['skEmpresaSocioCliente'] : NULL);
      $this->admi['skSocioComercial'] = (isset($_POST['skSocioComercial']) ? $_POST['skSocioComercial'] : NULL);
      $this->admi['skEmpresaSocioFacturacion'] = (isset($_POST['skEmpresaSocioFacturacion']) ? $_POST['skEmpresaSocioFacturacion'] : NULL);

        if( $this->admi['skEmpresaSocioFacturacion'] == $this->admi['skEmpresaSocioResponsable']){
          $this->admi['tipoFactura'] = 'Agencia';
        }else{
            if($this->admi['skEmpresaSocioFacturacion'] == $this->admi['skEmpresaSocioCliente']){
                $this->admi['tipoFactura'] = 'Cliente';
            }else{
            $this->admi['tipoFactura'] = 'General';
            }
        }

      $data = parent::consultarDomicilios();

      if (!$data) {
          return FALSE;
      }

      return $data;
    }

  public function get_datos_proceso(){

      $this->admi['skCodigo'] = (isset($_POST['skCodigo']) ? $_POST['skCodigo'] : NULL);
      $this->admi['skServicioProceso'] = (isset($_POST['skServicioProceso']) ? $_POST['skServicioProceso'] : NULL);
      
            if($this->admi['skServicioProceso'] == 'MLCL' || $this->admi['skServicioProceso'] == 'PLCL' ){
                        $this->impo['p1'] = $this->admi['skCodigo'];
                        $datosManiobra= $this->sysAPI('impo', 'mani_deta', 'consultarManiobras', [
                         'GET' => $this->impo
                        ]);
                        $this->data['skEmpresaSocioResponsable'] = $datosManiobra['datos']['skEmpresaSocioResponsable'];
                        $this->data['empresaResponsable'] = $datosManiobra['datos']['nombreAgencia']. "(".$datosManiobra['datos']['rfcAgenciaAduanal'].")"." - Agencia Aduanal";

                        $this->data['skEmpresaSocioCliente'] = $datosManiobra['datos']['skCliente'];
                        $this->data['empresaCliente'] = $datosManiobra['datos']['nombreCliente']. "(".$datosManiobra['datos']['rfcClienteManiobra'].")"." - Cliente";
                        $this->data['skEmpresaSocioDomicilio'] =  NULL;
                        $this->data['empresaSocioDomicilio']  =  NULL;
                        if(!empty($datosManiobra['domicilioReceptor'])){
                            $this->data['skEmpresaSocioDomicilio'] = $datosManiobra['domicilioReceptor']['skEmpresaSocioDomicilio'];
                            $this->data['empresaSocioDomicilio'] = $datosManiobra['domicilioReceptor']['calleReceptor'].",".$datosManiobra['domicilioReceptor']['numeroExteriorReceptor'].",".$datosManiobra['domicilioReceptor']['coloniaReceptor'].",".$datosManiobra['domicilioReceptor']['municipioReceptor'].",".$datosManiobra['domicilioReceptor']['estadoReceptor'].",".$datosManiobra['domicilioReceptor']['paisReceptor'];

                        }
                        $this->data['skEmpresaSocioFacturacion'] = $datosManiobra['datos']['skFacturar'];
                        $this->data['empresaFacturacion'] = $datosManiobra['datos']['nombreEmpresaFacturacion']. "(".$datosManiobra['datos']['nombreEmpresaFacturacionRFC'].")";
                        $this->data['skUsoCFDI'] = $datosManiobra['datos']['skUsoCFDIManiobras'];
                        $this->data['skCentroCosto'] = $datosManiobra['datos']['skCentroCosto'];
                        $this->data['skDivisa'] = $datosManiobra['datos']['skDivisa'];
                        $this->data['sPedimento'] = NULL;
                        $this->data['sReferencia'] = $datosManiobra['datos']['sReferencia'];
                        $this->data['sBl'] = $datosManiobra['datos']['sBLMaster'];
                        $this->data['sBlHouse'] = $datosManiobra['datos']['sBLHouse'];
                        $this->data['sContenedor'] = $datosManiobra['datos']['sContenedor'];
                        $this->data['iCredito'] = (!empty($datosManiobra['datos']['iCredito']) ? $datosManiobra['datos']['iCredito'] : NULL );
                        $this->data['dFechaProgramacionNueva'] = (!empty($datosManiobra['datos']['dFechaProgramacionNueva']) ? date('d/m/Y', strtotime($datosManiobra['datos']['dFechaProgramacionNueva'])) : '');
                        $this->admi['datos'] = $this->data;


                        return $this->admi;


            }
            if($this->admi['skServicioProceso'] == 'RLCL' ){
                        $this->impo['p1'] = $this->admi['skCodigo'];
                        $datosRevalidacion= $this->sysAPI('impo', 'reva_deta', 'consultarRevalidaciones', [
                         'GET' => $this->impo
                        ]);
                        $this->data['skEmpresaSocioResponsable'] = $datosRevalidacion['datos']['skEmpresaSocioResponsable'];
                        $this->data['empresaResponsable'] = $datosRevalidacion['datos']['empresaResponsable']. "(".$datosRevalidacion['datos']['empresaResponsableRFC'].")"." - Agencia Aduanal";

                        $this->data['skEmpresaSocioCliente'] = $datosRevalidacion['datos']['skEmpresaSocioCliente'];
                        $this->data['empresaCliente'] = $datosRevalidacion['datos']['empresaCliente']. "(".$datosRevalidacion['datos']['empresaClienteRFC'].")"." - Cliente";
                        $this->data['skEmpresaSocioDomicilio'] =  NULL;
                        $this->data['empresaSocioDomicilio']  =  NULL;
                        if(!empty($datosRevalidacion['domicilioReceptor'])){
                            $this->data['skEmpresaSocioDomicilio'] = $datosRevalidacion['domicilioReceptor']['skEmpresaSocioDomicilio'];
                            $this->data['empresaSocioDomicilio'] = $datosRevalidacion['domicilioReceptor']['calleReceptor'].",".$datosRevalidacion['domicilioReceptor']['numeroExteriorReceptor'].",".$datosRevalidacion['domicilioReceptor']['coloniaReceptor'].",".$datosRevalidacion['domicilioReceptor']['municipioReceptor'].",".$datosRevalidacion['domicilioReceptor']['estadoReceptor'].",".$datosRevalidacion['domicilioReceptor']['paisReceptor'];

                        }
                        $this->data['skEmpresaSocioFacturacion'] = $datosRevalidacion['datos']['skEmpresaSocioFacturar'];
                        $this->data['empresaFacturacion'] = $datosRevalidacion['datos']['empresaFacturar']. "(".$datosRevalidacion['datos']['empresaFacturarRFC'].")";
                        $this->data['skUsoCFDI'] = $datosRevalidacion['datos']['CFDI'];
                        $this->data['skCentroCosto'] = $datosRevalidacion['datos']['skCentroCosto'];
                        $this->data['skDivisa'] = $datosRevalidacion['datos']['skDivisa'];
                        $this->data['sPedimento'] = NULL;
                        $this->data['sReferencia'] = $datosRevalidacion['datos']['sReferencia'];
                        $this->data['sBl'] = $datosRevalidacion['datos']['sBLMaster'];
                        $this->data['sBlHouse'] = $datosRevalidacion['datos']['sBLHouse'];
                        $this->data['sContenedor'] = $datosRevalidacion['datos']['sContenedor'];
                        $this->data['iCredito'] = (!empty($datosRevalidacion['datos']['iCredito']) ? $datosRevalidacion['datos']['iCredito'] : NULL );
                        $this->data['dFechaProgramacionNueva'] = (!empty($datosRevalidacion['datos']['dFechaRevalidacion']) ? date('d/m/Y', strtotime($datosRevalidacion['datos']['dFechaRevalidacion'])) : '');
                        $this->admi['datos'] = $this->data;


                        return $this->admi;


            }
            
             if($this->admi['skServicioProceso'] == 'FLET' ){
                        $this->impo['p1'] = $this->admi['skCodigo'];
                        $datosFlete= $this->sysAPI('tran', 'cfll_form', 'getData', [
                         'GET' => $this->impo
                        ]);
                        $datosFleteContenedores= $this->sysAPI('tran', 'cfll_form', 'getContenedoresGuardados', [
                         'GET' => $this->impo
                        ]);
                        
                        if(empty($datosFleteContenedores)){
                            $datosFleteContenedores['jsonContenedores'] = '';
                        }
                        $this->data['skEmpresaSocioResponsable'] = $datosFlete['skEmpresaSocioResponsable'];
                        $this->data['empresaResponsable'] = $datosFlete['empresaResponsable'];

                        $this->data['skEmpresaSocioCliente'] = $datosFlete['skEmpresaSocioCliente'];
                        $this->data['empresaCliente'] = $datosFlete['sEmpresaSocioCliente'];
                        $this->data['skEmpresaSocioDomicilio'] =  NULL;
                        $this->data['empresaSocioDomicilio']  =  NULL;
                        
                        if(!empty($datosFlete['domicilioReceptor'])){
                            $this->data['skEmpresaSocioDomicilio'] = NULL;
                            $this->data['empresaSocioDomicilio'] = NULL;
                        }
                        
                        $this->data['skEmpresaSocioFacturacion'] = NULL;
                        $this->data['empresaFacturacion'] = NULL;
                        $this->data['skUsoCFDI'] = NULL;
                        $this->data['skCentroCosto'] = NULL;
                        $this->data['skDivisa'] = 'MXN';
                        $this->data['sPedimento'] = $datosFlete['sPedimento'];
                        $this->data['sReferencia'] = $datosFlete['sReferencia'];
                        $this->data['sBl'] = NULL;
                        $this->data['sBlHouse'] = NULL;
                        $this->data['sContenedor'] = $datosFleteContenedores['jsonContenedores'];
                        $this->data['iCredito'] = NULL;
                        $this->data['Observaciones'] = $datosFlete['sObservaciones'];
                        $this->data['dFechaProgramacionNueva'] =$datosFlete['dFechaSolicitud'];
                        $this->admi['datos'] = $this->data;
                        
                        return $this->admi;


            }
            
            return true;

  }
  
}
