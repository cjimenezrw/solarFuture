<?php
Class Pros_form_Controller Extends Empr_Model{
    // CONST //

    // PUBLIC VARIABLES //
        public $prospectos = [];

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'stp_prospectos';

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    
    public function guardar(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];

        // Obtener los datos de entrada //
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                return $this->data;
            }

        // Validar los datos de entrada //
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                return $this->data;
            }

        $this->prospectos['skProspecto'] = !empty($_GET['p1']) ? $_GET['p1'] : NULL;
        Conn::begin($this->idTran);

        $this->prospectos['axn'] = 'guardar';
        $stp_prospectos = parent::stp_prospectos();
        if(is_array($stp_prospectos) && isset($stp_prospectos['success']) && $stp_prospectos['success'] == false){
            Conn::rollback($this->idTran);
            return $stp_prospectos;
        }
        
        Conn::commit($this->idTran);
        $this->data['datos'] = $stp_prospectos;
        $this->data['message'] = 'GUARDADO CON ÉXITO';
        return $this->data;
    }

    public function consultar(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];
        $params = [];
        $params['skProspecto'] = (!empty($_GET['p1']) ? $_GET['p1'] : NULL);
        if(empty($params['skProspecto'])){
            return $this->data;
        }
        $_get_prospecto = parent::_get_prospecto([
            'skProspecto'=>$params['skProspecto']
        ]);
        if(is_array($_get_prospecto) && isset($_get_prospecto['success']) && $_get_prospecto['success'] == false){
            DLOREAN_Model::showError('REGISTRO NO ENCONTRADO',404);
        }
        $this->data['datos'] = $_get_prospecto;
        return $this->data;
    }

    /**
     * getInputData
     *
     * Obtener los datos de entrada
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return Boolean TRUE | FALSE
     */
    private function getInputData(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];
        
        if(!$_POST && !$_GET){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'NO SE RECIBIERON DATOS';
            return $this->data;
        }

        if($_POST){
            foreach($_POST AS $key=>$val){
                if(!is_array($val)){
                    $this->prospectos[$key] = $val;
                    continue;
                }else{
                    $this->prospectos[$key] = $val;
                    continue;
                }
            }
        }

        if($_GET){
            foreach($_GET AS $key=>$val){
                if(!is_array($val)){
                    $this->prospectos[$key] = $val;
                    continue;
                }else{
                    $this->prospectos[$key] = $val;
                    continue;
                }
            }
        }

        return $this->data;
    }

    /**
     * validar_datos_entrada
     *
     * Validar los datos de entrada
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return Boolean TRUE | FALSE
     */
    private function validar_datos_entrada(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];
        
          $validations = [
              'sNombreContacto'=>['message'=>'NOMBRE CONTACTO'],
              'sCorreo'=>['message'=>'CORREO'],
              'sTelefono'=>['message'=>'TELÉFONO']
          ];

          foreach($validations AS $k=>$v){
              if(!isset($this->prospectos[$k]) || empty(trim($this->prospectos[$k]))){
                  $this->data['success'] = FALSE;
                  $this->data['message'] = $v['message'].' REQUERIDO';
                  return $this->data;
              }
              if(isset($v['validations'])){
                  foreach($v['validations'] AS $valid){
                      switch ($valid) {
                          case 'integer':
                              $this->prospectos[$k] = str_replace(',','',$this->prospectos[$k]);
                              if(!preg_match('/^[0-9]+$/', $this->prospectos[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                  return $this->data;
                              }
                          break;
                          case 'decimal':
                              $this->prospectos[$k] = str_replace(',','',$this->prospectos[$k]);
                              if(!preg_match('/^[0-9.]+$/', $this->prospectos[$k])){
                                  $this->data['success'] = FALSE;
                                  $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                  return $this->data;
                              }
                          break;
                          case 'date':
                              $this->prospectos[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->prospectos[$k])));
                              if(!preg_match('/^[0-9\/-]+$/', $this->prospectos[$k])){
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
}