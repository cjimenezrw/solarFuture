<?php

/**
 * Controller de módulo de agregado de grupos de Notificaciones
 *
 * Este es el controlador del módulo de agregado de grupos de Notificaciones (grno-form)
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
 */
Class Grno_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    /**
     * Guardar
     *
     * Módulo para Guardar grupos de usuarios
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed     Retorna un array del resultado de la operación.
     */
    public function guardar() {

        $this->data['success'] = TRUE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        if ($_POST) {
            $this->gruposNotificaciones['skGrupoNotificacion'] = isset($_POST['skGrupoNotificacion']) ? $_POST['skGrupoNotificacion'] : NULL;
            $this->gruposNotificaciones['skEstatus'] = isset($_POST['skEstatus']) ? $_POST['skEstatus'] : NULL;
            $this->gruposNotificaciones['sNombre'] = isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL;
            $this->gruposNotificaciones['sDescripcion'] = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : NULL;
            $skUsuario = isset($_POST['skUsuario']) ? $_POST['skUsuario'] : NULL;
            $skNotificacionMensaje = isset($_POST['skNotificacionMensaje']) ? $_POST['skNotificacionMensaje'] : NULL;

            Conn::begin('stpCU_gruposNotificaciones');

            $this->gruposNotificaciones['skGrupoNotificacion'] = parent::stpCU_gruposNotificaciones();

            if (!$this->gruposNotificaciones['skGrupoNotificacion']) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_gruposNotificaciones');
                return $this->data;
            }

            if (!parent::delete_gruposNotificaciones_usuarios()) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_gruposNotificaciones');
                return $this->data;
            }

            if($skUsuario){
                $i = 0;
                foreach ($skUsuario AS $k => $v) {
                    $this->gruposNotificaciones['skUsuario'] = $v;
                    if (!parent::stpC_gruposNotificaciones_usuarios()) {
                        $this->data['success'] = FALSE;
                        break;
                    }
                    $i++;
                }
            }



            if (!parent::delete_gruposNotificaciones_mensajes()) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_gruposNotificaciones');
                return $this->data;
            }

            if($skNotificacionMensaje){
                $i = 0;
                foreach ($skNotificacionMensaje AS $k => $v) {
                    $this->gruposNotificaciones['skNotificacionMensaje'] = $v;
                    if (!parent::stpC_gruposNotificaciones_mensajes()) {
                        $this->data['success'] = FALSE;
                        break;
                    }
                    $i++;
                }
            }

            if(!$this->data['success']){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_gruposNotificaciones');
                return $this->data;
            }

            // RETORNAMOS RESPUESTA //
            $this->data['success'] = TRUE;
            $this->data['message'] = 'Registro guardado con &eacute;xito.';
            $this->data['datos'] = $this->gruposNotificaciones['skGrupoNotificacion'];
            Conn::commit('stpCU_gruposNotificaciones');

            return $this->data;
        }

        return FALSE;
    }

    /**
     * consultar
     *
     * Consultar grupo de Notificaciones por skGrupoNotificacion
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed     Retorna un array del resultado de la operación.
     */
    public function consultar() {
        $this->data['estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        if (isset($_GET['p1'])) {
            $this->gruposNotificaciones['skGrupoNotificacion'] = $_GET['p1'];
            $this->data['datos'] = parent::consultarGruposNotificaciones();
            $this->data['gruposNotificaciones_usuarios'] = $this->gruposNotificaciones_usuarios();
            $this->data['gruposNotificaciones_mensajes'] = $this->gruposNotificaciones_mensajes();
            return $this->data;
        }
        return $this->data;
    }

    public function gruposNotificaciones_usuarios(){
        $gruposNotificaciones_usuarios = parent::consultarGruposNotificaciones_usuarios();

        if(!$gruposNotificaciones_usuarios){
            return FALSE;
        }

        $records = array();
        while($row = Conn::fetch_assoc($gruposNotificaciones_usuarios)){
            utf8($row);
            $data = array(
                'id'=>$row['skUsuario'],
                'usuario'=>$row['usuario']
            );
            $input = '<input data-name="'.$row['usuario'].'" type="text" name="skUsuario[]" value="'.$row['skUsuario'].'" hidden />';
            $data['usuario'] = $data["usuario"] . $input;
            array_push($records,$data);
        }

        return json_encode($records);
    }

    public function gruposNotificaciones_mensajes(){
        $gruposNotificaciones_mensajes = parent::consultarGruposNotificaciones_mensajes();

        if(!$gruposNotificaciones_mensajes){
            return FALSE;
        }

        $records = array();
        while($row = Conn::fetch_assoc($gruposNotificaciones_mensajes)){
            utf8($row);
            $data = array(
                'id'=>$row['skNotificacionMensaje'],
                'mensaje'=>$row['mensaje']
            );
            $input = '<input data-name="'.$row['mensaje'].'" type="text" name="skNotificacionMensaje[]" value="'.$row['skNotificacionMensaje'].'" hidden />';
            $data['mensaje'] = $data["mensaje"] . $input;
            array_push($records,$data);
        }

        return json_encode($records);
    }

}
