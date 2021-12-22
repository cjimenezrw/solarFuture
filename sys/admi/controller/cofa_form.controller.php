<?php

/**
 * Cofa_form_Controller
 *
 * API Facturacion (Cofa_form)
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
 */
Class Cofa_form_Controller Extends Admi_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran;

        private $skPuestoGral;


    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_facturas';
    }

    public function __destruct() {

    }

    /**
     * guardar
     *
     * Guardar API Facturas (cofa-form)
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function guardar() {

        $this->data = ['success'=>NULL,'message'=>NULL,'datos'=>NULL];

        Conn::begin($this->idTran);

        // Obtener datos de factura de información
            if(!$this->getInputData()){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // Validamos los datos de entrada
        $validarDatos = $this->validar_datos_facturas();

        if(!$validarDatos['success']){
            Conn::rollback($this->idTran);
            return $this->data;
        }
        // Guardar facturas



            $facturas = $this->facturas();
            if(!$facturas['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
           


        // Guardar facturas Servicios
            if(isset($this->admi['servicios']) && !empty($this->admi['servicios'])){
                $facturas_servicios = $this->facturas_servicios();
                if(!$facturas_servicios['success']){
                    Conn::rollback($this->idTran);
                    return $this->data;
                }
            }
            // Guardar facturas impuestos
          /*  if(isset($this->admi['impuestos']) && !empty($this->admi['impuestos'])){
                $facturas_impuestos = $this->facturas_impuestos();
                if(!$facturas_impuestos['success']){
                    Conn::rollback($this->idTran);
                    return $this->data;
                }
            }*/
        // Actualizar orden de Cobro
            if(isset($this->admi['skOrdenServicio']) && !empty($this->admi['skOrdenServicio'])){
                $facturas_ordenesServicios = $this->facturas_ordenesServicios();
                if(!$facturas_ordenesServicios['success']){
                    Conn::rollback($this->idTran);
                    return $this->data;
                }
            }

           


        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['message'] = 'Registro guardado con éxito.';
        return $this->data;
    }

    /**
     * validar_datos_facturas
     *
     * Valida los datos de facturas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function validar_datos_facturas(){
        $this->data['success'] = TRUE;
        $validations = [
            'skEmpresaSocioResponsable'=>['message'=>'EMPRESA RESPONSABLE'],
            'skEmpresaSocioEmisor'=>['message'=>'EMISOR'],
            'fSubtotal'=>['message'=>'SUBTOTAL','requerido' => false,'validations'=>['decimal']],
            'fTotal'=>['message'=>'TOTAL','requerido' => false,'validations'=>['decimal']],
            'fDescuento'=>['message'=>'DESCUENTO','requerido' => false,'validations'=>['decimal']],
            'fImpuestosRetenidos'=>['message'=>'IMPUESTOS RETENIDOS','requerido' => false,'validations'=>['decimal']],
            'fImpuestosTrasladados'=>['message'=>'IMPUESTOS TRASLADADOS','requerido' => false,'validations'=>['decimal']],
            'dFechaServicio'=>['message'=>'FECHA DE SERVICIO','requerido' => false,'validations'=>['date']]

        ];

        foreach($validations AS $k=>$v){
            if((!isset($this->admi[$k]) || empty(trim($this->admi[$k]))) && (isset($v['requerido']) && ($v['requerido']) )){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return $this->data;
            }
            if(isset($v['validations']) && (isset($this->admi[$k]) && !empty(trim($this->admi[$k])))){
                foreach($v['validations'] AS $valid){
                    switch ($valid) {
                        case 'integer':
                            $this->admi[$k] = str_replace(',','',$this->admi[$k]);
                            if(!preg_match('/^[0-9]+$/', $this->admi[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                return $this->data;
                            }
                        break;
                        case 'decimal':
                            $this->admi[$k] = str_replace(',','',$this->admi[$k]);
                            if(!preg_match('/^[0-9.]+$/', $this->admi[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                return $this->data;
                            }
                        break;
                        case 'date':
                            $this->admi[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->admi[$k])));
                            if(!preg_match('/^[0-9\/-]+$/', $this->admi[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - FECHA NO VALIDA';
                                return $this->data;
                            }
                        break;
                    }
                }
            }
        }
        return $this->data;
    }

    /**
     * facturas
     *
     * Guardar facturas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function facturas(){
        $this->admi['axn'] = 'guardar';
        $this->admi['skEstatus'] = 'PE';
          if(isset($this->admi['skOrdenServicio']) && !empty($this->admi['skOrdenServicio'])){
            if(!is_array($this->admi['skOrdenServicio'])){
                $this->admi['skOrdenServicio'] = $this->admi['skOrdenServicio'];
            }
          }
        $stpCUD_facturas = parent::stpCUD_facturas();


        if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS GENERALES DE FACTURAS.';
            return $this->data;
        }

        $this->admi['skFactura'] = $stpCUD_facturas['skFactura'];

        $this->data['datos']['skFactura'] = $stpCUD_facturas['skFactura'];

        $this->data['success'] = TRUE;
        $this->data['message'] = 'GENERALES DE FACTURAS GUARDADO.';
        return $this->data;
    }

 




    /**
     * facturas_servicios
     *
     * Guardar facturas Servicios
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function facturas_servicios(){

        $this->admi['axn'] = "facturas_servicios_delete";
        $stpCUD_facturas = parent::stpCUD_facturas();
        if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL PROCESAR LOS SERVICIOS.';
            return $this->data;
        }



        foreach ($this->admi['servicios'] AS $srv){
            // AQUI VAN LOS SERVICIOS NORMALES.
            $this->admi['axn'] = "facturas_servicios";

            $this->admi['skServicio']           = (isset($srv['skServicio']) ? $srv['skServicio'] : NULL);
            $this->admi['sDescripcion']         = (isset($srv['sDescripcion']) ? $srv['sDescripcion'] : NULL);
            $this->admi['skUnidadMedida']         = (isset($srv['skUnidadMedida']) ? $srv['skUnidadMedida'] : NULL);
            $this->admi['fCantidad']            = (isset($srv['fCantidad']) ? str_replace(',','',$srv['fCantidad']) : NULL);
            $this->admi['fPrecioUnitario']      = (isset($srv['fPrecioUnitario']) ? str_replace(',','',$srv['fPrecioUnitario']) : NULL);
            $this->admi['fImporte']             = (isset($srv['fImporte']) ? str_replace(',','',$srv['fImporte']) : NULL);
            $this->admi['fDescuento']             = (isset($srv['fDescuento']) ? str_replace(',','',$srv['fDescuento']) : NULL);
            $this->admi['fImpuestosTrasladados']  = (isset($srv['fImpuestosTrasladados']) ? str_replace(',','',$srv['fImpuestosTrasladados']) : NULL);
            $this->admi['fImpuestosRetenidos']    = (isset($srv['fImpuestosRetenidos']) ? str_replace(',','',$srv['fImpuestosRetenidos']) : NULL);
         
            $stpCUD_facturas = parent::stpCUD_facturas();
          
            if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL CONCEPTO.';
                return $this->data;
            }

            $this->admi['skFacturaServicio'] = $stpCUD_facturas['skFacturaServicio'];

            if(!empty($this->admi['fImpuestosTrasladados'])){
                    $this->admi['axn'] = "facturas_servicios_impuestos";
                    $this->admi['fImporte']        = (isset($this->admi['fImpuestosTrasladados']) ? str_replace(',','',$this->admi['fImpuestosTrasladados']) : NULL);
                    $this->admi['skImpuesto'] = "TRAIVA";
                    $stpCUD_facturas = parent::stpCUD_facturas();
                    if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                        return $this->data;
                    }
            }
            if(!empty($this->admi['fImpuestosRetenidos'])){
                    $this->admi['axn'] = "facturas_servicios_impuestos";
                    $this->admi['fImporte']        = (isset($this->admi['fImpuestosRetenidos']) ? str_replace(',','',$this->admi['fImpuestosRetenidos']) : NULL);
                    $this->admi['skImpuesto'] = "RETIVA";
                    $stpCUD_facturas = parent::stpCUD_facturas();
                    if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                        return $this->data;
                    }
            }


        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'SERVICIOS DE FACTURAS GUARDADOS.';
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
     * facturas_impuestos
     *
     * facturas_impuestos
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    /*private function facturas_impuestos(){
        $this->admi['axn'] = 'facturas_impuestos';

        foreach ($this->admi['impuestos'] AS $imp){
            // AQUI VAN LOS SERVICIOS NORMALES.

            $this->admi['skImpuesto']           = (isset($imp['skImpuesto']) ? $imp['skImpuesto'] : NULL);
            $this->admi['skTipoImpuesto']       = (isset($imp['skTipoImpuesto']) ? $imp['skTipoImpuesto'] : NULL);
            $this->admi['fTasa']                = (isset($imp['fTasa']) ? $imp['fTasa'] : NULL);
            $this->admi['fImporte']              = (isset($imp['fImporte']) ? str_replace(',','',$imp['fImporte']) : NULL);

            $stpCUD_facturas = parent::stpCUD_facturas();
            if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO.';
                return $this->data;
            }


        }

        $this->data['success'] = TRUE;
        $this->data['message'] = ' IMPUESTOS GUARDADOS CORRECTAMENTE EN FACTURA.';
        return $this->data;
    }*/
        /**
         * facturas_ordenesServicios
         *
         * facturas_ordenesServicios
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        private function facturas_ordenesServicios(){
            $this->admi['axn'] = 'facturas_ordenesServicios';


            if(!is_array($this->admi['skOrdenServicio'])){
                $this->admi['skOrdenServicio'] = $this->admi['skOrdenServicio'];
                $stpCUD_facturas = parent::stpCUD_facturas();
                if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL ACTUALIZAR ESTATUS ORDEN DE PAGO.';
                    return $this->data;
                }
            }else{

                $ordenesServicios = $this->admi['skOrdenServicio'];

                foreach ($ordenesServicios AS $value) {
                    $this->admi['skPago'] = $value;

                    $stpCUD_facturas = parent::stpCUD_facturas();
                    if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL ACTUALIZAR ESTATUS ORDEN DE PAGO.';
                        return $this->data;
                    }
                }

            }


            $this->data['success'] = TRUE;
            $this->data['message'] = 'ESTATUS DE ORDEN DE PAGO ACTUALIZADO.';
            return $this->data;
        }
         
 
        

}
