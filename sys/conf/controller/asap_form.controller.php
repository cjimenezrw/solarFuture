<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 02/11/2016
 * Time: 10:02 AM
 */

Class Asap_form_Controller Extends Conf_Model
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

    public function accionesPerfilesAplicaciones(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
                $this->perfil['skPerfil']       = utf8($_POST['skPerfil']);
                $delete = "DELETE core_aplicaciones_perfiles WHERE skPerfil = '".$this->perfil['skPerfil']."'";
                $result = Conn::query($delete);
            if ($result){
                foreach($_POST['skAplicacion'] as $key => $value) {
                            $this->perfil['skPerfil']       = utf8($_POST['skPerfil']);
                            $this->perfil['skAplicacion']   = ($_POST['skAplicacion'][$key] ? $_POST['skAplicacion'][$key] : NULL);
                            $skaplicacion = parent::acciones_perfiles_aplicaciones();
                }

                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            } else {
                //echo "llego aqui";
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
            }
        }

        $this->load_view('asap_form',$this->data);
        return true;
    }
    public function consultarPerfilAplicacion(){
        $this->data['Estatus'] =  parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['aplicaciones'] = parent::consulta_Aplicaciones_perfiles();
        if (isset($_GET['p1'])) {
            $this->perfil['skPerfil'] = $_GET['p1'];
            $this->data['perfilAplicacion'] = parent::consulta_perfil_aplicacion();
            $this->data['datos'] =  parent::consulta_Perfil();

            return $this->data;
        }
        return $this->data;
    }

}
