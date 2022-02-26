<?php
Class Acpo_deta_Controller Extends Cont_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'acpo_deta';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cont['skAccessPoint'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        if(!empty($this->cont['skAccessPoint'])){
            
            $this->data['datos'] = parent::_get_accessPoint([
                'skAccessPoint'=>$this->cont['skAccessPoint']
            ]);

            $this->data['_get_contratos'] = parent::_get_contratos([
                'skAccessPoint'=>$this->cont['skAccessPoint'],
                'skEstatus'=>'AC'
            ]);

        }

        //exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }

}