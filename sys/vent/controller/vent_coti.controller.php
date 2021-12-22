<?php
Class Vent_coti_Controller Extends Vent_Model {

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
       * Guardar Comprobante de Egresos
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
            print_r($this->vent);
            die();*/

            $this->vent['skCotizacion'] = (isset($_POST['skCotizacion']) ? $_POST['skCotizacion'] : NULL);  

            

            // Guardar cotizacion
            
             // guardar_venta 
             $guardar_venta = $this->guardar_venta();
             if(!$guardar_venta['success']){
                 Conn::rollback($this->idTran);
                 return $this->data;
             }
             

            $descontar_servicio_inventario = $this->descontar_servicio_inventario();
            if(!$descontar_servicio_inventario['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
             // GENERAR ORDEN DE SERVICIO 
            $generar_orden = $this->generar_orden();
            if(!$generar_orden['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            

        //Conn::commit($this->idTran);
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->vent;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
       
        return $this->data;
    }

    
     /**
       * guardar_venta
       *
       * Guardar guardar_venta
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function guardar_venta(){
        $this->data['success'] = TRUE;
        $this->vent['axn'] = 'guardar_venta';
        $this->vent['skVenta'] = NULL;
 

        $stpCUD_ventas = parent::stpCUD_ventas();
        if(!$stpCUD_ventas || isset($stpCUD_ventas['success']) && $stpCUD_ventas['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA COTIZACION';
            return $this->data;
        }

        


        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE VENTA GUARDADOS';
        return $this->data;
    }

    /**
       * descontar_servicio_inventario
       *
       * Guardar descontar_servicio_inventario
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function descontar_servicio_inventario(){
          $this->data['success'] = TRUE;
          $this->vent['axn'] = 'descontar_servicio_inventario';
          $this->vent['skEstatus'] = NULL;
          if(!empty($this->vent['servicio'])){
        
            foreach($this->vent['servicio'] AS $key => $row){

                if(!empty($row['skServicioInventario'])){
                    $this->vent['fCantidad'] = 1;
                    $this->vent['iDetalle'] = $row['iDetalle'];
                    $this->vent['skServicio'] = $row['skServicio'];
                    $this->vent['skCotizacionServicio'] = $row['skCotizacionServicio'];
                    foreach($row['skServicioInventario'] AS $rowServicio){
                      
                        $this->vent['skServicioInventario'] = $rowServicio; 
                        
                        $stpCUD_serviciosInventario = parent::stpCUD_serviciosInventario();
                        if(!$stpCUD_serviciosInventario || isset($stpCUD_serviciosInventario['success']) && $stpCUD_serviciosInventario['success'] != 1){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA COTIZACION';
                            return $this->data;
                        }

                    }
                }else{
                    $this->vent['fCantidad'] = number_format($row['fCantidad'],2);
                    $this->vent['skCotizacionServicio'] = NULL;
                    $this->vent['skServicioInventario'] = NULL;
                    $this->vent['iDetalle'] = NULL;
                    $this->vent['skServicio'] = $row['skServicio'];
                    $stpCUD_serviciosInventario = parent::stpCUD_serviciosInventario();
                    if(!$stpCUD_serviciosInventario || isset($stpCUD_serviciosInventario['success']) && $stpCUD_serviciosInventario['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA COTIZACION';
                        return $this->data;
                    }
                }
            }  
        }
          
 

          $this->data['success'] = TRUE;
          $this->data['message'] = 'DATOS DE COTIZACION GUARDADOS';
          return $this->data;
      }

      /**
       * generar_orden
       *
       * Guardar generar_orden
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function generar_orden(){
        $this->data['success'] = TRUE;
        $this->vent['axn'] = 'generar_orden';
        $this->vent['skVenta'] = NULL;
 

        $generarOrden = $this->sysAPI('admi', 'orse_inde', 'generarOrden', [
            'POST'=>[
                'axn'=>'GE',
                'skProceso'=>'VENT',
                'skCodigo'=>$this->vent['skCotizacion']
            ]
        ]); 
        if(!$generarOrden || isset($generarOrden['success']) && $generarOrden['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = $generarOrden['message'];
            return $this->data;
        }

        


        $this->data['success'] = TRUE;
        $this->data['message'] = 'ORDEN GENERADA CON EXITO';
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
              'skCotizacion'=>['message'=>'COTIZACION']
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
     /**
     * get_empresas
     *
     * Obtener Empresas
     *
     * @author Luis Valdez <lvaldez@woodward.com.mx>
     * @return Array EmpresasSocios
     */
    public function get_serviciosInventario(){
        $this->vent['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        $this->vent['skServicio'] = (isset($_POST['skServicio']) ? $_POST['skServicio'] : NULL);
        
        return parent::get_serviciosInventario();
    }
    

  
 
    


     
}
