<?php

Class Empr_Controller Extends Empr_Model {

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
     * Módulo de consulta de empresas (empr-inde)
     *
     * Módulo para consultar el catálogo de empresas
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return html     Retorna la vista del módulo de consulta de empresas y/o funcionalidades.
     */
    public function empr_inde() {
        $this->load_class("empr_inde", "controller");
        $empr_inde = new Empr_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'generarExcel':
                $empr_inde->generarExcel();
                return TRUE;
                break;
            case 'getEmpresas':
                $data = $empr_inde->getEmpresas();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'pdf':
                $empr_inde->generarPDF();
                break;
            default:
                $this->load_view('empr_inde', $this->data);
                break;
        }
        return true;
    }

    /**
     * Módulo de consulta de empresas socios (emso-inde)
     *
     * Módulo para consultar el catálogo de empresas socios
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return html     Retorna la vista del módulo de consulta de empresas socios y/o funcionalidades.
     */
    public function emso_inde() {
        $this->load_class("emso_inde", "controller");
        $emso_inde = new Emso_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'generarExcel':
                $emso_inde->generarExcel();
                return TRUE;
                break;
            case 'getEmpresasSocios':
                $data = $emso_inde->getEmpresasSocios();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'pdf':
                $emso_inde->generarPDF();
                break;
            default:
                $this->load_view('emso_inde', $this->data);
                break;
        }
        return true;
    }

    /**
     * Módulo de formulario de empresas socios (emso-form)
     *
     * Módulo para agregar / editar el catálogo de empresas socios
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return html     Retorna la vista del módulo de consulta de empresas socios y/o funcionalidades.
     */
    public function emso_form() {
        $this->load_class("emso_form", "controller");
        $emso_form = new Emso_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getCaracteristicaCatalogo':
                $sCatalogo = isset($_GET['sCatalogo']) ? $_GET['sCatalogo'] : NULL;
                $sCatalogoKey = isset($_GET['sCatalogoKey']) ? $_GET['sCatalogoKey'] : NULL;
                $sCatalogoNombre = isset($_GET['sCatalogoNombre']) ? $_GET['sCatalogoNombre'] : NULL;
                $data = $emso_form->getCaracteristicaCatalogo($sCatalogo, $sCatalogoKey, $sCatalogoNombre);
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'rel_caracteristica_empesaTipo':
                $skEmpresaTipo = isset($_POST['skEmpresaTipo']) ? $_POST['skEmpresaTipo'] : NULL;
                $data = $emso_form->rel_caracteristica_empesaTipo($skEmpresaTipo);
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'validarEmpresaSocio':
                $data = $emso_form->validarEmpresaSocio();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            case 'guardar':
                $data = $emso_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $emso_form->consultarSocioEmpresa();
                $this->load_view('emso_form', $this->data);
                break;
        }
        return true;
    }

   
    public function tipo_inde() {
        $this->load_class("tipo_inde", "controller");

        $empr_tipo = new Tipo_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'generarExcel':
                $empr_tipo->generarExcelTipos();
                break;
            case 'getTiposEmpresas':
                $data = $empr_tipo->consultarTipo();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            default:
                $this->load_view('tipo_inde', $this->data);
                break;
        }
        return true;
    }

    public function tipo_form() {
        $this->load_class("tipo_form", "controller");
        $tipo_form = new Tipo_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'validarCodigo':
                $respuesta = $tipo_form->validarCodigo();
                if ($respuesta) {
                    $isAvailable = true;
                } else {
                    $isAvailable = false;
                }
                $data = array('valid' => $isAvailable);
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
            case 'guardar':
                $data = $tipo_form->accionesTipos();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            default:
                $this->data = $tipo_form->consultarTipo();
                $this->load_view('tipo_form', $this->data);
                break;
        }
        return true;
    }

    public function tipo_deta() {
        $this->load_class("tipo_deta", "controller");

        $tipo_deta = new Tipo_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'pdf':
                $tipo_deta->crearPDF();
                break;
            default:
                $this->data['datos'] = $tipo_deta->consultarTipo();
                $this->load_view('tipo_deta', $this->data);
                break;
        }
        return true;
    }

    /**
     * Consulta de Prospectos (pros-inde)
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return html Retorna la vista del módulo
     */
    public function pros_inde() {
        $this->load_class("pros_inde", "controller");
        $pros_inde = new Pros_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($pros_inde->consultar());
                break;
            case 'eliminar':
                header('Content-Type: application/json');
                echo json_encode($pros_inde->eliminar());
                break;
            case 'generarExcel':
                $pros_inde->generarExcel();
                break;
            case 'pdf':
                $pros_inde->generarPDF();
                break;
            default:
                $this->load_view('pros_inde', $this->data);
                break;
        }
        return true;
    }

    /**
     * Formulario de Prospectos (pros-form)
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return html Retorna la vista del módulo
     */
    public function pros_form() {
        $this->load_class("pros_form", "controller");
        $pros_form = new Pros_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($pros_form->guardar());
                break;
            default:
                $this->load_view('pros_form', $pros_form->consultar());
                break;
        }
        return TRUE;
    }

    /**
     * Detalles de Prospectos (pros-deta)
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return html Retorna la vista del módulo
     */
    public function pros_deta() {
        $this->load_class("pros_deta", "controller");
        $pros_deta = new Pros_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->load_view('pros_deta', $pros_deta->consultar());
                break;
        }
        return TRUE;
    }
}
