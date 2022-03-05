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
    
}
