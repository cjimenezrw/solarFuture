<?php

/**
 * Controller de módulo de agregado de grupos de usuarios
 *
 * Este es el controlador del módulo de agregado de grupos de usuarios (grus-form)
 *
 * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
 */
Class Meno_form_Controller Extends Conf_Model {

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
     * Módulo para Guardar Notificaciones de Mensajes
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed     Retorna un array del resultado de la operación.
     */
    public function guardar() {

        $this->data['success'] = TRUE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        if ($_POST) {
            $this->notificacionesMensaje['skNotificacionMensaje']       = isset($_POST['skNotificacionMensaje']) ? $_POST['skNotificacionMensaje'] : NULL;
            $this->notificacionesMensaje['skTipoNotificacion']          = isset($_POST['skTipoNotificacion']) ? $_POST['skTipoNotificacion'] : NULL;
            $this->notificacionesMensaje['skComportamientoModulo']            = isset($_POST['skComportamientoModulo']) ? $_POST['skComportamientoModulo'] : NULL;
            $this->notificacionesMensaje['sObligatorio']                = isset($_POST['sObligatorio']) ? $_POST['sObligatorio'] : NULL;
            $this->notificacionesMensaje['skEstatus']                   = isset($_POST['skEstatus']) ? $_POST['skEstatus'] : NULL;
            $this->notificacionesMensaje['sNombre']                     = isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL;
            $this->notificacionesMensaje['sMensaje']                    = isset($_POST['sMensaje']) ? $_POST['sMensaje'] : NULL;
            $this->notificacionesMensaje['sUrl']                        = isset($_POST['sUrl']) ? $_POST['sUrl'] : NULL;
            $this->notificacionesMensaje['sIcono']                      = isset($_POST['sIcono']) ? $_POST['sIcono'] : NULL;
            $this->notificacionesMensaje['sColor']                      = isset($_POST['sColor']) ? $_POST['sColor'] : NULL;
            $this->notificacionesMensaje['sImagen']                     = isset($_POST['sImagen']) ? $_POST['sImagen'] : NULL;
            $this->notificacionesMensaje['sClaveNotificacion']          = isset($_POST['sClaveNotificacion']) ? $_POST['sClaveNotificacion'] : NULL;
            $this->notificacionesMensaje['iNotificacionGeneral']        = isset($_POST['iNotificacionGeneral']) ? $_POST['iNotificacionGeneral'] : NULL;
            $this->notificacionesMensaje['iEnviarCorreo']               = isset($_POST['iEnviarCorreo']) ? $_POST['iEnviarCorreo'] : NULL;
            $this->notificacionesMensaje['sMensajeCorreo']              = isset($_POST['sMensajeCorreo']) ? $_POST['sMensajeCorreo'] : NULL;
            $this->notificacionesMensaje['iNoAlmacenado']               = isset($_POST['iNoAlmacenado']) ? $_POST['iNoAlmacenado'] : NULL;
            $this->notificacionesMensaje['iEnviarInstantaneo']          = isset($_POST['iEnviarInstantaneo']) ? $_POST['iEnviarInstantaneo'] : NULL;

            $skNotificacionMensajeVariable = isset($_POST['skNotificacionMensajeVariable']) ? $_POST['skNotificacionMensajeVariable'] : NULL;
            $this->notificacionesMensaje['iCatalogo'] = 0;

            // VERIFICAMOS SI ES CATALOGO (se determina si trae valores) //
                if($skNotificacionMensajeVariable){
                    $this->notificacionesMensaje['iCatalogo'] = 1;
                }

            Conn::begin('stpCU_notificacionesMensajes');

            $this->notificacionesMensaje['skNotificacionMensaje'] = parent::stpCU_notificacionesMensajes();

            if (!$this->notificacionesMensaje['skNotificacionMensaje']) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_notificacionesMensajes');
                return $this->data;
            }


                    if(isset($_POST['skAplicaciones'])){
                                                    $sql = "DELETE FROM rel_notificacionesMensajes_aplicaciones WHERE skNotificacionMensaje='".$this->notificacionesMensaje['skNotificacionMensaje']."'";
                                                    $result = Conn::query($sql);
                                                    foreach ($_POST['skAplicaciones'] as $key => $value) {
                                                        $this->notificacionesMensaje['skNotificacionMensaje']   = utf8($this->notificacionesMensaje['skNotificacionMensaje']);
                                                        $this->notificacionesMensaje['skAplicacion']   = ($_POST['skAplicaciones'][$key] ? $_POST['skAplicaciones'][$key] : NULL);;
                                                        $svalor = parent::acciones_notificaciones_aplicaciones();
                                                    }
                }


            // GUARDAMOS LOS VALORES DEL PUNTO DE TRACKING DE CATÁLOGO //
                if($skNotificacionMensajeVariable){

                    if(!parent::deleteNotificacionMensajeVariable($skNotificacionMensajeVariable)){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al verificar valores del punto de tracking.';
                        Conn::rollback('stpCUD_trackingPuntos');
                        return $this->data;
                    }

                    foreach($skNotificacionMensajeVariable AS $k=>$v){
                        $this->notificacionesMensaje['skNotificacionMensajeVariable'] = $v;
                        $this->notificacionesMensaje['sValor'] = $_POST['sValor'][$k];
                        $this->notificacionesMensaje['sVariable'] = $_POST['sVariable'][$k];
                        if(!parent::stpC_notificacionesMensajesVariables()){
                            $this->data['success'] = FALSE;
                            break;
                        }
                    }

                    if(!$this->data['success']){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al guardar los valores del punto de tracking.';
                        Conn::rollback('stpCU_notificacionesMensajes');
                        return $this->data;
                    }


                }

            if(!$this->data['success']){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_notificacionesMensajes');
                return $this->data;
            }

            // RETORNAMOS RESPUESTA //
            $this->data['success'] = TRUE;
            $this->data['message'] = 'Registro guardado con &eacute;xito.';
            $this->data['datos'] = $this->notificacionesMensaje['skNotificacionMensaje'];
            Conn::commit('stpCU_notificacionesMensajes');

            return $this->data;
        }

        return FALSE;
    }

    /**
     * consultar
     *
     * Consultar grupo de usuarios por skGrupoUsuario
     *
     * @author Luis Alberto valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed     Retorna un array del resultado de la operación.
     */
    public function consultar() {
        $this->data['estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['comportamientos'] = parent::consultar_comportamientos();
        $this->data['tiposNotificaciones'] = parent::consultar_tiposNotificaciones();
        $this->data['aplicaciones']  = parent::consultar_aplicacion();
        if (isset($_GET['p1'])) {
            $this->notificacionesMensaje['skNotificacionMensaje'] = $_GET['p1'];
            $this->data['datos'] = parent::consultarNotificacionesMensaje();
            $this->data['variablesMensajes'] = parent::variablesMensajes();
            $this->data['aplicacionesMensajes'] = parent::getAplicacionesMensajes();
            return $this->data;
        }
        return $this->data;
    }

    public function validarCodigo() {
        $skNotificacionMensaje = (isset($_POST['p1']) ? $_POST['p1'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        return parent::validar_codigoNotificacionMensaje($_POST['sClaveNotificacion'],$skNotificacionMensaje);

        return false;
    }



}
