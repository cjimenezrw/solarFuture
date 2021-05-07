<?php

Class Vent_Model Extends DLOREAN_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    protected $vent = array(); 
  
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        //parent::__construct();
    }

    public function __destruct() {

    }
   
 
     
    public function stpCUD_cotizaciones() {

        $sql = "CALL stpCUD_cotizaciones (
            " .escape(isset($this->vent['skCotizacion']) ? $this->vent['skCotizacion'] : NULL) . ",
            " .escape(isset($this->vent['skCotizacionConcepto']) ? $this->vent['skCotizacionConcepto'] : NULL) . ",
            " .escape(isset($this->vent['skEstatus']) ? $this->vent['skEstatus'] : NULL) . ",
            " .escape(isset($this->vent['skDivisa']) ? $this->vent['skDivisa'] : NULL) . ",
            " .escape(isset($this->vent['dFechaVigencia']) ? $this->vent['dFechaVigencia'] : NULL) . ",
            " .escape(isset($this->vent['skEmpresaSocioCliente']) ? $this->vent['skEmpresaSocioCliente'] : NULL) . ",
            " .escape(isset($this->vent['skProspecto']) ? $this->vent['skProspecto'] : NULL) . ",
            " .escape(isset($this->vent['sObservaciones']) ? $this->vent['sObservaciones'] : NULL) . ",
            " .escape(isset($this->vent['sObservacionesCancelacion']) ? $this->vent['sObservacionesCancelacion'] : NULL) . ",
            " .escape(isset($this->vent['sCondicion']) ? $this->vent['sCondicion'] : NULL) . ",
            " .escape(isset($this->vent['fImporteSubtotal']) ? $this->vent['fImporteSubtotal'] : NULL) . ",
            " .escape(isset($this->vent['fDescuento']) ? $this->vent['fDescuento'] : NULL) . ",
            " .escape(isset($this->vent['fImpuestosTrasladados']) ? $this->vent['fImpuestosTrasladados'] : NULL) . ",
            " .escape(isset($this->vent['fImpuestosRetenidos']) ? $this->vent['fImpuestosRetenidos'] : NULL) . ",
            " .escape(isset($this->vent['fImporteTotal']) ? $this->vent['fImporteTotal'] : NULL) . ",
            " .escape(isset($this->vent['fTipoCambio']) ? $this->vent['fTipoCambio'] : NULL) . ",
            " .escape(isset($this->vent['skConcepto']) ? $this->vent['skConcepto'] : NULL) . ",
            " .escape(isset($this->vent['skTipoMedida']) ? $this->vent['skTipoMedida'] : NULL) . ",
            " .escape(isset($this->vent['skImpuesto']) ? $this->vent['skImpuesto'] : NULL) . ",
            " .escape(isset($this->vent['sDescripcion']) ? $this->vent['sDescripcion'] : NULL) . ",
            " .escape(isset($this->vent['fCantidad']) ? $this->vent['fCantidad'] : NULL) . ",
            " .escape(isset($this->vent['fPrecioUnitario']) ? $this->vent['fPrecioUnitario'] : NULL) . ",
            " .escape(isset($this->vent['fImporte']) ? $this->vent['fImporte'] : NULL) . ",
            " .escape(isset($this->vent['sCorreo']) ? $this->vent['sCorreo'] : NULL) . ",
            " .escape(isset($this->vent['skInformacionProductoServicio']) ? $this->vent['skInformacionProductoServicio'] : NULL) . ",
            " .escape(isset($this->vent['skCatalogoSistemaOpciones']) ? $this->vent['skCatalogoSistemaOpciones'] : NULL) . ",
            " .escape(isset($this->vent['fCostoRecibo']) ? $this->vent['fCostoRecibo'] : NULL) . ",
            " .escape(isset($this->vent['iInformacionPanel']) ? $this->vent['iInformacionPanel'] : NULL) . ",
            " .escape(isset($this->vent['fKwGastados']) ? $this->vent['fKwGastados'] : NULL) . ",
            " .escape(isset($this->vent['skCategoriaPrecio']) ? $this->vent['skCategoriaPrecio'] : NULL) . ",
            " .escape(isset($this->vent['sDireccion']) ? $this->vent['sDireccion'] : NULL) . ",
            " .escape(isset($this->vent['sRPU']) ? $this->vent['sRPU'] : NULL) . ",
            " .escape(isset($this->vent['sTelefono']) ? $this->vent['sTelefono'] : NULL) . ",
            " .escape(isset($this->vent['TARIFA']) ? $this->vent['TARIFA'] : NULL) . ",

            " .escape(isset($this->vent['axn']) ? $this->vent['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
         
        
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }


    /**
     * _getCotizacion
     *
     * Obtener Datos de Cotizacion guardada
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array Datos | False
     */
    public function _getCotizacion() {

        $sql = "SELECT 
        oc.skCotizacion,
        CONCAT('SFM',RIGHT(CONCAT('0000',CAST(oc.iFolio AS VARCHAR(4))),4)) AS iFolio,
        oc.dFechaVigencia,
        oc.skDivisa,
        oc.skEmpresaSocioCliente,
        oc.skProspecto,
        oc.sObservaciones,
        oc.sCondicion,
        oc.fImporteSubtotal,
        oc.fDescuento,
        oc.fImpuestosTrasladados,
        oc.fImpuestosRetenidos,
        oc.fImporteTotal,
        oc.fTipoCambio,
        oc.fCostoRecibo,
        oc.iInformacionPanel,
        oc.fKwGastados,
        oc.skCategoriaPrecio,
        oc.sDireccion,
        oc.sRPU,
        oc.sTelefono,
        oc.TARIFA,
        oc.dFechaCreacion,
        cp.sNombreContacto AS prospecto,
        cep.sRFC AS clienteRFC,
        rca.sNombre AS categoria,
        cu.sNombre AS usuarioCreacion,
        (SELECT SUM(cc2.fMetros2*rcc.fCantidad) FROM rel_cotizaciones_conceptos rcc  
        INNER JOIN cat_conceptos cc2 ON cc2.skConcepto = rcc.skConcepto AND cc2.skCategoriaProducto = 'PANSOL' 
        WHERE rcc.skCotizacion = oc.skCotizacion ) AS metros2,
        (SELECT SUM(rcc.fCantidad) FROM rel_cotizaciones_conceptos rcc  
        INNER JOIN cat_conceptos cc2 ON cc2.skConcepto = rcc.skConcepto AND cc2.skCategoriaProducto = 'PANSOL' 
        WHERE rcc.skCotizacion = oc.skCotizacion ) AS cantidadPanel,
        (SELECT  (SUM(fKwConcepto)/1000) FROM rel_cotizaciones_conceptos WHERE skCotizacion = oc.skCotizacion  ) AS capacidad,
        (SELECT  ((SUM(fKwConcepto)*4.5)/1000) FROM rel_cotizaciones_conceptos WHERE skCotizacion = oc.skCotizacion  ) AS produccionDiaria,
        (SELECT  ((SUM(fKwConcepto)*4.5)/1000)*30 FROM rel_cotizaciones_conceptos WHERE skCotizacion = oc.skCotizacion  ) AS produccionMensual,
        (SELECT  ((SUM(fKwConcepto)*4.5)/1000)*60 FROM rel_cotizaciones_conceptos WHERE skCotizacion = oc.skCotizacion  ) AS produccionBimestral,
        (SELECT  ((SUM(fKwConcepto)*4.5)/1000)*365 FROM rel_cotizaciones_conceptos WHERE skCotizacion = oc.skCotizacion  ) AS produccionAnual,
        (SELECT  ((((SUM(fKwConcepto)*4.5)/1000)*365) /(oc.fKwGastados*6)*100) FROM rel_cotizaciones_conceptos WHERE skCotizacion = oc.skCotizacion  ) AS porcentajeAnualCubierto,

        ROUND(ROUND(oc.fImporteTotal/oc.fCostoRecibo,1)/6,1) AS recuperacionInversion,
        (oc.fCostoRecibo * 6) AS gastoAnual,
        (oc.fKwGastados * 6) AS consumoAnual,
        (oc.fImporteTotal /(oc.fKwGastados * 6)) AS precioPromedio,
        IF(cep.sNombre IS NOT NULL,cep.sNombre,IF(cp.sNombreContacto IS NOT NULL,cp.sNombreContacto,NULL)) AS cliente
        FROM ope_cotizaciones oc 
        LEFT JOIN rel_empresasSocios resc ON resc.skEmpresaSocio = oc.skEmpresaSocioCliente
        LEFT JOIN cat_prospectos cp ON cp.skProspecto = oc.skEmpresaSocioCliente
        LEFT JOIN cat_empresas cep ON cep.skEmpresa = resc.skEmpresa
        LEFT JOIN cat_usuarios cu ON cu.skUsuario = oc.skUsuarioCreacion 
        LEFT JOIN rel_catalogosSistemasOpciones rca ON rca.skCatalogoSistemaOpciones = oc.skCategoriaPrecio
 
        WHERE  oc.skCotizacion =  " . escape($this->vent['skCotizacion']);


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

     /**
     * _getCotizacionConceptos
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getCotizacionConceptos() {

        $sql = "SELECT DISTINCT
		                cse.skCotizacionConcepto,
		                cse.skCotizacion,
		                cse.skConcepto,
                        cse.skTipoMedida,
                        cse.fCantidad,
                        cse.fPrecioUnitario,
                        cse.fImporte,
                        cse.sDescripcion,
                        cc.sNombre AS concepto,
                        cc.sCodigo AS sCodigo,
                        cc.iDetalle,
                        cum.sNombre as tipoMedida
		                FROM rel_cotizaciones_conceptos cse 
                        INNER JOIN cat_conceptos cc ON cc.skConcepto = cse.skConcepto
                        LEFT JOIN cat_unidadesMedidaSAT cum ON cum.skUnidadMedida = cse.skTipoMedida
		                WHERE cse.skCotizacion = " . escape($this->vent['skCotizacion']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        $i = 0;
        foreach ($records as $value) {

            $this->vent['skCotizacionConcepto'] = $value['skCotizacionConcepto'];

            $this->vent['skConcepto'] = $value['skConcepto'];
            $records[$i]['impuestos'] = $this->_getCotizacionConceptos_impuestos();
            $records[$i]['venta'] = $this->_getCotizacionConceptos_ventas();
            $i++;
        }
       
        return $records;
    }
     /**
     * _getCotizacionConceptos_impuestos
     *
     * Función Para obtener los datos de los almacenes
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getCotizacionConceptos_impuestos() {

        $sql = "SELECT
							
							 ras.skTipoImpuesto  AS tipoImpuesto,
							 ci.sNombre AS impuesto
							 FROM rel_cotizaciones_conceptosImpuestos ras
							 INNER JOIN cat_impuestos ci ON ci.skImpuesto = ras.skImpuesto
							 WHERE ras.skCotizacion = " . escape($this->vent['skCotizacion']) . " AND ras.skCotizacionConcepto = " . escape($this->vent['skCotizacionConcepto']) . "  AND ras.skConcepto= " . escape($this->vent['skConcepto']);
   
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        return $records;
    }
    /**
     * _getCotizacionConceptos_ventas
     *
     * Función Para obtener los datos de los almacenes
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getCotizacionConceptos_ventas() {

        $sql = "SELECT
							  
                             rci.sNumeroSerie 
							 FROM rel_cotizaciones_conceptos  ras
							 INNER JOIN rel_conceptos_inventarios rci ON rci.skCotizacionConcepto = ras.skCotizacionConcepto
							 WHERE ras.skCotizacion = " . escape($this->vent['skCotizacion']) . " AND ras.skCotizacionConcepto = " . escape($this->vent['skCotizacionConcepto']) . "  AND ras.skConcepto= " . escape($this->vent['skConcepto']);
     
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        return $records;
    }
     /**
     * _getCotizacionCorreos
     *
     * Función Para obtener los correos de las cotizaciones
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getCotizacionCorreos() {

        $sql = "SELECT rcc.sCorreo FROM rel_cotizaciones_correos rcc WHERE  rcc.skCotizacion= " . escape($this->vent['skCotizacion']);
   
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        return $records;
    }


    /**
       * consultar_unidadesMedida
       *
       * Obtiene los tipos de procesos activos para servicios
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
       */
      public function consultar_unidadesMedida() {
        $sql = "SELECT skUnidadMedida, CONCAT('(',sClaveSAT,') ', sNombre)  AS sNombre FROM cat_unidadesMedidaSAT
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
     * Obtiene los impuestos que pueden aplicar al Concepto
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
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

    public function _getConceptoImpuestos() {
        $select = "SELECT cim.skImpuesto,CONCAT( cim.skTipoImpuesto,'-',cim.sNombre,'(', cim.svalor,'%)')  AS nombre 
                    FROM rel_conceptos_impuestos  rci
                    INNER JOIN cat_impuestos cim ON cim.skImpuesto = rci.skImpuesto
                    where rci.skConcepto = '".$this->vent['skConcepto']."' ";
       
        $result = Conn::query($select);
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

        if (isset($this->vent['skEmpresaTipo']) && !empty($this->vent['skEmpresaTipo'])) {
            if (is_array($this->vent['skEmpresaTipo'])) {
                $sql .= " AND es.skEmpresaTipo IN (" . mssql_where_in($this->vent['skEmpresaTipo']) . ") ";
            } else {
                $sql .= " AND es.skEmpresaTipo = " . escape($this->vent['skEmpresaTipo']);
            }
        }

        $sql .= " ) AS N1 ";

        if (isset($this->vent['sNombre']) && !empty(trim($this->vent['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->vent['sNombre']) . "%' ";
        }

        if (isset($this->vent['skEmpresaSocio']) && !empty($this->vent['skEmpresaSocio'])) {
            $sql .= " WHERE N1.id = " . escape($this->vent['skEmpresaSocio']);
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
     * get_empresasProspectos
     *
     * Consulta Empresas Socios
     *
     * @author Luis Valdez <lvaldez@softlab.com.mx>
     * @return Array Datos | False
     */
    public function get_empresasProspectos() {

        $sql = "SELECT N1.* FROM (
            SELECT
            cp.skProspecto AS id, CONCAT(cp.sNombreContacto,' - Prospecto') AS nombre
            FROM cat_prospectos cp
            WHERE cp.skEstatus = 'NU'
            UNION 
            SELECT
            es.skEmpresaSocio AS id, CONCAT(e.sNombre,' (',e.sRFC,') - Cliente') AS nombre
            FROM rel_empresasSocios es
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            WHERE es.skEstatus = 'AC' AND e.skEstatus = 'AC' AND es.skEmpresaTipo IN ('CLIE') "; 

      
        $sql .= " ) AS N1 ";
        

        if (isset($this->vent['sNombre']) && !empty(trim($this->vent['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->vent['sNombre']) . "%' ";
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
     * get_empresas
     *
     * Consulta Empresas Socios
     *
     * @author Luis Valdez <lvaldez@softlab.com.mx>
     * @return Array Datos | False
     */
    public function get_prospectos() {

        $sql = "SELECT N1.* FROM (
            SELECT
            cp.skProspecto AS id, cp.sNombreContacto AS nombre
            FROM cat_prospectos cp
            WHERE cp.skEstatus = 'NU' "; 

      
        $sql .= " ) AS N1 ";

        if (isset($this->vent['sNombre']) && !empty(trim($this->vent['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->vent['sNombre']) . "%' ";
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
     * consultar_tiposMedidas
     *
     * Obtiene los tipos de medidas activas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function consultar_tiposMedidas() {
        $sql = "SELECT skUnidadMedida AS id,sNombre AS nombre  FROM cat_unidadesMedidaSAT
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
     * consultar_conceptos
     *
     * Obtiene los Conceptos disponibles
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function consultar_conceptos() {
        $sql = "SELECT skConcepto AS id,sNombre AS nombre  FROM cat_conceptos
				WHERE skEstatus = 'NU' ";
        if (!empty(trim($_POST['val']))) {
            $sql .= " AND sNombre   LIKE '%" . escape($_POST['val'], false) . "%' ";
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records,FALSE);
        return $records;
    }
    /**
     * consultar_conceptos_datos
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function consultar_conceptos_datos() {

        $sql = "SELECT   rcp.fPrecioVenta 
        FROM cat_conceptos cse 
        LEFT JOIN rel_conceptos_precios rcp ON rcp.skConcepto = cse.skConcepto 
        WHERE cse.skConcepto = " . escape($this->vent['skConcepto']);

        if (isset($this->vent['skCategoriaPrecio']) && !empty($this->vent['skCategoriaPrecio'])) {
            $sql .= " AND rcp.skCategoriaPrecio = ".escape($this->vent['skCategoriaPrecio'])." LIMIT 1 ";
        }else{
            $sql .= " ORDER BY rcp.fPrecioVenta DESC LIMIT 1 ";
        } 


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }
    /**
     * consultar_conceptos_impuestos
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function consultar_conceptos_impuestos() {

        $sql = "SELECT DISTINCT
		                cse.skConcepto,
                        resi.skImpuesto,
                        resi.skTipoImpuesto,
                        resi.sValor,
                        cse.fPrecioVenta
		                FROM cat_conceptos cse
		                INNER JOIN rel_conceptos_impuestos resi ON resi.skConcepto = cse.skConcepto

		                WHERE cse.skConcepto = " . escape($this->vent['skConcepto']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * _getDivisas
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getDivisas() {

        $sql = "SELECT DISTINCT
		                cd.skDivisa,
                        cd.sNombre 
		                FROM cat_divisas cd WHERE skEstatus='AC'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }
    /**
     * _getCategorias
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getCategorias() {

        $sql = "SELECT cso.sNombre,cso.skCatalogoSistemaOpciones AS skCategoriaPrecio  FROM cat_catalogosSistemas cs
        INNER JOIN rel_catalogosSistemasOpciones cso ON cso.skCatalogoSistema = cs.skCatalogoSistema 
        WHERE cs.skCatalogoSistema = 'CATPRE' AND cso.skEstatus = 'AC'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }


    /**
     * _getInformacionProducto
     *
     * Obtiene los tipos de procesos activos para servicios
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function _getInformacionProducto() {
        $sql = "SELECT skInformacionProductoServicio,sNombre AS informacionProducto FROM cat_informacionProductoServicio
        WHERE skEstatus = 'AC' ";


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _getCotizacionInformacionProducto() {
        $select = "SELECT cip.skInformacionProductoServicio,sNombre,sDescripcionHoja1,sDescripcionHoja2,sImagen FROM rel_cotizacion_informacionProducto rci
        LEFT JOIN cat_informacionProductoServicio cip ON cip.skInformacionProductoServicio = rci.skInformacionProductoServicio
         where rci.skCotizacion = " . escape($this->vent['skCotizacion']);
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * _getTerminosCondiciones
     *
     * Obtiene los tipos de procesos activos para servicios
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function _getTerminosCondiciones() {
        $sql = "SELECT skCatalogoSistemaOpciones,sNombre AS terminoCondicion 
        FROM rel_catalogosSistemasOpciones
        WHERE skEstatus = 'AC' AND skCatalogoSistema = 'TERCOT' ORDER BY sNombre ASC ";


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _getCotizacionTerminosCondiciones() {
        $select = "SELECT rci.skCatalogoSistemaOpciones,rcs.sNombre AS  terminoCondicion
        FROM rel_cotizaciones_terminosCondiciones rci
        LEFT JOIN rel_catalogosSistemasOpciones rcs ON rcs.skCatalogoSistemaOpciones = rci.skCatalogoSistemaOpciones AND rcs.skCatalogoSistema = 'TERCOT'
         where rci.skCotizacion = " . escape($this->vent['skCotizacion'])." ORDER BY rcs.sNombre ASC ";
          
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

     /**
     * get_conceptosInventario
     *
     * Consulta 
     *
     * @author Luis Valdez <lvaldez@softlab.com.mx>
     * @return Array Datos | False
     */
    public function get_conceptosInventario() {
        $sql = "SELECT N1.* FROM (
            SELECT
            rci.skConceptoInventario AS id, rci.sNumeroSerie AS nombre 
            FROM rel_conceptos_inventarios rci 
            WHERE rci.skEstatus = 'NU' AND rci.skConcepto = " . escape($this->vent['skConcepto']);

  

        $sql .= " ) AS N1 ";

        if (isset($this->vent['sNombre']) && !empty(trim($this->vent['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->vent['sNombre']) . "%' ";
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
    public function stpCUD_conceptosInventario() {

        $sql = "CALL stpCUD_conceptosInventario (
            " .escape(isset($this->vent['skConcepto']) ? $this->vent['skConcepto'] : NULL) . ",
            " .escape(isset($this->vent['skCotizacionConcepto']) ? $this->vent['skCotizacionConcepto'] : NULL) . ",
            " .escape(isset($this->vent['skConceptoInventario']) ? $this->vent['skConceptoInventario'] : NULL) . ",
            " .escape(isset($this->vent['skEstatus']) ? $this->vent['skEstatus'] : NULL) . ",
            " .escape(isset($this->vent['fCantidad']) ? $this->vent['fCantidad'] : NULL) . ",
            " .escape(isset($this->vent['sNumeroSerie']) ? $this->vent['sNumeroSerie'] : NULL) . ",
            " .escape(isset($this->vent['axn']) ? $this->vent['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
 
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }

    public function stpCUD_ventas() {

        $sql = "CALL stpCUD_ventas (
            " .escape(isset($this->vent['skVenta']) ? $this->vent['skVenta'] : NULL) . ",
            " .escape(isset($this->vent['skCotizacion']) ? $this->vent['skCotizacion'] : NULL) . ", 
            " .escape(isset($this->vent['axn']) ? $this->vent['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
 
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record; 
    }


      

   


}
