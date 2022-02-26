<?php
Class Acpo_form_Controller Extends Cont_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'acpo_form';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

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

        $this->cont['skAccessPoint'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

        // Guardamos el Access Point
            $stp_accessPoint = $this->stp_accessPoint();
            if(!$stp_accessPoint['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // Validamos la MAC
            $validar_MAC = $this->validar_MAC();
            if(!$validar_MAC['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        Conn::commit($this->idTran);
        $this->data['datos'] = $this->cont;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'REGISTRO GUARDADO CON ÉXITO.';
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

    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        $this->data['message'] = "";


        $validations = [
        'sMAC'=>['message'=>'MAC'],
        'skTorre'=>['message'=>'TORRE'],
        'sNombre'=>['message'=>'NOMBRE']
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
                            $this->cont[$k] = date('Ymd', strtotime(str_replace('/', '-', $this->cont[$k])));
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

    public function stp_accessPoint(){
        $this->data['success'] = TRUE;
        $this->cont['axn'] = 'guardar_accessPoint';
        $this->cont['skEstatus'] = 'AC';

        $stp_accessPoint = parent::stp_accessPoint();
        if(!$stp_accessPoint || isset($stp_accessPoint['success']) && $stp_accessPoint['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL ACCESS POINT';
            return $this->data;
        }

        $this->cont['skAccessPoint'] = (isset($stp_accessPoint['skAccessPoint']) ? $stp_accessPoint['skAccessPoint'] : NULL);

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE ACCESS POINT GUARDADOS';
        return $this->data;
    }

    public function validar_MAC(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL, 'valid' => TRUE];

        $this->cont['skAccessPoint'] = ((isset($this->cont['skAccessPoint']) && !empty($this->cont['skAccessPoint'])) ? $this->cont['skAccessPoint'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        $this->cont['sMAC'] = (isset($_POST['sMAC']) ? $_POST['sMAC'] : (isset($_GET['sMAC']) ? $_GET['sMAC'] : NULL));

        $sql = "SELECT sMAC FROM cat_accessPoint WHERE sMAC = ".escape($this->cont['sMAC'])." AND skEstatus = 'AC'"; 
        
        if(!empty($this->cont['skAccessPoint'])){
            $sql .= " AND skAccessPoint != ".escape($this->cont['skAccessPoint']);    
        }
        
        $sql .= " LIMIT 1 ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);

        if(!empty($record)){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'LA MAC YA HA SIDO REGISTRADA';
            $this->data['valid'] = FALSE;
            return $this->data;
        }

        return $this->data;

    }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cont['skAccessPoint'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;

        $this->data['_get_torres'] = parent::_get_torres([

        ]);
        
        if(!empty($this->cont['skAccessPoint'])){
            
            $this->data['datos'] = parent::_get_accessPoint([
                'skAccessPoint'=>$this->cont['skAccessPoint']
            ]);

        }

        //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }

}