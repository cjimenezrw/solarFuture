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
           
            " .escape(isset($this->vent['axn']) ? $this->vent['axn'] : NULL) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";
      
        //$this->log($sql, true);
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
     * _getCotizacion
     *
     * Obtener Datos de Cotizacion guardada
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return Array Datos | False
     */
    public function _getCotizacion() {

        $sql = "SELECT * FROM ope_cotizaciones oc WHERE  oc.skCotizacion =  " . escape($this->vent['skCotizacion']);


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
        utf8($records);
        return $records;
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

      

   


}
