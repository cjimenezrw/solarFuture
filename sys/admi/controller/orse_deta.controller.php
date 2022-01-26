<?php

Class Orse_deta_Controller Extends Admi_Model {
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

        $this->admi['skOrdenServicio'] = $_GET['p1'];
        $this->data['datos'] =  parent::_getOrdenServicio(); 

        $this->data['serviciosOrdenes'] =  parent::_getOrdenServicioServicios(); 
        //exit('<pre>'.print_r($this->data['serviciosOrdenes'],1).'</pre>');
       // $this->admi['datos'] = $this->data['datos']['proceso'];
        //$this->admi['skCodigoServicio'] = $this->data['datos']['skCodigoServicio'];
        /*if(!empty($this->admi['skCodigoServicio'])){
            $this->data['domicilioReceptor'] = parent::getDatosReceptor();
        }*/

        // BANCOS Y CUENTAS BANCARIAS
        $this->admi['skEmpresaSocioResponsable'] = $_SESSION['usuario']['skEmpresaSocio'];
        $getBancosCuentasResponsable = $this->getBancosCuentasResponsable();
        $this->data['get_bancosReceptor'] = isset($getBancosCuentasResponsable['datos']['bancos']) ? $getBancosCuentasResponsable['datos']['bancos']: [];
        $this->data['get_bancosCuentasReceptor'] = isset($getBancosCuentasResponsable['datos']['cuentasBancarias']) ? $getBancosCuentasResponsable['datos']['cuentasBancarias']: [];

        $facturas = $this->get_ordenes_facturas();
	if (!empty($facturas)) {
	    $this->data['facturas'] = $facturas;
	}
       

 
        return $this->data;
    }

    public function getBancosCuentasResponsable(){
        $data = ['success'=>TRUE,'message'=>NULL,'datos'=>['bancos'=>[],'cuentasBancarias'=>[]]];
        $this->admi['skEmpresaSocioResponsable'] = isset($_POST['skEmpresaSocioResponsable']) ? $_POST['skEmpresaSocioResponsable'] : $this->admi['skEmpresaSocioResponsable'];
        
        $_getBancosCuentasResponsable = parent::_getBancosCuentasResponsable();
        if(!$_getBancosCuentasResponsable){
            $data['success'] = FALSE;
            $data['message'] = 'HUBO UN ERROR AL CONSULTAR LAS CUENTAS BANCARIAS';
            return $data;
        }
        
        foreach($_getBancosCuentasResponsable AS $row){
            if(!isset($data['datos']['bancos'][$row['skBanco']])){
                $data['datos']['bancos'][$row['skBanco']] = $row;
            }
            $data['datos']['cuentasBancarias'][$row['skBanco']][] = $row;
        }
        return $data;
    }

    public function formatoPDF() {
        //$data = [];
        $this->data = $this->consultar();

        $HEACOT = parent::getVariable('HEACOT');
        $this->data['PIECOT'] = parent::getVariable('PIECOT');
        //exit('<pre>'.print_r($this->data,1).'</pre>');

        ob_start();
        $this->load_view('formato_ordenDeServicios', $this->data, NULL, FALSE);
        $content = ob_get_contents();
        ob_end_clean();
    
        /*parent::pdf([
            'content' => $content,
            'header' => '<div></div>',
            'footer' => '',
            'pdf' => array(
            'contentMargins' => [10, 15, 5, 5],
            'format' => 'LETTER',
            'vertical' => 'L',
            'footerMargin' => 15,
            'headerMargin' => 5,
            'fileName' => 'Orden de Servicio.pdf'
            )
        ]);
        return true;*/

        parent::pdf([
            [
                'content' => $content,
                'defaultWatermark' => false,
                'header' => '
                <div class="pdf_cabecera">
                    <div style="width:40%;float: left;"><img style=""  src="' . CORE_PATH . 'assets/tpl/images/logoOriginal.png" width="300" height="100"></div>
                    <div style="width:57%;float: left;background-color:#FFFFFF; color:white;padding-top:35px;padding-left:15px;border-left:.5px solid gray;color:#cecece;">
                    <span class="bold" style="font-size: 9px;text-transform: uppercase;color:#000000;">'.$_SESSION['usuario']['sEmpresa'].'</span><br>
                    <span class="bold" style="font-size: 9px;text-transform: uppercase;color:#000000;">RFC: '.array_keys($_SESSION['usuario']['rfc'])[0].'</span><br>
                    <span style="font-size: 9px;color:#000000;">'.$HEACOT.'</span>
                    </div>
                    <hr style="color:#cecece;">
                </div>',
                'footer' => '<div></div>',
                'defaultFooter' => false,
                'defaultHeader' => false,
                'pdf' => [
                    'contentMargins' => [10, 15, 35, 5],
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 5,
                    'headerMargin' => 5,
                    'fileName' => 'Cita '.$this->data['datos']['iFolio'].'.pdf',
                    'directDownloadFile' => (isset($_GET['directDownloadFile']) && $_GET['directDownloadFile'] == true ? true : false)
                ]
            ]
            
        ]);
        return true;
    }


        public function get_ordenes_facturas() {
            $UBIFAC = TMP_HARDPATH;
            $i = 0;
            $sql = "SELECT rpf.skOrdenServicio
                ,opeF.iFolio  AS iFolio
                ,opeF.iFolio AS folioFactura
                ,opeF.skUUIDSAT
                ,opeF.sRFCEmisor
                ,opeF.sSerie
                ,opeF.skFactura
                ,opeF.skEmpresaSocioResponsable
                from rel_ordenes_facturas rpf
                INNER JOIN ope_facturas opeF ON opeF.skFactura = rpf.skFactura 
                where skOrdenServicio = " . escape($_GET['p1']);
            $result = Conn::query($sql);
            if (!$result) {
                return FALSE;
            }
            $record = Conn::fetch_assoc_all($result);

            $carpeta="facturas";
            
            $anio = date('Y');
            $VARCFD =  TMP_HARDPATH;
            $VARCFD = $VARCFD.$carpeta."/".$anio."/";

           
        
            foreach ($record AS $factura) {

                $record[$i]['facturaPDF'] = "";
                $record[$i]['facturaXML'] = "";
                $rutaCompleta= $VARCFD.$factura['sRFCEmisor']."/";

                $fileNameXML = $factura['iFolio'].'.xml';
                $fileNamePDF = $factura['iFolio'].'.pdf';
                
        
                if (!empty($factura['skUUIDSAT'])) {
                    $filePDF = $rutaCompleta.$factura['iFolio'].".pdf";
                    $fileXML = $rutaCompleta.$factura['iFolio'].".xml";

                
                    if (file_exists($filePDF)) {
                         $record[$i]['facturaPDF'] = '<center><a type="button" href="?axn=mostrarDocumento&tipo=pdf&urlDocumento=' . $filePDF . '" target="_blank" class="ajax-popup-link fa fa-file-pdf-o"></a></center>';
                        $record[$i]['ubicacionPDF'] = $filePDF;
                    }
            
                    if (file_exists($filePDF)) {
                         $record[$i]['facturaXML'] = '<center><a type="button" href="?axn=mostrarDocumento&tipo=xml&urlDocumento=' . $fileXML . '" target="_blank" class="fa fa-file-pdf-o"></a></center>';
                        $record[$i]['ubicacionXML'] = $fileXML;
                    }
                }
        
                $i++;
            }
        
            return $record;
            }


            public function mostrarDocumento() {
                $this->admi['urlDocumento'] = (isset($_GET['urlDocumento']) ? $_GET['urlDocumento'] : NULL);
                $this->admi['tipo'] = $_GET['tipo'];
            
                if ($this->admi['tipo'] == 'pdf') {
                    $fileName = "factura";
                    header("Content-Type: application/pdf");
                    header('Content-Disposition: inline; filename="' . $fileName . '.pdf"');
                    readfile($this->admi['urlDocumento']);
                }
                if ($this->admi['tipo'] == 'xml') {
                    $fileName = "factura";
                    header('Content-type: "text/xml"; charset="utf8"');
                    header('Content-disposition: attachment; filename="' . $fileName . '.xml"');
                    readfile($this->admi['urlDocumento']);
                } 
            }

    

}
