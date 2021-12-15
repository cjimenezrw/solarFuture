<?php
Class Cita_inde_Controller Extends Cita_Model {

    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_inde';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function consultar(){
        $configuraciones = [];
        $configuraciones['query'] = "SELECT 
            cit.skCita,
            CONCAT('CIT',RIGHT(CONCAT('0000',CAST(cit.iFolioCita AS VARCHAR(4))),4)) AS iFolioCita,
            cit.skCategoriaCita,
            cit.skEstatus,
            cit.dFechaCita,
            cit.tHoraInicio,
            cit.tHoraFin,
            cit.skEmpresaSocioCliente,
            cit.sNombre,
            cit.sTelefono,
            cit.sCorreo,
            cit.skEstadoMX,
            cit.skMunicipioMX,
            cit.sDomicilio,
            cit.sObservaciones,
            cit.sInstruccionesServicio,
            cit.skUsuarioConfirmacion,
            cit.dFechaConfirmacion,
            cit.skUsuarioCreacion,
            cit.dFechaCreacion,
            cit.skUsuarioModificacion,
            cit.dFechaModificacion,
            cate.sNombreCategoria,
            cate.iMinutosDuracion,
            est.sNombre AS estatus,
            est.sIcono AS estatusIcono,
            est.sColor AS estatusColor,
            esMX.sNombre AS estado,
            muMX.sNombre AS municipio,
            CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion,
            CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion,
            CONCAT(uConf.sNombre,' ',uConf.sApellidoPaterno,' ',uConf.sApellidoMaterno) AS usuarioConfirmacion,
            e.sNombre AS empresaCliente,
            e.sRFC AS empresaRFC
            FROM ope_citas cit
            LEFT JOIN cat_citas_categorias cate ON cate.skCategoriaCita = cit.skCategoriaCita
            INNER JOIN core_estatus est ON est.skEstatus = cit.skEstatus
            INNER JOIN cat_estadosMX esMX ON esMX.skEstadoMX = cit.skEstadoMX
            INNER JOIN cat_municipiosMX muMX ON muMX.skMunicipioMX = cit.skMunicipioMX
            INNER JOIN cat_usuarios uCre ON uCre.skUsuario = cit.skUsuarioCreacion
            LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = cit.skUsuarioModificacion
            LEFT JOIN cat_usuarios uConf ON uConf.skUsuario = cit.skUsuarioConfirmacion
            LEFT JOIN rel_empresasSocios es ON es.skEmpresaSocio = cit.skEmpresaSocioCliente
            LEFT JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            WHERE 1=1 ";
        
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= " AND cit.skEstatus = 'PE' ";
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
                utf8($row);

                
            // REGLAS DEL MENÚ EMERGENTE //
                $regla = [];
            
            // FORMATEO DE DATOS //
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : NULL;
                $row['dFechaModificacion'] = ($row['dFechaModificacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaModificacion'])) : NULL;
                $row['dFechaConfirmacion'] = ($row['dFechaConfirmacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaConfirmacion'])) : NULL;
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skCita']);
            
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

}