<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 21/10/2016
 * Time: 11:59 AM
 */
Class Inic_recu_Controller Extends Inic_Model
{
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    public function recoverPass()
    {
        //$_GET["sysUrl"]
        $data = array();
        $data['email'] = (isset($_POST['email']) ? $_POST['email'] : '');
        $verificar = parent::verificar_correo($data);

        if ($verificar) {

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $sIp = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $sIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $sIp = $_SERVER['REMOTE_ADDR'];
            }

            $this->mail['email'] = ($_POST['email'] ? "'" . $_POST['email'] . "'" : 'NULL');
            $this->mail['sIP'] = ($sIp ? "'" . $sIp . "'" : 'NULL');
            $saveRecu = parent::save_recu();

            if ($saveRecu) {

                $url = SYS_URL . 'sys/inic/inic-recu/recuperar-clave/' .$saveRecu . '/';

               $mailTo = array(

                    'subject' => 'Solicitud de restablecimiento de contraseña',
                    'to' => array($_POST['email']),
                    'msg' => '<br> <b>Ingrese a esta dirección para restablecer su contraseña: </b><br> <a href="'. $url .'" target="_blank">'.$url.'</a> <br><br>
                    Si usted no solicitó el restablecimiento de contraseña, por favor comuniquese al área de sistemas de Woodward Group; Teléfono: (+52) 01 314 3311240',
                    'cc' => array(),
                    'bcc' => array(),
                    'msgPriority' => 1,
                   'NoLog' => true,
                   'send1by1' => true,
                   'files'=> array(),
                   'envioInstantaneo' => true,
                    'senderConf' => array()
                );

                parent::sendMail($mailTo);


                echo 'true';
                return true;
            } else {
                return false;
            }

        } else {
            echo 'false';
            return false;
        }

    }


    public function verifyToken()
    {
        $data = array();
        $data['token'] = $_GET["p1"];
        $verificar = parent::verificar_token($data);

        if ($verificar) {
            $this->data["token"] = $verificar['sToken'];
            $this->data["skUsuario"] = $verificar['skUsuario'];
            $this->data["sUsuario"] = $verificar['sUsuario'];
            return $this->data;
        } else {
            $this->data["token"] = false;
            return $this->data;
        }

    }

    public function changePass()
    {

        $this->data['message'] = NULL;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {

            $this->data2['token'] = ($_POST['token'] ? "'" . $_POST['token'] . "'" : 'NULL');

            if ($_POST['pass'] != '') {

                $dataPass = parent::encriptar($_POST['pass']);

                $this->data2['salt'] = ($dataPass['salt'] ? "'" . $dataPass["salt"] . "'" : 'NULL');
                $this->data2['hash'] = ($dataPass['hash'] ? "'" . $dataPass["hash"] . "'" : 'NULL');
            } else {
                $this->data2['salt'] = 'NULL';
                $this->data2['hash'] = 'NULL';
            }

            $resetpass = parent::change_pass();

            if ($resetpass) {

                $this->data['success'] = true;
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            } else {

                $this->data['success'] = false;
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
            }
        }
        return true;
    }


}
