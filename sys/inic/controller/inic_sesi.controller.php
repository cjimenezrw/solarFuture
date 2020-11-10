<?php

Class Inic_sesi_Controller Extends Inic_Model
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

    public function verificarSession()
    {
        $data = array();
        $this->data['message'] = '';
        $this->data['response'] = true;
        $this->data['datos'] = false;
        $data['usuario'] = (isset($_POST['usuario']) ? $_POST['usuario'] : '');
        $data['password'] = (isset($_POST['password']) ? $_POST['password'] : '');
        $data['g-recaptcha-response'] = (isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '');
        $datosUsuario = parent::verificar_usuario($data);
        if ($datosUsuario) {
            $skUsuario = $datosUsuario;
            $perfiles = parent::verificar_perfil($skUsuario);
            if ($perfiles) {
                //While para pintar los perfiles
                $perfil = array();
                $i = 0;
                while ($row = Conn::fetch_array($perfiles)) {
                    $perfil[$i] = array(
                        'skEmpresaSocio' => $row['skEmpresaSocio'],
                        'skUsuario' => $row['skUsuario'],
                        'sNombreEmpresa' => $row['Empresa'],
                    );
                    $i++;
                }

                header('Content-Type: application/json');
                echo json_encode($perfil);
                return true;
            } else {
                $this->data['response'] = false;
                $this->data['message'] = 'El usuario no cuenta con perfiles.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;

            }
        } else {
            echo 'false';
            return false;
        }

    }

    public function iniciar_sesion()
    {
        $data = array();
        $data['skUsuario'] = (isset($_POST['skUsuario']) ? $_POST['skUsuario'] : '');
        $data['skEmpresaSocio'] = (isset($_POST['skEmpresaSocio']) ? $_POST['skEmpresaSocio'] : '');
        $data['password'] = (isset($_POST['password']) ? $_POST['password'] : '');
        $data['type'] = (isset($_POST['type']) ? $_POST['type'] : '');
        //Funcion para traer datos del usuario de la session, despues hacer while para meter los datos a la session
        $row = parent::datos_session($data);

        if ($row) {
            //foreach ($datosSessionUsuario as $row) {

                utf8($row);


                $perfiles = parent::obtener_perfiles($row['skUsuario'],$row['skEmpresaSocio']);
                //$this->log($canales, true);
                $perfilesArray = array();
                foreach ( $perfiles as $rowPerfiles) {
                    $perfilesArray[$rowPerfiles['skPerfil']] = $rowPerfiles['skPerfil'];
                }

                // OBTENER CANALES DE GRUPOS DE NOTIFICACIÓN (SISTEMA)
                /*$canales = parent::obtener_canales($row['skUsuario']);
                $canalesArray = array();
                foreach ( $canales as $rowCanales) {
                    $canalesArray[$rowCanales['skGrupoNotificacion']] = $rowCanales['skGrupoNotificacion'];
                }
                // CANAL DEL USUARIO
                $canalesArray[$row['skUsuario']] = $row['skUsuario'];
                */

                if ($row['skGrupo']) {
                    $rfc = parent::obtener_rfcs($row['skGrupo']);
                    $rfcArray = array();
                    foreach ($rfc as $rowRfc) {
                        $rfcArray[$rowRfc['sRFC']] = $rowRfc['sRFC'];
                    }
                } else {
                    $rfc = parent::obtener_rfc($row['skEmpresaSocio']);
                    $rfcArray = array();
                    foreach ($rfc as $rowRfc) {
                        $rfcArray[$rowRfc['sRFC']] = $rowRfc['sRFC'];
                    }
                }



                $_SESSION['usuario'] = array(
                    'skUsuario' => $row['skUsuario'],
                    'sNombreUsuario' => $row['nombreUsuario'],
                    'sUsuario' => $row['sUsuario'],
                    'sEmpresa' => $row['sEmpresa'],
                    'skPuestoGeneral' => $row['PUEGEN'],
                    'skArea' => $row['skArea'],
                    'skDepartamento' => $row['skDepartamento'],
                    'tipoUsuario' => $row['sTipoUsuario'],
                    'correo' => $row['correo'],
                    'skRolDigitalizacion' => $row['skRolDigitalizacion'],
                    'sPaterno' => $row['sApellidoPaterno'],
                    'sMaterno' => $row['sApellidoMaterno'],
                    'skEmpresaSocio' => $row['skEmpresaSocio'],
                    'skEmpresa' => $row['skEmpresa'],
                    'sFoto' => $row['sFoto'],
                    'skEmpresaSocioPropietario' => $row['skEmpresaSocioPropietario'],
                    'perfiles' => $perfilesArray,
                    'CRYKEY' => ($row['CRYKEY'] ? $row['CRYKEY'] : $row['skUsuario']),
                    'rfc' => $rfcArray
                    //'canales' => $canalesArray
                );
                /*$conf = array(
                    'usuario'=>$row['sUsuario'],
                    'fechaCreacion'=>date("d/m/Y H:i:s")
                );*/
                //parent::notify('INICSE', $conf);
        //    }
            if($data['type'] == 'reingresar'){
                $this->data['response'] = true;
                $this->data['message'] = 'Session Iniciada';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            }
            $url = SYS_URL;
            header('Content-Type: application/json');
            echo json_encode($url);
            //$this->log("Epsito", true);
            return true;
        } else {
            $this->data['response'] = false;
            $this->data['message'] = 'Error, la contraseña es incorrecta';
            header('Content-Type: application/json');
            echo json_encode($this->data);
            return false;

        }


    }
}
