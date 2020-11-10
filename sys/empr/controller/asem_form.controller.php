<?php

Class Asem_form_Controller Extends Empr_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }

    public function accionesServiciosEmpresas() {
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $skSolicitudEmpresa = parent::acciones_serviciosEmpresa();
            if ($skSolicitudEmpresa) {

                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
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

        $this->load_view('suem_form', $this->data);
        return true;
    }

    public function consultarSolicitudEmpresa() {
        $this->data['empresasTipos'] = parent::getEmpresasTipos();
        if (isset($_GET['p1'])) {
            $this->data['datos'] = parent::consultar_solicitudEmpresa(escape($_GET['p1']));
            $this->data['servicios'] = parent::consultar_serviciosEmpresa(escape($_GET['p1']));
        }
        return $this->data;
    }

}
