<?php
Class Serv_form_Controller Extends Admi_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();
    private $idTran = 'servicios'; //Mi procedimiento

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
       
            $this->admi['skServicio'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

            
            // Guardar Servicio
            $guardar_servicio = $this->guardar_servicio();
            if(!$guardar_servicio['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar impuestos Servicio
            $guardar_servicio_impuestos = $this->guardar_servicio_impuestos();
            if(!$guardar_servicio_impuestos['success']){
               // Conn::rollback($this->idTran);
                return $this->data;
            }

            // GUARDAR SERVICIOS PRECIOS
            $guardar_servicio_precios = $this->guardar_servicio_precios();
            if(!$guardar_servicio_precios['success']){
               // Conn::rollback($this->idTran);
                return $this->data;
            }
 
            
        //Conn::commit($this->idTran);
        //Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
       
        return $this->data;
    }
    /**
       * guardar_servicio
       *
       * Guardar Servicio
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function guardar_servicio(){
          $this->data['success'] = TRUE;
          $this->admi['axn'] = 'guardar_servicio';
          $this->admi['skEstatus'] = 'AC';

          $stpCUD_servicios = parent::stpCUD_servicios();
           
          if(!$stpCUD_servicios || isset($stpCUD_servicios['success']) && $stpCUD_servicios['success'] != 1){
              $this->data['success'] = FALSE;
              $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DEL SERVICIO';
              return $this->data;
          }

          $this->admi['skServicio'] = $stpCUD_servicios['skServicio'];

          $this->data['success'] = TRUE;
          $this->data['message'] = 'DATOS DE SERVICIO GUARDADOS';
          return $this->data;
      }
      /**
         * guardar_servicio_impuestos
         *
         * Guardar Archivos
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_servicio_impuestos(){
            $this->data['success'] = TRUE;

            
            $this->admi['axn'] = 'eliminar_servicio_impuestos';
             $stpCUD_servicios = parent::stpCUD_servicios();
            if(!$stpCUD_servicios || isset($stpCUD_servicios['success']) && $stpCUD_servicios['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DEL SERVICIO';
                return $this->data;
            }
          

            $this->admi['axn'] = 'guardar_servicio_impuestos';

           
            
            if(!empty($this->admi['skImpuesto'])){
                foreach ($this->admi['skImpuesto'] as $k => $v) {
                    //verificamos si ya existe el producto en el catalogo, si no existe se inserta.
                    $this->admi['skImpuestoServicio']= (!empty($v) ? $v : NULL);

                  
                    
                    $stpCUD_servicios = parent::stpCUD_servicios();
    
                    if(!$stpCUD_servicios || isset($stpCUD_servicios['success']) && $stpCUD_servicios['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS IMPUESTOS DEL SERVICIO';
                        return $this->data;
                    }
                }

            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'IMPUESTOS GUARDADOS CON ÉXITO';
            return $this->data;
        }

        public function guardar_servicio_precios(){
            $this->data['success'] = TRUE;
            $this->admi['axn'] = 'guardar_servicio_precios';
          
            $delete = "DELETE FROM rel_servicios_precios WHERE skServicio = ".escape($this->admi['skServicio']);
            $result = Conn::query($delete);

            if(!empty($this->admi['CATPRE'])){
                foreach ($this->admi['CATPRE'] AS $k => $v) {
                    if(!empty($v)){
                        $this->admi['skCategoriaPrecio']= $k;
                        $this->admi['fPrecio']= $v;

                        $stpCUD_servicios = parent::stpCUD_servicios();
                        if(!$stpCUD_servicios || isset($stpCUD_servicios['success']) && $stpCUD_servicios['success'] != 1){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS PRECIOS DEL SERVICIO';
                            return $this->data;
                        }
                    }
                }
            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'PRECIOS GUARDADOS CON ÉXITO';
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
              'sCodigo'=>['message'=>'CODIGO'],
              'sNombre'=>['message'=>'NOMBRE']
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

   

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->admi['skServicio'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        $this->data['unidadesMedida'] = parent::consultar_unidadesMedida();

         
        $impuestos = parent::getImpuestos();
          $conImpuestos= array();
          foreach($impuestos AS $k=>$v){
          $v['selected'] = 0;
          $conImpuestos[trim($v['nombre'])] = $v;
          }

        // OBTENEMOS LAS CATEGORÍAS DE PRECIOS
            $_get_categorias_precios = parent::getCatalogoSistema(['skCatalogoSistema'=>'CATPRE']);
            $this->data['categorias_precios'] = [];
            foreach($_get_categorias_precios AS $k=>$v){
                $this->data['categorias_precios'][$v['skCatalogoSistemaOpciones']] = $v;
            }

        if (!empty($this->admi['skServicio'])) {
            $this->data['datos'] = parent::_getServicio();
            $conImpuestosServicios = parent::_getServicioImpuestos();
            foreach($conImpuestosServicios AS $k=>$v){
                if(isset($conImpuestos[trim($v['nombre'])])){
                    $conImpuestos[trim($v['nombre'])]['selected'] = 1;
                }
            }

            //OBTENEMOS LOS VALORES DE CATEGORÍAS DE PRECIOS
                $_get_servicios_precios = parent::_get_servicios_precios();
                foreach($_get_servicios_precios AS $k=>$v){
                    $this->data['categorias_precios'][$v['skCategoriaPrecio']]['fPrecio'] = $v['fPrecio'];
                }

            
        }
        $this->data['serviciosImpuestos'] = $conImpuestos;
        
        return $this->data;
    }

    


     
}
