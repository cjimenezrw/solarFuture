<?php

/**
 * Bacu_deta_Controller
 *
 * Detalle de Cuenta Bancaria (bacu-deta)
 *
 * @author lvaldez
 */
Class Bacu_deta_Controller Extends Admi_Model {

    // CONST //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = []; 

    public function __construct() {
        parent::init();
       }

    public function __destruct() {

    }
    
  /**
     * get_data_bancoCuentas
     *
     * Obtenemos los datos la Cuenta Bancaria
     *
     * @author lvaldez
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function get_data_bancoCuentas() {
        $this->data['success'] = TRUE;
        
        $this->admi['skBancoCuenta'] = (isset($_POST['skBancoCuenta']) ? $_POST['skBancoCuenta'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        if(!empty($this->admi['skBancoCuenta'])){
            $_get_bancosCuenta = parent::_get_bancosCuenta();
            if(!$_get_bancosCuenta){
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL REGISTRO', 404);
            }
            $this->data['datos'] = $_get_bancosCuenta[0];
        }
        return $this->data;
    }
   
}
