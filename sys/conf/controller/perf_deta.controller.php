<?php

Class Perf_deta_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultarperfil(){
        if (isset($_GET['p1'])) {
            $this->perfil['skPerfil'] = $_GET['p1'];
            return parent::consulta_perfil();
        }
        return false;
    }
}
