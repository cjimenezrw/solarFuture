<?php

Class Grus_deta_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultarGrupo(){
        if (isset($_GET['p1'])) {
            $this->gruposUsuarios['skGrupoUsuario'] = $_GET['p1'];
            $this->data['datos'] = parent::consultarGruposUsuarios();
            $this->data['gruposUsuarios_usuarios'] = parent::consultarGruposUsuarios_usuarios();
            return $this->data;
        }
        return FALSE;
    }
}
