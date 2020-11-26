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
 
    public function stp_prospectos(){
        $sql = "CALL stp_prospectos (
            ".escape(isset($this->prospectos['skProspecto']) ? $this->prospectos['skProspecto'] : NULL).",
            ".escape(isset($this->prospectos['sNombreContacto']) ? $this->prospectos['sNombreContacto'] : NULL).",
            ".escape(isset($this->prospectos['sEmpresa']) ? $this->prospectos['sEmpresa'] : NULL).",
            ".escape(isset($this->prospectos['sCorreo']) ? $this->prospectos['sCorreo'] : NULL).",
            ".escape(isset($this->prospectos['sTelefono']) ? $this->prospectos['sTelefono'] : NULL).",
            ".escape(isset($this->prospectos['sComentarios']) ? $this->prospectos['sComentarios'] : NULL).",
            ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']).",

            ".escape(isset($this->prospectos['axn']) ? $this->prospectos['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController)."
        )";
        
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

    public function _get_prospecto($params){
        $sql = "SELECT      
             pros.skProspecto
            ,pros.skEmpresaSocioPropietario
            ,pros.skEstatus
            ,pros.iFolioProspecto
            ,pros.sNombreContacto
            ,pros.sEmpresa
            ,pros.sCorreo
            ,pros.sTelefono
            ,pros.sComentarios
            ,pros.skUsuarioCreacion
            ,pros.dFechaCreacion
            ,pros.skUsuarioModificacion
            ,pros.dFechaModificacion
            ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno) AS usuarioCreacion
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            FROM cat_prospectos pros
            INNER JOIN core_estatus est ON est.skEstatus = pros.skEstatus
            INNER JOIN cat_usuarios ucre ON ucre.skUsuario = pros.skUsuarioCreacion
            WHERE pros.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario'])."
            AND pros.skProspecto = ".escape($params['skProspecto']);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

}