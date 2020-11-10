<?php
/**
 *  Clase controlador de detallas de grupos
 * 
 *  Esta clase es el controlador de la vista grup_deta.php
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
Class Grup_deta_Controller Extends Empr_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    /** @var array Contiene los datos que se requieran en esta clase */
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
        $this->data = $this->consultarGrupo();
        ob_start();
        $this->load_view('grup_deta',$this->data, NULL, FALSE);
        $content = ob_get_contents();
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
    
    /**
     * Consultar grupo  
     * 
     * Esta funcion obtiene la informacion de un grupo basado en ID, obtenido por
     * el p1 a travez de GET
     * 
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return object Objeto mssql de resultado.
     */
    public function consultarGrupo(){
        if (isset($_GET['p1'])) {
            $this->grupo['skGrupo'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_grupo();
            $this->data['grupo_empresas'] = parent::consultar_empresasGrupo(FALSE);
            return $this->data;
        }
        return false;
    }
}
