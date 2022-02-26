<?php
Class Torr_deta_Controller Extends Cont_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'torr_deta';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cont['skTorre'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        if(!empty($this->cont['skTorre'])){
            
            $this->data['datos'] = parent::_get_torres([
                'skTorre'=>$this->cont['skTorre']
            ]);

            $this->data['_get_accessPoint'] = parent::_get_accessPoint([
                'skTorre'=>$this->cont['skTorre'],
                'skEstatus'=>'AC'
            ]);

        }

        //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }

}