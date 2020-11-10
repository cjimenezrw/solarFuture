<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 13/08/2018
 * Time: 02:24 PM
 */

Class Tarj_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }
    public function getBancos(){
        $skBanco = $_GET['p1'];
        $sql = " SELECT skBanco, sNombre, sDescripcion, dFechaCreacion FROM cat_bancos WHERE skBanco ='$skBanco'";

        $result = Conn::query($sql);
        if (!$result) {
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al consultar datos.';
            return $this->data;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, false);

        if (!$record) {
            return $this->data;
        }
    }

    public function getDataBanco(){
        $this->data['bancos'] = $this->getDataBancos();
        if (isset($_GET['p1'])) {
            $this->cuenta['skTarjetaBanco'] = $_GET['p1'];
            $this->data['datos'] = $this->consultar_cat_tarjetaBanco();
        }
        return $this->data;
    }

    public function consultar_cat_tarjetaBanco(){
        $sql="SELECT * FROM rel_tarjetasBancos WHERE skTarjetaBanco = '".$this->cuenta['skTarjetaBanco']."'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc($result);
        utf8($records, FALSE);
        return $records;
    }

    public function guardar() {

        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro agregado con éxito.';
        $this->data['data'] = FALSE;

        $this->cuenta['skTarjetaBanco'] = (isset($_POST['skTarjetaBanco']) ? $_POST['skTarjetaBanco'] : (isset($_GET['skTarjetaBanco']) ? $_GET['skTarjetaBanco'] : NULL));
        $this->cuenta['skBanco'] = (isset($_POST['skBanco']) ? $_POST['skBanco'] : (isset($_GET['skBanco']) ? $_GET['skBanco'] : NULL));
        $this->cuenta['sTarjeta'] = (isset($_POST['sTarjeta']) ? $_POST['sTarjeta'] : (isset($_GET['sTarjeta']) ? $_GET['sTarjeta'] : NULL));
        $this->cuenta['sDescripcionTarjeta'] = (isset($_POST['sDescripcionTarjeta']) ? $_POST['sDescripcionTarjeta'] : (isset($_GET['sDescripcionTarjeta']) ? $_GET['sDescripcionTarjeta'] : NULL));


        $skCuentaBanco  = parent::accionesTarjetasBanco();

        if ($skCuentaBanco) {
            $this->data['success'] = true;
            $this->data['message'] = 'Registro insertado con &eacute;xito.';

        }else{
            $this->data['success'] = false;
            $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';


        }



        return $this->data;

    }

    public function getDataBancos()
    {
        $sql = "SELECT skBanco, sNombre, sDescripcion FROM cat_bancos";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }
}
