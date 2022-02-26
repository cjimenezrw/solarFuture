<?php

Class Cont_deta_Controller Extends Cont_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cont['skContrato'] = $_GET['p1'];

        if(!empty($this->cont['skContrato'])){
            $this->data['datos'] =  parent::_get_contratos(); 
            $cobros_contratos =  parent::_get_contratos_cobros(); 

            if(!empty($cobros_contratos)){
                $this->data['cobros_contratos'] = $cobros_contratos;
            }

            
        }
        
 
        return $this->data;
    }

    


     

}
