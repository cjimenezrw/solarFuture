<?php
Class Conc_form_Controller Extends Conc_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();
    private $idTran = 'conceptos'; //Mi procedimiento

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
                Conn::rollback($this->idTran);
                return $this->data;
            }

            // Validamos los datos de entrada
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            



            $this->conc['skConcepto'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

            // Guardar Concepto
            $guardar_comprobante = $this->guardar_concepto();
            if(!$guardar_comprobante['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar impuestos Concepto
            /*$guardar_conceptos = $this->guardar_concepto_impuestos();
            if(!$guardar_conceptos['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }*/
          

        //Conn::commit($this->idTran);
        //Conn::commit($this->idTran);
        $this->data['datos'] = $this->conc;
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
      public function guardar_concepto(){
          $this->data['success'] = TRUE;
          $this->conc['axn'] = 'guardar_concepto';
          $this->conc['skEstatus'] = 'NU';

          $stpCUD_conceptos = parent::stpCUD_conceptos();
           
          if(!$stpCUD_conceptos || isset($stpCUD_conceptos['success']) && $stpCUD_conceptos['success'] != 1){
              $this->data['success'] = FALSE;
              $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DEL CONCEPTO';
              return $this->data;
          }

          $this->conc['skConcepto'] = $stpCUD_conceptos['skConcepto'];

          $this->data['success'] = TRUE;
          $this->data['message'] = 'DATOS DE CONCEPTO GUARDADOS';
          return $this->data;
      }
      /**
         * guardar_impu
         *
         * Guardar Archivos
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_concepto_impuestos(){
            $this->data['success'] = TRUE;
            $this->conc['axn'] = 'guardar_concepto_impuestos';
            
            foreach ($this->conc['Conceptos'] as $row) {
                //verificamos si ya existe el producto en el catalogo, si no existe se inserta.
                $this->conc['skImpuesto']= (!empty($row['skImpuesto']) ? $row['skImpuesto'] : NULL);
               
                $stpCUD_conceptos = parent::stpCUD_conceptos();

                if(!$stpCUD_conceptos || isset($stpCUD_conceptos['success']) && $stpCUD_conceptos['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS IMPUESTOS DEL CONCEPTO';
                    return $this->data;
                }
            }
            $this->data['success'] = TRUE;
            $this->data['message'] = 'IMPUESTOS GUARDADOS CON EXITO';
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
              'sCodigo'=>['message'=>'CODIGO'],
              'sCodigo'=>['message'=>'CODIGO']
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
        $this->data['unidadesMedida'] = parent::consultar_unidadesMedida();
        
        $impuestos = parent::getImpuestos();
          $conImpuestos= array();
          foreach($impuestos AS $k=>$v){
          $v['selected'] = 0;
          $conImpuestos[trim($v['nombre'])] = $v;
          }

        if (!empty($this->conc['skConcepto'])) {
            $this->data['datos'] = parent::_getConcepto();
            $conImpuestosConceptos = parent::_getConceptoImpuestos();
            foreach($conImpuestosConceptos AS $k=>$v){
                if(isset($conImpuestos[trim($v['nombre'])])){
                    $conImpuestos[trim($v['nombre'])]['selected'] = 1;
                }
            }
        }
        $this->data['conceptosImpuestos'] = $conImpuestos;

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
        $this->conc['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        if(isset($_POST['skEmpresaTipo']) && !empty($_POST['skEmpresaTipo'])){
            $skEmpresaTipo = json_decode($_POST['skEmpresaTipo'], true, 512);
            if(!is_array($skEmpresaTipo)){
                $skEmpresaTipo = $_POST['skEmpresaTipo'];
            }
            $this->conc['skEmpresaTipo'] = $skEmpresaTipo;
        }
        return parent::get_empresas();
    }


     
}
