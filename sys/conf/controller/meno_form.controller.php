<?php
Class Meno_form_Controller Extends Conf_Model {
    // CONS //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'stpCUD_notificacionesMensajes';

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function guardar() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        //Conn::begin($this->idTran);
        $this->log('GUARDANDO', true, true);
        // Obtener datos de entrada de información
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            // Validamos los datos de entrada
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }
            
            $this->conf['skNotificacionMensaje'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

            // Guardar notificacion
            $guardar_notificacion = $this->guardar_notificacion();
            if(!$guardar_notificacion['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }
            
        //Conn::commit($this->idTran);
        $this->data['datos'] = $this->conf;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
       
        return $this->data;
    }

      public function guardar_notificacion(){
          $this->data['success'] = TRUE;
          $this->conf['axn'] = 'guardar_notificacion';
          $this->conf['skEstatus'] = 'AC';
        
          $stpCUD_notificacionesMensajes = parent::stpCUD_notificacionesMensajes();
                
          if(!$stpCUD_notificacionesMensajes || isset($stpCUD_notificacionesMensajes['success']) && $stpCUD_notificacionesMensajes['success'] != 1){
              $this->data['success'] = FALSE;
              $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL REGISTRO';
              return $this->data;
          }

        $this->conf['skNotificacionMensaje'] = $stpCUD_notificacionesMensajes['skNotificacionMensaje'];

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DEL MENSAJE GUARDADO CN EXITO';
        return $this->data;
    }
   
    /**
       * validar_datos_entrada
       *
       * Valida los datos del la entrada
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        $this->data['message'] = "";


          $validations = [
              //'sCodigo'=>['message'=>'fCantidad']
          ];

          foreach($validations AS $k=>$v){
              if(!isset($this->conf[$k]) || empty(trim($this->conf[$k]))){
                  $this->data['success'] = FALSE;
                  $this->data['message'] = $v['message'].' REQUERIDO';
                  return $this->data;
              }
              if(isset($v['validations'])){
                  foreach($v['validations'] AS $valid){
                      switch ($valid) {
                          case 'integer':
                              $this->conf[$k] = str_replace(',','',$this->conf[$k]);
                              if(!preg_match('/^[0-9]+$/', $this->conf[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                  return $this->data;
                              }
                          break;
                          case 'decimal':
                              $this->conf[$k] = str_replace(',','',$this->conf[$k]);
                              if(!preg_match('/^[0-9.]+$/', $this->conf[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                  return $this->data;
                              }
                          break;
                          case 'date':
                              $this->conf[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->conf[$k])));
                              if(!preg_match('/^[0-9\/-]+$/', $this->conf[$k])){
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
       * @author LUIS ALBERTO VALDEZ ALVAREZ <lvaldez@woodward.com.mx>
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
                      $this->conf[$key] = $val;
                      continue;
                  }else{
                      $this->conf[$key] = $val;
                      continue;
                  }
              }
          }

          if($_GET){
              foreach($_GET AS $key=>$val){
                  if(!is_array($val)){
                      $this->conf[$key] = $val;
                      continue;
                  }else{
                      $this->conf[$key] = $val;
                      continue;
                  }
              }
          }

          return $this->data;
        }
        public function validarCodigo() {
            $skNotificacionMensaje = (isset($_POST['p1']) ? $_POST['p1'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
            return parent::validar_codigoNotificacionMensaje($_POST['sClaveNotificacion'], $skNotificacionMensaje);
    
            return false;
        }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->data['estatus'] = parent::consultar_core_estatus(['AC', 'IN'], true);
        $this->data['comportamientos'] = parent::consultar_comportamientos();
         if (isset($_GET['p1'])) {
            $this->conf['skNotificacionMensaje'] = $_GET['p1'];
            $this->data['datos'] = parent::consultarNotificacionesMensaje();
            //$this->data['variablesMensajes'] = parent::variablesMensajes();
            //$this->data['aplicacionesMensajes'] = parent::getAplicacionesMensajes();
            return $this->data;
        }
        return $this->data;

       
        
        
        return $this->data;
    }
}
