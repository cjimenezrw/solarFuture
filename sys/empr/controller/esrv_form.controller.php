<?php

Class Esrv_form_Controller Extends Empr_Model
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

    public function accionesServicios(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
           
            
            $this->servem['skServicio']  = escape(( isset($_GET['p1']) ) ? $_GET['p1'] : NULL);
            $this->servem['skEmpresaTipo']       = escape(( isset($_POST['skEmpresaTipo']) )      ? $_POST['skEmpresaTipo'] : NULL);
            $this->servem['sDescripcion']        = escape(( isset($_POST['sDescripcion']) )       ? $_POST['sDescripcion'] : NULL);
            $this->servem['sNombre']             = escape(( isset($_POST['sNombre']) )            ? $_POST['sNombre'] : NULL);
            $this->servem['skEmpresaTipo']       = ( isset($_POST['skEmpresaTipo']) )            ? $_POST['skEmpresaTipo'] : FALSE;
            $this->servem['skUsuarioCreacion']   = escape($_SESSION['usuario']['skUsuario']);
            $this->servem['skModulo']            = escape($this->sysController);
            
            
            $skServicio = parent::acciones_servicios();
            
            
            if (strlen($skServicio) === 36) {

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

        $this->load_view('suem_form',$this->data);
        return true;
        
    }
    public function consultarServicio(){
        $this->data['empresasTipos'] = parent::getEmpresasTipos();
        if (isset($_GET['p1'])) {
            $this->data['datos'] =  parent::consultar_servicio(escape($_GET['p1']));
            $this->data['empresasTiposServicios'] =  parent::consultar_servicioTipoEmpresa(escape($_GET['p1']));
        }
        return $this->data;
    }
    
    
}
