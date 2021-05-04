<?php
Class Conc_inde_Controller Extends Conc_Model {
    
    
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
        $configuraciones['query'] = "SELECT cc.skConcepto,
        cc.iFolio,
        cc.sCodigo,
        cc.dFechaCreacion,
        cc.sNombre,
        cc.skEstatus,
        cc.fCantidad,
        ce.sNombre AS estatus,
        ce.sIcono AS estatusIcono,
        ce.sColor AS estatusColor,
        cep.sNombre AS proveedor,
        cu.sNombre AS usuarioCreacion       
        FROM cat_conceptos cc
        INNER JOIN core_estatus ce ON ce.skEstatus = cc.skEstatus
        INNER JOIN cat_usuarios cu ON cu.skUsuario = cc.skUsuarioCreacion
        LEFT JOIN rel_empresasSocios resp ON resp.skEmpresaSocio = cc.skEmpresaSocioProveedor
        LEFT JOIN cat_empresas cep ON cep.skEmpresa = resp.skEmpresa
        WHERE cc.skEstatus != 'CA' ";
        
        if(!isset($_POST['filters'])){
            //$configuraciones['query'] .= " AND cc.skEstatus != 'CA' ";
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
                    'menuEmergente2'=>($row['skEstatus'] == 'NU' ? SELF::HABILITADO : SELF::DESHABILITADO)
                ];

                $row['fCantidad'] = ($row['fCantidad']) ? number_format($row['fCantidad'],2) : '';
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skConcepto']);
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

        $this->conc['axn'] = 'cancelar_concepto';
        $this->conc['skConcepto'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->conc['sObservacionesCancelacion'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        
        $stpCUD_conceptos = parent::stpCUD_conceptos();
           
        if(!$stpCUD_conceptos || isset($stpCUD_conceptos['success']) && $stpCUD_conceptos['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }
}
    

