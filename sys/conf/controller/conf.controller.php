<?php

require(SYS_PATH . 'inic/controller/autocom.php');

Class Conf_Controller Extends Conf_Model {

    use AutoCompleteTrait;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }
 


    public function conf_inde() {
        echo '<hr>MODULO CARGADO: conf_inde';
        echo('<pre>' . print_r($_GET, 1) . '</pre><hr>');
    }



    public function usua_inde() {
        $this->load_class("usua_inde", "controller");
        $usua_inde = new Usua_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getUsuarios':
                $data = $usua_inde->getUsuarios();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $usua_inde->generarExcelUsuario();
                break;
            case 'pdf':
                $usua_inde->generarPDF();
                break;
            default:
                $this->load_view('usua_inde');
                break;
        }
        return TRUE;
    }

    public function perf_inde() {
        $this->load_class("perf_inde", "controller");
        $perf_inde = new Perf_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'obtenerPerfiles':
                $data = $perf_inde->obtenerPerfiles();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $perf_inde->generarExcelPerfiles();
                break;
            case 'pdf':
                $perf_inde->generarPDF();
                break;
            default:
                $this->load_view('perf_inde');
                break;
        }
        return TRUE;
    }

    public function perf_form() {
        $this->load_class("perf_form", "controller");
        $perf_form = new Perf_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'consultarPerfilClonado':
                $skPerfilClonar = isset($_POST['skPerfilClonar']) ? $_POST['skPerfilClonar'] : NULL;
                $data = $perf_form->consultar_perfil_clonado($skPerfilClonar);
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'guardar':
                $data = $perf_form->accionesPerfiles();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            default:
                $this->data = $perf_form->consultarPerfil();
                $this->load_view('perf_form', $this->data);
                break;
        }
        return true;
    }

     public function hica_inde() {
        $this->load_class("hica_inde", "controller");
        $hica_inde = new Hica_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'getAccessHistory':
                $data = $hica_inde->getAccessHistory();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $hica_inde->generarExcel();
                break;
            case 'pdf':
                $hica_inde->generarPDF();
                break;
            default:
                $this->load_view('hica_inde', $this->data);
                //$this->load_view('hica_inde');
                break;
        }
        return true;
    }

    public function hiac_inde() {
        $this->load_class("hiac_inde", "controller");
        $hiac_inde = new Hiac_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'generarExcel':
                $hiac_inde->generarExcel();
                break;
            case 'pdf':
                $hiac_inde->generarPDF();
                break;
            case 'getActionsHistory':
                $data = $hiac_inde->getActionsHistory();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            default:
                $this->load_view('hiac_inde', $this->data);
                //$this->load_view('hica_inde');
                break;
        }
        return true;
    }

    public function usua_form() {

        $this->load_class("usua_form", "controller");
        $usua_form = new Usua_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'aut_empresas':
                $value = (isset($_GET['val'])) ? $_GET['val'] : $_POST['val'];
                $data = $this->aut_empresas($value);
                header('Content-Type: application/json');
                echo json_encode($data, 512);
                break;
            case 'aut_perfiles':
                $value = (isset($_GET['val'])) ? $_GET['val'] : $_POST['val'];
                $data = $this->aut_perfiles($value);
                header('Content-Type: application/json');
                echo json_encode($data, 512);
                break;
            case 'rel_area_departamento':
                $skArea = isset($_POST['skArea']) ? $_POST['skArea'] : NULL;
                $data = $usua_form->rel_area_departamento($skArea);
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'getCaracteristicaCatalogo':
                $sCatalogo = isset($_GET['sCatalogo']) ? $_GET['sCatalogo'] : NULL;
                $sCatalogoKey = isset($_GET['sCatalogoKey']) ? $_GET['sCatalogoKey'] : NULL;
                $sCatalogoNombre = isset($_GET['sCatalogoNombre']) ? $_GET['sCatalogoNombre'] : NULL;
                $data = $usua_form->getCaracteristicaCatalogo($sCatalogo, $sCatalogoKey, $sCatalogoNombre);
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'guardar':
                $data = $usua_form->accionesUsuarios();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarUsuario':
                $respuesta = $usua_form->validarUsuario();
                if ($respuesta) {
                    $isAvailable = true;
                } else {
                    $isAvailable = false;
                }
                $data = array('valid' => $isAvailable);
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            default:
                $this->data = $usua_form->consultarUsuario();
                $this->load_view('usua_form', $this->data);
                break;
        }
        return true;
    }

    public function usua_deta() {
        $this->load_class("usua_deta", "controller");
        $usua_deta = new Usua_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'pdf':
                $usua_deta->crearPDF();
                break;
            default:
                $this->data['datos'] = $usua_deta->consultarUsuario();
                $this->load_view('usua_deta', $this->data);
                break;
        }
        return true;
    }

    public function perf_deta() {
        $this->load_class("perf_deta", "controller");
        $perf_deta = new Perf_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            default:
                $this->data['datos'] = $perf_deta->consultarPerfil();
                $this->load_view('perf_deta', $this->data);
                break;
        }
        return true;
    }

    public function hmsg_inde() {
        $this->load_class("hmsg_inde", "controller");
        $hmsg_inde = new Hmsg_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'getAccessMsgHistory':
                $data = $hmsg_inde->getAccessMsgHistory();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $hmsg_inde->generarExcel();
                break;
            default:
                $this->load_view('hmsg_inde', $this->data);
                break;
        }
        return true;
    }

    public function hmsg_deta() {
        $this->load_class("hmsg_deta", "controller");
        $hmsg_deta = new Hmsg_deta_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {

            case 'pdf':
                $hmsg_deta->crearPDF();
                break;
            default:
                $this->data['datos'] = $hmsg_deta->consultarRegistroMsg();
                $this->load_view('hmsg_deta', $this->data);
                break;
        }
        return true;
    }
 

     

    /**
     * toke_form
     *
     * Módulo para la asignación de un token para tener permisos a los servicios web (API,WEB SERVICE,CRON JOB)
     *
     * @author           Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed     Retorna el un array de resultados o la vista del módulo.
     */
    public function toke_form() {
        $this->load_class("toke_form", "controller");
        $toke_form = new Toke_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                $data = $toke_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $toke_form->consultarUsuarioToken();
                $this->load_view('toke_form', $this->data);
                break;
        }
        return true;
    }

 

      


    public function hino_inde() {
        $this->load_class("hino_inde", "controller");
        $hino_inde = new Hino_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'getNotiHistory':
                $data = $hino_inde->getNotiHistory();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $hino_inde->generarExcel();
                break;
            default:
                $this->load_view('hino_inde', $this->data);
                break;
        }
        return true;
    }

   



    public function tarj_inde() {
        $this->load_class("tarj_inde", "controller");
        $tarj_inde = new Tarj_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getCatalogosTarjetas':
                $data = $tarj_inde->getCatalogosTarjetas();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $tarj_inde->generarExcel();
                break;
            case 'pdf':
                $tarj_inde->generarPDF();
                break;
            default:
                $this->load_view('tarj_inde');
                break;
        }
        return TRUE;
    }

    

    public function tarj_form() {
        $this->load_class("tarj_form", "controller");
        $tarj_form = new Tarj_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getDataBancos':
                $data = $tarj_form->getDataBancos();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'guardar':
                $data = $tarj_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $tarj_form->getDataBanco();
                $this->load_view('tarj_form', $this->data);
                break;
        }
        return TRUE;
    }


  


    public function stpCU_addCuentas() {
        $sql = "EXECUTE stpCU_confCorreos
            @skBanco           = " . escape($this->cuenta['skBanco']) . ",
            @sCuenta                  = " . escape($this->cuenta['sCuenta']) . ",
            @skDescripcion          = " . escape($this->cuenta['skDescripcion']) . ",
            @skUsuario                = " . escape($_SESSION['usuario']['skUsuario']);


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }



}
