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

        // guardar_agendarCita 
            $guardar_cita = $this->guardar_agendarCita();
            if(!$guardar_cita['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // confirmar_cita_personal 
            $confirmar_cita_personal = $this->confirmar_cita_personal();
            if(!$confirmar_cita_personal['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        Conn::commit($this->idTran);
        $this->data['datos'] = $this->cita;
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
        $this->cita['skEstatus'] = 'CF';

        $stp_cita_agendar = parent::stp_cita_agendar();
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LA CITA';
            return $this->data;
        }

        $this->cita['skCita'] = (isset($stp_cita_agendar['skCita']) ? $stp_cita_agendar['skCita'] : NULL);

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CITA GUARDADOS';
        return $this->data;
    }

    public function confirmar_cita_personal(){
        $this->data['success'] = TRUE;

        // BORRAMOS EL PERSONAL ACTUAL DE LA CITA //
            $this->cita['axn'] = 'delete_cita_personal';
            $stp_cita_agendar = parent::stp_cita_agendar();
            if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL CONFIGURAR EL PERSONAL DE LA CITA';
                return $this->data;
            }

        // GUARDAMOS EL PERSONAL DE LA CITA //
            $this->cita['axn'] = 'confirmar_cita_personal';
            $this->cita['skEstatus'] = 'AC';
            if(!empty($this->cita['skCitaPersonal_array'])){
                foreach($this->cita['skCitaPersonal_array'] AS $k=>$v){
                    $this->cita['skUsuarioPersonal'] = $v;
                    
                    $stp_cita_agendar = parent::stp_cita_agendar();
                    if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL PERSONAL DE LA CITA';
                        return $this->data;
                    }
    
                }
            }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CITA GUARDADOS';
        return $this->data;
    }

    public function get_ordenServicio(){

        $this->cita['iFolioOrdenServicio'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $_get_ordenServicio = parent::_get_ordenServicio([
            'iFolioOrdenServicio'=>$this->cita['iFolioOrdenServicio'],
            'skEstatus'=>'AC'
        ]);

        return $_get_ordenServicio;
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
        $this->data = ['success' => TRUE, 'message' => 'MUNICIPIOS DISPONIBLES CARGADOS', 'datos' => NULL];

        $this->cita['skEstadoMX'] = (isset($_POST['skEstadoMX']) && !empty($_POST['skEstadoMX'])) ? $_POST['skEstadoMX'] : NULL;

        $this->data['cat_municipiosMX'] = parent::_get_cat_municipiosMX([
            'skEstadoMX'=>$this->cita['skEstadoMX'],
            'skEstatus'=>'AC'
        ]);

        return $this->data;
    }

    public function get_personal(){
        $this->cita['nombre'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $sql = "SELECT N1.* FROM (
            SELECT
                u.skUsuario AS id,CONCAT(u.sNombre,' ',u.sApellidoPaterno,' ',u.sApellidoMaterno) AS nombre
            FROM cat_usuarios u 
                WHERE u.skEstatus = 'AC'
            ) AS N1 WHERE 1=1 ";

        if(isset($this->cita['nombre']) && !empty(trim($this->cita['nombre']))){
            $sql .= " AND N1.nombre LIKE '%".escape($this->cita['nombre'],FALSE)."%' ";
        }

        $sql .= " LIMIT 10; ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;

    }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cita['skCita'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        $this->data['cat_citas_categorias'] = parent::_get_cat_citas_categorias([
            'skEstatus'=>'AC'
        ]);

        $this->data['cat_estadosMX'] = parent::_get_cat_estadosMX([
            'skEstatus'=>'AC'
        ]);

        if(!empty($this->cita['skCita'])){
            
            $this->data['datos'] = parent::_get_citas([
                'skCita'=>$this->cita['skCita']
            ]);

            $this->data['citas_personal'] = parent::_get_citas_personal([
                'skCita'=>$this->cita['skCita']
            ]);

            $this->data['cat_municipiosMX'] = parent::_get_cat_municipiosMX([
                'skEstadoMX'=>$this->data['datos']['skEstadoMX'],
                'skEstatus'=>'AC'
            ]);
            
            $this->cita['dFechaCita'] = (isset($this->data['datos']['dFechaCita']) && !empty($this->data['datos']['dFechaCita'])) ? date('Ymd', strtotime(str_replace('/', '-', $this->data['datos']['dFechaCita']))) : NULL;

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

        }

        //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }

}