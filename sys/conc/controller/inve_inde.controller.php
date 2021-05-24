<?php
Class Inve_inde_Controller Extends Conc_Model {
    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct(){ 
        parent::init(); 
    }

    public function __destruct(){ 

    }

    public function consulta(){
        $configuraciones = [];

        //$configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT cc.skConcepto,
            cc.iFolio,
            cc.fCantidad,
            cc.iDetalle,
            cc.sCodigo,
            cc.dFechaCreacion,
            cc.sNombre,
            #SUBSTRING(cc.sNombre, 1, 50) AS sNombre,
            cc.skEstatus,
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
            WHERE cc.skEstatus != 'CA' AND cc.fCantidad IS NOT NULL ";
            
        if(!isset($_POST['filters'])){

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
                        'menuEmergente1'=>SELF::HABILITADO,
                        'menuEmergente2'=>SELF::HABILITADO,
                        'menuEmergente3'=>SELF::HABILITADO
                    ];

                $row['fCantidad'] = ($row['fCantidad']) ? number_format($row['fCantidad'],2) : '';
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skConcepto']);
                array_push($data['data'],$row);
            }
        return $data;
    }

    public function generarExcel(){
        parent::generar_excel($_POST['title'],$_POST['headers'],$this->consulta());
    }

    public function generarPDF() {
        return parent::generar_pdf($_POST['title'],$_POST['headers'],$this->consulta());
    }
}