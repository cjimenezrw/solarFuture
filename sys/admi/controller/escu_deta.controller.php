  <?php

Class Escu_deta_Controller Extends Admi_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = [];

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultar(){
        $this->cfdi['skEmpresaSocio'] = isset($_GET['p1']) ? $_GET['p1'] : NULL;
        $this->data['datos'] = parent::getEmpresasSocios();
	    
        $this->data['facturasPendientes'] = parent::getFacturasEmpresaSocio('PE');
        $this->data['facturasPagadas'] = parent::getFacturasEmpresaSocio('PA');
        $this->data['facturasCanceladas'] = parent::getFacturasEmpresaSocio('CA');
        return $this->data;
    }

}
