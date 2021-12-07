  <?php

Class Serv_deta_Controller Extends Admi_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultar(){

        $this->admi['skServicio'] = $_GET['p1'];
        $this->data['datos'] =  parent::_getServicio();
        $this->data['serviciosImpuestos']  = parent::_getServicioImpuestos(); 
        
            
        return $this->data;
    }

}
