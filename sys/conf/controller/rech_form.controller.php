<?php

/**
 * Controller de módulo de mercancias
 *
 * Este es el controlador del módulo de  mercancias
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
 */
Class Rech_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    /**
     * Guardar
     *
     * Guardar registros de mercancias
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
     * @return miced Retorna Array de datos de registro de sellos.
     */
    public function guardar() {
        $this->data['success'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        if ($_POST) {

            $this->rech['skRechazoRevalidacion']        = (isset($_POST['skRechazoRevalidacion'])  ? $_POST['skRechazoRevalidacion'] : NULL);
            $this->rech['sNombre']                      = (isset($_POST['sNombre'])  ? $_POST['sNombre'] : NULL);
            $this->rech['skEstatus']                    = (isset($_POST['skEstatus'])  ? $_POST['skEstatus'] : NULL);

            $skRechazoRevalidacion = parent::stpCUD_rechazosRevalidacion();

            if ($skRechazoRevalidacion) {
                $this->data['success'] = true;
                $this->data['message'] = 'Registro guardado con &eacute;xito.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            } else {
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
            }
        }
        $this->load_view('rech_form', $this->data);
        return true;

    }

    public function consultarRechazoRevalidacion(){
            $this->data['estatus']=[['skEstatus' =>'AC','sNombre' =>'Activo'],['skEstatus' =>'IN','sNombre' =>'Inactivo']];
        if (isset($_GET['p1'])) {
            $this->rech['skRechazoRevalidacion'] = $_GET['p1'];
            $this->data['datos'] = parent::consultar_rechazoRevalidacion();
        }
        return $this->data;
    }


}
