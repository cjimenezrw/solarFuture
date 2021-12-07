<?php
Class Coco_form_Controller Extends Admi_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();
    private $idTran = 'comprobantesCFDI'; //Mi procedimiento

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }
    /**
       * guardar
       *
       * Guardar Comprobante de Egresos
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez >
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
    public function guardar() {
        //exit(print_r($_POST));

        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        Conn::begin($this->idTran);

        // Obtener datos de entrada de información
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            // Validamos los datos de entrada
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            // Validamos los datos de entrada
            $validar_duplicidad = $this->validar_duplicidad();
            if(!$validar_duplicidad['success']){
                  
                Conn::rollback($this->idTran);
                return $this->data;
            }
            // Validamos los RFC permitidos
            $validar_rfcEmisor = $this->validar_rfcEmisor();
            if(!$validar_rfcEmisor['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }



            $this->admi['skComprobanteCFDI'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

           
            // Guardar Comprobante
            $guardar_comprobante = $this->guardar_comprobante();
            if(!$guardar_comprobante['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
            if(!empty($this->admi['datosConceptos'])){
                // Guardar Conceptos
                $guardar_servicios = $this->guardar_servicios();
                if(!$guardar_servicios['success']){
                    Conn::rollback($this->idTran);
                    return $this->data;
                }
            } 
            
            // Guardar Archivos
            $guardar_archivos = $this->guardar_archivos();
            if(!$guardar_archivos['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }  
           

        //Conn::commit($this->idTran);
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
        return $this->data;
    }
    /**
       * guardar_comprobante
       *
       * Guardar Comprobante
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function guardar_comprobante(){
          $this->data['success'] = TRUE;
          $this->admi['axn'] = 'guardar_comprobante';
          $this->admi['skEstatus'] = 'NU';

          $stpCUD_comprobanteCFDI = parent::stpCUD_comprobanteCFDI();

          if(!$stpCUD_comprobanteCFDI || isset($stpCUD_comprobanteCFDI['success']) && $stpCUD_comprobanteCFDI['success'] != 1){
              $this->data['success'] = FALSE;
              $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DEL COMPROBANTE';
              return $this->data;
          }

          $this->admi['skComprobanteCFDI'] = $stpCUD_comprobanteCFDI['skComprobanteCFDI'];

          $this->data['success'] = TRUE;
          $this->data['message'] = 'DATOS DE COMPROBANTE GUARDADOS';
          return $this->data;
      }
      /**
         * guardar_servicios
         *
         * Guardar Archivos
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_servicios(){
            $this->data['success'] = TRUE;
            $this->admi['axn'] = 'guardar_servicios';
            $this->admi['Conceptos'] = array();
            foreach ($this->admi['datosConceptos'] as $rowConceptos) {
                 array_push($this->admi['Conceptos'],json_decode($rowConceptos,true,512));
             }
             
             $this->admi['arrayClaveProdServ'] = [];
            foreach ($this->admi['Conceptos'] as $row) {
                $this->admi['axn'] = 'guardar_servicios';
                $this->admi['skComprobanteCFDIServicio']  = "";
                $this->admi['iNumeroIdentificacion']    = (!empty($row['ClaveProdServ']) ? $row['ClaveProdServ'] : NULL);
                $this->admi['sNumeroIdentificacion']    = (!empty($row['NoIdentificacion']) ? $row['NoIdentificacion'] : NULL);
                $this->admi['skCuentaGasto']            = (!empty($row['skCuentaGasto']) ? $row['skCuentaGasto'] : NULL);
                $this->admi['skUnidadMedida']           = (!empty($row['ClaveUnidad']) ? $row['ClaveUnidad'] : NULL);
                $this->admi['sUnidad']                  = (!empty($row['Unidad']) ? $row['Unidad'] : NULL);
                $this->admi['sDescripcion']             = (!empty($row['Descripcion']) ? $row['Descripcion'] : NULL);
                $this->admi['fCantidad']                = (!empty($row['Cantidad']) ? $row['Cantidad'] : NULL);
                $this->admi['fPrecioUnitario']          = (!empty($row['ValorUnitario']) ? $row['ValorUnitario'] : NULL);
                $this->admi['fImporte']                 = (!empty($row['Importe']) ? $row['Importe'] : NULL);
                $this->admi['fImpuestosTrasladados']    = (!empty($row['fImpuestosTrasladados']) ? $row['fImpuestosTrasladados'] : NULL);
                $this->admi['fImpuestosRetenidos']      = (!empty($row['fImpuestosRetenidos']) ? $row['fImpuestosRetenidos'] : NULL);
                $this->admi['fDescuento']               = "";
                array_push($this->admi['arrayClaveProdServ'], $this->admi['iNumeroIdentificacion']);
                $stpCUD_comprobanteCFDI = parent::stpCUD_comprobanteCFDI();

                if(!$stpCUD_comprobanteCFDI || isset($stpCUD_comprobanteCFDI['success']) && $stpCUD_comprobanteCFDI['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DEL COMPROBANTE';
                    return $this->data;
                }

                $this->admi['skComprobanteCFDIServicio'] = $stpCUD_comprobanteCFDI['skComprobanteCFDIServicio'];

                    if(!empty($this->admi['fImpuestosTrasladados'])){
                            $this->admi['axn'] = "comprobantes_servicios_impuestos";
                            $this->admi['fImporte']        = (isset($this->admi['fImpuestosTrasladados']) ? str_replace(',','',$this->admi['fImpuestosTrasladados']) : NULL);
                            $this->admi['skImpuesto'] = "TRAIVA";
                            $stpCUD_comprobanteCFDI = parent::stpCUD_comprobanteCFDI();
                            if(!$stpCUD_comprobanteCFDI || isset($stpCUD_comprobanteCFDI['success']) && $stpCUD_comprobanteCFDI['success'] != 1){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                                return $this->data;
                            }
                    }
                    if(!empty($this->admi['fImpuestosRetenidos'])){
                        $this->admi['axn'] = "comprobantes_servicios_impuestos";
                        $this->admi['fImporte']        = (isset($this->admi['fImpuestosRetenidos']) ? str_replace(',','',$this->admi['fImpuestosRetenidos']) : NULL);
                        $this->admi['skImpuesto'] = "RETIVA";
                        $stpCUD_comprobanteCFDI = parent::stpCUD_comprobanteCFDI();
                        if(!$stpCUD_comprobanteCFDI || isset($stpCUD_comprobanteCFDI['success']) && $stpCUD_comprobanteCFDI['success'] != 1){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                            return $this->data;
                        }
                    }

            }
            $this->data['success'] = TRUE;
            $this->data['message'] = 'CONCEPTOS  GUARDADOS CON EXITO';
            return $this->data;
        }

        

      /**
         * guardar_archivos
         *
         * Guardar Archivos
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_archivos(){
            $this->data['success'] = TRUE;
            $this->admi['axn'] = 'guardar_archivos';
            $this->admi['skEstatus'] = 'NU'; 

             
            //$this->admi['sRFCCliente'] = (!empty($this->admi['sRFCCliente']) ? $this->admi['sRFCCliente'] : NULL);

            $carpeta="comprobantes";
            
            $anio = date('Y');
            $VARCFD =  TMP_HARDPATH;
            $VARCFD = $VARCFD.$carpeta."/".$anio."/";

            $rutaCompleta= $VARCFD.$this->admi['sRFCEmisor']."/";

            $fileNameXML = $this->admi['iFolio'].'.xml';
            $fileNamePDF = $this->admi['iFolio'].'.pdf';

            if(!empty($_FILES['facturaXML']['tmp_name'])){
              if (!is_dir($rutaCompleta)) {
                  if (!mkdir($rutaCompleta, 0777, TRUE)) {
                      return FALSE;
                  }
              }
              chmod($rutaCompleta, 0777);
               if (!move_uploaded_file($_FILES['facturaXML']['tmp_name'], $rutaCompleta.$fileNameXML)) {
                  $this->data['success'] = FALSE;
                  $this->data['message'] = 'No se pudo subir el archivo: ' . $fileNameXML;
                  return FALSE;
              }
              chmod($rutaCompleta.$fileNameXML, 0777);
            }
            if(!empty($this->admi['rutaArchivoXML'])){
                if (!is_dir($rutaCompleta)) {
                    if (!mkdir($rutaCompleta, 0777, TRUE)) {
                        return FALSE;
                    }
                }
                if (!copy($this->admi['rutaArchivoXML'], $rutaCompleta.$fileNameXML)){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'No se pudo subir el archivo: ' . $fileNameXML;
                    return FALSE;
                }
                chmod($rutaCompleta, 0777);
                chmod($rutaCompleta.$fileNameXML, 0777);
            }
            
           

            if(!empty($_FILES['facturaPDF']['tmp_name'])){
                if (!is_dir($rutaCompleta)) {
                    if (!mkdir($rutaCompleta, 0777, TRUE)) {
                        return FALSE;
                    }
                }
                 if (!move_uploaded_file($_FILES['facturaPDF']['tmp_name'], $rutaCompleta.$fileNamePDF)) {
                   $this->data['success'] = FALSE;
                   $this->data['message'] = 'No se pudo subir el archivo: ' . $fileNamePDF;
                   return FALSE;
               }
               chmod($rutaCompleta, 0777);
               chmod($rutaCompleta.$fileNamePDF, 0777); 
            }
            if(!empty($this->admi['rutaArchivoPDF'])){
                if (!is_dir($rutaCompleta)) {
                    if (!mkdir($rutaCompleta, 0777, TRUE)) {
                        return FALSE;
                    }
                }
                if (!copy($this->admi['rutaArchivoPDF'], $rutaCompleta.$fileNamePDF)) {
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'No se pudo subir el archivo: ' . $fileNamePDF;
                    return FALSE;
                }
                chmod($rutaCompleta, 0777);
                chmod($rutaCompleta.$fileNamePDF, 0777); 

            }

            $this->data['success'] = TRUE;
            $this->data['message'] = 'ARCHIVOS GUARDADOS CON EXITO';
            return $this->data;
        }

         
        
        
      /**
         * validar_duplicidad
         *
         * Valida los datos del la entrada
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        private function validar_duplicidad(){
            $this->data['success'] = TRUE;
            $this->data['message'] = "";
            $sql="SELECT skUUIDSAT FROM ope_cfdiComprobantes WHERE skUUIDSAT =" . escape($this->admi['skUUIDSAT'])." AND skEstatus != 'CA' ";

            $result = Conn::query($sql);
            if (!$result || count($result->fetchall()) > 0) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'EL COMPROBANTE YA SE HA REGISTRADO CON ANTERIORIDAD';

                return $this->data;
            }
            return $this->data;

        }
        /**
         * validar_rfcEmisor
         *
         * Valida los datos del RFC Emisor
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        private function validar_rfcEmisor(){
            $this->data['success'] = TRUE;
            $this->data['message'] = "";
            if (!in_array($this->admi['sRFCEmisor'], ['SLI2105127D8','GACS8804016N1'])) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'EL RFC EMISOR NO ESTA PERMITIDO:'.$this->admi['sRFCEmisor'];
                return $this->data;
            }
            return $this->data;
        }

         
    /**
       * validar_datos_entrada
       *
       * Valida los datos del la entrada
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        $this->data['message'] = "";


          $validations = [
              'skUUIDSAT'=>['message'=>'skUUIDSAT'],
              'dFechaFactura'=>['message'=>'FECHA FACTURA','validations'=>['date']],
              'dFechaTimbrado'=>['message'=>'FECHA TIMBRADO','validations'=>['date']],
              'skEmpresaSocioResponsable'=>['message'=>'RESPONSABLE']
              //'fTotal'=>['message'=>'TOTAL','validations'=>['decimal']]
          ];

          foreach($validations AS $k=>$v){
              if(!isset($this->admi[$k]) || empty(trim($this->admi[$k]))){
                  $this->data['success'] = FALSE;
                  $this->data['message'] = $v['message'].' REQUERIDO';
                  return $this->data;
              }
              if(isset($v['validations'])){
                  foreach($v['validations'] AS $valid){
                      switch ($valid) {
                          case 'integer':
                              $this->admi[$k] = str_replace(',','',$this->admi[$k]);
                              if(!preg_match('/^[0-9]+$/', $this->admi[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                  return $this->data;
                              }
                          break;
                          case 'decimal':
                              $this->admi[$k] = str_replace(',','',$this->admi[$k]);
                              if(!preg_match('/^[0-9.]+$/', $this->admi[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                  return $this->data;
                              }
                          break;
                          case 'date':
                              $this->admi[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->admi[$k])));
                              if(!preg_match('/^[0-9\/-]+$/', $this->admi[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - FECHA NO VALIDA';
                                  return $this->data;
                              }
                          break;
                      }
                  }
              }
          }

          return $this->data;
      }

    /**
       * getInputData
       *
       * Obtener datos de entrada de información
       *
       * @author LUIS ALBERTO VALDEZ ALVAREZ <lvaldez>
       * @return Boolean TRUE | FALSE
       */
      private function getInputData(){

          $this->data['success'] = TRUE;

          if(!$_POST && !$_GET){
              $this->data['success'] = FALSE;
              $this->data['message'] = 'NO SE RECIBIERON DATOS';
              return $this->data;
          }

          if($_POST){
              foreach($_POST AS $key=>$val){
                  if(!is_array($val)){
                      $this->admi[$key] = $val;
                      continue;
                  }else{
                      $this->admi[$key] = $val;
                      continue;
                  }
              }
          }

          if($_GET){
              foreach($_GET AS $key=>$val){
                  if(!is_array($val)){
                      $this->admi[$key] = $val;
                      continue;
                  }else{
                      $this->admi[$key] = $val;
                      continue;
                  }
              }
          }

          return $this->data;
      }

    /* FUNCIONES PARA EL GUARDADO  */

   


    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->admi['skComprobanteCFDI'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;

        if (!empty($this->admi['skComprobanteCFDI'])) {
            $this->data['data']['datos'] = parent::_getComprobanteCFDI();
        }

        return $this->data;
    }

    public function obtenerDatosXML() {
        
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $fileName = 'tmp'.rand(1,1000).time().'.xml';
        move_uploaded_file($_FILES['facturaXML']['tmp_name'], TMP_HARDPATH.$fileName);
        $this->admi['rutaArchivo'] = TMP_HARDPATH.$fileName;


        $datos =   parent::leerXML();
        $this->data['datos'] = $datos['datos'];
        $this->data['datos']['sXML'] = file_get_contents($this->admi['rutaArchivo'], true);
        unlink($this->admi['rutaArchivo']);
        $this->acomodarDatos();

       

        return $this->data;
    }

    public function acomodarDatos(){
       
        if(!empty($_POST['archivoGuardado'])){
            $this->data['datos'] = $_POST;
            
        }
        //OBTENER SK de metodo,forma,usoCFDI,etc.
      
        $this->data['datos']['comprobante']['skFormaPago'] = (!empty($this->data['datos']['comprobante']['FormaPago']) ? $this->data['datos']['comprobante']['FormaPago'] : NULL);
      
        $this->data['datos']['comprobante']['skMetodoPago'] =(!empty($this->data['datos']['comprobante']['MetodoPago']) ? $this->data['datos']['comprobante']['MetodoPago'] : NULL);
  
        $this->data['datos']['Receptor']['skUsoCFDI'] = (!empty($this->data['datos']['Receptor']['UsoCFDI']) ? $this->data['datos']['Receptor']['UsoCFDI'] : NULL);
        //OBTENER EMISOR skEmpresaSocioEmisor, SI NO EXISTE COMO PROVEEDOR, SE REGISTRA CON ESE TIPO DE EMPRESA [PROV].
        
        $this->admi['sRFC'] = $this->data['datos']['Emisor']['Rfc'];
        $this->admi['skEmpresaTipo']= 'PROP';
        $this->data['datos']['Emisor']['skEmpresaSocioEmisor'] = $this->obtenerEmpresa();
        /*if(empty($this->data['datos']['Emisor']['skEmpresaSocioEmisor'])) {
            $this->admi['empresa']['sNombre'] = (isset($this->data['datos']['Emisor']['Nombre']) ? $this->data['datos']['Emisor']['Nombre'] : NULL);
            $this->admi['empresa']['sRFC'] = $this->admi['sRFC'];
            $this->admi['empresa']['skEmpresaTipo'] = 'PROV';
            $empresa=  $this->guardarEmpresa();

            $this->data['datos']['Emisor']['skEmpresaSocioEmisor'] = $empresa['datos']['skEmpresaSocio'];
          
            

 
        }*/
        //$this->data['datos']['Emisor']['skEmpresaSocioEmisor'] = $_SESSION['usuario']['skEmpresaSocioPropietario'];
        //$this->data['datos']['Responsable']['skEmpresaSocioResponsable'] = $this->data['datos']['Emisor']['skEmpresaSocioEmisor'];
        //$this->data['datos']['Responsable']['skEmpresaSocioResponsable'] = $_SESSION['usuario']['skEmpresaSocioPropietario'];
           // $this->data['datos']['Responsable']['sRFCResponsable'] = $this->admi['sRFC'];
            //$this->data['datos']['Responsable']['sNombre']=(isset($this->data['datos']['Emisor']['Nombre']) ? $this->data['datos']['Emisor']['Nombre'] : NULL);

        $this->admi['sRFC'] = $this->data['datos']['Receptor']['Rfc'];
        $this->admi['skEmpresaTipo']= ['AGAD','CLIE'];
        $this->data['datos']['Receptor']['sRFCReceptor'] = $this->data['datos']['Receptor']['Rfc'];
        $this->data['datos']['Receptor']['skEmpresaSocioFacturar'] = $this->obtenerEmpresa();
        $this->admi['skEmpresaTipo']= ['AGAD'];
        //$this->data['datos']['Responsable']['skEmpresaSocioResponsable'] = $this->obtenerEmpresa();
        //$this->data['datos']['Responsable']['sRFCResponsable'] = $this->data['datos']['Receptor']['Rfc'];
        //$this->data['datos']['Responsable']['sNombre'] = $this->data['datos']['Receptor']['Nombre'];



        if(empty($this->data['datos']['Receptor']['skEmpresaSocioFacturar'])) {
            $this->admi['empresa']['sNombre'] = $this->data['datos']['Receptor']['Nombre'];
            $this->admi['empresa']['sRFC'] = $this->admi['sRFC'];
            $this->admi['empresa']['skEmpresaTipo'] = 'CLIE';
            $empresa=  $this->guardarEmpresa(); 
            $this->data['datos']['Receptor']['skEmpresaSocioFacturar'] = $empresa['skEmpresaSocio'];
            //$this->data['datos']['Responsable']['skEmpresaSocioResponsable'] = $empresa['skEmpresaSocio'];



        }

        /*$this->data['datos']['Cliente']['skEmpresaSocioCliente'] = "";
        if($this->data['datos']['Responsable']['sRFCResponsable'] != $this->data['datos']['Receptor']['sRFCReceptor']){
          $this->data['datos']['Cliente']['skEmpresaSocioCliente'] = $this->data['datos']['Receptor']['skEmpresaSocioFacturar'];
          $this->data['datos']['Cliente']['sRFCCliente'] = $this->data['datos']['Receptor']['Rfc'];
          
        }*/

        return $this->data;



    }
    public function obtenerEmpresa(){

      $sql= "SELECT   res.skEmpresaSocio FROM rel_empresasSocios res
             INNER JOIN cat_empresas ce ON ce.skEmpresa = res.skEmpresa
             WHERE res.skEstatus = 'AC' AND ce.skEstatus = 'AC' AND res.skEmpresaSocioPropietario = " . escape($_SESSION['usuario']['skEmpresaSocioPropietario'])." ";

             if (isset($this->admi['skEmpresaTipo']) && !empty($this->admi['skEmpresaTipo'])) {
                 if (is_array($this->admi['skEmpresaTipo'])) {
                     $sql .= " AND res.skEmpresaTipo IN (" . mssql_where_in($this->admi['skEmpresaTipo']) . ") ";
                 } else {
                     $sql .= " AND res.skEmpresaTipo = " . escape($this->admi['skEmpresaTipo']);
                 }
             }
             if (isset($this->admi['sRFC']) && !empty($this->admi['sRFC'])) {
                 $sql .= " AND ce.sRFC = " . escape($this->admi['sRFC']);
             }
             $sql.= " LIMIT 1 ";

             $result = Conn::query($sql);
             if (!$result) {
                 return FALSE;
             }
             $record = Conn::fetch_assoc($result);
             return (!empty($record['skEmpresaSocio']) ? $record['skEmpresaSocio'] : NULL);

    }
    private function guardarEmpresa(){
       $this->admi['empresa']['skEmpresa'] = NULL;

        $sql = "SELECT skEmpresa FROM cat_empresas WHERE skEstatus = 'AC' AND sRFC=" . escape($this->admi['empresa']['sRFC']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);

        if(!empty($record['skEmpresa'])){
        $this->admi['empresa']['skEmpresa'] = $record['skEmpresa'];
        }

            $empr = $this->sysAPI('empr', 'emso_form', 'guardar', [
                'POST' => [
                    'skEmpresa' => $this->admi['empresa']['skEmpresa'],
                    'skEmpresaSocio'=> NULL,
                    'sRFC' => $this->admi['empresa']['sRFC'],
                    'sNombre' => $this->admi['empresa']['sNombre'],
                    'sNombreCorto' => $this->admi['empresa']['sNombre'],
                    'skEstatus' => 'AC',
                    'skEmpresaTipo' => $this->admi['empresa']['skEmpresaTipo']
                ]
             ]);
             return $empr;
    }
     /**
     * getEmpresas
     *
     * Obtener Empresas
     *
     * @author lvaldez <lvaldez>
     * @return Array EmpresasSocios
     */
    public function getEmpresas(){
        $this->admi['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        if(isset($_POST['skEmpresaTipo']) && !empty($_POST['skEmpresaTipo'])){
            $skEmpresaTipo = json_decode($_POST['skEmpresaTipo'], true, 512);
            if(!is_array($skEmpresaTipo)){
                $skEmpresaTipo = $_POST['skEmpresaTipo'];
            }
            $this->admi['skEmpresaTipo'] = $skEmpresaTipo;
        }
        return parent::get_empresas();
    }
    
}
