<?php
Class Arri_inde_Controller Extends Serv_Model {

    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'serv_arri';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }


}