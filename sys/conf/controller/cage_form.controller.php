<?php
Class Cage_form_Controller Extends Conf_Model{

    // CONSTANTS //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'stpCU_catalogosSistemas';
    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function guardar(){
        
        $this->data = ['success'=>FALSE,'message'=>NULL,'datos'=>FALSE];

        $this->conf['axn'] = 'guardar';

        if(isset($_GET['p1']) && !empty($_GET['p1'])){
            $this->conf['axn'] = 'editar';
        }
        $this->conf['skCatalogoSistema'] = (isset($_POST['skCatalogoSistema']) ? $_POST['skCatalogoSistema'] :  ((isset($_GET['p1'])) ? $_GET['p1'] : NULL) );
        $this->conf['sNombre'] = (isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL);
        $this->conf['skCatalogosSistemas_array'] = (isset($_POST['skCatalogoSistemaOpciones']) ? $_POST['skCatalogoSistemaOpciones'] : NULL);
        $skCatalogoSistemaOpciones = isset($_POST['skCatalogoSistemaOpciones']) ? $_POST['skCatalogoSistemaOpciones'] : NULL;
        $sNombreOpcion = (isset($_POST['sNombreOpcion']) ? $_POST['sNombreOpcion'] : NULL);
        $skClave = (isset($_POST['skClave']) ? $_POST['skClave'] : NULL);

        //Se valida que vengar el responsable, sino regresa un mensaje de error.
        if(empty($this->conf['skCatalogoSistema'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'ES NECESARIO INGRESAR EL CÓDIGO.';
            return $this->data;
        }
        //Se valida que vengar el responsable, sino regresa un mensaje de error.
        if(empty($this->conf['sNombre'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'ES NECESARIO INGRESAR EL NOMBRE.';
            return $this->data;
        }
        //Se valida que vengar el responsable, sino regresa un mensaje de error.
        if(empty($sNombreOpcion)){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'ES NECESARIO INGRESAR AL MENOS 1 NOMBRE DE OPCIONES.';
            return $this->data;
        }

            //exit('<pre>'.print_r($skCatalogoSistemaOpciones,1).'</pre>');

        Conn::begin($this->idTran);

        // GUARDAMOS EL CATALOGO DE SISTEMA //
            $stpCU_catalogosSistemas = parent::stpCU_catalogosSistemas();
            if(!$stpCU_catalogosSistemas || isset($stpCU_catalogosSistemas['success']) && $stpCU_catalogosSistemas['success'] != 1){
                Conn::rollback($this->idTran);
                $this->data['success'] = FALSE;
                $this->data['message'] = isset($stpCU_catalogosSistemas['message']) ? $stpCU_catalogosSistemas['message'] : 'Hubo un error al guardar.';
                $this->data['messageSQL'] = isset($stpCU_catalogosSistemas['messageSQL']) ? $stpCU_catalogosSistemas['messageSQL'] : 'Hubo un error SQL ';
                return $this->data;
            }

        // ELIMINAMOS DE MANERA LÓGICA LOS MOTIVOS DE LA CATEGORÍA //
            $delete_catalogosOpciones = parent::delete_catalogosOpciones();
            if(!$delete_catalogosOpciones){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al procesar las opciones.';
                $this->data['messageSQL'] = isset($delete_catalogosOpciones['messageSQL']) ? $delete_catalogosOpciones['messageSQL'] : 'Hubo un error SQL ';
                return $this->data;   
            }

        // GUARDAMOS LAS OPCIONES //
            if(isset($sNombreOpcion) && !empty($sNombreOpcion) && is_array($sNombreOpcion)){
                $this->conf['axn'] = 'guardar_opciones';

                if((!isset($_GET['p1'])) && empty($this->conf['skCatalogoSistema'])){
                    $this->conf['skCatalogoSistema'] = $stpCU_catalogosSistemas["skCatalogoSistema"];
                }
                //exit('<pre>'.print_r($_POST['skCatalogoSistemaOpciones'],1).print_r($skClave,1).print_r($sNombreOpcion,1).'</pre>');
                foreach($sNombreOpcion AS $key=>$val){
                    
                    $this->conf['skCatalogoSistemaOpciones'] =  isset($skCatalogoSistemaOpciones[$key]) ? $skCatalogoSistemaOpciones[$key] : NULL ;
                    $this->conf['sNombreOpcion'] = $val;
                    $this->conf['skClave'] = isset($skClave[$key]) ? $skClave[$key] : NULL ;

 
                    $stpC_catalogoSistemaOpciones = parent::stpC_catalogoSistemaOpciones();
                    if(!$stpC_catalogoSistemaOpciones || isset($stpC_catalogoSistemaOpciones['success']) && $stpC_catalogoSistemaOpciones['success'] != 1){
                        Conn::rollback($this->idTran);
                        $this->data['success'] = FALSE;
                        $this->data['message'] = isset($stpC_catalogoSistemaOpciones['message']) ? $stpC_catalogoSistemaOpciones['message'] : 'Hubo un error al guardar las opciones';
                        $this->data['messageSQL'] = isset($stpC_catalogoSistemaOpciones['messageSQL']) ? $stpC_catalogoSistemaOpciones['messageSQL'] : 'Hubo un error SQL ';
                        return $this->data;
                    }

                }
            }

        Conn::commit($this->idTran);
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
        return $this->data;
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
            $this->conf['skCatalogoSistema'] = $_GET['p1'];
            $this->data['datos'] = parent::cage_query(
                escape(
                    (isset($_GET['p1']))?$_GET['p1']:NULL
                ), true);
            $this->data['catalogosOpciones'] = parent::consultar_opcionesCatalogos(TRUE);
        }

        return $this->data;
    }
    
}
