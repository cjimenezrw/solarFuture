<?php

Class Cofa_deta_Controller Extends Admi_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
	parent::init();
    }

    public function __destruct() {

    }

    public function consultar() {
         	$this->admi['skFactura'] = $_GET['p1'];
            $this->data['datos'] = parent::consultar_factura();
            if(!$this->data['datos']){
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL COMPROBNTE',404);
            }

            $carpeta="facturas";
            
            $anioTimbrado =(!empty($this->data['datos']['dFechaTimbrado']) ? date('Y', strtotime($this->data['datos']['dFechaTimbrado'])) : NULL);
            $mesTimbrado =(!empty($this->data['datos']['dFechaTimbrado']) ? date('m', strtotime($this->data['datos']['dFechaTimbrado'])) : NULL);
           // $anio = date('Y');
            $VARCFD = parent::getVariable('VARCFD');
            $VARCFD =  DIR_PROJECT.$VARCFD;
            $VARCFD = $VARCFD.$carpeta."/".$anioTimbrado."/".$mesTimbrado."/";

            $rutaCompleta= $VARCFD; 
            $fileNameXML = $this->data['datos']['skUUIDSAT'].'.xml';
            $fileNamePDF = $this->data['datos']['skUUIDSAT'].'.pdf';

            //SI UUID ES DIFERENTE DE VACIO, SE VA A CONSULTAR LA RUTA PARA VER SI EXISTEN LOS DOS DOCUMENTOS.
            if(!empty($this->data['datos']['skUUIDSAT'])){
              $filePDF = $rutaCompleta.$this->data['datos']['skUUIDSAT'].".pdf";
              $fileXML = $rutaCompleta.$this->data['datos']['skUUIDSAT'].".xml";
             

              $nombreArchivo = '';
              $nombreArchivo = $this->data['datos']['skUUIDSAT'];
  			
              if(file_exists($filePDF)){
                  $this->data['datos']['facturaPDF'] = '?axn=mostrarDocumento&tipo=pdf&name='.$nombreArchivo.'&urlDocumento='.$filePDF;
                 
              }
              if(file_exists($filePDF)){
                  $this->data['datos']['facturaXML'] = '?axn=mostrarDocumento&tipo=xml&name='.$nombreArchivo.'&urlDocumento='.$fileXML;
              }



            } 

            $this->data['VARCFD'] =$VARCFD;
            $this->data['facturas_servicios'] = parent::consultar_facturas_servicios();
            // $this->data['transaccionesFacturas'] = parent::_get_transaccion_facturas();
        	//$this->data['ordenesFacturas'] = parent::_get_ordenes_facturas();
            //$this->data['historialConexion'] = parent::consultar_factura_historial();
            //$this->data['historialCancelacion'] = parent::consultar_factura_historialCancelacion();

 
	     return $this->data;
    }


       

        public function mostrarDocumento(){
            $this->admi['urlDocumento'] = (isset($_GET['urlDocumento']) ? $_GET['urlDocumento'] : NULL);
            $this->admi['name'] = (isset($_GET['name']) ? $_GET['name'] : 'Factura');
            $this->admi['tipo'] = $_GET['tipo'];

            if($this->admi['tipo'] == 'pdf'){
                 header("Content-Type: application/pdf");
                header('Content-Disposition: inline; filename="' . $this->admi['name'] . '.pdf"');
                readfile($this->admi['urlDocumento']);
            }
            if($this->admi['tipo'] == 'xml'){
                 header('Content-type: "text/xml"; charset="utf8"');
                header('Content-disposition: attachment; filename="' . $this->admi['name'] . '.xml"');
                readfile($this->admi['urlDocumento']);
            }
            if($this->admi['tipo'] == 'formatoPreFactura'){
                header('Content-type: "text/xml"; charset="utf8"');
                header('Content-disposition: attachment; filename="' . $this->admi['name'] . '.xml"');
                readfile($this->generarFormatoFA());
            }

        }



}

?>
