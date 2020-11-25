<?php
Class Pros_deta_Controller Extends Empr_Model{
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultar(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];
        $params = [];
        $params['skProspecto'] = (!empty($_GET['p1']) ? $_GET['p1'] : NULL);
        if(empty($params['skProspecto'])){
            return $this->data;
        }
        $_get_prospecto = parent::_get_prospecto([
            'skProspecto'=>$params['skProspecto']
        ]);
        if(is_array($_get_prospecto) && isset($_get_prospecto['success']) && $_get_prospecto['success'] == false){
            DLOREAN_Model::showError('REGISTRO NO ENCONTRADO',404);
        }
        $this->data['datos'] = $_get_prospecto;
        return $this->data;
    }
}