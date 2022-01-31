<?php

/**
 * Banc_deta_Controller
 *
 * Detalle de Bancos (banc-deta)
 *
 * @author lvaldez
 */
Class Banc_deta_Controller Extends Admi_Model {

    // CONST //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran; 

    public function __construct() {
        parent::init(); 
    }

    public function __destruct() {

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

}
