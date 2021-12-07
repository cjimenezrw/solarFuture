<?php
Class Uscf_inde_Controller Extends Admi_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'usosCFDI'; //Mi procedimiento

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }
    //AQUÍ VAN LAS FUNCIONES//
    public function consulta(){
        $configuraciones = [];

        //$configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT 
        cuf.skUsoCFDI,
        cuf.sNombre,
        cuf.sClave,
        ce.sNombre AS estatus,
        ce.sColor AS estatusColor,
        ce.sIcono AS estatusIcono


        FROM cat_usosCFDI cuf
        LEFT JOIN core_estatus ce ON ce.skEstatus = cuf.skEstatus ";
        
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= "   ";
        }

        // SE EJECUTA LA CONSULTA //
        $data = parent::crear_consulta($configuraciones);
        
        // Retorna el Resultado del Query para la Generación de Excel y Reportes Automáticos //
            if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
                return $data['data'];
            }
        
        // FORMATEAMOS LOS DATOS DE LA CONSULTA //
            $result = $data['data'];
            $data['data'] = [];
            foreach (Conn::fetch_assoc_all($result) AS $row) {
                utf8($row);

                
            //REGLA DEL MENÚ EMERGENTE
            $regla = [ ];

                  
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skUsoCFDI']);
                array_push($data['data'],$row);
        }
        return $data;
    }

    //Función para generar excel
    public function generarExcel(){
        $data = $this->consulta();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    //Función para generar PDF
    public function generarPDF() {
        return parent::generar_pdf(
           $_POST['title'], 
           $_POST['headers'], 
           $this->consulta()
        );
    }

     
}
    

