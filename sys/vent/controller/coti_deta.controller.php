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

        $this->vent['skCotizacion'] = $_GET['p1'];
        $this->data['datos'] =  parent::_getCotizacion();
        $this->data['conceptosCotizacion']  = parent::_getCotizacionConceptos();
        $this->data['cotizacionCorreos']  = parent::_getCotizacionCorreos();
        $this->data['cotizacionInformacionProducto'] = parent::_getCotizacionInformacionProducto();
        $this->data['cotizacionTerminosCondiciones'] = parent::_getCotizacionTerminosCondiciones();



 
        return $this->data;
    }

    public function formatoPDF() {
        //$data = [];
        $this->data = $this->consultar();
        
        
        ob_start();
        $this->load_view('formato_cotizacion', $this->data, NULL, FALSE);
        $content = ob_get_contents();
        ob_end_clean();
    
        parent::pdf([
            'content' => $content,
            'header' => '<div></div>',
            'defaultFooter' => false,
            'footer' => '',
            'pdf' => array(
            'contentMargins' => [10, 15, 5, 5],
            'format' => 'LETTER',
            'vertical' => 'L',
            'footerMargin' => 5,
            'headerMargin' => 5,
            'fileName' => 'Cotizacion.pdf'
            )
        ]);
        return true;
        }

}
