  <?php

Class Coti_deta_Controller Extends Vent_Model {
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

        $this->conc['skcotizacion'] = $_GET['p1'];
        $this->data['datos'] =  parent::_getCotizacion();
        $this->data['conceptosCotizacion']  = parent::_getCotizacionConceptos();

 
        return $this->data;
    }

}
