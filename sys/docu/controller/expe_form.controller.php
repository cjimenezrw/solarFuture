<?php
Class Expe_form_Controller Extends Docu_Model {

    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'expe_form';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function guardar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        Conn::begin($this->idTran);

        // OBTENER DATOS DE ENTRADA
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // VALIDAR DATOS DE ENTRADA
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
//exit('<pre>'.print_r($_FILES,1).'</pre>');
//exit('<pre>'.print_r(json_decode($_POST['docu_file_OPERAT_FOTOGR'], true, 512),1).'</pre>');
            $guardar_documento = $this->sysAPI('docu', 'docu_serv', 'guardar', [
                'POST'=>[
                    'skTipoExpediente'=>'OPERAT',
                    'skTipoDocumento'=>'PEDIME',
                    'skCodigo'=>'MYUUID'
                ],
                'FILES'=>[
                    'docu_file'=>$_FILES['docu_file_OPERAT_PEDIME']
                ]
            ]);

            $guardar_documento = $this->sysAPI('docu', 'docu_serv', 'guardar', [
                'POST'=>[
                    'skTipoExpediente'=>'OPERAT',
                    'skTipoDocumento'=>'BILLLA',
                    'skCodigo'=>'MYUUID'
                ],
                'FILES'=>[
                    'docu_file'=>$_FILES['docu_file_OPERAT_BILLLA']
                ]
            ]);
            
            $guardar_documento = $this->sysAPI('docu', 'docu_serv', 'guardar', [
                'POST'=>[
                    'skTipoExpediente'=>'OPERAT',
                    'skTipoDocumento'=>'FOTOGR',
                    'skCodigo'=>'MYUUID'
                ],
                'FILES'=>[
                    'docu_file'=>$_FILES['docu_file_OPERAT_FOTOGR']
                ]
            ]);

exit('<pre>'.print_r($guardar_documento,1).'</pre>');


exit('<pre>'.print_r($_FILES,1).'</pre>');
exit('<pre>'.print_r($this->docu,1).'</pre>');

        $this->docu['skTipoExpediente'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

        // GUARDAR
            $guardar_tipoExpediente = $this->guardar_tipoExpediente();
            if(!$guardar_tipoExpediente['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // RETORNAMOS LOS RESULTADOS
            Conn::commit($this->idTran);
            $this->data['datos'] = $this->docu;
            $this->data['success'] = TRUE;
            $this->data['message'] = 'Registro guardado con éxito.';

    }

    public function guardar_tipoExpediente(){
        $this->data['success'] = TRUE;
        $this->docu['axn'] = 'guardar_tipoExpediente';

        $stp_docu_tiposExpedientes = parent::stp_docu_tiposExpedientes();

        if(!$stp_docu_tiposExpedientes || isset($stp_docu_tiposExpedientes['success']) && $stp_docu_tiposExpedientes['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR TIPO EXPEDIENTE';
            return $this->data;
        }

        $this->docu['skTipoExpediente'] = $stp_docu_tiposExpedientes['skTipoExpediente'];

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS GUARDADOS TIPO EXPEDIENTE';
        return $this->data;
    }

    public function consultar(){

    }

    /*
    * getInputData
    *
    * Obtener los datos de entrada
    *
    * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
    * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
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
                    $this->docu[$key] = $val;
                    continue;
                }else{
                    $this->docu[$key] = $val;
                    continue;
                }
            }
        }

        if($_GET){
            foreach($_GET AS $key=>$val){
                if(!is_array($val)){
                    $this->docu[$key] = $val;
                    continue;
                }else{
                    $this->docu[$key] = $val;
                    continue;
                }
            }
        }

        return $this->data;
    }

    /**
     * validar_datos_entrada
     *
     * Valida los datos de entrada
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
     */
    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        $this->data['message'] = "";


        $validations = [
            //'sNombre'=>['message'=>'NOMBRE']
        ];

        foreach($validations AS $k=>$v){
            if(!isset($this->docu[$k]) || empty(trim($this->docu[$k]))){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return $this->data;
            }
            if(isset($v['validations'])){
                foreach($v['validations'] AS $valid){
                    switch ($valid) {
                        case 'integer':
                            $this->docu[$k] = str_replace(',','',$this->docu[$k]);
                            if(!preg_match('/^[0-9]+$/', $this->docu[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                return $this->data;
                            }
                        break;
                        case 'decimal':
                            $this->docu[$k] = str_replace(',','',$this->docu[$k]);
                            if(!preg_match('/^[0-9.]+$/', $this->docu[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                return $this->data;
                            }
                        break;
                        case 'date':
                            $this->docu[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->docu[$k])));
                            if(!preg_match('/^[0-9\/-]+$/', $this->docu[$k])){
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