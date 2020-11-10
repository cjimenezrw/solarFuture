<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 16/11/2016
 * Time: 10:42 AM
 */
Class Inic_serv_Controller Extends Inic_Model
{
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct()
    {
        parent::init();
    }

    public function __destruct()
    {

    }

    /**
     * @return array|bool|mixed
     *
     */
    public function getDataUser()
    {
        $sUsuario = (isset($_POST['usuario']) ? $_POST['usuario'] : (isset($_GET['usuario']) ? $_GET['usuario'] : NULL));
        $password = (isset($_POST['password']) ? $_POST['password'] : (isset($_GET['password']) ? $_GET['password'] : NULL));
        $skAplicacion = (isset($_POST['skAplicacion']) ? $_POST['skAplicacion'] : (isset($_GET['skAplicacion']) ? $_GET['skAplicacion'] : NULL));

        $sql = "SELECT TOP 1
                u.skUsuario, u.salt, u.hash1, u.sNombre AS nombreUsuario, u.sApellidoPaterno, u.sApellidoMaterno, u.sUsuario, p.sNombre AS nombrePerfil,
                u.sCorreo AS correo, ut.skToken, es.skEmpresaSocio, es.skEmpresa, es.skEmpresaSocioPropietario, u.sTipoUsuario, p.skPerfil, ce.sNombre AS nombreEmpresa
                FROM core_aplicaciones a
                INNER JOIN core_aplicaciones_perfiles ap ON ap.skAplicacion = a.skAplicacion
                INNER JOIN core_perfiles p ON p.skPerfil = ap.skPerfil
                INNER JOIN rel_usuarios_perfiles up ON up.skPerfil = ap.skPerfil
                INNER JOIN cat_usuarios u ON u.skUsuario = up.skUsuario
                INNER JOIN rel_usuarios_token ut ON ut.skUsuarioPerfil = up.skUsuarioPerfil
                INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = up.skEmpresaSocio
                INNER JOIN cat_empresas ce ON ce.skEmpresa = es.skEmpresa
                WHERE a.skAplicacion = '$skAplicacion' AND a.skEstatus = 'AC' AND ap.skEstatus = 'AC' AND u.skEstatus = 'AC'
                AND (u.sUsuario = '" . $sUsuario . "' OR sCorreo = '" . $sUsuario . "')";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        $jsonData = [];
        $row = Conn::fetch_assoc($result);

        if ($row) {
            utf8($row, false);
            $hash = hash('sha512', $row['salt'] . $password);
            if ($row['hash1'] != $hash) {
                $result = array('ok' => 0, 'success' => 'false');
            } else {

                $this->device['skToken']        = ($row['skToken'] ? $row['skToken'] : 'NULL');
                $this->device['skUsuario']      = ($row['skUsuario'] ? $row['skUsuario'] : 'NULL');
                $this->device['sModelo']        = (isset($_POST['sModelo']) ? $_POST['sModelo'] : 'NULL');
                $this->device['sOperadora']     = (isset($_POST['sOperadora']) ? $_POST['sOperadora'] : 'NULL');
                $this->device['sIdDispositivo'] = (isset($_POST['sIdDispositivo']) ? $_POST['sIdDispositivo'] : 'NULL');
                $this->device['skAplicacion']   = (isset($_POST['skAplicacion']) ? $_POST['skAplicacion'] : 'NULL');
                $this->device['sOsVersion']     = (isset($_POST['sOsVersion']) ? $_POST['sOsVersion'] : 'NULL');
                $this->device['sVersionApp']    = (isset($_POST['sVersionApp']) ? $_POST['sVersionApp'] : 'NULL');
                $this->device['sIdPlayer']      = (isset($_POST['sIdPlayer']) ? $_POST['sIdPlayer'] : 'NULL');
                $this->device['sIdGcm']         = (isset($_POST['sIdGcm']) ? $_POST['sIdGcm'] : 'NULL');

                $perfiles = parent::verificar_perfil_mobile($row['skUsuario'], $skAplicacion);
                $perfil = array();
                if ($perfiles) {
                    //While para pintar los perfiles
                    $i = 0;
                    foreach ($perfiles as $row2) {
                        $perfil[$i] = array(
                            'skToken'        => $row2['skToken'],
                            'sNombre'        => $row2['sNombre'],
                            'bOpciones'          => ($row2['skEmpresaSocio'] == $row2['skEmpresaSocioPropietario'] ? true : false),
                            'sNombreEmpresa' => $row2['Empresa'],
                        );
                        $i++;
                    }
                    //echo json_encode($perfil);
                }

                $sToken = parent::get_tokenDevice();
                $success['ok']                  = '1';
                $jsonData['skUsuario']          = $row['skUsuario'];
                $jsonData['skDispositivoToken'] = $sToken;
                $jsonData['nombreUsuario']      = $row['nombreUsuario'];
                $jsonData['sCorreo']            = $row['correo'];
                $jsonData['sEmpresa']           = $row['nombreEmpresa'];
                $jsonData['perfiles']           = $perfil;

                $result = array_merge($success, $jsonData);

            }


        } else {
            $result = array('ok' => 0, 'success' => 'false');
        }
        return $result;
    }

    public function removeDataUser()
    {

        $this->device['sIdDispositivo']     = (isset($_POST['sIdDispositivo']) ? $_POST['sIdDispositivo'] : (isset($_GET['sIdDispositivo']) ? $_GET['sIdDispositivo'] : NULL));
        $this->device['skDispositivoToken'] = (isset($_POST['skDispositivoToken']) ? $_POST['skDispositivoToken'] : (isset($_GET['skDispositivoToken']) ? $_GET['skDispositivoToken'] : NULL));

        $param = parent::remove_tokenDevice();

        return $param;
    }

}
