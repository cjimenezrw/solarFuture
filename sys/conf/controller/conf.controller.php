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

    /**
     * modn_inde
     *
     * Consultar Notas de Módulos
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Array
     */
    public function modn_inde() {
        $this->load_class("modn_inde", "controller");
        $modn_inde = new Modn_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($modn_inde->consultar());
            break;
            case 'generarExcel':
                $modn_inde->generarExcel();
            break;
            case 'pdf':
                $modn_inde->generarPDF();
            break;
            default:
                $this->load_view('modn_inde');
            break;
        }
        return true;
    }

    /**
     * modn_form
     *
     * Módulo Formulario de Notas de Módulos
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Array
     */
    public function modn_form() {
        $this->load_class("modn_form", "controller");
        $modn_form = new Modn_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getEmpresas':
                header('Content-Type: application/json');
                echo json_encode($modn_form->getEmpresas());
            break;
            case 'getUsuarios':
                header('Content-Type: application/json');
                echo json_encode($modn_form->getUsuarios());
            break;
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($modn_form->guardar());
                break;
            default:
                $this->data = $modn_form->getModulosNotas();
                $this->load_view('modn_form',$this->data);
            break;
        }
        return true;
    }

    public function tpno_inde() {
        $this->load_class("tpno_inde", "controller");
        $tpno_inde = new Tpno_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'getTiposNotificacion':
                $data = $tpno_inde->getTiposNotificacion();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'eliminar':
                $skTipoNotificacion = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));
                $data = $tpno_inde->eliminar($skTipoNotificacion);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $tpno_inde->generarExcelVariablesSistema();
                break;
            default:
                $this->load_view('tpno_inde', $this->data);
                break;
        }
        return true;
    }

    public function tpno_form() {
        $this->load_class("tpno_form", "controller");
        $tpno_form = new Tpno_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'guardar':
                $data = $tpno_form->accionesTipoNotificacion();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarCodigo':
                $respuesta = $tpno_form->validarCodigo();
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
                $this->data = $tpno_form->consultarTipoNotificacion();
                $this->load_view('tpno_form', $this->data);
                break;
        }
        return true;
    }

    public function conf_inde() {
        echo '<hr>MODULO CARGADO: conf_inde';
        echo('<pre>' . print_r($_GET, 1) . '</pre><hr>');
    }

    public function grus_inde() {
        $this->load_class("grus_inde", "controller");
        $grus_inde = new Grus_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                $data = $grus_inde->consultar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $grus_inde->generarExcel();
                break;
            case 'pdf':
                $grus_inde->generarPDF();
                break;
            default:
                $this->load_view('grus_inde');
                break;
        }
        return TRUE;
    }

    public function grus_form() {
        $this->load_class("grus_form", "controller");
        $grus_form = new Grus_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getUsuarios':
                $val = (isset($_POST['val']) ? $_POST['val'] : (isset($_GET['val']) ? $_GET['val'] : NULL));
                $data = $grus_form->get_usuarios($val);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'guardar':
                $data = $grus_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $grus_form->consultar();
                $this->load_view('grus_form', $this->data);
                break;
        }
        return true;
    }

    public function grus_deta() {
        $this->load_class("grus_deta", "controller");
        $grus_deta = new Grus_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->data = $grus_deta->consultarGrupo();
                $this->load_view('grus_deta', $this->data);
                break;
        }
        return true;
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

    public function sevi_inde() {
        $this->load_class("sevi_inde", "controller");
        $sevi_inde = new Sevi_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'getServidoresVinculados':
                $data = $sevi_inde->getServidoresVinculados();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $sevi_inde->generarExcelServidoresVinculados();
                break;
            default:
                $this->load_view('sevi_inde', $this->data);
                break;
        }
        return true;
    }

    public function sevi_form() {
        $this->load_class("sevi_form", "controller");
        $sevi_form = new Sevi_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'guardar':
                $data = $sevi_form->accionesServidores();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarCodigo':
                $respuesta = $sevi_form->validarCodigo();
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
                $this->data = $sevi_form->consultarServidor();
                $this->load_view('sevi_form', $this->data);
                break;
        }
        return true;
    }

    public function vasi_inde() {
        $this->load_class("vasi_inde", "controller");
        $vasi_inde = new Vasi_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'getVariablesSistema':
                $data = $vasi_inde->getVariablesSistema();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $vasi_inde->generarExcelVariablesSistema();
                break;
            default:
                $this->load_view('vasi_inde', $this->data);
                break;
        }
        return true;
    }

    public function vasi_form() {
        $this->load_class("vasi_form", "controller");
        $vasi_form = new Vasi_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'guardar':
                $data = $vasi_form->accionesVariables();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarCodigo':
                $respuesta = $vasi_form->validarCodigo();
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
                $this->data = $vasi_form->consultarVariable();
                $this->load_view('vasi_form', $this->data);
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

    public function tvar_inde() {
        $this->load_class("tvar_inde", "controller");
        $tvar_inde = new Tvar_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'generarExcel':
                $tvar_inde->generarExcelTiposVariables();
                break;

            case 'getTiposVariables':
                $data = $tvar_inde->getTiposVariables();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;

            default:
                $this->load_view('tvar_inde', $this->data);
                break;
        }
        return true;
    }

    public function tvar_deta() {
        $this->load_class("tvar_deta", "controller");
        $tvar_deta = new Tvar_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'pdf':
                $tvar_deta->crearPDF();
                break;
            default:
                $this->data['datos'] = $tvar_deta->consultarTipoDeVariable();
                $this->load_view('tvar_deta', $this->data);
                break;
        }
        return TRUE;
    }

    public function area_inde() {
        $this->load_class("area_inde", "controller");
        $area_inde = new Area_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getAreas':
                $data = $area_inde->getAreas();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $area_inde->generarExcelAreas();
                break;
            default:
                $this->load_view('area_inde');
                break;
        }
        return TRUE;
    }

    public function area_form() {
        $this->load_class("area_form", "controller");
        $area_form = new Area_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'guardar':
                $data = $area_form->accionesArea();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarCodigo':
                $respuesta = $area_form->validarCodigo();
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
                $this->data = $area_form->consultarArea();
                $this->load_view('area_form', $this->data);
                break;
        }
        return true;
    }

    public function tvar_form() {
        $this->load_class("tvar_form", "controller");
        $tvar_form = new Tvar_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'validarCodigo':
                $respuesta = $tvar_form->validarCodigoTipoVariable();
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
            case 'guardar':
                $data = $tvar_form->accionesTiposVariables();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            default:
                $this->data = $tvar_form->consultarTipoVariable();
                $this->load_view('tvar_form', $this->data);
                break;
        }
        return true;
    }

    public function depa_form() {
        $this->load_class("depa_form", "controller");
        $depa_form = new Depa_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'searchAreas':
                $arr = $this->searchAreas((isset($_GET['val'])) ? $_GET['val'] : $_POST['val']);

                header('Content-Type: application/json');
                echo json_encode($arr, 512);
                break;
            case 'guardar':
                $data = $depa_form->accionesDepa();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarCodigo':
                $respuesta = $depa_form->validarCodigo();
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
                $this->data = $depa_form->consultarDepa();
                $this->load_view('depa_form', $this->data);
                break;
        }
        return true;
    }

    public function depa_inde() {
        $this->load_class("depa_inde", "controller");
        $depa_inde = new Depa_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getDepa':
                $data = $depa_inde->getDepa();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $depa_inde->generarExcelDepartamentos();
                break;
            default:
                $this->load_view('depa_inde');
                break;
        }
        return TRUE;
    }

    public function apmo_inde() {
        $this->load_class("apmo_inde", "controller");
        $apmo_inde = new Apmo_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getAplicaciones':
                $data = $apmo_inde->getAplicaciones();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $apmo_inde->generarExcelAplicaciones();
                break;
            case 'pdf':
                $apmo_inde->generarPDF();
                break;
            default:
                $this->load_view('apmo_inde', $this->data);
                break;
        }
        return TRUE;
    }

    public function apus_deta() {
        $this->load_class("apus_deta", "controller");
        $apus_deta = new Apus_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getAppsUsers':
                $data = $apus_deta->getAplicaciones();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $apus_deta->generarExcelAplicaciones();
                break;
            case 'eliminar':
                $id = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));
                $data = $apus_deta->eliminar($id);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            default:
                $this->load_view('apus_deta', $this->data);
                break;
        }
        return TRUE;
    }

    public function apmo_form() {
        $this->load_class("apmo_form", "controller");
        $apmo_form = new Apmo_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'guardar':
                $data = $apmo_form->accionesAplicacion();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarCodigo':
                $respuesta = $apmo_form->validarCodigo();
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
                $this->data = $apmo_form->consultarAplicacion();
                $this->load_view('apmo_form', $this->data);
                break;
        }
        return true;
    }

    public function asap_form() {
        $this->load_class("asap_form", "controller");
        $asap_form = new Asap_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'guardar':
                $data = $asap_form->accionesPerfilesAplicaciones();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            default:
                $this->data = $asap_form->consultarPerfilAplicacion();
                $this->load_view('asap_form', $this->data);
                break;
        }
        return true;
    }

    public function apmo_deta() {
        $this->load_class("apmo_deta", "controller");
        $apmo_deta = new Apmo_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->data = $apmo_deta->consultarAplicacion();
                $this->load_view('apmo_deta', $this->data);
                break;
        }
        return true;
    }

    public function meno_inde() {
        $this->load_class("meno_inde", "controller");
        $meno_inde = new Meno_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getMensajesNotificacion':
                $data = $meno_inde->getMensajesNotificacion();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $meno_inde->generarExcelMensajesNotificacion();
                break;
            case 'pdf':
                $meno_inde->generarPDF();
                break;
            default:
                $this->load_view('meno_inde', $this->data);
                break;
        }
        return TRUE;
    }

    public function meno_form() {
        $this->load_class("meno_form", "controller");
        $meno_form = new Meno_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'validarCodigo':
                $respuesta = $meno_form->validarCodigo();
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
            case 'getModulos':
                $val = (isset($_POST['val']) ? $_POST['val'] : (isset($_GET['val']) ? $_GET['val'] : NULL));
                $data = $meno_form->get_modulos($val);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'guardar':
                $data = $meno_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $meno_form->consultar();
                $this->load_view('meno_form', $this->data);
                break;
        }
        return true;
    }

    public function grno_inde() {
        $this->load_class("grno_inde", "controller");
        $grno_inde = new Grno_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                $data = $grno_inde->consultar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $grno_inde->generarExcel();
                break;
            case 'pdf':
                $grno_inde->generarPDF();
                break;
            default:
                $this->load_view('grno_inde');
                break;
        }
        return TRUE;
    }

    public function grno_form() {
        $this->load_class("grno_form", "controller");
        $grno_form = new Grno_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getUsuarios':
                $val = (isset($_POST['val']) ? $_POST['val'] : (isset($_GET['val']) ? $_GET['val'] : NULL));
                $data = $grno_form->get_usuarios($val);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'getMensajes':
                $val = (isset($_POST['val']) ? $_POST['val'] : (isset($_GET['val']) ? $_GET['val'] : NULL));
                $data = $grno_form->get_mensajes($val);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'guardar':
                $data = $grno_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $grno_form->consultar();
                $this->load_view('grno_form', $this->data);
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

    public function caba_inde() {
        $this->load_class("caba_inde", "controller");
        $caba_inde = new Caba_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getCatalogosBancos':
                $data = $caba_inde->getCatalogosBancos();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $caba_inde->generarExcel();
                break;
            case 'pdf':
                $caba_inde->generarPDF();
                break;
            default:
                $this->load_view('caba_inde');
                break;
        }
        return TRUE;
    }

    public function cuen_inde() {
        $this->load_class("cuen_inde", "controller");
        $cuen_inde = new Cuen_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getCatalogosCuentas':
                $data = $cuen_inde->getCatalogosCuentas();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $cuen_inde->generarExcel();
                break;
            case 'pdf':
                $cuen_inde->generarPDF();
                break;
            default:
                $this->load_view('cuen_inde');
                break;
        }
        return TRUE;
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

    public function caba_form() {
        $this->load_class("caba_form", "controller");
        $caba_form = new Caba_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getDataBanco':
                $data = $caba_form->getDataBanco();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'guardar':
                $data = $caba_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $caba_form->getDataBanco();
                $this->load_view('caba_form', $this->data);
                break;
        }
        return TRUE;
    }

    public function cuen_form() {
        $this->load_class("cuen_form", "controller");
        $cuen_form = new Cuen_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getDataBancos':
                $data = $cuen_form->getDataBancos();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'guardar':
                $data = $cuen_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $cuen_form->getDataBanco();
                $this->load_view('cuen_form', $this->data);
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


    public function cage_inde() {
        $this->load_class("cage_inde", "controller");
        $cage_inde = new Cage_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getCatalogosGenerales':
                $data = $cage_inde->getCatalogosGenerales();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'generarExcel':
                $cage_inde->generarExcel();
                break;
            case 'pdf':
                $cage_inde->generarPDF();
                break;
            default:
                $this->load_view('cage_inde');
                break;
        }
        return TRUE;
    }

    /**
     * Módulo de agregado Catalogos de sistema generales
     *
     * Modulo que agrega o edita registros de Metadatos de Tipos de Documentos
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return html     Retorna la vista del módulo de catalogos Generales del Sistema.
     */
    public function cage_form() {
        $this->load_class("cage_form", "controller");
        $cage_form = new Cage_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                $data = $cage_form->accionesCatalogosSistema();
                if (!$data) {
                    return false;
                }
            return true;
            case 'validarCodigo':
                header('Content-Type: application/json');
                echo json_encode(array('valid' => $cage_form->validarCodigo()));
                break;
            default:
                $this->load_view('cage_form', $cage_form->consultar_cage());
                break;
        }
        return true;
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


    public function came_inde() {
        $this->load_class("came_inde", "controller");
        $came_inde = new Came_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                $data = $came_inde->consultar();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $came_inde->generarExcel();
                break;
            case 'pdf':
                $came_inde->generarPDF();
                break;
            default:
                $this->load_view('came_inde', $this->data);
                break;
        }
        return true;
    }

    public function came_form() {
        $this->load_class("came_form", "controller");
        $came_form = new Came_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                $came_form->guardar();
                break;
            default:
                $this->load_view('came_form', $came_form->consultarMercancia());
                break;
        }
        return true;
    }
    public function cldo_inde() {
        $this->load_class("cldo_inde", "controller");
        $cldo_inde = new Cldo_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                $data = $cldo_inde->consultar();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $cldo_inde->generarExcel();
                break;
            case 'pdf':
                $cldo_inde->generarPDF();
                break;
            default:
                $this->load_view('cldo_inde', $this->data);
                break;
        }
        return true;
    }
    public function cldo_form() {
        $this->load_class("cldo_form", "controller");
        $cldo_form = new Cldo_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                $cldo_form->guardar();
                break;
            default:
                $this->load_view('cldo_form', $cldo_form->consultarClaveDocumento());
                break;
        }
        return true;
    }

    public function ardo_inde() {
        $this->load_class("ardo_inde", "controller");
        $ardo_inde = new Ardo_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                $data = $ardo_inde->consultar();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $ardo_inde->generarExcel();
                break;
            case 'pdf':
                $ardo_inde->generarPDF();
                break;
            default:
                $this->load_view('ardo_inde', $this->data);
                break;
        }
        return true;
    }
    public function ardo_form() {
        $this->load_class("ardo_form", "controller");
        $ardo_form = new Ardo_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                $ardo_form->guardar();
                break;
            default:
                $this->load_view('cldo_form', $ardo_form->consultarArchivoDocumento());
                break;
        }
        return true;
    }

    public function rech_inde() {
        $this->load_class("rech_inde", "controller");
        $rech_inde = new Rech_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                $data = $rech_inde->consultar();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'generarExcel':
                $rech_inde->generarExcel();
                break;
            case 'pdf':
                $rech_inde->generarPDF();
                break;
            default:
                $this->load_view('rech_inde', $this->data);
                break;
        }
        return true;
    }

    public function rech_form() {
        $this->load_class("rech_form", "controller");
        $rech_form = new Rech_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                $rech_form->guardar();
                break;
            default:
                $this->load_view('rech_form', $rech_form->consultarRechazoRevalidacion());
                break;
        }
        return true;
    }


}
