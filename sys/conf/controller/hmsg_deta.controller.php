<?php
/**
 * 
 */
Class Hmsg_deta_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    //use AutoCompleteTrait;
    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    
    /**
     * Crear pdf
     * 
     * Esta funcion crea el array para usar la funcion pdf de DLOREAN.Functions
     * 
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     */
    public function crearPDF(){
        $this->data['datos'] = $this->consultarRegistroMsg();
        ob_start();
        $this->load_view('hmsg_deta',$this->data, NULL, FALSE);
        $content = ob_get_contents();
        ob_end_clean();
        parent::pdf(array(
            'waterMark'     => array(
                'imgsrc'    => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
                'opacity'   => .14,
                'size'      => [100,90]
            ),
            'content' => $content,
            'header' => '<div class="pdf_cabecera">
                        <div class="pdf_left"><img style=""  src="' . CORE_PATH . 'assets/tpl/images/logoPDF.png" width="50" height="50"></div>
                        <div class="pdf_centro">
                          <h3>Detalles del correo</h3>
                        </div>
                        <div class="leFlotar"></div>
                      </div>',
            'footer' => false,
            'pdf' => array(
                'contentMargins'=>[10,10,25,25],
                'format'  => 'LETTER',
                'vertical' => false,
                'footerMargin' => 5,
                'headerMargin' => 5,
            )
        ));

    }
    public function consultarRegistroMsg(){
        if (isset($_GET['p1'])) {
            $this->msgHist['skMensaje'] = $_GET['p1'];
            return parent::consulta_mensaje();
        }
        return false;
    }
    
}
