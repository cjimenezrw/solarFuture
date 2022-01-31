<?php

/**
 * Cotr_form_Controller
 *
 * Formulario de Transacciones (cotr-form)
 *
 * @author lvaldez<lvaldez>
 */
Class Cotr_form_Controller Extends Admi_Model {

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
        $this->skPuestoGral = $_SESSION['usuario']['skPuestoGeneral'];
     }

    public function __destruct() {

    }
    
  /**
     * guardar
     *
     * Guardar Transacción
     *
     * @author lvaldez<lvaldez>
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
            
            $this->admi['skTransaccion'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);
            
        // Guardar Transacción
            $guardar_transaccion = $this->guardar_transaccion();
            if(!$guardar_transaccion['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // Guardar Documentos
        if(!empty($_FILES['docu_file_ADMINI_COMPRO']['name'])){
            $guardar_documentos = $this->guardar_documentos();
            if(!$guardar_documentos['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
        }
            
        
            
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['message'] = 'TRANSACCIÓN GUARDADA CON ÉXITO';
        return $this->data;
    }
    
  /**
     * guardar_transaccion
     *
     * Guardar Transacción
     *
     * @author lvaldez <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function guardar_transaccion(){
        $this->data['success'] = TRUE;
        $this->admi['axn'] = 'guardar_transaccion';
        $this->admi['skEstatus'] = (!empty($this->admi['skEstatus']) ? $this->admi['skEstatus'] : 'VA');
         $stpCUD_transacciones = parent::stpCUD_transacciones();

        if(!$stpCUD_transacciones || isset($stpCUD_transacciones['success']) && $stpCUD_transacciones['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE TRANSACCIÓN';
            return $this->data;
        }
        
        $this->admi['skTransaccion'] = $stpCUD_transacciones['skTransaccion'];
        //$this->admi['empresaRFC'] = $stpCUD_transacciones['empresaRFC'];
        
        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE TRANSACCIÓN GUARDADOS';
        return $this->data;
    }

    public function guardar_documentos(){
        $this->data['success'] = TRUE;
        $this->admi['axn'] = 'guardar_documentos';
        
        $_get_transaccion = parent::_get_transaccion();
        
        if(
            empty($_FILES['docu_file_ADMINI_COMPRO']['name'])
            && empty($_get_transaccion['skDocumentoComprobante'])
        ){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'ES NECESARIO ADJUNTAR EL COMPROBANTE';
            return $this->data;
        }elseif(!empty($_get_transaccion['skDocumentoComprobante'])){
            $this->admi['skDocumentoComprobante'] = $_get_transaccion['skDocumentoComprobante'];
        }
        
        if(
            isset($_FILES['docu_file_ADMINI_COMPRO']['name']) 
            && !empty($_FILES['docu_file_ADMINI_COMPRO']['name'])
        ){
            $guardar_documento = $this->sysAPI('docu', 'docu_serv', 'guardar', [
                'POST'=>[
                    'skTipoExpediente'=>'ADMINI',
                    'skTipoDocumento'=>'COMPRO',
                    'skCodigo'=>$this->admi['skTransaccion']
                ],
                'FILES'=>[
                    'docu_file'=>$_FILES['docu_file_ADMINI_COMPRO']
                ]
            ]);
            
            if(!$guardar_documento || isset($guardar_documento['success']) && $guardar_documento['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = $guardar_documento['message'];
                return $this->data;
            }

            $this->admi['skDocumentoComprobante'] = $guardar_documento['data']['skDocumento'][0];
            
            // GUARDAMOS LOS DOCUMENTOS
                $stpCUD_transacciones = parent::stpCUD_transacciones();
                if(!$stpCUD_transacciones || isset($stpCUD_transacciones['success']) && $stpCUD_transacciones['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL COMPROBANTE';
                    return $this->data;
                }
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DOCUMENTO GUARDADO';
        return $this->data;
    }

    public function eliminar_ADMINI_COMPRO(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        Conn::begin($this->idTran);

        // Obtener datos de entrada de información
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            $this->admi['skTransaccion'] = $this->admi['skCodigo'];
            $this->admi['skDocumentoComprobante'] = $this->admi['skDocumento'];

        // ELIMINAMOS LOS DOCUMENTOS
            $this->admi['axn'] = 'eliminar_ADMINI_COMPRO';
            $stpCUD_transacciones = parent::stpCUD_transacciones();
            if(!$stpCUD_transacciones || isset($stpCUD_transacciones['success']) && $stpCUD_transacciones['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL ELIMINAR EL COMPROBANTE';
                return $this->data;
            }

        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'DOCUMENTO ELIMINADO CON ÉXITO';
        return $this->data;
    }
    
  
    
  /**
     * get_data_transaccion
     *
     * Obtenemos los datos del formulario de la transacción
     *
     * @author lvaldez <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function get_data_transaccion() {
        $this->data['success'] = TRUE;
        
        $this->admi['skTransaccion'] = (isset($_POST['skTransaccion']) ? $_POST['skTransaccion'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        $this->admi['skEstatus'] = 'AC';
        $this->data['get_formasPago'] = parent::_get_formasPago();
        
        $this->admi['skEstatus'] = 'AC';
        $this->admi['skDivisa'] = ['MXN','USD'];
        $this->data['get_divisas'] = parent::_get_divisas();
        
        $this->admi['skEmpresaSocioResponsable'] = $_SESSION['usuario']['skEmpresaSocio'];
        $getBancosCuentasResponsable = $this->getBancosCuentasResponsable();
        $this->data['get_bancosReceptor'] = isset($getBancosCuentasResponsable['datos']['bancos']) ? $getBancosCuentasResponsable['datos']['bancos']: [];
        $this->data['get_bancosCuentasReceptor'] = isset($getBancosCuentasResponsable['datos']['cuentasBancarias']) ? $getBancosCuentasResponsable['datos']['cuentasBancarias']: [];
        
        $this->data['get_bancosEmisor'] = parent::_get_bancos();
       
        
        if(!empty($this->admi['skTransaccion'])){
            $this->admi['skEstatus'] = ['PE','VA','PO'];
            $_get_transaccion = parent::_get_transaccion();
            
            if(!$_get_transaccion){
                DLOREAN_Model::showError('NO SE ENCONTRARON LOS DATOS','403');
            }
        
            $this->data['datos'] = ($_get_transaccion) ? $_get_transaccion : [];
        }
        //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }
    
    /**
     * get_facturas
     *
     * Obtenemos las facturas pendientes de pagar
     *
     * @author lvaldez <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function get_facturas_pendientes_pago(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>[]];
        
        $this->data['facturas'] = [];
        
        $this->admi['skEmpresaSocioResponsable'] = (isset($_POST['skEmpresaSocioResponsable']) ? $_POST['skEmpresaSocioResponsable'] : NULL);
        if(!$this->admi['skEmpresaSocioResponsable']){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'ES NECESARIO SELECCIONAR EL RESPONSABLE';
            return $this->data;
        }
        
        $this->admi['skEmpresaSocioCliente'] = (isset($_POST['skEmpresaSocioCliente']) ? $_POST['skEmpresaSocioCliente'] : NULL);
        $this->admi['skDivisa'] = (isset($_POST['skDivisa']) ? $_POST['skDivisa'] : NULL);
        $this->data['facturas'] = parent::_get_facturas_pendientes_pago();
        
        if(!$this->data['facturas']){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'NO SE ENCONTRARON RESULTADOS';
            return $this->data;
        }
        
        foreach($this->data['facturas'] AS $k=>&$v){
            $v['fSaldo'] = number_format(bcdiv($v['fSaldo'],'1',2),2);
            $v['fTotal'] = number_format(bcdiv($v['fTotal'],'1',2),2);
            $v['dFechaFacturacion'] = ($v['dFechaFacturacion']) ? date('d/m/Y H:i:s', strtotime($v['dFechaFacturacion'])) : '-';
        }
        
        $this->data['message'] = 'FACTURAS CONSULTADAS CON ÉXITO';
        return $this->data;
    }
    
  /**
     * updateComprobante
     *
     * Actualizamos el comprobante de la transacción
     *
     * @author lvaldez <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function updateComprobante(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];
        $this->admi['axn'] = 'guardar_transaccion_comprobante';
        Conn::begin($this->idTran);
        
        $this->admi['skTransaccion'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);
        $this->admi['sComprobanteArchivoFile'] = NULL;
        
        $stpCUD_transacciones = parent::stpCUD_transacciones();
        
        if(!$stpCUD_transacciones || isset($stpCUD_transacciones['success']) && $stpCUD_transacciones['success'] != 1){
            Conn::rollback($this->idTran);
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL ACTUALIZAR EL COMPROBANTE DE LA TRANSACCIÓN';
            return $this->data;
        }
        
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['message'] = 'TRANSACCIÓN ACTUALIZADA';
        return $this->data;
    }
    
  /**
     * getEmpresas
     *
     * Obtener Empresas
     *
     * @author lvaldez <lvaldez>
     * @return Array EmpresasSocios
     */
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
    
    /**
     * getBancosCuentasResponsable
     *
     * Obtener Cuentas Bancarias
     *
     * @author lvaldez<lvaldez>
     * @return Array Cuentas Bancarias
     */
    public function getBancosCuentasResponsable(){
        $data = ['success'=>TRUE,'message'=>NULL,'datos'=>['bancos'=>[],'cuentasBancarias'=>[]]];
        $this->admi['skEmpresaSocioResponsable'] = isset($_POST['skEmpresaSocioResponsable']) ? $_POST['skEmpresaSocioResponsable'] : $this->admi['skEmpresaSocioResponsable'];
        
        $_getBancosCuentasResponsable = parent::_getBancosCuentasResponsable();
        if(!$_getBancosCuentasResponsable){
            $data['success'] = FALSE;
            $data['message'] = 'HUBO UN ERROR AL CONSULTAR LAS CUENTAS BANCARIAS';
            return $data;
        }
        
        foreach($_getBancosCuentasResponsable AS $row){
            if(!isset($data['datos']['bancos'][$row['skBanco']])){
                $data['datos']['bancos'][$row['skBanco']] = $row;
            }
            $data['datos']['cuentasBancarias'][$row['skBanco']][] = $row;
        }
        return $data;
    }
    
  /**
     * validar_datos_entrada
     *
     * Valida los datos del la entrada
     *
     * @author lvaldez <lvaldez>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        
        $validations = [
            'skEmpresaSocioResponsable'=>['message'=>'EMPRESA RESPONSABLE'],
            'sReferencia'=>['message'=>'REFERENCIA'],
            'skTipoTransaccion'=>['message'=>'TIPO DE TRANSACCIÓN'],
            //'skBancoReceptor'=>['message'=>'BANCO RECEPTOR'],
            //'skBancoCuentaReceptor'=>['message'=>'CUENTA BANCARIA RECEPTORA'],
            'skFormaPago'=>['message'=>'FORMA DE PAGO'],
            'fImporte'=>['message'=>'IMPORTE','validations'=>['decimal']],
            'dFechaTransaccion'=>['message'=>'FECHA DE TRANSACCIÓN','validations'=>['date']]
        ];

        foreach($validations AS $k=>$v){
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
     * @author lvaldez <lvaldez>
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
