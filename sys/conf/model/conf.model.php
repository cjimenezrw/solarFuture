<?php

Class Conf_Model Extends DLOREAN_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    protected $conf = array();
    protected $usuario = array();
    protected $perfil = array();
    protected $msgHist = array();
    protected $servidor = array();
    /** @var array Array para almacenar los token de servicios web de un usuario. */
    protected $usuarios_token = array();
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        //parent::__construct();
    }

    public function __destruct() {

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
      

   


}
