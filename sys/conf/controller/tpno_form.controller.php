<?php

Class Tpno_form_Controller Extends Conf_Model
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

    public function accionesTipoNotificacion(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->tipoNotificacion['skTipoNotificacionVieja']  = escape($_POST['skTipoNotificacionVieja']);
            $this->tipoNotificacion['skTipoNotificacion']       = (isset($_POST['skTipoNotificacion']) ? escape($_POST['skTipoNotificacion']) : 'NULL');
            $this->tipoNotificacion['skEstatus']        = escape($_POST['skEstatus']);
            $this->tipoNotificacion['sNombre']          = escape($_POST['sNombre']);
            $this->tipoNotificacion['sDescripcion']     = escape($_POST['sDescripcion']);
            $skTipoNotificacion = parent::acciones_tipoNotificacion();
                if ($skTipoNotificacion) {
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

        $this->load_view('tpno_form',$this->data);
        return true;
    }
    public function consultarTipoNotificacion(){
        $this->data['Estatus'] = parent::consultar_core_estatus(['IN','EL','AC'],true);
        if (isset($_GET['p1'])) {
            $this->tipoNotificacion['skTipoNotificacion'] = $_GET['p1'];
            $this->data['datos'] =  parent::consulta_tipoNotificacion();
            return $this->data;
        }
        return $this->data;
    }
    public function validarCodigo(){
            return parent::validar_codigo_tipoNotificacion($_POST['skTipoNotificacion']);
    }

}
