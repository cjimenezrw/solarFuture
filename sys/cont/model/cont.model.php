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
            " .escape(isset($this->cont['skEmpresaSocioCliente']) ? $this->cont['skEmpresaSocioCliente'] : NULL) . ",
            " .escape(isset($this->cont['skTipoContrato']) ? $this->cont['skTipoContrato'] : NULL) . ",
            " .escape(isset($this->cont['dFechaInstalacion']) ? $this->cont['dFechaInstalacion'] : NULL) . ",
            " .escape(isset($this->cont['iFrecuenciaMantenimientoMensual']) ? $this->cont['iFrecuenciaMantenimientoMensual'] : NULL) . ",
            " .escape(isset($this->cont['iDiaMantenimiento']) ? $this->cont['iDiaMantenimiento'] : NULL) . ",
            " .escape(isset($this->cont['sTelefono']) ? $this->cont['sTelefono'] : NULL) . ",
            " .escape(isset($this->cont['sCorreo']) ? $this->cont['sCorreo'] : NULL) . ",
            " .escape(isset($this->cont['sDomicilio']) ? $this->cont['sDomicilio'] : NULL) . ",
            " .escape(isset($this->cont['sObservaciones']) ? $this->cont['sObservaciones'] : NULL) . ",
            " .escape(isset($this->cont['sObservacionesCancelacion']) ? $this->cont['sObservacionesCancelacion'] : NULL) . ",
            " .escape(isset($_SESSION['usuario']['skEmpresaSocioPropietario']) ? $_SESSION['usuario']['skEmpresaSocioPropietario'] : NULL) . ",
            
            " .escape(isset($this->cont['skOrdenServicio']) ? $this->cont['skOrdenServicio'] : NULL) . ",

            " .escape(isset($this->cont['axn']) ? $this->cont['axn'] : NULL) . ",
            " .escape($_SESSION['usuario']['skUsuario']). ",
            " .escape($this->sysController).")"; 

        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    } 

    public function _get_contratos() {

        $sql = "SELECT 
             oca.skContrato
            ,CONCAT('CON-', LPAD(oca.iFolio, 5, 0))  AS iFolio
            ,oca.skEstatus
            ,oca.skEmpresaSocioCliente
            ,oca.skTipoContrato
            ,oca.dFechaInstalacion
            ,oca.iFrecuenciaMantenimientoMensual
            ,oca.iDiaMantenimiento
            ,oca.sTelefono
            ,oca.sCorreo
            ,oca.sDomicilio
            ,oca.sObservaciones
            ,oca.skEmpresaSocioPropietario
            ,oca.sObservacionesCancelacion
            ,oca.dFechaCancelacion
            ,oca.skUsuarioCancelacion
            ,oca.dFechaCreacion
            ,oca.skUsuarioCreacion
            ,oca.dFechaModificacion
            ,oca.skUsuarioModificacion
            
            ,est.sNombre AS estatus
            ,est.sColor AS estatusColor
            ,est.sIcono AS estatusIcono

            ,e.sNombre AS cliente

            ,CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion
            ,CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion
            ,CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion

            ,TIPCON.sNombre AS tipoContrato
        
            FROM ope_contratos oca
            INNER JOIN core_estatus est ON est.skEstatus = oca.skEstatus
            INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = oca.skEmpresaSocioCliente
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN cat_usuarios uCre ON uCre.skUsuario = oca.skUsuarioCreacion 
            LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = oca.skUsuarioModificacion
            LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = oca.skUsuarioCancelacion
            INNER JOIN rel_catalogosSistemasOpciones TIPCON ON TIPCON.skCatalogoSistema = 'TIPCON' AND TIPCON.skClave = oca.skTipoContrato
            WHERE 1 = 1 ";

        if(isset($this->cont['skContrato']) && !empty($this->cont['skContrato'])){
            if(is_array($this->cont['skContrato'])){
                $sql .= " AND oca.skContrato IN (" . mssql_where_in($this->cont['skContrato']) . ") ";
            }else{
                $sql .= " AND oca.skContrato = " . escape($this->cont['skContrato']);
            }
        }

        if(isset($this->cont['skEmpresaSocioCliente']) && !empty($this->cont['skEmpresaSocioCliente'])){
            if(is_array($this->cont['skEmpresaSocioCliente'])){
                $sql .= " AND oca.skEmpresaSocioCliente IN (" . mssql_where_in($this->cont['skEmpresaSocioCliente']) . ") ";
            }else{
                $sql .= " AND oca.skEmpresaSocioCliente = " . escape($this->cont['skEmpresaSocioCliente']);
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

    public function get_empresas() {
        $sql = "SELECT N1.* FROM (
            SELECT
            es.skEmpresaSocio AS id
            ,CONCAT(e.sNombre,' (', IF(e.sRFC IS NOT NULL,e.sRFC,IF(e.sTelefono IS NOT NULL,e.sTelefono,IF(e.sCorreo IS NOT NULL,e.sCorreo,NULL))),') - ',et.sNombre) AS nombre
            ,es.skEmpresaTipo
            ,e.sTelefono
            ,e.sCorreo
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

    public function _getTiposPeriodos() {
        $sql = "SELECT cd.skTipoPeriodo, cd.sNombre AS sNombre FROM cat_tiposPeriodos cd WHERE skEstatus='AC' ORDER BY cf.sNombre ASC";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_formasPago() {
        $sql = "SELECT CONCAT('(',cf.sCodigo,') ',cf.sNombre)  AS sNombre,cf.sCodigo FROM cat_formasPago cf  WHERE cf.skEstatus = 'AC' ORDER BY cf.sNombre ASC";
        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_metodosPago() {
        $sql = "SELECT  CONCAT('(',cm.sCodigo,') ',cm.sNombre) AS sNombre,cm.sCodigo FROM cat_metodosPago cm WHERE cm.skEstatus = 'AC' ORDER BY cm.sNombre ASC";
        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_usosCFDI() {
        $sql = "SELECT CONCAT('(',cu.sClave,') ',cu.sNombre) AS sNombre,cu.sClave AS sCodigo FROM cat_usosCFDI cu where cu.skEstatus = 'AC' ORDER BY cu.sNombre ASC";
        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

}
