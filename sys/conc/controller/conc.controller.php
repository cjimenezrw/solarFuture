<?php

Class Conc_Controller Extends Conc_Model {

    
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function inve_inde() {
        $this->load_class("inve_inde", "controller");
        $inve_inde = new Inve_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                header('Content-Type: application/json');
                echo json_encode($inve_inde->consulta());
                break;
            case 'generarExcel':
                $inve_inde->generarExcel();
                break;
            case 'pdf':
                $inve_inde->generarPDF();
                break;
            default:
                $this->load_view('inve_inde');
                break;
        }
        return TRUE;
    }

    public function inve_form() {
        $this->load_class("inve_form", "controller");
        $inve_form = new Inve_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($inve_form->guardar());
                break;
            default:
                $this->load_view('inve_form', $inve_form->getDatos());
                break;
        }
        return true;
    }
    
    public function prod_inde() {
        $this->load_class("prod_inde", "controller");
        $prod_inde = new Prod_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $prod_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $prod_inde->generarExcel();
                break;
            case 'pdf':
                $prod_inde->generarPDF();
                break;
                break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($prod_inde->cancelar(),true,512);
                break;
            default:
                $this->load_view('prod_inde');
                break;
        }
        return TRUE;
    }

    public function prod_form() {
        $this->load_class("prod_form", "controller");
        $prod_form = new Prod_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        $ckCsrfToken = (isset($_POST['ckCsrfToken']) ? $_POST['ckCsrfToken'] : (isset($_GET['ckCsrfToken']) ? $_GET['ckCsrfToken'] : NULL));
        if ($ckCsrfToken) {
            $axn = 'ckEditor_upload';
        }
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($prod_form->guardar());
                break;
            case 'ckEditor_upload':
                header('Content-Type: application/json');
                echo json_encode($prod_form->ckEditor_upload());
                break;
            default:
                $this->data = $prod_form->getDatos();
                $this->load_view('prod_form', $this->data);
                break;
        }
        return true;
    }

 


    public function conc_inde() {
        $this->load_class("conc_inde", "controller");
        $conc_inde = new Conc_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $conc_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $conc_inde->generarExcel();
                break;
            case 'pdf':
                $conc_inde->generarPDF();
                break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($conc_inde->cancelar(),true,512);
                break;
            default:
                $this->load_view('conc_inde');
                break;
        }
        return TRUE;
    }

     
 
    public function conc_form() {
        $this->load_class("conc_form", "controller");
        $conc_form = new Conc_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'get_empresas':
                header('Content-Type: application/json');
                echo json_encode($conc_form->get_empresas());
                break;
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($conc_form->guardar());
                break;
            default:
                $this->data = $conc_form->getDatos();
                $this->load_view('conc_form', $this->data);
                break;
        }
        return true;
    }
    public function conc_deta() {
        $this->load_class("conc_deta", "controller");
        $conc_deta = new Conc_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'pdf':
                $conc_deta->crearPDF();
                break;
            default:
                $this->data = $conc_deta->consultar();
                $this->load_view('conc_deta', $this->data);
                break;
        }
        return true;
    }

    public function inve_sali() {
        $this->load_class("inve_sali", "controller");
        $inve_sali = new Inve_sali_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($inve_sali->guardar());
                break;
            default:
                $this->data = $inve_sali->getDatos();
                $this->load_view('inve_sali', $this->data);
                break;
        }
        return true;
    }



}
