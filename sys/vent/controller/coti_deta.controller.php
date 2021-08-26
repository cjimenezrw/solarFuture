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
        $this->data['conceptosCotizacionInventario'] = parent::_getCotizacionConceptos_inventario();
        $this->data['cotizacionCorreos']  = parent::_getCotizacionCorreos();
        $this->data['cotizacionInformacionProducto'] = parent::_getCotizacionInformacionProducto();
        $this->data['cotizacionTerminosCondiciones'] = parent::_getCotizacionTerminosCondiciones();
        $this->data['BANCOT'] = parent::getVariable('BANCOT');
        $this->data['PIECOT'] = parent::getVariable('PIECOT');
        $this->data['TARIFA'] = json_decode(parent::getVariable('TARIFA'),true,512);
 
        return $this->data;
    }

    public function formatoPDF() {
        
        $this->data = $this->consultar();

        ob_start();
            $this->load_view('formato_cotizacion', $this->data, NULL, FALSE);
            $formato_cotizacion = ob_get_contents();
        ob_end_clean();

        $pdf_cotizacion_analisis = [];
        if(!empty($this->data['datos']['iInformacionPanel'])){
            ob_start();
            $this->load_view('formato_cotizacion_analisis', $this->data, NULL, FALSE);
            $formato_cotizacion_analisis = ob_get_contents();
            ob_end_clean();
            $pdf_cotizacion_analisis = [
                'content' => $formato_cotizacion_analisis,
                'defaultWatermark' => false,
                'header' => '<div></div>',
                'footer' => '<div></div>',
                'defaultFooter' => false,
                'defaultHeader' => false,
                'pdf' => [
                    'contentMargins' => [10, 15, 5, 5],
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 5,
                    'headerMargin' => 5
                ]
            ];
        }

        parent::pdf([
            [
                'content' => $formato_cotizacion,
                'defaultWatermark' => false,
                'header' => '<div></div>',
                'footer' => '<div></div>',
                'defaultFooter' => false,
                'defaultHeader' => false,
                'pdf' => [
                    'contentMargins' => [10, 15, 5, 5],
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 5,
                    'headerMargin' => 5,
                    'fileName' => 'Cotización '.$this->data['datos']['iFolio'].'.pdf',
                    'directDownloadFile' => (isset($_GET['directDownloadFile']) && $_GET['directDownloadFile'] == true ? true : false)
                ]
            ],$pdf_cotizacion_analisis
            
        ]);

        return true;
    }

    public function formatoVentaPDF() {
        
        $this->data = $this->consultar();
        
        ob_start();
            $this->load_view('formato_venta', $this->data, NULL, FALSE);
            $formato_cotizacion = ob_get_contents();
        ob_end_clean();

        parent::pdf([
            [
                'content' => $formato_cotizacion,
                'defaultWatermark' => false,
                'header' => '<div></div>',
                'footer' => '<div></div>',
                'defaultFooter' => false,
                'defaultHeader' => false,
                'pdf' => [
                    'contentMargins' => [10, 15, 5, 5],
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 5,
                    'headerMargin' => 5,
                    'fileName' => 'Venta '.$this->data['datos']['iFolio'].'.pdf',
                    'directDownloadFile' => (isset($_GET['directDownloadFile']) && $_GET['directDownloadFile'] == true ? true : false)
                ]
            ]
        ]);

        return true;
    }

}
