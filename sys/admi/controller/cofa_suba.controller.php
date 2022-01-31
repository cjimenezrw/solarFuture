<?php
Class Cofa_suba_Controller Extends Admi_Model {

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
          



            $this->admi['skFactura'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

            
           
            // Guardar Archivos
            $guardar_datosXML = $this->guardar_datosXML();
            if(!$guardar_datosXML['success']){
                Conn::rollback($this->idTran);
                return $this->data;
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
     * guardar_datosXML
     *
     * Guardar guardar_datosXML
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function guardar_datosXML(){
        $this->admi['axn'] = 'guardar_datosXML';
        $this->admi['skEstatus'] = 'PE';
         
        $stpCUD_facturas = parent::stpCUD_facturas();


        if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS GENERALES DE FACTURAS.';
            return $this->data;
        }

        $this->admi['skFactura'] = $stpCUD_facturas['skFactura'];

        $this->data['datos']['skFactura'] = $stpCUD_facturas['skFactura'];

        $this->data['success'] = TRUE;
        $this->data['message'] = 'GENERALES DE DATOS XML.';
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

            $carpeta="facturas";
            $anioTimbrado =date('Y', strtotime($this->admi['dFechaTimbrado']));
            $mesTimbrado =date('m', strtotime($this->admi['dFechaTimbrado']));
            
            $VARCFD = parent::getVariable('VARCFD');
            $VARCFD =  DIR_PROJECT.$VARCFD;
            $VARCFD = $VARCFD.$carpeta."/".$anioTimbrado."/".$mesTimbrado."/";
            $rutaCompleta= $VARCFD;
            $fileNameXML = $this->admi['skUUIDSAT'].'.xml';
            $fileNamePDF = $this->admi['skUUIDSAT'].'.pdf';

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
            $sql="SELECT skUUIDSAT FROM ope_facturas WHERE skUUIDSAT =" . escape($this->admi['skUUIDSAT'])." AND skEstatus != 'CA' ";

            $result = Conn::query($sql);
            if (!$result || count($result->fetchall()) > 0) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'EL COMPROBANTE YA SE HA REGISTRADO CON ANTERIORIDAD';

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
              'dFechaTimbrado'=>['message'=>'FECHA TIMBRADO','validations'=>['date']] 
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
