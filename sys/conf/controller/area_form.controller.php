<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 02/11/2016
 * Time: 10:02 AM
 */

Class Area_form_Controller Extends Conf_Model
{
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct()
    {
        parent::init();
    }

    public function __destruct()
    {

    }

    public function accionesArea(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->area['skAreaVieja']  = ($_POST['skAreaVieja']    ? $_POST['skAreaVieja']     : NULL);
            $this->area['skArea']       = (isset($_POST['skArea'])  ? $_POST['skArea']          : NULL);
            $this->area['skEstatus']        = ($_POST['skEstatus']          ? $_POST['skEstatus']           : NULL);
            $this->area['sNombre']          = ($_POST['sNombre']            ? $_POST['sNombre']             : NULL);
            $skArea = parent::acciones_area();
            if ($skArea) {
                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            } else {
                //echo "llego aqui";
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
            }
        }

        $this->load_view('area_form',$this->data);
        return true;
    }
    public function consultarArea(){
        $this->data['Estatus'] =  parent::consultar_core_estatus(['AC','IN'],true);
        if (isset($_GET['p1'])) {
            $this->area['skArea'] = $_GET['p1'];
            $this->data['datos'] =  parent::consulta_area();
            return $this->data;
        }
        return $this->data;
        return false;
    }
    public function validarCodigo(){

        return parent::validar_codigo($_POST['skArea']);

        return false;
    }

}
