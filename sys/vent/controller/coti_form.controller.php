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
            

            $this->vent['skCotizacion'] = (isset($_POST['skCotizacion']) ? $_POST['skCotizacion'] : NULL);  

            // REGISTRAR CLIENTE NUEVO
            $registrar_cliente = $this->registrar_cliente();
            if(!$registrar_cliente['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            if(empty($this->vent['skEmpresaSocioCliente']) && empty($this->vent['skProspecto'])){
                Conn::rollback($this->idTran);
                $this->data['success'] = FALSE;
                $this->data['message'] = 'EL CLIENTE O PROSPECTO ES REQUERIDO';

                return $this->data;
            }

            // Guardar cotizacion
            $guardar_cotizacion = $this->guardar_cotizacion();
            if(!$guardar_cotizacion['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar correos
            $guardar_cotizacion_correos = $this->guardar_cotizacion_correos();
            if(!$guardar_cotizacion_correos['success']){
               Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar impuestos Concepto
            $guardar_cotizacion_servicios = $this->guardar_cotizacion_servicios();
            if(!$guardar_cotizacion_servicios['success']){
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

    public function registrar_cliente(){

        $validarEmpresaSocio = $this->sysAPI('empr','emso_form','validarEmpresaSocio',[
            'POST'=>[
                'sRFC'=>$this->vent['sRFC'],
                'skEmpresaTipo'=>'CLIE'
            ]
        ]);

        if(!empty($validarEmpresaSocio['skEmpresaSocio'])){
            $this->vent['skEmpresaSocioCliente'] = $validarEmpresaSocio['skEmpresaSocio'];
            $this->data['success'] = TRUE;
            $this->data['message'] = 'CLIENTE EXISTENTE';
            return $this->data;
        }

        if(isset($this->vent['skEmpresaSocioCliente']) || !empty($this->vent['skEmpresaSocioCliente'])){
            $this->data['success'] = TRUE;
            $this->data['message'] = 'CLIENTE EXISTENTE';
            return $this->data;
        }

        $registrar_cliente = $this->sysAPI('empr','emso_form','guardar',[
            'POST'=>[
                'sRFC'=>$this->vent['sRFC'],
                'sNombre'=>$this->vent['sRazonSocial'],
                'sNombreCorto'=>$this->vent['sRazonSocial'],
                'skEstatus'=>'AC',
                'skEmpresaTipo'=>'CLIE',
            ]
        ]);
        
        if(!empty($registrar_cliente['skEmpresaSocio'])){
            $this->vent['skEmpresaSocioCliente'] = $registrar_cliente['skEmpresaSocio'];
            $this->data['success'] = TRUE;
            $this->data['message'] = 'CLIENTE REGISTRADO';
            return $this->data;
        }else{
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL REGISTRAR EL CLIENTE';
            return $this->data; 
        }
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
         * guardar_cotizacion_servicios
         *
         * Guardar Archivos
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_cotizacion_servicios(){
            $this->data['success'] = TRUE;
            $this->vent['axn'] = 'guardar_cotizacion_servicios';
          
            $delete="DELETE FROM rel_cotizaciones_servicios WHERE skCotizacion = '". $this->vent['skCotizacion'] ."'";
            $result = Conn::query($delete);
    
            if(!empty($this->vent['servicios'])){
                foreach ($this->vent['servicios'] AS $con){
                    $this->vent['axn'] = 'guardar_cotizacion_servicios';
                    //$this->vent['skCotizacionConcepto']           = (isset($con['skCotizacionConcepto']) ? $con['skCotizacionConcepto'] : NULL);
                    $this->vent['skServicio']         = (isset($con['skServicio']) ? $con['skServicio'] : NULL);
                    $this->vent['sDescripcion']       = (isset($con['sDescripcion']) ? $con['sDescripcion'] : NULL);
                    $this->vent['skTipoMedida']       = (isset($con['skTipoMedida']) ? $con['skTipoMedida'] : NULL);
                    $this->vent['fCantidad']          = (isset($con['fCantidad']) ? str_replace(',','',$con['fCantidad']) : NULL);
                    $this->vent['fPrecioUnitario']    = (isset($con['fPrecioUnitario']) ? str_replace(',','',$con['fPrecioUnitario']) : NULL);
                    $this->vent['fImporte']    = (isset($con['fImporte']) ? str_replace(',','',$con['fImporte']) : NULL);
                    $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
    
                    if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS servicios DE LA COTIZACION';
                        return $this->data;
                    }

                    $this->vent['skCotizacionConcepto'] = $stpCUD_cotizaciones['skCotizacionConcepto'];

                    

                }
                 

            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'servicios GUARDADOS CON EXITO';
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

        if(!isset($this->vent['iClienteRegistrado']) && isset($this->vent['sRFC']) && empty($this->vent['sRFC'])){
            $this->vent['sRFC'] = 'XAXX010101000';
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
        $this->vent['sClonar'] = (isset($_GET['p2']) && !empty($_GET['p2'])) ? $_GET['p2'] : NULL;
        $this->data['informacionProducto'] = parent::_getInformacionProducto();
        $this->data['terminosCondiciones'] = parent::_getTerminosCondiciones();
        $this->data['divisas'] = parent::_getDivisas();
        $this->data['categoria'] = parent::_getCategorias();
        $this->data['TARIFA'] = json_decode(parent::getVariable('TARIFA'),true,512);

        if (!empty($this->vent['skCotizacion'])) {
            
            $this->data['datos'] = parent::_getCotizacion();
            $cotizacionservicios = parent::_getCotizacionservicios();
            $this->data['cotizacionesservicios'] = $cotizacionservicios;
            $cotizacionCorreos= parent::_getCotizacionCorreos();
            $this->data['cotizacionesCorreos'] = $cotizacionCorreos;

            $this->data['cotizacionInformacionProducto'] = parent::_getCotizacionInformacionProducto();
            $this->data['cotizacionTerminosCondiciones'] = parent::_getCotizacionTerminosCondiciones();

            if(!empty($this->vent['sClonar'])){
                $this->data['datos']['skCotizacion'] = NULL;
                $this->data['datos']['skCotizacion'] = NULL;
            }
            
            

            
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

    /**
     * get_empresasProspecto
     *
     * Obtener Empresas
     *
     * @author Luis Valdez <lvaldez@woodward.com.mx>
     * @return Array EmpresasSocios
     */
    public function get_empresasProspectos(){
        $this->vent['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
         
        return parent::get_empresasProspectos();
    }
    
    public function get_medidas(){
        return parent::consultar_tiposMedidas();
    }
    public function get_servicios(){
        return parent::consultar_servicios();
    }
    public function get_servicios_impuestos(){
        $this->vent['skServicio'] = (isset($_POST['skServicio']) ? $_POST['skServicio'] : NULL);
        return parent::consultar_servicios_impuestos();
  
    }
    public function get_servicios_datos(){
        $this->vent['skServicio'] = (isset($_POST['skServicio']) ? $_POST['skServicio'] : NULL);
        $this->vent['skCategoriaPrecio'] = (isset($_POST['skCategoriaPrecio']) ? $_POST['skCategoriaPrecio'] : NULL);
       
        return parent::consultar_servicios_datos();
  
    }
    


     
}
