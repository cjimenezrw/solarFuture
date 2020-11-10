<?php

Class Func_util_Controller Extends Inic_Model {
    // PUBLIC VARIABLES //

    use AutoCompleteTrait;
    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    public function cargarModulos(){
        $data = array();
        $data['skModuloInicio']= $this->sysController;
         return $modulosPrincipales = parent::modulos_principales($data);
    }

}
