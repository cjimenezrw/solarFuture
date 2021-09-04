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
    private $idTran = 'cotizacion'; //Mi procedimiento

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
        CONCAT('SFM',RIGHT(CONCAT('0000',CAST(oc.iFolio AS VARCHAR(4))),4)) AS iFolio,
        oc.dFechaCreacion, 
        oc.fImporteTotal,
        oc.skDivisa,
        oc.dFechaVigencia,
        oc.sObservaciones,
        oc.skEstatus,
        oc.skEstatusActaEntrega,
        ce.sNombre AS estatus,
        ce.sIcono AS estatusIcono,
        ce.sColor AS estatusColor, 
        cu.sNombre AS usuarioCreacion,
        IF(cep.sNombre IS NOT NULL,cep.sNombre,IF(cp.sNombreContacto IS NOT NULL,cp.sNombreContacto,NULL)) AS cliente
        FROM ope_cotizaciones oc
        INNER JOIN core_estatus ce ON ce.skEstatus = oc.skEstatus
        INNER JOIN cat_usuarios cu ON cu.skUsuario = oc.skUsuarioCreacion
        LEFT JOIN rel_empresasSocios resc ON resc.skEmpresaSocio = oc.skEmpresaSocioCliente
        LEFT JOIN cat_prospectos cp ON cp.skProspecto = oc.skEmpresaSocioCliente
        LEFT JOIN cat_empresas cep ON cep.skEmpresa = resc.skEmpresa
        WHERE 1=1 ";
        
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= " AND oc.skEstatus != 'CA' ";
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

                /*
                */
                
            //REGLA DEL MENÚ EMERGENTE
                $regla = [
                    'menuEmergente1'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente3'=>[
                        "id"=>$row['skCotizacion'].'/'.'CL',
                        "titulo"=>'Clonar',
                        "estatus"=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO)
                    ],
                    'menuEmergente5'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente6'=>($row['skEstatus'] == 'VE' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente9'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente10'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::OCULTO),
                    'menuEmergente11'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::OCULTO),
                    'menuEmergente12'=>($row['skEstatus'] == 'VE' ? SELF::HABILITADO : SELF::OCULTO),
                    'menuEmergente13'=>($row['skEstatus'] == 'VE' ? SELF::HABILITADO : SELF::OCULTO),
                    'menuEmergente14'=>($row['skEstatusActaEntrega'] == 'GE' ? SELF::HABILITADO : SELF::OCULTO),
                    'menuEmergente15'=>($row['skEstatusActaEntrega'] == 'GE' ? SELF::HABILITADO : SELF::OCULTO)
                ];

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                $row['dFechaVigencia'] = ($row['dFechaVigencia']) ? date('d/m/Y', strtotime($row['dFechaVigencia'])) : '';
                $row['fImporteTotal'] = (!empty($row['fImporteTotal']) ? "$".number_format($row['fImporteTotal'],2) : '');
                 
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

    public function cancelar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->vent['axn'] = 'cancelar_cotizacion';
        $this->vent['skCotizacion'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->vent['sObservacionesCancelacion'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;

        $stpCUD_cotizaciones = parent::stpCUD_cotizaciones();  
        if(!$stpCUD_cotizaciones || isset($stpCUD_cotizaciones['success']) && $stpCUD_cotizaciones['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }
    public function cancelarVenta(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->vent['skCotizacion'] = (isset($_POST['skCotizacion']) && !empty($_POST['skCotizacion'])) ? $_POST['skCotizacion'] : NULL;
        $this->data['datos'] =  parent::_getCotizacion();
        if($this->data['datos']['skEstatus'] != 'VE'){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'LA VENTA YA SE HA CANCELADO CON ANTERIORIDAD O YA NO SE ENCUENTRA ACTIVA';
            return $this->data;
        }

        
        
        Conn::begin($this->idTran);
        $this->vent['axn'] = 'cancelarVentaCotizacion';


        $stpCUD_conceptosInventario = parent::stpCUD_conceptosInventario();
        if(!$stpCUD_conceptosInventario || isset($stpCUD_conceptosInventario['success']) && $stpCUD_conceptosInventario['success'] != 1){
            Conn::rollback($this->idTran);
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR LA COTIZACION EN GENERAL';
            return $this->data;
        }

        $this->vent['axn'] = 'cancelarVentaConcepto';

        $this->data['conceptosCotizacion']  = parent::_getCotizacionConceptos();
      

        foreach($this->data['conceptosCotizacion'] AS $keyConceptos => $rowConceptos){
           
            $this->vent['skConcepto'] = $rowConceptos['skConcepto'];
            $this->vent['skCotizacionConcepto'] = $rowConceptos['skCotizacionConcepto'];
            $this->vent['skConceptoInventario']  = NULL;
            if(!empty($rowConceptos['iDetalle'])){
               
                    if(!empty($rowConceptos['venta']) && is_array($rowConceptos['venta'])){
                      
                        foreach($rowConceptos['venta'] AS $row){
                            
                            $this->vent['fCantidad'] = 1;
                            $this->vent['skConceptoInventario'] = $row['skConceptoInventario'];
                            $stpCUD_conceptosInventario = parent::stpCUD_conceptosInventario();
                            if(!$stpCUD_conceptosInventario || isset($stpCUD_conceptosInventario['success']) && $stpCUD_conceptosInventario['success'] != 1){
                                Conn::rollback($this->idTran);
                                $this->data['success'] = FALSE;
                                $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL CONCEPTO DE DETALLE';
                                return $this->data;
                            }

                        }

                    }
                
            }else{

                $this->vent['fCantidad'] = $rowConceptos['fCantidad'];
                $stpCUD_conceptosInventario = parent::stpCUD_conceptosInventario();
                if(!$stpCUD_conceptosInventario || isset($stpCUD_conceptosInventario['success']) && $stpCUD_conceptosInventario['success'] != 1){
                    Conn::rollback($this->idTran);
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL CONCEPTO GENERAL';
                    return $this->data;
                }

            }
            

        }

         

        Conn::commit($this->idTran);
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
        return $this->data;
    }
    

    public function cotizacionPDF(){
        $formatoPDF = $this->sysAPI('vent', 'coti_deta', 'formatoPDF', [
            'GET' => [
                'p1' => (isset($_GET['id']) ? $_GET['id'] :  NULL),
                'directDownloadFile' => true
            ]
         ]);
         return true;
    }  

    public function ventaPDF(){
        $formatoPDF = $this->sysAPI('vent', 'coti_deta', 'formatoVentaPDF', [
            'GET' => [
                'p1' => (isset($_GET['id']) ? $_GET['id'] :  NULL),
                'directDownloadFile' => true
            ]
         ]);
         return true;
    }  

    public function entregaPDF(){
        $formatoPDF = $this->sysAPI('vent', 'coti_deta', 'formatoEntregaPDF', [
            'GET' => [
                'p1' => (isset($_GET['id']) ? $_GET['id'] :  NULL),
                'directDownloadFile' => true
            ]
         ]);
         return true;
    }  
}
    

