<?php
Class Cita_deta_Controller Extends Cita_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_deta';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

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