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
 

 


    public function conc_inde() {
        $this->load_class("conc_inde", "controller");
        $conc_inde = new Conc_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $conc_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $conc_inde->generarExcel();
                break;
            case 'pdf':
                $conc_inde->generarPDF();
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



}
