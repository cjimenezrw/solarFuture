<?php

Class Dlorean_catalogo_Controller Extends Inic_Model {
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
    
    public function cargarMapa(){
         $this->data['mapa'] = parent::cargar_Mapa();
         return $this->data;
    }

}


// Catalogo de componentes estables y experimentales.
// Experimental and stable components catalog
// xasc-cata