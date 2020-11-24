  <?php

Class Conc_deta_Controller Extends Conc_Model {
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

        $this->conc['skConcepto'] = $_GET['p1'];
        $this->data['datos'] =  parent::_getConcepto();
        $this->data['conceptosImpuestos']  = parent::_getConceptoImpuestos();

 
        return $this->data;
    }

}
