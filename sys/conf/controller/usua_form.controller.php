<?php

Class Usua_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function accionesUsuarios() {
        //exit('<pre>'.print_r($_POST,1).'</pre>');
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con &eacute;xito.';
        $this->data['response'] = FALSE;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {


            $namePic = (isset($_POST['sUsuario']) ? $_POST['sUsuario'] : $_POST["sUsuarioViejo"]);
            $pathNameFile = CORE_PATH.'assets/profiles/'. $namePic . '*.*';

            if (file_exists($_FILES['avatar']['tmp_name']) || is_uploaded_file($_FILES['avatar']['tmp_name'])) {

                if ($_FILES["avatar"]["name"] != "") {
                    $target_dir = CORE_PATH.'assets/profiles/';
                    $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
                    $newfilename = $namePic . '.' . $ext;

                    array_map('unlink', glob($pathNameFile));

                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir . $newfilename)) {
                        $avatar = $newfilename;
                    }
                }
            } else if ($_POST['picDel'] == 'true') {
                array_map('unlink', glob($pathNameFile));
            }

            $this->usuario['skUsuario'] = ($_POST['skUsuario'] ?  $_POST['skUsuario']  : NULL);
            $this->usuario['sUsuario'] = (isset($_POST['sUsuario']) ?  $_POST['sUsuario'] : NULL);
            $this->usuario['skEstatus'] = ($_POST['skEstatus'] ? $_POST['skEstatus']  : NULL);

            $this->usuario['skArea'] = ($_POST['skArea'] ?  $_POST['skArea'] : NULL);
            $this->usuario['skDepartamento'] = (isset($_POST['skDepartamento']) ?  $_POST['skDepartamento']  : NULL);
            $this->usuario['skGrupo'] = ($_POST['skGrupo'] ?  $_POST['skGrupo']  : NULL);

            $this->usuario['sNombre'] = ($_POST['sNombre'] ? $_POST['sNombre'] : NULL);
            $this->usuario['sApellidoPaterno'] = ($_POST['sApellidoPaterno'] ? $_POST['sApellidoPaterno'] : NULL);
            $this->usuario['sApellidoMaterno'] = ($_POST['sApellidoMaterno'] ? $_POST['sApellidoMaterno'] : NULL);
            $this->usuario['sCorreo'] = ($_POST['sCorreo'] ? $_POST['sCorreo'] : NULL);
            $this->usuario['sTipoUsuario'] = (isset($_POST['sTipoUsuario']) ? $_POST['sTipoUsuario'] : NULL);
            $this->usuario['sFoto'] = (isset($avatar) ?  $avatar  : NULL);
            $this->usuario['picDel'] = (isset($_POST['picDel']) ? $_POST['picDel'] : NULL);
            $this->usuario['skRolDigitalizacion'] = (isset($_POST['skRolDigitalizacion']) ? $_POST['skRolDigitalizacion'] : NULL);

            if ($_POST['sPassword'] != '') {

                $dataPass = parent::encriptar($_POST['sPassword']);

                $this->usuario['salt'] = ($dataPass['salt'] ? $dataPass["salt"] : NULL);
                $this->usuario['hash'] = ($dataPass['hash'] ? $dataPass["hash"] : NULL);
            } else {
                $this->usuario['salt'] = NULL;
                $this->usuario['hash'] = NULL;
            }

            $skUsuario = parent::acciones_usuarios();
            if ($skUsuario) {
                $arrayPerfiles = array();
                //print_r($_POST);
                if (isset($_POST['skUsuarioPerfil'])) {
                    foreach ($_POST['skUsuarioPerfil'] as $key => $value) {
                        // el key traer el numero del array
                        $this->usuario['skUsuario'] = utf8($skUsuario);
                        $this->usuario['skUsuarioPerfil'] = ($_POST['skUsuarioPerfil'][$key] ? $_POST['skUsuarioPerfil'][$key] : NULL);
                        $this->usuario['skEmpresaSocio'] = ($_POST['skEmpresaSocio'][$key] ? $_POST['skEmpresaSocio'][$key] : NULL);
                        $this->usuario['skPerfil'] = ($_POST['skPerfil'][$key] ? $_POST['skPerfil'][$key] : NULL);

                        $skUsuarioPerfil = parent::acciones_usuarios_perfiles();
                        if ($skUsuarioPerfil) {
                            //SE INSERTAN Los skUsuarioPerfil en array para no eliminar
                            array_push($arrayPerfiles, $skUsuarioPerfil);
                        }
                    }
                }
                // ELIMINADO DE skUsuarioPerfil que no esten en $arrayPerfiles
                $arrayNoEliminar = '';
                foreach ($arrayPerfiles as $clave => $valor) {
                    $arrayNoEliminar.= ($arrayNoEliminar ? ",'" . $valor . "'" : "'" . $valor . "'");
                }
                $this->usuario['skUsuario'] = utf8($skUsuario);
                $eliminadoPerfiles = parent::eliminar_usuarios_perfiles($arrayNoEliminar);

                // GUARDAMOS LAS CARACTERÍSTICAS DE LOS USUARIOS //
                $skCaracteristicaUsuario = isset($_POST['skCaracteristicaUsuario']) ? $_POST['skCaracteristicaUsuario'] : NULL;
                if ($skCaracteristicaUsuario) {
                    $this->usuario['skUsuario'] = $skUsuario;
                    // Eliminamos las características ANTERIORES //
                    if (!parent::stpCD_caracteristica_usuario(TRUE)) {
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                    }
                    // Insertamos las características NUEVAS //
                    foreach ($skCaracteristicaUsuario AS $k => &$v) {
                        if(!empty($v)){
                            $this->usuario['skCaracteristicaUsuario'] = $k;
                            $this->usuario['sValor'] = $v;
                            if (!parent::stpCD_caracteristica_usuario()) {
                                $this->data['success'] = FALSE;
                                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                                break;
                            }
                        }
                    }
                }

                if(!$this->data['success']){
                    header('Content-Type: application/json');
                    echo json_encode($this->data);
                    return false;
                }


                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            } else {
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
            }
        }
        $this->load_view('suem_form', $this->data);
        return true;
    }

    public function consultarUsuario() {
        $this->data['Area'] = parent::consultar_area();
        $this->data['Grupo'] = parent::consultar_grupos();
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'], true);
        if (isset($_GET['p1'])) {
            $this->usuario['skUsuario'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_usuario();
            $this->data['Departamento'] = parent::getArea_Departamento($this->data['datos']['skArea']);
            $this->data['usuario_perfiles'] = $this->consultarUsuarioPerfiles();
            return $this->data;
        }
        return $this->data;

    }

    public function consultarUsuarioPerfiles() {
        $usuario_perfiles = parent::usuario_perfiles();
        $records = array();
        if ($usuario_perfiles) {
            foreach ($usuario_perfiles as $k => $v) {
                $data = array(
                    'id' => $v['skUsuarioPerfil'],
                    'empresa' => $v['empresa'],
                    'perfil' => $v['perfil']
                );

                $input = '<input type="text" name="skUsuarioPerfil[]" value="' . $v['skUsuarioPerfil'] . '" hidden />';
                $input .= '<input data-name="' . $v['empresa'] . '" type="text" name="skEmpresaSocio[]" value="' . $v['skEmpresaSocio'] . '" hidden />';
                $input .= '<input data-name="' . $v['perfil'] . '" type="text" name="skPerfil[]" value="' . $v['skPerfil'] . '" hidden />';
                $data["empresa"] = $data["empresa"] . $input;
                array_push($records, $data);
            }
        }

        return json_encode($records);
    }

    public function validarUsuario() {
        return parent::validar_usuario($_POST['sUsuario']);
    }

    public function rel_area_departamento(&$skArea){
        $result = parent::getArea_Departamento($skArea);
        if(!$result){
            return false;
        }
        $data = array();
        foreach ( $result as $row){
            array_push($data,$row);
        }
        return $data;
    }

    public function getCaracteristicaCatalogo(&$sCatalogo, &$sCatalogoKey, &$sCatalogoNombre) {
        $result = parent::getCaracteristica_valoresCatalogo($sCatalogo, $sCatalogoKey, $sCatalogoNombre);
        if (!$result) {
            return array();
        }
        $data = array();
        foreach ( $result as $row){
            utf8($row, FALSE);
            array_push($data, array(
                'id' => $row[$sCatalogoKey],
                'nombre' => $row[$sCatalogoNombre]
            ));
        }
        return $data;
    }

}
