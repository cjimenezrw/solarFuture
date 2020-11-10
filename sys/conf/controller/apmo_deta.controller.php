<?php

Class Apmo_deta_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultarAplicacion(){
        if (isset($_GET['p1'])) {
            $this->aplicacion['skAplicacion'] = $_GET['p1'];
            $this->data['datos'] =  parent::consulta_aplicacion_detalles();
            $this->data['perfiles'] =  parent::consulta_aplicaciones_perfiles_detalles();
            return $this->data;
        }
        return false;
    }
}
