<?php
Class Orse_inde_Controller Extends Admi_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'cobros'; //Mi procedimiento

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
        oos.skOrdenServicio,
        CONCAT('ORD-', LPAD(oos.iFolio, 5, 0))  AS iFolio,
        oos.dFechaCreacion,
        oos.skDivisa,
        oos.fImporteTotal,
        oos.fImporteSubtotal,
        oos.fImpuestosRetenidos,
        oos.fImpuestosTrasladados,
        oos.fDescuento, 
        oos.skEstatus,
        cer.sNombre AS responsable,
        cec.sNombre AS cliente,
        cef.sNombre AS facturacion,
        ce.sNombre AS estatus,
        ce.sIcono AS estatusIcono,
        ce.sColor AS estatusColor, 
        cu.sNombre AS usoCFDI,
        '' AS folioServicio,
        cuc.sNombre AS usuarioCreacion,
        (SELECT  occ.iFolio   FROM rel_ordenesServicios_facturas rpf  INNER JOIN ope_facturas occ ON occ.skFactura = rpf.skFactura  AND occ.skEstatus !='CA' AND occ.iFolio IS NOT NULL WHERE rpf.skOrdenServicio = oos.skOrdenServicio LIMIT 1 ) AS iFolioFactura
        FROM ope_ordenesServicios oos
        LEFT JOIN core_estatus ce ON ce.skEstatus = oos.skEstatus 
        LEFT JOIN rel_empresasSocios resr ON resr.skEmpresaSocio = oos.skEmpresaSocioResponsable
        LEFT JOIN cat_empresas cer ON cer.skEmpresa = resr.skEmpresa
        LEFT JOIN rel_empresasSocios resc ON resc.skEmpresaSocio = oos.skEmpresaSocioCliente
        LEFT JOIN cat_empresas cec ON cec.skEmpresa = resc.skEmpresa
        LEFT JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = oos.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas cef ON cef.skEmpresa = resf.skEmpresa
        LEFT JOIN cat_usosCFDI cu ON cu.skUsoCFDI = oos.skUsoCFDI
        LEFT JOIN cat_usuarios cuc ON cuc.skUsuario = oos.skUsuarioCreacion
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
                    "menuEmergente2" => $this->ME_autorizar($row),
                    "menuEmergente3" => $this->ME_cancelar($row)
                    
                ];
                $row['fImporteTotal'] = ($row['fImporteTotal']) ? '$ '.number_format($row['fImporteTotal'],2) : '$ 0.00'; 

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''; 
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skOrdenServicio']);
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
    /* ME_autorizar
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_autorizar(&$row){
        if((in_array($row['skEstatus'], ['PE'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }

    /* ME_cancelar
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_cancelar(&$row){
        if((in_array($row['skEstatus'], ['PE'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }



    public function autorizarOrden(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->admi['axn'] = 'autorizarOrden';
        $this->admi['skOrdenServicio'] = (isset($_POST['skOrdenServicio']) && !empty($_POST['skOrdenServicio'])) ? $_POST['skOrdenServicio'] : NULL;

        $stpCUD_ordenesServicios = parent::stpCUD_ordenesServicios();  
        if(!$stpCUD_ordenesServicios || isset($stpCUD_ordenesServicios['success']) && $stpCUD_ordenesServicios['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL AUTORIZAR LA SOLICITUD. ';
            return $this->data;
        }

        return $this->data;
    } 

    public function enviarFacturacion(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->admi['axn'] = 'enviarFacturacion';
        $this->admi['skOrdenServicio'] = (isset($_POST['skOrdenServicio']) && !empty($_POST['skOrdenServicio'])) ? $_POST['skOrdenServicio'] : NULL;

        $stpCUD_ordenesServicios = parent::stpCUD_ordenesServicios();  
        if(!$stpCUD_ordenesServicios || isset($stpCUD_ordenesServicios['success']) && $stpCUD_ordenesServicios['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL AUTORIZAR LA SOLICITUD. ';
            return $this->data;
        }

        return $this->data;
    } 

    public function cancelarOrden(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->admi['axn'] = 'cancelarOrden';
        $this->admi['skOrdenServicio'] = (isset($_POST['skOrdenServicio']) && !empty($_POST['skOrdenServicio'])) ? $_POST['skOrdenServicio'] : NULL;

        $stpCUD_ordenesServicios = parent::stpCUD_ordenesServicios();  
        if(!$stpCUD_ordenesServicios || isset($stpCUD_ordenesServicios['success']) && $stpCUD_ordenesServicios['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL AUTORIZAR LA SOLICITUD. ';
            return $this->data;
        }

        return $this->data;
    } 

    public function generarOrden(){
        $this->data = ['success' => TRUE, 'message' => NULL];

        $this->admi['axn'] = 'GE';
        $this->admi['skCodigo'] = (isset($_POST['skCodigo']) && !empty($_POST['skCodigo'])) ? $_POST['skCodigo'] : NULL;
        $this->admi['skProceso'] = (isset($_POST['skProceso']) && !empty($_POST['skProceso'])) ? $_POST['skProceso'] : NULL;
        if(empty($this->admi['axn']) ){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'LA ACCION ES REQUERIDA ';
            return $this->data;
        }
        if(!empty($this->admi['axn']) &&  !in_array($this->admi['axn'], ['CO','GE'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'LA ACCION NO ES VALIDA ';
            return $this->data;

        }
        if(empty($this->admi['skCodigo'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'EL CODIGO ES REQUERIDO';
            return $this->data;
        }
        if(empty($this->admi['skProceso'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'EL PROCESO ES REQUERIDO';
            return $this->data;
        }
        if(!empty($this->admi['skProceso']) &&  !in_array($this->admi['skProceso'], ['VACI','LAVA'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'EL CODIGO DEL PROCESO NO ES VALIDO ';
            return $this->data;
        }

        $stpCUD_cobros = parent::stpCUD_cobros();  
        if(!$stpCUD_cobros || isset($stpCUD_cobros['success']) && $stpCUD_cobros['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GENERAR LA ORDEN DE SERVICIO. ';
            return $this->data;
        } 
        

        $this->data['skOrdenServicio'] = (!empty($stpCUD_cobros['skOrdenServicio']) ? $stpCUD_cobros['skOrdenServicio'] : NULL);
        
        if(empty($this->data['skOrdenServicio'])){
             $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GENERAR LA ORDEN DE SERVICIO. ';
            return $this->data;
        } 
        $this->data['success'] = TRUE;
        $this->data['message'] = 'ORDEN DE SERVICIO GENERADA CON EXITO';
        return $this->data;
 
    } 
    public function consultarOrden(){
        $this->data = ['success' => TRUE, 'message' => NULL];

        $this->admi['axn'] = 'CO';
        $this->admi['skCodigo'] = (isset($_POST['skCodigo']) && !empty($_POST['skCodigo'])) ? $_POST['skCodigo'] : NULL;
        $this->admi['skProceso'] = (isset($_POST['skProceso']) && !empty($_POST['skProceso'])) ? $_POST['skProceso'] : NULL;
        if(empty($this->admi['axn']) ){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'LA ACCION ES REQUERIDA ';
            return $this->data;
        }
        if(!empty($this->admi['axn']) &&  !in_array($this->admi['axn'], ['CO'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'LA ACCION NO ES VALIDA ';
            return $this->data;

        }
        if(empty($this->admi['skCodigo'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'EL CODIGO ES REQUERIDO';
            return $this->data;
        }
        if(empty($this->admi['skProceso'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'EL PROCESO ES REQUERIDO';
            return $this->data;
        }
        if(!empty($this->admi['skProceso']) &&  !in_array($this->admi['skProceso'], ['VACI','LAVA'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'EL CODIGO DEL PROCESO NO ES VALIDO ';
            return $this->data;
        }

        $stpCUD_cobros = parent::stpCUD_cobrosCO();  
         
       
        $this->data['datos'] = $stpCUD_cobros;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'ORDEN DE SERVICIO GENERADA CON EXITO';
        return $this->data;
 
    } 

     
}
    

