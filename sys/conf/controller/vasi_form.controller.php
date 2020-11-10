<?php

Class Vasi_form_Controller Extends Conf_Model
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

    public function accionesVariables(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->variable['skVariableVieja']  = escape($_POST['skVariableVieja']);
            $this->variable['skVariable']       = (isset($_POST['skVariable']) ? escape($_POST['skVariable']) : 'NULL');
            $this->variable['skVariableTipo']   = escape($_POST['skVariableTipo']);
            $this->variable['skEstatus']        = escape($_POST['skEstatus']);
            $this->variable['sNombre']          = escape($_POST['sNombre']);
            $this->variable['sDescripcion']     = escape($_POST['sDescripcion']);
            $this->variable['sValor']           = escape($_POST['sValor']);
            $skVariable = parent::acciones_variables();
                if ($skVariable) {
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

        $this->load_view('vasi_form',$this->data);
        return true;
    }
    public function consultarVariable(){
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['variableTipo'] = parent::consultar_variableTipo();
        if (isset($_GET['p1'])) {
            $this->variable['skVariable'] = $_GET['p1'];
            $this->data['datos'] =  parent::consulta_variable();
            return $this->data;
        }
        return $this->data;
        return false;
    }
    public function validarCodigo(){
            return parent::validar_codigo_variable($_POST['skVariable']);

        return false;
    }

}
