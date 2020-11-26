<?php
Class Coti_inde_Controller Extends Vent_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }
    //AQUÍ VAN LAS FUNCIONES//
    public function consulta(){
        $configuraciones = [];

        //$configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT oc.skCotizacion,
        oc.iFolio, 
        oc.dFechaCreacion, 
        oc.fTotal,
        oc.skDivisa,
        oc.dFechaVigencia,
        oc.sComentarios,
        ce.sNombre AS estatus,
        ce.sIcono AS estatusIcono,
        ce.sColor AS estatusColor,
        cep.sNombre AS cliente,
        cu.sNombre AS usuarioCreacion       
        FROM ope_cotizaciones oc
        INNER JOIN core_estatus ce ON ce.skEstatus = oc.skEstatus
        INNER JOIN cat_usuarios cu ON cu.skUsuario = oc.skUsuarioCreacion
        LEFT JOIN rel_empresasSocios resc ON resc.skEmpresaSocio = oc.skEmpresaSocioCliente
        LEFT JOIN cat_empresas cep ON cep.skEmpresa = resc.skEmpresa
            ";            
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

                /*
                */
                
            //REGLA DEL MENÚ EMERGENTE
                $regla = [];

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skCotizacion']);
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
    

