<?php
Class Cofa_inde_Controller Extends Admi_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'facturas'; //Mi procedimiento

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
        ofa.skFactura,
        ofa.iFolio,
        ofa.skEstatus,
        ofa.skEstatusPago,
        ofa.dFechaCreacion,
        ofa.skMetodoPago,
        ofa.skFormaPago,
        ofa.skUsoCFDI,
        ofa.skDivisa,
        ofa.sReferencia,
        ofa.fImpuestosRetenidos,
        ofa.fImpuestosTrasladados,
        ofa.fSubtotal,
        ofa.fTotal,
        cef.sNombre AS facturacion,
        cu.sNombre AS usuarioCreacion,
        ce.sNombre AS estatus,
        ce.sIcono AS estatusIcono,
        ce.sColor AS estatusColor,
        cep.sNombre AS estatusPago,
        cep.sIcono AS estatusIconoPago,
        cep.sColor AS estatusColorPago

        FROM ope_facturas ofa
        LEFT JOIN core_estatus ce ON ce.skEstatus = ofa.skEstatus
        LEFT JOIN core_estatus cep ON cep.skEstatus = ofa.skEstatusPago
        LEFT JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = ofa.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas cef ON cef.skEmpresa = resf.skEmpresa
        LEFT JOIN cat_usuarios cu ON cu.skUsuario = ofa.skUsuarioCreacion
        
        WHERE 1=1 ";
        
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

                 $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''; 
                 $row['fSubtotal'] = (!empty($row['fSubtotal']) ? '$'.number_format($row['fSubtotal'],2) : '$ 0.00'); 
                 $row['fTotal'] = (!empty($row['fTotal']) ? '$'.number_format($row['fTotal'],2) : '$ 0.00'); 

               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skFactura']);
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
    

