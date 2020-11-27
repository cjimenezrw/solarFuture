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

            



            $this->vent['skCotizacion'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

            
            // Guardar Concepto
            $guardar_cotizacion = $this->guardar_cotizacion();
            if(!$guardar_cotizacion['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar impuestos Concepto
            $guardar_cotizacion_conceptos = $this->guardar_cotizacion_conceptos();
            if(!$guardar_cotizacion_conceptos['success']){
               // Conn::rollback($this->idTran);
                return $this->data;
            }
          

        //Conn::commit($this->idTran);
        //Conn::commit($this->idTran);
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
          
            $delete="DELETE FROM rel_cotizaciones_conceptos WHERE skCotizacion = '". $this->coti['skCotizacion'] ."'";
            $result = Conn::query($delete);
            if(!empty($this->vent['skConcepto'])){
                foreach ($this->vent['skConcepto'] as $k => $v) {
                    //verificamos si ya existe el producto en el catalogo, si no existe se inserta.
                    $this->vent['skCotizacionConcepto']= (!empty($v) ? $v : NULL);
                   
                    $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();
    
                    if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS CONCEPTOS DE LA COTIZACION';
                        return $this->data;
                    }
                }

            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'CONCEPTOS GUARDADOS CON EXITO';
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
              'skEmpresaSocioCliente'=>['message'=>'CLIENTE']
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
            $cotizacionConceptos = parent::_getCotizacionConceptos();
            $this->data['cotizacionesConceptos'] = $cotizacionConceptos;
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


     
}
