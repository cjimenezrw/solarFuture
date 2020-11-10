<?php

Class Suem_form_Controller Extends Empr_Model
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

    public function accionesSucursales(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {

            $this->sucursal['skSucursalVieja']  = ($_POST['skSucursalVieja']    ? $_POST['skSucursalVieja']     : NULL);
            $this->sucursal['skSucursal']       = (isset($_POST['skSucursal'])  ? $_POST['skSucursal']          : 'NULL');
            $this->sucursal['skEstatus']        = ($_POST['skEstatus']          ? $_POST['skEstatus']           : 'NULL');
            $this->sucursal['skAduana']         = ($_POST['skAduana']           ? $_POST['skAduana']            : 'NULL');
            $this->sucursal['skEmpresaSocioAgente']         = ($_POST['skEmpresaSocioAgente']           ? $_POST['skEmpresaSocioAgente']            : 'NULL');
            $this->sucursal['sNombre']          = ($_POST['sNombre']            ? $_POST['sNombre']             : 'NULL');
            $this->sucursal['sNombreCorto']     = ($_POST['sNombreCorto']       ? $_POST['sNombreCorto']        : 'NULL');
            $skSucursal = parent::acciones_sucursal();
                if ($skSucursal) {

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

        $this->load_view('suem_form',$this->data);
        return true;
    }
    public function consultarSucursal(){
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['aduanas'] = parent::consultar_aduanas();
        $this->data['agentes'] = parent::consultar_agentes();
        if (isset($_GET['p1'])) {
            $this->sucursal['skSucursal'] = $_GET['p1'];
            $this->data['datos'] =  parent::consulta_sucursal();
            return $this->data;
        }
        return $this->data;
    }
    public function validarCodigo(){

            return parent::validar_codigo($_POST['skSucursal']);

    }

}
