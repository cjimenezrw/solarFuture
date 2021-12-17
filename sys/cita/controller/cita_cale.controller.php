<?php
Class Cita_cale_Controller Extends Cita_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_cale';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cita['sClaveCategoriaCita'] = (isset($_POST['sClaveCategoriaCita']) ? $_POST['sClaveCategoriaCita'] : NULL);
        $this->cita['skEstadoMX'] = (isset($_POST['skEstadoMX']) ? $_POST['skEstadoMX'] : NULL);
        $this->cita['skMunicipioMX'] = (isset($_POST['skMunicipioMX']) ? $_POST['skMunicipioMX'] : NULL);
        $this->cita['iFiltroHistorico'] = (isset($_POST['iFiltroHistorico']) ? $_POST['iFiltroHistorico'] : 0);
        $this->cita['skEmpresaSocioCliente'] = (isset($_POST['skEmpresaSocioCliente']) ? $_POST['skEmpresaSocioCliente'] : NULL);
        $this->cita['sNombre'] = (isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL);
        $this->cita['empleado'] = (isset($_POST['empleado']) ? $_POST['empleado'] : NULL);
        
        $this->data['citas'] = parent::_get_citas([
            'skEstatus'=>['CF'],
            'sClaveCategoriaCita'=>$this->cita['sClaveCategoriaCita'],
            'skEstadoMX'=>$this->cita['skEstadoMX'],
            'skMunicipioMX'=>$this->cita['skMunicipioMX'],
            'skEmpresaSocioCliente'=>$this->cita['skEmpresaSocioCliente'],
            'sNombre'=>$this->cita['sNombre'],
            'iFiltroHistorico'=>$this->cita['iFiltroHistorico']
        ]);

        $this->data['cat_citas_categorias'] = parent::_get_cat_citas_categorias([
            'skEstatus'=>'AC'
        ]);

        $this->data['cat_estadosMX'] = parent::_get_cat_estadosMX([
            'skEstatus'=>'AC'
        ]);

        $this->data['calendario'] = [];

        foreach($this->data['citas'] AS $row){
            if(!isset($this->cita['calendario'][$row['skCita']])){
                $this->data['calendario'][$row['skCita']] = [
                    'id'=>$row['skCita'],
                    'title'=>$row['estatus']." - ".$row['sNombre']."\n\r".date('H:i:s', strtotime($row['tHoraInicio']))." - ".date('H:i:s', strtotime($row['tHoraFin'])),
                    'display'=>'background',
                    'start'=>$row['dFechaCita'],
                    'end'=>$row['dFechaCita'],
                    'color'=>$row['sColorCategoria'],
                    'skModulo'=>'cita-deta',
                    'sURL'=>'/'.DIR_PATH.'sys/cita/cita-deta/detalles-cita/'.$row['skCita'].'/'
                ];
            }

            $index = array_search($row['sClaveCategoriaCita'],array_column($this->data['cat_citas_categorias'],'sClaveCategoriaCita'));
            if($index !== false){
                if(!isset($this->data['cat_citas_categorias'][$index]['iCantidadCitas'])){
                    $this->data['cat_citas_categorias'][$index]['iCantidadCitas'] = 1;
                }else{
                    $this->data['cat_citas_categorias'][$index]['iCantidadCitas'] += 1;
                }
            }

        }

        exit('<pre>'.print_r($this->data,1).'</pre>');
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

}