<?php

Class Tvar_form_Controller Extends Conf_Model
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

    
    /**
     * Acciones de grupos
     * 
     * Esta funcion procesa las acciones CUD de grupos, retornando una respuesta
     * como JSON, que indica a la interfaz si la accion fue exitosa o no
     * 
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function accionesTiposVariables() {
        
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->tipovariable['skVariableTipoViejo'] = (isset($_POST['skVariableTipoViejo']) ? $_POST['skVariableTipoViejo'] : NULL); 
            $this->tipovariable['skVariableTipo'] = (isset($_POST['skVariableTipo']) ? $_POST['skVariableTipo'] : NULL); 
            $this->tipovariable['skEstatus'] = ($_POST['skEstatus'] ? $_POST['skEstatus'] :NULL);
            $this->tipovariable['sNombre'] = ($_POST['sNombre'] ? $_POST['sNombre'] : NULL);
            $skVariableTipo = parent::acciones_tipovariables();
            
            if ($skVariableTipo) {
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

        $this->load_view('tvar_form', $this->data);
        return true;
    }
    
    
    /**
     * Consultar Tipo de variable
     * 
     * Esta funcion retorna los datos de grupos
     * 
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function consultarTipoVariable() {
        $this->data['Estatus'] =  parent::consultar_core_estatus(['AC','IN'],true);
        if (isset($_GET['p1'])) {
            $this->tipovariable['skVariableTipo'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_tipovariable();
            return $this->data;
        }
        return $this->data;
        return false;
    }
    
    public function validarCodigoTipoVariable(){

            return parent::validar_codigoTipoVariable($_POST['skVariableTipo']);

    }

}
