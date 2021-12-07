<?php
Class Coco_inde_Controller Extends Admi_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'comprobantes'; //Mi procedimiento

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
        occ.skComprobanteCFDI,
        occ.dFechaCreacion,
        occ.dFechaTimbrado, 
        occ.fTotal, 
		occ.iFolio,
		occ.iFolio AS iFolioMostrar,
        occ.fSaldo,
        occ.skEstatus,
        occ.skEstatusPago,
        occ.sTipoComprobante,
        ce.sNombre AS estatus,
        ce.sColor AS estatusColor,
        ce.sIcono AS estatusIcono,
        cep.sNombre AS estatusPago,
        cep.sColor AS estatusColorPago,
        cep.sIcono AS estatusIconoPago,
        cef.sNombre AS facturar,
        cer.sNombre AS responsable,
        cmp.sCodigo AS metodoPago,
        cfp.sCodigo AS formaPago,
        cuc.sClave AS usoCFDI
        FROM  ope_cfdiComprobantes occ
        LEFT JOIN core_estatus ce ON ce.skEstatus = occ.skEstatus
        LEFT JOIN core_estatus cep ON cep.skEstatus = occ.skEstatusPago
        LEFT JOIN rel_empresasSocios resf ON resf.skEmpresaSocio  = occ.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas cef ON cef.skEmpresa  = resf.skEmpresa
        LEFT JOIN rel_empresasSocios resr ON resr.skEmpresaSocio  = occ.skEmpresaSocioResponsable
        LEFT JOIN cat_empresas cer ON cer.skEmpresa  = resr.skEmpresa
        LEFT JOIN cat_metodosPago cmp ON cmp.sCodigo = occ.skMetodoPago
        LEFT JOIN cat_formasPago cfp ON cfp.sCodigo = occ.skFormaPago
        LEFT JOIN cat_usosCFDI cuc ON cuc.sClave = occ.skUsoCFDI
        WHERE 1 = 1 
         ";
        
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
            $regla = [ 
                "menuEmergente1" => $this->ME_relacionar($row)
                
            ];

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''; 
                $row['dFechaTimbrado'] = ($row['dFechaTimbrado']) ? date('d/m/Y', strtotime($row['dFechaTimbrado'])) : ''; 
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skComprobanteCFDI']);
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

    /* ME_relacionar
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_relacionar(&$row){
        if( (in_array($row['skEstatus'], ['NU','PO'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }

     
}
    

