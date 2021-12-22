<?php
Class Entr_coti_Controller Extends Vent_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();
    private $idTran = 'cotizacion';

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function guardar() {
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

            $this->vent['skCotizacion'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);  

            //exit('<pre>'.print_r($this->vent,1).'</pre>');
            
             // guardar_actaEntrega 
             $guardar_actaEntrega = $this->guardar_actaEntrega();
             if(!$guardar_actaEntrega['success']){
                 Conn::rollback($this->idTran);
                 return $this->data;
             }

             // Guardar Documentos
            $guardar_documentos = $this->guardar_documentos();
            if(!$guardar_documentos['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
            
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->vent;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
       
        return $this->data;
    }

    public function guardar_actaEntrega(){
        $this->data['success'] = TRUE;
        $this->vent['axn'] = 'guardar_actaEntrega';
 

        $stp_vent_actaEntrega = parent::stp_vent_actaEntrega();
        if(!$stp_vent_actaEntrega || isset($stp_vent_actaEntrega['success']) && $stp_vent_actaEntrega['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA COTIZACION';
            return $this->data;
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE VENTA GUARDADOS';
        return $this->data;
    }

      public function guardar_documentos(){
        $this->data['success'] = TRUE;
        $this->vent['axn'] = 'guardar_documentos';
        if(
            isset($_FILES['docu_file_OPERAT_FOTOGR']['name']) 
            && !empty($_FILES['docu_file_OPERAT_FOTOGR']['name'])
        ){
            $guardar_documento = $this->sysAPI('docu', 'docu_serv', 'guardar', [
                'POST'=>[
                    'skTipoExpediente'=>'OPERAT',
                    'skTipoDocumento'=>'FOTOGR',
                    'skCodigo'=>$this->vent['skCotizacion']
                ],
                'FILES'=>[
                    'docu_file'=>$_FILES['docu_file_OPERAT_FOTOGR']
                ]
            ]);
            
            if(!$guardar_documento || isset($guardar_documento['success']) && $guardar_documento['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = $guardar_documento['message'];
                return $this->data;
            }

            $this->vent['skDocumentoFotografias'] = $guardar_documento['data']['skDocumento'];
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'FOTOGRAFÍAS GUARDADAS';
        return $this->data;
    }

    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        $this->data['message'] = "";


          $validations = [
            'sTelefonoRecepcionEntrega'=>['message'=>'TELÉFONO'],
            'dFechaEntregaInstalacion'=>['message'=>'FECHA DE INSTALACIÓN','validations'=>['date']],
            'sObservacionesInstalacion'=>['message'=>'OBSERVACIONES DE LA INSTALACIÓN'],
          ];

          foreach($validations AS $k=>$v){
              if(!isset($this->vent[$k]) || empty(trim($this->vent[$k]))){
                  $this->data['success'] = FALSE;
                  $this->data['message'] = $v['message'].' REQUERIDO';
                  return $this->data;
              }
              if(isset($v['validations'])){
                  foreach($v['validations'] AS $valid){
                      switch ($valid) {
                          case 'integer':
                              $this->vent[$k] = str_replace(',','',$this->vent[$k]);
                              if(!preg_match('/^[0-9]+$/', $this->vent[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                  return $this->data;
                              }
                          break;
                          case 'decimal':
                              $this->vent[$k] = str_replace(',','',$this->vent[$k]);
                              if(!preg_match('/^[0-9.]+$/', $this->vent[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                  return $this->data;
                              }
                          break;
                          case 'date':
                              $this->vent[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->vent[$k])));
                              if(!preg_match('/^[0-9\/-]+$/', $this->vent[$k])){
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
                      $this->vent[$key] = $val;
                      continue;
                  }else{
                      $this->vent[$key] = $val;
                      continue;
                  }
              }
          }

          if($_GET){
              foreach($_GET AS $key=>$val){
                  if(!is_array($val)){
                      $this->vent[$key] = $val;
                      continue;
                  }else{
                      $this->vent[$key] = $val;
                      continue;
                  }
              }
          }

          return $this->data;
      }

   

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->vent['skCotizacion'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
 
        if (!empty($this->vent['skCotizacion'])) {
            
            $this->data['datos'] = parent::_getCotizacion();
            $cotizacionservicios = parent::_getCotizacionservicios();
            $this->data['serviciosCotizacion'] = $cotizacionservicios;
        }
 //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }
     
}
