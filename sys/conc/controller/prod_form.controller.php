<?php
Class Prod_form_Controller Extends Conc_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();
    private $idTran = 'informacionProducto';

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
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
    public function guardar() {
        //exit(print_r($_POST));

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

            $this->conc['skInformacionProductoServicio'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);
            
            // Guardar Imagen
            $guardar_informacionProductoServicio_imagen = $this->guardar_informacionProductoServicio_imagen();
            if(!$guardar_informacionProductoServicio_imagen['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar Concepto
            $guardar_informacionProductoServicio = $this->guardar_informacionProductoServicio();
            if(!$guardar_informacionProductoServicio['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        //Conn::commit($this->idTran);
        $this->data['datos'] = $this->conc;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
       
        return $this->data;
    }

    public function guardar_informacionProductoServicio_imagen(){
        $this->data['success'] = TRUE;
        if (!empty($_FILES["sImagen"]["name"])) {
            $path = DIR_PROJECT.'files/conc/prod-form/';
            $ext = pathinfo($_FILES["sImagen"]["name"], PATHINFO_EXTENSION);
            $fileName = strtotime(date('Ymd h:i:s')).rand(0,1000).'.'.$ext;
            if(!empty($this->conc['sImagenGuardada'])){
                unlink(DIR_PROJECT.'files/conc/prod-form/'.$this->conc['sImagenGuardada']);
            }
            if (move_uploaded_file($_FILES["sImagen"]["tmp_name"], $path.$fileName)) {
                $this->data['success'] = TRUE;
                $this->conc['sImagen'] = $fileName;
            }else{
                $this->data['success'] = FALSE;
            }
        }else{
            $this->data['success'] = TRUE;
            $this->conc['sImagen'] = $this->conc['sImagenGuardada'];
        }
        $this->data['success'] = TRUE;
        $this->data['message'] = 'PROCESO REALIZADO';
        return $this->data;
    }

    public function guardar_informacionProductoServicio(){
        $this->data['success'] = TRUE;
        $this->conc['axn'] = 'guardar_informacionProductoServicio';

        $stpCUD_informacionProductoServicio = parent::stpCUD_informacionProductoServicio();
        
        if(!$stpCUD_informacionProductoServicio || isset($stpCUD_informacionProductoServicio['success']) && $stpCUD_informacionProductoServicio['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR';
            return $this->data;
        }

        $this->conc['skInformacionProductoServicio'] = $stpCUD_informacionProductoServicio['skInformacionProductoServicio'];

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CONCEPTO GUARDADOS';
        return $this->data;
    }

    public function ckEditor_upload(){
        if (!empty($_FILES["upload"]["name"])) {
            $path = DIR_PROJECT.'files/conc/prod-form/uploads/';
            $ext = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
            $fileName = strtotime(date('Ymd h:i:s')).rand(0,1000).'.'.$ext;
            if (move_uploaded_file($_FILES["upload"]["tmp_name"], $path.$fileName)) {
                return [
                    "fileName" => $fileName,
                    "uploaded" => 1, 
                    "url" => SYS_URL.'files/conc/prod-form/uploads/'.$fileName
                ];
            }else{
                return [
                    "fileName" => NULL,
                    "uploaded" => 0, 
                    "url" => NULL
                ];
            }
        }
        return [
            "fileName" => NULL,
            "uploaded" => 0, 
            "url" => NULL
        ];
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
              'sNombre'=>['message'=>'NOMBRE']
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
        $this->conc['skInformacionProductoServicio'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        if (!empty($this->conc['skInformacionProductoServicio'])) {
            $this->data['datos'] = parent::_get_informacionProductoServicio();
        }
        return $this->data;
    }

     
}
