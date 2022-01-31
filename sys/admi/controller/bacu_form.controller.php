<?php

/**
 * Bacu_form_Controller
 *
 * Formulario de Cuentas Bancarias (bacu-form)
 *
 * @author lvaldez
 */
Class Bacu_form_Controller Extends Admi_Model {

    // CONST //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran;
        private $skPuestoGral;
        private $visionUsuario;

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_bancoCuentas'; 
    }

    public function __destruct() {

    }
    
  /**
     * guardar
     *
     * Guardar Cuenta Bancaria
     *
     * @author lvaldez
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function guardar(){
        $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>[]];
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
            
            $this->admi['skBancoCuenta'] = (isset($_POST['skBancoCuenta']) ? $_POST['skBancoCuenta'] : NULL);
            
        // Guardar el Corte de Almacenajes
            $guardar_banco_cuenta = $this->guardar_banco_cuenta();
            if(!$guardar_banco_cuenta['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
            
            $this->data['datos'] = $this->admi;
            
        Conn::commit($this->idTran);
        $this->data['datos'] = $this->admi;
        $this->data['message'] = 'CUENTA BANCARIA GUARDADA CON ÉXITO';
        return $this->data;
    }
    
  /**
     * guardar_banco
     *
     * Guardar Banco
     *
     * @author lvaldez
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function guardar_banco_cuenta(){
        $this->data['success'] = TRUE;
        $this->admi['axn'] = 'guardar_banco_cuenta';
        
        $this->admi['skEstatus'] = 'AC';
        $stpCUD_bancoCuentas = parent::stpCUD_bancoCuentas();

        if(!$stpCUD_bancoCuentas || isset($stpCUD_bancoCuentas['success']) && $stpCUD_bancoCuentas['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA CUENTA BANCARIA';
            return $this->data;
        }

        $this->admi['skBancoCuenta'] = $stpCUD_bancoCuentas['skBancoCuenta'];
        
        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE LA CUENTA BANCARIA GUARDADOS';
        return $this->data;
    }
    
    
  /**
     * get_data_banco
     *
     * Obtenemos los datos del Formulario de Banco
     *
     * @author lvaldez
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    public function get_data_bancoCuentas() {
        $this->data['success'] = TRUE;
        
        $this->admi['skBancoCuenta'] = (isset($_POST['skBancoCuenta']) ? $_POST['skBancoCuenta'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        
        $this->data['get_bancos'] = parent::_get_bancos();
        $this->data['get_divisas'] = parent::consultar_divisas();
        
        if(!empty($this->admi['skBancoCuenta'])){
            $_get_bancosCuenta = parent::_get_bancosCuenta();
            if(!$_get_bancosCuenta){
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL REGISTRO', 404);
            }
            $this->data['datos'] = $_get_bancosCuenta[0];
        }
        return $this->data;
    }
    
    /**
     * getEmpresas
     *
     * Obtener Empresas
     *
     * @author lvaldez
     * @return Array EmpresasSocios
     */
    public function getEmpresas(){
        $this->admi['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        if(isset($_POST['skEmpresaTipo']) && !empty($_POST['skEmpresaTipo'])){
            $skEmpresaTipo = json_decode($_POST['skEmpresaTipo'], true, 512);
            if(!is_array($skEmpresaTipo)){
                $skEmpresaTipo = $_POST['skEmpresaTipo'];
            }
            $this->admi['skEmpresaTipo'] = $skEmpresaTipo;
        }
        return parent::get_empresas();
    }
    
  /**
     * validar_datos_entrada
     *
     * Valida los datos del la entrada
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        
        $validations = [
            'skBanco'=>['message'=>'BANCO'],
            'skDivisa'=>['message'=>'DIVISA'],
            'sTitular'=>['message'=>'TITULAR'],
            'sNumeroCuenta'=>['message'=>'NÚMERO DE CUENTA'],
            'sClabeInterbancaria'=>['message'=>'CLABE INTERBANCARIA'],
            'sCuentaContable'=>['message'=>'CUENTA CONTABLE','validations'=>['integer']]
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
     * validarCuentaBanco
     *
     * Funcion para validar si existe la cuenta del banco
     *
     * @author lvaldez
     * @return bool
     */

    public function validarCuentaBanco(){
        $this->admi['skBancoCuenta'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        $this->admi['sNumeroCuenta'] = (isset($_POST['sNumeroCuenta']) && !empty($_POST['sNumeroCuenta'])) ? $_POST['sNumeroCuenta'] : NULL;
        $this->admi['skBanco'] = (isset($_POST['skBanco']) && !empty($_POST['skBanco'])) ? $_POST['skBanco'] : NULL;
        

        if($this->admi['sNumeroCuenta'] && $this->admi['skBanco']){
        
            $_validarDatosCuentaBancaria = parent::_validarDatosCuentaBancaria();
            if(isset($_validarDatosCuentaBancaria['sNumeroCuenta']) && !empty($_validarDatosCuentaBancaria['sNumeroCuenta'])){
                //SI YA EXISTE LA CUENTA RETORNA QUE YA EXISTE
                return ['valid'=>FALSE,'message' => 'LA CUENTA YA EXISTE'];
            }
            //SI LA CUENTA NO EXISTE
            return ['valid'=>TRUE];   

        }else{
          //SI EL BANCO NO HA SIDO SELECCIONADO
          return ['valid'=>FALSE,'message' => 'ES NECESARIO SELECCIONAR EL BANCO'];
        }
    }
    
    /**
     * validarCuentaContable
     *
     * Funcion para validar si existe el iCuentaContable.
     *
     * @author lvaldez
     * @return bool
     */
    public function validarCuentaContable(){
        $this->admi['skBancoCuenta'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        $this->admi['skBanco'] = (isset($_POST['skBanco']) && !empty($_POST['skBanco'])) ? $_POST['skBanco'] : NULL;
        $this->admi['sCuentaContable'] = (isset($_POST['sCuentaContable']) && !empty($_POST['sCuentaContable'])) ? $_POST['sCuentaContable'] : NULL;
        
        if($this->admi['sCuentaContable'] && $this->admi['skBanco']){
            $_validarDatosCuentaBancaria = parent::_validarDatosCuentaBancaria();
            if(isset($_validarDatosCuentaBancaria['sCuentaContable']) && !empty($_validarDatosCuentaBancaria['sCuentaContable'])){
                return ['valid'=>FALSE,'message' => 'LA CUENTA CONTABLE YA EXISTE'];
            }
            return ['valid'=>TRUE];            
        }else{
          //SI EL BANCO NO HA SIDO SELECCIONADO
          return ['valid'=>FALSE,'message' => 'ES NECESARIO SELECCIONAR EL BANCO'];
        }
    }
    
  /**
     * getInputData
     *
     * Obtener datos de entrada de información
     *
     * @author lvaldez
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
}
