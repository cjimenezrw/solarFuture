<?php
Class Serv_arri_Controller Extends Serv_Model {

    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'serv_arri';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function consultarBuques(){
        $this->data = ['success' => FALSE, 'message' => NULL, 'datos' => NULL];
        $this->serv['p1']         = (!empty($_POST['p1']) ? $_POST['p1'] : (!empty($_GET['p1']) ? $_GET['p1'] : NULL));
       if(empty($this->serv['p1'])){
            $this->data['success'] = FALSE; 
            $this->data['message'] = 'FALTA INCLUIR LA VERSION'; 
            $this->data['datos'] = []; 
            return $this->data;
       }
       if(!empty($this->serv['p1']) &&  !in_array($this->serv['p1'], ['v1','V1'])){
            $this->data['success'] = FALSE; 
            $this->data['message'] = 'La Version no es Valida!'; 
            $this->data['datos'] = []; 
            return $this->data;
       }
       if(in_array($this->serv['p1'], ['v1','V1'])){
            $this->serv['pagina']         = (!empty($_POST['pagina']) ? $_POST['pagina'] : (!empty($_GET['pagina']) ? $_GET['pagina'] : NULL));
            $this->serv['tipoTrafico']         = (!empty($_POST['tipoTrafico']) ? $_POST['tipoTrafico'] : (!empty($_GET['tipoTrafico']) ? $_GET['tipoTrafico'] : NULL));
            $this->serv['buque']         = (!empty($_POST['buque']) ? $_POST['buque'] : (!empty($_GET['buque']) ? $_GET['buque'] : NULL));
            $this->serv['codigo']         = (!empty($_POST['codigo']) ? $_POST['codigo'] : (!empty($_GET['codigo']) ? $_GET['codigo'] : NULL));
            $this->serv['bandera']         = (!empty($_POST['bandera']) ? $_POST['bandera'] : (!empty($_GET['bandera']) ? $_GET['bandera'] : NULL));
            $this->serv['lineaNaviera']         = (!empty($_POST['lineaNaviera']) ? $_POST['lineaNaviera'] : (!empty($_GET['lineaNaviera']) ? $_GET['lineaNaviera'] : NULL));
            
            $buques  = parent::_consultarBuques();
            $total = count($buques);
            if(!empty($buques)){
                $this->data['success'] = TRUE; 
                $this->data['message'] = 'Buques obtenidos con exito';  
                $this->data['totalResultados'] = $total; 
                $this->data['datos'] = $buques; 
                
                
            }

       }  
        return $this->data;
    }


    public function consultarArribos(){
        $this->data = ['success' => FALSE, 'message' => NULL, 'datos' => NULL];
        $this->serv['p1']         = (!empty($_POST['p1']) ? $_POST['p1'] : (!empty($_GET['p1']) ? $_GET['p1'] : NULL));
       if(empty($this->serv['p1'])){
            $this->data['success'] = FALSE; 
            $this->data['message'] = 'FALTA INCLUIR LA VERSION'; 
            $this->data['datos'] = []; 
            return $this->data;
       }
       if(!empty($this->serv['p1']) &&  !in_array($this->serv['p1'], ['V1'])){
            $this->data['success'] = FALSE; 
            $this->data['message'] = 'LA VERSION NO ES VALIDA!'; 
            $this->data['datos'] = []; 
            return $this->data;
       }
       if($this->serv['p1'] == 'V1'){
            $this->serv['pagina']         = (!empty($_POST['pagina']) ? $_POST['pagina'] : (!empty($_GET['pagina']) ? $_GET['pagina'] : NULL));
            $this->serv['tipoTrafico']         = (!empty($_POST['tipoTrafico']) ? $_POST['tipoTrafico'] : (!empty($_GET['tipoTrafico']) ? $_GET['tipoTrafico'] : NULL));
            $this->serv['buque']         = (!empty($_POST['buque']) ? $_POST['buque'] : (!empty($_GET['buque']) ? $_GET['buque'] : NULL));
            $this->serv['codigo']         = (!empty($_POST['codigo']) ? $_POST['codigo'] : (!empty($_GET['codigo']) ? $_GET['codigo'] : NULL));
            $this->serv['codigoArribo']         = (!empty($_POST['codigoArribo']) ? $_POST['codigoArribo'] : (!empty($_GET['codigoArribo']) ? $_GET['codigoArribo'] : NULL));
            $this->serv['lineaNaviera']         = (!empty($_POST['lineaNaviera']) ? $_POST['lineaNaviera'] : (!empty($_GET['lineaNaviera']) ? $_GET['lineaNaviera'] : NULL));
            $this->serv['viaje']         = (!empty($_POST['viaje']) ? $_POST['viaje'] : (!empty($_GET['viaje']) ? $_GET['viaje'] : NULL));
            
            
            $arribos  = parent::_consultarArribos();
            $total = count($arribos);
            if(!empty($arribos)){
                $this->data['success'] = TRUE; 
                $this->data['message'] = 'Arribos obtenidos con exito'; 
                //$this->data['pagina'] = '1'; 
                //$this->data['totalPagina'] = ''; 
                $this->data['totalResultados'] = $total; 
                $this->data['datos'] = $arribos; 
                
     
                
            }

       }  
        return $this->data;
    }

}