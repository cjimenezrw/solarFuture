<?php

/**
 * Cotr_pago_Controller
 *
 * Formulario de Aplicación de Pago de Transacciones (cotr-pago)
 *
 * @author  <lvaldez>
 */
Class Cotr_pago_Controller Extends Admi_Model {

    // CONST //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran;
        private $skPuestoGral;
        private $visionUsuario;

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_transacciones'; 
    }

    public function __destruct() {

    }

  /**
     * guardar
     *
     * Guardar Transacción
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

        $this->admi['skTransaccion'] = (isset($_POST['skTransaccion']) ? $_POST['skTransaccion'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        // Guardar Transacción
            $guardar_transaccion_aplicacion_pago = $this->guardar_transaccion_aplicacion_pago();
            if(!$guardar_transaccion_aplicacion_pago['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['message'] = 'APLICACIÓN DE PAGO GUARDADA CON ÉXITO';
        return $this->data;
    }

  /**
     * guardar_transaccion_aplicacion_pago
     *
     * Guardar la Aplicación de Pago de la Transacción
     *
     * @author  <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function guardar_transaccion_aplicacion_pago(){
        $this->data['success'] = TRUE;
        
        $this->admi['axn'] = 'guardar_transaccion_aplicacion_pago';
        
        // OBTENEMOS LA TRANSACCIÓN ACTUAL
            $_get_transaccion = parent::_get_transaccion();
            if(!$_get_transaccion){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'NO SE PUDO OBTENER LA TRANSACCIÓN';
                return $this->data;
            }
            
        // VALIDAMOS QUE ESTÉ ACTIVA LA TRANSACCIÓN Y TENGA SALDO //
            if(in_array($_get_transaccion['skEstatus'],['CA','PE','FI'])){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'LA TRANFERENCIA NO ESTÁ AUTORIZADA PARA APLICAR PAGOS';
                return $this->data;
            }
        
        // OBTENEMOS LAS FACTURAS A APLICAR IMPORTE
            $_get_saldo_facturas = parent::_get_saldo_facturas();
            if(!$_get_saldo_facturas){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'NO SE PUDO OBTENER EL SALDO DE LAS FACTURAS';
                return $this->data;
            }
           
           
        // PREPARAMOS LOS DATOS PARA LA APLICACIÓN DEL IMPORTE
            $sumaImporte = 0;
            foreach($_get_saldo_facturas AS &$row){
                if(!isset($this->admi['importeAplicado'][$row['skFactura']])){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'NO SE PUDO OBTENER LA FACTURA';
                    return $this->data;
                }

                // VERIFICAMOS SI EL IMPORTE ES MAYOR AL SALDO, ENTONCES ASIGNAMOS EL IMPORTE IGUAL AL SALDO
                    $row['fImporte'] = (($this->admi['importeAplicado'][$row['skFactura']] > $row['fSaldo']) ? $row['fSaldo'] : $this->admi['importeAplicado'][$row['skFactura']]);
                    $sumaImporte += $row['fImporte'];
                    
                // VERIFICAMOS LA FORMA DE PAGO Y MÉTODO DE PAGO DE LA FACTURA
                        // Método de Pago => Pago en una solo Exhibición (PUE)
                    if($row['codigoMetodoPago'] == 'PUE'){
                        // bcdiv(number,'1',2)
 
                       /* if(bcdiv($this->admi['importeAplicado'][$row['skFactura']],'1',2) != bcdiv($row['fSaldo'],'1',2)){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = "LA FACTURA #".$row['iFolio']." SOLO SE PUEDE PAGAR EN 1 SOLA EXHIBICIÓN: <b><br>SALDO $".number_format($row['fSaldo'],2)." <br>IMPORTE $".number_format($this->admi['importeAplicado'][$row['skFactura']],2)."</b>";
                            return $this->data;
                        }
                        */
                        
                        
                       /* if(bcdiv($this->admi['importeAplicado'][$row['skFactura']],'1',2) != bcdiv($row['fSaldo'],'1',2)){
                            if(date('Ym',strtotime($_get_transaccion['dFechaTransaccion'])) != date('Ym',strtotime($row['dFechaFactura']))){
                            //if(date('Ym',strtotime('15-02-2020')) != date('Ym',strtotime($row['dFechaFactura']))){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = "LA FACTURA #".$row['iFolio']." NO SE PUEDE PAGAR DEBIDO A LA FECHA DE FACTURACIÓN <b>".date('d/m/Y',strtotime($row['dFechaFactura']))."</b> <br><br>SOLO SE PUEDE PAGAR EN EL MISMO MES EN QUE FUE FACTURADA</b>";
                                return $this->data;
                            }
                        }*/
                    }
                    
                    
                // VERIFICAMOS EL PAGO DE FACTURA CON NOTAS DE CRÉDITO (NCRE)
                    if($_get_transaccion['skTipoTransaccion'] == 'NCRE' && $this->admi['importeAplicado'][$row['skFactura']] != $_get_transaccion['fSaldo']){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = "LA FACTURA #".$row['iFolio']." SE LE DEBE DE APLICAR EL TOTAL DEL SALDO DE LA NOTA DE CRÉDITO: <b><br>SALDO $".number_format($_get_transaccion['fSaldo'],2)." <br>IMPORTE $".number_format($this->admi['importeAplicado'][$row['skFactura']],2)."</b>";
                        return $this->data;
                    }
            }
            
        // VALIDAMOS QUE LA SUMA DEL IMPORTE A APLICAR NO SEA MAYOR AL SALDO DE LA TRANSACCIÓN
            if( (double)filter_var($sumaImporte, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) > (double)filter_var($_get_transaccion['fSaldo'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ){
                $this->data['success'] = FALSE;
                $this->data['message'] = "EL TOTAL DEL IMPORTE A APLICAR ES MAYOR AL SALDO DISPONIBLE: <b><br>SALDO $".number_format($_get_transaccion['fSaldo'],2)." <br>IMPORTE $".number_format($sumaImporte,2)."</b>";
                return $this->data;
            }
      
        // APLICAMOS LOS PAGOS A LAS FACTURAS
            foreach($_get_saldo_facturas AS &$row){
                $this->admi['skFactura'] = $row['skFactura'];
                $this->admi['fImporte'] = $row['fImporte'];

                $stpCUD_transacciones = parent::stpCUD_transacciones();
                if(!$stpCUD_transacciones || isset($stpCUD_transacciones['success']) && $stpCUD_transacciones['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE APLICACIÓN DE PAGO';
                    return $this->data;
                }
            }
        
        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE APLICACIÓN DE PAGO GUARDADOS';
        return $this->data;
    }

  /**
     * get_data_transaccion
     *
     * Obtenemos los datos del formulario de la transacción
     *
     * @author <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function get_data_transaccion() {
        $this->data['success'] = TRUE;

        $this->admi['skTransaccion'] = (isset($_POST['skTransaccion']) ? $_POST['skTransaccion'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        if(empty($this->admi['skTransaccion'])){
            DLOREAN_Model::showError('NO SE ENCONTRÓ LA TRANFERENCIA',404);
        }
        
        $this->data['datos'] = parent::_get_transaccion();
        
        if(!$this->data['datos']){
            DLOREAN_Model::showError('NO SE ENCONTRÓ LA TRANFERENCIA',404);
        }

        $this->admi['skFactura'] = (!empty($this->data['datos']['skFacturaNotaCredito']) ? $this->data['datos']['skFacturaNotaCredito'] : NULL);
        $this->admi['skEmpresaSocioResponsable'] = $this->data['datos']['skEmpresaSocioResponsable'];
        $this->admi['skEmpresaSocioCliente'] = $this->data['datos']['skEmpresaSocioCliente'];
        $this->admi['skDivisa'] = $this->data['datos']['skDivisa'];
        $this->data['facturas'] = parent::_get_facturas_pendientes_pago();
        
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
            'facturas'=>['message'=>'FACTURA']
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
