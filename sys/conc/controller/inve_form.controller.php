<?php
Class Inve_form_Controller Extends Conc_Model {
    // CONS //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'stpCUD_conceptosInventario';

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function guardar() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        //Conn::begin($this->idTran);

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

            $this->conc['skConcepto'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

            // Guardar Concepto Producto
            $guardar_concepto_productos = $this->guardar_concepto_productos();
            if(!$guardar_concepto_productos['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }
            
        //Conn::commit($this->idTran);
        $this->data['datos'] = $this->conc;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
       
        return $this->data;
    }

      public function guardar_concepto_productos(){
          $this->data['success'] = TRUE;
          $this->conc['axn'] = 'guardar_concepto';
          $this->conc['skEstatus'] = 'NU';

          $stpCUD_conceptosInventario = parent::stpCUD_conceptosInventario();
           
          if(!$stpCUD_conceptosInventario || isset($stpCUD_conceptosInventario['success']) && $stpCUD_conceptosInventario['success'] != 1){
              $this->data['success'] = FALSE;
              $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS PRODUCTOS DEL CONCEPTO';
              return $this->data;
          }

          $this->conc['skConcepto'] = $stpCUD_conceptosInventario['skConcepto'];

          $this->data['success'] = TRUE;
          $this->data['message'] = 'DATOS DE LOS PRODUCTOS GUARDADOS';
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
              'sCodigo'=>['message'=>'fCantidad']
          ];

          foreach($validations AS $k=>$v){
              if(!isset($this->conc[$k]) || empty(trim($this->conc[$k]))){
                  $this->data['success'] = FALSE;
                  $this->data['message'] = $v['message'].' REQUERIDO';
                  return $this->data;
              }
              if(isset($v['validations'])){
                  foreach($v['validations'] AS $valid){
                      switch ($valid) {
                          case 'integer':
                              $this->conc[$k] = str_replace(',','',$this->conc[$k]);
                              if(!preg_match('/^[0-9]+$/', $this->conc[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                  return $this->data;
                              }
                          break;
                          case 'decimal':
                              $this->conc[$k] = str_replace(',','',$this->conc[$k]);
                              if(!preg_match('/^[0-9.]+$/', $this->conc[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                  return $this->data;
                              }
                          break;
                          case 'date':
                              $this->conc[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->conc[$k])));
                              if(!preg_match('/^[0-9\/-]+$/', $this->conc[$k])){
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
                      $this->conc[$key] = $val;
                      continue;
                  }else{
                      $this->conc[$key] = $val;
                      continue;
                  }
              }
          }

          if($_GET){
              foreach($_GET AS $key=>$val){
                  if(!is_array($val)){
                      $this->conc[$key] = $val;
                      continue;
                  }else{
                      $this->conc[$key] = $val;
                      continue;
                  }
              }
          }

          return $this->data;
        }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->conc['skConcepto'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;

        if (!empty($this->conc['skConcepto'])) {
            $this->data['datos'] = parent::_getConcepto();
        }
        
        return $this->data;
    }
}
