<?php

/**
 * Banc_form_Controller
 *
 * Formulario de Bancos (banc-form)
 *
 * @author lvaldez
 */
Class Banc_form_Controller Extends Admi_Model {

    // CONST //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran; 

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_bancos'; 
    }

    public function __destruct() {

    }
    
  /**
     * guardar
     *
     * Guardar Banco
     *
     * @author lvaldez
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
            
            $this->admi['skBanco'] = (isset($_POST['skBanco']) ? $_POST['skBanco'] : NULL);
            
        // Guardar el Corte de Almacenajes
            $guardar_banco = $this->guardar_banco();
            if(!$guardar_banco['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
            
            $this->data['datos'] = $this->admi;
            
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['message'] = 'BANCO GUARDADO CON ÉXITO';
        return $this->data;
    }
    
  /**
     * guardar_banco
     *
     * Guardar Banco
     *
     * @author lvaldez
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function guardar_banco(){
        $this->data['success'] = TRUE;
        $this->admi['axn'] = 'guardar_banco';
        
        $this->admi['skEstatus'] = 'AC';
        $stpCUD_bancos = parent::stpCUD_bancos();

        if(!$stpCUD_bancos || isset($stpCUD_bancos['success']) && $stpCUD_bancos['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DEL BANCO';
            return $this->data;
        }

        $this->admi['skBanco'] = $stpCUD_bancos['skBanco'];
        
        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DEL BANCO GUARDADOS';
        return $this->data;
    }
    
    
  /**
     * get_data_banco
     *
     * Obtenemos los datos del Formulario de Banco
     *
     * @author lvaldez
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function get_data_banco() {
        $this->data['success'] = TRUE;
        
        $this->admi['skBanco'] = (isset($_POST['skBanco']) ? $_POST['skBanco'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        if(!empty($this->admi['skBanco'])){
            $_getBancos = parent::_getBancos();
            if(!$_getBancos){
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL REGISTRO', 404);
            }
            $this->data['datos'] = $_getBancos[0];
        }
        return $this->data;
    }
    
    
  /**
     * validar_datos_entrada
     *
     * Valida los datos del la entrada
     *
     * @author lvaldez
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        
        $validations = [
            'sNombre'=>['message'=>'NOMBRE DEL BANCO'],
            'sNombreCorto'=>['message'=>'NOMBRE CORTO DEL BANCO'],
            'sRFC'=>['message'=>'RFC DEL BANCO']
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
     * @author lvaldez
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
    
    /**
     * validarRFC
     *
     * Función para validar si existe el RFC.
     *
     * @author lvaldez
     * @return bool
     */

    public function validarRFC(){
        $this->admi['skBanco'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        $this->admi['sRFC'] = (isset($_POST['sRFC']) && !empty($_POST['sRFC'])) ? $_POST['sRFC'] : NULL;
        if($this->admi['sRFC']){

            $_validarBanco = parent::_validarBanco();
            if(isset($_validarBanco['sRFC']) && !empty($_validarBanco['sRFC'])){
                return ['valid'=>FALSE];
            }

            return ['valid'=>TRUE];

            
        }
    }
    
    /**
     * validarCuentaContable
     *
     * Funcion para validar si existe el iCuentaContable.
     *
     * @author lvaldez
     * @return bool
     */
    public function validarCuentaContable(){
        $this->admi['skBanco'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        $this->admi['sCuentaContable'] = (isset($_POST['sCuentaContable']) && !empty($_POST['sCuentaContable'])) ? $_POST['sCuentaContable'] : NULL;
        if($this->admi['sCuentaContable']){
            $_validarBanco = parent::_validarBanco();
            if(isset($_validarBanco['sCuentaContable']) && !empty($_validarBanco['sCuentaContable'])){
                return ['valid'=>FALSE];
            }
            return ['valid'=>TRUE];            
        }
    }
}
