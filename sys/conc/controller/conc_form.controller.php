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

            
            // Guardar Concepto
            $guardar_comprobante = $this->guardar_concepto();
            if(!$guardar_comprobante['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar impuestos Concepto
            $guardar_concepto_impuestos = $this->guardar_concepto_impuestos();
            if(!$guardar_concepto_impuestos['success']){
               // Conn::rollback($this->idTran);
                return $this->data;
            }

            // Guardar Categorías Precios
            $guardar_concepto_precios = $this->guardar_concepto_precios();
            if(!$guardar_concepto_precios['success']){
               // Conn::rollback($this->idTran);
                return $this->data;
            }
          
            
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
          
            $delete="DELETE FROM rel_conceptos_impuestos WHERE skConcepto = '". $this->conc['skConcepto'] ."'";
            $result = Conn::query($delete);
            if(!empty($this->conc['skImpuesto'])){
                foreach ($this->conc['skImpuesto'] as $k => $v) {
                    //verificamos si ya existe el producto en el catalogo, si no existe se inserta.
                    $this->conc['skImpuestoConcepto']= (!empty($v) ? $v : NULL);
                   
                    $stpCUD_conceptos = parent::stpCUD_conceptos();
    
                    if(!$stpCUD_conceptos || isset($stpCUD_conceptos['success']) && $stpCUD_conceptos['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS IMPUESTOS DEL CONCEPTO';
                        return $this->data;
                    }
                }

            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'IMPUESTOS GUARDADOS CON EXITO';
            return $this->data;
        }

        /**
         * guardar_concepto_precios
         *
         * Guardar Precios de Concepto
         *
         * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
         * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
         */
        public function guardar_concepto_precios(){
            $this->data['success'] = TRUE;
            $this->conc['axn'] = 'guardar_concepto_precios';
          
            $delete = "DELETE FROM rel_conceptos_precios WHERE skConcepto = ".escape($this->conc['skConcepto']);
            $result = Conn::query($delete);

            if(!empty($this->conc['CATPRE'])){
                foreach ($this->conc['CATPRE'] AS $k => $v) {
                    if(!empty($v)){
                        $this->conc['skCategoriaPrecio']= $k;
                        $this->conc['fPrecioVenta']= $v;

                        $stpCUD_conceptos = parent::stpCUD_conceptos();
        
                        if(!$stpCUD_conceptos || isset($stpCUD_conceptos['success']) && $stpCUD_conceptos['success'] != 1){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS PRECIOS DEL CONCEPTO';
                            return $this->data;
                        }
                    }
                }
            }
            
            $this->data['success'] = TRUE;
            $this->data['message'] = 'PRECIOS GUARDADOS CON EXITO';
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
        $this->conc['skConcepto'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        $this->data['unidadesMedida'] = parent::consultar_unidadesMedida();

        // OBTENEMOS LAS CATEGORÍAS DE PRECIOS
            //$_get_categorias_precios = parent::_get_categorias_precios();
            $_get_categorias_precios = parent::getCatalogoSistema(['skCatalogoSistema'=>'CATPRE']);
            $this->data['categorias_precios'] = [];
            foreach($_get_categorias_precios AS $k=>$v){
                $this->data['categorias_precios'][$v['skCatalogoSistemaOpciones']] = $v;
            }

        // OBTENEMOS LAS CATEGORÍAS DE PRECIOS
            $this->data['categorias_producto'] = parent::getCatalogoSistema(['skCatalogoSistema'=>'CATPRO']);

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

            //OBTENEMOS LOS VALORES DE CATEGORÍAS DE PRECIOS
                $_get_conceptos_precios = parent::_get_conceptos_precios();
                foreach($_get_conceptos_precios AS $k=>$v){
                    $this->data['categorias_precios'][$v['skCategoriaPrecio']]['fPrecioVenta'] = $v['fPrecioVenta'];
                }
        }
        $this->data['conceptosImpuestos'] = $conImpuestos;

        // OBTENEMOS EL CATÁLOGO DE INFORMACIÓN DE PRODUCTO
            $this->data['informacionProductoServicio'] = parent::_get_informacionProductoServicio();
        
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
