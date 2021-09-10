<?php
Class Prod_inde_Controller Extends Conc_Model {
    
    
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
        $configuraciones['query'] = "SELECT
            ips.skInformacionProductoServicio
            ,ips.skEstatus
            ,ips.sNombre
            ,ips.sDescripcionHoja1
            ,ips.sDescripcionHoja2
            ,ips.sDescripcionGarantia
            ,ips.sImagen
            ,ips.skUsuarioCreacion
            ,ips.dFechaCreacion
            ,ips.skUsuarioModificacion
            ,ips.dFechaModificacion
            ,ce.sNombre AS estatus
            ,ce.sIcono AS estatusIcono
            ,ce.sColor AS estatusColor
            ,cu.sNombre AS usuarioCreacion
        FROM cat_informacionProductoServicio ips
        INNER JOIN core_estatus ce ON ce.skEstatus = ips.skEstatus
        INNER JOIN cat_usuarios cu ON cu.skUsuario = ips.skUsuarioCreacion
        WHERE 1=1 ";
        
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= " AND ips.skEstatus != 'CA' ";
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
                    'menuEmergente1'=>($row['skEstatus'] == 'AC' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente2'=>($row['skEstatus'] == 'AC' ? SELF::HABILITADO : SELF::DESHABILITADO)
                ];

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skInformacionProductoServicio']);
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

        $this->conc['axn'] = 'cancelar_informacionProductoServicio';
        $this->conc['skInformacionProductoServicio'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->conc['sObservacionesCancelacion'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        
        $stpCUD_informacionProductoServicio = parent::stpCUD_informacionProductoServicio();
        
        if(!$stpCUD_informacionProductoServicio || isset($stpCUD_informacionProductoServicio['success']) && $stpCUD_informacionProductoServicio['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }
}
    

