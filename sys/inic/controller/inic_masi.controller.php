<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 04/10/2016
 * Time: 03:55 PM
 */

Class Inic_masi_Controller Extends Inic_Model {
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
