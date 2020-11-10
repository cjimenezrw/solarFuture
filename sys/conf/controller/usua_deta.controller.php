<?php

Class Usua_deta_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultarUsuario(){
        if (isset($_GET['p1'])) {
            $this->usuario['skUsuario'] = $_GET['p1'];
            return parent::consulta_usuario();
        }
        return false;
    }
    
    public function crearPDF(){
        $this->data['datos'] = $this->consultarUsuario();
        ob_start();
        $this->load_view('usua_deta',$this->data, NULL, FALSE);
        $content = ob_get_contents();
        //exit('<pre>'.print_r($content,1).'</pre>');
        ob_end_clean();
        parent::pdf(array(
            'waterMark'     => array(
                'imgsrc'    => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
                'opacity'   => .14,
                'size'      => [100,90]
            ),
            'content' => $content,
            'header' => false,
            'footer' => false,
            'pdf' => array(
                'contentMargins'=>[10,10,25,25],
                'format'  => 'LETTER',
                'vertical' => true,
                'footerMargin' => 5,
                'headerMargin' => 5,
            )
        ));
        
    }
}
