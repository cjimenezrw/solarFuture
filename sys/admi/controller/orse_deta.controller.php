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
        $this->admi['datos'] = $this->data['datos']['proceso'];
        $this->admi['skCodigoServicio'] = $this->data['datos']['skCodigoServicio'];
        if(!empty($this->admi['skCodigoServicio'])){
            $this->data['domicilioReceptor'] = parent::getDatosReceptor();
        }

        $comprobantes = $this->get_ordenes_comprobanates();
	if (!empty($comprobantes)) {
	    $this->data['comprobantes'] = $comprobantes;
	}
       

 
        return $this->data;
    }

    public function formatoPDF() {
        //$data = [];
        $this->data = $this->consultar();
        
        $this->data['footer'] = '<div class="pdf_cabecera" style="color:gray">
                            <div class="pdf_left">
                                <div class="pdf_fontStyle">' . COMPANY . '</div>
                                <div class="pdf_fontStyle">' . date_format(new DateTime(), 'd/m/Y H:i:s') . '</div>
                            </div>
                            <div class="pdf_centro pdf_fontStyle">' . SYS_URL . '</div>
                            <div class="pdf_left fpag pdf_fontStyle">' . $_SESSION['usuario']['sNombreUsuario'] . ' ' . $_SESSION['usuario']['sPaterno'] . ' ' . $_SESSION['usuario']['sPaterno'] . '</div>
                        </div>';
         
        ob_start();
        $this->load_view('formato_ordenDeServicios', $this->data, NULL, FALSE);
        $content = ob_get_contents();
        ob_end_clean();
    
        parent::pdf([
            'content' => $content,
            'header' => '<div></div>',
            'defaultFooter' => false,
            'footer' => '<div class="pdf_cabecera" style="color:gray">
                            <div class="pdf_left">
                                <div class="pdf_fontStyle">' . COMPANY . '</div>
                                <div class="pdf_fontStyle">' . date_format(new DateTime(), 'd/m/Y H:i:s') . '</div>
                            </div>
                            <div class="pdf_centro pdf_fontStyle">' . SYS_URL . '</div>
                            <div class="pdf_left fpag pdf_fontStyle">' . $_SESSION['usuario']['sNombreUsuario'] . ' ' . $_SESSION['usuario']['sPaterno'] . ' ' . $_SESSION['usuario']['sPaterno'] . '</div>
                        </div>',
            'pdf' => array(
            'contentMargins' => [10, 15, 5, 5],
            'format' => 'LETTER',
            'vertical' => 'L',
            'footerMargin' => 15,
            'headerMargin' => 5,
            'fileName' => 'Orden de Servicio.pdf'
            )
        ]);
        return true;
        }


        public function get_ordenes_comprobanates() {
            $UBIFAC = TMP_HARDPATH;
            $i = 0;
            $sql = "SELECT rpf.skOrdenServicio
                ,opeF.iFolio  AS iFolio
                ,opeF.iFolio AS folioFactura
                ,opeF.skUUIDSAT
                ,opeF.sRFCEmisor
                ,opeF.sSerie
                ,opeF.skComprobanteCFDI
                ,opeF.skEmpresaSocioResponsable
                from rel_ordenes_comprobantes rpf
                INNER JOIN ope_cfdiComprobantes opeF ON opeF.skComprobanteCFDI = rpf.skComprobanteCFDI 
                where skOrdenServicio = " . escape($_GET['p1']);
            $result = Conn::query($sql);
            if (!$result) {
                return FALSE;
            }
            $record = Conn::fetch_assoc_all($result);

            $carpeta="comprobantes";
            
            $anio = date('Y');
            $VARCFD =  TMP_HARDPATH;
            $VARCFD = $VARCFD.$carpeta."/".$anio."/";

           
        
            foreach ($record AS $comprobantes) {

                $record[$i]['facturaPDF'] = "";
                $record[$i]['facturaXML'] = "";
                $rutaCompleta= $VARCFD.$comprobantes['sRFCEmisor']."/";

                $fileNameXML = $comprobantes['iFolio'].'.xml';
                $fileNamePDF = $comprobantes['iFolio'].'.pdf';
                
        
                if (!empty($comprobantes['skUUIDSAT'])) {
                    $filePDF = $rutaCompleta.$comprobantes['iFolio'].".pdf";
                    $fileXML = $rutaCompleta.$comprobantes['iFolio'].".xml";

                
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
