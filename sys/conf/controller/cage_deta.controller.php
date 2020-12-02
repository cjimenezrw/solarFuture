<?php

Class Cage_deta_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    /*
     * getDatos
     *
     * Funcion para consultar los datos de categorías de desvíos.
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return array
     */
    public function getDatos(){
		$this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];
		        
		        $this->conf['skCatalogoSistema'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;

		        if($this->conf['skCatalogoSistema']){

		            $this->data['datos'] = parent::consultar_catalogosSistemas();
		            $this->data['catalogoOpciones'] = parent::consultar_opcionesCatalogo();
		            
		        }

		        return $this->data;
		    }
}