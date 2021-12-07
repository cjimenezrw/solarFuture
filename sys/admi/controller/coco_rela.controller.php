<?php

/**
 * Coco_rela_Controller
 *
 * Formulario de Relacion de Comprobante con Ordenes de Servicio (coco-rela)
 *
 * @author  <lvaldez>
 */
Class Coco_rela_Controller Extends Admi_Model {

    // CONST //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran; 

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_comprobanteCFDI'; 
    }

    public function __destruct() {

    }

  /**
     * guardar
     *
     * Guardar
     *
     * @author  <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function guardar(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>[]];
        Conn::begin($this->idTran);

        // Obtener datos de entrada de información
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // Validamos los datos de entrada
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        $this->admi['skComprobanteCFDI'] = (isset($_POST['skComprobanteCFDI']) ? $_POST['skComprobanteCFDI'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        // Guardar Relacion
            $guardar_relacion_comprobante_orden= $this->guardar_relacion_comprobante_orden();
            if(!$guardar_relacion_comprobante_orden['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['message'] = 'COMPROBANTE RELACIONADO CON ÉXITO';
        return $this->data;
    }

  /**
     * guardar_relacion_comprobante_orden
     *
     * Guardar la relacion del comprobante con orden de servicio
     *
     * @author  <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function guardar_relacion_comprobante_orden(){
        $this->data['success'] = TRUE;
        
        $this->admi['axn'] = 'guardar_relacion_comprobante_orden';
        
        // OBTENEMOS EL COMPROBANTE ACTUAL
            $consultar_comprobante = parent::consultar_comprobante();
            if(!$consultar_comprobante){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'NO SE PUDO OBTENER EL COMPROBANTE';
                return $this->data;
            }
            
        // VALIDAMOS QUE ESTÉ ACTIVO EL COMPROBANTE Y TENGA SALDO //
            if(in_array($consultar_comprobante['skEstatus'],['FI','CA'])){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'EL COMPROBANTE NO SE PUEDE RELACIONAR POR EL ESTATUS';
                return $this->data;
            }
        
        // OBTENEMOS LAS ORDENES DE SERVICIO A APLICAR IMPORTE
            $_get_saldo_ordenes = parent::_get_saldo_ordenes();
            if(!$_get_saldo_ordenes){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'NO SE PUDO OBTENER EL SALDO DE LAS ORDENES';
                return $this->data;
            }
           
           
        // PREPARAMOS LOS DATOS PARA LA APLICACIÓN DEL IMPORTE
            $sumaImporte = 0;
            foreach($_get_saldo_ordenes AS &$row){
                if(!isset($this->admi['importeAplicado'][$row['skOrdenServicio']])){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'NO SE PUDO OBTENER LA ORDEN DE SERVICIO';
                    return $this->data;
                }

                // VERIFICAMOS SI EL IMPORTE ES MAYOR AL SALDO, ENTONCES ASIGNAMOS EL IMPORTE IGUAL AL SALDO
                    $row['fImporte'] = (($this->admi['importeAplicado'][$row['skOrdenServicio']] > $row['fSaldoRelacion']) ? $row['fSaldoRelacion'] : $this->admi['importeAplicado'][$row['skOrdenServicio']]);
                    $sumaImporte += $row['fImporte'];
                    
                // VERIFICAMOS LA FORMA DE PAGO Y MÉTODO DE PAGO DE LA ORDEN DE SERVICIO
                        // Método de Pago => Pago en una solo Exhibición (PUE)
                   
                    
                    
                 
            }
            
        // VALIDAMOS QUE LA SUMA DEL IMPORTE A APLICAR NO SEA MAYOR AL SALDO DE LA TRANSACCIÓN
            if( (double)filter_var($sumaImporte, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) > (double)filter_var($consultar_comprobante['fSaldoRelacionado'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ){
                $this->data['success'] = FALSE;
                $this->data['message'] = "EL TOTAL DEL IMPORTE A APLICAR ES MAYOR AL SALDO DISPONIBLE: <b><br>SALDO $".number_format($consultar_comprobante['fSaldoRelacionado'],2)." <br>IMPORTE $".number_format($sumaImporte,2)."</b>";
                return $this->data;
            }
      
        // RELACIONAMOS EL COMPROBANTE CON LA ORDEN DE SERVICIO

            foreach($_get_saldo_ordenes AS &$row){
                $this->admi['skOrdenServicio'] = $row['skOrdenServicio'];
                $this->admi['fImporte'] = $row['fImporte'];

                $stpCUD_comprobanteCFDI = parent::stpCUD_comprobanteCFDI();
                if(!$stpCUD_comprobanteCFDI || isset($stpCUD_comprobanteCFDI['success']) && $stpCUD_comprobanteCFDI['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE APLICACIÓN DE PAGO';
                    return $this->data;
                }
            }
        
        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE APLICACIÓN RELACIONADOS CON EXITO';
        return $this->data;
    }

  /**
     * consultar
     *
     * Obtenemos los datos del formulario de la transacción
     *
     * @author <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function consultar() {
        $this->data['success'] = TRUE;

        $this->admi['skComprobanteCFDI'] = (isset($_POST['skComprobanteCFDI']) ? $_POST['skComprobanteCFDI'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        if(empty($this->admi['skComprobanteCFDI'])){
            DLOREAN_Model::showError('NO SE ENCONTRÓ EL COMPROBANTE',404);
        }
        
        $this->data['datos'] = parent::consultar_comprobante();
        
        if(!$this->data['datos']){
            DLOREAN_Model::showError('NO SE LA ORDEN DE SERVICIO',404);
        }

        $this->admi['skEmpresaSocioResponsable'] = $this->data['datos']['skEmpresaSocioResponsable'];
        $this->admi['skEmpresaSocioCliente'] = $this->data['datos']['skEmpresaSocioCliente'];
        $this->admi['skDivisa'] = $this->data['datos']['skDivisa'];
        $this->data['ordenes'] = parent::_get_ordenes_pendientes_relacion();
        
        return $this->data;
    }

  /**
     * validar_datos_entrada
     *
     * Valida los datos del la entrada
     *
     * @author <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        
        $validations = [
            'ordenes'=>['message'=>'ORDENES']
        ];
        
        foreach($validations AS $k=>$v){
            if(isset($this->admi[$k]) && is_array($this->admi[$k])){
                continue; 
            }
            if(!isset($this->admi[$k]) || empty(trim($this->admi[$k]))){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return $this->data;
            }
            if(isset($v['validations'])){
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
     * getInputData
     *
     * Obtener datos de entrada de información
     *
     * @author <lvaldez>
     * @return Boolean TRUE | FALSE
     */
    private function getInputData(){
        $this->data['success'] = TRUE;
        
        if(!$_POST && !$_GET){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'NO SE RECIBIERON DATOS';
            return $this->data;
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

        return $this->data;
    }
}
