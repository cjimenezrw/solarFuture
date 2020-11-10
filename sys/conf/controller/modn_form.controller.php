
<?php

Class Modn_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function guardar() {

        $this->data['success'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;
        
        // RECIBIMOS LOS DATOS DEL FORMULARIO //
            $this->conf['skModuloDetalle'] = (isset($_POST['skModuloDetalle']) ? $_POST['skModuloDetalle'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
            $this->conf['skEstatus'] = 'AC';
            $this->conf['skModulo'] = (isset($_POST['skModulo']) ? $_POST['skModulo'] : NULL);
            $this->conf['skEmpresaSocio'] = (isset($_POST['skEmpresaSocio']) ? $_POST['skEmpresaSocio'] : NULL);
            $this->conf['skUsuarioDeveloper'] = (isset($_POST['skUsuarioDeveloper']) ? $_POST['skUsuarioDeveloper'] : NULL);
            $this->conf['skUsuarioResponsable'] = (isset($_POST['skUsuarioResponsable']) ? $_POST['skUsuarioResponsable'] : NULL);
            $this->conf['sObjetivo'] = (isset($_POST['sObjetivo']) ? $_POST['sObjetivo'] : NULL);
            $this->conf['sRFC'] = (isset($_POST['sRFC']) ? $_POST['sRFC'] : NULL);
            $this->conf['sAduana'] = (isset($_POST['sAduana']) ? $_POST['sAduana'] : NULL);
            $this->conf['sNotas'] = (isset($_POST['sNotas']) ? $_POST['sNotas'] : NULL);
            $this->conf['dFechaImplementacion'] = (isset($_POST['dFechaImplementacion']) ? $_POST['dFechaImplementacion'] : NULL);
            
        Conn::begin('stpCU_modulosNotas');
            
            $stpCU_modulosNotas = parent::stpCU_modulosNotas();
            if(!$stpCU_modulosNotas || isset($stpCU_modulosNotas['success']) && $stpCU_modulosNotas['success'] != 1){
                Conn::rollback('stpCU_modulosNotas');
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar.';
                return $this->data;
            }
                
        Conn::commit('stpCU_modulosNotas');
        $this->data['success'] = true;
        $this->data['message'] = 'Registro guardado con éxito.';
        return $this->data;
    }
    
    public function getModulosNotas(){
        if (isset($_GET['p1'])) {
            $this->traf['skModuloDetalle'] = $_GET['p1'];
            $this->data['datos'] = parent::_getModulosNotas();
        }
        return $this->data;
    }
    
    public function getEmpresas(){
        
    }
    
    public function getUsuarios(){
        
    }

}
