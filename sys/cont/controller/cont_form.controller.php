<?php
Class Cont_form_Controller Extends Cont_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'Cont_form_Controller';

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function guardar() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        Conn::begin($this->idTran);

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

            $this->cont['skContrato'] = (isset($_POST['skContrato']) ? $_POST['skContrato'] : NULL);  
        
            // Guardar contrato
            $guardar_contrato = $this->guardar_contrato();
            if(!$guardar_contrato['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        Conn::commit($this->idTran);
        $this->data['datos'] = $this->cont;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'REGISTRO GUARDADO CON ÉXITO';
       
        return $this->data;
    }
    
    public function guardar_contrato(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->data['success'] = TRUE;
        $this->cont['axn'] = 'guardar';
        $this->cont['skEstatus'] = 'AC';

        $stpCUD_contratos = parent::stpCUD_contratos();
        
        if(!$stpCUD_contratos || isset($stpCUD_contratos['success']) && $stpCUD_contratos['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS GENERALES DEL CONTRATO';
            return $this->data;
        }

        $this->cont['skContrato'] = $stpCUD_contratos['skContrato'];

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CONTRATO GUARDADO CON EXITO';
        return $this->data;
    }

    private function validar_datos_entrada(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        
        $validations = [

        ];

        foreach($validations AS $k=>$v){
            
            if(!isset($this->cont[$k]) || empty(trim($this->cont[$k]))){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return $this->data;
            }

            if(isset($v['validations'])){
                foreach($v['validations'] AS $valid){
                    switch ($valid) {
                        case 'integer':
                            $this->cont[$k] = str_replace(',','',$this->cont[$k]);
                            if(!preg_match('/^[0-9]+$/', $this->cont[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                return $this->data;
                            }
                        break;
                        case 'decimal':
                            $this->cont[$k] = str_replace(',','',$this->cont[$k]);
                            if(!preg_match('/^[0-9.]+$/', $this->cont[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                return $this->data;
                            }
                        break;
                        case 'date':
                            $this->cont[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->cont[$k])));
                            if(!preg_match('/^[0-9\/-]+$/', $this->cont[$k])){
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
                    $this->cont[$key] = $val;
                    continue;
                }else{
                    $this->cont[$key] = $val;
                    continue;
                }
            }
        }

        if($_GET){
            foreach($_GET AS $key=>$val){
                if(!is_array($val)){
                    $this->cont[$key] = $val;
                    continue;
                }else{
                    $this->cont[$key] = $val;
                    continue;
                }
            }
        }

        return $this->data;
    }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cont['skContrato'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        $this->data['tipoPeriodo'] = parent::_getTiposPeriodos();
        $this->data['formaPago'] = parent::consultar_formasPago();
        $this->data['metodoPago'] = parent::consultar_metodosPago();
        $this->data['usoCFDI'] = parent::consultar_usosCFDI(); 
        
        if(!empty($this->cont['skContrato'])){
            $this->data['datos'] = parent::_get_contratos();
        }
        return $this->data;
    }

    public function get_empresas(){
        $this->cont['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        if(isset($_POST['skEmpresaTipo']) && !empty($_POST['skEmpresaTipo'])){
            $skEmpresaTipo = json_decode($_POST['skEmpresaTipo'], true, 512);
            if(!is_array($skEmpresaTipo)){
                $skEmpresaTipo = $_POST['skEmpresaTipo'];
            }
            $this->cont['skEmpresaTipo'] = $skEmpresaTipo;
        }
        return parent::get_empresas();
    }

}