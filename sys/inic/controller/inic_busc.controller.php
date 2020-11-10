<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 04/10/2016
 * Time: 03:55 PM
 */

Class Inic_busc_Controller Extends Inic_Model {
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
    public function buscarModulo(){

        if (isset($_GET['p1'])) {
                $this->buscar['sBuscar'] = $_GET['p1'];
                return $resultado =  parent::buscar_modulo();
        }
        return true;

    }

}
