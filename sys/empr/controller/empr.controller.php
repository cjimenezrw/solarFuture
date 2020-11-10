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
     * dacr_inde
     *
     * Módulo para consultar los días de almacenajes por cliente y recinto
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return html Vista del módulo
     */
    public function dacr_inde(){
        $this->load_class("dacr_inde", "controller");
        $dacr_inde = new Dacr_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'generarExcel':
                $dacr_inde->generarExcel();
                break;
            case 'pdf':
                $dacr_inde->generarPDF();
                break;
            case 'eliminar':
                header('Content-Type: application/json');
                echo json_encode($dacr_inde->eliminar());
                break;
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($dacr_inde->consultar());
                break;
            default:
                $this->load_view('dacr_inde', $this->data);
                break;
        }
        return true;
    }

    /**
     * dacr_form
     *
     * Módulo para configurar los días de almacenajes por cliente y recinto
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return html Vista del módulo
     */
    public function dacr_form(){
        $this->load_class("dacr_form", "controller");
        $dacr_form = new Dacr_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getClientes':
                header('Content-Type: application/json');
                echo json_encode($dacr_form->getClientes());
                break;
            case 'validarConfiguracion':
                header('Content-Type: application/json');
                echo json_encode($dacr_form->validarConfiguracion());
                break;
            case 'getRecintos':
                header('Content-Type: application/json');
                echo json_encode($dacr_form->getRecintos());
                break;
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($dacr_form->guardar());
                break;
            default:
                $this->data['recintos'] = $dacr_form->getRecintos();
                $this->data['datos'] = $dacr_form->getAlmacenajesClientesRecintos();//exit('<pre>'.print_r($this->data,1).'</pre>');
                $this->load_view('dacr_form', $this->data);
                break;
        }
        return true;
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

    public function suem_inde() {
        //exit('<pre>'.print_r($_SESSION['modulos'],1).'</pre>');
        $this->load_class("suem_inde", "controller");
        $suem_inde = new Suem_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'getSucursales':
                $data = $suem_inde->getSucursales();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $suem_inde->generarExcelSucursales();
                break;
            case 'pdf':
                $suem_inde->generarPDF();
                break;
            default:
                $this->load_view('suem_inde', $this->data);
                break;
        }
        return true;
    }

    public function suem_form() {
        $this->load_class("suem_form", "controller");
        $suem_form = new Suem_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'guardar':
                $data = $suem_form->accionesSucursales();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            case 'validarCodigo':
                $respuesta = $suem_form->validarCodigo();
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
                $this->data = $suem_form->consultarSucursal();
                $this->load_view('suem_form', $this->data);
                break;
        }
        return true;
    }

    public function codo_form() {
        $this->load_class("codo_form", "controller");
        $codo_form = new Codo_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'aut_typeDocs':
                $value = (isset($_GET['val'])) ? $_GET['val'] : $_POST['val'];
                $data = $this->aut_typeDocs($value);
                header('Content-Type: application/json');
                echo json_encode($data, 512);
                break;
            case 'guardar':
                $data = $codo_form->guardar();
                header('Content-Type: application/json');
                echo json_encode($data);
                return TRUE;
                break;
            default:
                $this->data = $codo_form->consultarTipo();
                $this->data['configDocs'] = json_encode($codo_form->get_ConfigDocsEmpr());
                $this->load_view('codo_form', $this->data);
                break;
        }
        return true;
    }

    public function suem_deta() {
        $this->load_class("suem_deta", "controller");
        $suem_deta = new Suem_deta_Controller();
        $axn = isset($_POST['axn']) ? $_POST['axn'] : $_GET['axn'];

        switch ($axn) {
            case 'pdf':
                $suem_deta->crearPDF();
                break;
            default:
                $this->data['datos'] = $suem_deta->consultarSucursal();
                $this->load_view('suem_deta', $this->data);
                break;
        }
        return true;
    }

    public function grup_inde() {

        $this->load_class("grup_inde", "controller");
        $grup_inde = new Grup_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'getGrupos':
                $data = $grup_inde->getGrupos();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            case 'generarExcel':
                $grup_inde->generarExcelGrupos();
                break;
            case 'pdf':
                $grup_inde->generarPDF();
                break;
            default:
                $this->load_view('grup_inde', $this->data);
                break;
        }
        return true;
    }

    public function grup_form() {
        $this->load_class("grup_form", "controller");
        $grup_form = new Grup_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'aut_empresas':
                $value = isset($_POST['val']) ? $_POST['val'] : '';
                $data = $this->aut_empresas($value);
                header('Content-Type: application/json');
                echo json_encode($data, 512);
                break;
            case 'guardar':
                $data = $grup_form->accionesGrupos();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            default:
                $this->data = $grup_form->consultarGrupo();
                $this->load_view('grup_form', $this->data);
                break;
        }
        return true;
    }

    public function grup_deta() {
        $this->load_class("grup_deta", "controller");

        $grup_deta = new Grup_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'pdf':
                $grup_deta->crearPDF();
                break;
            default:
                $this->data = $grup_deta->consultarGrupo();
                $this->load_view('grup_deta', $this->data);
                break;
        }
        return true;
    }
    public function prom_form() {
        $this->load_class("prom_form", "controller");
        $prom_form = new Prom_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {

            case 'guardar':
                $data = $prom_form->guardar();
                if (!$data) {
                    return false;
                }
                return true;
                break;
            default:
                $this->data = $prom_form->consultarPromotor();
                $this->load_view('prom_form', $this->data);
                break;
        }
        return true;
    }
    public function prom_inde() {
        $this->load_class("prom_inde", "controller");

        $prom_inde = new Prom_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'generarExcel':
                $prom_inde->generarExcel();
                break;
            case 'consultarPromotores':
                $data = $prom_inde->consultarPromotores();
                header('Content-Type: application/json');
                echo json_encode($data);
                return true;
                break;
            default:
                $this->load_view('prom_inde', $this->data);
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

    public function soem_inde() {
        //exit('<pre>'.print_r($_SESSION['modulos'],1).'</pre>');
        $this->load_class("soem_inde", "controller");
        $soem_inde = new Soem_inde_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'getSolicitudesEmpresas':
                $data = $soem_inde->getSolicitudesEmpresas();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'eliminar':
                header('Content-Type: application/json');
                echo json_encode($soem_inde->eliminar());
                break;
            case 'rechazar':
                header('Content-Type: application/json');
                echo json_encode($soem_inde->rechazar());
                break;
            case 'aprobar':
                header('Content-Type: application/json');
                echo json_encode($soem_inde->aprobar());
                break;
            case 'solInfo':
                header('Content-Type: application/json');
                echo json_encode($soem_inde->solInfo());
                break;
            case 'generarExcel':
                $soem_inde->generarExcel();
                break;
            case 'pdf':
                $soem_inde->generarPDF();
                break;
            default:
                $this->load_view('soem_inde', $this->data);
                break;
        }
        return true;
    }

    public function soem_form() {
        $this->load_class("soem_form", "controller");
        $soem_form = new Soem_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'guardar':
                $data = $soem_form->accionesSolicitudesEmpresas();
                if (!$data) {
                    return false;
                }
                break;
            case 'rel_caracteristica_empesaTipo':
                $this->load_class("emso_form", "controller");
                $emso_form = new Emso_form_Controller();
                $skEmpresaTipo = isset($_POST['skEmpresaTipo']) ? $_POST['skEmpresaTipo'] : NULL;
                $data = $emso_form->rel_caracteristica_empesaTipo($skEmpresaTipo);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'validarEmpresaSocio':
                $this->load_class("emso_form", "controller");
                $emso_form = new Emso_form_Controller();
                $data = $emso_form->validarEmpresaSocio();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'validarCodigo':

                $respuesta = $soem_form->validarCodigo();
                if ($respuesta) {
                    $isAvailable = true;
                } else {
                    $isAvailable = false;
                }
                $data = array('valid' => $isAvailable);
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            default:
                $this->load_view('soem_form', $soem_form->consultarSolicitudEmpresa());
                break;
        }
        return true;
    }

    public function soem_deta() {
        $this->load_class("soem_deta", "controller");
        $soem_deta = new Soem_deta_Controller();
        $axn = isset($_POST['axn']) ? $_POST['axn'] : $_GET['axn'];

        switch ($axn) {
            case 'pdf':
                $soem_deta->crearPDF();
                break;
            default:
                $this->load_view('soem_deta', $soem_deta->consultarSolicitud()['data']);
                break;
        }
        return true;
    }

    public function esrv_inde(){
        $this->load_class("esrv_inde", "controller");
        $esrv_inde = new Esrv_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'generarExcel':
                $esrv_inde->generarExcel();
                break;
            case 'getServicios':
                header('Content-Type: application/json');
                echo json_encode($esrv_inde->getServicios());
                break;
            case 'pdf':
                $esrv_inde->generarPDF();
                break;
            case 'eliminar':
                $sk = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));
                header('Content-Type: application/json');
                echo json_encode($esrv_inde->eliminar(escape($sk)));
                break;
            default:
                $this->load_view('esrv_inde', $this->data);
                break;
        }
        return true;
    }

    public function esrv_form(){
        $this->load_class("esrv_form", "controller");
        $esrv_form = new Esrv_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'guardar':
                $data = $esrv_form->accionesServicios();
                if (!$data) {
                    return false;
                }
                break;

            default:
                $this->load_view('esrv_form', $esrv_form->consultarServicio());
                break;
        }
        return true;
    }

    public function asem_form(){
        $this->load_class("asem_form", "controller");
        $asem_form = new Asem_form_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'guardar':
                $data = $asem_form->accionesServiciosEmpresas();
                if (!$data) {
                    return false;
                }
                break;
            case 'aut_servicios':
                $value = (isset($_GET['val'])) ? $_GET['val'] : $_POST['val'];
                $d = $this->aut_servicios($value, escape($_GET['p1']));
                header('Content-Type: application/json');
                echo json_encode($d, 512);
                break;
            default:
                $this->load_view('asem_form', $asem_form->consultarSolicitudEmpresa());
                break;
        }
        return true;
    }



    /**
     * coem_inde
     *
     * Módulo para consultar los correos de empresas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return html Retorna la vista configuraciones de correos de empreas
     */
    public function coem_inde() {
        $this->load_class("coem_inde", "controller");
        $coem_inde = new Coem_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'generarExcel':
                $coem_inde->generarExcel();
                break;
            case 'pdf':
                $coem_inde->generarPDF();
                break;/*015133*/
            case 'eliminar':
                header('Content-Type: application/json');
                echo json_encode($coem_inde->eliminar());
                break;
            case 'consultar':
                header('Content-Type: application/json');
                echo json_encode($coem_inde->consultar());
                break;
            default:
                $this->load_view('coem_inde', $this->data);
                break;
        }
        return true;
    }

    /**
     * coem_form
     *
     * Módulo para guardar correos de empresas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return html funcion para guardar correos de empresas
     */
    public function coem_form() {
        $this->load_class("coem_form", "controller");
        $coem_form = new Coem_form_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'getEmpresas':
                header('Content-Type: application/json');
                echo json_encode($coem_form->getEmpresas());
                break;
            case 'validarConfiguracion':
                header('Content-Type: application/json');
                echo json_encode($coem_form->validarConfiguracion());
                break;
            case 'guardar':
                header('Content-Type: application/json');
                echo json_encode($coem_form->guardar());
                break;
            default:
                $this->data['datos'] = $coem_form->getConfiguracionCorreos();
                $this->load_view('coem_form', $this->data);
                break;
        }
        return true;
    }

    /**
     * coem_deta
     *
     * Módulo para consulta de corroes de empresa
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return html Retorna la vista del módulo de consulta de corroes de empresa
     */
    public function coem_deta() {
        $this->load_class("coem_deta", "controller");
        $coem_deta = new Coem_deta_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->data['datos'] = $coem_deta->getConfiguracionCorreos();
                $this->load_view('coem_deta', $this->data);
                break;
        }
        return true;
    }

    /**
     * get_configuracionCorreosEmpresas
     *
     * Obtiene la configuración de correos de Empresas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function get_configuracionCorreosEmpresas() {
        $sql = "SELECT lc.skConfiguracionCorreo, et.skEmpresaTipo, et.sNombre AS tipoEmpresa, es.skEmpresaSocio, es.skEstatus, est.sNombre AS estatus, e.sRFC, IIF(e.sNombreCorto IS NOT NULL, e.sNombreCorto, e.sNombre) AS cliente, lc.sCorreo

            FROM cat_configuracionCorreos lc
            INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = lc.skEmpresaSocio
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN core_estatus est ON est.skEstatus = es.skEstatus
            INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo
            WHERE lc.skTipoProceso = 'REAC' AND lc.skEmpresaSocio = " . escape($this->correo['skEmpresaSocio']);

        $result = Conn::query($sql);

        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * get_empresas
     *
     * Consulta empresas
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function get_empresas() {
        $sql = "SELECT N1.* FROM (
            SELECT
            es.skEmpresaSocio AS id, IIF(e.sNombreCorto IS NOT NULL, e.sNombreCorto, e.sNombre) AS nombre, es.skEmpresaTipo
            FROM rel_empresasSocios es
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            WHERE es.skEstatus = 'AC' AND es.skEmpresaSocioPropietario = " . escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

        if (!empty($this->lamina['skEmpresaTipo'])) {
            if (is_array($this->lamina['skEmpresaTipo'])) {
                $sql .= " AND es.skEmpresaTipo IN (" . mssql_where_in($this->lamina['skEmpresaTipo']) . ") ";
            } else {
                $sql .= " AND es.skEmpresaTipo = " . escape($this->lamina['skEmpresaTipo']);
            }
        }

        $sql .= " ) AS N1 ";

        if (!empty($this->lamina['sNombre'])) {
            $sql .= " WHERE N1.nombre COLLATE Latin1_General_CI_AI LIKE '%" . $this->lamina['sNombre'] . "%' ";
        }

        if (!empty($this->lamina['skEmpresaSocio'])) {
            $sql .= " WHERE N1.id = " . escape($this->lamina['skEmpresaSocio']);
        }

        $sql .= " ORDER BY N1.nombre ASC ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }


}
