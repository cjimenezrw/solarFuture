  <?php

Class Conc_deta_Controller Extends Conc_Model {
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

        $this->conc['skConcepto'] = $_GET['p1'];
        $this->data['datos'] =  parent::_getConcepto();
        $this->data['conceptosImpuestos']  = parent::_getConceptoImpuestos();

        // OBTENEMOS LAS CATEGORÍAS DE PRECIOS
            //$_get_categorias_precios = parent::_get_categorias_precios();
            $_get_categorias_precios = parent::getCatalogoSistema(['skCatalogoSistema'=>'CATPRE']);
            $this->data['categorias_precios'] = [];
            foreach($_get_categorias_precios AS $k=>$v){
                $this->data['categorias_precios'][$v['skCatalogoSistemaOpciones']] = $v;
            }

        //OBTENEMOS LOS VALORES DE CATEGORÍAS DE PRECIOS
            $_get_conceptos_precios = parent::_get_conceptos_precios();
            foreach($_get_conceptos_precios AS $k=>$v){
                $this->data['categorias_precios'][$v['skCategoriaPrecio']]['fPrecioVenta'] = $v['fPrecioVenta'];
            }
            
        return $this->data;
    }

}
