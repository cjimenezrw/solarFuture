<?php

Class Soem_form_Controller Extends Empr_Model
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

    public function accionesSolicitudesEmpresas(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            
            $su = &$_SESSION['usuario'];
            
            $this->solEm['skEmpresaPropietario']     = escape($_SESSION['usuario']['skEmpresaSocioPropietario']);
            $this->solEm['skSolicitudEmpresa']       = escape(( isset($_POST['skSolicitudEmpresa']) )    ? $_POST['skSolicitudEmpresa'] : NULL);
            $this->solEm['skEmpresaTipo']            = escape(( isset($_POST['skEmpresaTipo']) )         ? $_POST['skEmpresaTipo'] : NULL);
            $this->solEm['skEmpresa']                = escape(( isset($_POST['skEmpresa']) )             ? $_POST['skEmpresa'] : NULL);
            $this->solEm['sRazonSocial']             = escape(( isset($_POST['sRazonSocial']) )          ? $_POST['sRazonSocial'] : NULL);
            $this->solEm['sAlias']                   = escape(( isset($_POST['sAlias']) )                ? $_POST['sAlias'] : NULL);
            $this->solEm['sRFC']                     = escape(( isset($_POST['sRFC']) )                  ? $_POST['sRFC'] : NULL);
            $this->solEm['skUsuarioCreacion']        = escape($su['skUsuario']);
            $this->solEm['skModulo']                 = escape($this->sysController);
            $skSolicitudEmpresa = parent::acciones_solicitudEmpresa();
                if ($skSolicitudEmpresa) {
                    
                    parent::notify('NUSOEM', [
                        'skSolicitudEmpresa' => $skSolicitudEmpresa, 
                        'sNombre' => "$su[sNombreUsuario] $su[sPaterno] $su[sMaterno]"
                    ]);
                    
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
    public function consultarSolicitudEmpresa(){
        $this->data['empresasTipos'] = parent::getEmpresasTipos();
        if (isset($_GET['p1'])) {
            $this->data['datos'] =  parent::consultar_solicitudEmpresa(escape($_GET['p1']));
            
        }
        return $this->data;
    }
}
