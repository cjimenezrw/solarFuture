<?php

Class Modu_deta_Controller Extends Conf_Model {

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
        
        $this->conf['skModulo'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        //se obtienen los tipos de botones de core_botones

        if($this->conf['skModulo']){

        	$this->data['permisosModulo'] = parent::_consultar_modulo_permisos();
        	$this->data['datos'] = parent::_consultar_modulos();
        	$this->data['botones'] = parent::_consultar_modulos_botones();
            $this->data['ME'] = parent::_consultar_modulos_menuEmergentes();
            $this->data['caracteristicasModulo'] = parent::_consultar_modulos_caracteristicas();
            $this->data['perfiles'] = parent::_consultar_modulos_perfiles();
            $this->data['modulosMenu'] = parent::_consultar_modulosMenu();

            //DLOREAN_Model::log($this->data,TRUE,TRUE);
            if(!$this->data['datos']){
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL REGISTRO',404);
            }

        }

        return $this->data;
    }
    

    
}