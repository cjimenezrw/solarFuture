<?php

/**
 * Controller de módulo de mercancias
 *
 * Este es el controlador del módulo de  mercancias
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
 */
Class Came_form_Controller Extends Conf_Model {

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

            $this->mercancias['skMercancia']      = (isset($_GET['p1'])  ? $_GET['p1'] : NULL);
            $this->mercancias['sNombre']          = (isset($_POST['sNombre'])  ? $_POST['sNombre'] : NULL);
            $this->mercancias['skEstatus']        = (isset($_POST['skEstatus'])  ? $_POST['skEstatus'] : NULL);
            $this->mercancias['sDescripcion']     = (isset($_POST['sDescripcion'])  ? $_POST['sDescripcion'] : NULL);

            $skMercancia = parent::acciones_cat_mercancias();

            if ($skMercancia) {
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
        $this->load_view('came_form', $this->data);
        return true;

    }

    public function consultarMercancia(){
            $this->data['estatus']=[['skEstatus' =>'AC','sNombre' =>'Activo'],['skEstatus' =>'IN','sNombre' =>'Inactivo']];
        if (isset($_GET['p1'])) {
            $this->mercancias['skMercancia'] = $_GET['p1'];
            $this->data['datos'] = parent::consultar_cat_mercancias();
        }
        return $this->data;
    }


}
