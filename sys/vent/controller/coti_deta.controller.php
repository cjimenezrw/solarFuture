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
        $this->data['BANCOT'] = parent::getVariable('BANCOT');
        $this->data['PIECOT'] = parent::getVariable('PIECOT');
 
        return $this->data;
    }

    public function formatoPDF() {
        
        $this->data = $this->consultar();
        
        ob_start();
            $this->load_view('formato_cotizacion', $this->data, NULL, FALSE);
            $formato_cotizacion = ob_get_contents();
        ob_end_clean();

        ob_start();
            $this->load_view('formato_cotizacion_analisis', $this->data, NULL, FALSE);
            $formato_cotizacion_analisis = ob_get_contents();
        ob_end_clean();

        parent::pdf([
            [
                'content' => $formato_cotizacion,
                'header' => '<div></div>',
                'defaultFooter' => false,
                'footer' => '',
                'pdf' => [
                    'contentMargins' => [10, 15, 5, 5],
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 5,
                    'headerMargin' => 5,
                    'fileName' => 'Cotizacion.pdf'
                ]
            ],
            [
                'content' => $formato_cotizacion_analisis,
                'header' => '<div></div>',
                'defaultFooter' => false,
                'footer' => '',
                'pdf' => [
                    'contentMargins' => [10, 15, 5, 5],
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 5,
                    'headerMargin' => 5
                ]
            ]
        ]);

        return true;
    }

}
