<?php

/**
 * Grup form controller
 * Controlador de la vista grup_form
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
Class Grup_form_Controller Extends Empr_Model {

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
     * Acciones de grupos
     * 
     * Esta funcion procesa las acciones CUD de grupos, retornando una respuesta
     * como JSON, que indica a la interfaz si la accion fue exitosa o no
     * 
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function accionesGrupos() {
        
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        
        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->grupo['skGrupo'] = (isset($_POST['skGrupo']) ? $_POST['skGrupo'] : NULL); 
            $this->grupo['skEstatus'] = ($_POST['skEstatus'] ? $_POST['skEstatus'] :NULL);
            $this->grupo['sNombre'] = ($_POST['sNombre'] ? $_POST['sNombre'] : NULL);
            
            if(isset($_POST['skEmpresaSocio'])){
                $this->grupo['skEmpresaSocio'] = array_filter($_POST['skEmpresaSocio']);

            }
            $skSucursal = parent::acciones_grupo();
            
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
        $this->load_view('grup_form', $this->data);
        return true;
    }
    
    
    /**
     * Consultar grupo
     * 
     * Esta funcion retorna los datos de grupos
     * 
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function consultarGrupo() {
        $this->data['Estatus'] = parent::consultar_estatus();
        if (isset($_GET['p1'])) {
            $this->grupo['skGrupo'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_grupo();
            $this->data['grupo_empresas'] = parent::consultar_empresasGrupo();
            return $this->data;
        }
        return $this->data;
        return false;
    }
    
}