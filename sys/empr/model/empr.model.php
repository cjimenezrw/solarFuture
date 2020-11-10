<?php

/**
 * Modelo de modulo de empresas
 *
 * Este es el modelo de modulo emp, osea empresas
 *
 * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
 */
Class Empr_Model Extends DLOREAN_Model {

    // PUBLIC VARIABLES //
    /** @var array Contiene array de datos */
    public $empr = array();
    // PROTECTED VARIABLES //
    protected $solEm = array();
    protected $servem = array();
    // PRIVATE VARIABLES //
    private $data = array();

    /** @var array Contiene los datos que se requieran de sucursales para el CUD */
    protected $sucursal = array();

    /** @var array Contiene los datos que se requieran de grupos para el CUD */
    protected $grupo = array();

    /** @var array Contiene los datos que se requieran de los tipos de empresa para el CUD */
    protected $tiposEmpr = array();

    /** @var array Contiene los datos que se requieran de los tipos de empresa para el CUD */
    protected $correo = array();

    /** @var array Contiene los datos que se requieran de empresas socios para el CUD */
    protected $empresaSocio = array();

    public function __construct() {
        //parent::__construct();
    }

    public function __destruct() {

    }

    /**
     * get_almacenajesClientesRecintos
     *
     * Consulta las configuraciones de días de almacenajes de cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function get_almacenajesClientesRecintos(){
        $sql = "SELECT acr.*, e1.sNombre AS cliente, e1.sNombreCorto AS clienteCorto, e2.sNombre AS recinto, e2.sNombreCorto AS recintoCorto, est.sNombre AS estatus
            FROM cat_diasAlmacenajesClientes_recintos acr
            INNER JOIN rel_empresasSocios es1 ON es1.skEmpresaSocio = acr.skEmpresaSocioCliente
            INNER JOIN cat_empresas e1 ON e1.skEmpresa = es1.skEmpresa
            INNER JOIN rel_empresasSocios es2 ON es2.skEmpresaSocio = acr.skEmpresaSocioRecinto
            INNER JOIN cat_empresas e2 ON e2.skEmpresa = es2.skEmpresa
            INNER JOIN core_estatus est ON est.skEstatus = acr.skEstatus
            WHERE es1.skEstatus = 'AC' AND es2.skEstatus = 'AC' ";

        if(!empty($this->empr['skEmpresaSocioCliente'])) {
            $sql .= " AND acr.skEmpresaSocioCliente = ". escape($this->empr['skEmpresaSocioCliente']);
        }

        if(!empty($this->empr['skEstatus'])) {
            $sql .= " AND acr.skEstatus = ". escape($this->empr['skEstatus']);
        }

        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * Acciones de sucursal
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_sucursales</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$sucursal</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_sucursal() {
        $sql = "EXECUTE stpCUD_sucursales
            @skSucursalVieja        = " . escape($this->sucursal['skSucursalVieja']) . ",
            @skSucursal             = " . escape($this->sucursal['skSucursal']) . ",
            @skEstatus              = " . escape($this->sucursal['skEstatus']) . ",
            @skAduana               = " . escape($this->sucursal['skAduana']) . ",
            @skEmpresaSocioAgente   = " . escape($this->sucursal['skEmpresaSocioAgente']) . ",
            @sNombre                = " . escape($this->sucursal['sNombre']) . ",
            @sNombreCorto           = " . escape($this->sucursal['sNombreCorto']) . ",
            @skUsuario              = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo               = '" . $this->sysController . "'";

        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skSucursal'];
    }

    /**
     * Acciones de sucursal
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_sucursales</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$sucursal</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_sucursal_servidor() {
        $sql = "EXECUTE stpC_sucursal_servidor
            @skSucursal             = " . escape($this->sucursal['skSucursal']) . ",
            @skServidorVinculado    = " . escape($this->sucursal['skServidorVinculado']) . "";
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Acciones de grupos
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_grupos</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$grupo</b>
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_grupo() {

        Conn::begin('stpCUD_grupos');

        $sql = "EXECUTE stpCUD_grupos
            @skGrupo                = " . escape($this->grupo['skGrupo']) . ",
            @skEstatus              = " . escape($this->grupo['skEstatus']) . ",
            @sNombre                = " . escape($this->grupo['sNombre']) . ",
            @skUsuarioCreador       = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo               = '" . $this->sysController . "'";

        $result = Conn::query($sql);
        if (!$result) {
            parent::rollback('stpCUD_grupos');
            return false;
        }
        $row = Conn::fetch_assoc($result);
        $idGrupoProcesado = $row['skGrupo'];

        if (is_string($idGrupoProcesado) && strlen($idGrupoProcesado) === 36 && isset($this->grupo['skEmpresaSocio']) && is_array($this->grupo['skEmpresaSocio'])) {

            if (!Conn::query("DELETE FROM  rel_gruposEmpresas WHERE skGrupo='$idGrupoProcesado';")) {
                Conn::rollback('stpCUD_grupos');
                return false;
            }

            foreach ($this->grupo['skEmpresaSocio'] as $value) {
                if (!Conn::query("INSERT INTO rel_gruposEmpresas
                    (skGrupo, skSocioEmpresa) VALUES('$idGrupoProcesado', '$value');")) {
                    Conn::rollback('stpCUD_grupos');
                    return false;
                }
            }
        }

        parent::commit('stpCUD_grupos');
        return true;
    }

    /**
     * Acciones de tipos de empresas
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_tiposEmpresas</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$grupo</b>
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_tiposEmpresas() {

        $sql = "CALL stpCUD_tiposEmpresas (
            " . escape($this->tiposEmpr['skEmpresaTipoViejo']) . ",
            " . escape($this->tiposEmpr['skEmpresaTipo']) . ",
            " . escape($this->tiposEmpr['skEstatus']) . ",
            " . escape($this->tiposEmpr['sNombre']) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "')";

        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Consulta sucursal
     *
     * Esta funcion consulta los datos de una sucursal usando su ID, hace uso de los datos
     * que posea la variable  <b>$sucursal</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_sucursal() {
        $select = "SELECT * FROM cat_sucursales WHERE skSucursal = '" . $this->sucursal['skSucursal'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consulta grupos
     *
     * Obtiene los datos de un grupo basado en su ID,  hace uso de los datos
     * que posea la variable  <b>$grupo</b>
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_grupo() {
        $select = "SELECT * FROM cat_gruposEmpresas WHERE skGrupo = '" . $this->grupo['skGrupo'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consulta tipos de empresa
     *
     * Obtiene los datos de un grupo basado en su ID,  hace uso de los datos
     * que posea la variable  <b>$grupo</b>
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_tipoEmpr() {
        $select = "SELECT * FROM cat_empresasTipos WHERE skEmpresaTipo = '" . $this->tiposEmpr['skEmpresaTipo'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consulta sucursales
     *
     * Esta funcion obtiene los datos de todas las sucursale que posean el skEstatus AC.
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultar_sucursales() {
        $select = "SELECT * FROM cat_sucursales WHERE skEstatus = 'AC'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * Valida codigo
     *
     * Consulta si un nuevo codigo de sucursal esta disponible
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $skSucursal Nuevo skSucursal a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigo($skSucursal) {
        $select = "SELECT skSucursal FROM cat_sucursales WHERE skSucursal = '" . $skSucursal . "'";
        $result = Conn::query($select);
        if (!$result) {
            return false;
        }
        if (count($result->fetchall()) > 0) {
            return false;
        }
        return true;
    }

    public function consultar_empresasGrupo($tablaMultiple = TRUE) {
        $sql = "
            SELECT
                    rge.skSocioEmpresa,
                    ce.sNombre
            FROM
                    rel_gruposEmpresas rge
            INNER JOIN rel_empresasSocios res ON
                    (
                            res.skEmpresaSocio  = rge.skSocioEmpresa
                    )
            INNER JOIN cat_empresas ce ON
                    (
                            ce.skEmpresa = res.skEmpresa
                    )
            WHERE rge.skGrupo = '" . $this->grupo['skGrupo'] . "';";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $data = array();
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);

            $input = '<input data-name="' . $row['sNombre'] . '" type="text" name="skEmpresaSocio[]" value="' . $row['skSocioEmpresa'] . '" hidden />';

            if (!$tablaMultiple) {
                $input = '';
            }

            array_push($data, array(
                "id" => $row['skSocioEmpresa'],
                "empresa" => $row['sNombre'] . $input
            ));
        }

        Conn::free_result($result);
        return json_encode($data);
    }

    /**
     * Valida codigo de Tipo de empresa
     *
     * Consulta si un nuevo codigo de tipo de empresa esta disponible
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $skSucursal Nuevo skSucursal a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigoTipoEmpresa($skEmpresaTipo) {
        $select = "SELECT skEmpresaTipo FROM cat_empresasTipos WHERE skEmpresaTipo = '" . $skEmpresaTipo . "'";
        $result = Conn::query($select);
        if (!$result) {
            return false;
        }
        if (count($result->fetchall()) > 0) {
            return false;
        }
        return true;
    }

    /**
     * Autocompletado de empresas
     *
     * Retorna un array con los datos de una busuqueda de empresas para usarla en
     * un autocompletado.
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $value Nombre de la sucursal a buscar
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function aut_empresas($value) {

        $selec = "SELECT  es.skEmpresaSocio AS 'id', CONCAT(e.sNombre ,' (', ce.sNombre,')' ) AS 'nombre' FROM rel_empresasSocios es "
                . " INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
               INNER JOIN cat_empresasTipos ce ON ce.skEmpresaTipo = es.skEmpresaTipo WHERE 1=1 ";

        if ($_SESSION['usuario']['tipoUsuario'] === 'U') {
            $selec .= " AND es.skEmpresaSocioPropietario = '" . $_SESSION['usuario']['skEmpresaSocioPropietario'] . "' ";
        }

        $selec .= " AND e.sNombre like '%" . $value . "%'  LIMIT 20 ";
        $query = Conn::query($selec);

        if (!$query) {

            return false;
        }

        $jsonData = array();
        while ($array = Conn::fetch_assoc($query)) {
            $jsonData[] = $array;
        }

        return $jsonData;
    }

    /**
     * Consulta estatus
     *
     * Consulta informacion de los estatus AC e IC
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultar_estatus() {
        $select = "SELECT skEstatus,sNombre FROM core_estatus WHERE skEstatus IN ('AC','IN')";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc_all($result);
        return $record;
    }

    /**
     * Consulta estatus
     *
     * Consulta informacion de los estatus AC e IC
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultar_aduanas() {
        $select = "SELECT skAduana,sNombreCorto FROM integradora.dbo.cat_aduanas WHERE iVisibleSucursal = 1";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        //$record = Conn::fetch_assoc($result);
        return Conn::fetch_assoc_all($result);
    }

    /**
     * Consulta estatus
     *
     * Consulta informacion de los estatus AC e IC
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultar_agentes() {
        $select = "SELECT res.skEmpresaSocio,sNombreCorto, rce.sValor AS Patente
            FROM rel_empresasSocios res
            INNER JOIN rel_caracteristica_empresaSocio rce ON rce.skEmpresaSocio = res.skEmpresaSocio AND rce.skCaracteristicaEmpresaSocio = 'PATENT'
            INNER JOIN cat_empresas ce ON ce.sKempresa = res.skEmpresa
            WHERE res.skEmpresaTipo = 'AEAD'
            ";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        //$record = Conn::fetch_assoc($result);
        return Conn::fetch_assoc_all($result);
    }

    /**
     * stpCU_diasAlmacenajeClienteRecinto
     *
     * Guarda / Actualiza La configuración de días libres de almacenajes por cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function stpCU_diasAlmacenajeClienteRecinto(){
        $sql = "EXECUTE stpCU_diasAlmacenajeClienteRecinto
            @skDiaAlmacenaje                = " . escape($this->empr['skDiaAlmacenaje']) . ",
            @skEstatus                      = " . escape($this->empr['skEstatus']) . ",
            @skEmpresaSocioPropietario      = " . escape($_SESSION['usuario']['skEmpresaSocioPropietario']) . ",
            @skEmpresaSocioCliente          = " . escape($this->empr['skEmpresaSocioCliente']) . ",
            @skEmpresaSocioRecinto          = " . escape($this->empr['skEmpresaSocioRecinto']) . ",
            @iDiasAlmacenajes               = " . escape($this->empr['iDiasAlmacenajes']) . ",

            @skUsuario                      = " . escape($_SESSION['usuario']['skUsuario']) . ",
            @skModulo                       = " . escape($this->sysController);

        $result = Conn::query($sql);

        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }

    /**
     * delete_diasAlmacenajeClienteRecinto
     *
     * Elimina la configuración de días libres de almacenajes por cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function delete_diasAlmacenajeClienteRecinto(){

        if(!$this->empr['skDiaAlmacenaje']){
            return TRUE;
        }

        $skDiaAlmacenaje = mssql_where_in($this->empr['skDiaAlmacenaje']);

        if(!$skDiaAlmacenaje){
            return TRUE;
        }

        $sql = "UPDATE cat_diasAlmacenajesClientes_recintos SET skEstatus = 'EL' WHERE skEstatus != 'EL' AND skDiaAlmacenaje NOT IN (".mssql_where_in($this->empr['skDiaAlmacenaje']).")";

        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }

        return TRUE;
    }

    /**
     * get_empresas
     *
     * Consulta empresas
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function get_empresas(){

        $sql = "SELECT N1.* FROM (
            SELECT
            es.skEmpresaSocio AS id, IIF(e.sNombreCorto IS NOT NULL, e.sNombreCorto, e.sNombre) AS nombre, es.skEmpresaTipo
            FROM rel_empresasSocios es
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            WHERE es.skEstatus = 'AC' AND es.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

        if(!empty($this->empr['skEmpresaTipo'])){
            if(is_array($this->empr['skEmpresaTipo'])){
                $sql .= " AND es.skEmpresaTipo IN (".mssql_where_in($this->empr['skEmpresaTipo']).") ";
            }else{
                $sql .= " AND es.skEmpresaTipo = ". escape($this->empr['skEmpresaTipo']);
            }
        }

        $sql .= " ) AS N1 ";

        if(!empty($this->empr['sNombre'])){
            $sql .= " WHERE N1.nombre COLLATE Latin1_General_CI_AI LIKE '%".$this->empr['sNombre']."%' ";
        }

        if (!empty($this->empr['skEmpresaSocio'])) {
            $sql .= " WHERE N1.id = " . escape($this->empr['skEmpresaSocio']);
        }
        $sql .= " ORDER BY N1.nombre ASC ";

        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * getEmpresaByRFC
     *
     * Obtiene la empresa por RFC
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param string $sRFC RFC de la empresa a buscar
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function getEmpresaByRFC($sRFC = '') {
        $sql = "SELECT * FROM cat_empresas WHERE sRFC = '" . $sRFC . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * getEmpresaSocioByRFC
     *
     * Obtiene la empresa socio por RFC
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param string $sRFC RFC del empresaSocio a buscar
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function getEmpresaSocioByRFC($sRFC = '') {
        $sql = "SELECT * FROM rel_empresasSocios es "
                . " INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa "
                . " WHERE es.skEmpresaSocioPropietario = '" . $_SESSION['usuario']['skEmpresaSocioPropietario'] . "' AND e.sRFC = '" . $sRFC . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * validar_empresaSocio
     *
     * Obtiene la empresa socio por RFC y skEmpresaSocioPropietario.
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param string $sRFC RFC del empresaSocio a buscar
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function validar_empresaSocio($sRFC = NULL, $skEmpresaTipo = NULL) {
        $sql = "SELECT e.*,es.skEmpresaSocio,es.skEmpresaSocioPropietario,es.skEmpresaTipo  FROM cat_empresas e
            LEFT JOIN rel_empresasSocios es ON es.skEmpresa = e.skEmpresa AND es.skEmpresaSocioPropietario = '" . $_SESSION['usuario']['skEmpresaSocioPropietario'] . "'";
        if (!is_null($skEmpresaTipo)) {
            $sql .= " AND es.skEmpresaTipo = '" . $skEmpresaTipo . "'";
        }
        $sql .= " WHERE e.sRFC = '" . $sRFC . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * consultar_empresaSocio
     *
     * Obtiene la empresa socio por skEmpresaSocio.
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param string $skEmpresaSocio identificador de la empresa socio.
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function consultar_empresaSocio($skEmpresaSocio) {
        $sql = "SELECT * FROM rel_empresasSocios es "
                . " INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa "
                . " WHERE es.skEmpresaSocio = '" . $skEmpresaSocio . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * getEmpresasTipos
     *
     * Obtiene los tipos de empresas activos.
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function getEmpresasTipos() {
        $sql = "SELECT * FROM cat_empresasTipos WHERE skEstatus = 'AC' ORDER BY sNombre ASC";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function getCorresponsales() {
        $sql = "SELECT ce.*,re.skEmpresaSocio FROM cat_empresas ce
 INNER JOIN rel_empresasSocios re ON re.skEmpresa = ce.skEmpresa
 WHERE re.skEmpresaTipo IN ('CORR') ORDER BY ce.sNombre ASC ";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }
    public function getPromotores() {
        $sql = "SELECT ce.* ,re.skEmpresaSocio FROM cat_empresas ce
 INNER JOIN rel_empresasSocios re ON re.skEmpresa = ce.skEmpresa
 WHERE re.skEmpresaTipo IN ('PROM') ORDER BY ce.sNombre ASC ";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * getPaises
     *
     * Obtiene los paises.
     *
     * @author Jonathan Topete Figueroa <jtopete@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function getPaises() {
        $sql = "SELECT * FROM cat_paises";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }




    /**
     * getEmpresasSociosDatos
     *
     * Obtiene los datos de las empresas.
     *
     * @author Jonathan Topete Figueroa <jtopete@woodward.com.mx>
     * @param string $skEmpresaSocio identificador de la empresa socio.
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function getEmpresasSociosDatos($skEmpresaSocio) {
        $sql = "SELECT * FROM rel_empresasSocios_datos WHERE skEmpresaSocio = '" . $skEmpresaSocio . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * stpCUD_empresaSocio
     *
     * Crea o Edita una empresa socio en base de datos.
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return boolean Retorna un objeto de resultado mssql en caso de exito ó false en caso de error.
     */
    public function stpCUD_empresaSocio() {
        $sql = "CALL stpCUD_empresaSocio (
            /*@skEmpresaSocio             = */" . escape($this->empresaSocio['skEmpresaSocio']) . ",
            /*@skEmpresa                  = */" . escape($this->empresaSocio['skEmpresa']) . ",
            /*@skEmpresaSocioSugerido     = */ NULL,
            /*@skEmpresaSocioPropietario  = */" . escape($_SESSION['usuario']['skEmpresaSocioPropietario']) . ",
            /*@skEmpresaTipo              = */" . escape($this->empresaSocio['skEmpresaTipo']) . ",
            /*@sRFC                       = */" . escape($this->empresaSocio['sRFC']) . ",
            /*@sNombre                    = */" . escape($this->empresaSocio['sNombre']) . ",
            /*@sNombreCorto               = */" . escape($this->empresaSocio['sNombreCorto']) . ",
            /*@skEstatus                  = */" . escape($this->empresaSocio['skEstatus']) . ",
            /*@skUsuarioCreacion          = */" . escape($_SESSION['usuario']['skUsuario']) . ",
            /*@skModulo                   = */" . escape($this->sysController) . ")";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * stpCUD_empresasSociosDatos
     *
     * Crea o Edita los datos de una empresa socio en base de datos.
     *
     * @author Jonathan Topete Figueroa <jtopete@woodward.com.mx>
     * @return boolean Retorna un objeto de resultado mssql en caso de éxito ó false en caso de error.
     */
    public function stpCUD_empresasSociosDatos() {
        $sql = "CALL stpCUD_empresasSociosDatos (
            /*@skDatosEmpreasSocios       = */" . escape($this->empresaSocio['skDatosEmpreasSocios']) . ",
            /*@skEmpresaSocio             = */" . escape($this->empresaSocio['skEmpresaSocio']) . ",
            /*@skEmpresaSocioCorresponsal             = */" . escape($this->empresaSocio['skEmpresaSocioCorresponsal']) . ",
            /*@skEmpresaSocioPromotor1             = */" . escape($this->empresaSocio['skEmpresaSocioPromotor1']) . ",
            /*@skEmpresaSocioPromotor2             = */" . escape($this->empresaSocio['skEmpresaSocioPromotor2']) . ",
            /*@sObservaciones             = */" . escape($this->empresaSocio['sObservaciones']) . ",
            /*@skUsuarioCreacion          = */" . escape($_SESSION['usuario']['skUsuario']) . ",
            /*@skModulo                   = */" . escape($this->sysController) . " )";


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }

    /**
     * stpCD_caracteristica_empesaSocio
     *
     * Guarda las características de empresa socio en base de datos.
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param bool $delete Acción para eliminar las caracteristicas anteriores.
     * @return bool Retorna true en caso de exito ó false en caso de error.
     */
    public function stpCD_caracteristica_empesaSocio($delete = FALSE) {
        $sql = "CALL stpCD_caracteristica_empresaSocio ( ";
        if ($delete) {
            $sql .= "
            /*@skEmpresaSocio                 = */" . escape($this->empresaSocio['skEmpresaSocio']) . ",
            /*@skCaracteristicaEmpresaSocio   = */ NULL,
            /*@sValor                         = */ NULL,
            /*@axn                            = */' DELETE',
            /*@skUsuarioCreacion              = */ NULL,
            /*@skModulo                       = */ NULL )";
        } else {
            $sql .= "
                /*@skEmpresaSocio                 = */ " . escape($this->empresaSocio['skEmpresaSocio']) . ",
                /*@skCaracteristicaEmpresaSocio   = */ " . escape($this->empresaSocio['skCaracteristicaEmpresaSocio']) . ",
                /*@sValor                         = */ " . escape($this->empresaSocio['sValor']) . ",
                /*@axn                            = */ NULL,
                /*@skUsuarioCreacion              = */ " . escape($_SESSION['usuario']['skUsuario']) . ",
                /*@skModulo                       = */ " . escape($this->sysController) . " ) ";
        }
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * getCaracteristica_empesaTipo
     *
     * Obtiene todas las características activas disponibles según el tipo de empresa.
     *
     * @author   Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param    $skEmpresaTipo Tipo de empresa a la cual aplican las características, se pasa por referencia.
     * @return   mixed Retorna un objeto mssql de datos.
     */
    public function getCaracteristica_empesaTipo(&$skEmpresaTipo) {
        $sql = "SELECT c.* FROM rel_caracteristica_empresaTipo cet
        INNER JOIN cat_caracteristicasEmpresaSocio c ON c.skCaracteristicaEmpresaSocio = cet.skCaracteristicaEmpresaSocio
        WHERE c.skEstatus = 'AC' AND cet.skEmpresaTipo = '" . $skEmpresaTipo . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * getCaracteristica_skEmpresaSocio
     *
     * Obtiene los valores de las características de una empresa socio.
     *
     * @author   Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param    $skEmpresaSocio Empresa socio, se pasa por referencia.
     * @return   mixed Retorna un objeto mssql de datos.
     */
    public function getCaracteristica_skEmpresaSocio(&$skEmpresaSocio) {
        $sql = "SELECT * FROM rel_caracteristica_empresaSocio WHERE skEmpresaSocio = '" . $skEmpresaSocio . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * getCaracteristica_valoresCatalogo
     *
     * Obtiene los valores del catálogo utlizado para una característica para una empresa socio.
     *
     * @author   Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param    $sCatalogo Nombre del Catálogo (Tabla en base de datos)
     * @return   mixed Retorna un objeto mssql de datos.
     */
    public function getCaracteristica_valoresCatalogo(&$sCatalogo, &$sCatalogoKey, &$sCatalogoNombre) {
        $sql = "SELECT * FROM " . $sCatalogo;
        $where = " WHERE skEstatus = 'AC' ";
        if (isset($_POST['criterio'])) {
            $where .= " AND " . $sCatalogoNombre . " like " . escape('%' . $_POST['criterio'] . '%');
        }
        $sql .= $where;
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * Consulta servidores para las sucursales de empresas
     *
     * Consulta informacion de los estatus AC e IC
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultar_servidores() {
        $select = "SELECT skServidorVinculado,sNombre FROM cat_servidoresVinculados WHERE skEstatus = 'AC'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consulta_sucursal_servidor() {
        $select = "SELECT * FROM rel_sucursales_servidoresVinculados where skSucursal = '" . $this->sucursal['skSucursal'] . "' ";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_solicitudEmpresa($skSolicitudEmpresa){
        $s = Conn::query("SELECT * FROM ope_solicitudesEmpresas WHERE skSolicitudEmpresa = $skSolicitudEmpresa");
        if(!$s){
            return false;
        }
        return Conn::fetch_assoc($s);
    }

    public function acciones_solicitudEmpresa() {
        $d = $this->solEm;
        $result = Conn::query("EXECUTE stpCU_solicitudesEmpresas
            @skSolicitudEmpresa 	= $d[skSolicitudEmpresa],
            @skEmpresaPropietario 	= $d[skEmpresaPropietario],
            @skEmpresa                  = $d[skEmpresa],
            @skEmpresaTipo		= $d[skEmpresaTipo],
            @sRazonSocial 		= $d[sRazonSocial],
            @sAlias 			= $d[sAlias],
            @sRFC 			= $d[sRFC],
            @skUsuarioCreacion		= $d[skUsuarioCreacion],
            @skModulo			= $d[skModulo]");
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result)['skSolicitudEmpresa'];
    }

    protected function eliminar_solicitudEmpresa($sk){
        $tid = '8xb989';

        Conn::begin($tid);

        $u = Conn::query("UPDATE ope_solicitudesEmpresas SET skEstatus='EL' WHERE skSolicitudEmpresa = $sk");

        if(!$u){
            Conn::rollback($tid);
            return false;
        }

        Conn::commit($tid);
        return true;
    }

    protected function rechazar_solicitudEmpresa($sk){
        $tid = '8xb9c65';

        Conn::begin($tid);

        $u = Conn::query("UPDATE ope_solicitudesEmpresas
                SET skEstatus='RZ' WHERE skSolicitudEmpresa = $sk");

        if(!$u){
            Conn::rollback($tid);
            return false;
        }

        Conn::commit($tid);
        return true;
    }

    protected function aprobar_solicitudEmpresa($sk){
        $tid = 'l0x33d5';

        Conn::begin($tid);

        $d = $this->data_solicitudEmpresa($sk);

        $i = Conn::query("EXECUTE stpCUD_empresaSocio
        @skEmpresaSocio	= NULL,
        @skEmpresaSocioSugerido         	= $sk,
    	@skEmpresa				= $d[skEmpresa],
    	@skEmpresaSocioPropietario		= $d[skEP],
    	@skEmpresaTipo				= $d[skEmpresaTipo],
    	@sRFC					= $d[sRFC],
    	@sNombre      				= $d[sRazonSocial],
    	@sNombreCorto   			= $d[sAlias],
    	@skEstatus				= 'AC',
    	@skUsuarioCreacion			= $d[skUsr],
    	@skModulo				= $d[skMod]");

        if(!$i){
            Conn::rollback($tid);
            return false;
        }
        $this->log(Conn::fetch_assoc($i), true);

        $u = Conn::query("UPDATE ope_solicitudesEmpresas
                SET skEstatus='AP' WHERE skSolicitudEmpresa = $sk");
        if(!$u){
            Conn::rollback($tid);
            return false;
        }

        Conn::commit($tid);
        return true;


    }

    private function data_solicitudEmpresa($sk){
        $s = Conn::query("SELECT * FROM ope_solicitudesEmpresas WHERE skSolicitudEmpresa = $sk;");
        if(!$s){
            return false;
        }
        $d = Conn::fetch_assoc($s);
        $d['skEP']          = escape($_SESSION['usuario']['skEmpresaSocioPropietario']);
        $d['skUsr']         = escape($_SESSION['usuario']['skUsuario']);
        $d['skMod']         = escape($this->sysController);
        $d['skEmpresa']     = escape($d['skEmpresa']);
        $d['sAlias']        = escape($d['sAlias']);
        $d['sRazonSocial']  = escape($d['sRazonSocial']);
        $d['sRFC']          = escape($d['sRFC']);
        $d['skEmpresaTipo'] = escape($d['skEmpresaTipo']);
        return $d;
    }

    public function consultar_servicio($skServicio){
        $s = Conn::query("SELECT * FROM cat_servicios WHERE skServicio = $skServicio");
        if(!$s){
            return false;
        }
        return Conn::fetch_assoc($s);
    }

    public function consultar_servicioTipoEmpresa($skServicio){
        $s = Conn::query("SELECT  skEmpresaTipo
            FROM  rel_serviciosTiposEmpresas WHERE skServicio = $skServicio");
        if(!$s){
            return false;
        }

        $r = [];

        foreach (Conn::fetch_assoc_all($s) as $value) {
            array_push($r, $value['skEmpresaTipo']);
        }

        return $r;
    }

    public function acciones_servicios() {
        $d = $this->servem;
        $tid = "servem";
        Conn::begin($tid);

        $result = Conn::query("
        EXECUTE stpCU_cat_servicios
            @skServicio 		= $d[skServicio],
            @sDescripcion		= $d[sDescripcion],
            @sNombre			= $d[sNombre],
            @skUsuarioCreacion		= $d[skUsuarioCreacion],
            @skModulo			= $d[skModulo]");
        if (!$result) {
            Conn::rollback($tid);
            return FALSE;
        }
        $id = Conn::fetch_assoc($result)['skServicio'];

        if (!$this->setServiciosEmpresasTipos(escape($id)) ){
            Conn::rollback($tid);
            return false;
        }
        Conn::commit($tid);

        return $id;
    }

    private function setServiciosEmpresasTipos($skServicio){

        Conn::query("DELETE FROM rel_serviciosTiposEmpresas WHERE skServicio = $skServicio;");

        $skt = $this->servem['skEmpresaTipo'];

        if(!is_array($skt) || count($skt) === 0 ){
            return true;
        }

        foreach ($skt as $value) {
            $v = escape($value);
            $i = Conn::query("
                INSERT INTO  rel_serviciosTiposEmpresas
                    (skServicioTipoEmpresa, skEmpresaTipo, skServicio)
                VALUES((newid()), $v , $skServicio);");
            if(!$i){
                return false;
            }
        }
        return true;
    }

    public function aut_servicios($value,$skes) {

        $query = Conn::query("
            SELECT
                    cs.skServicio as id,
                    cs.sNombre as nombre
            FROM
                    cat_servicios cs
            WHERE
            cs.sNombre LIKE '%$value%'
            AND cs.skServicio IN(
                SELECT
                        skServicio
                FROM
                        rel_serviciosTiposEmpresas
                WHERE
                        skEmpresaTipo = ( SELECT skEmpresaTipo FROM rel_empresasSocios WHERE skEmpresaSocio = $skes)
            )
            AND cs.skEstatus = 'AC'; ");

        if (!$query) {
            return false;
        }

        $jsonData = array();
        while ($array = Conn::fetch_assoc($query)) {
            $jsonData[] = $array;
        }

        return $jsonData;
    }

    public function acciones_serviciosEmpresa(){
        $tid = 'leserv';
        $sk  =  escape(( isset($_GET['p1']) ) ? $_GET['p1'] : NULL);
        $srv = (isset($_POST['skServicio']) ) ? $_POST['skServicio'] : false;



        if(strlen($sk) < 36){
            return false;
        }

        Conn::begin($tid);

        $d = Conn::query("DELETE FROM  rel_servicios_EmpresasSocios WHERE skEmpresaSocio = $sk;");

        if(!$d){
            Conn::rollback($tid);
            return false;
        }

        if(!is_array($srv)){
            Conn::commit($tid);
            return true;
        }

        foreach ($srv as $value) {

            $v = escape($value);

            $i = Conn::query("INSERT INTO rel_servicios_EmpresasSocios (skServicioEmpresasSocios, skEmpresaSocio, skServicio)
                        VALUES((newid()),$sk, $v);");

            if (!$i){
                Conn::rollback($tid);
                return false;
            }

        }

        Conn::commit($tid);
        return true;

    }

    public function consultar_serviciosEmpresa($sk){
        $s = Conn::query("
            SELECT
                rses.skServicio,
                cs.sNombre
            FROM
                rel_servicios_EmpresasSocios rses
            INNER JOIN cat_servicios cs ON
                cs.skServicio = rses.skServicio
            WHERE
                rses.skEmpresaSocio = $sk");

        if(!$s){
            return false;
        }

        return Conn::fetch_assoc_all($s);
    }

    public function consultar_documentos() {
        $select = "SELECT dtp.*, cdn.sNombre FROM rel_digitalizacionTiposDocumentos_tiposExpedientes dtp
        INNER JOIN cat_digitalizacionTiposDocumentos cdn ON cdn.skTipoDocumento = dtp.skTipoDocumento
         WHERE DTP.skTipoExpediente = 'EMPR'";
        $result = Conn::query($select);

        if (!$result) {
            return FALSE;
        }
        return $result;
    }

    public function stpCU_confTiposDocEmpr(){
        $sql = "EXECUTE stpCU_confTiposDocEmpr
            @skTipoDocumento    = ".escape($this->cd['skTipoDocumento']).",
            @iObligatorio       = ".escape($this->cd['iObligatorio']).",
            @skEmpresaTipo      = ".escape($this->cd['skEmpresaTipo']).",
            @skDocumentoConfig  = ".escape($this->cd['skDocumentoConfig']).",
            @iFechaExpiracion   = ".escape($this->cd['iFechaExpiracion']).",
            @iMultiple          = ".escape($this->cd['iMultiple']).",
            @skUsuario          = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo           = " . escape($this->sysController) . ",
            @iOriginal          = ".escape($this->cd['iOriginal']);
        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }

    public function getConfigDocsEmpr(){
        $sql = "SELECT cc.*,cd.sNombre FROM rel_come_confTiposDocEmpr cc
            INNER JOIN cat_digitalizacionTiposDocumentos cd ON cd.skTipoDocumento = cc.skTipoDocumento
            WHERE cc.skEmpresaTipo = ".escape($this->cd['skEmpresaTipo'])." ORDER BY cd.sNombre ";
        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function sltInfo($skID){
        $s = Conn::query("
        SELECT
            cet.sNombre as TipoEmpresa,
            c_e.sNombre as sEstatus,
            ose.sRazonSocial,
            ose.sRFC,
            ose.sAlias,
            ose.dFechaCreacion,
            CONCAT( c_u.sNombre, ' ', c_u.sApellidoPaterno, ' ', c_u.sApellidoMaterno ) as Creador

        FROM
            ope_solicitudesEmpresas ose
        INNER JOIN cat_empresasTipos cet ON
            cet.skEmpresaTipo = ose.skEmpresaTipo
        INNER JOIN cat_usuarios c_u ON
            c_u.skUsuario = ose.skUsuarioCreacion
        LEFT JOIN core_estatus c_e ON
            c_e.skEstatus = ose.skEstatus
        WHERE ose.skSolicitudEmpresa = $skID");

        return [
            'success' => ( !(is_bool($s)) ),
            'data' => ( (!is_bool($s)) ? Conn::fetch_assoc($s) : []  )
            ];
    }


    /**
     * get_configuracionCorreosEmpresas
     *
     * Obtiene la configuración de correos de empresas
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function get_configuracionCorreosEmpresas() {
        $sql = "SELECT lc.skConfiguracionCorreo, et.skEmpresaTipo, et.sNombre AS tipoEmpresa, es.skEmpresaSocio, es.skEstatus, est.sNombre AS estatus, e.sRFC, IIF(e.sNombreCorto IS NOT NULL, e.sNombreCorto, e.sNombre) AS cliente, lc.sCorreo
            FROM cat_configuracionCorreos lc
            INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = lc.skEmpresaSocio
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN core_estatus est ON est.skEstatus = es.skEstatus
            INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo
            WHERE lc.skTipoProceso = 'REAC' AND lc.skEmpresaSocio = " . escape($this->correo['skEmpresaSocio']);

        $result = Conn::query($sql);

        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    /**
     * deleteConfCorreosEmpresas
     *
     * Elimina la configuración de correos de empresas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return bool Retorna True | False
     */
    public function deleteConfCorreosEmpresas() {
        $sql = "DELETE FROM cat_configuracionCorreos WHERE skTipoProceso = 'REAC' AND skEmpresaSocio = " . escape($this->correo['skEmpresaSocio']);
        $result = Conn::query($sql);

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * stpCU_confCorreosEmpresas
     *
     * Configuración de correos de Empresas
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function stpCU_confCorreosEmpresas() {
        $sql = "EXECUTE stpCU_confCorreos
            @skEmpresaSocio           = " . escape($this->correo['skEmpresaSocio']) . ",
            @sCorreo                  = " . escape($this->correo['sCorreo']) . ",
            @skTipoProceso            = " . escape($this->correo['skTipoProceso']) . ",
            @skUsuario                = " . escape($_SESSION['usuario']['skUsuario']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }

    /**
     * Acciones de tipos de empresas
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_tiposEmpresas</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$grupo</b>
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function stpCUD_promotores() {

        $sql = "CALL stpCUD_promotores (
            " . escape($this->prom['skPromotor']) . ",
            " . escape($this->prom['skEstatus']) . ",
            " . escape($this->prom['sNombre']) . ",
            " . escape($this->prom['sCorreo']) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "')";


        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return Conn::fetch_assoc($result);
    }
    /**
     * Consulta tipos de empresa
     *
     * Obtiene los datos de un grupo basado en su ID,  hace uso de los datos
     * que posea la variable  <b>$grupo</b>
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_promotor() {
        $select = "SELECT * FROM cat_promotores WHERE skPromotor = '" . $this->prom['skPromotor'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

}
