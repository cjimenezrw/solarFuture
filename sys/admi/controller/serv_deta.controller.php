  <?php

Class Serv_deta_Controller Extends Admi_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consultar(){

        $this->admi['skServicio'] = $_GET['p1'];
        $this->data['datos'] =  parent::_getServicio();
        $this->data['serviciosImpuestos']  = parent::_getServicioImpuestos(); 
        

        // OBTENEMOS LAS CATEGORÍAS DE PRECIOS
            $_get_categorias_precios = parent::getCatalogoSistema(['skCatalogoSistema'=>'CATPRE']);
            $this->data['categorias_precios'] = [];
            foreach($_get_categorias_precios AS $k=>$v){
                $this->data['categorias_precios'][$v['skCatalogoSistemaOpciones']] = $v;
            }

        //OBTENEMOS LOS VALORES DE CATEGORÍAS DE PRECIOS
            $_get_servicios_precios = parent::_get_servicios_precios();
            foreach($_get_servicios_precios AS $k=>$v){
                $this->data['categorias_precios'][$v['skCategoriaPrecio']]['fPrecio'] = $v['fPrecio'];
            }
            
        return $this->data;
    }

}
