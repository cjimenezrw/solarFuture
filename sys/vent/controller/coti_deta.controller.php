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
        $this->data['serviciosCotizacion']  = parent::_getCotizacionservicios();
        $this->data['serviciosCotizacionInventario'] = parent::_getCotizacionservicios_inventario();
        $this->data['cotizacionCorreos']  = parent::_getCotizacionCorreos();
        $this->data['cotizacionInformacionProducto'] = parent::_getCotizacionInformacionProductoPDF();
        $this->data['cotizacionTerminosCondiciones'] = parent::_getCotizacionTerminosCondiciones();
        $this->data['BANCOT'] = parent::getVariable('BANCOT');
        $this->data['PIECOT'] = parent::getVariable('PIECOT');
        $this->data['TARIFA'] = json_decode(parent::getVariable('TARIFA'),true,512);

        $get_documentos = $this->sysAPI('docu', 'docu_serv', 'get_documentos', [
            'POST'=>[
                'skTipoExpediente'=>'OPERAT',
                'skTipoDocumento'=>'FOTOGR',
                'skCodigo'=>$this->vent['skCotizacion']
            ]
        ]);

        $this->data['fotografiasEntrega'] = (isset($get_documentos['data']) && !empty($get_documentos['data']) ? $get_documentos['data'] : []);
        
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

        $serviciosInventario = [];
        foreach($this->data['serviciosCotizacionInventario'] AS $row){
            if(!isset($serviciosInventario[$row['sCodigo']])){
                $serviciosInventario[$row['sCodigo']] = [
                    'sCodigo'=>$row['sCodigo'],
                    'servicio'=>$row['servicio'],
                    'sDescripcion'=>$row['sDescripcion'],
                    'sNumeroSerie'=>[]
                ];
            }
            array_push($serviciosInventario[$row['sCodigo']]['sNumeroSerie'],$row['sNumeroSerie']);
        }

        $this->data['serviciosCotizacionInventario'] = $serviciosInventario;
        
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
    

    public function formatoEntregaPDF() {
        
        $this->data = $this->consultar();
 
        //exit("<pre>".print_r($this->data,1)."</pre>");
        
        $serviciosInventario = [];
        foreach($this->data['serviciosCotizacionInventario'] AS $row){
            if(!isset($serviciosInventario[$row['sCodigo']])){
                $serviciosInventario[$row['sCodigo']] = [
                    'sCodigo'=>$row['sCodigo'],
                    'servicio'=>$row['servicio'],
                    'sDescripcion'=>$row['sDescripcion'],
                    'sNumeroSerie'=>[]
                ];
            }
            array_push($serviciosInventario[$row['sCodigo']]['sNumeroSerie'],$row['sNumeroSerie']);
        }

        $this->data['serviciosCotizacionInventario'] = $serviciosInventario;

        
        ob_start();
            $this->load_view('formato_entrega', $this->data, NULL, FALSE);
            $formato_cotizacion = ob_get_contents();
        ob_end_clean();

        parent::pdf([
            [
                'content' => $formato_cotizacion,
                'defaultWatermark' => false,
                'header' => '<div><img src="' . CORE_PATH . 'assets/custom/img/header_entrega.jpg" width="100%" height="140"></div>',
                'footer' => '<div><img src="' . CORE_PATH . 'assets/custom/img/footer_entrega.jpg" width="100%" height="220"></div>',
                'defaultFooter' => false,
                'defaultHeader' => false,
                'pdf' => [
                    'contentMargins' => [0, 0, 30, 40], // [LEFT, RIGHT, TOP, BOTTOM]
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 0,
                    'headerMargin' => 0,
                    'fileName' => 'Venta '.$this->data['datos']['iFolio'].'.pdf',
                    'directDownloadFile' => (isset($_GET['directDownloadFile']) && $_GET['directDownloadFile'] == true ? true : false)
                ]
            ]
        ]);

        return true;
    }

}
