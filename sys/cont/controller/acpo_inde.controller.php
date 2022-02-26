<?php
Class Acpo_inde_Controller Extends Cont_Model {

    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'acpo_inde';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function consultar(){
        $configuraciones = [];
        $configuraciones['query'] = "SELECT
             ap.skAccessPoint
            ,ap.skEstatus
            ,ap.sMAC
            ,ap.sNombre
            ,ap.sObservaciones
            ,ap.sObservacionesCancelacion
            ,ap.skUsuarioCancelacion
            ,ap.dFechaCancelacion
            ,ap.skUsuarioCreacion
            ,ap.dFechaCreacion
            ,ap.skUsuarioModificacion
            ,ap.dFechaModificacion
            ,CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion
            ,CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion
            ,CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            ,tor.skTorre
            ,tor.sNombre AS nombreTorre
            ,tor.sMAC AS MACtorre
            FROM cat_accessPoint ap
            INNER JOIN cat_torres tor ON tor.skTorre = ap.skTorre
            INNER JOIN core_estatus est ON est.skEstatus = ap.skEstatus
            INNER JOIN cat_usuarios uCre ON uCre.skUsuario = ap.skUsuarioCreacion
            LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = ap.skUsuarioModificacion
            LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = ap.skUsuarioCancelacion
            WHERE 1 = 1 ";
        
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= " AND ap.skEstatus IN ('AC') ";
        }

        // SE EJECUTA LA CONSULTA //
            $data = parent::crear_consulta($configuraciones);
        
        // Retorna el Resultado del Query para la Generación de Excel y Reportes Automáticos //
            if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
                return $data['data'];
            }
        
        // RECORREMOS LOS DATOS DE LA CONSULTA //
            $result = $data['data'];
            $data['data'] = [];
            foreach (Conn::fetch_assoc_all($result) AS $row) {
                utf8($row,FALSE);
                
            // REGLAS DEL MENÚ EMERGENTE //
                /*
                    1.- Editar
                    2.- Cancelar
                    3.- Detalles
                */
                $regla = [
                    'menuEmergente1'=>($row['skEstatus'] == 'AC' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente2'=>($row['skEstatus'] == 'CA' ? SELF::DESHABILITADO : SELF::HABILITADO),
                    'menuEmergente3'=>SELF::HABILITADO
                ];
            
            // FORMATEO DE DATOS //
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : NULL;
                $row['dFechaModificacion'] = ($row['dFechaModificacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaModificacion'])) : NULL;
                $row['dFechaCancelacion'] = ($row['dFechaCancelacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaCancelacion'])) : NULL;
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skAccessPoint']);
            
            array_push($data['data'],$row);
        }
        return $data;
    }

    public function generarExcel(){
        parent::generar_excel(html_entity_decode($_POST['title']), $_POST['headers'], $this->consultar());
    }

    public function generarPDF(){
        parent::generar_pdf(html_entity_decode($_POST['title']), $_POST['headers'], $this->consultar());
    }

    public function cancelar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cont['axn'] = 'cancelar_accessPoint';
        $this->cont['skAccessPoint'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->cont['sObservaciones'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        $this->cont['skEstatus'] = 'CA';

        $stp_accessPoint = parent::stp_accessPoint();  
        if(!$stp_accessPoint || isset($stp_accessPoint['success']) && $stp_accessPoint['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }

}