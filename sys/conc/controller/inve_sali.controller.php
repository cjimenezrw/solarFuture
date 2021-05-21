<?php
Class Inve_sali_Controller Extends Conc_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();
    private $idTran = 'cotizacion'; //Mi procedimiento

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }
    /**
       * guardar
       *
       * Guardar Salida de Mercancia
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
    public function guardar() {
        //exit(print_r($_POST));

        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        Conn::begin($this->idTran);

        // Obtener datos de entrada de información
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            // Validamos los datos de entrada
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
            /*echo "<PRE>";
            print_r($this->conc);
            die();*/

            $this->conc['skConcepto'] = (isset($_POST['skConcepto']) ? $_POST['skConcepto'] : NULL);  

            

             
             // baja_inventario 
             $baja_inventario = $this->baja_inventario();
             if(!$baja_inventario['success']){
                 Conn::rollback($this->idTran);
                 return $this->data;
             }
             

             
            

        //Conn::commit($this->idTran);
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->conc;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
       
        return $this->data;
    }

    
     
    /**
       * baja_inventario
       *
       * Guardar baja_inventario
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function baja_inventario(){
          $this->data['success'] = TRUE;
          $this->conc['axn'] = 'baja_inventario';
          $this->conc['skEstatus'] = NULL;

          $this->conc['skUsuarioBaja'] = (!empty($_POST['skUsuarioBaja']) ? $_POST['skUsuarioBaja'] : NULL);  
          $this->conc['sDescripcionBaja'] = (!empty($_POST['sDescripcionBaja']) ? $_POST['sDescripcionBaja'] : NULL);  
          
          if(!empty($this->conc['skConceptoInventario'])){
            $inventario = $this->conc['skConceptoInventario'];
            foreach($inventario AS $key => $row){
                $this->conc['skConceptoInventario'] = $row;
                $this->conc['fCantidad'] = 1;
                $this->conc['iDetalle'] = 1;
                    $stpCUD_conceptosInventario = parent::stpCUD_conceptosInventario();
                    if(!$stpCUD_conceptosInventario || isset($stpCUD_conceptosInventario['success']) && $stpCUD_conceptosInventario['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA COTIZACION';
                        return $this->data;
                    }
            }  
            
        }else{
            if(empty($this->conc['fCantidad'])){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'LA CANTIDAD ES REQUERIDA';
                return $this->data;
            }

            $this->conc['fCantidad'] =  $this->conc['fCantidad'];
            $this->conc['skConceptoInventario'] = NULL;
            $this->conc['iDetalle'] = NULL;
            $stpCUD_conceptosInventario = parent::stpCUD_conceptosInventario();
            if(!$stpCUD_conceptosInventario || isset($stpCUD_conceptosInventario['success']) && $stpCUD_conceptosInventario['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA COTIZACION';
                return $this->data;
            }
            
        }
          
 

          $this->data['success'] = TRUE;
          $this->data['message'] = 'DATOS DE COTIZACION GUARDADOS';
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
              'skConcepto'=>['message'=>'CONCEPTO']
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
        $this->data['usuarioBaja'] = parent::_getUsuariosBaja();
        if (!empty($this->conc['skConcepto'])) {
            
            $this->data['datos'] = parent::_getConcepto();
            $this->conc['skEstatus'] = 'NU';
            $this->data['inventario'] = parent::_get_conceptos_inventario();
  

           
            

            
        }
 //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }
     
 
    


     
}
