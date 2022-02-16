<?php
Class Admi_Model Extends DLOREAN_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    protected $admi = array(); 
  
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        //parent::__construct();
    }

    public function __destruct() {

    }
   
 
    public function stpCUD_cobros() {

        $sql = "CALL stpCUD_cobros (
            " .escape(isset($this->admi['skOrdenServicio']) ? $this->admi['skOrdenServicio'] : NULL) . ",
            " .escape(isset($this->admi['skCodigo']) ? $this->admi['skCodigo'] : NULL) . ",
            " .escape(isset($this->admi['skProceso']) ? $this->admi['skProceso'] : NULL) . ", 
            " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";      
        
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }
    public function stpCUD_cobrosCO() {

        $sql = "CALL stpCUD_cobros (
            " .escape(isset($this->admi['skOrdenServicio']) ? $this->admi['skOrdenServicio'] : NULL) . ",
            " .escape(isset($this->admi['skCodigo']) ? $this->admi['skCodigo'] : NULL) . ",
            " .escape(isset($this->admi['skProceso']) ? $this->admi['skProceso'] : NULL) . ", 
            " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
       
        $this->log($sql, true);
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record; 
    }

    public function stpCUD_servicios() {

        $sql = "CALL stpCUD_servicios (
            ".escape(isset($this->admi['skServicio']) ? $this->admi['skServicio'] : NULL).",
            ".escape(isset($this->admi['skEstatus']) ? $this->admi['skEstatus'] : NULL).",
            ".escape(isset($this->admi['sCodigo']) ? $this->admi['sCodigo'] : NULL).",
            ".escape(isset($this->admi['sNombre']) ? $this->admi['sNombre'] : NULL).",
            ".escape(isset($this->admi['skUnidadMedida']) ? $this->admi['skUnidadMedida'] : NULL).",
            ".escape(isset($this->admi['iClaveProductoServicio']) ? $this->admi['iClaveProductoServicio'] : NULL).",
            ".escape(isset($this->admi['sDescripcion']) ? $this->admi['sDescripcion'] : NULL).",
            ".escape(isset($this->admi['skImpuestoServicio']) ? $this->admi['skImpuestoServicio'] : NULL).",
            ".escape(isset($this->admi['skCategoriaPrecio']) ? $this->admi['skCategoriaPrecio'] : NULL).",
            ".escape(isset($this->admi['fPrecio']) ? $this->admi['fPrecio'] : NULL).",
            ".escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
      
        if($this->admi['axn'] == 'guardar_servicio_precios'){
            //exit('<pre>'.print_r($sql,1).'</pre>');
        }

        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }


    /**
     * _getServicio
     *
     * Obtener Datos de Servicio guardado
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez>
     * @return Array Datos | False
     */
    public function _getServicio() {

        $sql = "SELECT cs.skServicio, 
                cs.sCodigo,
                cs.dFechaCreacion,
                cs.sNombre, 
                cs.sDescripcion, 
                cs.skUnidadMedida,
                cs.iClaveProductoServicio,
                ce.sNombre AS estatus,
                ce.sIcono AS estatusIcono,
                ce.sColor AS estatusColor,
                cum.sNombre AS unidadMedida, 
                cu.sNombre AS usuarioCreacion       
                FROM cat_servicios cs
                INNER JOIN core_estatus ce ON ce.skEstatus = cs.skEstatus
                INNER JOIN cat_usuarios cu ON cu.skUsuario = cs.skUsuarioCreacion
                LEFT JOIN cat_unidadesMedidaSAT cum ON cum.skUnidadMedida = cs.skUnidadMedida
                WHERE cs.skServicio =  " . escape($this->admi['skServicio']);
                

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }


    /**
       * consultar_unidadesMedida
       *
       * Obtiene los tipos de procesos activos para servicios
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez>
       * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
       */
      public function consultar_unidadesMedida() {
        $sql = "SELECT skUnidadMedida, CONCAT('(',sClaveSAT,') ', sNombre)  AS sNombre 
        FROM cat_unidadesMedidaSAT
        WHERE skEstatus = 'AC' ";


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * getImpuestos
     *
     * Obtiene los impuestos que pueden aplicar al servicio
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function getImpuestos() {
        $sql = "SELECT cim.skImpuesto AS id,CONCAT( cim.skTipoImpuesto,'-',cim.sNombre,'(', cim.svalor,'%)') AS nombre
                FROM cat_impuestos cim
                WHERE cim.skEstatus = 'AC' ";


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }


    public function _getServicioImpuestos() {
        $select = "SELECT cim.skImpuesto,CONCAT( cim.skTipoImpuesto,'-',cim.sNombre,'(', cim.svalor,'%)')  AS nombre 
                    FROM rel_servicios_impuestos  rci
                    INNER JOIN cat_impuestos cim ON cim.skImpuesto = rci.skImpuesto
                    where rci.skServicio = '".$this->admi['skServicio']."' ";
       
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _get_servicios_precios(){
        $sql = "SELECT rcp.*,cs.sNombre AS catalogo, cso.sNombre AS categoriaPrecio 
            FROM rel_servicios_precios rcp 
            INNER JOIN rel_catalogosSistemasOpciones cso ON cso.skCatalogoSistemaOpciones = rcp.skCategoriaPrecio
            INNER JOIN cat_catalogosSistemas cs ON cs.skCatalogoSistema = cso.skCatalogoSistema
            WHERE cs.skCatalogoSistema = 'CATPRE' AND cso.skEstatus = 'AC' 
            AND rcp.skServicio = ".escape($this->admi['skServicio'])." ORDER BY cso.sNombre ASC";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _getOrdenServicio(){
        $sql= "SELECT oos.skOrdenServicio, 
        CONCAT('ORD-', LPAD(oos.iFolio, 5, 0)) AS iFolio,
        oos.dFechaCreacion,
        oos.skEstatus,
        oos.skDivisa,
        oos.fImporteTotal,
        oos.iNoFacturable,
        oos.fImporteTotalSinIva,
        oos.sReferencia, 
        oos.sNombreCliente, 
        oos.fTipoCambio,
        oos.fImporteSubtotal,
        oos.fImpuestosRetenidos,
        oos.fImpuestosTrasladados,
        oos.fDescuento,
        oos.skMetodoPago,
        oos.skFormaPago,
        oos.skUsoCFDI,
        oos.skEmpresaSocioResponsable,
        oos.skEmpresaSocioCliente,
        oos.skEmpresaSocioFacturacion,
        oos.skEmpresaSocioPropietario,
        oos.sDescripcion,
        cer.sNombre AS responsable,
        cer.sRFC AS sRFCResponsable,
        cec.sNombre AS cliente,
        cef.sNombre AS facturacion,
        cef.sRFC AS sRFCReceptor,
        cep.sRFC AS sRFCEmisor,
        ce.sNombre AS estatus,
        ce.sIcono AS iconoEstatus,
        ce.sColor AS colorEstatus,
        cuc.sNombre AS usuarioCreacion,
        cc.sSerie,
        cc.skComprobante,
        '' AS folioServicio,
        rosp.skServicioProceso AS proceso,
        di.sNombre AS divisa,
        meto.sNombre AS metodoPago,
        form.sNombre AS formaPago,
        uso.sNombre AS usoCFDI,

        
        rosp.skCodigo AS skCodigoServicio,
        (SELECT  occ.iFolio   FROM rel_ordenesServicios_facturas rpf  INNER JOIN ope_facturas occ ON occ.skFactura = rpf.skFactura  AND occ.skEstatus !='CA' AND occ.iFolio IS NOT NULL WHERE rpf.skOrdenServicio = oos.skOrdenServicio LIMIT 1 ) AS iFolioFactura
        FROM ope_ordenesServicios oos
        LEFT JOIN core_estatus ce ON ce.skEstatus = oos.skEstatus
        LEFT JOIN rel_empresasSocios resr ON resr.skEmpresaSocio = oos.skEmpresaSocioResponsable
        LEFT JOIN cat_empresas cer ON cer.skEmpresa = resr.skEmpresa
        LEFT JOIN rel_empresasSocios resc ON resc.skEmpresaSocio = oos.skEmpresaSocioCliente
        LEFT JOIN cat_empresas cec ON cec.skEmpresa = resc.skEmpresa
        LEFT JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = oos.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas cef ON cef.skEmpresa = resf.skEmpresa
        LEFT JOIN rel_empresasSocios resp ON resp.skEmpresaSocio = oos.skEmpresaSocioPropietario
        LEFT JOIN cat_empresas cep ON cep.skEmpresa = resp.skEmpresa
        LEFT JOIN cat_usuarios cuc ON cuc.skUsuario = oos.skUsuarioCreacion
        LEFT JOIN rel_ordenesServicios_procesos rosp ON rosp.skOrdenServicio = oos.skOrdenServicio
        LEFT JOIN cat_comprobantes cc ON cc.skEmpresa = resp.skEmpresa AND cc.sClave = 'FA'
        LEFT JOIN cat_divisas di ON di.skDivisa = oos.skDivisa
        LEFT JOIN cat_metodosPago meto ON meto.sCodigo = oos.skMetodoPago
        LEFT JOIN cat_formasPago form ON form.sCodigo = oos.skFormaPago
        LEFT JOIN cat_usosCFDI uso ON uso.sClave = oos.skUsoCFDI
        WHERE 1 = 1  AND  oos.skOrdenServicio =  " . escape($this->admi['skOrdenServicio']);
        
        
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * _getOrdenServicioServicios
     *
     * Función Para obtener los datos de los almacenes
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getOrdenServicioServicios() {

        $sql = "SELECT
        ras.*,
        (cse.sNombre + IF(ras.sDescripcion IS NOT NULL, ' '+ras.sDescripcion,'') ) AS servicioFact,
        cse.sNombre AS servicio, 
        cum.sNombre AS unidadMedida,
        rsir.sValor AS RETIVA,
        rsit.sValor AS TRAIVA,
        (SELECT fImporte FROM rel_ordenesServicios_serviciosImpuestos rps where rps.skOrdenServicio = ras.skOrdenServicio AND rps.skServicio = ras.skServicio AND rps.skImpuesto = 'RETIVA' AND rps.skOrdenServicioServicio = ras.skOrdenServicioServicio )AS fImpuestosRetenidos,
        (SELECT fImporte FROM rel_ordenesServicios_serviciosImpuestos rps where rps.skOrdenServicio = ras.skOrdenServicio AND rps.skServicio = ras.skServicio AND rps.skImpuesto = 'TRAIVA' AND rps.skOrdenServicioServicio = ras.skOrdenServicioServicio )AS fImpuestosTrasladados
        FROM rel_ordenesServicios_servicios ras
        LEFT JOIN cat_servicios cse ON cse.skServicio = ras.skServicio 
        LEFT JOIN cat_unidadesMedidaSAT cum ON cum.skUnidadMedida = ras.skUnidadMedida
        LEFT JOIN rel_servicios_impuestos rsir ON rsir.skServicio = ras.skServicio AND rsir.skImpuesto = 'RETIVA'
        LEFT JOIN rel_servicios_impuestos rsit ON rsit.skServicio = ras.skServicio AND rsit.skImpuesto = 'TRAIVA'
        WHERE ras.skOrdenServicio = " . escape($this->admi['skOrdenServicio']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        $i = 0;
        foreach ($records as $value) {

            $this->admi['skOrdenServicioServicio'] = $value['skOrdenServicioServicio'];

            $this->admi['skServicio'] = $value['skServicio'];
            $records[$i]['impuestos'] = $this->_getOrdenServicioServiciosImpuestos();
            $i++;
        }

        return $records;
    }

    /**
     * _getOrdenServicioServiciosImpuestos
     *
     * Función Para obtener los datos de los almacenes
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getOrdenServicioServiciosImpuestos() {

        $sql = "SELECT
							 ras.*,
							 cti.sNombre AS tipoImpuesto,
							 ci.sNombre AS impuesto

							 FROM rel_ordenesServicios_serviciosImpuestos ras
							 INNER JOIN cat_impuestos ci ON ci.skImpuesto = ras.skImpuesto
							 INNER JOIN cat_tiposImpuestos cti ON cti.skTipoImpuesto = ci.skTipoImpuesto
							 WHERE ras.skOrdenServicio = " . escape($this->admi['skOrdenServicio']) . " AND ras.skOrdenServicioServicio = " . escape($this->admi['skOrdenServicioServicio']) . "  AND ras.skServicio= " . escape($this->admi['skServicio']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        return $records;
    }

    /**
     * getDatosReceptor
     *
     * Obtener Datos de Receptor para Facturacion
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array Datos | False
     */
    public function getDatosReceptor() {


        $sql = " SELECT
		cpa.sNombre AS paisReceptor,
		cepa.sNombre AS estadoReceptor,
		resp.sMunicipio AS municipioReceptor,
		resp.sColonia AS coloniaReceptor,
		resp.sCalle AS calleReceptor,
		resp.sCodigoPostal AS codigoPostalReceptor,
		resp.sNumeroExterior AS numeroExteriorReceptor,
		resp.sNumeroInterior AS numeroInteriorReceptor
		FROM  rel_ordenesServicios_domicilios resp
		INNER JOIN cat_paises cpa ON cpa.skPais = resp.skPais
		INNER JOIN cat_estadosPaises cepa ON cepa.skEstado = resp.skEstado
		WHERE  resp.skOrdenServicio = " . escape($this->admi['skOrdenServicio']);
    

        $result = Conn::query($sql);
                if (!$result) {
                    return FALSE;
                }
        return Conn::fetch_assoc($result);

    }


  

    /**
     * get_empresas
     *
     * Consulta Empresas Socios
     *
     * @author Luis Valdez <lvaldez@softlab.com.mx>
     * @return Array Datos | False
     */
    public function get_empresas() {
        $sql = "SELECT N1.* FROM (
            SELECT
            es.skEmpresaSocio AS id, CONCAT(e.sNombre,' (',e.sRFC,') - ',et.sNombre) AS nombre, es.skEmpresaTipo
            FROM rel_empresasSocios es
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo
            WHERE es.skEstatus = 'AC' AND e.skEstatus = 'AC' AND es.skEmpresaSocioPropietario = " . escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

        if (isset($this->admi['skEmpresaTipo']) && !empty($this->admi['skEmpresaTipo'])) {
            if (is_array($this->admi['skEmpresaTipo'])) {
                $sql .= " AND es.skEmpresaTipo IN (" . mssql_where_in($this->admi['skEmpresaTipo']) . ") ";
            } else {
                $sql .= " AND es.skEmpresaTipo = " . escape($this->admi['skEmpresaTipo']);
            }
        }

        $sql .= " ) AS N1 ";

        if (isset($this->admi['sNombre']) && !empty(trim($this->admi['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->admi['sNombre']) . "%' ";
        }

        if (isset($this->admi['skEmpresaSocio']) && !empty($this->admi['skEmpresaSocio'])) {
            $sql .= " WHERE N1.id = " . escape($this->admi['skEmpresaSocio']);
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

    public function _getBancosCuentasResponsable(){
        $sql = "SELECT b.skBanco,b.sNombre as banco,b.sNombreCorto bancoAlias,b.sRFC AS bancoRFC,b.sObservaciones AS sObservacionesBanco,
            bc.skBancoCuenta,bc.skDivisa,bc.sNumeroCuenta,bc.sTitular,bc.sClabeInterbancaria,bc.sObservaciones AS sObservacionesCuenta
            FROM cat_bancos b
            INNER JOIN cat_bancosCuentas bc ON bc.skBanco = b.skBanco
            WHERE b.skEstatus = 'AC' AND bc.skEstatus = 'AC'";

        if (isset($this->admi['skBanco']) && !empty($this->admi['skBanco'])) {
            $sql .= " AND b.skBanco = ".escape($this->admi['skBanco']);
        }

        if (isset($this->admi['skBancoCuenta']) && !empty($this->admi['skBancoCuenta'])) {
            $sql .= " AND bc.skBancoCuenta = ".escape($this->admi['skBancoCuenta']);
        }

        if (isset($this->admi['skEmpresaSocioResponsable']) && !empty($this->admi['skEmpresaSocioResponsable'])) {
            $sql .= " AND bc.skEmpresaSocioPropietario = ".escape($this->admi['skEmpresaSocioResponsable']);
        }
        //exit('<pre>'.print_r($sql,1).'</pre>');
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function _get_formasPago(){
        $sql = "SELECT fp.* FROM cat_formasPago fp WHERE 1=1 AND fp.skEstatus = 'AC' ";

        $sql .= " ORDER BY fp.sNombre ASC ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function _get_divisas(){
        $sql = "SELECT * FROM cat_divisas WHERE 1=1 ";

        if (isset($this->admi['skEstatus']) && !empty(trim($this->admi['skEstatus']))) {
            $sql .= " AND skEstatus = ".escape($this->admi['skEstatus']);
        }

        if (isset($this->admi['skDivisa']) && !empty($this->admi['skDivisa'])) {
            if (is_array($this->admi['skDivisa'])) {
                $sql .= " AND skDivisa IN (" . mssql_where_in($this->admi['skDivisa']) . ")";
            } else {
                $sql .= " AND skDivisa = " . escape($this->admi['skDivisa']);
            }
        }

        $sql .= " ORDER BY sNombre ASC ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function _get_bancos(){
        $sql = "SELECT ban.* FROM cat_bancos ban WHERE 1=1 ";

        if (isset($this->admi['skEstatus']) && !empty($this->admi['skEstatus'])) {
            $sql .= " AND ban.skEstatus = ".escape($this->admi['skEstatus']);
        }

        if (isset($this->admi['skBanco']) && !empty($this->admi['skBanco'])) {
            $sql .= " AND ban.skBanco = ".escape($this->admi['skBanco']);
        }

        $sql .= " ORDER BY ban.sNombre ASC ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }
    public function _get_bancosCuenta(){
        $sql = "SELECT
             bc.*
            ,b.sNombre AS banco
            ,b.sNombreCorto AS bacoCorto
            ,d.sNombre AS divisa
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            ,e.sNombre AS empresaResponsable
            ,e.sRFC AS empresaResponsableRFC
            ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno,' ',ucre.sApellidoMaterno) AS usuarioCreacion
            ,IF(b.skUsuarioModificacion IS NOT NULL,CONCAT(umod.sNombre,' ',umod.sApellidoPaterno,' ',umod.sApellidoMaterno),NULL) AS usuarioModificacion
            FROM cat_bancosCuentas bc
            INNER JOIN cat_bancos b ON b.skBanco = bc.skBanco
            INNER JOIN cat_divisas d ON d.skDivisa = bc.skDivisa
            INNER JOIN core_estatus est ON est.skEstatus = bc.skEstatus
            INNER JOIN cat_usuarios ucre ON ucre.skUsuario = bc.skUsuarioCreacion
            LEFT JOIN rel_empresasSocios es ON es.skEmpresaSocio = bc.skEmpresaSocioResponsable
            LEFT JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            LEFT JOIN cat_usuarios umod ON umod.skUsuario = bc.skUsuarioModificacion
            WHERE bc.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

        if (isset($this->admi['skBancoCuenta']) && !empty(trim($this->admi['skBancoCuenta']))) {
            $sql .= " AND bc.skBancoCuenta = ".escape($this->admi['skBancoCuenta']);
        }

        if (isset($this->admi['skBanco']) && !empty(trim($this->admi['skBanco']))) {
            $sql .= " AND bc.skBanco = ".escape($this->admi['skBanco']);
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function _get_bancosCuentas(){
        $sql = "SELECT banCue.*, ban.sNombre AS banco 
        FROM cat_bancosCuentas banCue
        INNER JOIN cat_bancos ban ON ban.skBanco = banCue.skBanco 
        WHERE 1=1 ";

        if (isset($this->admi['skEstatus']) && !empty($this->admi['skEstatus'])) {
            $sql .= " AND banCue.skEstatus = ".escape($this->admi['skEstatus']);
        }

        if (isset($this->admi['skBanco']) && !empty($this->admi['skBanco'])) {
            $sql .= " AND banCue.skBanco = ".escape($this->admi['skBanco']);
        }

        $sql .= " ORDER BY banCue.sTitular ASC ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }


    public function _get_transaccion(){
        $sql = "SELECT tra.skTransaccion
        ,tra.skEstatus
        ,tra.iFolio AS iFolio
        ,tra.skEmpresaSocioPropietario
        ,Fem.sRFC AS rfcPropietario
        ,tra.skEmpresaSocioResponsable
        ,tra.skEmpresaSocioCliente
        ,tra.sReferencia
        ,tra.skBancoEmisor
        ,tra.sBancoCuentaEmisor
        ,tra.skBancoReceptor
        ,tra.skBancoCuentaReceptor
        ,tra.skFormaPago
        ,tra.skDivisa
        ,tra.fTipoCambio
        ,tra.skTipoTransaccion
        ,CASE tra.skTipoTransaccion
            WHEN 'TRAN' THEN 'Transferencia'
            WHEN 'NCRE' THEN 'Nota de Crédito'
            WHEN 'SAFA' THEN 'Saldo a Favor'
        END AS tipoTransaccion
        ,tra.fImporte
        ,tra.fSaldo
        ,tra.sObservaciones
        ,tra.dFechaTransaccion
        ,tra.skUsuarioCancelacion
        ,tra.dFechaCancelacion
        ,tra.skDocumentoComprobante
        ,tra.sObservacionCancelacion
        ,tra.skUsuarioCreacion
        ,tra.dFechaCreacion
        ,tra.skUsuarioModificacion
        ,tra.dFechaModificacion
        ,tra.skFacturaNotaCredito
        ,est.sNombre AS estatus
        ,est.sIcono AS estatusIcono
        ,est.sColor AS estatusColor
        ,banE.sNombre AS bancoEmisor
        ,banR.sNombre AS bancoReceptor
        ,banCueR.sNumeroCuenta AS sNumeroCuentaReceptor
        ,banCueR.sTitular AS sTitularReceptor
        ,fp.sNombre AS formaPago
        ,fp.sCodigo AS codigoPago
        ,eR.sNombre AS empresaResponsable
        ,eR.sRFC AS empresaResponsableRFC
        ,eC.sNombre AS empresaCliente
        ,eC.sRFC AS empresaClienteRFC
        ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno,' ',ucre.sApellidoMaterno) AS usuarioCreacion
        ,CONCAT(umod.sNombre,' ',umod.sApellidoPaterno,' ',umod.sApellidoMaterno) AS usuarioModificacion
        ,CONCAT(ucan.sNombre,' ',ucan.sApellidoPaterno,' ',ucan.sApellidoMaterno) AS usuarioCancelacion
    FROM ope_transacciones tra
        INNER JOIN core_estatus est ON est.skEstatus = tra.skEstatus
        LEFT JOIN cat_bancos banE ON banE.skBanco = tra.skBancoEmisor
        LEFT JOIN cat_bancos banR ON banR.skBanco = tra.skBancoReceptor
        LEFT JOIN cat_bancosCuentas banCueR ON banCueR.skBancoCuenta = tra.skBancoCuentaReceptor
        INNER JOIN cat_formasPago fp ON fp.skFormaPago = tra.skFormaPago
        INNER JOIN rel_empresasSocios esR ON esR.skEmpresaSocio = tra.skEmpresaSocioResponsable
        INNER JOIN cat_empresas eR ON eR.skEmpresa = esR.skEmpresa
        LEFT JOIN rel_empresasSocios esC ON esC.skEmpresaSocio = tra.skEmpresaSocioCliente
        LEFT JOIN cat_empresas eC ON eC.skEmpresa = esC.skEmpresa
        INNER JOIN rel_empresasSocios Fes ON Fes.skEmpresaSocio = tra.skEmpresaSocioPropietario
        INNER JOIN cat_empresas Fem ON Fem.skEmpresa = Fes.skEmpresa
        INNER JOIN cat_usuarios ucre ON ucre.skUsuario = tra.skUsuarioCreacion
        LEFT JOIN cat_usuarios umod ON umod.skUsuario = tra.skUsuarioModificacion
        LEFT JOIN cat_usuarios ucan ON ucan.skUsuario = tra.skUsuarioCancelacion 
    WHERE 1=1 ";

        if (isset($this->admi['skTransaccion']) && !empty($this->admi['skTransaccion'])) {
            $sql .= " AND tra.skTransaccion = ".escape($this->admi['skTransaccion']);
        }

        if (isset($this->admi['skEstatus']) && !empty($this->admi['skEstatus'])) {
            if (is_array($this->admi['skEstatus'])) {
                $sql .= " AND tra.skEstatus IN (" . mssql_where_in($this->admi['skEstatus']) . ")";
            } else {
                $sql .= " AND tra.skEstatus = " . escape($this->admi['skEstatus']);
            }
        }

        if (isset($this->admi['skEmpresaSocio']) && !empty($this->admi['skEmpresaSocio'])) {
            $sql .= " AND tra.skEmpresaSocio = ".escape($this->admi['skEmpresaSocio']);
        }

        if (isset($this->admi['skBancoEmisor']) && !empty($this->admi['skBancoEmisor'])) {
            $sql .= " AND tra.skBancoEmisor = ".escape($this->admi['skBancoEmisor']);
        }

        if (isset($this->admi['sBancoCuentaEmisor']) && !empty($this->admi['sBancoCuentaEmisor'])) {
            $sql .= " AND tra.sBancoCuentaEmisor = ".escape($this->admi['sBancoCuentaEmisor']);
        }

        if (isset($this->admi['skBancoReceptor']) && !empty($this->admi['skBancoReceptor'])) {
            $sql .= " AND tra.skBancoReceptor = ".escape($this->admi['skBancoReceptor']);
        }

        if (isset($this->admi['skBancoCuentaReceptor']) && !empty($this->admi['skBancoCuentaReceptor'])) {
            $sql .= " AND tra.skBancoCuentaReceptor = ".escape($this->admi['skBancoCuentaReceptor']);
        }

        if (isset($this->admi['skFormaPago']) && !empty($this->admi['skFormaPago'])) {
            $sql .= " AND tra.skFormaPago = ".escape($this->admi['skFormaPago']);
        }

        if (isset($this->admi['skDivisa']) && !empty($this->admi['skDivisa'])) {
            if (is_array($this->admi['skDivisa'])) {
                $sql .= " AND tra.skDivisa IN (" . mssql_where_in($this->admi['skDivisa']) . ")";
            } else {
                $sql .= " AND tra.skDivisa = " . escape($this->admi['skDivisa']);
            }
        }

        $sql .= " ORDER BY tra.dFechaCreacion DESC ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        if (isset($this->admi['skTransaccion']) && !empty($this->admi['skTransaccion'])) {
            $records = Conn::fetch_assoc($result);
        }else{
            $records = Conn::fetch_assoc_all($result);
        }

        utf8($records);
        return $records;
    }
    public function _get_transaccion_facturas(){
 
            $sql = "SELECT tfac.*
                ,RIGHT('TRA-' + RIGHT('000000'+ CAST(tra.iFolio AS VARCHAR(6)),6),10) AS iFolioTransaccion
                ,ofa.iFolio AS iFolioFactura
                ,ofa.fSaldo,
                ofa.fTotal, 
                ofa.skUUIDSAT, 
                ofa.dFechaTimbrado AS dFechaFactura,     
                tfac.iParcialidad
                ,est.sNombre AS estatusTransaccionFactura, 
                est.sIcono AS sIconoTransaccionFactura, 
                est.sColor AS sColorTransaccionFactura
                ,CONCAT(u.sNombre,' ',u.sApellidoPaterno,' ',u.sApellidoMaterno) AS usuarioCreacion
                ,CONCAT(u.sNombre,' ',u.sApellidoPaterno) AS usuarioCortoCreacion
                ,mp.sCodigo AS codigoMetodoPago, 
                mp.sNombre AS metodoPago, 
                fp.sCodigo AS codigoFormaPago, 
                fp.sNombre AS formaPago,
                ce.sNombre AS estatus,
                ce.sIcono AS iconoEstatus,
                ce.sColor AS colorEstatus,
                RIGHT('0000000000'+ CAST(ofac.iFolio AS VARCHAR(10)),10) AS iFolioComplemento,
                ofac.skUUIDSAT AS skUUIDSATComplemento,
                ofac.sRFCEmisor AS sRFCEmisorComplemento,
                ofac.sSerie AS sSerieComplemento,
                tra.dFechaTransaccion AS fechaTransaccion
                FROM rel_transacciones_facturas tfac
                INNER JOIN ope_transacciones tra ON tra.skTransaccion = tfac.skTransaccion
                INNER JOIN ope_facturas ofa ON ofa.skFactura = tfac.skFactura
                INNER JOIN cat_metodosPago mp ON mp.sCodigo = ofa.skMetodoPago
                INNER JOIN cat_formasPago fp ON fp.sCodigo = ofa.skFormaPago
                INNER JOIN cat_usuarios u ON u.skUsuario = tfac.skUsuarioCreacion
                INNER JOIN core_estatus ce ON ce.skEstatus = tfac.skEstatus
                LEFT JOIN rel_transacciones_facturas rtc ON rtc.skTransaccionPago = tfac.skTransaccionPago
                LEFT JOIN ope_facturas ofac ON ofac.skFactura = rtc.skFactura AND ofac.skEstatus = 'FA' AND ofac.iFolio IS NOT NULL
                LEFT JOIN core_estatus est ON est.skEstatus = tfac.skEstatus
                WHERE 1=1  ";
    
            if (isset($this->admi['skTransaccion']) && !empty($this->admi['skTransaccion'])) {
                $sql .= " AND tfac.skTransaccion = ".escape($this->admi['skTransaccion']);
            }
    
            if (isset($this->admi['skFactura']) && !empty($this->admi['skFactura'])) {
                $sql .= " AND tfac.skFactura = ".escape($this->admi['skFactura']);
            }
    
        if (isset($this->admi['getFacturasSinComprobante']) && !empty($this->admi['getFacturasSinComprobante'])) {
                $sql .= " AND tfac.skTransaccionComprobante IS NULL";
            }
    
            $sql .= " ORDER BY tfac.dFechaCreacion DESC ";
    
            $result = Conn::query($sql);
            if (!$result) {
                return FALSE;
            }
            $records = Conn::fetch_assoc_all($result);
            utf8($records);
            return $records;
 
    }

    public function stpCUD_transacciones() {
        $sql = "CALL stpCUD_transacciones (
        " .escape(isset($this->admi['skTransaccion']) ? $this->admi['skTransaccion'] : NULL) . ",
        " .escape(isset($this->admi['skTransaccionPago']) ? $this->admi['skTransaccionPago'] : NULL) . ",
        " .escape(isset($this->admi['skEstatus']) ? $this->admi['skEstatus'] : NULL) . ",
        " .escape(isset($this->admi['skTipoTransaccion']) ? $this->admi['skTipoTransaccion'] : NULL) . ",
        " .escape($_SESSION['usuario']['skEmpresaSocioPropietario']) . ",
        " .escape(isset($this->admi['skEmpresaSocioResponsable']) ? $this->admi['skEmpresaSocioResponsable'] : NULL) . ",
        " .escape(isset($this->admi['skEmpresaSocioCliente']) ? $this->admi['skEmpresaSocioCliente'] : NULL) . ",
        " .escape(isset($this->admi['sReferencia']) ? $this->admi['sReferencia'] : NULL) . ",
        " .escape(isset($this->admi['skBancoEmisor']) ? $this->admi['skBancoEmisor'] : NULL) . ",
        " .escape(isset($this->admi['sBancoCuentaEmisor']) ? $this->admi['sBancoCuentaEmisor'] : NULL) . ",
        " .escape(isset($this->admi['skBancoReceptor']) ? $this->admi['skBancoReceptor'] : NULL) . ",
        " .escape(isset($this->admi['skBancoCuentaReceptor']) ? $this->admi['skBancoCuentaReceptor'] : NULL) . ",
        " .escape(isset($this->admi['skDivisa']) ? $this->admi['skDivisa'] : NULL) . ",
        " .escape(isset($this->admi['fTipoCambio']) ? $this->admi['fTipoCambio'] : NULL) . ",
        " .escape(isset($this->admi['skFormaPago']) ? $this->admi['skFormaPago'] : NULL) . ",
        " .escape(isset($this->admi['fImporte']) ? $this->admi['fImporte'] : NULL) . ",
        " .escape(isset($this->admi['fImporteMXN']) ? $this->admi['fImporteMXN'] : NULL) . ",
        " .escape(isset($this->admi['fSaldo']) ? $this->admi['fSaldo'] : NULL) . ",
        " .escape(isset($this->admi['dFechaTransaccion']) ? $this->admi['dFechaTransaccion'] : NULL) . ",
        " .escape(isset($this->admi['skDocumentoComprobante']) ? $this->admi['skDocumentoComprobante'] : NULL) . ",
        " .escape(isset($this->admi['sObservaciones']) ? $this->admi['sObservaciones'] : NULL) . ",
        " .escape(isset($this->admi['sObservacionCancelacion']) ? $this->admi['sObservacionCancelacion'] : NULL) . ",
        " .escape(isset($this->admi['sObservacionesValidacionRechazo']) ? $this->admi['sObservacionesValidacionRechazo'] : NULL) . ",
        " .escape(isset($this->admi['skPago']) ? $this->admi['skPago'] : NULL) . ",
        " .escape(isset($this->admi['skFactura']) ? $this->admi['skFactura'] : NULL) . ",
        

        " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
        '" . $_SESSION['usuario']['skUsuario'] . "',
        '" . $this->sysController . "' )";
        

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

 


    //Función para generar excel
    public function leerXML(){
        $this->data['datos'] = [];
        $xmlObject = simplexml_load_file($this->admi['rutaArchivo']);

        $ns = $xmlObject->getNamespaces(true);
        $result = $this->XMLNode($xmlObject, $ns);
        $texto = file_get_contents($this->admi['rutaArchivo']);

    if (strpos($texto,"cfdi:Comprobante")!==FALSE) {
        $this->data['datos']['tipo']="cfdi";
    } elseif (strpos($texto,"<Comprobante")!==FALSE) {
        $this->data['datos']['tipo']="cfd";
    } elseif (strpos($texto,"retenciones:Retenciones")!==FALSE) {
        $this->data['datos']['tipo']="retenciones";
    } else {
        return false;
        //die("Tipo de XML no identificado ....");
    }

    $this->data['datos']['Emisor'] = $result['Emisor'];
    $this->data['datos']['Receptor'] = $result['Receptor'];

    //COMPROBANTE GENERAL
    $this->data['datos']['comprobante']['Version'] = (!empty($result['Version']) ? $result['Version'] : NULL);
    $this->data['datos']['comprobante']['Serie'] = (!empty($result['Serie']) ? $result['Serie'] : NULL);
    $this->data['datos']['comprobante']['Folio'] = (!empty($result['Folio']) ? $result['Folio'] : NULL);
    $this->data['datos']['comprobante']['Fecha'] = (!empty($result['Fecha']) ? $result['Fecha'] : NULL);
    $this->data['datos']['comprobante']['Sello'] = (!empty($result['Sello']) ? $result['Sello'] : NULL);
    $this->data['datos']['comprobante']['FormaPago'] = (!empty($result['FormaPago']) ? $result['FormaPago'] : NULL);
    $this->data['datos']['comprobante']['NoCertificado'] = (!empty($result['NoCertificado']) ? $result['NoCertificado'] : NULL);
    $this->data['datos']['comprobante']['Certificado'] = (!empty($result['Certificado']) ? $result['Certificado'] : NULL);
    $this->data['datos']['comprobante']['SubTotal'] = (!empty($result['SubTotal']) ? $result['SubTotal'] : NULL);
    $this->data['datos']['comprobante']['Moneda'] = (!empty($result['Moneda']) ? $result['Moneda'] : NULL);
    $this->data['datos']['comprobante']['TipoCambio'] = (!empty($result['TipoCambio']) ? $result['TipoCambio'] : NULL);
    $this->data['datos']['comprobante']['Total'] = (!empty($result['Total']) ? $result['Total'] : NULL);
    $this->data['datos']['comprobante']['TipoDeComprobante'] = (!empty($result['TipoDeComprobante']) ? $result['TipoDeComprobante'] : NULL);
    $this->data['datos']['comprobante']['MetodoPago'] = (!empty($result['MetodoPago']) ? $result['MetodoPago'] : NULL);
    $this->data['datos']['comprobante']['LugarExpedicion'] = (!empty($result['LugarExpedicion']) ? $result['LugarExpedicion'] : NULL);

    //COMPLEMENTOS
    $this->data['datos']['Complemento']= (!empty($result['Complemento']['TimbreFiscalDigital']) ? $result['Complemento']['TimbreFiscalDigital'] : NULL);

    //servicios
    $this->data['datos']['servicios'] = [];
    if(!empty($result['servicios']) && in_array($this->data['datos']['comprobante']['TipoDeComprobante'],['E','I']) ){
        $i=0;
        foreach ($result['servicios'] as $key => $servicios) {
            if(!empty($servicios)){
            $this->data['datos']['servicios'][$i] = $servicios;
            unset($this->data['datos']['servicios'][$i]['Impuestos']);
            if(!empty($servicios['Impuestos']['Traslados']['Traslado'])){
                $this->data['datos']['servicios'][$i]['fImpuestosTrasladados']= $servicios['Impuestos']['Traslados']['Traslado']['Importe'];
            }
            if(!empty($servicios['Impuestos']['Retenciones']['Retencion'])){
                $this->data['datos']['servicios'][$i]['fImpuestosRetenidos']= $servicios['Impuestos']['Retenciones']['Retencion']['Importe'];
            }
            }
            $i++;
        }
    }
    //servicios
    $this->data['datos']['Pagos'] = [];
    if($this->data['datos']['comprobante']['TipoDeComprobante'] == "P"){
            if(is_array($result['Complemento']['Pagos'])){
        

                $i=0;
                foreach($result['Complemento']['Pagos'] AS $keyMovimientos => $rowMovimientos){

                    if(!empty($rowMovimientos['FechaPago'])){
                        $this->data['datos']['comprobante']['dFechaPago'] = (!empty($rowMovimientos['FechaPago']) ? $rowMovimientos['FechaPago']: NULL);
                        $this->data['datos']['comprobante']['FormaPago'] = (!empty($rowMovimientos['FormaDePagoP']) ? $rowMovimientos['FormaDePagoP'] : NULL);
                        $this->data['datos']['comprobante']['sNumeroOperacion'] = (!empty($rowMovimientos['NumOperacion']) ? $rowMovimientos['NumOperacion'] : NULL);
                        $this->data['datos']['comprobante']['Moneda'] = (!empty($rowMovimientos['MonedaP']) ? $rowMovimientos['MonedaP']: NULL);
                        $this->data['datos']['comprobante']['fMontoTotalPago'] = (!empty($rowMovimientos['Monto']) ? $rowMovimientos['Monto'] : NULL);
                            
                            foreach($rowMovimientos AS $keyPagos => $rowPagos){
                                
                                if(is_array($rowPagos)){

                                    $this->data['datos']['Pagos'][$i]['sFolio'] = (!empty($rowPagos['Folio']) ? $rowPagos['Folio'] : NULL);
                                    $this->data['datos']['Pagos'][$i]['skUUIDSatRelacionado'] = $rowPagos['IdDocumento'];
                                    $this->data['datos']['Pagos'][$i]['sSerie'] = (!empty($rowPagos['Serie']) ? $rowPagos['Serie'] : NULL);
                                    $this->data['datos']['Pagos'][$i]['skDivisa'] = $rowPagos['MonedaDR'];
                                    $this->data['datos']['Pagos'][$i]['skMetodoPago'] = $rowPagos['MetodoDePagoDR'];
                                    $this->data['datos']['Pagos'][$i]['iNumeroParcialidad'] = $rowPagos['NumParcialidad'];
                                    $this->data['datos']['Pagos'][$i]['fImporteSaldoPago'] = $rowPagos['ImpPagado'];
                                    $this->data['datos']['Pagos'][$i]['fImporteSaldoAnterior'] = $rowPagos['ImpSaldoAnt'];
                                    $this->data['datos']['Pagos'][$i]['fImporteSaldoInsoluto'] = $rowPagos['ImpSaldoInsoluto'];
                                    
                                    $this->data['datos']['Pagos'][$i]['dFechaPago'] = $this->data['datos']['comprobante']['dFechaPago'];
                                    $this->data['datos']['Pagos'][$i]['fMontoTotalPago'] = $this->data['datos']['comprobante']['fMontoTotalPago'];
                                    $this->data['datos']['Pagos'][$i]['skFormaPago'] = $this->data['datos']['comprobante']['FormaPago'];
                                    $this->data['datos']['Pagos'][$i]['sNumeroOperacion'] = $this->data['datos']['comprobante']['sNumeroOperacion'];
                                    $i++;
                                }
            
                            }
                        }



                } 
                
            }else{
        
            if(!empty($result['Complemento']['Pagos']['Pago'])){
            $this->data['datos']['comprobante']['dFechaPago'] = (!empty($result['Complemento']['Pagos']['Pago']['FechaPago']) ? $result['Complemento']['Pagos']['Pago']['FechaPago'] : NULL);
            $this->data['datos']['comprobante']['FormaPago'] = (!empty($result['Complemento']['Pagos']['Pago']['FormaDePagoP']) ? $result['Complemento']['Pagos']['Pago']['FormaDePagoP'] : NULL);
            $this->data['datos']['comprobante']['sNumeroOperacion'] = (!empty($result['Complemento']['Pagos']['Pago']['NumOperacion']) ? $result['Complemento']['Pagos']['Pago']['NumOperacion'] : NULL);
            $this->data['datos']['comprobante']['Moneda'] = (!empty($result['Complemento']['Pagos']['Pago']['MonedaP']) ? $result['Complemento']['Pagos']['Pago']['MonedaP'] : NULL);
            $this->data['datos']['comprobante']['fMontoTotalPago'] = (!empty($result['Complemento']['Pagos']['Pago']['Monto']) ? $result['Complemento']['Pagos']['Pago']['Monto'] : NULL);
                $i=0;
                foreach($result['Complemento']['Pagos']['Pago'] AS $keyPagos => $rowPagos){
                    
                    if(is_array($rowPagos)){
                        $this->data['datos']['Pagos'][$i]['sFolio'] = (!empty($rowPagos['Folio']) ? $rowPagos['Folio'] : NULL);
                        $this->data['datos']['Pagos'][$i]['skUUIDSatRelacionado'] = $rowPagos['IdDocumento'];
                        $this->data['datos']['Pagos'][$i]['sSerie'] = (!empty($rowPagos['Serie']) ? $rowPagos['Serie'] : NULL);
                        $this->data['datos']['Pagos'][$i]['skDivisa'] = $rowPagos['MonedaDR'];
                        $this->data['datos']['Pagos'][$i]['skMetodoPago'] = $rowPagos['MetodoDePagoDR'];
                        $this->data['datos']['Pagos'][$i]['iNumeroParcialidad'] = $rowPagos['NumParcialidad'];
                        $this->data['datos']['Pagos'][$i]['fImporteSaldoPago'] = $rowPagos['ImpPagado'];
                        $this->data['datos']['Pagos'][$i]['fImporteSaldoAnterior'] = $rowPagos['ImpSaldoAnt'];
                        $this->data['datos']['Pagos'][$i]['fImporteSaldoInsoluto'] = $rowPagos['ImpSaldoInsoluto'];
                        $this->data['datos']['Pagos'][$i]['dFechaPago'] = $this->data['datos']['comprobante']['dFechaPago'];

                        $this->data['datos']['Pagos'][$i]['fMontoTotalPago'] = $this->data['datos']['comprobante']['fMontoTotalPago'];
                        $this->data['datos']['Pagos'][$i]['skFormaPago'] = $this->data['datos']['comprobante']['FormaPago'];
                        $this->data['datos']['Pagos'][$i]['sNumeroOperacion'] = $this->data['datos']['comprobante']['sNumeroOperacion'];
                        $i++;
                    }

                }
            }
        }
        
        
    } 

    //IMPUESTOS
    if(!empty($result['Impuestos']['Retenciones'])){
        $this->data['datos']['Impuestos']['Retenciones'] = (!empty($result['Impuestos']['Retenciones']['Retencion']) ? $result['Impuestos']['Retenciones']['Retencion'] : NULL);
        $this->data['datos']['comprobante']['TotalImpuestosRetenidos'] = (!empty($result['Impuestos']['TotalImpuestosRetenidos']) ? $result['Impuestos']['TotalImpuestosRetenidos'] : NULL);

    }
    if(!empty($result['Impuestos']['Traslados'])){
        $this->data['datos']['Impuestos']['Traslados'] = (!empty($result['Impuestos']['Traslados']['Traslado']) ? $result['Impuestos']['Traslados']['Traslado'] : NULL);
        $this->data['datos']['comprobante']['TotalImpuestosTrasladados'] = (!empty($result['Impuestos']['TotalImpuestosTrasladados']) ? $result['Impuestos']['TotalImpuestosTrasladados'] : NULL);
    }
    return $this->data;

    }
    public function XMLNode($XMLNode, $ns)
    {
        //
        $nodes = array();
        $response = array();
        $attributes = array();

        // first item ?
        $_isfirst = true;

        // each namespace
        //  - xmlns:cfdi="http://www.sat.gob.mx/cfd/3"
        //  - xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital"
        foreach ($ns as $eachSpace) {
            //
            // each node
            foreach ($XMLNode->children($eachSpace) as $_tag => $_node) {
                //
                $_value = $this->XMLNode($_node, $ns);

                // exists $tag in $children?
                if (key_exists($_tag, $nodes)) {
                    if ($_isfirst) {
                        $tmp = $nodes[$_tag];
                        unset($nodes[$_tag]);
                        $nodes[] = $tmp;
                        $is_first = false;
                    }
                    $nodes[] = $_value;
                } else {
                    $nodes[$_tag] = $_value;
                }
            }
        }
        //
        $attributes = array_merge(
        $attributes,
        (array)current($XMLNode->attributes())
        );
        // nodes ?
        if (count($nodes)) {
            $response = array_merge(
                $response,
                $nodes
            );
        }
        // attributes ?
        if (count($attributes)) {
            $response = array_merge(
                $response,
                $attributes
            );
        }
        return (empty($response) ? null : $response);
    }


    public function _get_facturas_pendientes_pago(){
        $sql = "SELECT occ.skFactura,
        occ.iFolio, 
        occ.skEmpresaSocioEmisor,
        occ.skEmpresaSocioResponsable,
        occ.skEmpresaSocioFacturacion,
        occ.fTipoCambio,
        occ.skFormaPago,
        occ.skMetodoPago,
        occ.skDivisa,
        occ.sReferencia, 
        occ.fImpuestosRetenidos,
        occ.fImpuestosTrasladados,
        occ.fSubtotal,
        occ.fTotal,
        occ.fDescuento,
        occ.fSaldo,
        occ.dFechaCreacion,
        occ.dFechaCreacion AS dFechaFactura,
        fp.sCodigo AS codigoFormaPago,
        fp.sNombre AS formaPago,
        mp.sCodigo AS codigoMetodoPago,
        mp.sNombre AS metodoPago,
        cee.sNombre AS empresaEmisor,
        cee.sRFC AS empresaEmisorRFC,
        cer.sNombre AS empresaResponsable,
        cer.sRFC AS empresaResponsableRFC,
        cef.sNombre AS empresaFacturar,
        cef.sRFC AS empresaFacturarRFC
        FROM ope_facturas occ
        INNER JOIN rel_empresasSocios rese ON rese.skEmpresaSocio = occ.skEmpresaSocioEmisor
        INNER JOIN cat_empresas cee ON cee.skEmpresa = rese.skEmpresa
        INNER JOIN rel_empresasSocios resr ON resr.skEmpresaSocio = occ.skEmpresaSocioResponsable
        INNER JOIN cat_empresas cer ON cer.skEmpresa = resr.skEmpresa
        INNER JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = occ.skEmpresaSocioFacturacion
        INNER JOIN cat_empresas cef ON cef.skEmpresa = resf.skEmpresa
        LEFT JOIN cat_metodosPago mp ON mp.sCodigo = occ.skMetodoPago
        LEFT JOIN cat_formasPago fp ON fp.sCodigo = occ.skFormaPago 
        WHERE occ.fSaldo > 0  AND occ.skEstatus NOT IN('CA')
                ";

        if (isset($this->admi['skEmpresaSocioResponsable']) && !empty($this->admi['skEmpresaSocioResponsable'])) {
            $sql .= " AND occ.skEmpresaSocioResponsable = ".escape($this->admi['skEmpresaSocioResponsable']);
        }

        if (isset($this->admi['skEmpresaSocioCliente']) && !empty($this->admi['skEmpresaSocioCliente'])) {
            $sql .= " AND occ.skEmpresaSocioCliente = ".escape($this->admi['skEmpresaSocioCliente']);
        }

        if (isset($this->admi['skDivisa']) && !empty($this->admi['skDivisa'])) {
            $sql .= " AND occ.skDivisa = ".escape($this->admi['skDivisa']);
        }

        if (isset($this->admi['skFactura']) && !empty($this->admi['skFactura'])) {
            $sql .= " AND occ.skFactura = ".escape($this->admi['skFactura']);
        }

        $sql .= " ORDER BY occ.dFechaCreacion ASC ";
 

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function _get_saldo_facturas(){
        $sql = "SELECT
            RIGHT('000000'+ CAST(occ.iFolio AS VARCHAR(6)),6) AS iFolio, occ.skFactura, occ.fSaldo, occ.dFechaCreacion,
            mp.sCodigo AS codigoMetodoPago, mp.sNombre AS metodoPago, fp.sCodigo AS codigoFormaPago, fp.sNombre AS formaPago
            FROM ope_facturas occ
            INNER JOIN cat_metodosPago mp ON mp.sCodigo = occ.skMetodoPago
            INNER JOIN cat_formasPago fp ON fp.sCodigo = occ.skFormaPago
            WHERE occ.skFactura IN (". mssql_where_in($this->admi['facturas']).")";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }


     /**
     * consultar_factura
     *
     * Obtener Datos de factura para editar y detalles
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez>
     * @return Array Datos | False
     */
    public function consultar_factura() {

        $sql = "SELECT occ.skFactura,
        ce.sNombre AS estatus,
         occ.iFolio AS iFolio,
        occ.iFolio AS iFolioOriginal,
        RIGHT('0000000000'+ CAST(occ.iFolio AS VARCHAR(10)),10) AS iFolioFactura,
        occ.dFechaCreacion, 
        occ.dFechaTimbrado, 
        occ.skEmpresaSocioEmisor,
        occ.skEmpresaSocioResponsable,
        occ.skEmpresaSocioFacturacion,
        occ.skEmpresaSocioCliente,
        occ.fTipoCambio,
        occ.skFormaPago,
        occ.skMetodoPago,
        occ.skUsoCFDI, 
        occ.sReferencia,
        occ.fImpuestosRetenidos,
        occ.fImpuestosTrasladados,
        occ.fSubtotal,
        occ.fSubtotal AS fImporteSubtotal,
        
        occ.fTotal, 
        occ.fTotal AS fImporteTotal, 
        occ.fSaldo, 
        occ.fDescuento,
        occ.sRFCEmisor,
        occ.sRFCReceptor,
        occ.sSerie,
        occ.skUUIDSAT,
        occ.skDivisa,
         occ.skEstatus,
        NOW() AS fechaActual,
        cee.sNombre AS empresaEmisor,
        cee.sRFC AS empresaEmisorRFC,
        cer.sNombre AS empresaResponsable,
        cer.sRFC AS empresaResponsableRFC,
        cef.sNombre AS empresaFacturar,
        cef.sRFC AS empresaFacturarRFC,
        cec.sNombre AS empresaCliente,
        cec.sRFC AS empresaClienteRFC,  
        cfp.sNombre AS formaPago,
        cfp.sCodigo AS codigoFormaPago,
        cmp.sNombre AS metodoPago,
        cmp.sCodigo AS codigoMetodoPago,
        cuf.sNombre AS usoCFDI, 

         CONCAT(cu.sNombre,' ',cu.sApellidoPaterno,' ',cu.sApellidoMaterno) AS usuarioCreacion
        FROM  ope_facturas occ
        LEFT JOIN cat_usuarios cu ON cu.skUsuario = occ.skUsuarioCreacion
         LEFT JOIN core_estatus ce ON ce.skEstatus = occ.skEstatus
        LEFT JOIN rel_empresasSocios rese ON rese.skEmpresaSocio = occ.skEmpresaSocioEmisor
        LEFT JOIN cat_empresas cee ON cee.skEmpresa = rese.skEmpresa
        LEFT JOIN rel_empresasSocios resr ON resr.skEmpresaSocio = occ.skEmpresaSocioResponsable
        LEFT JOIN cat_empresas cer ON cer.skEmpresa = resr.skEmpresa
        LEFT JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = occ.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas cef ON cef.skEmpresa = resf.skEmpresa
        LEFT JOIN rel_empresasSocios resc ON resc.skEmpresaSocio = occ.skEmpresaSocioCliente
        LEFT JOIN cat_empresas cec ON cec.skEmpresa = resc.skEmpresa
         LEFT JOIN cat_formasPago cfp ON cfp.sCodigo = occ.skFormaPago
        LEFT JOIN cat_metodosPago cmp ON cmp.sCodigo = occ.skMetodoPago
        LEFT JOIN cat_usosCFDI cuf ON cuf.skUsoCFDI = occ.skUsoCFDI 
            WHERE  occ.skFactura = " . escape($this->admi['skFactura'])." AND occ.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * consultar_facturas_servicios
     *
     * Obtener Datos de factura para editar y detalles
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez>
     * @return Array Datos | False
     */
    public function consultar_facturas_servicios() {

        $sql = "SELECT rfa.skFacturaServicio,
        rfa.skServicio,
        IF(cse.sNombre IS NULL, rfa.sDescripcion,cse.sNombre) AS servicio,
        (cse.sNombre + IF(rfa.sDescripcion IS NOT NULL, ' '+rfa.sDescripcion,'') ) AS servicioFact,
        cse.iClaveProductoServicio,  
        rfa.sDescripcion, 
        rfa.fCantidad,
        rfa.fPrecioUnitario,
        rfa.fDescuento,
        rfa.fImporteTotal AS fImporte,
        rfa.fImporteTotal AS fImporteTotal, 
        rfa.skUnidadMedida,
        cus.sClaveSAT, 
        cus.sNombre AS unidadMedida,
        rsir.sValor AS RETIVA,
        rsit.sValor AS TRAIVA, 
        (SELECT fImporte FROM rel_facturas_serviciosImpuestos rps where rps.skFactura = rfa.skFactura  AND rps.skImpuesto = 'RETIVA' AND rps.skFacturaServicio = rfa.skFacturaServicio )AS fImpuestosRetenidos,
        (SELECT fImporte FROM rel_facturas_serviciosImpuestos rps where rps.skFactura = rfa.skFactura  AND rps.skImpuesto = 'TRAIVA' AND rps.skFacturaServicio = rfa.skFacturaServicio )AS fImpuestosTrasladados
        FROM  rel_facturas_servicios rfa
        INNER JOIN ope_facturas occ ON occ.skFactura = rfa.skFactura
         LEFT JOIN cat_servicios cse ON cse.skServicio = rfa.skServicio
        LEFT JOIN cat_unidadesMedidaSAT cus ON cus.skUnidadMedida = rfa.skUnidadMedida
        LEFT JOIN rel_servicios_impuestos rsir ON rsir.skServicio = rfa.skServicio AND rsir.skImpuesto = 'RETIVA'
        LEFT JOIN rel_servicios_impuestos rsit ON rsit.skServicio = rfa.skServicio AND rsit.skImpuesto = 'TRAIVA'	 
        WHERE  rfa.skFactura = " . escape($this->admi['skFactura']);


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /*public function stpCUD_ordenesServicios() {

        $sql = "CALL stpCUD_ordenesServicios (
            " .escape(isset($this->admi['skOrdenServicio']) ? $this->admi['skOrdenServicio'] : NULL) . ",
            " .escape(isset($this->admi['skOrdenServicioServicio']) ? $this->admi['skOrdenServicioServicio'] : NULL) . ",
            " .escape(isset($this->admi['skServicio']) ? $this->admi['skServicio'] : NULL) . ",
            " .escape(isset($this->admi['skEstatus']) ? $this->admi['skEstatus'] : NULL) . ",
            " .escape($_SESSION['usuario']['skEmpresaSocioPropietario']) . ",
            " .escape(isset($this->admi['skEmpresaSocioResponsable']) ? $this->admi['skEmpresaSocioResponsable'] : NULL) . ",
            " .escape(isset($this->admi['skEmpresaSocioCliente']) ? $this->admi['skEmpresaSocioCliente'] : NULL) . ",
            " .escape(isset($this->admi['skEmpresaSocioFacturacion']) ? $this->admi['skEmpresaSocioFacturacion'] : NULL) . ",
            " .escape(isset($this->admi['skDivisa']) ? $this->admi['skDivisa'] : NULL) . ",
            " .escape(isset($this->admi['sReferencia']) ? $this->admi['sReferencia'] : NULL) . ",
            " .escape(isset($this->admi['sDescripcion']) ? $this->admi['sDescripcion'] : NULL) . ",
            " .escape(isset($this->admi['fImporteTotal']) ? $this->admi['fImporteTotal'] : NULL) . ",
            " .escape(isset($this->admi['fImporteSubtotal']) ? $this->admi['fImporteSubtotal'] : NULL) . ",
            " .escape(isset($this->admi['fImpuestosRetenidos']) ? $this->admi['fImpuestosRetenidos'] : NULL) . ",
            " .escape(isset($this->admi['fImpuestosTrasladados']) ? $this->admi['fImpuestosTrasladados'] : NULL) . ",
            " .escape(isset($this->admi['fDescuento']) ? $this->admi['fDescuento'] : NULL) . ",
            " .escape(isset($this->admi['fTipoCambio']) ? $this->admi['fTipoCambio'] : NULL) . ",
            " .escape(isset($this->admi['sContenedor']) ? $this->admi['sContenedor'] : NULL) . ",
            " .escape(isset($this->admi['sBl']) ? $this->admi['sBl'] : NULL) . ",
            " .escape(isset($this->admi['sPedimento']) ? $this->admi['sPedimento'] : NULL) . ",
            " .escape(isset($this->admi['skUsoCFDI']) ? $this->admi['skUsoCFDI'] : NULL) . ",
            " .escape(isset($this->admi['skMetodoPago']) ? $this->admi['skMetodoPago'] : NULL) . ",
            " .escape(isset($this->admi['skFormaPago']) ? $this->admi['skFormaPago'] : NULL) . ",
            " .escape(isset($this->admi['skTipoMedida']) ? $this->admi['skTipoMedida'] : NULL) . ",
            " .escape(isset($this->admi['fCantidad']) ? $this->admi['fCantidad'] : NULL) . ",

            " .escape(isset($this->admi['fPrecioUnitario']) ? $this->admi['fPrecioUnitario'] : NULL) . ",
            " .escape(isset($this->admi['skImpuesto']) ? $this->admi['skImpuesto'] : NULL) . ",
            " .escape(isset($this->admi['skTipoImpuesto']) ? $this->admi['skTipoImpuesto'] : NULL) . ",
            " .escape(isset($this->admi['fTasa']) ? $this->admi['fTasa'] : NULL) . ",
            " .escape(isset($this->admi['fImporte']) ? $this->admi['fImporte'] : NULL) . ",
            
           
            " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
            
       
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }*/

    public function _get_saldo_ordenes(){
        $sql = "SELECT
            RIGHT('000000'+ CAST(ors.iFolio AS VARCHAR(6)),6) AS iFolio, ors.skOrdenServicio, ors.fSaldoRelacion, ors.dFechaCreacion
            
            FROM ope_ordenesServicios ors 
            WHERE ors.skOrdenServicio IN (". mssql_where_in($this->admi['ordenes']).")";
         

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }


    public function _get_ordenes_pendientes_relacion(){
        $sql = "SELECT ors.skOrdenServicio,
        ors.iFolio,  
        ors.skEmpresaSocioResponsable,
        ors.skEmpresaSocioFacturacion,
        ors.fTipoCambio,
        ors.skFormaPago,
        ors.skMetodoPago,
        ors.skDivisa,
        ors.sReferencia, 
        ors.fImpuestosRetenidos,
        ors.fImpuestosTrasladados,
        ors.fImporteSubtotal,
        ors.fImporteTotal,
        ors.fDescuento,
        ors.fSaldoRelacion,
        ors.dFechaCreacion,
        fp.sCodigo AS codigoFormaPago,
        fp.sNombre AS formaPago,
        mp.sCodigo AS codigoMetodoPago,
        mp.sNombre AS metodoPago, 
        cer.sNombre AS empresaResponsable,
        cer.sRFC AS empresaResponsableRFC,
        cef.sNombre AS empresaFacturar,
        cef.sRFC AS empresaFacturarRFC
        FROM ope_ordenesServicios ors 
        INNER JOIN rel_empresasSocios resr ON resr.skEmpresaSocio = ors.skEmpresaSocioResponsable
        INNER JOIN cat_empresas cer ON cer.skEmpresa = resr.skEmpresa
        INNER JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = ors.skEmpresaSocioFacturacion
        INNER JOIN cat_empresas cef ON cef.skEmpresa = resf.skEmpresa
        LEFT JOIN cat_metodosPago mp ON mp.sCodigo = ors.skMetodoPago
        LEFT JOIN cat_formasPago fp ON fp.sCodigo = ors.skFormaPago 
        WHERE ors.fSaldoRelacion > 0  AND ors.skEstatus NOT IN('CA','NU','PE')
                ";

        if (isset($this->admi['skEmpresaSocioResponsable']) && !empty($this->admi['skEmpresaSocioResponsable'])) {
            $sql .= " AND ors.skEmpresaSocioResponsable = ".escape($this->admi['skEmpresaSocioResponsable']);
        }
 

        if (isset($this->admi['skDivisa']) && !empty($this->admi['skDivisa'])) {
            $sql .= " AND ors.skDivisa = ".escape($this->admi['skDivisa']);
        }

        if (isset($this->admi['skOrdenServicio']) && !empty($this->admi['skOrdenServicio'])) {
            $sql .= " AND ors.skOrdenServicio = ".escape($this->admi['skOrdenServicio']);
        }

        $sql .= " ORDER BY ors.dFechaCreacion ASC ";

 

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
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


  

    /**
     * consultar_tiposMedidas
     *
     * Obtiene los tipos de medidas activas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function consultar_tiposMedidas() {
        $sql = "SELECT skUnidadMedida AS id,CONCAT('(',sClaveSAT,') ', sNombre) AS nombre  FROM cat_unidadesMedidaSAT
				WHERE skEstatus = 'AC' ";
        if (!empty(trim($_POST['val']))) {
            $sql .= " AND sNombre   LIKE '%" . escape($_POST['val'], false) . "%' ";
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * consultar_servicios
     *
     * Obtiene los servicios
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function consultar_servicios() {
        $sql = "SELECT skServicio AS id,sNombre AS nombre  FROM cat_servicios
				WHERE 1 = 1 ";
        if (!empty(trim($_POST['val']))) {
            $sql .= " AND sNombre LIKE '%" . escape($_POST['val'], false) . "%' ";
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * consultar_servicio_impuestos
     *
     * Función Para obtener la configuracion de Responsable - Cliente
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function consultar_servicio_impuestos() {

        $sql = "SELECT DISTINCT
		                cse.skServicio,
                        resi.skImpuesto,
                        resi.skTipoImpuesto,
                        resi.sValor

		                FROM cat_servicios cse
		                INNER JOIN rel_servicios_impuestos resi ON resi.skServicio = cse.skServicio

		                WHERE cse.skServicio = " . escape($this->admi['skServicio']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }




    public function stpCUD_ordenServicio() {

        $sql = "CALL stpCUD_ordenServicio (
            " .escape(isset($this->admi['skOrdenServicio']) ? $this->admi['skOrdenServicio'] : NULL) . ",
            " .escape(isset($this->admi['skOrdenServicioServicio']) ? $this->admi['skOrdenServicioServicio'] : NULL) . ",
            " .escape(isset($this->admi['skServicio']) ? $this->admi['skServicio'] : NULL) . ",

            " .escape(isset($this->admi['skEstatus']) ? $this->admi['skEstatus'] : NULL) . ",

            " .escape($_SESSION['usuario']['skEmpresaSocioPropietario']) . ",
            " .escape(isset($this->admi['skEmpresaSocioResponsable']) ? $this->admi['skEmpresaSocioResponsable'] : NULL). ",
            " .escape(isset($this->admi['skEmpresaSocioCliente']) ? $this->admi['skEmpresaSocioCliente'] : NULL) . ",
            " .escape(isset($this->admi['skEmpresaSocioFacturacion']) ? $this->admi['skEmpresaSocioFacturacion'] : NULL) . ",
            " .escape(isset($this->admi['skDivisa']) ? $this->admi['skDivisa'] : NULL) . ",
            " .escape(isset($this->admi['sReferencia']) ? $this->admi['sReferencia'] : NULL) . ",
            " .escape(isset($this->admi['sNombreCliente']) ? $this->admi['sNombreCliente'] : NULL) . ",
            " .escape(isset($this->admi['sDescripcion']) ? $this->admi['sDescripcion'] : NULL) . ",


            " .escape(isset($this->admi['fImporteTotal']) ? $this->admi['fImporteTotal'] : NULL) . ",
            " .escape(isset($this->admi['fImporteSubtotal']) ? $this->admi['fImporteSubtotal'] : NULL) . ",
            " .escape(isset($this->admi['fImpuestosRetenidos']) ? $this->admi['fImpuestosRetenidos'] : NULL) . ",
            " .escape(isset($this->admi['fImpuestosTrasladados']) ? $this->admi['fImpuestosTrasladados'] : NULL) . ",
            " .escape(isset($this->admi['fDescuento']) ? $this->admi['fDescuento'] : NULL) . ",
            " .escape(isset($this->admi['fTipoCambio']) ? $this->admi['fTipoCambio'] : NULL) . ",
            " .escape(isset($this->admi['skUsoCFDI']) ? $this->admi['skUsoCFDI'] : NULL) . ",
            " .escape(isset($this->admi['skMetodoPago']) ? $this->admi['skMetodoPago'] : NULL) . ",
            " .escape(isset($this->admi['skFormaPago']) ? $this->admi['skFormaPago'] : NULL) . ",


            " .escape(isset($this->admi['skUnidadMedida']) ? $this->admi['skUnidadMedida'] : NULL) . ",
            " .escape(isset($this->admi['fCantidad']) ? $this->admi['fCantidad'] : NULL) . ",
            " .escape(isset($this->admi['fPrecioUnitario']) ? $this->admi['fPrecioUnitario'] : NULL) . ",

            " .escape(isset($this->admi['skImpuesto']) ? $this->admi['skImpuesto'] : NULL) . ",
            " .escape(isset($this->admi['skTipoImpuesto']) ? $this->admi['skTipoImpuesto'] : NULL) . ",
            " .escape(isset($this->admi['fTasa']) ? $this->admi['fTasa'] : NULL) . ",
            " .escape(isset($this->admi['fImporte']) ? $this->admi['fImporte'] : NULL) . ",

            " .escape(isset($this->admi['iNoFacturable']) ? $this->admi['iNoFacturable'] : NULL) . ",

 
            " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
     
        $this->log($sql, true);
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }


    public function stpCUD_facturas() {

        $sql = "CALL stpCUD_facturas (
            " .escape(isset($this->admi['skFactura']) ? $this->admi['skFactura'] : NULL) . ",
            " .escape(isset($this->admi['skFacturaServicio']) ? $this->admi['skFacturaServicio'] : NULL) . ",
            " .escape(isset($this->admi['skOrdenServicio']) ? $this->admi['skOrdenServicio'] : NULL) . ",
            " .escape(isset($this->admi['skServicio']) ? $this->admi['skServicio'] : NULL) . ",
            " .escape(isset($this->admi['skEstatus']) ? $this->admi['skEstatus'] : NULL) . ",
            " .escape(isset($this->admi['skComprobante']) ? $this->admi['skComprobante'] : NULL). ",
            " .escape($_SESSION['usuario']['skEmpresaSocioPropietario']) . ",
            " .escape(isset($this->admi['skEmpresaSocioEmisor']) ? $this->admi['skEmpresaSocioEmisor'] : NULL). ",
            " .escape(isset($this->admi['skEmpresaSocioResponsable']) ? $this->admi['skEmpresaSocioResponsable'] : NULL) . ",
            " .escape(isset($this->admi['skEmpresaSocioCliente']) ? $this->admi['skEmpresaSocioCliente'] : NULL) . ",
            " .escape(isset($this->admi['skEmpresaSocioFacturacion']) ? $this->admi['skEmpresaSocioFacturacion'] : NULL) . ",
            " .escape(isset($this->admi['skDivisa']) ? $this->admi['skDivisa'] : NULL) . ",
            " .escape(isset($this->admi['sReferencia']) ? $this->admi['sReferencia'] : NULL) . ",
            " .escape(isset($this->admi['sDescripcion']) ? $this->admi['sDescripcion'] : NULL) . ",
            " .escape(isset($this->admi['fTotal']) ? $this->admi['fTotal'] : NULL) . ",
            " .escape(isset($this->admi['fSaldo']) ? $this->admi['fSaldo'] : NULL) . ", 
            " .escape(isset($this->admi['fSubtotal']) ? $this->admi['fSubtotal'] : NULL) . ", 
            " .escape(isset($this->admi['fImpuestosRetenidos']) ? $this->admi['fImpuestosRetenidos'] : NULL) . ",
            " .escape(isset($this->admi['fImpuestosTrasladados']) ? $this->admi['fImpuestosTrasladados'] : NULL) . ",
            " .escape(isset($this->admi['fDescuento']) ? $this->admi['fDescuento'] : NULL) . ",
            " .escape(isset($this->admi['fTipoCambio']) ? $this->admi['fTipoCambio'] : NULL) . ", 
            " .escape(isset($this->admi['skUsoCFDI']) ? $this->admi['skUsoCFDI'] : NULL) . ",
            " .escape(isset($this->admi['skMetodoPago']) ? $this->admi['skMetodoPago'] : NULL) . ",
            " .escape(isset($this->admi['skFormaPago']) ? $this->admi['skFormaPago'] : NULL) . ",
            " .escape(isset($this->admi['sSerie']) ? $this->admi['sSerie'] : NULL) . ",
            " .escape(isset($this->admi['sRFCEmisor']) ? $this->admi['sRFCEmisor'] : NULL) . ",
            " .escape(isset($this->admi['sRFCReceptor']) ? $this->admi['sRFCReceptor'] : NULL) . ",


            " .escape(isset($this->admi['skUnidadMedida']) ? $this->admi['skUnidadMedida'] : NULL) . ",
            " .escape(isset($this->admi['fCantidad']) ? $this->admi['fCantidad'] : NULL) . ",
            " .escape(isset($this->admi['fPrecioUnitario']) ? $this->admi['fPrecioUnitario'] : NULL) . ",

            " .escape(isset($this->admi['skImpuesto']) ? $this->admi['skImpuesto'] : NULL) . ",
            " .escape(isset($this->admi['skTipoImpuesto']) ? $this->admi['skTipoImpuesto'] : NULL) . ",
            " .escape(isset($this->admi['fTasa']) ? $this->admi['fTasa'] : NULL) . ",
            " .escape(isset($this->admi['fImporte']) ? $this->admi['fImporte'] : NULL) . ",


            " .escape(isset($this->admi['sFolioFactura']) ? $this->admi['sFolioFactura'] : NULL) . ",
            " .escape(isset($this->admi['skUUIDSAT']) ? $this->admi['skUUIDSAT'] : NULL) . ",
            " .escape(isset($this->admi['fTotalFactura']) ? $this->admi['fTotalFactura'] : NULL) . ",
            " .escape(isset($this->admi['dFechaFactura']) ? $this->admi['dFechaFactura'] : NULL) . ",
            " .escape(isset($this->admi['dFechaTimbrado']) ? $this->admi['dFechaTimbrado'] : NULL) . ",

            " .escape(isset($this->admi['iNoFacturable']) ? $this->admi['iNoFacturable'] : NULL) . ",


            
           
            " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
          
       
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }

    
        /**
    * getEmpresasSocios
    *
    * Funcion para consultar todos los Datos de la empresa socio
    *
    * Modulo utilizado por los ejecutivos y Comercial
    *
    * @author Cristian Alexis Mendoza Gonzalez <cmendoza@woodward.com.mx>
    * @return todos los corresponsales existentes  || si es error retorna FALSE.
    *
    */
    public function getEmpresasSocios() {

        $sql = "select relEmp.skEmpresaSocio, catEmp.sNombre , catEmp.sNombreCorto, catEmp.sRFC, catEmp.skEstatus, catEmpTi.sNombre AS nombreTipo, relEmp.dFechaCreacion from rel_empresasSocios AS relEmp
        LEFT JOIN cat_empresas AS catEmp ON catEmp.skEmpresa = relEmp.skEmpresa
        LEFT JOIN cat_empresasTipos AS catEmpTi ON catEmpTi.skEmpresaTipo = relEmp.skEmpresaTipo
        where skEmpresaSocio = ". escape($this->cfdi['skEmpresaSocio']);
        $result = Conn::query($sql);
  
        if (!$result) {
            return FALSE;
        }
  
        return Conn::fetch_assoc($result);
      }
  
      public function getFacturasEmpresaSocio($estatus=''){
          $sql = "SELECT  occ.skEstatus,occ.skEstatusPago,
          ep.sNombre AS estatusPago,ep.sIcono AS estatusPagoIcono,ep.sColor AS estatusPagoColor,
          e.sNombre AS estatus,e.sColor AS estatusColor,e.sIcono AS estatusIcono,
          occ.iFolio,occ.skFormaPago,occ.skMetodoPago,occ.skUsoCFDI,
         occ.dFechaCreacion AS dFechaFacturacion,occ.fTotal,occ.fSaldo,cee.sNombre AS Facturacion,cer.sNombre AS responsable,
          occ.dFechaCreacion,
          cfp.sCodigo AS formaPago,cfp.sNombre AS nombreFormaPago,
          cmp.sCodigo AS metodoPago,cmp.sNombre AS nombreMetodoPago,
          cuc.sClave AS usoCFDI,cuc.sNombre AS nombreCFDI
          FROM ope_facturas occ
          LEFT JOIN cat_metodosPago cmp ON cmp.sCodigo = occ.skMetodoPago
          LEFT JOIN cat_formasPago cfp ON cfp.sCodigo = occ.skFormaPago
          LEFT JOIN cat_usosCFDI cuc ON cuc.sClave = occ.skUsoCFDI
          LEFT JOIN rel_empresasSocios ree ON ree.skEmpresaSocio = occ.skEmpresaSocioFacturacion
          LEFT JOIN cat_empresas cee ON cee.skEmpresa = ree.skEmpresa
          LEFT JOIN rel_empresasSocios rer ON rer.skEmpresaSocio = occ.skEmpresaSocioResponsable
          LEFT JOIN cat_empresas cer ON cer.skEmpresa = rer.skEmpresa
          LEFT JOIN core_estatus ep ON  ep.skEstatus = occ.skEstatusPago
          LEFT JOIN core_estatus e ON  e.skEstatus = occ.skEstatus
      WHERE 1 = 1   AND  occ.skEmpresaSocioFacturacion = ".escape(isset($this->cfdi['skEmpresaSocio']) ? $this->cfdi['skEmpresaSocio'] : NULL);
  
                  if(isset($estatus) && !empty(trim($estatus))){
                      if($estatus == 'PA'){
                          $sql.=" AND occ.skEstatusPago = 'PA' AND occ.skEstatus != 'CA'";
                      }
  
                      if($estatus == 'PE'){
                           $sql.=" AND ( occ.skEstatusPago = 'PE' OR occ.skEstatusPago IS NULL) AND occ.skEstatus != 'CA' ";
                      }
  
                      if($estatus == 'CA'){
                          $sql.=" AND occ.skEstatus = 'CA'";
                      }
                  }
              
          $result = Conn::query($sql);
          if (!$result) {
              return FALSE;
          }
          $record = Conn::fetch_assoc_all($result);
          return $record;
      }
 

     
    /**
     * _validarBanco
     *
     * Funcion para validar si existe el RFC, Cuenta Contable del Banco
     *
     * @author lvaldez
     * @return array
     */
    public function _validarBanco(){
        $sql = "SELECT * FROM cat_bancos WHERE skEstatus = 'AC' ";

        if (isset($this->admi['sRFC']) && !empty(trim($this->admi['sRFC']))) {
            $sql .= " AND sRFC = ".escape($this->admi['sRFC']);
        }

        if (isset($this->admi['sCuentaContable']) && !empty(trim($this->admi['sCuentaContable']))) {
            $sql .= " AND sCuentaContable = ".escape($this->admi['sCuentaContable']);
        }

        if (isset($this->admi['skBanco']) && !empty(trim($this->admi['skBanco']))) {
            $sql .= " AND skBanco != ".escape($this->admi['skBanco']);
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
         }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

    public function _getBancos(){
        $sql = "SELECT
            b.*
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno,' ',ucre.sApellidoMaterno) AS usuarioCreacion
            ,IF(b.skUsuarioModificacion IS NOT NULL,CONCAT(umod.sNombre,' ',umod.sApellidoPaterno,' ',umod.sApellidoMaterno),NULL) AS usuarioModificacion
            FROM cat_bancos b
            INNER JOIN core_estatus est ON est.skEstatus = b.skEstatus
            INNER JOIN cat_usuarios ucre ON ucre.skUsuario = b.skUsuarioCreacion
            LEFT JOIN cat_usuarios umod ON umod.skUsuario = b.skUsuarioModificacion
            WHERE b.skEstatus='AC' ";

        if (isset($this->admi['skBanco']) && !empty(trim($this->admi['skBanco']))) {
            $sql .= " AND b.skBanco = ".escape($this->admi['skBanco']);
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    

    public function stpCUD_bancos() {

 
        
        $sql = "CALL stpCUD_bancos (
            " .escape(isset($this->admi['skBanco']) ? $this->admi['skBanco'] : NULL) . ",
            " .escape(isset($this->admi['skEstatus']) ? $this->admi['skEstatus'] : NULL) . ",
            " .escape(isset($this->admi['sNombre']) ? $this->admi['sNombre'] : NULL) . ",
            " .escape(isset($this->admi['sNombreCorto']) ? $this->admi['sNombreCorto'] : NULL) . ",
            " .escape(isset($this->admi['sRFC']) ? $this->admi['sRFC'] : NULL) . ",
            " .escape(isset($this->admi['sObservaciones']) ? $this->admi['sObservaciones'] : NULL) . ",
            " .escape($_SESSION['usuario']['skEmpresaSocioPropietario']).",
 

            
           
            " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
          
       
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }


    public function stpCUD_bancoCuentas() {

  
        $sql = "CALL stpCUD_bancoCuentas (
            " .escape(isset($this->admi['skBancoCuenta']) ? $this->admi['skBancoCuenta'] : NULL) . ",
            " .escape(isset($this->admi['skBanco']) ? $this->admi['skBanco'] : NULL) . ",
            " .escape(isset($this->admi['skDivisa']) ? $this->admi['skDivisa'] : NULL) . ",
            " .escape(isset($this->admi['skEmpresaSocioResponsable']) ? $this->admi['skEmpresaSocioResponsable'] : NULL) . ",
            " .escape(isset($this->admi['sTitular']) ? $this->admi['sTitular'] : NULL) . ",
            " .escape(isset($this->admi['sNumeroCuenta']) ? $this->admi['sNumeroCuenta'] : NULL) . ",
            " .escape(isset($this->admi['sClabeInterbancaria']) ? $this->admi['sClabeInterbancaria'] : NULL) . ",
            " .escape(isset($this->admi['skEstatus']) ? $this->admi['skEstatus'] : NULL) . ",
            " .escape(isset($this->admi['sCuentaContable']) ? $this->admi['sCuentaContable'] : NULL) . ",
            " .escape(isset($this->admi['sCuentaContableComplementaria']) ? $this->admi['sCuentaContableComplementaria'] : NULL) . ",
            " .escape(isset($this->admi['sObservaciones']) ? $this->admi['sObservaciones'] : NULL) . ",
            " .escape($_SESSION['usuario']['skEmpresaSocioPropietario']).",
 

            
           
            " .escape(isset($this->admi['axn']) ? $this->admi['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
          
       
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }

   /**
       * consultar_divisas
       *
       * Obtiene los tipos de procesos activos para servicios
       *
       * @author lvaldez
       * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
       */
      public function consultar_divisas() {
        $sql = "SELECT skDivisa AS id, skDivisa AS nombre  FROM cat_divisas
        WHERE skEstatus = 'AC' ";

        if(isset($_POST['val']) && !empty(trim($_POST['val']))){
            $sql.=" AND skDivisa  COLLATE Latin1_General_CI_AI LIKE '%".escape($_POST['val'], FALSE)."%' ";
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * _validarDatosCuentaBancaria
     *
     * Función para validar los datos de la cuenta bancaria
     *
     * @author lvaldez
     * @return array
     */
    public function _validarDatosCuentaBancaria(){
        $sql = "SELECT * FROM cat_bancosCuentas WHERE skEstatus = 'AC' ";

        if (isset($this->admi['skBancoCuenta']) && !empty(trim($this->admi['skBancoCuenta']))) {
            $sql .= " AND skBancoCuenta != ".escape($this->admi['skBancoCuenta']);
        }

        if (isset($this->admi['skBanco']) && !empty(trim($this->admi['skBanco']))) {
            $sql .= " AND skBanco = ".escape($this->admi['skBanco']);
        }

        if (isset($this->admi['sNumeroCuenta']) && !empty(trim($this->admi['sNumeroCuenta']))) {
            $sql .= " AND sNumeroCuenta = ".escape($this->admi['sNumeroCuenta']);
        }

        if (isset($this->admi['sCuentaContable']) && !empty(trim($this->admi['sCuentaContable']))) {
            $sql .= " AND sCuentaContable = ".escape($this->admi['sCuentaContable']);
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
         }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }
    

}
