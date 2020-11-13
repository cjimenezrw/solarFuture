<?php

require(SYS_PATH . 'inic/controller/autocom.php');

Class Inic_Controller Extends Inic_Model {

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

    public function inic_sesi() {
        //Mandamos llamar controller especial para la vista de inic-sesi
        $this->load_class("inic_sesi", "controller");
        $inic_sesi = new Inic_sesi_Controller();

        // Accion que le dice al switch a donde entrar
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        switch ($axn) {
            case 'verificarSession':
                $inic_sesi->verificarSession();
                break;
            case 'iniciarSession':
                $inic_sesi->iniciar_sesion();
                break;
            default:
                if (isset($_SESSION['usuario'])) {
                    header('Location: ' . SYS_URL . SYS_PROJECT . '/inic/inic-dash/inicio/');
                } else {
                    $this->load_view('inic_sesi', array(), NULL, FALSE);
                }
                break;
        }
    }

    public function inic_dash() {
        $this->load_class("inic_dash", "controller");
        $inic_dash = new Inic_dash_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        if (isset($_GET['axn']) && $axn === '') {
            $axn = (isset($_GET['axn']) ? $_GET['axn'] : '');
        }

        switch ($axn) {
 
            case 'obtenerPerfiles':
                $arr = $this->obtenerPerfiles($_GET['perfilesLike']);
                header('Content-Type: application/json');
                echo json_encode($arr, 512);
                break;
            case 'obtenerEmpresas':
                $arr = $this->obtenerEmpresas($_GET['empresasLike']);
                header('Content-Type: application/json');
                echo json_encode($arr, 512);
                break;
            case 'estadisticaAccesos':
                $data = $inic_dash->estadisticaAccesos();
                header('Content-Type: application/json');
                echo $data;
                return true;
                break;
            case 'saveFilters':
                $data = $inic_dash->saveFilters();
                echo $data;
                return true;
                break;
            case 'getFilters':
                $data = $inic_dash->getFilters();
                header('Content-Type: application/json');
                echo $data;
                return true;
            break;
            case 'removeFilters':
                        $data = $inic_dash->removeFilters();
                        header('Content-Type: application/json');
                        echo $data;
                        return true;
            break;
            default:
                $this->data = $inic_dash->datosInicial();
                $this->load_view('inic_dash', $this->data);
                break;
        }
        return true;
    }

    public function func_test() {

        $this->load_class("inic_testing", "controller");
        $inic_dash = new Inic_testing_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        if (isset($_GET['axn']) && $axn === '') {
            $axn = (isset($_GET['axn']) ? $_GET['axn'] : '');
        }
        switch ($axn) {

            case 'hailPDF' :

                $pdfConfig = array(
                    "data" => array(),
                    "waterMark" => array(
                        "imgsrc" => CORE_PATH . 'assets/tpl/images/logoWB.png',
                        "opacity" => .15,
                        "size" => array(100, 100),
                        "place" => 'P'
                    ),
                    "content" => SYS_PATH . $this->sysModule . '/view/forDaPDFs/content.php',
                    "header" => SYS_PATH . $this->sysModule . '/view/forDaPDFs/header.php',
                    "footer" => SYS_PATH . $this->sysModule . '/view/forDaPDFs/footer.php',
                    "css" => SYS_PATH . $this->sysModule . '/view/forDaPDFs/css.css',
                    "pdf" => array(
                        "contentMargins" => array(10, 10, 25, 25),
                        "format" => 'LETTER',
                        "vertical" => true,
                        "footerMargin" => 5,
                        "headerMargin" => 5,
                        "font-size" => 12,
                        "font" => 'Times',
                        "fileName" => '',
                        "location" => '',
                    )
                );

                parent::pdf($pdfConfig);
                break;

            case 'returnExcel':
                $this->retornarExcel();
                break;

            case 'mail':
                $this->sendMail($m = 0);
                break;
            default:

                $this->load_view('inic_testing');
                break;
        }
        return true;
    }

    public function func_cata() {
        $this->load_class("func_cata", "controller");
        $func_cata = new Func_cata_Controller();

        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');

        if (isset($_GET['axn']) && $axn === '') {
            $axn = (isset($_GET['axn']) ? $_GET['axn'] : '');
        }

        switch ($axn) {
            default:

                $this->data['datos'] = $func_cata->cargarModulos();
                $this->load_view('func_cata', $this->data);
                break;
        }
        return true;
    }

    public function func_opci() {
        $this->load_class("func_opci", "controller");
        $func_opci = new Func_opci_Controller();
        switch ($axn) {
            default:
                $this->data['datos'] = $func_opci->cargarModulos();
                $this->load_view('func_opci', $this->data);
                break;
        }
        return true;
    }

    public function func_oper() {
        $this->load_class("func_oper", "controller");
        $func_oper = new Func_oper_Controller();
        switch ($axn) {
            default:
                $this->data['datos'] = $func_oper->cargarModulos();
                $this->load_view('func_oper', $this->data);
                break;
        }
        return true;
    }

    public function func_esta() {
        $this->load_class("func_esta", "controller");
        $func_esta = new Func_esta_Controller();
        switch ($axn) {
            default:
                $this->data['datos'] = $func_esta->cargarModulos();
                $this->load_view('func_esta', $this->data);
                break;
        }
        return true;
    }

    public function func_cons() {
        $this->load_class("func_cons", "controller");
        $func_cons = new Func_cons_Controller();
        switch ($axn) {
            default:
                $this->data['datos'] = $func_cons->cargarModulos();
                $this->load_view('func_cons', $this->data);
                break;
        }
        return true;
    }

    public function retornarExcel() {

        $datos = "perra";

        if (!isset($_GET['datos']) && !isset($_POST['datos'])) {

            echo "No datos no excel, PERRA!";

            return false;
        } else {

            $datos = (isset($_GET['datos'])) ? $_GET['datos'] : $_POST['datos'];
        }

        if (is_string($datos)) {

            $datos = json_decode($datos, true, 256);
        }

        $this->excel($datos);
    }

    public function inic_recu() {
        $this->load_class("inic_recu", "controller");
        $inic_recu = new Inic_recu_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        if (isset($_POST["token"])) {
            $axn = 'changePass';
        } elseif ($_GET["p1"]) {
            $axn = 'verifyToken';
        }
        switch ($axn) {
            case 'verifyToken':
                $this->data = $inic_recu->verifyToken();
                $this->load_view('inic_recu', $this->data, NULL, FALSE);
                break;
            case 'recoverPass':
                $inic_recu->recoverPass();
                return TRUE;
                break;
            case 'changePass':
                $inic_recu->changePass();
                return TRUE;
                break;
            default:
                if (isset($_SESSION['usuario'])) {
                    header('Location: ' . SYS_URL . SYS_PROJECT . '/inic/inic-dash/inicio/');
                } else {
                    $this->load_view('inic_recu', array(), NULL, FALSE);
                }
                break;
        }
        return true;
    }


    public function inic_clie() {
        $this->load_class("inic_clie", "controller");
        $inic_clie = new Inic_clie_Controller();
        switch ($axn) {
            default:
                if (isset($_SESSION['usuario'])) {
                    header('Location: ' . SYS_URL . SYS_PROJECT . '/inic/inic-dash/inicio/');
                } else {
                    $this->load_view('inic_clie', array(), NULL, FALSE);
                }
                break;
        }
        return true;
    }
    public function inic_busc() {
        $this->load_class("inic_busc", "controller");
        $inic_busc = new Inic_busc_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : '');
        if (isset($_GET['axn']) && $axn === '') {
            $axn = (isset($_GET['axn']) ? $_GET['axn'] : '');
        }
        switch ($axn) {
            default:
                $this->data['datos'] = $inic_busc->buscarModulo();
                $this->load_view('inic_busc', $this->data);
                break;
        }
        return true;
    }

    public function inic_masi() {
        $this->load_class("inic_masi", "controller");
        $inic_masi = new Inic_masi_Controller();
        switch ($axn) {
            default:
                $this->data = $inic_masi->cargarMapa();
                $this->load_view('inic_masi', $this->data);
                break;
        }
        return true;
    }

    public function inic_serv() {
        $this->load_class("inic_serv", "controller");
        $inic_serv = new Inic_serv_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'listarComentarios':
                header('Content-Type: application/json');
                $publicData = $this->getCommentTree(escape($_POST['skIdentificador']));
                echo json_encode([
                    'success' => is_array($publicData),
                    'data' => $publicData
                ]);
                break;
            case 'logout':
                $data = $inic_serv->removeDataUser();
                if ($data) {
                    $result = array('ok' => 1, 'success' => 'true');
                    header('Content-Type: application/json');
                    echo json_encode($result);
                }
                break;
            case 'login':
                $data = $inic_serv->getDataUser();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            default:
                break;
        }
        return true;
    }

    public function inic_slid() {
        $this->load_class("inic_slid", "controller");
        $inic_slid = new Inic_slid_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'contactList':
                $data = $inic_slid->getContactList();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'actionsList':
                $data = $inic_slid->getActionsList();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'sendMessage':
                $data = $inic_slid->sendMessage();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'getMessages':
                $data = $inic_slid->getMessages();
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            case 'count':
                $data = $inic_slid->countMessages();
                if ($data) {
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
                break;
            case 'noti_settings':
                $data = $inic_slid->notiSettings();
                if ($data) {
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
                break;
            case 'notiConfig':
                $data = $inic_slid->notiConfigChange();
                if ($data) {
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
                break;
            default:
                $this->load_view('inic_slid', $this->data, null, false);
                break;
        }
        return true;
    }

    public function xasc_cata() {

        $this->load_class("dlorean_catalogo", "controller");
        $inic_slid = new Dlorean_catalogo_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));

        switch ($axn) {
            case 'uniPEDEEFE':

                /*
                 * Puedes incluir html de vistas externas preprocesadas con php asi :

                ob_start();
                $this->load_view('nomi_format_pdf', ['array' => 'de datinis'], NULL, false);
                $objects = ob_get_contents();
                ob_end_clean();

                 * Ahora  $objects es una cadena de texto con html de la vista y la puedes
                 * incluir en la configuracion de  ~~content~~
                */

                $this->pdf([
                    'waterMark' => [
                        'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
                        'opacity' => .05,
                        'size' => [100, 90]
                    ],
                    'content' => '<b>Uff men este es un PE DE EFE de array UNICO.</b>',
                    'pdf' => [
                        // <-  ->?  ^
                        'contentMargins' => [15, 15, 25, 25],
                        'format' => 'Letter',
                        'footerMargin' => 5,
                        'headerMargin' => 5,
                        'directDownloadFile' => true,
                        'fileName' => 'Le pedeefe unico no multiple.pdf'
                    ]
                ]);

                break;

            case 'multiPEDEEFE':

                $this->pdf([[
                    'waterMark' => [
                        'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
                        'opacity' => .05,
                        'size' => [100, 90]
                    ],
                    'content' => '<b>HABEMUS WEA!.</b>',
                    'pdf' => [
                        // <-  ->?  ^
                        'contentMargins' => [15, 15, 25, 25],
                        'format' => 'Letter',
                        'vertical' => false,
                        'footerMargin' => 5,
                        'headerMargin' => 5,
                        'directDownloadFile' => true,
                        'fileName' => 'LE multipletltltltltlt.pdf'
                    ]
                ],[
                    'content' => '<b>SISISISSIISISISIS BUENO NO....2 </b>',
                    'header' => '<div>Hider personalizado futer default </div>',
                    'defaultHeader' => true,
                    'footer' => false,
                    'pdf' => [

                        'contentMargins' => [15, 15, 25, 25],
                        'format' => 'Letter-L',
                        'vertical' => true,
                        'footerMargin' => 5,
                        'headerMargin' => 5,
                    ]
                ],[
                    'waterMark' => [
                        'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
                        'opacity' => .09,
                        'size' => [100, 90]
                    ],
                    'content' => '<b>HIDER Y FUTER PERSONALIXAO </b>',
                    'header' => '<div>Tu mama</div>',
                    'footer' => '<div>No es tu mama</div>',
                    'defaultFooter' => false ,
                    'defaultHeader' => false ,
                    'pdf' => [
                        // <-  ->?  ^
                        'contentMargins' => [15, 15, 25, 25],
                        'format' => 'Letter',
                        'vertical' => false,
                        'footerMargin' => 5,
                        'headerMargin' => 5
                    ]
                ],[
                    'waterMark' => [
                        'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
                        'opacity' => .09,
                        'size' => [100, 90]
                    ],
                    'content' => '<b>Solo futer perzonalizado 444444   NO 24  <br> El hijo del papá</b>',
                    'footer' => '<div>Ufff men tengo pie de atleta... no de chef.</div>',
                    'defaultFooter' => false,
                    'pdf' => [
                        // <-  ->?  ^
                        'contentMargins' => [15, 15, 25, 25],
                        'format' => 'Letter',
                        'vertical' => false,
                        'footerMargin' => 5,
                        'headerMargin' => 5
                    ]
                ],[

                    'content' => '<b>NO MARCA DE AGUA PERRRAS!</b>',
                    'defaultWatermark' => false,
                    'pdf' => [
                        // <-  ->?  ^
                        'contentMargins' => [15, 15, 25, 25],
                        'format' => 'Letter',
                        'vertical' => true,
                        'footerMargin' => 5,
                        'headerMargin' => 5
                    ]
                ],[

                    'content' => '<b>Con marca que es de agua! No de grasa, no de arena. <br> DE AGUA </b>',
                    'pdf' => [
                        // <-  ->?  ^
                        'contentMargins' => [15, 15, 25, 25],
                        'format' => 'Letter',
                        'vertical' => true,
                        'footerMargin' => 5,
                        'headerMargin' => 5
                    ]
                ] ]);

                break;

            case 'excelExample':
                $this->excel([
                    'fileName' => 'SimonCamion',
                    'format' => 'xlsx',
                    'pages' => [
                        'Hoja Zuculentonga' => [
                            'startAt' => 'A1',
                            'headers' => ['IF', 'NO', [
                                    'value' => 'THEN SI',
                                    'merge' => 2,
                                    'font' => [
                                        'bold' => true,
                                        'italic' => true,
                                        'color' => ['rgb' => '003399']
                                    ]
                                ], 'equis', 'de'],
                            'headersOrientation' => 'H',
                            'data' => [
                                [
                                    'Simon',
                                    'Camion',
                                    [
                                        'value' => 'DIGIMOOOOOON',
                                        'merge' => 2,
                                        'font' => [
                                            'bold' => true,
                                            'italic' => true,
                                            'color' => ['rgb' => '003399']
                                        ],
                                        'fill' => [
                                            'type' => 'solid',
                                            'color' => array('rgb' => 'FF0000')
                                        ]
                                    ],
                                    'Equis de',
                                    'Si'
                                ], ['si', 'si', 'si', 'si', 'Bueno...no']
                            ]
                        ]
                    ]
                ]);

                break;

            case 'longProcesWithStreamingExample':
                streamingStart();
                $datosXD = 'Proceso turbo mega super hiper requete mortalmente largo.';

                foreach (explode(' ', $datosXD) as $word) {
                    streamData($word);
                    sleep(1);
                }

                streamigStop();
                break;

            case 'ChronoShow':

                function turboFuncion_A() {
                    chronStart();
                    sleep(rand(1, 3));
                    chronEnd();
                }

                function turboFuncionNoES_C() {
                    chronStart('SubCosa1');
                    sleep(rand(1, 2));
                    chronEnd('SubCosa1');
                }

                chronStart('General');
                turboFuncion_A();
                turboFuncionNoES_C();
                chronEnd('General');

                echo('<pre>' . print_r(getChronArray(), 1) . '</pre>');

                break;

            default:
                $this->load_view('dlorean_catalogo', $this->data);
                break;
        }
        return true;
    }

}
