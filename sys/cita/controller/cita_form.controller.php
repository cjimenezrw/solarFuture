<?php
Class Cita_form_Controller Extends Cita_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_form';

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

            $this->cita['skCita'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);  

            //exit('<pre>'.print_r($this->cita,1).'</pre>');
            
        // guardar_actaEntrega 
            $guardar_cita = $this->guardar_agendarCita();
            if(!$guardar_cita['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }
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
                    $this->cita[$key] = $val;
                    continue;
                }else{
                    $this->cita[$key] = $val;
                    continue;
                }
            }
        }

        if($_GET){
            foreach($_GET AS $key=>$val){
                if(!is_array($val)){
                    $this->cita[$key] = $val;
                    continue;
                }else{
                    $this->cita[$key] = $val;
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
        'skCategoriaCita'=>['message'=>'CATEGORÍA'],
        'dFechaCita'=>['message'=>'FECHA DE CITA','validations'=>['date']],
        'tHoraInicio'=>['message'=>'CATEGORÍA'],
        'sNombre'=>['message'=>'NOMBRE'],
        'sTelefono'=>['message'=>'TELÉFONO'],
        'sCorreo'=>['message'=>'CORREO'],
        'skEstadoMX'=>['message'=>'ESTADO'],
        'skMunicipioMX'=>['message'=>'MUNICIPIO'],
        'sDomicilio'=>['message'=>'DOMICILIO']
        ];

        foreach($validations AS $k=>$v){
            if(!isset($this->cita[$k]) || empty(trim($this->cita[$k]))){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return $this->data;
            }
            if(isset($v['validations'])){
                foreach($v['validations'] AS $valid){
                    switch ($valid) {
                        case 'integer':
                            $this->cita[$k] = str_replace(',','',$this->cita[$k]);
                            if(!preg_match('/^[0-9]+$/', $this->cita[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                return $this->data;
                            }
                        break;
                        case 'decimal':
                            $this->cita[$k] = str_replace(',','',$this->cita[$k]);
                            if(!preg_match('/^[0-9.]+$/', $this->cita[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                return $this->data;
                            }
                        break;
                        case 'date':
                            $this->cita[$k] = date('Ymd', strtotime(str_replace('/', '-', $this->cita[$k])));
                            if(!preg_match('/^[0-9\/-]+$/', $this->cita[$k])){
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

    public function guardar_agendarCita(){
        $this->data['success'] = TRUE;
        $this->cita['axn'] = 'guardar_agendarCita';
        $this->cita['skEstatus'] = 'PE';

        $stp_cita_agendar = parent::stp_cita_agendar();
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LA CITA';
            return $this->data;
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CITA GUARDADOS';
        return $this->data;
    }

    public function get_horarios_disponibles(){
        $this->data = ['success' => TRUE, 'message' => 'HORARIOS DISPONIBLES CARGADOS', 'datos' => NULL];

        $this->cita['dFechaCita'] = (isset($_POST['dFechaCita']) && !empty($_POST['dFechaCita'])) ? date('Ymd', strtotime(str_replace('/', '-', $_POST['dFechaCita']))) : NULL;

        $this->data['horarios_disponibles'] = parent::_get_horarios_disponibles([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        $this->data['horarios_descansos'] = parent::_get_horarios_descansos([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        $this->data['horarios_disponibles_excepciones'] = parent::_get_horarios_disponibles_excepciones([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        $this->data['horarios_descansos_excepciones'] = parent::_get_horarios_descansos_excepciones([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        return $this->data;
    }

    public function get_cat_municipiosMX(){
        $this->data = ['success' => TRUE, 'message' => 'HORARIOS DISPONIBLES CARGADOS', 'datos' => NULL];

        $this->cita['skEstadoMX'] = (isset($_POST['skEstadoMX']) && !empty($_POST['skEstadoMX'])) ? $_POST['skEstadoMX'] : NULL;

        $this->data['cat_municipiosMX'] = parent::_get_cat_municipiosMX([
            'skEstadoMX'=>$this->cita['skEstadoMX'],
            'skEstatus'=>'AC'
        ]);

        return $this->data;
    }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cita['skCotizacion'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        if (!empty($this->cita['skCotizacion'])) {
            
            $this->data['datos'] = parent::_getCotizacion();
            $cotizacionConceptos = parent::_getCotizacionConceptos();
            $this->data['conceptosCotizacion'] = $cotizacionConceptos;
        }

        $this->data['cat_citas_categorias'] = parent::_get_cat_citas_categorias([
            'skEstatus'=>'AC'
        ]);

        $this->data['cat_estadosMX'] = parent::_get_cat_estadosMX([
            'skEstatus'=>'AC'
        ]);

 //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }

}