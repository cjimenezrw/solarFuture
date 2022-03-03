<?php
Class Cont_Controller Extends Cont_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
    
    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function cont_inde() {
        $this->load_class("cont_inde", "controller");
        $cont_inde = new Cont_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                header('Content-Type: application/json');
                echo json_encode($cont_inde->consulta());
            break;
            case 'generarOrden':
                $data = $cont_inde->generarOrden();
                header('Content-Type: application/json');
                echo json_encode($data);
            break; 
            case 'cancelar':
                $data = $cont_inde->cancelar();
                header('Content-Type: application/json');
                echo json_encode($data);
            break; 
            case 'activar':
                $data = $cont_inde->activar();
                header('Content-Type: application/json');
                echo json_encode($data);
            break; 
            case 'cobros_contratos':
                $data = $cont_inde->cobros_contratos();
                header('Content-Type: application/json');
                echo json_encode($data);
            break;
            case 'generarExcel':
                $cont_inde->generarExcel();
                break;
            case 'pdf':
                $cont_inde->generarPDF();
                break;
            default:
                $this->load_view('cont_inde');
                break;
        }
        return TRUE;
    }

    public function cont_form() {
        $this->load_class("cont_form", "controller");
        $cont_form = new Cont_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'get_empresas':
                header('Content-Type: application/json');
                echo json_encode($cont_form->get_empresas());
            break;
            case 'get_servicios':
                header('Content-Type: application/json');
                echo json_encode($cont_form->get_servicios());
            break;
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($cont_form->guardar(),true,512);
                break;
            default:
                $this->data = $cont_form->getDatos();
                $this->load_view('cont_form', $this->data);
                break;
        }
        return true;
    }

    public function cont_deta() {
        $this->load_class("cont_deta", "controller");
        $cont_deta = new Cont_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) { 
            default:
                $this->data = $cont_deta->consultar();
                $this->load_view('cont_deta', $this->data);
            break;
        }
        return true;
    }
    
    public function torr_inde() {
        $this->load_class("torr_inde", "controller");
        $torr_inde = new Torr_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($torr_inde->consultar(),true,512);
                break;
            case 'generarExcel':
                $torr_inde->generarExcel();
                break;
            case 'pdf':
                $torr_inde->generarPDF();
                break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($torr_inde->cancelar(),true,512);
                break;
            default:
                $this->load_view('torr_inde');
                break;
        }
        return TRUE;
    }

    public function torr_form() {
        $this->load_class("torr_form", "controller");
        $torr_form = new Torr_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($torr_form->guardar());
                break;
            case 'validar_MAC':
                header('Content-Type: application/json');
                echo json_encode($torr_form->validar_MAC());
                break;
            default:
                $this->load_view('torr_form', $torr_form->getDatos());
                break;
        }
        return true;
    }

    public function torr_deta() {
        $this->load_class("torr_deta", "controller");
        $torr_deta = new Torr_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->load_view('torr_deta', $torr_deta->getDatos());
                break;
        }
        return true;
    }

    public function acpo_inde() {
        $this->load_class("acpo_inde", "controller");
        $acpo_inde = new acpo_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($acpo_inde->consultar(),true,512);
                break;
            case 'generarExcel':
                $acpo_inde->generarExcel();
                break;
            case 'pdf':
                $acpo_inde->generarPDF();
                break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($acpo_inde->cancelar(),true,512);
                break;
            default:
                $this->load_view('acpo_inde');
                break;
        }
        return TRUE;
    }

    public function acpo_form() {
        $this->load_class("acpo_form", "controller");
        $acpo_form = new acpo_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($acpo_form->guardar());
                break;
            case 'validar_MAC':
                header('Content-Type: application/json');
                echo json_encode($acpo_form->validar_MAC());
                break;
            default:
                $this->load_view('acpo_form', $acpo_form->getDatos());
                break;
        }
        return true;
    }

    public function acpo_deta() {
        $this->load_class("acpo_deta", "controller");
        $acpo_deta = new acpo_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->load_view('acpo_deta', $acpo_deta->getDatos());
                break;
        }
        return true;
    }



}
