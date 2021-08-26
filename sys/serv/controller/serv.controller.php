<?php
Class Serv_Controller Extends Serv_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
    
    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function serv_arri() {
        $this->load_class("serv_arri", "controller");
        $serv_arri = new Serv_arri_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
         switch ($axn) {
            case 'consultarBuques':
                header('Content-Type: application/json');
                echo json_encode($serv_arri->consultarBuques());
            break;
            case 'consultarArribos':
                header('Content-Type: application/json');
                echo json_encode($serv_arri->consultarArribos());
            break;
            default:
                /*
                require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'header.php');
                require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'breadCrumbs.php');
                require_once(SYS_PATH . $this->sysModule . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'arri_inde.php');
                require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'footer.php');
                require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'analyticstracking.php');
                */
                $this->load_view('serv_arri',[],NULL,FALSE);
                break;
        }
        return;
    }

    public function arri_inde() {
        $this->load_class("arri_inde", "controller");
        $arri_inde = new Arri_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            default:
                $this->load_view('arri_inde',[],NULL,FALSE);
                break;
        }
        return TRUE;
    }

}
