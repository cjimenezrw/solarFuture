<?php

Class Vent_Controller Extends Vent_Model {

    
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function coti_inde() {
        $this->load_class("coti_inde", "controller");
        $coti_inde = new Coti_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $coti_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $coti_inde->generarExcel();
                break;
            case 'pdf':
                $coti_inde->generarPDF();
                break;
            case 'cotizacionPDF':
                $coti_inde->cotizacionPDF();
                break;
            case 'ventaPDF':
                $coti_inde->ventaPDF();
                break;
            case 'entregaPDF':
                $coti_inde->entregaPDF();
                break;
            case 'cancelarVenta':
                header('Content-Type: application/json');
                echo json_encode($coti_inde->cancelarVenta(),true,512);
            break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($coti_inde->cancelar(),true,512);
                break;
            default:
                $this->load_view('coti_inde');
                break;
        }
        return TRUE;
    }

     
 
    public function coti_form() {
        $this->load_class("coti_form", "controller");
        $coti_form = new Coti_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'get_empresas':
                header('Content-Type: application/json');
                echo json_encode($coti_form->get_empresas());
            break;
            case 'get_prospectos':
                header('Content-Type: application/json');
                echo json_encode($coti_form->get_prospectos());
            break;
            case 'get_empresasProspectos':
                header('Content-Type: application/json');
                echo json_encode($coti_form->get_empresasProspectos());
            break;
            
            case 'get_servicios':
                header('Content-Type: application/json');
                echo json_encode($coti_form->get_servicios());
            break;
            case 'get_servicios_impuestos':
                header('Content-Type: application/json');
                echo json_encode($coti_form->get_servicios_impuestos());
            break;
            case 'get_servicios_datos':
                header('Content-Type: application/json');
                echo json_encode($coti_form->get_servicios_datos());
            break;
            
            case 'get_medidas':
                header('Content-Type: application/json');
                echo json_encode($coti_form->get_medidas());
            break;
                
            
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($coti_form->guardar());
                break;
            default:
                $this->data = $coti_form->getDatos();
                $this->load_view('coti_form', $this->data);
                break;
        }
        return true;
    }

    public function coti_deta() {
        $this->load_class("coti_deta", "controller");
        $coti_deta = new Coti_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'pdf':
                $coti_deta->crearPDF();
            break;
            case 'formatoPDF':
                echo $coti_deta->formatoPDF();
            break;
            case 'formatoVentaPDF':
                echo $coti_deta->formatoVentaPDF();
            break;
            case 'formatoEntregaPDF':
                echo $coti_deta->formatoEntregaPDF();
            break;
            default:
                $this->data = $coti_deta->consultar();
                $this->load_view('coti_deta', $this->data);
            break;
        }
        return true;
    }

    public function vent_coti() {
        $this->load_class("vent_coti", "controller");
        $vent_coti = new Vent_coti_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'get_serviciosInventario':
                header('Content-Type: application/json');
                echo json_encode($vent_coti->get_serviciosInventario());
            break;
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($vent_coti->guardar());
                break;
            default:
                $this->data = $vent_coti->getDatos();
                $this->load_view('vent_coti', $this->data);
                break;
        }
        return true;
    }

    public function entr_coti() {
        $this->load_class("entr_coti", "controller");
        $entr_coti = new Entr_coti_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($entr_coti->guardar());
                break;
            default:
                $this->data = $entr_coti->getDatos();
                $this->load_view('entr_coti', $this->data);
                break;
        }
        return true;
    }



}
