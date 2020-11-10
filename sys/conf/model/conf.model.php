<?php

Class Conf_Model Extends DLOREAN_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    protected $conf = array();
    protected $usuario = array();
    protected $perfil = array();
    protected $msgHist = array();
    protected $servidor = array();
    protected $variable = array();
    protected $tipovariable = array();
    protected $gruposUsuarios = array();
    protected $gruposNotificaciones = array();
    protected $tipoNotificacion = array();
    protected $notificacionesMensaje = array();
    protected $aplicacion = array();
    protected $mercancias = array();

    /** @var array Array para almacenar los token de servicios web de un usuario. */
    protected $usuarios_token = array();
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        //parent::__construct();
    }

    public function __destruct() {

    }
    protected function accionesCuentaBanco(){


        $sql = "CALL stpCU_cuentasBancos (
            " . escape($this->cuenta['skCuentaBanco']) . ",
            " . escape($this->cuenta['skBanco']) . ",
            " . escape($this->cuenta['sCuenta']) . ",
            /*@sDescripcionCuenta		    = */" . escape($this->cuenta['sDescripcionCuenta']) . ",
            /*@skUsuarioCreacion                = */'" . $_SESSION['usuario']['skUsuario'] . "',
            /*@skModulo                 = */'" . $this->sysController . "')";

        $query = Conn::query($sql);

        if(!$query){
            return false;
        }
        $record = Conn::fetch_assoc($query);
        Conn::free_result($query);
        return $record['skCuentaBanco'];

    }

    protected function accionesTarjetasBanco(){

        $sql = "CALL stpCU_tarjetasBancos (
            /*@skTarjetaBanco		      = */" . escape($this->cuenta['skTarjetaBanco']) . ",
            /*@skBanco			          = */" . escape($this->cuenta['skBanco']) . ",
            /*@sTarjeta			          = */" . escape($this->cuenta['sTarjeta']) . ",
            /*@sDescripcionTarjeta		  = */" . escape($this->cuenta['sDescripcionTarjeta']) . ",
            /*@skUsuarioCreacion          = */'" . $_SESSION['usuario']['skUsuario'] . "',
            /*@skModulo                   = */'" . $this->sysController . "')";

        $query = Conn::query($sql);

        if(!$query){
            return false;
        }
        $record = Conn::fetch_assoc($query);
        Conn::free_result($query);
        return $record['skTarjetaBanco'];

    }

    protected function accionesBancos(){

        $sql = "CALL stpCU_Bancos (
            " . escape($this->banco['skBanco']) . ",
            " . escape($this->banco['sNombre']) . ",
            " . escape($this->banco['sDescripcion']) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "')";

        $query = Conn::query($sql);

        if(!$query){
            return false;
        }
        $record = Conn::fetch_assoc($query);
        Conn::free_result($query);
        return $record['skBanco'];

    }

    public function _getModulosNotas(){
        $sql = "SELECT cmn.*,
            IIF(e.sNombreCorto IS NOT NULL, e.sNombreCorto, e.sNombre) AS empresa,
            CONCAT(udev.sNombre,' ',udev.sApellidoPaterno) AS developer,
            CONCAT(ures.sNombre,' ',ures.sApellidoPaterno) AS responsable,
            CONCAT(u.sNombre,' ',u.sApellidoPaterno) AS usuarioCreacion,
            est.sNombre AS estatus,
            cm.sNombre AS modulo
            FROM core_modulos_notas cmn
            INNER JOIN core_modulos cm ON cm.skModulo = cmn.skModulo
            INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = cmn.skEmpresaSocio
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN cat_usuarios udev ON udev.skUsuario = cmn.skUsuarioDeveloper
            INNER JOIN cat_usuarios ures ON ures.skUsuario = cmn.skUsuarioResponsable
            INNER JOIN cat_usuarios u ON u.skUsuario = cmn.skUsuarioCreacion
            INNER JOIN core_estatus est ON est.skEstatus = cmn.skEstatus
            WHERE 1=1 ";

        if(isset($this->conf['skModuloDetalle']) && !empty($this->conf['skModuloDetalle'])){
            $sql .= " AND cmn.skModuloDetalle = ".escape($this->conf['skModuloDetalle']);
        }

        if(isset($this->conf['skModulo']) && !empty($this->conf['skModulo'])){
            $sql .= " AND cmn.skModulo = ".escape($this->conf['skModulo']);
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
     * Consulta tipo de Notificacion
     *
     * Esta funcion consulta los datos de un tipo de notificacion usando su ID, hace uso de los datos
     * que posea la variable  <b>$tipoNotificacion</b>
     *
     * @author Alfonso Rangel Ramos <arangel@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_tipoNotificacion() {
        $select = "SELECT * FROM cat_NotificacionesTipos WHERE skTipoNotificacion = '" . $this->tipoNotificacion['skTipoNotificacion'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    public function consultar_estatusTipoNotificacion() {
        $select = "SELECT skEstatus,sNombre FROM core_estatus WHERE skEstatus IN ('AC','IN','EL')";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return $result;
    }

    public function acciones_tipoNotificacion() {

        $sql = "EXECUTE stpCUD_tipoNotificacion
            @skTipoNotificacionVieja  = " . $this->tipoNotificacion['skTipoNotificacionVieja'] . ",
            @skTipoNotificacion       = " . $this->tipoNotificacion['skTipoNotificacion'] . ",
            @skEstatus                = " . $this->tipoNotificacion['skEstatus'] . ",
            @sNombre                  = " . $this->tipoNotificacion['sNombre'] . ",
            @sDescripcion             = " . $this->tipoNotificacion['sDescripcion'] . ",
            @skUsuario                = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo                 = '" . $this->sysController . "'";

        $result = Conn::query($sql);

        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Valida codigo tipo notificacion
     *
     * Consulta si un nuevo codigo de tipo de notificacion esta disponible
     *
     * @author Alfonso Rangel <arangel@woodward.com.mx>
     * @param string &skTipoNotificacion Nuevo skVariable a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigo_tipoNotificacion($skTipoNotificacion) {
        $select = "SELECT skTipoNotificacion FROM cat_NotificacionesTipos WHERE skTipoNotificacion = '" . $skTipoNotificacion . "'";
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
     * stpCU_gruposUsuarios
     *
     * Guarda un grupo de usuarios.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function stpCU_gruposUsuarios() {
        $sql = "EXECUTE stpCU_gruposUsuarios
        @skGrupoUsuario             = " . escape($this->gruposUsuarios['skGrupoUsuario']) . ",
        @skUsuarioResponsable       = " . escape($this->gruposUsuarios['skUsuarioResponsable']) . ",
        @skEstatus                  = " . escape($this->gruposUsuarios['skEstatus']) . ",
        @sNombre                    = " . escape($this->gruposUsuarios['sNombre']) . ",
        @sDescripcion               = " . escape($this->gruposUsuarios['sDescripcion']) . ",
        @skUsuario                  = '" . $_SESSION['usuario']['skUsuario'] . "',
        @skModulo                   = '" . $this->sysController . "'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skGrupoUsuario'];
    }

    /**
     * stpC_gruposUsuarios_usuarios
     *
     * Guarda usuarios a un grupo de usuarios.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function stpC_gruposUsuarios_usuarios() {
        $sql = "EXECUTE stpC_gruposUsuarios_usuarios
        @skGrupoUsuario             = " . escape($this->gruposUsuarios['skGrupoUsuario']) . ",
        @skUsuario                  = " . escape($this->gruposUsuarios['skUsuario']) . ",
        @iRecursivo                 = " . escape($this->gruposUsuarios['iRecursivo']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skGrupoUsuario'];
    }

    /**
     * delete_gruposUsuarios_usuarios
     *
     * Elimina los usuarios de un grupo de usuarios
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function delete_gruposUsuarios_usuarios() {
        $sql = "DELETE FROM rel_gruposUsuarios_usuarios WHERE skGrupoUsuario = '" . $this->gruposUsuarios['skGrupoUsuario'] . "'";
        $query = Conn::query($sql);
        if (!$query) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * consultarGruposUsuarios
     *
     * Consulta un grupo de usuario.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultarGruposUsuarios() {
        $sql = "SELECT gu.*,ce.sNombre AS estatus,CONCAT(cu.sNombre,' ',cu.sApellidoPaterno,' ',cu.sApellidoMaterno) AS responsable FROM cat_gruposUsuarios gu
            INNER JOIN core_estatus ce ON ce.skEstatus = gu.skEstatus
            INNER JOIN cat_usuarios cu ON cu.skUsuario = gu.skUsuarioResponsable
            WHERE skGrupoUsuario = '" . $this->gruposUsuarios['skGrupoUsuario'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * consultarGruposUsuarios_usuarios
     *
     * Consulta los usuarios de un grupo de usuario.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultarGruposUsuarios_usuarios() {
        $sql = "SELECT rgu.*,CONCAT(cu.sNombre,' ',cu.sApellidoPaterno,' ',cu.sApellidoMaterno) AS usuario FROM rel_gruposUsuarios_usuarios rgu
            INNER JOIN cat_usuarios cu ON cu.skUsuario = rgu.skUsuario
            WHERE skGrupoUsuario = '" . $this->gruposUsuarios['skGrupoUsuario'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return $result;
    }

    /**
     * getUsuarios
     *
     * Consulta los usuarios activos del sistema.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param    string  $val String referente al nombre ó apellido paterno ó apellido materno.
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function get_usuarios($val = NULL) {
        $sql = "SELECT DISTINCT cu.skUsuario AS id, CONCAT(cu.sNombre,' ',cu.sApellidoPaterno,' ',cu.sApellidoMaterno) AS nombre
        FROM cat_usuarios cu
        INNER JOIN rel_usuarios_perfiles up ON up.skUsuario = cu.skUsuario
        WHERE skEstatus = 'AC' AND (cu.sNombre LIKE '%" . $val . "%' OR  cu.sApellidoPaterno LIKE '%" . $val . "%' OR cu.sApellidoMaterno LIKE '%" . $val . "%')
        AND up.skEmpresaSocio = '".$_SESSION['usuario']['skEmpresaSocioPropietario']."' ";
        $query = Conn::query($sql);
        if (!$query) {
            return FALSE;
        }
        $result = array();
        while ($row = Conn::fetch_assoc($query)) {
            utf8($row);
            array_push($result, $row);
        }
        return $result;
    }

    public function searchAreas($parametro) {

        $selec = "SELECT skArea  AS 'id', sNombre  AS 'nombre' FROM cat_areas WHERE sNombre like '%$parametro%' LIMIT 20";
        $query = Conn::query($selec);

        if (!$query) {

            return false;
        }

        $jsonData = array();
        while ($array = Conn::fetch_assoc($query)) {
            utf8($array);
            $jsonData[] = $array;
        }

        return $jsonData;
    }

    public function getPaises($parametro) {

        // SQL


        $selec = "SELECT id, nombre FROM paises WHERE nombre like '%$parametro%' LIMIT 20";
        $query = Conn::query($selec);


        if (!$query) {

            return false;
        }

        /* $data = array(array(), array());

          while ($result = Conn::fetch_assoc($query)) {
          utf8($result);
          array_push($data[0], $result['nombre']);
          $data[1][$result['nombre']] = $result['id'];
          } */

        $jsonData = array();
        while ($array = Conn::fetch_assoc($query)) {
            $jsonData[] = $array;
        }

        return $jsonData;
    }

    public function acciones_usuarios() {

        $sql = "CALL stpCUD_usuarios (
            " . escape($this->usuario['skUsuario']) . ",
            " . escape($this->usuario['sUsuario']) . ",
            " . escape($this->usuario['skEstatus']) . ",
            " . escape($this->usuario['skArea']) . ",
            " . escape($this->usuario['skDepartamento']) . ",
            " . escape($this->usuario['skGrupo']) . ",
            " . escape($this->usuario['sNombre']) . ",
            " . escape($this->usuario['sApellidoPaterno']) . ",
            " . escape($this->usuario['sApellidoMaterno']) . ",
            " . escape($this->usuario['hash']) . ",
            " . escape($this->usuario['sFoto']) . ",
            " . escape($this->usuario['salt']) . ",
            " . escape($this->usuario['sCorreo']) . ",
            " . escape($this->usuario['sTipoUsuario']) . ",
            " . escape($this->usuario['picDel']) . ",
            " . escape($this->usuario['skRolDigitalizacion']) . ",
            '" . $_SESSION['usuario']['skUsuario'] . "',
            '" . $this->sysController . "' )";

        //$this->log($sql, true);
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skUsuario'];
    }

    public function acciones_usuarios_perfiles() {

        $sql = "CALL stpCU_usuarios_perfiles (
            /*@skUsuario              = */" . escape($this->usuario['skUsuario']) . ",
            /*@skUsuarioPerfil        = */" . escape($this->usuario['skUsuarioPerfil']) . ",
            /*@skPerfil               = */" . escape($this->usuario['skPerfil']) . ",
            /*@skEmpresaSocio         = */" . escape($this->usuario['skEmpresaSocio']) . " ) ";
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skUsuarioPerfil'];
    }


    public function eliminar_usuarios_perfiles($arrayNoEliminar) {
        $sql = "DELETE FROM rel_usuarios_perfiles
              WHERE skUsuario = '" . $this->usuario['skUsuario'] . "' " .
                ($arrayNoEliminar ? " AND skUsuarioPerfil NOT IN(" . $arrayNoEliminar . ") " : "");
        /* $sql="EXECUTE stpD_usuarios_perfiles
          @skUsuario              = '".$this->usuario['skUsuario']."',
          @sCadenaPerfil        = ".$arrayNoEliminar.""; */
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        return true;
    }

    public function consulta_usuario() {
        $select = "SELECT * FROM cat_usuarios WHERE skUsuario = '" . $this->usuario['skUsuario'] . "'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consultar registro de correo electronico
     *
     * Obtiene los datos de un registro de correo electronico.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return array     Retorna array de perfiles asignados al usuario con sus respectivas epmpresas y sucursales.
     */
    public function consulta_mensaje() {
        $select = "SELECT * FROM core_mensajesCorreos WHERE skMensaje = '" . $this->msgHist['skMensaje'] . "'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consultar registro de un area
     *
     * Obtiene los datos de un registro de area.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return object  Retorna objeto de resultados
     */
    public function consulta_area() {
        $select = "SELECT * FROM cat_areas WHERE skArea = '" . $this->area['skArea'] . "'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consultar registro de un departamentos
     *
     * Obtiene los datos de un registro de departamento.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return object  Retorna objeto de resultados
     */
    public function consulta_depa() {
        $select = "SELECT skDepartamento, skEstatus, skArea, sNombre, dFechaCreacion
                    FROM cat_departamentos  WHERE skDepartamento = '" . $this->departamento['skDepartamento'] . "'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * usuario_perfiles
     *
     * Obtiene los perfiles asignados al usuario con sus respectivas epmpresas y sucursales.
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return array     Retorna array de perfiles asignados al usuario con sus respectivas epmpresas y sucursales.
     */
    public function usuario_perfiles() {
        $sql = " SELECT rup.*,p.sNombre AS perfil, e.sNombre AS empresa FROM rel_usuarios_perfiles rup "
                . " INNER JOIN core_perfiles p ON p.skPerfil = rup.skPerfil "
                . " INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = rup.skEmpresaSocio "
                . " INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa "
                . " WHERE rup.skUsuario = '" . $this->usuario['skUsuario'] . "'";
        //$this->log($sql,true);
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $data = array();
        //while ($row = Conn::fetch_assoc($result)) {
        foreach (Conn::fetch_assoc_all($result) as $row) {
            utf8($row);
            array_push($data, $row);
        }
        Conn::free_result($result);
        return $data;
    }

    /**
     * getUsuario_token
     *
     * Busca en Base de datos y obtiene los perfiles asignados al usuario con sus respectivas epmpresas y sucursales relacionados con su token de servicios web.
     *
     * @author           Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param string $skUsuario Identificador del usuario para consultar sus token de servicios web.
     * @return array     Retorna array de perfiles asignados al usuario con sus respectivas epmpresas y sucursales con su token de servicios web.
     */
    public function getUsuario_token($skUsuario = '') {
        $sql = " SELECT rup.*,p.sNombre AS perfil, e.sNombre AS empresa, ut.skToken, u.sNombre, u.sApellidoPaterno, u.sApellidoMaterno, u.sCorreo FROM rel_usuarios_perfiles rup "
                . " INNER JOIN core_perfiles p ON p.skPerfil = rup.skPerfil "
                . " INNER JOIN cat_usuarios u ON u.skUsuario = rup.skUsuario "
                . " INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = rup.skEmpresaSocio "
                . " INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa "
                . " LEFT JOIN rel_usuarios_token ut ON ut.skUsuarioPerfil = rup.skUsuarioPerfil "
                . " WHERE rup.skUsuario = '" . $skUsuario . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $data = array();
        foreach (Conn::fetch_assoc_all($result) as $row) {
            utf8($row);
            $sql = "SELECT ups.*, s.sNombre AS sucursal FROM rel_usuarios_perfiles_sucursales ups "
                    . " INNER JOIN cat_sucursales s ON s.skSucursal = ups.skSucursal "
                    . " WHERE skUsuarioPerfil = '" . $row['skUsuarioPerfil'] . "'";
            $result_sucursales = Conn::query($sql);
            if (!$result_sucursales) {
                return FALSE;
            }
            $sucursales = array();
            while ($sucursal = Conn::fetch_assoc($result_sucursales)) {
                utf8($sucursal);
                array_push($sucursales, $sucursal);
            }
            $row['sucursales'] = $sucursales;
            Conn::free_result($result_sucursales);
            array_push($data, $row);
        }
        Conn::free_result($result);
        return $data;
    }

    /**
     * stpCD_usuarioToken
     *
     * Guarda en Base de datos un token de servicios web.
     *
     * @author           Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return array     Retorna array de perfiles asignados al usuario con sus respectivas epmpresas y sucursales con su token de servicios web.
     */
    public function stpCD_usuarioToken() {
        $sql = "EXECUTE stpCD_usuarioToken
            @skUsuarioPerfil            = " . escape($this->usuarios_token['skUsuarioPerfil']) . ",
            @skUsuarioCreacion          = " . escape($_SESSION['usuario']['skUsuario']) . ",
            @skModulo                   = " . escape($this->sysController) . "";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    public function validar_usuario($sUsuario) {
        $select = "SELECT sUsuario FROM cat_usuarios WHERE sUsuario = '" . $sUsuario . "'";
        $result = Conn::query($select);
        if (!$result) {
            return false;
        }
        if (count($result->fetchall()) > 0) {
            return false;
        }
        return true;
    }

    public function consultar_estatus() {
        $select = "SELECT skEstatus,sNombre FROM core_estatus WHERE skEstatus IN ('AC','IN')";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        //$record = Conn::fetch_assoc($result);
        return $result;
    }

    public function consultar_area() {
        $select = "SELECT skArea,sNombre FROM cat_areas WHERE skEstatus IN ('AC','IN') ORDER BY sNombre ASC";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record  = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function getArea_Departamento(&$skArea) {
        $select = "SELECT skDepartamento, sNombre FROM cat_departamentos WHERE skEstatus IN ('AC','IN') AND skArea = '" . $skArea . "' ORDER BY sNombre ASC";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record  = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function consultarPerfilClonado(&$skPerfilClonar) {
        $select = "EXEC stpPermisosGenerales
            @sModulo = 'prin-inic',
            @iNivel = 0,
            @skPerfil = " . (isset($skPerfilClonar) ? "'" . $skPerfilClonar . "'" : 'NULL') . ",
            @skUsuario = 'NULL'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return $result;
    }

    public function consultar_grupos() {
        $select = "SELECT skGrupo,sNombre FROM cat_gruposEmpresas WHERE skEstatus IN ('AC','IN') ORDER BY sNombre ASC";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_perfiles() {
        $select = "SELECT skPerfil,sNombre FROM core_perfiles WHERE skEstatus IN ('AC','IN')";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);;
    }

    function aut_perfiles($value) {

        $sql = "SELECT  skPerfil AS 'id', sNombre AS 'nombre' FROM core_perfiles WHERE sNombre like '%" . $value . "%' LIMIT 20";

        $query = Conn::query($sql);

        if (!$query) {

            return false;
        }

        $jsonData = array();
        while ($array = Conn::fetch_assoc($query)) {
            $jsonData[] = $array;
        }

        return $jsonData;
    }

    public function acciones_perfiles() {

        $sql = "CALL stpCUD_perfiles (
            /*@skPerfil               = */" . $this->perfil['skPerfil'] . ",
            /*@skEstatus              = */" . $this->perfil['skEstatus'] . ",
            /*@sNombre                = */" . $this->perfil['sNombre'] . ",
            /*@sDescripcionPerfil     = */".escape($this->perfil['sDescripcionPerfil']).",
            /*@skUsuario              = */'" . $_SESSION['usuario']['skUsuario'] . "',
            /*@skModulo               = */'" . $this->sysController . "' )";

        $result = Conn::query($sql);
        if (!$result) {

            return false;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skPerfil'];
    }

    public function crear_permisos($datos) {
        $sql = "INSERT INTO core_modulos_permisos_perfiles (skPerfil, skPermiso,skModulo ) VALUES " . $datos . "";

        //$this->log($sql,true);
        $result = Conn::query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function consulta_Perfil() {
        $select = "SELECT cp.*, ce.sNombre AS sEstatus, cuc.sNombre AS sUsuarioCreador, cum.sNombre AS sUsuarioModificador
        FROM core_perfiles  cp
        INNER JOIN core_estatus ce ON ce.skEstatus = cp.skEstatus
        INNER JOIN cat_usuarios cuc ON cuc.skUsuario = cp.skUsuarioCreador
        LEFT JOIN cat_usuarios cum ON cum.skUsuario = cp.skUsuarioModificador
        WHERE cp.skPerfil = '" . $this->perfil['skPerfil'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    public function consulta_modulos() {
        $select = "CALL stpPermisosGeneralesPermisos (
            /*@sModulo = */'prin-inic',
            /*@iNivel = */0,
            /*@skPerfil = */" . (isset($this->perfil['skPerfil']) ? "'" . $this->perfil['skPerfil'] . "'" : 'NULL') . ",
            /*@skUsuario =*/ NULL )";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consulta_modulos_assoc() {
        $select = "CALL stpPermisosGeneralesPermisos (
            /*@sModulo = */'prin-inic',
            /*@iNivel = */0,
            /*@skPerfil = */" . (isset($this->perfil['skPerfil']) ? "'" . $this->perfil['skPerfil'] . "'" : 'NULL') . ",
            /*@skUsuario =*/ NULL )";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $r = array();
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);
            array_push($r, $row);
        }
        Conn::free_result($result);
        return $r;
    }

    public function consulta_modulos_mobile() {
        $select = "CALL stpPermisosGeneralesPermisos (
            /*@sModulo = */'mpric-inic',
            /*@iNivel = */0,
            /*@skPerfil = */" . (isset($this->perfil['skPerfil']) ? "'" . $this->perfil['skPerfil'] . "'" : 'NULL') . ",
            /*@skUsuario =*/ NULL )";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);;
    }

    public function consulta_modulos_mobile_json() {
        $select = "CALL stpPermisosGeneralesPermisos (
            /*@sModulo = */'mpric-inic',
            /*@iNivel = */0,
            /*@skPerfil = */" . (isset($this->perfil['skPerfil']) ? "'" . $this->perfil['skPerfil'] . "'" : 'NULL') . ",
            /*@skUsuario =*/ NULL )";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $r = array();
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);
            array_push($r, $row);
        }
        Conn::free_result($result);
        return $r;
    }

    public function consultar_usuarioPerfiles() {
        $select = "SELECT cp.*, ce.sNombre AS sEstatus, cuc.sNombre AS sUsuarioCreador, cum.sNombre AS sUsuarioModificador
        FROM core_perfiles  cp
        INNER JOIN core_estatus ce ON ce.skEstatus = cp.skEstatus
        INNER JOIN cat_usuarios cuc ON cuc.skUsuario = cp.skUsuarioCreador
        LEFT JOIN cat_usuarios cum ON cum.skUsuario = cp.skUsuarioModificador
        WHERE cp.skPerfil = '" . $this->perfil['skPerfil'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consulta Servidor
     *
     * Esta funcion consulta los datos de una Servidor usando su ID, hace uso de los datos
     * que posea la variable  <b>$servidor</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_servidor() {
        $select = "SELECT * FROM cat_servidoresVinculados WHERE skServidorVinculado = '" . $this->servidor['skServidorVinculado'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    public function consultar_servidores_soportados(){
        $select = "SELECT * FROM cat_servidores_soportados;";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * Valida codigo
     *
     * Consulta si un nuevo codigo de servidor esta disponible
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $skServidor Nuevo skServidor a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigo_servidor($skServidor) {
        $select = "SELECT skServidorVinculado FROM cat_servidoresVinculados WHERE skServidorVinculado = '" . $skServidor . "'";
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
     * Acciones de Variables del Sistema
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_variablesSitema</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$variable</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_variables() {

        $sql = "EXECUTE stpCUD_variablesSistema
            @skVariableVieja          = " . $this->variable['skVariableVieja'] . ",
            @skVariable               = " . $this->variable['skVariable'] . ",
            @skVariableTipo           = " . $this->variable['skVariableTipo'] . ",
            @skEstatus                = " . $this->variable['skEstatus'] . ",
            @sNombre                  = " . $this->variable['sNombre'] . ",
            @sDescripcion             = " . $this->variable['sDescripcion'] . ",
            @sValor                   = " . $this->variable['sValor'] . ",
            @skUsuario                = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo                 = '" . $this->sysController . "'";
        //$sql="UPDATE cat_sucursales SET skSucursal = 'RAFA' WHERE skSucursal = 'RAFA' ";
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Acciones de Tipos de Variables del Sistema
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_tiposvariablesSistema</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$tipovariable</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_tipovariables() {

        $sql = "EXECUTE stpCUD_tiposvariablesSistema
            @skVariableTipoViejo    = " . escape($this->tipovariable['skVariableTipoViejo']) . ",
            @skVariableTipo         = " . escape($this->tipovariable['skVariableTipo']) . ",
            @skEstatus              = " . escape($this->tipovariable['skEstatus']) . ",
            @sNombre                = " . escape($this->tipovariable['sNombre']) . ",

            @skUsuario              = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo               = '" . $this->sysController . "'";
        //exit('<pre>'.print_r($sql,1).'</pre>');
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Consulta tipo variable
     *
     * Esta funcion consulta los datos de un tipo de variable usando su ID, hace uso de los datos
     * que posea la variable  <b>$tiposvariable</b>
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_tipovariable() {
        $select = "SELECT * FROM core_variablesTipos WHERE skVariableTipo = '" . $this->tipovariable['skVariableTipo'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Valida codigo tipo variable
     *
     * Consulta si un nuevo codigo de tipo de variable esta disponible
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param string $skVariableTipo Nuevo skSucursal a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigoTipoVariable($skVariableTipo) {
        $select = "SELECT skVariableTipo FROM core_variablesTipos WHERE skVariableTipo = '" . $skVariableTipo . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        if (count($result->fetchall()) === 0) {
            return true;
        }
        return false;
    }

    /*
     * Acciones de sucursal
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_sucursales</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$sucursal</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */

    public function acciones_servidores() {

        $sql = "EXECUTE stpCUD_servidoresVinculados
          @skServidorVinculadoViejo = " . $this->servidor['skServidorVinculadoViejo'] . ",
          @skServidorVinculado      = " . $this->servidor['skServidorVinculado'] . ",
          @skEstatus                = " . $this->servidor['skEstatus'] . ",
          @sNombre                  = " . $this->servidor['sNombre'] . ",
          @sVinculacion                  = " . $this->servidor['sVinculacion'] . ",
          @sIP                      = " . $this->servidor['sIP'] . ",
          @sUsuario                 = " . $this->servidor['sUsuario'] . ",
          @sPassword                = " . $this->servidor['sPassword'] . ",
          @sBDA                     = " . $this->servidor['sBDA'] . ",
          @sDSN                     = " . $this->servidor['sDSN'] . ",
          @iPuerto                  = " . $this->servidor['iPuerto'] . ",
          @skUsuario                = '" . $_SESSION['usuario']['skUsuario'] . "',
          @skModulo                 = '" . $this->sysController . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skServidorVinculado'];
    }

    /**
     * Consulta variable
     *
     * Esta funcion consulta los datos de una variable usando su ID, hace uso de los datos
     * que posea la variable  <b>$variable</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consulta_variable() {
        $select = "SELECT * FROM core_variables WHERE skVariable = '" . $this->variable['skVariable'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Valida codigo
     *
     * Consulta si un nuevo codigo de variable esta disponible
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $skVariable Nuevo skVariable a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigo_variable($skVariable) {
        $select = "SELECT skVariable FROM core_variables WHERE skVariable = '" . $skVariable . "'";
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
     * Consulta variable
     *
     * Esta funcion consulta los datos de una variable usando su ID, hace uso de los datos
     * que posea la variable  <b>$variable</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultar_variableTipo() {
        $select = "SELECT * FROM core_variablesTipos";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record =  Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function acciones_area() {
        $sql = "EXECUTE stpCUD_areas
            @skAreaVieja            = " . escape($this->area['skAreaVieja']) . ",
            @skArea                 = " . escape($this->area['skArea']) . ",
            @skEstatus              = " . escape($this->area['skEstatus']) . ",
            @sNombre                = " . escape($this->area['sNombre']) . ",
            @skUsuario              = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo               = '" . $this->sysController . "'";
        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        return true;
    }

    public function validar_codigo($skArea) {
        $select = "SELECT skArea FROM cat_areas WHERE skArea = '" . $skArea . "'";
        $result = Conn::query($select);
        if (!$result) {
            return false;
        }
        if (count($result->fetchall()) > 0) {
            return false;
        }
        return true;
    }

    public function acciones_depa() {
        $sql = "EXECUTE stpCUD_departamentos
            @skDepartamentoViejo    = " . escape($this->departamento['skDepartamentoViejo']) . ",
            @skDepartamento         = " . escape($this->departamento['skDepartamento']) . ",
            @skEstatus              = " . escape($this->departamento['skEstatus']) . ",
            @sNombre                = " . escape($this->departamento['sNombre']) . ",
            @skArea                 = " . escape($this->departamento['skArea']) . ",
            @skUsuario              = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo               = '" . $this->sysController . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    public function validar_codigoD($skDepartamento) {
        $select = "SELECT skDepartamento FROM cat_departamentos WHERE skDepartamento = '" . $skDepartamento . "'";
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
     * getCaracteristicas_usuarios
     *
     * Obtiene todas las características activas disponibles para los usuarios.
     *
     * @author   Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return   mixed Retorna un array de datos.
     */
    public function getCaracteristicas_usuarios() {
        $sql = "SELECT * FROM cat_caracteristicasUsuarios WHERE skEstatus = 'AC'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * getCaracteristicas_skUsuario
     *
     * Obtiene los valores de las características de un usuario.
     *
     * @author   Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param    $skUsuario Identificador del usuario, se pasa por referencia.
     * @return   mixed Retorna un array de datos.
     */
    public function getCaracteristicas_skUsuario(&$skUsuario) {
        $sql = "SELECT * FROM rel_caracteristicasUsuarios_usuarios WHERE skUsuario = '" . $skUsuario . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * getCaracteristica_valoresCatalogo
     *
     * Obtiene los valores del catálogo utlizado para una característica para un usuario.
     *
     * @author   Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param    $sCatalogo Nombre del Catálogo (Tabla en base de datos)
     * @return   mixed Retorna un array de datos.
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
     * stpCD_caracteristica_usuario
     *
     * Guarda las características de un usuario en base de datos.
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param bool $delete Acción para eliminar las caracteristicas anteriores.
     * @return bool Retorna true en caso de exito ó false en caso de error.
     */
    public function stpCD_caracteristica_usuario($delete = FALSE) {
        $sql = "CALL stpCD_caracteristica_usuario ( ";
        if ($delete) {
            $sql .= "
            @skUsuario                  = " . escape($this->usuario['skUsuario']) . ",
            @skCaracteristicaUsuario    = NULL,
            @sValor                     = NULL,
            @axn                        = 'DELETE',
            @skUsuarioCreacion          = NULL,
            @skModulo                   = NULL )";
        } else {
            $sql .= "
                @skUsuario                  = " . escape($this->usuario['skUsuario']) . ",
                @skCaracteristicaUsuario    = " . escape($this->usuario['skCaracteristicaUsuario']) . ",
                @sValor                     = " . escape($this->usuario['sValor']) . ",
                @axn                        = NULL,
                @skUsuarioCreacion          = " . escape($_SESSION['usuario']['skUsuario']) . ",
                @skModulo                   = " . escape($this->sysController) . " )";
        }
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * stpCUD_aplicaciones
     *
     * Guarda las apliaciones en base de datos.
     *
     * @author  Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param bool $delete Acción para eliminar las caracteristicas anteriores.
     * @return bool Retorna true en caso de exito ó false en caso de error.
     */
    public function acciones_aplicacion() {
        $sql = "EXECUTE stpCUD_aplicaciones
            @skAplicacionVieja      = " . escape($this->aplicacion['skAplicacionVieja']) . ",
            @skAplicacion           = " . escape($this->aplicacion['skAplicacion']) . ",
            @skEstatus              = " . escape($this->aplicacion['skEstatus']) . ",
            @sNombre                = " . escape($this->aplicacion['sNombre']) . ",
            @skUsuario              = '" . $_SESSION['usuario']['skUsuario'] . "',
            @skModulo               = '" . $this->sysController . "'";

        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Valida codigo
     *
     * Consulta si un nuevo codigo de Aplicacion esta disponible
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $skAplicacion Nuevo skServidor a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigo_apliacion($skAplicacion) {
        $select = "SELECT skAplicacion FROM core_aplicaciones WHERE skAplicacion = '" . $skAplicacion . "'";
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
     * Consultar registro de un aplicacion
     *
     * Obtiene los datos de un registro de aplicacion.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object  Retorna objeto de resultados
     */
    public function consulta_aplicacion() {
        $select = "SELECT * FROM core_aplicaciones WHERE skAplicacion = '" . $this->aplicacion['skAplicacion'] . "'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Consultar registro de un aplicacion
     *
     * Obtiene los datos de un registro de aplicacion.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object  Retorna objeto de resultados
     */
    public function consulta_aplicacion_detalles() {
        $select = "SELECT ca.*, ce.sNombre AS sEstatus FROM core_aplicaciones ca
                        INNER JOIN core_estatus ce ON ce.skEstatus = ca.skEstatus
                        WHERE ca.skAplicacion = '" . $this->aplicacion['skAplicacion'] . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * Acciones de perfiles Aplicaciones
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpC_perfiles_aplicaciones</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$sucursal</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_perfiles_aplicaciones() {
        $sql = "EXECUTE stpC_perfiles_aplicaciones
           @skAplicacion          = " . escape($this->perfil['skAplicacion']) . ",
           @skPerfil              = " . escape($this->perfil['skPerfil']) . "";
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    public function consulta_perfil_aplicacion() {
        $select = "SELECT * FROM core_aplicaciones_perfiles where skPerfil = '" . $this->perfil['skPerfil'] . "' ";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    /**
     * Consultar registro de un aplicacion
     *
     * Obtiene los datos de un registro de aplicacion.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object  Retorna objeto de resultados
     */
    public function consulta_Aplicaciones_perfiles() {
        $select = "SELECT * FROM core_aplicaciones WHERE skEstatus = 'AC'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }

        $record =  Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    /**
     * Consultar registro de un aplicacion
     *
     * Obtiene los datos de un registro de aplicacion.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object  Retorna objeto de resultados
     */
    public function consulta_aplicaciones_perfiles_detalles() {
        $select = "SELECT cap.*, cp.sNombre  FROM core_aplicaciones_perfiles  cap
        INNER JOIN core_perfiles cp ON cp.skPerfil = cap.skPerfil
        WHERE cap.skAplicacion = '" . $this->aplicacion['skAplicacion'] . "'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }

        return $result;
    }

    /**
     * getUsuarios
     *
     * Consulta los usuarios activos del sistema.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param    string  $val String referente al nombre ó apellido paterno ó apellido materno.
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function get_modulos($val = NULL) {
        $sql = "SELECT skModulo AS id, sTitulo AS nombre FROM core_modulos WHERE skEstatus = 'AC' AND sTitulo LIKE '%" . $val . "%' ";
        $query = Conn::query($sql);
        if (!$query) {
            return FALSE;
        }
        $result = array();
        while ($row = Conn::fetch_assoc($query)) {
            utf8($row);
            array_push($result, $row);
        }
        return $result;
    }

    /**
     * stpCU_notificacionesMensajes
     *
     * Guarda una notifiacion mensaje.
     *
     * @author Luis alberto valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function stpCU_notificacionesMensajes() {
        $sql = "EXECUTE stpCU_notificacionesMensajes
         @skNotificacionMensaje         = " . escape($this->notificacionesMensaje['skNotificacionMensaje']) . ",
         @skTipoNotificacion            = " . escape($this->notificacionesMensaje['skTipoNotificacion']) . ",
         @skComportamientoModulo        = " . escape($this->notificacionesMensaje['skComportamientoModulo']) . ",
         @sObligatorio                  = " . escape($this->notificacionesMensaje['sObligatorio']) . ",
         @skEstatus                     = " . escape($this->notificacionesMensaje['skEstatus']) . ",
         @sNombre                       = " . escape($this->notificacionesMensaje['sNombre']) . ",
         @sMensaje                      = " . escape($this->notificacionesMensaje['sMensaje']) . ",
         @sUrl                          = " . escape($this->notificacionesMensaje['sUrl']) . ",
         @sIcono                        = " . escape($this->notificacionesMensaje['sIcono']) . ",
         @sColor                        = " . escape($this->notificacionesMensaje['sColor']) . ",
         @sImagen                       = " . escape($this->notificacionesMensaje['sImagen']) . ",
         @sClaveNotificacion            = " . escape($this->notificacionesMensaje['sClaveNotificacion']) . ",
         @iNotificacionGeneral          = " . escape($this->notificacionesMensaje['iNotificacionGeneral']) . ",
         @iEnviarCorreo                 = " . escape($this->notificacionesMensaje['iEnviarCorreo']) . ",
         @iEnviarInstantaneo            = " . escape($this->notificacionesMensaje['iEnviarInstantaneo']) . ",
         @sMensajeCorreo                = " . escape($this->notificacionesMensaje['sMensajeCorreo']) . ",
         @iNoAlmacenado                 = " . escape($this->notificacionesMensaje['iNoAlmacenado']) . ",
         @skUsuario                     = '" . $_SESSION['usuario']['skUsuario'] . "',
         @skModuloGuardado              = '" . $this->sysController . "'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skNotificacionMensaje'];
    }

    /**
     * Eliminado LOGICO el punto de tracking (cat_trackingPuntosValores)
     *
     * Elimina LOGICAMENTE los valores del punto de tracking
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string Identificador del punto valor.
     * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.
     */
    public function deleteNotificacionMensajeVariable($skNotificacionMensajeVariable) {

        $sql = "DELETE FROM rel_notificacionesMensajes_variables";

        if ($skNotificacionMensajeVariable) {
            $where_in = mssql_where_in($skNotificacionMensajeVariable);
            if (empty($where_in)) {
                return TRUE;
            }
            $sql .= " WHERE skNotificacionMensajeVariable NOT IN (" . $where_in . ") ";

            $sql .= " AND skNotificacionMensaje = '" . $this->notificacionesMensaje['skNotificacionMensaje'] . "' ";
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * stpC_notificacionesMensajesVariables
     *
     * Guarda o actuzaliza las variables de los mensajes en las notificaciones
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.a
     */
    public function stpC_notificacionesMensajesVariables() {
        $sql = "EXECUTE stpC_notificacionesMensajesVariables
         @skNotificacionMensajeVariable         = " . escape($this->notificacionesMensaje['skNotificacionMensajeVariable']) . ",
         @skNotificacionMensaje                 = " . escape($this->notificacionesMensaje['skNotificacionMensaje']) . ",
         @sValor                                = " . escape($this->notificacionesMensaje['sValor']) . ",
         @sVariable                             = " . escape($this->notificacionesMensaje['sVariable']) . "";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * consultarGruposUsuarios
     *
     * Consulta un grupo de usuario.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultarNotificacionesMensaje() {
        $sql = "SELECT gu.*,ce.sNombre AS estatus
                FROM cat_notificacionesMensajes gu
                INNER JOIN core_estatus ce ON ce.skEstatus = gu.skEstatus
              WHERE skNotificacionMensaje = '" . $this->notificacionesMensaje['skNotificacionMensaje'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /*
     * Consulta todos los valores asignados a un punto de tracking de tipo catálogo.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param    bool    $tablaMultiple Si se pasa TRUE retorna con configuración de tabla múltiple.
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */

    public function variablesMensajes() {
        $sql = "SELECT re.* FROM rel_notificacionesMensajes_variables re WHERE   re.skNotificacionMensaje = '" . $this->notificacionesMensaje['skNotificacionMensaje'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        $data = array();
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);

            $input = '';
            $input .= '<input data-name="' . $row['skNotificacionMensajeVariable'] . '" type="text" name="skNotificacionMensajeVariable[]" value="' . $row['skNotificacionMensajeVariable'] . '" hidden />
                  <input data-name="' . $row['sVariable'] . '" type="text" name="sVariable[]" value="' . $row['sVariable'] . '" hidden />
                  <input data-name="' . $row['sValor'] . '" type="text" name="sValor[]" value="' . $row['sValor'] . '" hidden />';
            array_push($data, array(
                "id" => $row['skNotificacionMensajeVariable'],
                "skNotificacionMensajeVariable" => $row['skNotificacionMensajeVariable'],
                "sVariable" => $row['sVariable'],
                "sValor" => $row['sValor'] . $input
            ));
        }

        Conn::free_result($result);
        return $data;
    }

    public function consultar_aplicacion() {
        $sql = " SELECT
                      ca.skAplicacion,
                      ca.sNombre
                  FROM core_aplicaciones ca
                WHERE ca.skEstatus = 'AC'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return $result;
    }

    public function getAplicacionesMensajes() {
        $kes = $this->notificacionesMensaje['skNotificacionMensaje'];
        $sql = "
              SELECT skAplicacion
                  FROM rel_notificacionesMensajes_aplicaciones WHERE skNotificacionMensaje = '$kes';";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        $jsonData = array();
        while ($array = Conn::fetch_assoc($result)) {
            utf8($array);
            array_push($jsonData, $array['skAplicacion']);
        }
        return $jsonData;
    }

    /**
     * Acciones relacion de Tipos de documentos con Expedientes
     *
     * Esta funcion ejecuta un procedimiento almacenado llamado <b>stpCUD_digitalizacionTiposExpedientes</b>
     * en el que estan definidas las acciones de Create Update Delete, hace uso de los datos
     * que posea la variable  <b>$expediente</b>
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return true | false True cuando todo ha salido correcto o false en caso de error
     */
    public function acciones_notificaciones_aplicaciones() {
        $sql = "EXECUTE stpC_notificacionesMensajes_aplicaciones
            @skNotificacionMensaje          = " . escape($this->notificacionesMensaje['skNotificacionMensaje']) . ",
            @skAplicacion     = " . escape($this->notificacionesMensaje['skAplicacion']) . "";
        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * stpCU_gruposNotificaciones
     *
     * Guarda un grupo de Notificaciones.
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function stpCU_gruposNotificaciones() {
        $sql = "EXECUTE stpCU_gruposNotificaciones
               @skGrupoNotificacion             = " . escape($this->gruposNotificaciones['skGrupoNotificacion']) . ",
               @skEstatus                  = " . escape($this->gruposNotificaciones['skEstatus']) . ",
               @sNombre                    = " . escape($this->gruposNotificaciones['sNombre']) . ",
               @sDescripcion               = " . escape($this->gruposNotificaciones['sDescripcion']) . ",
               @skUsuario                  = '" . $_SESSION['usuario']['skUsuario'] . "',
               @skEmpresaSocioPropietario  = '" . $_SESSION['usuario']['skEmpresaSocioPropietario']. "',
               @skModulo                   = '" . $this->sysController . "'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skGrupoNotificacion'];
    }

    /**
     * stpC_gruposNotificaciones_usuarios
     *
     * Guarda usuarios a un grupo de Notificaciones.
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function stpC_gruposNotificaciones_usuarios() {
        $sql = "EXECUTE stpC_gruposNotificaciones_usuarios
               @skGrupoNotificacion             = " . escape($this->gruposNotificaciones['skGrupoNotificacion']) . ",
               @skUsuario                  = " . escape($this->gruposNotificaciones['skUsuario']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skGrupoNotificacion'];
    }

    /**
     * delete_gruposNotificaciones_usuarios
     *
     * Elimina los usuarios de un grupo de Notificaciones
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function delete_gruposNotificaciones_usuarios() {
        $sql = "DELETE FROM rel_gruposNotificaciones_usuarios WHERE skGrupoNotificacion = '" . $this->gruposNotificaciones['skGrupoNotificacion'] . "'";
        $query = Conn::query($sql);
        if (!$query) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * consultarGruposNotificaciones
     *
     * Consulta un grupo de Notificacion.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultarGruposNotificaciones() {
        $sql = "SELECT gu.*

                    FROM cat_gruposNotificaciones gu
                   INNER JOIN core_estatus ce ON ce.skEstatus = gu.skEstatus
                   WHERE skGrupoNotificacion = '" . $this->gruposNotificaciones['skGrupoNotificacion'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record;
    }

    /**
     * consultarGruposNofiticaciones_usuarios
     *
     * Consulta los usuarios de un grupo de usuario.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultarGruposNotificaciones_usuarios() {
        $sql = "SELECT rgu.*,CONCAT(cu.sNombre,' ',cu.sApellidoPaterno,' ',cu.sApellidoMaterno) AS usuario
                    FROM rel_gruposNotificaciones_usuarios rgu
                   INNER JOIN cat_usuarios cu ON cu.skUsuario = rgu.skUsuario
                   WHERE skGrupoNotificacion = '" . $this->gruposNotificaciones['skGrupoNotificacion'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return $result;
    }

    public function consultar_tiposNotificaciones() {
        $select = "SELECT skTipoNotificacion,sNombre FROM cat_notificacionesTipos WHERE skEstatus ='AC'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        //$record = Conn::fetch_assoc($result);
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_comportamientos() {
        $select = "SELECT skComportamientoModulo,sNombre FROM core_comportamientos_modulos WHERE skEstatus ='AC'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        //$record = Conn::fetch_assoc($result);
        return Conn::fetch_assoc_all($result);
    }

    /**
     * getMensajes
     *
     * Consulta los mensajes de notificacion activos del sistema.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param    string  $val String referente al nombre.
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function get_mensajes($val = NULL) {
        $sql = "SELECT skNotificacionMensaje AS id,  sNombre AS nombre FROM cat_notificacionesMensajes WHERE skEstatus = 'AC' AND sNombre LIKE '%" . $val . "%' ";
        $query = Conn::query($sql);
        if (!$query) {
            return FALSE;
        }
        $result = array();
        while ($row = Conn::fetch_assoc($query)) {
            utf8($row);
            array_push($result, $row);
        }
        return $result;
    }

    /**
     * stpC_gruposNotificaciones_mensajes
     *
     * Guarda mensajes a un grupo de Notificaciones.
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function stpC_gruposNotificaciones_mensajes() {
        $sql = "EXECUTE stpC_gruposNotificaciones_mensajes
                @skGrupoNotificacion             = " . escape($this->gruposNotificaciones['skGrupoNotificacion']) . ",
                @skNotificacionMensaje           = " . escape($this->gruposNotificaciones['skNotificacionMensaje']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['skGrupoNotificacion'];
    }

    /**
     * consultarGruposNofiticaciones_mensajes
     *
     * Consulta los mensajes de un grupo de usuario.
     *
     * @author Luis Alberto Valdez Alvarez <cjimenez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function consultarGruposNotificaciones_mensajes() {
        $sql = "SELECT rgu.*,cu.sNombre AS mensaje
                      FROM rel_gruposNotificaciones_mensajes rgu
                     INNER JOIN cat_notificacionesMensajes cu ON cu.skNotificacionMensaje = rgu.skNotificacionMensaje
                     WHERE skGrupoNotificacion = '" . $this->gruposNotificaciones['skGrupoNotificacion'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return $result;
    }

    /**
     * delete_gruposNotificaciones_mensajes
     *
     * Elimina los usuarios de un grupo de Notificaciones
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
    public function delete_gruposNotificaciones_mensajes() {
        $sql = "DELETE FROM rel_gruposNotificaciones_mensajes WHERE skGrupoNotificacion = '" . $this->gruposNotificaciones['skGrupoNotificacion'] . "'";
        $query = Conn::query($sql);
        if (!$query) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Valida codigo de Notificacione Mensaje
     *
     * Consulta si un nuevo codigo de notificacion Mensaje esta disponible
     *
     * @author Luis Alverto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $skSucursal Nuevo sClaveNotificacion a consultar
     * @return true | false Retorna true si el codigo esta disponible o false si algo falla o no esta disponible
     */
    public function validar_codigoNotificacionMensaje($sClaveNotificacion, $skNotificacionMensaje) {
        $select = "SELECT sClaveNotificacion FROM cat_notificacionesMensajes
                  WHERE sClaveNotificacion = '" . $sClaveNotificacion . "' ";
        if ($skNotificacionMensaje) {
            $select .= " AND  skNotificacionMensaje != '" . $skNotificacionMensaje . "'";
        }

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
     * acciones_catalogoSistema
     *
     * Guarda mensajes a un grupo de Notificaciones.
     *
     * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
     */
     public function acciones_catalogoSistema(){

             $sql="CALL stpCU_catalogosSistemas (
             /*@skCatalogoSistema     = */"  .escape($this->cage['skCatalogoSistema']).",
             /*@skEstatus             = */"  .escape($this->cage['skEstatus']).",
             /*@sNombre               = */"  .escape($this->cage['sNombre']).",
             /*@skUsuarioCreacion     = */'" .$_SESSION['usuario']['skUsuario']."',
             /*@skModulo              = */'" .$this->sysController."' ) ";

             $result = Conn::query($sql);
             if (!$result) {
                 return false;
             }
             $record = Conn::fetch_assoc($result);
             Conn::free_result($result);
             return $record['skCatalogoSistema'];
     }

     /**
      * stpC_catalogoSistemaOpciones
      *
      * Guarda o actuzaliza los valores del punto de Catalogos de Sistemas
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
      * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.a
      */
     public function stpC_catalogoSistemaOpciones() {
         $sql = "CALL stpC_catalogoSistemaOpciones (
         /*@skCatalogoSistemaOpciones     = */" . escape($this->cage['skCatalogoSistemaOpciones']) . ",
         /*@skCatalogoSistema             = */".escape($this->cage['skCatalogoSistema']).",
         /*@skEstatus                     = */'AC',
         /*@sNombre                       = */" . escape($this->cage['sNombreOpcion']) . ",
         /*@sClave                        = */" . escape($this->cage['sClave']) . ",
         /*@skUsuario                     = */'" . $_SESSION['usuario']['skUsuario'] . "',
         /*@skModulo                      = */'" . $this->sysController . "' )";

         $result = Conn::query($sql);
         if (!$result) {
             return FALSE;
         }
         return TRUE;
     }
     
     /**
     * stpC_catalogoSistemaOpciones
     *
     * Guarda o actuzaliza los valores del punto de Catalogos de Sistemas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.a
     */
    public function deleteCatalogoSitemaValores() {
        if(!mssql_where_in($this->cage['skCatalogoSistemaOpciones'])){
            return true;
        }
	$sql = "UPDATE rel_catalogosSistemasOpciones SET skEstatus = 'EL' WHERE skCatalogoSistema = ".escape($this->cage['skCatalogoSistema'])." skCatalogoSistemaOpciones NOT IN (". mssql_where_in($this->cage['skCatalogoSistemaOpciones']).")";
	$result = Conn::query($sql);
	if (!$result) {
	    return FALSE;
	}
	return TRUE;
    }
    
     /**
      * Validacion de Codigo
      *
      * Validacion de Codigos NO REPETIDOS en Catalogos de Sistema
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
      * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.a
      */
     public function cage_query($code,$dataRet = false) {
         $slq = "SELECT * FROM cat_catalogosSistemas WHERE skCatalogoSistema = $code";
         $result = Conn::query($slq);
         if (!$result) {
             return false;
         }

         if($dataRet){
             return Conn::fetch_assoc($result);
         }

         return (count($result->fetchall()) > 0)? false:true;

     }

     /**
      * Consultar valores de catálogo del tipo de ticket(rel_tipoTickets_valores)
      *
      * Consulta todos los valores asignados a un punto de tracking de tipo catálogo.
      *
      * @author Luis Alberto Valdez Alvarez<lvaldez@woodward.com.mx>
      * @param    bool    $tablaMultiple Si se pasa TRUE retorna con configuración de tabla múltiple.
      * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
      */
     public function consultar_opcionesCatalogos($tablaMultiple = FALSE) {
         $sql = "SELECT tpv.* FROM rel_catalogosSistemasOpciones tpv WHERE tpv.skEstatus = 'AC' AND tpv.skCatalogoSistema = '" . $this->cage['skCatalogoSistema'] . "'";

         $result = Conn::query($sql);
         if (!$result) {
             return FALSE;
         }

         $data = array();
         while ($row = Conn::fetch_assoc($result)) {
             utf8($row);

             $input = '';
             if ($tablaMultiple) {
                 $input .= '<input data-name="' . $row['skCatalogoSistemaOpciones'] . '" type="text" name="skCatalogoSistemaOpciones[]" value="' . $row['skCatalogoSistemaOpciones'] . '" hidden /><input data-name="' . $row['sNombre'] . '" type="text" name="sNombreOpcion[]" value="' . $row['sNombre'] . '" hidden /><input data-name="' . $row['sClave'] . '" type="text" name="sClave[]" value="' . $row['sClave'] . '" hidden />';
             }
             array_push($data, array(
                "id" => $row['skCatalogoSistemaOpciones'],
                "skCatalogoSistemaOpciones" => $row['skCatalogoSistemaOpciones'],
                "sNombreOpcion" => $row['sNombre'] . $input,
                "sClave" => $row['sClave']
             ));
         }
         $result->closeCursor();
         return $data;
     }



     /**
      * consultar_cat_mercancias
      *
      * Consulta catalogo de mercancias
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
      * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
      */
     public function consultar_cat_mercancias() {
         $sql = "SELECT cme.* ,ce.sNombre AS estatus
                                     FROM cat_mercancias cme INNER JOIN core_estatus ce ON ce.skEstatus = cme.skEstatus
                    WHERE cme.skMercancia = '" . $this->mercancias['skMercancia'] . "'";
         $result = Conn::query($sql);
         if (!$result) {
             return FALSE;
         }
         $record = Conn::fetch_assoc($result);
         Conn::free_result($result);
         return $record;
     }


     /**
      * stpC_catalogoSistemaOpciones
      *
      * Guarda o actuzaliza los valores del punto de Catalogos de Sistemas
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
      * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.a
      */
     public function acciones_cat_mercancias() {
         $sql = "CALL stpCU_cat_mercancias (
         " . escape($this->mercancias['skMercancia']) . ",
         " . escape($this->mercancias['skEstatus']) . ",
         " . escape($this->mercancias['sNombre']) . ",
         " . escape($this->mercancias['sDescripcion']) . ",
         '" . $_SESSION['usuario']['skUsuario'] . "',
         '" . $this->sysController . "')";

         $result = Conn::query($sql);

         if (!$result) {
             return FALSE;
         }
         $record = Conn::fetch_assoc($result);
         Conn::free_result($result);
         return $record['skMercancia'];
     }


     /**
      * stpC_catalogoSistemaOpciones
      *
      * Guarda o actuzaliza los valores del punto de Catalogos de Sistemas
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
      * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.a
      */
     public function stpCUD_clavesDocumentos() {
         $sql = "CALL stpCUD_clavesDocumentos (
         " . escape($this->docu['skClaveDocumento']) . ",
         " . escape($this->docu['skEstatus']) . ",
         " . escape($this->docu['sClave']) . ",
         " . escape($this->docu['sNombre']) . ",
         '" . $_SESSION['usuario']['skUsuario'] . "',
         '" . $this->sysController . "')";

         $result = Conn::query($sql);

         if (!$result) {
             return FALSE;
         }
         $record = Conn::fetch_assoc($result);
         Conn::free_result($result);
         return $record['skClaveDocumento'];
     }

     /**
      * consultar_cat_mercancias
      *
      * Consulta catalogo de mercancias
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
      * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
      */
     public function consultar_claveDocumento() {
         $sql = "SELECT cme.* ,ce.sNombre AS estatus
                                     FROM cat_clavesDocumentos cme
                                     INNER JOIN core_estatus ce ON ce.skEstatus = cme.skEstatus
                    WHERE cme.skClaveDocumento = '" . $this->docu['skClaveDocumento'] . "'";
         $result = Conn::query($sql);
         if (!$result) {
             return FALSE;
         }
         $record = Conn::fetch_assoc($result);
         Conn::free_result($result);
         return $record;
     }
     /**
      * stpC_catalogoSistemaOpciones
      *
      * Guarda o actuzaliza los valores del punto de Catalogos de Sistemas
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
      * @return bool Retorna TRUE en caso de exito ó FALSE si algo falla.a
      */
     public function stpCUD_rechazosRevalidacion() {
         $sql = "CALL stpCUD_rechazosRevalidacion (
         " . escape($this->rech['skRechazoRevalidacion']) . ",
         " . escape($this->rech['skEstatus']) . ",
         " . escape($this->rech['sNombre']) . ",
         '" . $_SESSION['usuario']['skUsuario'] . "',
         '" . $this->sysController . "')";

         $result = Conn::query($sql);

         if (!$result) {
             return FALSE;
         }
         $record = Conn::fetch_assoc($result);
         Conn::free_result($result);
         return $record['skRechazoRevalidacion'];
     }

     /**
      * consultar_cat_mercancias
      *
      * Consulta catalogo de mercancias
      *
      * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
      * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
      */
     public function consultar_rechazoRevalidacion() {
         $sql = "SELECT cme.* ,ce.sNombre AS estatus
                                     FROM cat_rechazosRevalidacion cme
                                     INNER JOIN core_estatus ce ON ce.skEstatus = cme.skEstatus
                    WHERE cme.skRechazoRevalidacion = '" . $this->rech['skRechazoRevalidacion'] . "'";
         $result = Conn::query($sql);
         if (!$result) {
             return FALSE;
         }
         $record = Conn::fetch_assoc($result);
         Conn::free_result($result);
         return $record;
     }



}
