<?php
Class Docu_Controller Extends Docu_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
    
    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function docu_serv() {
        $this->load_class("docu_serv", "controller");
        $docu_serv = new Docu_serv_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($docu_serv->guardar(),true,512);
                break;
            case 'configuracion_tipoExpediente_tipoDocumento':
                header('Content-Type: application/json');
                echo json_encode($docu_serv->configuracion_tipoExpediente_tipoDocumento(),true,512);
                break;
            case 'get_documentos':
                header('Content-Type: application/json');
                echo json_encode($docu_serv->get_documentos(),true,512);
                break;
            case 'eliminar':
                header('Content-Type: application/json');
                echo json_encode($docu_serv->eliminar(),true,512);
                break;
            default:
                exit('<pre>'.print_r('Docu Serv',1).'</pre>');
                break;
        }
        return;
    }

    public function expe_inde() {
        $this->load_class("expe_inde", "controller");
        $expe_inde = new Expe_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($expe_inde->consultar(),true,512);
                break;
            case 'generarExcel':
                $expe_inde->generarExcel();
                break;
            case 'pdf':
                $expe_inde->generarPDF();
                break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($expe_inde->cancelar(),true,512);
                break;
            default:
                $this->load_view('expe_inde');
                break;
        }
        return TRUE;
    }

    public function expe_form() {
        $this->load_class("expe_form", "controller");
        $expe_form = new Expe_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($expe_form->guardar(),true,512);
                break;
            default:
                $this->load_view('expe_form',$expe_form->consultar());
                break;
        }
        return;
    }

    public function expe_deta() {
        $this->load_class("expe_deta", "controller");
        $expe_deta = new Expe_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->load_view('expe_deta',$expe_deta->consultar());
                break;
        }
        return;
    }

}