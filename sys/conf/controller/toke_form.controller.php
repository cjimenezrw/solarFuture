<?php

Class Toke_form_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    
    /**
    * getUsuario_token
    *
    * Retorna los datos a la vista de los perfiles asignados al usuario con sus respectivas epmpresas y sucursales relacionados con su token de servicios web.
    *
    * @author           Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
    * @param string     $skUsuario Identificador del usuario para consultar sus token de servicios web.
    * @return array     Retorna array de perfiles asignados al usuario con sus respectivas epmpresas y sucursales con su token de servicios web.
    */
    public function consultarUsuarioToken(){
        if (isset($_GET['p1'])) {
            $this->data['usuarios_token'] = parent::getUsuario_token($_GET['p1']);
            return $this->data;
        }
        return $this->data;
        return TRUE;
    }
    
    /**
    * guardar
    * 
    * Acción para la creación del token para servicios web.
    * 
    * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
    * @return mixed Retorna un array del resultado de la operación.
    */
    public function guardar(){
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con &eacute;xito.';
        $this->data['datos'] = TRUE;
        $usuarios_token = isset($_POST['skUsuarioPerfil']) ? $_POST['skUsuarioPerfil'] : NULL;
        if(!is_null($usuarios_token)){
            Conn::begin('stpC_usuarioToken');
            foreach($usuarios_token AS $k=>$v){
                $this->usuarios_token['skUsuarioPerfil'] = $v;
                if(!parent::stpCD_usuarioToken()){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                    break;
                }
            }
            if($this->data['success']){
                Conn::commit('stpC_usuarioToken');
            }else{
                Conn::rollback('stpC_usuarioToken');
            }
        }
        return $this->data;
    }
    
}