<?php

Class Sevi_form_Controller Extends Conf_Model
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

    public function accionesServidores(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->servidor['skServidorVinculadoViejo']  = escape($_POST['skServidorVinculadoViejo']);
            $this->servidor['skServidorVinculado']       = (isset($_POST['skServidorVinculado']) ? escape($_POST['skServidorVinculado']) : 'NULL');
            $this->servidor['skEstatus']        = escape($_POST['skEstatus']);
            $this->servidor['sNombre']          = escape($_POST['sNombre']);
            $this->servidor['sVinculacion']          = escape($_POST['sVinculacion']);
            $this->servidor['sIP']              = escape($_POST['sIP']);
            $this->servidor['sUsuario']         = escape($_POST['sUsuario']);
            $this->servidor['sPassword']        = escape($_POST['sPassword']);
            $this->servidor['sBDA']             = escape($_POST['sBDA']);
            $this->servidor['sDSN']             = escape($_POST['sDSN']);
            $this->servidor['iPuerto']          = escape($_POST['iPuerto']);
            
            $skServidor = parent::acciones_servidores();
                if ($skServidor) {
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

        $this->load_view('sevi_form',$this->data);
        return true;
    }
    public function consultarServidor(){
        ///$this->data['Estatus'] = parent::consultar_estatus();
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['ServidoresSoportados'] = parent::consultar_servidores_soportados();
        if (isset($_GET['p1'])) {
            $this->servidor['skServidorVinculado'] = $_GET['p1'];
            $this->data['datos'] =  parent::consulta_servidor();
            return $this->data;
        }
        return $this->data;
        return false;
    }
    public function validarCodigo(){
            return parent::validar_codigo_servidor($_POST['skServidorVinculado']);

        return false;
    }

}
