<?php

Class Vasi_deta_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
	    private $data = [];

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function getDatos(){
    	$this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];
        
        $this->conf['skVariable'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;

        if ($this->conf['skVariable']) {

            $this->data['datos'] =  parent::consulta_variable();
            $this->data['moduloProyecto'] = parent::consulta_variable_proyecto();
            $this->data['moduloVariables'] = parent::consulta_variable_modulos();
            if(!$this->data['datos']){
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL REGISTRO',404);
            }

            return $this->data;
        }
        return $this->data;
    }
    
}