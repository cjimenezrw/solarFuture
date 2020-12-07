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
            array_push($data, $row);
        }
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
             return $record['skCatalogoSistema'];
     }

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
     * stpCUD_variablesSistema
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return Bool TRUE | FALSE
     */
    public function stpCUD_variablesSistema(){
        $sql = "CALL stpCUD_variablesSistema (
               /*@skVariableVieja          =*/ ".escape(isset($this->conf['skVariableVieja']) ? $this->conf['skVariableVieja'] : NULL).",
               /*@skVariable               =*/ ".escape(isset($this->conf['skVariable']) ? $this->conf['skVariable'] : NULL).",
               /*@skVariableTipo           =*/ ".escape(isset($this->conf['skVariableTipo']) ? $this->conf['skVariableTipo'] : NULL).",
               /*@skEstatus                =*/ ".escape(isset($this->conf['skEstatus']) ? $this->conf['skEstatus'] : NULL).",
               /*@sNombre                  =*/ ".escape(isset($this->conf['sNombre']) ? $this->conf['sNombre'] : NULL).",
               /*@sDescripcion             =*/ ".escape(isset($this->conf['sDescripcion']) ? $this->conf['sDescripcion'] : NULL).",
               /*@sValor                   =*/ ".escape(isset($this->conf['sValor']) ? $this->conf['sValor'] : NULL).",
               /*@sProyecto                =*/ ".escape(isset($this->conf['sProyecto']) ? $this->conf['sProyecto'] : NULL).",
               /*@skModuloVariable         =*/ ".escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL).",

               /*@axn                      =*/ ".escape(isset($this->conf['axn']) ? $this->conf['axn'] : NULL).",
               /*@skUsuario                =*/ ".escape($_SESSION['usuario']['skUsuario']).",
               /*@skModulo                 =*/ ".escape($this->sysController).")";

       $result = Conn::query($sql);
       if(is_array($result) && isset($result['success']) && $result['success'] == false){
           return $result;
       }
       $record = Conn::fetch_assoc($result);
       utf8($record);
       return $record;
    }

    public function consultar_variableTipo(){
        $sql = "SELECT * FROM core_variablesTipos";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record,true);
        return $record;
    }

    public function consulta_variable(){
        $sql = "SELECT 
             cv.*
            ,CONCAT(uc.sNombre,' ',uc.sApellidoPaterno) AS usuarioCreacion
            ,CONCAT(um.sNombre,' ',um.sApellidoPaterno) AS usuarioModificacion
            ,ce.sNombre AS estatus
            ,ce.sIcono AS estatusicono
            ,cvt.sNombre AS tipovariable
            FROM core_variables  cv
            LEFT JOIN core_estatus ce on ce.skEstatus =  cv.skEstatus
            LEFT JOIN cat_usuarios uc ON uc.skUsuario =  cv.skUsuarioCreacion
            LEFT JOIN cat_usuarios um ON um.skUsuario =  cv.skUsuarioModificacion
            LEFT JOIN core_variablesTipos cvt ON cvt.skVariableTipo = cv.skVariableTipo
            WHERE cv.skVariable = ".escape($this->conf['skVariable']);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

    public function _variablesSistema_consultar_modulos(){
        $sql = "SELECT 
             cm.*
            ,CONCAT(uc.sNombre,' ',uc.sApellidoPaterno) AS usuarioCreacion
            ,CONCAT(um.sNombre,' ',um.sApellidoPaterno) AS usuarioModificacion
            ,CONCAT(cm.sTitulo,' (',cm.skModulo,')') AS modulo
            ,ce.sNombre AS estatus
            ,ce.sIcono AS estatusicono
            ,cmi.sIcono
            ,cmi.sColor
            FROM core_modulos cm
            LEFT JOIN core_estatus ce on ce.skEstatus = cm.skEstatus
            LEFT JOIN cat_usuarios uc ON uc.skUsuario =  cm.skUsuarioCreacion
            LEFT JOIN cat_usuarios um ON um.skUsuario =  cm.skUsuarioCreacion
            LEFT JOIN core_modulos_iconos cmi ON cmi.skModulo = cm.skModulo
            LEFT JOIN rel_core_variables_modulos cvm ON cvm.skModulo = cm.skModulo 
            WHERE cm.skEstatus = 'AC'";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function consulta_variable_proyecto(){
        $sql = "SELECT sProyecto
            FROM rel_core_variables_proyectos
            WHERE skVariable = " . escape(isset($this->conf['skVariable']) ? $this->conf['skVariable'] : NULL);
       
       $result = Conn::query($sql);
       if(is_array($result) && isset($result['success']) && $result['success'] == false){
           return $result;
       }
       $record = Conn::fetch_assoc_all($result);
       utf8($record);
       return $record;
    }

    public function consulta_variable_modulos(){
        $sql = "SELECT 
            cvm.skModulo,
            CONCAT(cm.sTitulo,' (',cvm.skModulo,')') AS modulo
            FROM rel_core_variables_modulos cvm
            LEFT JOIN core_modulos cm ON cm.skModulo = cvm.skModulo
            WHERE skVariable =  ". escape(isset($this->conf['skVariable']) ? $this->conf['skVariable'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function validar_codigo_variable($skVariable){
        $sql = "SELECT skVariable FROM core_variables WHERE skVariable = '" . $skVariable . "'";
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        if (count($records) > 0) {
            return false;
        }
        return true;
    }
    
    public function _getModulosVariables() {
        $sql = "SELECT N1.* FROM (
            SELECT cm.skmodulo AS id
            ,CONCAT(cm.sTitulo,' (',cm.skModulo,')') AS nombre
            FROM core_modulos cm 
        ) AS N1 WHERE 1 = 1 ";

        if (isset($this->rehu['val']) && !empty($this->rehu['val']) && trim($this->rehu['val']) != '') {
            $sql .= " AND N1.nombre COLLATE Latin1_General_CI_AI LIKE '%" . escape($this->rehu['val'], FALSE) . "%' ";
        }
        
        $sql .= " ORDER BY N1.nombre ASC";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _consulta_botones(){
        $sql = "SELECT * from core_botones";


        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _getCaracteristicasModulo(){
        $sql = "SELECT
            sNombre,
            skCaracteristicaModulo,
            skCaracteristicaModulo AS id,
            CONCAT(sNombre,' (',skCaracteristicaModulo,')') AS nombre
            FROM core_caracteristicasModulos";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function _consultar_modulos_caracteristicas(){
        $sql = "SELECT cmc.*,
            ccm.sNombre AS caracteristica,
            ccm.skCaracteristicaModulo AS id,
            CONCAT(ccm.sNombre,' (',ccm.skCaracteristicaModulo,')') AS nombre
            FROM core_modulos_caracteristicas cmc
            LEFT JOIN core_caracteristicasModulos ccm ON ccm.skCaracteristicaModulo = cmc.skCaracteristicaModulo
            WHERE cmc.skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);


        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _consultar_comportamientos(){
        $sql = "SELECT
            CONCAT(sNombre,' (',skComportamientoModulo,')') AS comportamiento,
            skComportamientoModulo AS id
            FROM core_comportamientos_modulos";


        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _validar_modulo(){
        $sql = "SELECT cm.*
            FROM  core_modulos cm
            WHERE cm.skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);

        if (isset($_GET['p1']) && !empty(trim($_GET['p1']))) {
            $sql .= " AND cm.skModulo != " . escape($_GET['p1']);
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }

        return (count($result->fetchall()) > 0) ? false : true;
    }

    public function stpCUD_coreModulos(){
        $sql = "CALL stpCUD_coreModulos (
             /*@skModuloAlta          =*/ ".escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL).",
             /*@skModuloPrincipal     =*/ ".escape(isset($this->conf['skModuloPrincipal']) ? $this->conf['skModuloPrincipal'] : NULL).",
             /*@skModuloPadre         =*/ ".escape(isset($this->conf['skModuloPadre']) ? $this->conf['skModuloPadre'] : NULL).",
             /*@sNombre               =*/ ".escape(isset($this->conf['sNombre']) ? $this->conf['sNombre'] : NULL).",
             /*@sTitulo               =*/ ".escape(isset($this->conf['sTitulo']) ? $this->conf['sTitulo'] : NULL).",
             /*@iPosicion             =*/ ".escape(isset($this->conf['iPosicion']) ? $this->conf['iPosicion'] : NULL).",
             /*@sDescripcion          =*/ ".escape(isset($this->conf['sDescripcion']) ? $this->conf['sDescripcion'] : NULL).",
             /*@skPermiso             =*/ ".escape(isset($this->conf['skPermiso']) ? $this->conf['skPermiso'] : NULL).",
             /*@sColor                =*/ ".escape(isset($this->conf['sColor']) ? $this->conf['sColor'] : NULL).",
             /*@skMenu                =*/ ".escape(isset($this->conf['skMenu']) ? $this->conf['skMenu'] : NULL).",

             /*@skBoton               =*/ ".escape(isset($this->conf['skBoton']) ? $this->conf['skBoton'] : NULL).",
             /*@sFuncion              =*/ ".escape(isset($this->conf['sFuncion']) ? $this->conf['sFuncion'] : NULL).",
             /*@sIcono                =*/ ".escape(isset($this->conf['sIcono']) ? $this->conf['sIcono'] : NULL) . ",
             /*@skComportamiento      =*/ ".escape(isset($this->conf['skComportamiento']) ? $this->conf['skComportamiento'] : NULL).",

             /*@skCaracteristicaModulo      =*/ " . escape(isset($this->conf['skCaracteristicaModulo']) ? $this->conf['skCaracteristicaModulo'] : NULL).",


             /*@axn                   =*/ " . escape(isset($this->conf['axn']) ? $this->conf['axn'] : NULL).",
             /*@skUsuario             =*/ " . escape($_SESSION['usuario']['skUsuario']).",
             /*@skModulo              =*/ " . escape($this->sysController).")";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }

        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

    public function _consultar_modulo_permisos(){
        $sql = "SELECT cmp.*,
            per.sNombre AS permiso
            FROM core_modulos_permisos cmp
            LEFT JOIN core_permisos per ON per.skPermiso = cmp.skPermiso
            WHERE cmp.skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _consultar_modulosMenu(){
        $sql = "SELECT DISTINCT
            skMenu AS id
            FROM core_modulos_menus
            WHERE skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);;

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _consultar_modulos(){
        $sql = "SELECT cm.*
            ,CONCAT(uc.sNombre,' ',uc.sApellidoPaterno) AS usuarioCreacion
            ,CONCAT(um.sNombre,' ',um.sApellidoPaterno) AS usuarioModificacion
            ,ce.sNombre AS estatus
            ,ce.sIcono AS estatusicono
            ,cmi.sIcono
            ,cmi.sColor
            FROM core_modulos cm
            LEFT JOIN core_estatus ce on ce.skEstatus = cm.skEstatus
            LEFT JOIN cat_usuarios uc ON uc.skUsuario =  cm.skUsuarioCreacion
            LEFT JOIN cat_usuarios um ON um.skUsuario =  cm.skUsuarioCreacion
            LEFT JOIN core_modulos_iconos cmi ON cmi.skModulo = cm.skModulo
            WHERE cm.skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

    public function _consultar_modulos_botones(){
        $sql = "SELECT cmb.*,
            cb.sNombre AS boton
            FROM core_modulos_botones  cmb
            LEFT JOIN core_botones cb ON  cb.skBoton = cmb.skBoton
            WHERE cmb.skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _consultar_modulos_menuEmergentes(){
        $sql = "SELECT *
            FROM core_modulos_menusEmergentes
            WHERE skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function _consultar_modulos_perfiles(){
        $sql = "SELECT cmpp.*,
                cper.sNombre AS nombrePerfil,
                cper.dFechaCreacion,
                cper.sDescripcionPerfil AS descripcionPerfil,
                cper.skEstatus AS estatusPerfil,
                per.skPermiso AS permiso,
                per.sNombre AS nombrePermiso,
                ce.sNombre AS estatusPerfil,
                ce.sIcono AS estatusicono,
                ce.sNombre AS estatus
                FROM core_modulos_permisos_perfiles cmpp
                LEFT JOIN core_perfiles cper ON cper.skPerfil = cmpp.skPerfil
                LEFT JOIN core_permisos per ON per.skPermiso = cmpp.skPermiso
                LEFT JOIN core_estatus ce on ce.skEstatus = per.skEstatus
                WHERE cmpp.skModulo = " . escape(isset($this->conf['skModulo']) ? $this->conf['skModulo'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function cage_query($code, $dataRet = false){
        $slq = "SELECT * FROM cat_catalogosSistemas WHERE skCatalogoSistema = $code";
        $result = Conn::query($slq);
        if (!$result) {
            return false;
        }

        if ($dataRet) {
            return Conn::fetch_assoc($result);
        }

        return (count($result->fetchall()) > 0) ? false : true;
    }

    public function consultar_opcionesCatalogo(){
        $sql = "SELECT rcso.*,
            CONCAT(u.sNombre,' ',u.sApellidoPaterno) AS usuarioCreacion,
            CONCAT(u2.sNombre,' ',u2.sApellidoPaterno) AS usuarioModificacion,
            ce.sNombre as estatus
            FROM cat_catalogosSistemas ccs
            LEFT JOIN rel_catalogosSistemasOpciones rcso ON rcso.skCatalogoSistema = ccs.skCatalogoSistema
            LEFT JOIN cat_usuarios u ON u.skUsuario =  rcso.skUsuarioCreacion
            LEFT JOIN cat_usuarios u2 ON u2.skUsuario =  rcso.skUsuarioModificacion
            LEFT JOIN core_estatus ce ON ce.skEstatus = rcso.skEstatus
            WHERE  rcso.skEstatus = 'AC' AND ccs.skCatalogoSistema = " . escape(isset($this->conf['skCatalogoSistema']) ? $this->conf['skCatalogoSistema'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record);
        return $record;
    }

    public function consultar_opcionesCatalogos($tablaMultiple = FALSE){
        $sql = "SELECT tpv.* FROM rel_catalogosSistemasOpciones tpv
        WHERE tpv.skEstatus = 'AC' AND tpv.skCatalogoSistema = " . escape(isset($this->conf['skCatalogoSistema']) ? $this->conf['skCatalogoSistema'] : NULL);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }

        $data = array();
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);

            $input = '';
            if ($tablaMultiple) {
                $input .= '<input data-name="' . $row['skCatalogoSistemaOpciones'] . '" type="text" name="skCatalogoSistemaOpciones[]" value="' . $row['skCatalogoSistemaOpciones'] . '"  hidden/>';
                $input .= '<input data-name="' . $row['sNombre'] . '" type="text" name="sNombreOpcion[]" value="' . $row['sNombre'] . '" hidden />';
                $input .= '<input data-name="' . $row['skClave'] . '" type="text" name="skClave[]" value="' . $row['skClave'] . '" maxlength="6" hidden />';
            }
            array_push($data, array(
                "id" => $row['skCatalogoSistemaOpciones'],
                "skCatalogoSistemaOpciones" => $row['skCatalogoSistemaOpciones'],
                "sNombreOpcion" => $row['sNombre'] . $input,
                "skClave" => $row['skClave']
            ));
        }
        return $data;
    }

    public function stpCU_catalogosSistemas(){
        $sql = "CALL stpCU_catalogosSistemas (
            /*@skCatalogoSistema     =*/ ".escape(isset($this->conf['skCatalogoSistema']) ? $this->conf['skCatalogoSistema'] : NULL).",
            /*@skEstatus             =*/ ".escape(isset($this->conf['skEstatus']) ? $this->conf['skEstatus'] : NULL).",
            /*@sNombre               =*/ ".escape(isset($this->conf['sNombre']) ? $this->conf['sNombre'] : NULL).",
            /*@axn                   =*/ ".escape(isset($this->conf['axn']) ? $this->conf['axn'] : NULL).",
            /*@skUsuario             =*/ ".escape($_SESSION['usuario']['skUsuario']).",
            /*@skModulo              =*/ ".escape($this->sysController).")";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }

    public function stpC_catalogoSistemaOpciones(){
        $sql = "CALL stpC_catalogoSistemaOpciones (
            /*@skCatalogoSistemaOpciones     =*/ ".escape(isset($this->conf['skCatalogoSistemaOpciones']) ? $this->conf['skCatalogoSistemaOpciones'] : NULL).",
            /*@skCatalogoSistema             =*/ ".escape(isset($this->conf['skCatalogoSistema']) ? $this->conf['skCatalogoSistema'] : NULL).",
            /*@skEstatus                     =*/ ".escape(isset($this->conf['skEstatus']) ? $this->conf['skEstatus'] : NULL).",
            /*@sNombre                       =*/ ".escape(isset($this->conf['sNombreOpcion']) ? $this->conf['sNombreOpcion'] : NULL).",
            /*@skClave                       =*/ ".escape(isset($this->conf['skClave']) ? $this->conf['skClave'] : NULL).",
            /*@axn                           =*/ ".escape(isset($this->conf['axn']) ? $this->conf['axn'] : NULL).",
            /*@skUsuario                     =*/ ".escape($_SESSION['usuario']['skUsuario']).",
            /*@skModulo                      =*/ ".escape($this->sysController).")";

      
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        return $record;
    }

    public function delete_catalogosOpciones(){
        $sql = "UPDATE rel_catalogosSistemasOpciones SET
            skEstatus = 'EL',
            skUsuarioModificacion = ".escape($_SESSION['usuario']['skUsuario']).",
            dFechaModificacion = NOW()
            WHERE skEstatus != 'EL' AND skCatalogoSistema = ".escape($this->conf['skCatalogoSistema']);

        $mssql_where_in = mssql_where_in($this->conf['skCatalogosSistemas_array']);
        if (!empty($mssql_where_in)) {
            $sql .= " AND skCatalogoSistemaOpciones NOT IN (" . $mssql_where_in . ")";
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        return TRUE;
    }

    public function consultar_catalogosSistemas(){
        $sql = "SELECT ccs.*,
            CONCAT(u.sNombre,' ',u.sApellidoPaterno) AS usuarioCreacion,
            CONCAT(u2.sNombre,' ',u2.sApellidoPaterno) AS usuarioModificacion,
            ce.sNombre as estatus
            FROM cat_catalogosSistemas ccs
            INNER JOIN cat_usuarios u ON u.skUsuario =  ccs.skUsuarioCreacion
            LEFT JOIN cat_usuarios u2 ON u2.skUsuario =  ccs.skUsuarioModificacion
            LEFT JOIN core_estatus ce ON ce.skEstatus = ccs.skEstatus
            WHERE ccs.skCatalogoSistema = " . escape(isset($this->conf['skCatalogoSistema']) ? $this->conf['skCatalogoSistema'] : NULL);
        
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

}
