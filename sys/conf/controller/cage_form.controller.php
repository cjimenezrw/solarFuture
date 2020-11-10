<?php
Class Cage_form_Controller Extends Conf_Model{

    // CONSTANTS //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function accionesCatalogosSistema(){
        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        if ($_POST) {
            $this->cage['skCatalogoSistema'] = (isset($_POST['skCatalogoSistema']) ? $_POST['skCatalogoSistema'] :  ((isset($_GET['p1'])) ? $_GET['p1'] : NULL) );
            $this->cage['sNombre'] = (isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL);
            $this->cage['skEstatus'] = (isset($_POST['skEstatus']) ? $_POST['skEstatus'] : NULL);

            $skCatalogoSistemaOpciones = isset($_POST['skCatalogoSistemaOpciones']) ? $_POST['skCatalogoSistemaOpciones'] : NULL;

            $skCatalogoSistema = parent::acciones_catalogoSistema();
            
            if (is_string($skCatalogoSistema) && strlen($skCatalogoSistema) === 6) {
                    $this->cage['skCatalogoSistema'] = $skCatalogoSistema;
                    
                    if($skCatalogoSistemaOpciones){
                        $this->cage['skCatalogoSistemaOpciones'] = $skCatalogoSistemaOpciones;
                        if(!parent::deleteCatalogoSitemaValores($skCatalogoSistemaOpciones)){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                            return $this->data;
                        }
                        
                        foreach($skCatalogoSistemaOpciones AS $k=>$v){
                            $this->cage['skCatalogoSistemaOpciones'] = $v;
                            $this->cage['sNombreOpcion'] = $_POST['sNombreOpcion'][$k];
                            $this->cage['sClave'] = $_POST['sClave'][$k];
                            if(!parent::stpC_catalogoSistemaOpciones()){
                                $this->data['success'] = FALSE;
                                break;
                            }
                        }
                    }
                    

                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
                
            } else {
                
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
                
            }

        }
        
        $this->load_view('cage_form',$this->data);
        return true;
    }

    public function validarCodigo (){
        return parent::cage_query(
                escape(
                        (isset($_POST['skCatalogoSistema']))? $_POST['skCatalogoSistema']:NULL
                    )
            );
    }

    public function consultar_cage(){
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'], true);

        if(isset($_GET['p1']) && strlen($_GET['p1']) === 6){
            $this->cage['skCatalogoSistema'] = $_GET['p1'];
            $this->data['datos'] = parent::cage_query(
                    escape(
                        (isset($_GET['p1']))?$_GET['p1']:NULL
                    ), true);
            $this->data['catalogosOpciones'] = parent::consultar_opcionesCatalogos(TRUE);
        }

        return $this->data;
    }
}
