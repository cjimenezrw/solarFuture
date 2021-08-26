<?php
Class Docu_Model Extends DLOREAN_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
        protected $docu = [];

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() { }

    public function __destruct() { }

    public function _get_documentos(){

        $DOCUME = parent::getVariable('DOCUME');
        $EXPEDIENTE = DIR_PROJECT.$DOCUME;
        
        $sql = "SELECT 
            doc.skDocumento, 
            doc.skEstatus, 
            doc.skTipoExpediente, 
            doc.skTipoDocumento, 
            doc.skCodigo, 
            doc.sNombre, 
            doc.sNombreOriginal, 
            CONCAT(".escape($EXPEDIENTE).",doc.sUbicacion) AS sUbicacion,
            CONCAT(".escape(SYS_URL.$DOCUME).",doc.sUbicacion) AS sUbicacionPublica,
            CONCAT(".escape(SYS_URL.$DOCUME).",doc.sUbicacion) AS sUbicacionPublicaThumbnail, 
            doc.dFechaCreacion, 
            doc.skUsuarioCreacion, 
            doc.dFechaModificacion, 
            doc.skUsuarioModificacion,
            ex.sNombre AS sExpediente,
            td.sNombre AS sTipoDocumento,
            est.sNombre AS estatus,
            est.sIcono AS estatusIcono,
            est.sColor AS estatusColor,
            CONCAT(uC.sNombre,' ',uC.sApellidoPaterno) AS usuarioCreacion
            FROM ope_docu_documentos doc
            INNER JOIN cat_docu_tiposExpedientes ex ON ex.skTipoExpediente = doc.skTipoExpediente
            INNER JOIN cat_docu_tiposDocumentos td ON td.skTipoDocumento = doc.skTipoDocumento
            INNER JOIN core_estatus est ON est.skEstatus = doc.skEstatus
            INNER JOIN cat_usuarios uC ON uC.skUsuario = doc.skUsuarioCreacion
            WHERE 1=1 ";
        
        if(isset($this->docu['skDocumento']) && !empty($this->docu['skDocumento'])){
            if(is_array($this->docu['skDocumento'])){
                $sql .= " AND doc.skDocumento IN (" . mssql_where_in($this->docu['skDocumento']) . ") ";
            }else{
                $sql .= " AND doc.skDocumento = " . escape($this->docu['skDocumento']);
            }
        }

        if(isset($this->docu['skCodigo']) && !empty($this->docu['skCodigo'])){
            if(is_array($this->docu['skCodigo'])){
                $sql .= " AND doc.skCodigo IN (" . mssql_where_in($this->docu['skCodigo']) . ") ";
            }else{
                $sql .= " AND doc.skCodigo = " . escape($this->docu['skCodigo']);
            }
        }

        if(isset($this->docu['skTipoExpediente']) && !empty($this->docu['skTipoExpediente'])){
            if(is_array($this->docu['skTipoExpediente'])){
                $sql .= " AND doc.skTipoExpediente IN (" . mssql_where_in($this->docu['skTipoExpediente']) . ") ";
            }else{
                $sql .= " AND doc.skTipoExpediente = " . escape($this->docu['skTipoExpediente']);
            }
        }

        if(isset($this->docu['skTipoDocumento']) && !empty($this->docu['skTipoDocumento'])){
            if(is_array($this->docu['skTipoDocumento'])){
                $sql .= " AND doc.skTipoDocumento IN (" . mssql_where_in($this->docu['skTipoDocumento']) . ") ";
            }else{
                $sql .= " AND doc.skTipoDocumento = " . escape($this->docu['skTipoDocumento']);
            }
        }

        if(isset($this->docu['skEstatus']) && !empty($this->docu['skEstatus'])){
            if(is_array($this->docu['skEstatus'])){
                $sql .= " AND doc.skEstatus IN (" . mssql_where_in($this->docu['skEstatus']) . ") ";
            }else{
                $sql .= " AND doc.skEstatus = " . escape($this->docu['skEstatus']);
            }
        }
        
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_documentos_caracteristicas(){
        $sql = "SELECT * FROM rel_docu_documentos_caracteristicas docca
        INNER JOIN cat_caracteristicas ca ON ca.skCaracteristica = docca.skCaracteristica
        WHERE 1=1 ";

        if(isset($this->docu['skDocumento']) && !empty($this->docu['skDocumento'])){
            if(is_array($this->docu['skDocumento'])){
                $sql .= " AND docca.skDocumento IN (" . mssql_where_in($this->docu['skDocumento']) . ") ";
            }else{
                $sql .= " AND docca.skDocumento = " . escape($this->docu['skDocumento']);
            }
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_tiposExpedientes_tiposDocumentos(){
        $sql = "SELECT 
            extd.*,
            ex.sNombre AS tipoExpediente,
            td.sNombre AS tipoDocumento
            FROM rel_docu_tiposExpedientes_tiposDocumentos extd
            INNER JOIN cat_docu_tiposExpedientes ex ON ex.skTipoExpediente = extd.skTipoExpediente
            INNER JOIN cat_docu_tiposDocumentos td ON td.skTipoDocumento = extd.skTipoDocumento
            WHERE 1=1 ";

        if(isset($this->docu['skDocumento']) && !empty($this->docu['skDocumento'])){
            if(is_array($this->docu['skDocumento'])){
                $sql .= " AND extd.skDocumento IN (" . mssql_where_in($this->docu['skDocumento']) . ") ";
            }else{
                $sql .= " AND extd.skDocumento = " . escape($this->docu['skDocumento']);
            }
        }

        if(isset($this->docu['skTipoExpediente']) && !empty($this->docu['skTipoExpediente'])){
            if(is_array($this->docu['skTipoExpediente'])){
                $sql .= " AND extd.skTipoExpediente IN (" . mssql_where_in($this->docu['skTipoExpediente']) . ") ";
            }else{
                $sql .= " AND extd.skTipoExpediente = " . escape($this->docu['skTipoExpediente']);
            }
        }

        if(isset($this->docu['skTipoDocumento']) && !empty($this->docu['skTipoDocumento'])){
            if(is_array($this->docu['skTipoDocumento'])){
                $sql .= " AND extd.skTipoDocumento IN (" . mssql_where_in($this->docu['skTipoDocumento']) . ") ";
            }else{
                $sql .= " AND extd.skTipoDocumento = " . escape($this->docu['skTipoDocumento']);
            }
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_tiposDocumentos_extensiones(){
        $sql = "SELECT
            ex.sExtension,sContentType
            FROM rel_docu_tiposDocumentos_extensiones tdex
            INNER JOIN cat_extensionesDocumentos ex ON ex.skExtensionDocumento = tdex.skExtensionDocumento
            WHERE 1=1 ";

        if(isset($this->docu['skTipoDocumento']) && !empty($this->docu['skTipoDocumento'])){
            if(is_array($this->docu['skTipoDocumento'])){
                $sql .= " AND tdex.skTipoDocumento IN (" . mssql_where_in($this->docu['skTipoDocumento']) . ") ";
            }else{
                $sql .= " AND tdex.skTipoDocumento = " . escape($this->docu['skTipoDocumento']);
            }
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_tiposDocumentos_caracteristicas(){
        $sql = "SELECT ca.*,
            tdca.skTipoDocumentoCaracteristica, 
            tdca.skTipoDocumento, 
            IF(tdca.sValor IS NOT NULL, tdca.sValor, ca.sValorDefault) AS sValor,
            IF(tdca.sValorTexto IS NOT NULL, tdca.sValorTexto, ca.sValorTextoDefault) AS sValorTexto
            FROM rel_docu_tiposDocumentos_caracteristicas tdca
            INNER JOIN cat_caracteristicas ca ON ca.skCaracteristica = tdca.skCaracteristica
            WHERE 1=1 ";

        if(isset($this->docu['skTipoDocumento']) && !empty($this->docu['skTipoDocumento'])){
            if(is_array($this->docu['skTipoDocumento'])){
                $sql .= " AND tdca.skTipoDocumento IN (" . mssql_where_in($this->docu['skTipoDocumento']) . ") ";
            }else{
                $sql .= " AND tdca.skTipoDocumento = " . escape($this->docu['skTipoDocumento']);
            }
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_tiposExpedientes(){
        $sql = "SELECT
            ex.*,
            est.sNombre AS estatus,
            est.sIcono AS estatusIcono,
            est.sColor AS estatusColor,
            CONCAT(uC.sNombre,' ',uC.sApellidoPaterno) AS usuarioCreacion,
            CONCAT(uM.sNombre,' ',uM.sApellidoPaterno) AS usuarioModificacion
            FROM cat_docu_tiposExpedientes ex
            INNER JOIN core_estatus est ON est.skEstatus = ex.skEstatus
            INNER JOIN cat_usuarios uC ON uC.skUsuario = ex.skUsuarioCreacion
            LEFT JOIN cat_usuarios uM ON uM.skUsuario = ex.skUsuarioModificacion 
            WHERE 1=1 ";

        if(isset($this->docu['skTipoExpediente']) && !empty($this->docu['skTipoExpediente'])){
            if(is_array($this->docu['skTipoExpediente'])){
                $sql .= " AND ex.skTipoExpediente IN (" . mssql_where_in($this->docu['skTipoExpediente']) . ") ";
            }else{
                $sql .= " AND ex.skTipoExpediente = " . escape($this->docu['skTipoExpediente']);
            }
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_tiposDocumentos(){
        $sql = "SELECT
            td.*,
            est.sNombre AS estatus,
            est.sIcono AS estatusIcono,
            est.sColor AS estatusColor,
            CONCAT(uC.sNombre,' ',uC.sApellidoPaterno) AS usuarioCreacion,
            CONCAT(uM.sNombre,' ',uM.sApellidoPaterno) AS usuarioModificacion
            FROM cat_docu_tiposExpedientes td
            INNER JOIN core_estatus est ON est.skEstatus = td.skEstatus
            INNER JOIN cat_usuarios uC ON uC.skUsuario = td.skUsuarioCreacion
            LEFT JOIN cat_usuarios uM ON uM.skUsuario = td.skUsuarioModificacion 
            WHERE 1=1 ";

            if(isset($this->docu['skTipoDocumento']) && !empty($this->docu['skTipoDocumento'])){
                if(is_array($this->docu['skTipoDocumento'])){
                    $sql .= " AND td.skTipoDocumento IN (" . mssql_where_in($this->docu['skTipoDocumento']) . ") ";
                }else{
                    $sql .= " AND td.skTipoDocumento = " . escape($this->docu['skTipoDocumento']);
                }
            }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function stp_docu_documentos(){

        /*
            skDocumento CHAR(36),
            skEstatus CHAR(2),
            skTipoExpediente CHAR(6),
            skTipoDocumento CHAR(6),
            skCodigo CHAR(36),
            sNombre VARCHAR(500),
            sNombreOriginal VARCHAR(500),
            sUbicacion VARCHAR(500),
            sExtension VARCHAR(200),

            axn VARCHAR(300),
            skUsuario CHAR(36),
            skModulo CHAR(9)
        */

        return $this->call_stp([
            'stp'=>'stp_docu_documentos',
            'obj'=>$this->docu,
            'stp_params'=>[
                'skDocumento',
                'skEstatus'=>'AC',
                'skTipoExpediente',
                'skTipoDocumento',
                'skCodigo',
                'sNombre',
                'sNombreOriginal',
                'sUbicacion',
                'sExtension',

                'axn',
                'skUsuario'=>$_SESSION['usuario']['skUsuario'],
                'skModulo'=>$this->sysController
            ]
        ]);
    }

    public function call_stp($conf = []){

        if(empty($conf['stp'])){
            return FALSE;
        }

        $sql = "CALL ".escape($conf['stp'], FALSE)." ( \n";

        if(empty($conf['stp_params'])){
            return FALSE;
        }

        if(empty($conf['obj'])){
            return FALSE;
        }

        $i = 1;
        $prepare_stp_params = [];
        foreach($conf['stp_params'] AS $k=>$v){

            if(is_numeric($k)){
                $sql .= escape(isset($conf['obj'][$v]) ? $conf['obj'][$v] : NULL);
                array_push($prepare_stp_params,escape(isset($conf['obj'][$v]) ? $conf['obj'][$v] : NULL));
            }else{
                $sql .= escape(isset($conf['stp_params'][$k]) ? $conf['stp_params'][$k] : NULL);
                array_push($prepare_stp_params,escape(isset($conf['stp_params'][$k]) ? $conf['stp_params'][$k] : NULL));
            }

            if($i < count($conf['stp_params'])){
                $sql .= ",\n";
            }
            $i++;
        }

        $sql .= "\n ); ";
        
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }

}