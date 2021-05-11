<?php

Class Conc_Model Extends DLOREAN_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    protected $conc = array(); 
  
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        //parent::__construct();
    }

    public function __destruct() {

    }

    public function eliminarProductosInventario(){
        $sql = "UPDATE rel_conceptos_inventarios SET 
            skEstatus = 'EL',
            dFechaModificacion = NOW(),
            skUsuarioModificacion = ".escape($_SESSION['usuario']['skUsuario'])."
            WHERE skConceptoInventario NOT IN (".mssql_where_in($this->conc['skConceptoInventario']).") AND skEstatus = 'NU'";
           
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    public function _get_conceptos_inventario(){
        $sql = "SELECT 
            rci.*
            ,ce.sNombre AS estatus
            ,ce.sIcono AS estatusIcono
            ,ce.sColor AS estatusColor
            ,CONCAT('SFM',RIGHT(CONCAT('0000',CAST(oc.iFolio AS VARCHAR(4))),4)) AS iFolio
            FROM rel_conceptos_inventarios rci
            INNER JOIN core_estatus ce ON ce.skEstatus = rci.skEstatus
            LEFT JOIN rel_cotizaciones_conceptos rcc ON rcc.skCotizacionConcepto = rci.skCotizacionConcepto
            LEFT JOIN ope_cotizaciones oc ON oc.skCotizacion = rcc.skCotizacion
            WHERE rci.skConcepto = ".escape($this->conc['skConcepto']);

        if (isset($this->conc['skEstatus']) && !empty(trim($this->conc['skEstatus']))) {
            $sql .= " AND rci.skEstatus = ".escape($this->conc['skEstatus']);
        }

        $sql .= "ORDER BY ce.skEstatus DESC";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function stpCUD_conceptosInventario(){
        $sql = "CALL stpCUD_conceptosInventario (
            " .escape(isset($this->conc['skConcepto']) ? $this->conc['skConcepto'] : NULL) . ",
            " .escape(isset($this->conc['skCotizacion']) ? $this->conc['skCotizacion'] : NULL) . ",
            " .escape(isset($this->conc['skCotizacionConcepto']) ? $this->conc['skCotizacionConcepto'] : NULL) . ",
            " .escape(isset($this->conc['skConceptoInventario']) ? $this->conc['skConceptoInventario'] : NULL) . ",
            " .escape(isset($this->conc['skEstatus']) ? $this->conc['skEstatus'] : NULL) . ",
            " .escape(isset($this->conc['fCantidad']) ? $this->conc['fCantidad'] : NULL). ",
            " .escape(isset($this->conc['sNumeroSerie']) ? $this->conc['sNumeroSerie'] : NULL) . ",

            " .escape(isset($this->conc['axn']) ? $this->conc['axn'] : NULL) . ",
            " .escape($_SESSION['usuario']['skUsuario']). ",
            " .escape($this->sysController)." )";
       
        $this->log($sql, true);
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    } 

    public function _get_informacionProductoServicio(){
        $sql = "SELECT
            ips.skInformacionProductoServicio
            ,ips.skEstatus
            ,ips.sNombre
            ,ips.sDescripcionHoja1
            ,ips.sDescripcionHoja2
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
        WHERE ips.skInformacionProductoServicio = ".escape($this->conc['skInformacionProductoServicio']);
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc($result);
        utf8($records);
        return $records;
    }

    public function stpCUD_informacionProductoServicio(){
        $sql = "CALL stpCUD_informacionProductoServicio (
            " .escape(isset($this->conc['skInformacionProductoServicio']) ? $this->conc['skInformacionProductoServicio'] : NULL) . ",
            " .escape(isset($this->conc['sNombre']) ? $this->conc['sNombre'] : NULL) . ",
            " .escape(isset($this->conc['sDescripcionHoja1']) ? $this->conc['sDescripcionHoja1'] : NULL) . ",
            " .escape(isset($this->conc['sDescripcionHoja2']) ? $this->conc['sDescripcionHoja2'] : NULL) . ",
            " .escape(isset($this->conc['sImagen']) ? $this->conc['sImagen'] : NULL). ",
            " .escape(isset($this->conc['sObservacionesCancelacion']) ? $this->conc['sObservacionesCancelacion'] : NULL) . ",

            " .escape(isset($this->conc['axn']) ? $this->conc['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
       
        //$this->log($sql, true);
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }
   
 
     
    public function stpCUD_conceptos() {

        $sql = "CALL stpCUD_conceptos (
            " .escape(isset($this->conc['skConcepto']) ? $this->conc['skConcepto'] : NULL) . ",
            " .escape(isset($this->conc['skEstatus']) ? $this->conc['skEstatus'] : NULL) . ",
            " .escape(isset($this->conc['sCodigo']) ? $this->conc['sCodigo'] : NULL) . ",
            " .escape(isset($this->conc['sNombre']) ? $this->conc['sNombre'] : NULL). ",
            " .escape(isset($this->conc['iDetalle']) ? $this->conc['iDetalle'] : NULL). ",
            " .escape(isset($this->conc['skClaveSAT']) ? $this->conc['skClaveSAT'] : NULL) . ",
            " .escape(isset($this->conc['skUnidadMedida']) ? $this->conc['skUnidadMedida'] : NULL) . ",
            " .escape(isset($this->conc['iClaveProductoServicio']) ? $this->conc['iClaveProductoServicio'] : NULL) . ",
            " .escape(isset($this->conc['skEmpresaSocioProveedor']) ? $this->conc['skEmpresaSocioProveedor'] : NULL) . ",
            " .escape(isset($this->conc['sDescripcion']) ? $this->conc['sDescripcion'] : NULL) . ",
            " .escape(isset($this->conc['sObservacionesCancelacion']) ? $this->conc['sObservacionesCancelacion'] : NULL) . ",
            " .escape(isset($this->conc['fPrecioCompra']) ? $this->conc['fPrecioCompra'] : NULL) . ",
            " .escape(isset($this->conc['skCategoriaPrecio']) ? $this->conc['skCategoriaPrecio'] : NULL) . ",
            " .escape(isset($this->conc['fPrecioVenta']) ? $this->conc['fPrecioVenta'] : NULL) . ",
            " .escape(isset($this->conc['skImpuestoConcepto']) ? $this->conc['skImpuestoConcepto'] : NULL) . ",
            " .escape(isset($this->conc['fKwh']) ? $this->conc['fKwh'] : NULL) . ",
            " .escape(isset($this->conc['skCategoriaProducto']) ? $this->conc['skCategoriaProducto'] : NULL) . ",
            " .escape(isset($this->conc['fMetros2']) ? $this->conc['fMetros2'] : NULL) . ",
            " .escape(isset($this->conc['axn']) ? $this->conc['axn'] : NULL) . ",
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

    public function _get_conceptos_precios(){
        $sql = "SELECT rcp.*,cs.sNombre AS catalogo, cso.sNombre AS categoriaPrecio 
            FROM rel_conceptos_precios rcp 
            INNER JOIN rel_catalogosSistemasOpciones cso ON cso.skCatalogoSistemaOpciones = rcp.skCategoriaPrecio
            INNER JOIN cat_catalogosSistemas cs ON cs.skCatalogoSistema = cso.skCatalogoSistema
            WHERE cs.skCatalogoSistema = 'CATPRE' AND cso.skEstatus = 'AC' 
            AND rcp.skConcepto = ".escape($this->conc['skConcepto'])." ORDER BY cso.sNombre ASC";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _get_categorias_precios(){
        $sql = "SELECT cso.* FROM cat_catalogosSistemas cs
            INNER JOIN rel_catalogosSistemasOpciones cso ON cso.skCatalogoSistema = cs.skCatalogoSistema 
            WHERE cs.skCatalogoSistema = 'CATPRE' AND cso.skEstatus = 'AC' ORDER BY cso.sNombre ASC";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * _getConcepto
     *
     * Obtener Datos de concepto guardado
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array Datos | False
     */
    public function _getConcepto() {

        $sql = "SELECT cc.skConcepto,
                cc.iFolio,
                cc.sCodigo,
                cc.dFechaCreacion,
                cc.sNombre,
                cc.fPrecioCompra,
                cc.sDescripcion,
                cc.fPrecioVenta,
                cc.skUnidadMedida,
                cc.iClaveProductoServicio,
                cc.skEmpresaSocioProveedor,
                cc.fKwh,
                cc.skCategoriaProducto,
                cc.fCantidad,
                cc.iDetalle,
                cso.sNombre AS categoriaProducto,
                cc.fMetros2,
                ce.sNombre AS estatus,
                ce.sIcono AS estatusIcono,
                ce.sColor AS estatusColor,
                cum.sNombre AS unidadMedida,
                cep.sNombre AS proveedor,
                cep.sRFC AS proveedorRFC,
                cu.sNombre AS usuarioCreacion       
                FROM cat_conceptos cc
                INNER JOIN core_estatus ce ON ce.skEstatus = cc.skEstatus
                INNER JOIN cat_usuarios cu ON cu.skUsuario = cc.skUsuarioCreacion
                LEFT JOIN rel_empresasSocios resp ON resp.skEmpresaSocio = cc.skEmpresaSocioProveedor
                LEFT JOIN cat_empresas cep ON cep.skEmpresa = resp.skEmpresa
                LEFT JOIN cat_unidadesMedidaSAT cum ON cum.skUnidadMedida = cc.skUnidadMedida
                LEFT JOIN rel_catalogosSistemasOpciones cso ON cso.skClave = cc.skCategoriaProducto AND cso.skCatalogoSistema = 'CATPRO'
                WHERE cc.skConcepto =  " . escape($this->conc['skConcepto']);

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
                    where rci.skConcepto = '".$this->conc['skConcepto']."' ";
       
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

        if (isset($this->conc['skEmpresaTipo']) && !empty($this->conc['skEmpresaTipo'])) {
            if (is_array($this->conc['skEmpresaTipo'])) {
                $sql .= " AND es.skEmpresaTipo IN (" . mssql_where_in($this->conc['skEmpresaTipo']) . ") ";
            } else {
                $sql .= " AND es.skEmpresaTipo = " . escape($this->conc['skEmpresaTipo']);
            }
        }

        $sql .= " ) AS N1 ";

        if (isset($this->conc['sNombre']) && !empty(trim($this->conc['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->conc['sNombre']) . "%' ";
        }

        if (isset($this->conc['skEmpresaSocio']) && !empty($this->conc['skEmpresaSocio'])) {
            $sql .= " WHERE N1.id = " . escape($this->conc['skEmpresaSocio']);
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

      

   


}
