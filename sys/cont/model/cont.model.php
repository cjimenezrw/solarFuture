<?php
Class Cont_Model Extends DLOREAN_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
        protected $cont = [];

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() { }

    public function __destruct() { }
 
    public function stpCUD_contratos(){
        $sql = "CALL stpCUD_contratos (
            " .escape(isset($this->cont['skContrato']) ? $this->cont['skContrato'] : NULL) . ",
            " .escape(isset($this->cont['skEstatus']) ? $this->cont['skEstatus'] : NULL) . ",
            " .escape(isset($this->cont['skEstatusContrato']) ? $this->cont['skEstatusContrato'] : NULL) . ",
            " .escape(isset($this->cont['skContratoRemplazo']) ? $this->cont['skContratoRemplazo'] : NULL) . ",
            " .escape(isset($this->cont['skEmpresaSocioCliente']) ? $this->cont['skEmpresaSocioCliente'] : NULL) . ",
            " .escape(isset($this->cont['skEmpresaSocioFacturacion']) ? $this->cont['skEmpresaSocioFacturacion'] : NULL) . ",
            " .escape(isset($_SESSION['usuario']['skEmpresaSocioPropietario']) ? $_SESSION['usuario']['skEmpresaSocioPropietario'] : NULL) . ",            
            
            " .escape(isset($this->cont['skFormaPago']) ? $this->cont['skFormaPago'] : NULL) . ",
            " .escape(isset($this->cont['skMetodoPago']) ? $this->cont['skMetodoPago'] : NULL) . ",
            " .escape(isset($this->cont['skUsoCFDI']) ? $this->cont['skUsoCFDI'] : NULL) . ",
            
            " .escape(isset($this->cont['dFechaInicioContrato']) ? $this->cont['dFechaInicioContrato'] : NULL) . ",
            " .escape(isset($this->cont['dFechaInicioCobro']) ? $this->cont['dFechaInicioCobro'] : NULL) . ",
            " .escape(isset($this->cont['iDiaCorte']) ? $this->cont['iDiaCorte'] : NULL) . ",
            " .escape(isset($this->cont['iNoFacturable']) ? $this->cont['iNoFacturable'] : NULL) . ",
            " .escape(isset($this->cont['skTipoPeriodo']) ? $this->cont['skTipoPeriodo'] : NULL) . ",
            
            " .escape(isset($this->cont['sReporteInstalacion']) ? $this->cont['sReporteInstalacion'] : NULL) . ",
            " .escape(isset($this->cont['sDireccion']) ? $this->cont['sDireccion'] : NULL) . ",
            " .escape(isset($this->cont['sTelefono']) ? $this->cont['sTelefono'] : NULL) . ",
            " .escape(isset($this->cont['sCorreo']) ? $this->cont['sCorreo'] : NULL) . ",
            " .escape(isset($this->cont['sDetallesServicio']) ? $this->cont['sDetallesServicio'] : NULL) . ",

            " .escape(isset($this->cont['skOrdenServicio']) ? $this->cont['skOrdenServicio'] : NULL) . ",




            " .escape(isset($this->cont['axn']) ? $this->cont['axn'] : NULL) . ",
            " .escape($_SESSION['usuario']['skUsuario']). ",
            " .escape($this->sysController)." )"; 
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    } 

    public function _get_contratos() {

        $sql = "SELECT 
        oca.iFolio,
        oca.skContrato,
        oca.skEstatus,
        oca.skEstatusContrato,
        oca.skEmpresaSocioCliente,
        oca.skEmpresaSocioFacturacion,
        oca.skContratoRemplazo,
        
        oca.skFormaPago,
        oca.skMetodoPago,
        oca.skUsoCFDI,
        oca.dFechaCreacion,
        oca.dFechaInicioCobro,
        oca.dFechaInicioContrato,
        
        oca.iDiaCorte,
        oca.iNoFacturable,
        
        oca.sCorreo,
        oca.skTipoPeriodo,
        
        oca.sReporteInstalacion,
        oca.sDireccion,
        
        oca.sTelefono,
        oca.sDetallesServicio,
        ce.sNombre AS estatus,
        ce.sColor AS estatusColor,
        ce.sIcono AS estatusIcono ,
        cec.sNombre AS cliente,
        cecf.sNombre AS facturacion,
        cuc.sNombre AS usuarioCreacion,
        
        ctp.sNombre AS tipoPeriodo
        
        FROM ope_contratos oca
        LEFT JOIN core_estatus ce ON ce.skEstatus = oca.skEstatus
        LEFT JOIN cat_usuarios cuc ON cuc.skUsuario = oca.skUsuarioCreacion 
        LEFT JOIN rel_empresasSocios res ON res.skEmpresaSocio = oca.skEmpresaSocioCliente
        LEFT JOIN cat_empresas cec ON cec.skEmpresa = res.skEmpresa
        LEFT JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = oca.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas cecf ON cecf.skEmpresa = resf.skEmpresa
        LEFT JOIN core_estatus ceco ON ceco.skEstatus = oca.skEstatusContrato
        LEFT JOIN cat_tiposPeriodos ctp ON ctp.skTipoPeriodo = oca.skTipoPeriodo
        WHERE 1 = 1 ";

        if(isset($this->cont['skContrato']) && !empty($this->cont['skContrato'])){
            if(is_array($this->cont['skContrato'])){
                $sql .= " AND oca.skContrato IN (" . mssql_where_in($this->cont['skContrato']) . ") ";
            }else{
                $sql .= " AND oca.skContrato = " . escape($this->cont['skContrato']);
            }
        }

        if(isset($this->cont['skTorre']) && !empty($this->cont['skTorre'])){
            if(is_array($this->cont['skTorre'])){
                $sql .= " AND cto.skTorre IN (" . mssql_where_in($this->cont['skTorre']) . ") ";
            }else{
                $sql .= " AND cto.skTorre = " . escape($this->cont['skTorre']);
            }
        }

        if(isset($this->cont['skAccessPoint']) && !empty($this->cont['skAccessPoint'])){
            if(is_array($this->cont['skAccessPoint'])){
                $sql .= " AND oca.skAccessPoint IN (" . mssql_where_in($this->cont['skAccessPoint']) . ") ";
            }else{
                $sql .= " AND oca.skAccessPoint = " . escape($this->cont['skAccessPoint']);
            }
        }

        if(isset($this->cont['skEstatus']) && !empty($this->cont['skEstatus'])){
            if(is_array($this->cont['skEstatus'])){
                $sql .= " AND oca.skEstatus IN (" . mssql_where_in($this->cont['skEstatus']) . ") ";
            }else{
                $sql .= " AND oca.skEstatus = " . escape($this->cont['skEstatus']);
            }
        }

        $sql .= " ORDER BY oca.dFechaCreacion DESC ";
        
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
        return $result;
        }

        if(isset($this->cont['skContrato']) && !empty($this->cont['skContrato'])){
            $records = Conn::fetch_assoc($result);
        }else{
            $records = Conn::fetch_assoc_all($result);
        }

        utf8($records, FALSE);
        return $records;
    }

    /**
     * _get_contratos_cobros
     *
     *
     * @author luisalberto1192 <lvaldez>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _get_contratos_cobros() {

        $sql = "SELECT 
                        rcc.iAnio,
                        rcc.iMes,
                        rcc.iDia,
                        rcc.dFechaCreacion,
                        rcc.skEstatus,
                        rcc.sDescripcion,
                        rcc.skContratoCobro,
                        rcc.skContrato,
                        rcc.skTipoPeriodo,
                        CONCAT('ORD-', LPAD(oos.iFolio, 5, 0))  AS iFolio,
                        ctp.sNombre AS tipoPeriodo,
                        IF(iNoFacturable IS NOT NULL, oos.fImporteTotalSinIva, oos.fImporteTotal) AS fImporteTotal
		                FROM rel_contratos_cobros rcc 
                        LEFT JOIN ope_ordenesServicios oos ON oos.skOrdenServicio = rcc.skOrdenServicio
                        LEFT JOIN cat_tiposPeriodos ctp ON ctp.skTipoPeriodo = rcc.skTipoPeriodo
                        WHERE 1 = 1 ";

        if(isset($this->cont['skContrato']) && !empty($this->cont['skContrato'])){
            if(is_array($this->cont['skContrato'])){
                $sql .= " AND rcc.skContrato IN (" . mssql_where_in($this->cont['skContrato']) . ") ";
            }else{
                $sql .= " AND rcc.skContrato = " . escape($this->cont['skContrato']);
            }
        } 
        $sql .= " ORDER BY rcc.dFechaCreacion ASC";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }



    /**
     * get_empresas
     *
     * Consulta Empresas Socios
     *
     * @author Luis Valdez <lvaldez>
     * @return Array Datos | False
     */
    public function get_empresas() {
        $sql = "SELECT N1.* FROM (
            SELECT
            es.skEmpresaSocio AS id, CONCAT(e.sNombre,' (', IF(e.sRFC IS NOT NULL,e.sRFC,IF(e.sTelefono IS NOT NULL,e.sTelefono,IF(e.sCorreo IS NOT NULL,e.sCorreo,NULL))),') - ',et.sNombre) AS nombre, es.skEmpresaTipo
            FROM rel_empresasSocios es
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo
            WHERE es.skEstatus = 'AC' AND e.skEstatus = 'AC' AND es.skEmpresaSocioPropietario = " . escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

        if (isset($this->cont['skEmpresaTipo']) && !empty($this->cont['skEmpresaTipo'])) {
            if (is_array($this->cont['skEmpresaTipo'])) {
                $sql .= " AND es.skEmpresaTipo IN (" . mssql_where_in($this->cont['skEmpresaTipo']) . ") ";
            } else {
                $sql .= " AND es.skEmpresaTipo = " . escape($this->cont['skEmpresaTipo']);
            }
        }

        $sql .= " ) AS N1 ";

        if (isset($this->cont['sNombre']) && !empty(trim($this->cont['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->cont['sNombre']) . "%' ";
        }

        if (isset($this->cont['skEmpresaSocio']) && !empty($this->cont['skEmpresaSocio'])) {
            $sql .= " WHERE N1.id = " . escape($this->cont['skEmpresaSocio']);
        }

        $sql .= " ORDER BY N1.nombre ASC ";
       
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * get_servicios
     *
     * Consulta Empresas Socios
     *
     * @author Luis Valdez <lvaldez>
     * @return Array Datos | False
     */
    public function get_servicios() {
        $sql = "SELECT N1.* FROM (
            SELECT
            es.skServicio AS id,  es.sNombre  AS nombre 
            FROM cat_servicios es 
            WHERE es.skEstatus = 'AC'  ";

        $sql .= " ) AS N1 ";

        if (isset($this->cont['sNombre']) && !empty(trim($this->cont['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->cont['sNombre']) . "%' ";
        }

        $sql .= " ORDER BY N1.nombre ASC ";
   
       
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * _getAccessPoint
     *
     *
     * @author luisalberto1192 <lvaldez>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getAccessPoint() {

        $sql = "SELECT 
		                cd.skAccessPoint,
                        CONCAT('(',cd.sMAC,') ',cd.sNombre) AS sNombre
		                FROM cat_accessPoint cd WHERE skEstatus='AC'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * _getTiposPeriodos
     *
     *
     * @author luisalberto1192 <lvaldez>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getTiposPeriodos() {

        $sql = "SELECT 
		                cd.skTipoPeriodo,
                        cd.sNombre AS sNombre
		                FROM cat_tiposPeriodos cd WHERE skEstatus='AC'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _get_torres($params = []){
        $sql = "SELECT
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

        if(isset($params['skTorre']) && !empty($params['skTorre'])){
            if(is_array($params['skTorre'])){
                $sql .= " AND tor.skTorre IN (" . mssql_where_in($params['skTorre']) . ") ";
            }else{
                $sql .= " AND tor.skTorre = " . escape($params['skTorre']);
            }
        }

        if(isset($params['skEstatus']) && !empty($params['skEstatus'])){
            if(is_array($params['skEstatus'])){
                $sql .= " AND tor.skEstatus IN (" . mssql_where_in($params['skEstatus']) . ") ";
            }else{
                $sql .= " AND tor.skEstatus = " . escape($params['skEstatus']);
            }
        }

        $sql .= " ORDER BY tor.dFechaCreacion DESC ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
        return $result;
        }

        if(isset($params['skTorre']) && !empty($params['skTorre'])){
            $records = Conn::fetch_assoc($result);
        }else{
            $records = Conn::fetch_assoc_all($result);
        }

        utf8($records, FALSE);
        return $records;
    }

    public function _get_accessPoint($params = []){
        $sql = "SELECT
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

        if(isset($params['skAccessPoint']) && !empty($params['skAccessPoint'])){
            if(is_array($params['skAccessPoint'])){
                $sql .= " AND ap.skAccessPoint IN (" . mssql_where_in($params['skAccessPoint']) . ") ";
            }else{
                $sql .= " AND ap.skAccessPoint = " . escape($params['skAccessPoint']);
            }
        }

        if(isset($params['skTorre']) && !empty($params['skTorre'])){
            if(is_array($params['skTorre'])){
                $sql .= " AND ap.skTorre IN (" . mssql_where_in($params['skTorre']) . ") ";
            }else{
                $sql .= " AND ap.skTorre = " . escape($params['skTorre']);
            }
        }

        if(isset($params['skEstatus']) && !empty($params['skEstatus'])){
            if(is_array($params['skEstatus'])){
                $sql .= " AND ap.skEstatus IN (" . mssql_where_in($params['skEstatus']) . ") ";
            }else{
                $sql .= " AND ap.skEstatus = " . escape($params['skEstatus']);
            }
        }

        $sql .= " ORDER BY ap.dFechaCreacion DESC ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
        return $result;
        }

        if(isset($params['skAccessPoint']) && !empty($params['skAccessPoint'])){
            $records = Conn::fetch_assoc($result);
        }else{
            $records = Conn::fetch_assoc_all($result);
        }

        utf8($records, FALSE);
        return $records;
    }

    public function stp_torres(){
        $sql = "CALL stp_torres (
            ".escape(isset($this->cont['skTorre']) ? $this->cont['skTorre'] : NULL).",
            ".escape(isset($this->cont['skEstatus']) ? $this->cont['skEstatus'] : NULL).",
            ".escape(isset($this->cont['sMAC']) ? $this->cont['sMAC'] : NULL).",
            ".escape(isset($this->cont['sNombre']) ? $this->cont['sNombre'] : NULL).",
            ".escape(isset($this->cont['sObservaciones']) ? $this->cont['sObservaciones'] : NULL).",

            ".escape(isset($this->cont['axn']) ? $this->cont['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
        
        //exit('<pre>'.print_r($sql,1).'</pre>');

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

    public function stp_accessPoint(){
        $sql = "CALL stp_accessPoint (
            ".escape(isset($this->cont['skAccessPoint']) ? $this->cont['skAccessPoint'] : NULL).",
            ".escape(isset($this->cont['skTorre']) ? $this->cont['skTorre'] : NULL).",
            ".escape(isset($this->cont['skEstatus']) ? $this->cont['skEstatus'] : NULL).",
            ".escape(isset($this->cont['sMAC']) ? $this->cont['sMAC'] : NULL).",
            ".escape(isset($this->cont['sNombre']) ? $this->cont['sNombre'] : NULL).",
            ".escape(isset($this->cont['sObservaciones']) ? $this->cont['sObservaciones'] : NULL).",

            ".escape(isset($this->cont['axn']) ? $this->cont['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
        
        //exit('<pre>'.print_r($sql,1).'</pre>');

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

    public function consultar_formasPago() {
        $sql = "SELECT CONCAT('(',cf.sCodigo,') ',cf.sNombre)  AS sNombre,cf.sCodigo FROM cat_formasPago cf  WHERE cf.skEstatus = 'AC'  ORDER BY cf.sNombre ASC   ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }
    public function consultar_metodosPago() {
        $sql = "SELECT  CONCAT('(',cm.sCodigo,') ',cm.sNombre) AS sNombre,cm.sCodigo FROM cat_metodosPago cm WHERE cm.skEstatus = 'AC'  ORDER BY cm.sNombre ASC   ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_usosCFDI() {

        $sql = "SELECT CONCAT('(',cu.sClave,') ',cu.sNombre) AS sNombre,cu.sClave AS sCodigo FROM cat_usosCFDI cu where cu.skEstatus = 'AC' ORDER BY cu.sNombre ASC  ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    

 


}
