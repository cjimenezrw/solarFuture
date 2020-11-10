<?php

Class Perf_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function accionesPerfiles() {
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $pset = array_merge(json_decode($_POST['web_pstore'], true),json_decode($_POST['mob_pstore'], true)) ;
            $this->perfil['skPerfil'] = ($_POST['skPerfil'] ? "'" . $_POST['skPerfil'] . "'" : 'NULL');
            $this->perfil['skEstatus'] = ($_POST['skEstatus'] ? "'" . $_POST['skEstatus'] . "'" : 'NULL');
            $this->perfil['sNombre'] = ($_POST['sNombre'] ? "'" . utf8_decode($_POST['sNombre']) . "'" : 'NULL');
            $this->perfil['sDescripcionPerfil'] = (isset($_POST['sDescripcionPerfil']) ? $_POST['sDescripcionPerfil'] : NULL);

            $skPerfil = parent::acciones_perfiles();

            if ($skPerfil) {

                foreach ($pset as $skm => $ward) {

                    if($ward['W']){
                        parent::crear_permisos("('$skPerfil'," . "'W'" . ",'$skm')");
                    }

                    if($ward['A']){
                        parent::crear_permisos("('$skPerfil'," . "'A'" . ",'$skm')");
                    }

                    if($ward['R']){
                        parent::crear_permisos("('$skPerfil'," . "'R'" . ",'$skm')");
                    }

                    if($ward['D']){
                        parent::crear_permisos("('$skPerfil'," . "'D'" . ",'$skm')");
                    }
                    //parent::crear_permisos("('$skPerfil'," . (($ward['W']) ? "'W'" : 'NULL') . ",'$skm')");
                }

                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
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

    public function consultarPerfil() {
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['Perfiles'] = parent::consultar_perfiles();


        if (isset($_GET['p1'])) {
            $this->perfil['skPerfil'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_Perfil();
            $this->data['modulos'] = parent::consulta_modulos();
            $this->data['modulosMobile'] = parent::consulta_modulos_mobile();
            $this->data['modulosMobile_json'] = json_encode(parent::consulta_modulos_mobile_json());
            $this->data['modulos_json'] = json_encode(parent::consulta_modulos_assoc(), 512);

            return $this->data;
        } else {
            $this->data['modulos'] = parent::consulta_modulos();
            $this->data['modulosMobile'] = parent::consulta_modulos_mobile();
            $this->data['modulosMobile_json'] = json_encode(parent::consulta_modulos_mobile_json());
            $this->data['modulos_json'] = json_encode(parent::consulta_modulos_assoc(), 512);
            return $this->data;
        }
        return false;
    }

    public function consultar_perfil_clonado($skPerfilClonar) {
        $result = parent::consultarPerfilClonado($skPerfilClonar);
        if (!$result) {
            return false;
        }
        $data = array();
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);
            array_push($data, $row);
        }
        return $data;
    }

}
