<?php
Class Cita_inde_Controller Extends Cita_Model {

    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;

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
        cit.skCita
       ,cit.skEstatus
       ,CONCAT('CIT-',RIGHT(CONCAT('0000',CAST(cit.iFolio AS VARCHAR(4))),4)) AS iFolio
       ,cit.skEmpresaSocioPropietario
       ,cit.skEmpresaSocioFacturacion
       ,cit.skEmpresaSocioCliente
       ,cit.sAsunto
       ,cit.skCategoriaCita
       ,cit.dFechaCita
       ,cit.tHoraInicio
       ,cit.tHoraFin
       ,cit.skTipoPeriodo
       ,cit.sTelefono
       ,cit.skEstadoMX
       ,cit.skMunicipioMX
       ,cit.sDomicilio
       ,cit.sObservaciones
       ,cit.sInstruccionesServicio
       ,cit.skDivisa
       ,cit.fTipoCambio
       ,cit.fImporteSubtotal
       ,cit.fImpuestosRetenidos
       ,cit.fImpuestosTrasladados
       ,cit.fDescuento
       ,cit.fImporteTotal
       ,cit.fImporteTotalSinIVA
       ,cit.iNoFacturable
       ,cit.skMetodoPago
       ,cit.skFormaPago
       ,cit.skUsoCFDI
       ,cit.skUsuarioConfirmacion
       ,cit.dFechaConfirmacion
       ,cit.sObservacionesFinalizacion
       ,cit.skUsuarioFinalizacion
       ,cit.dFechaFinalizacion
       ,cit.sObservacionesCancelacion
       ,cit.skUsuarioCancelacion
       ,cit.dFechaCancelacion
       ,cit.skUsuarioCreacion
       ,cit.dFechaCreacion
       ,cit.skUsuarioModificacion
       ,cit.dFechaModificacion

       ,cate.sNombreCategoria
       ,cate.sClaveCategoriaCita
       ,cate.iMinutosDuracion
       ,cate.sColorCategoria

       ,est.sNombre AS estatus
       ,est.sIcono AS estatusIcono
       ,est.sColor AS estatusColor

       ,esMX.sNombre AS estado
       ,muMX.sNombre AS municipio

       ,IF(cit.sNombreCliente IS NOT NULL, cit.sNombreCliente, IF(e_cli.sNombreCorto IS NOT NULL, e_cli.sNombreCorto, e_cli.sNombre)) AS sNombreCliente
       ,IF(e_cli.sNombreCorto IS NOT NULL, e_cli.sNombreCorto, e_cli.sNombre) AS empresaCliente
       ,e_cli.sRFC AS empresaClienteRFC
       ,IF(e_fac.sNombreCorto IS NOT NULL, e_fac.sNombreCorto, e_fac.sNombre) AS empresaFacturacion
       ,e_fac.sRFC AS empresaFacturacionRFC
       
       ,CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion
       ,CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion
       ,CONCAT(uConf.sNombre,' ',uConf.sApellidoPaterno,' ',uConf.sApellidoMaterno) AS usuarioConfirmacion
       ,CONCAT(uFin.sNombre,' ',uFin.sApellidoPaterno,' ',uFin.sApellidoMaterno) AS usuarioFinalizacion
       ,CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion
       
       ,di.sNombre AS divisa

       FROM ope_citas cit
       INNER JOIN cat_citas_categorias cate ON cate.skCategoriaCita = cit.skCategoriaCita
       INNER JOIN core_estatus est ON est.skEstatus = cit.skEstatus
       INNER JOIN cat_estadosMX esMX ON esMX.skEstadoMX = cit.skEstadoMX
       INNER JOIN cat_municipiosMX muMX ON muMX.skMunicipioMX = cit.skMunicipioMX
       INNER JOIN cat_usuarios uCre ON uCre.skUsuario = cit.skUsuarioCreacion
       INNER JOIN rel_empresasSocios res_cli ON res_cli.skEmpresaSocio = cit.skEmpresaSocioCliente
       INNER JOIN cat_empresas e_cli ON e_cli.skEmpresa = res_cli.skEmpresa
       LEFT JOIN rel_empresasSocios res_fac ON res_fac.skEmpresaSocio = cit.skEmpresaSocioFacturacion
       LEFT JOIN cat_empresas e_fac ON e_fac.skEmpresa = res_fac.skEmpresa
       LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = cit.skUsuarioModificacion
       LEFT JOIN cat_usuarios uConf ON uConf.skUsuario = cit.skUsuarioConfirmacion
       LEFT JOIN cat_usuarios uFin ON uFin.skUsuario = cit.skUsuarioFinalizacion
       LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = cit.skUsuarioCancelacion
       LEFT JOIN cat_divisas di ON di.skDivisa = cit.skDivisa
       WHERE 1=1 ";
        
        if(!isset($_POST['filters'])){
            //$configuraciones['query'] .= " AND cit.skEstatus != 'CA' ";
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
                /*
                    1.- Editar
                    2.- Confirmar / Reprogramar
                    3.- Generar Formato
                    4.- Descargar PDF
                    5.- Generar Orden de Servicio
                    6.- Cancelar
                    7.- Finalizar
                    8.- Detalles
                */
                $regla = [
                    'menuEmergente1'=>($row['skEstatus'] == 'PE' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente2'=>(in_array($row['skEstatus'], ['PE','CF','FI']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente3'=>(in_array($row['skEstatus'], ['PE','CF','FI','VE']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente4'=>(in_array($row['skEstatus'], ['PE','CF','FI','VE']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente5'=>(in_array($row['skEstatus'], ['CF','FI']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente6'=>(in_array($row['skEstatus'], ['PE','CF']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente7'=>(in_array($row['skEstatus'], ['CF']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente8'=>SELF::HABILITADO
                ];
            
            // FORMATEO DE DATOS //
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : NULL;
                $row['dFechaCita'] = ($row['dFechaCita']) ? date('d/m/Y', strtotime($row['dFechaCita'])) : NULL;
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

    public function formatoPDF(){
        $formatoPDF = $this->sysAPI('cita', 'cita_deta', 'formatoPDF', [
            'GET' => [
                'p1' => (isset($_GET['id']) ? $_GET['id'] :  NULL),
                'directDownloadFile' => true
            ]
         ]);
         return true;
    }

    public function cancelar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cita['axn'] = 'cancelar_cita';
        $this->cita['skCita'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->cita['sObservaciones'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        $this->cita['skEstatus'] = 'CA';

        $stp_cita_agendar = parent::stp_cita_agendar();  
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }

    public function finalizar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cita['axn'] = 'finalizar_cita';
        $this->cita['skCita'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->cita['sObservaciones'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        $this->cita['skEstatus'] = 'FI';

        $stp_cita_agendar = parent::stp_cita_agendar();  
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL FINALIZAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }

}