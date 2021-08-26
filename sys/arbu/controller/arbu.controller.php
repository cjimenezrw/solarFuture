<?php
Class Arbu_Controller Extends Arbu_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
    
    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function arri_inde() {
        $this->load_class("arri_inde", "controller");
        $arri_inde = new Arri_inde_Controller();
        $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
        switch ($axn) {
            case 'readXLSX':
                header('Content-Type: application/json');
                echo json_encode($arri_inde->readXLSX(),true,512);
                break;
            default:
                /*if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $sIp = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $sIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $sIp = $_SERVER['REMOTE_ADDR'];
                }
                $this->log('ACCESO WEB IP => '.$sIp,TRUE);*/
                $_SESSION['usuario']['skUsuario'] = '4c1ecec7-3714-11eb-b3f3-44a8422a117f';
                $this->log_access();
                $this->load_view('arri_inde',$arri_inde->get_buques_arribos(),NULL,FALSE);
                break;
        }
        return;
    }

}
