<?php
Class Coti_form_Controller Extends Vent_Model {

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
            $this->vent['skCotizacion'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);  
            // Guardar cotizacion
            $guardar_cotizacion = $this->guardar_cotizacion();
            if(!$guardar_cotizacion['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
            if(empty($this->vent['skEmpresaSocioCliente']) && empty($this->vent['skProspecto'])){
                Conn::rollback($this->idTran);
                $this->data['success'] = FALSE;
                $this->data['message'] = 'EL CLIENTE O PROSPECTO ES REQUERIDO';

                return $this->data;
            }

            // Guardar correos
            $guardar_cotizacion_correos = $this->guardar_cotizacion_correos();
            if(!$guardar_cotizacion_correos['success']){
               Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar impuestos Concepto
            $guardar_cotizacion_conceptos = $this->guardar_cotizacion_conceptos();
            if(!$guardar_cotizacion_conceptos['success']){
               Conn::rollback($this->idTran);
                return $this->data;
            }
            // Guardar informacion Producto
            $guardar_cotizacion_productosServicios = $this->guardar_cotizacion_productosServicios();
            if(!$guardar_cotizacion_productosServicios['success']){
               Conn::rollback($this->idTran);
                return $this->data;
            }

             // Guardar terminos Condiciones
             $guardar_cotizacion_terminosCondiciones= $this->guardar_cotizacion_terminosCondiciones();
             if(!$guardar_cotizacion_terminosCondiciones['success']){
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
       * guardar_comprobante
       *
       * Guardar Comprobante
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function guardar_cotizacion(){
          $this->data['success'] = TRUE;
          $this->vent['axn'] = 'guardar_cotizacion';
          $this->vent['skEstatus'] = 'NU';
            /*echo "<PRE>";
            print_r($this->vent);
            die();*/

          $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
           
          if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
              $this->data['success'] = FALSE;
              $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA COTIZACION';
              return $this->data;
          }

          $this->vent['skCotizacion'] = $stpCUD_cotizaciones['skCotizacion'];

          $this->data['success'] = TRUE;
          $this->data['message'] = 'DATOS DE COTIZACION GUARDADOS';
          return $this->data;
      }
      /**
         * guardar_cotizacion_correos
         *
         * Guardar correos
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_cotizacion_correos(){
            $this->data['success'] = TRUE;
            $this->vent['axn'] = 'guardar_cotizacion_correo';
          
            $delete="DELETE FROM rel_cotizaciones_correos WHERE skCotizacion = '". $this->vent['skCotizacion'] ."'";
            $result = Conn::query($delete);
           
            if(!empty($this->vent['sCorreos'])){
                foreach ($this->vent['sCorreos'] AS $correo){
                    $this->vent['axn'] = 'guardar_cotizacion_correo';
                    $this->vent['sCorreo']         = (!empty($correo) ? $correo : NULL);         
                     $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
                    if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS CORREOS DE LA COTIZACION';
                        return $this->data;
                    }
                }
            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'CORREO GUARDADOS CON EXITO';
            return $this->data;
        }
      /**
         * guardar_cotizacion_conceptos
         *
         * Guardar Archivos
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_cotizacion_conceptos(){
            $this->data['success'] = TRUE;
            $this->vent['axn'] = 'guardar_cotizacion_conceptos';
          
            $delete="DELETE FROM rel_cotizaciones_conceptos WHERE skCotizacion = '". $this->vent['skCotizacion'] ."'";
            $result = Conn::query($delete);
            $delete="DELETE FROM rel_cotizaciones_conceptosImpuestos WHERE skCotizacion = '". $this->vent['skCotizacion'] ."'";
            $result = Conn::query($delete);
            if(!empty($this->vent['conceptos'])){
                foreach ($this->vent['conceptos'] AS $con){
                    $this->vent['axn'] = 'guardar_cotizacion_conceptos';
                    //$this->vent['skCotizacionConcepto']           = (isset($con['skCotizacionConcepto']) ? $con['skCotizacionConcepto'] : NULL);
                    $this->vent['skConcepto']         = (isset($con['skConcepto']) ? $con['skConcepto'] : NULL);
                    $this->vent['skTipoMedida']       = (isset($con['skTipoMedida']) ? $con['skTipoMedida'] : NULL);
                    $this->vent['fCantidad']          = (isset($con['fCantidad']) ? str_replace(',','',$con['fCantidad']) : NULL);
                    $this->vent['fPrecioUnitario']    = (isset($con['fPrecioUnitario']) ? str_replace(',','',$con['fPrecioUnitario']) : NULL);
                    $this->vent['fImpuestosTrasladados']    = (isset($con['fImpuestosTrasladados']) ? str_replace(',','',$con['fImpuestosTrasladados']) : NULL);
                    $this->vent['fImpuestosRetenidos']    = (isset($con['fImpuestosRetenidos']) ? str_replace(',','',$con['fImpuestosRetenidos']) : NULL);
                    $this->vent['fImporte']    = (isset($con['fImporte']) ? str_replace(',','',$con['fImporte']) : NULL);
                    $this->vent['fDescuento']    = (isset($con['fDescuento']) ? str_replace(',','',$con['fDescuento']) : NULL);
                    $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
    
                    if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS CONCEPTOS DE LA COTIZACION';
                        return $this->data;
                    }

                    $this->vent['skCotizacionConcepto'] = $stpCUD_cotizaciones['skCotizacionConcepto'];

                    if(!empty($this->vent['fImpuestosTrasladados'])){
                            $this->vent['axn'] = "guardar_cotizacion_conceptosImpuestos";
                            $this->vent['fImporte']        = (isset($this->vent['fImpuestosTrasladados']) ? str_replace(',','',$this->vent['fImpuestosTrasladados']) : NULL);
                            $this->vent['skImpuesto'] = "TRAIVA";
                           
                            $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
                            if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                                return $this->data;
                            }
                    }
                    if(!empty($this->vent['fImpuestosRetenidos'])){
                            $this->vent['axn'] = "guardar_cotizacion_conceptosImpuestos";
                            $this->vent['fImporte']        = (isset($this->vent['fImpuestosRetenidos']) ? str_replace(',','',$this->vent['fImpuestosRetenidos']) : NULL);
                            $this->vent['skImpuesto'] = "RETIVA";
                            $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
                            if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL CONCEPTO.';
                                return $this->data;
                            }
                    }

                }
                 

            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'CONCEPTOS GUARDADOS CON EXITO';
            return $this->data;
        }

         /**
         * guardar_cotizacion_productosServicios
         *
         * Guardar productosServicios
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_cotizacion_productosServicios(){
            $this->data['success'] = TRUE;
            $this->vent['axn'] = 'guardar_cotizacion_informacionProductos';
          
            $delete="DELETE FROM rel_cotizacion_informacionProducto WHERE skCotizacion = '". $this->vent['skCotizacion'] ."'";
            $result = Conn::query($delete);
           
            if(!empty($this->vent['skInformacionProductosServicios'])){
            

                foreach ($this->vent['skInformacionProductosServicios'] AS $informacionProducto){
                    $this->vent['axn'] = 'guardar_cotizacion_informacionProductos';
                    $this->vent['skInformacionProductoServicio']         = (!empty($informacionProducto) ? $informacionProducto : NULL);         
                     $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
                    if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE  LA INFORMACION PRODUCTOS';
                        return $this->data;
                    }
                }
            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'INFORMACION PRODUCTO GUARDADOS CON EXITO';
            return $this->data;
        }
        /**
         * guardar_cotizacion_terminosCondiciones
         *
         * Guardar productosServicios
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_cotizacion_terminosCondiciones(){
            $this->data['success'] = TRUE;
            $this->vent['axn'] = 'guardar_cotizacion_terminosCondiciones';
          
            $delete="DELETE FROM rel_cotizaciones_terminosCondiciones WHERE skCotizacion = '". $this->vent['skCotizacion'] ."'";
            $result = Conn::query($delete);
           
            if(!empty($this->vent['terminosCondiciones'])){
            

                foreach ($this->vent['terminosCondiciones'] AS $terminosCondiciones){
                    $this->vent['axn'] = 'guardar_cotizacion_terminosCondiciones';
                    $this->vent['skCatalogoSistemaOpciones']         = (!empty($terminosCondiciones) ? $terminosCondiciones : NULL);         
                     $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
                    if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE  LA TERMINOS CONDICIONES';
                        return $this->data;
                    }
                }
            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'TERMINOS CONDICIONES GUARDADOS CON EXITO';
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
              'skDivisa'=>['message'=>'DIVISA'],
              'dFechaVigencia'=>['message'=>'VIGENCIA','validations'=>['date']]
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
        $this->data['informacionProducto'] = parent::_getInformacionProducto();
        $this->data['terminosCondiciones'] = parent::_getTerminosCondiciones();
        $this->data['divisas'] = parent::_getDivisas();

        if (!empty($this->vent['skCotizacion'])) {
            $this->data['datos'] = parent::_getCotizacion();
            $cotizacionConceptos = parent::_getCotizacionConceptos();
            $this->data['cotizacionesConceptos'] = $cotizacionConceptos;
            $cotizacionCorreos= parent::_getCotizacionCorreos();
            $this->data['cotizacionesCorreos'] = $cotizacionCorreos;

            $this->data['cotizacionInformacionProducto'] = parent::_getCotizacionInformacionProducto();
            $this->data['cotizacionTerminosCondiciones'] = parent::_getCotizacionTerminosCondiciones();
            
            

            
        }
 
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
    public function get_empresas(){
        $this->vent['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        if(isset($_POST['skEmpresaTipo']) && !empty($_POST['skEmpresaTipo'])){
            $skEmpresaTipo = json_decode($_POST['skEmpresaTipo'], true, 512);
            if(!is_array($skEmpresaTipo)){
                $skEmpresaTipo = $_POST['skEmpresaTipo'];
            }
            $this->vent['skEmpresaTipo'] = $skEmpresaTipo;
        }
        return parent::get_empresas();
    }
    /**
     * get_prospectos
     *
     * Obtener prospectos
     *
     * @author Luis Valdez <lvaldez@woodward.com.mx>
     * @return Array EmpresasSocios
     */
    public function get_prospectos(){
        $this->vent['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        
        return parent::get_prospectos();
    }

    
    public function get_medidas(){
        return parent::consultar_tiposMedidas();
    }
    public function get_conceptos(){
        return parent::consultar_conceptos();
    }
    public function get_conceptos_impuestos(){
        $this->vent['skConcepto'] = (isset($_POST['skConcepto']) ? $_POST['skConcepto'] : NULL);
        return parent::consultar_conceptos_impuestos();
  
    }
    public function get_conceptos_datos(){
        $this->vent['skConcepto'] = (isset($_POST['skConcepto']) ? $_POST['skConcepto'] : NULL);
        return parent::consultar_conceptos_datos();
  
    }
    


     
}
