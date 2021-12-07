<?php

Class Admi_Controller Extends Admi_Model {

    
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }
    public function uscf_inde() {
        $this->load_class("uscf_inde", "controller");
        $uscf_inde = new Uscf_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $uscf_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            default:
                $this->load_view('uscf_inde');
                break;
        }
        return TRUE;
    }

    public function orse_inde() {
        $this->load_class("orse_inde", "controller");
        $orse_inde = new Orse_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $orse_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'autorizarOrden':
                $data = $orse_inde->autorizarOrden();
                header('Content-Type: application/json');
                echo json_encode($data);
            break; 
            case 'cancelarOrden':
                $data = $orse_inde->cancelarOrden();
                header('Content-Type: application/json');
                echo json_encode($data);
            break; 
                
            case 'generarOrden':
                $data = $orse_inde->generarOrden();
                header('Content-Type: application/json');
                echo json_encode($data);
            break; 
            case 'consultarOrden':
                    $data = $orse_inde->consultarOrden();
                    header('Content-Type: application/json');
                    echo json_encode($data);
            break; 
                
            case 'generarExcel':
                $orse_inde->generarExcel();
                break;
            case 'pdf':
                $orse_inde->generarPDF();
                break;
           
            default:
                $this->load_view('orse_inde');
                break;
        }
        return TRUE;
    }
    public function orse_deta() {
        $this->load_class("orse_deta", "controller");
        $orse_deta = new Orse_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'pdf':
                $orse_deta->crearPDF();
            break;
            case 'mostrarDocumento':
                $orse_deta->mostrarDocumento();
            break;
            case 'formatoPDF':
                echo $orse_deta->formatoPDF(); 
            break;
            default:
                $this->data = $orse_deta->consultar();
                $this->load_view('orse_deta', $this->data);
            break;
        }
        return true;
    } 

    public function cotr_inde() {
        $this->load_class("cotr_inde", "controller");
        $cotr_inde = new Cotr_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $cotr_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
            break;
            case 'generarExcel':
                $cotr_inde->generarExcel();
            break;
            case 'pdf':
                $cotr_inde->generarPDF();
            break;
            default:
                $this->load_view('cotr_inde');
            break;
        }
        return TRUE;
    }
    /**
     * cotr_form
     *
     * Módulo Formulario de Transacciones
     *
     * @author lvaldez <lvaldez>
     * @return mixed Array
     */
    public function cotr_form(){
        $this->load_class("cotr_form", "controller");
        $cotr_form = new Cotr_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getEmpresas':
                header('Content-Type: application/json');
                echo json_encode($cotr_form->getEmpresas());
                break;
            case 'getBancosCuentasResponsable':
                header('Content-Type: application/json');
                echo json_encode($cotr_form->getBancosCuentasResponsable());
                break;
            case 'updateComprobante':
                header('Content-Type: application/json');
                echo json_encode($cotr_form->updateComprobante());
                break;
            case 'get_facturas_pendientes_pago':
                header('Content-Type: application/json');
                echo json_encode($cotr_form->get_facturas_pendientes_pago());
                break;
            case 'eliminar_ADMINI_COMPRO':
                header('Content-Type: application/json');
                echo json_encode($cotr_form->eliminar_ADMINI_COMPRO());
                break;
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($cotr_form->guardar());
                break;
            default:
                $this->load_view('cotr_form', $cotr_form->get_data_transaccion());
                break;
        }
        return true;
    }

    public function cotr_deta() {
        $this->load_class("cotr_deta", "controller");
        $cotr_deta = new Cotr_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'pdf':
                $cotr_deta->crearPDF();
            break;
            case 'formatoPDF':
                echo $cotr_deta->formatoPDF(); 
            break;
            default:
                $this->data = $cotr_deta->consulta();
                $this->load_view('cotr_deta', $this->data);
            break;
        }
        return true;
    } 
    


    public function coco_inde() {
        $this->load_class("coco_inde", "controller");
        $coco_inde = new Coco_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $coco_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
            break;
            case 'generarExcel':
                $coco_inde->generarExcel();
            break;
            case 'pdf':
                $coco_inde->generarPDF();
            break;
            default:
                $this->load_view('coco_inde');
            break;
        }
        return TRUE;
    }

    public function coco_form()
    {
        $this->load_class("coco_form", "controller");
        $coco_form = new Coco_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($coco_form->guardar());
            break;
            case 'getEmpresas':
                header('Content-Type: application/json');
                echo json_encode($coco_form->getEmpresas());
            break;
            case 'obtenerDatos':
                header('Content-Type: application/json');
                echo json_encode($coco_form->obtenerDatosXML());
            break; 
            default:
                $this->load_view('coco_form', $this->data);
            break;
        }
        return true;
    }

    public function appa_inde() {
        $this->load_class("appa_inde", "controller");
        $appa_inde = new Appa_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $appa_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
            break;
            case 'generarExcel':
                $appa_inde->generarExcel();
            break;
            case 'pdf':
                $appa_inde->generarPDF();
            break;
            default:
                $this->load_view('appa_inde');
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


    public function serv_inde() {
        $this->load_class("serv_inde", "controller");
        $serv_inde = new Serv_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consulta':
                $data = $serv_inde->consulta();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $serv_inde->generarExcel();
                break;
            case 'pdf':
                $serv_inde->generarPDF();
                break;
            case 'cancelar':
                header('Content-Type: application/json');
                echo json_encode($serv_inde->cancelar(),true,512);
                break;
            default:
                $this->load_view('serv_inde');
                break;
        }
        return TRUE;
    }

     
 
    public function serv_form() {
        $this->load_class("serv_form", "controller");
        $serv_form = new Serv_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) { 
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($serv_form->guardar());
                break;
            default:
                $this->data = $serv_form->getDatos();
                $this->load_view('serv_form', $this->data);
                break;
        }
        return true;
    }
    public function serv_deta() {
        $this->load_class("serv_deta", "controller");
        $serv_deta = new Serv_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'pdf':
                $serv_deta->crearPDF();
                break;
            default:
                $this->data = $serv_deta->consultar();
                $this->load_view('serv_deta', $this->data);
                break;
        }
        return true;
    }

    /**
     * cotr_pago
     *
     * Módulo Formulario de Aplicar Pago de Transacciones
     *
     * @author   <lvaldez>
     * @return mixed Array
     */
    public function cotr_pago(){
        $this->load_class("cotr_pago", "controller");
        $cotr_pago = new Cotr_pago_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($cotr_pago->guardar());
                break;
            default:
                $this->load_view('cotr_pago', $cotr_pago->get_data_transaccion());
                break;
        }
        return true;
    }

    /**
     * coco_deta
     *
     * Módulo para visualizar toda la informacion de un control de cobro(coco_deta)
     *
     * @author  <lvaldez>
     */

    public function coco_deta() {
        $this->load_class("coco_deta", "controller");
        $coco_deta = new Coco_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'generarFormatoFA':
                $coco_deta->generarFormatoFA();
            break;
            case 'mostrarDocumento':
                     $coco_deta->mostrarDocumento();
             break;
            default:
                $this->data = $coco_deta->consultar();
                $this->load_view('coco_deta', $this->data);
            break;
        }
        return TRUE;
    }

     /**
     * coco_rela
     *
     * Módulo Formulario de Aplicar Pago de Transacciones
     *
     * @author   <lvaldez>
     * @return mixed Array
     */
    public function coco_rela(){
        $this->load_class("coco_rela", "controller");
        $coco_rela = new Coco_rela_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($coco_rela->guardar());
                break;
            default:
                $this->load_view('coco_rela', $coco_rela->consultar());
                break;
        }
        return true;
    }


}
