<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 28/04/2018
 * Time: 12:21 PM
 */

Class Caba_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function getDataBanco() {

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
        $this->data['datos'] = array(
            'skBanco' => $record['skBanco'],
            'sNombre' => $record['sNombre'],
            'sDescripcion' => $record['sDescripcion'],
            'dFechaCreacion' => (!empty($record['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($record['dFechaCreacion'])) : '')
        );

        return $this->data;
    }

    public function guardar() {

        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro agregado con éxito.';
        $this->data['data'] = FALSE;

/*        echo "<PRE>";
        print_r($_POST);
        echo "</PRE>";
        die();*/


        $this->banco['skBanco'] = (isset($_POST['skBanco']) ? $_POST['skBanco'] : (isset($_GET['skBanco']) ? $_GET['skBanco'] : NULL));
        $this->banco['sNombre'] = (isset($_POST['sNombre']) ? $_POST['sNombre'] : (isset($_GET['sNombre']) ? $_GET['sNombre'] : NULL));
        $this->banco['sDescripcion'] = (isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : (isset($_GET['sDescripcion']) ? $_GET['sDescripcion'] : NULL));


        if ($this->banco['sNombre'] != NULL){

            $skBanco  = parent::accionesBancos();

            if ($skBanco) {
                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
            }else{
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';

            }
        }else{
            $this->data['success'] = false;
            $this->data['message'] = 'El nombre es requerido.';
        }
        return $this->data;
    }
}
