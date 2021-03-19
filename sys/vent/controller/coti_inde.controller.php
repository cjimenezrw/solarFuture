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
        CONCAT('SFM',RIGHT(CONCAT('0000',CAST(oc.iFolio AS VARCHAR(4))),4)) AS iFolio,
        oc.dFechaCreacion, 
        oc.fImporteTotal,
        oc.skDivisa,
        oc.dFechaVigencia,
        oc.sObservaciones,
        oc.skEstatus,
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
                $regla = [
                    'menuEmergente1'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente3'=>[
                        "id"=>$row['skCotizacion'].'/'.'CL',
                        "titulo"=>'Clonar',
                        "estatus"=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO)
                    ],
                    'menuEmergente5'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO),
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
}
    

