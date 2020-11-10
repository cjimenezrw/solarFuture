<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 02/11/2016
 * Time: 10:02 AM
 */
Class Depa_form_Controller Extends Conf_Model
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

    public function accionesDepa()
    {
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->departamento['skDepartamentoViejo'] = ($_POST['skDepartamentoViejo'] ? $_POST['skDepartamentoViejo'] : NULL);
            $this->departamento['skDepartamento'] = (isset($_POST['skDepartamento']) ? $_POST['skDepartamento'] : NULL);
            $this->departamento['skEstatus'] = ($_POST['skEstatus'] ? $_POST['skEstatus'] : NULL);
            $this->departamento['sNombre'] = ($_POST['sNombre'] ? $_POST['sNombre'] : NULL);
            $this->departamento['skArea'] = ($_POST['skArea'] ? $_POST['skArea'] : NULL);
            $skArea = parent::acciones_depa();
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

        $this->load_view('depa_form', $this->data);
        return true;
    }

    public function consultarDepa()
    {
        $this->data['Estatus'] =  parent::consultar_core_estatus(['AC','IN'],true);
        if (isset($_GET['p1'])) {
            $this->departamento['skDepartamento'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_depa();
            return $this->data;
        }
        return $this->data;
        return false;
    }

    public function validarCodigo()
    {

        return parent::validar_codigoD($_POST['skDepartamento']);

        return false;
    }

}
