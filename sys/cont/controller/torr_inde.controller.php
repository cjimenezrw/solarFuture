<?php
Class Torr_inde_Controller Extends Cont_Model {

    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'torr_inde';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function consultar(){
        $configuraciones = [];
        $configuraciones['query'] = "SELECT
             tor.skTorre
            ,tor.skEstatus
            ,tor.sMAC
            ,tor.sNombre
            ,tor.sObservaciones
            ,tor.sObservacionesCancelacion
            ,tor.skUsuarioCancelacion
            ,tor.dFechaCancelacion
            ,tor.skUsuarioCreacion
            ,tor.dFechaCreacion
            ,tor.skUsuarioModificacion
            ,tor.dFechaModificacion
            ,CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion
            ,CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion
            ,CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            FROM cat_torres tor
            INNER JOIN core_estatus est ON est.skEstatus = tor.skEstatus
            INNER JOIN cat_usuarios uCre ON uCre.skUsuario = tor.skUsuarioCreacion
            LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = tor.skUsuarioModificacion
            LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = tor.skUsuarioCancelacion
            WHERE 1 = 1 ";
        
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= " AND tor.skEstatus IN ('AC') ";
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
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skTorre']);
            
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

        $this->cont['axn'] = 'cancelar_torre';
        $this->cont['skTorre'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->cont['sObservaciones'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        $this->cont['skEstatus'] = 'CA';

        $stp_torres = parent::stp_torres();  
        if(!$stp_torres || isset($stp_torres['success']) && $stp_torres['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }

}