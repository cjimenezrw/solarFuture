<?php
Class Cita_Controller Extends Cita_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
    
    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function cita_inde() {
        $this->load_class("cita_inde", "controller");
        $cita_inde = new Cita_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($cita_inde->consultar(),true,512);
                break;
            case 'generarExcel':
                $cita_inde->generarExcel();
                break;
            case 'pdf':
                $cita_inde->generarPDF();
                break;
            case 'formatoPDF':
                $cita_inde->formatoPDF();
                break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($cita_inde->cancelar(),true,512);
                break;
            case 'finalizar':
                header('Content-Type: application/json');
                echo json_encode($cita_inde->finalizar(),true,512);
                break;
            default:
                $this->load_view('cita_inde');
                break;
        }
        return TRUE;
    }

    public function cita_form() {
        $this->load_class("cita_form", "controller");
        $cita_form = new Cita_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($cita_form->guardar());
                break;
            case 'get_empresas':
                header('Content-Type: application/json');
                echo json_encode($cita_form->get_empresas());
                break;
            case 'get_horarios_disponibles':
                header('Content-Type: application/json');
                echo json_encode($cita_form->get_horarios_disponibles());
                break;
            case 'get_cat_municipiosMX':
                header('Content-Type: application/json');
                echo json_encode($cita_form->get_cat_municipiosMX());
                break;
            case 'get_personal':
                header('Content-Type: application/json');
                echo json_encode($cita_form->get_personal());
                break;
            default:
                $this->load_view('cita_form', $cita_form->getDatos());
                break;
        }
        return true;
    }

    public function cita_conf() {
        $this->load_class("cita_conf", "controller");
        $cita_conf = new Cita_conf_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($cita_conf->guardar());
                break;
            case 'get_empresas':
                header('Content-Type: application/json');
                echo json_encode($cita_conf->get_empresas());
                break;
            case 'get_horarios_disponibles':
                header('Content-Type: application/json');
                echo json_encode($cita_conf->get_horarios_disponibles());
                break;
            case 'get_cat_municipiosMX':
                header('Content-Type: application/json');
                echo json_encode($cita_conf->get_cat_municipiosMX());
                break;
            case 'get_personal':
                header('Content-Type: application/json');
                echo json_encode($cita_conf->get_personal());
                break;
            default:
                $this->load_view('cita_conf', $cita_conf->getDatos());
                break;
        }
        return true;
    }

    public function cita_orde() {
        $this->load_class("cita_orde", "controller");
        $cita_orde = new Cita_orde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->guardar());
                break;
            case 'get_empresas':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_empresas());
                break;
            case 'get_horarios_disponibles':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_horarios_disponibles());
                break;
            case 'get_cat_municipiosMX':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_cat_municipiosMX());
                break;
            case 'get_personal':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_personal());
                break;
            case 'get_servicios':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_servicios());
            break;
            case 'get_servicio_impuestos':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_servicio_impuestos());
            break;
            case 'get_servicios_datos':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_servicios_datos());
            break;
            case 'get_medidas':
                header('Content-Type: application/json');
                echo json_encode($cita_orde->get_medidas());
            break;
            default:
                $this->load_view('cita_orde', $cita_orde->getDatos());
                break;
        }
        return true;
    }

    public function cita_deta() {
        $this->load_class("cita_deta", "controller");
        $cita_deta = new Cita_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'formatoPDF':
                echo $cita_deta->formatoPDF();
            break;
            default:
                $this->load_view('cita_deta', $cita_deta->getDatos());
                break;
        }
        return true;
    }

    public function cita_cale() {
        $this->load_class("cita_cale", "controller");
        $cita_cale = new Cita_cale_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'get_cat_municipiosMX':
                header('Content-Type: application/json');
                echo json_encode($cita_cale->get_cat_municipiosMX());
                break;
            case 'get_iFolio':
                header('Content-Type: application/json');
                echo json_encode($cita_cale->get_iFolio());
                break;
            case 'get_sNombre':
                header('Content-Type: application/json');
                echo json_encode($cita_cale->get_sNombre());
                break;
            case 'get_cliente':
                header('Content-Type: application/json');
                echo json_encode($cita_cale->get_cliente());
                break;
            case 'get_personal':
                header('Content-Type: application/json');
                echo json_encode($cita_cale->get_personal());
                break;
            case 'getDatos':
                header('Content-Type: application/json');
                echo json_encode($cita_cale->getDatos());
                break;
            default:
                $this->load_view('cita_cale', $cita_cale->getDatos());
                break;
        }
        return true;
    }
}