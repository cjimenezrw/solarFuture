<?php

/**
 * DLOREAN Model
 *
 * Esta es la clase principal de DLOREAN, todos los controladores heradaran
 * esta clase, pues contiene además las conexiones a base de datos y
 * funcionalidades principales del core.
 *
 * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
 */
Class DLOREAN_Model extends Conn {

    use DLOREAN_Functions;

    // PUBLIC VARIABLES //
    /** @var string Directorio que contiene los modulos, ejemplo: - sys - */
    public $sysProject;

    /** @var string Nombre del modulo principal */
    public $sysModule;

    /** @var string Contiene el primer parametro de url por query string */
    public $sysController;

    /** @var string Nombre de al funcion a ejecuter del modulo */
    public $sysFunction;

    /** @var string La url actual del modulo consultado */
    public $sysUrl;

    /** @var string Nombre elegante del modulo consultado */
    public $sysName;

    /** @var mixed Contiene el primer parametro de url por query string */
    public $p1;

    /** @var mixed Contiene el segundo parametro de url por query string */
    public $p2;

    /** @var mixed Contiene el tercer  parametro de url por query string */
    public $p3;

    /** @var mixed Contiene el cuarto parametro de url por query string */
    public $p4;

    /** @var mixed Contiene el quinto parametro de url por query string */
    public $p5;
    // PROTECTED VARIABLES //
    /** @var array Contiene los objetos de conexion a las bases de datos */
    protected $db = array();
    // PRIVATE VARIABLES //
    /** @var mixed Contiene los datos a usar en el DLOREAN Model */
    private $data;

    /**
     * Constructor del DLOREAN MODEL
     *
     * Invoca la funcion connect para crear los objetos de conexion de las bases
     * de datos y la función para obtener los parámetros del módulo.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     */
    public function __construct() {
        parent::__construct();
        $this->init();
    }

    /**
     * Destructor del DLOREAN MODEL
     *
     * Invoca la funcion disconnect para cerrar las conexiones de BD y cerrar sesión si la petición
     * es hecha por un token de servicios web.
     * de datos
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     */
    public function __destruct() {
        //$this->disconnect();
        // LOGOUT DEL SERVICIO WEB.
        $skToken = (isset($_POST['skToken']) ? $_POST['skToken'] : (isset($_GET['skToken']) ? $_GET['skToken'] : NULL));
        $skDispositivoToken = (isset($_POST['skDispositivoToken']) ? $_POST['skDispositivoToken'] : (isset($_GET['skDispositivoToken']) ? $_GET['skDispositivoToken'] : NULL));
        if ($skToken || $skDispositivoToken) {
            session_destroy();
        }
    }

    /**
     * Conectar a base de datos
     *
     * Crea la conexion con la base de datos, si tu le defines una accedera a ella
     * en caso de que no definas el parametro, usará la conexion por default
     * establecida  en el config.
     *
     * @deprecated Desde la implementacion de PDO.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string $connection Identificador de la conexión
     * @param bool $showError Parametro para mostrar o no los errores de conexion
     * @return true | string Cuando todo sale bien o string en caso de error
     */
    public function connectDEPRECATED($connection = FALSE, $showError = TRUE) {
        /* global $db_connections;
          $this->db = $_SESSION['DB_CONNECTIONS'];
          if(!$connection){
          $connection = DEFAULT_CONNECTION;
          $HOST_DB = $db_connections[DEFAULT_CONNECTION][ENVIRONMENT]['HOST_DB'];
          $USER_DB = $db_connections[DEFAULT_CONNECTION][ENVIRONMENT]['USER_DB'];
          $PASSWORD_DB = $db_connections[DEFAULT_CONNECTION][ENVIRONMENT]['PASSWORD_DB'];
          $DATABASE_DB = $db_connections[DEFAULT_CONNECTION][ENVIRONMENT]['DATABASE_DB'];
          }else{
          $sql = "SELECT * FROM cat_servidoresVinculados WHERE sNombre = '".$connection."'";
          $result = Conn::query($sql, $this->db[DEFAULT_CONNECTION]);
          if(!$result){
          return FALSE;
          }
          $row = Conn::fetch_assoc($result);
          $HOST_DB = $row['sIP'];
          $USER_DB = $row['sUsuario'];
          $PASSWORD_DB = $row['sPassword'];
          $DATABASE_DB = $row['sBDA'];

          if(isset($_SESSION['DB_CONNECTIONS'][$connection])){
          return TRUE;
          }
          }

          $this->db[$connection] = @mssql_connect($HOST_DB, $USER_DB, $PASSWORD_DB);

          if(!$this->db[$connection]){
          if($showError){
          $this->showError('ERROR AL CONECTAR A LA BASE DE DATOS: '.$DATABASE_DB , 500);
          }else{
          return FALSE;
          }
          }

          if(!@mssql_select_db($DATABASE_DB , $this->db[$connection])){
          if($showError){
          $this->showError('ERROR AL CONECTAR A LA BASE DE DATOS: '.$DATABASE_DB , 500);
          }else{
          return FALSE;
          }
          }

          $_SESSION['DB_CONNECTIONS'][$connection] = $this->db[$connection];

          return TRUE; */
    }

    /**
     * Desconectar de base de datos
     *
     * Cierra la conexion de base de datos del objeto parametrizado o de la
     * conexion por default en caso de no definirse.
     *
     * @deprecated Desde la implementacion de PDO
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param object $connection Objeto opcional de conexion a base de datos
     * @return true Cuando todo sale bien
     */
    public function disconnect($connection = FALSE) {
        /* if(isset($_SESSION['DB_CONNECTIONS'])){
          if(is_array($_SESSION['DB_CONNECTIONS'])){
          foreach($_SESSION['DB_CONNECTIONS'] AS $k=>&$v){
          @mssql_close($v);
          }
          unset($_SESSION['DB_CONNECTIONS']);
          }
          }
          return TRUE; */
    }

    /**
     * Detonador
     *
     * Detona la carga del modulo.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     */
    public function index() {
        $this->load_module();
    }

    /**
     * Inicializar datos
     *
     * Obtiene los parámetros del módulo pasados por URL
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return true Cuando todo sale bien
     */
    protected function init() {
        $_GET['sysProject'] = (isset($_GET['sysProject']) && !empty($_GET['sysProject'])) ? str_replace('/', '', $_GET['sysProject']) : NULL;
        $_GET['sysModule'] = (isset($_GET['sysModule']) && !empty($_GET['sysModule'])) ? str_replace('/', '', $_GET['sysModule']) : NULL;
        $_GET['sysController'] = (isset($_GET['sysController']) && !empty($_GET['sysController'])) ? str_replace('/', '', $_GET['sysController']) : NULL;
        $_GET['sysFunction'] = (isset($_GET['sysController']) && !empty($_GET['sysController'])) ? str_replace('-', '_', $_GET['sysController']) : NULL;
        $_GET['sysUrl'] = SERVER_PROTOCOL . SERVER_NAME . SERVER_PORT . $_SERVER['REQUEST_URI'];
        $_GET['sysName'] = (isset($_GET['sysName']) && !empty($_GET['sysName'])) ? str_replace('/', '', $_GET['sysName']) : NULL;
        $_GET['p1'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? str_replace('/', '', $_GET['p1']) : NULL;
        $_GET['p2'] = (isset($_GET['p2']) && !empty($_GET['p2'])) ? str_replace('/', '', $_GET['p2']) : NULL;
        $_GET['p3'] = (isset($_GET['p3']) && !empty($_GET['p3'])) ? str_replace('/', '', $_GET['p3']) : NULL;
        $_GET['p4'] = (isset($_GET['p4']) && !empty($_GET['p4'])) ? str_replace('/', '', $_GET['p4']) : NULL;
        $_GET['p5'] = (isset($_GET['p5']) && !empty($_GET['p5'])) ? str_replace('/', '', $_GET['p5']) : NULL;

        $this->sysProject = $_GET['sysProject'];
        $this->sysModule = $_GET['sysModule'];
        $this->sysController = $_GET['sysController'];
        $this->sysFunction = $_GET['sysFunction'];
        $this->sysUrl = $_GET['sysUrl'];
        $this->sysName = $_GET['sysName'];
        $this->p1 = $_GET['p1'];
        $this->p2 = $_GET['p2'];
        $this->p3 = $_GET['p3'];
        $this->p4 = $_GET['p4'];
        $this->p5 = $_GET['p5'];
        return TRUE;
    }

    /**
     * Autenticación por token de servicios web.
     *
     * Autentica al usuario por medio del token de servicios web.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return bool Retorna true en caso de que el token sea válido ó false en caso de token NO válido.
     */
    protected function token_auth() {
        $skToken = (isset($_POST['skToken']) ? $_POST['skToken'] : (isset($_GET['skToken']) ? $_GET['skToken'] : NULL));
        $skDispositivoToken = (isset($_POST['skDispositivoToken']) ? $_POST['skDispositivoToken'] : (isset($_GET['skDispositivoToken']) ? $_GET['skDispositivoToken'] : NULL));
        if (!is_null($skToken) || !is_null($skDispositivoToken)) {

            $sql = "SELECT
                u.skUsuario,u.sNombre AS nombreUsuario,u.sUsuario, p.sNombre AS nombrePerfil,u.skArea,u.skDepartamento,
                u.sTipoUsuario, u.sCorreo AS correo,u.skRolDigitalizacion, p.skPerfil, u.sApellidoPaterno,u.sApellidoMaterno, es.skEmpresaSocio,
                es.skEmpresa, es.skEmpresaSocioPropietario,e.sNombre AS sEmpresa,ut.skUsuarioPerfil, u.skGrupo
                FROM rel_usuarios_token ut
                INNER JOIN rel_usuarios_perfiles up ON up.skUsuarioPerfil = ut.skUsuarioPerfil
                INNER JOIN core_perfiles p ON p.skPerfil = up.skPerfil
                INNER JOIN cat_usuarios u ON u.skUsuario = up.skUsuario
                INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = up.skEmpresaSocio
                INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
                LEFT JOIN rel_dispositivo_token dt ON dt.skUsuario = u.skUsuario
                WHERE ut.skToken = '" . $skToken . "'";

            if (!is_null($skDispositivoToken)) {
                $sql .= " AND dt.skDispositivoToken = '" . $skDispositivoToken . "'";
            }

            $result = Conn::query($sql);
            if (!$result) {
                return FALSE;
            }
            $row = Conn::fetch_assoc($result);
            $result->closeCursor();
            if ($row) {
                utf8($row);

                $sucursales = "SELECT cps.skSucursal,cs.sAmbiente
                FROM rel_usuarios_perfiles  rup
                LEFT JOIN rel_usuarios_perfiles_sucursales cps ON cps.skUsuarioPerfil = cps.skUsuarioPerfil
                LEFT JOIN cat_sucursales cs ON cs.skSucursal = cps.skSucursal
                WHERE rup.skUsuarioPerfil = '" . $row['skUsuarioPerfil'] . "'";
                $result1 = Conn::query($sucursales);
                $sucursalesArray = array();
                $ambientesArray = array();
                while ($rowSucursales = Conn::fetch_array($result1)) {
                    $sucursalesArray[$rowSucursales['skSucursal']] = $rowSucursales['skSucursal'];
                    if ($rowSucursales['sAmbiente']) {
                        $ambientesArray[$rowSucursales['sAmbiente']] = $rowSucursales['sAmbiente'];
                    }
                }
                $result1->closeCursor();

                $add_quotes = function($value) {
                    return sprintf("'%s'", $value);
                };

                if ($row['skGrupo']) {
                    //$rfc = parent::obtener_rfcs($row['skGrupo']);
                    $rfc = "SELECT DISTINCT ce.sRFC
                        FROM rel_gruposEmpresas  rge
                        INNER JOIN rel_empresasSocios res ON res.skEmpresaSocio = rge.skSocioEmpresa
                        INNER JOIN cat_empresas ce ON ce.skEmpresa = res.skEmpresa
                        WHERE rge.skGrupo = '" . $row['skGrupo'] . "'";
                    $result3 = Conn::query($rfc);
                    $rfcArray = array();
                    while ($rowRfc = Conn::fetch_array($result3)) {
                        $rfcArray[$rowRfc['sRFC']] = $rowRfc['sRFC'];
                    }
                    $result3->closeCursor();
                } else {

                    //$rfc = parent::obtener_rfc($row['skEmpresaSocio']);
                    $rfc = "SELECT DISTINCT ce.sRFC
                        FROM rel_empresasSocios res
                        INNER JOIN cat_empresas ce ON ce.skEmpresa = res.skEmpresa
                        WHERE res.skEmpresaSocio = '" . $row['skEmpresaSocio'] . "'";
                    $result4 = Conn::query($rfc);
                    $rfcArray = array();
                    while ($rowRfc = Conn::fetch_array($result4)) {
                        $rfcArray[$rowRfc['sRFC']] = $rowRfc['sRFC'];
                    }
                    $result4->closeCursor();
                }

                    $visionEjecutivo = "SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
            		FROM cat_gruposUsuarios cg
            		 LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
            		 WHERE cg.skEstatus = 'AC'
            		AND  ( (rgu.skUsuario = '" . $row['skUsuario'] . "' AND rgu.iRecursivo = 0) OR cg.skUsuarioResponsable = '" . $row['skUsuario'] . "') ";
                $result3 = Conn::query($visionEjecutivo);
                $visionEjecutivoArray = array();
                foreach (Conn::fetch_assoc_all($result3) as $rowVisionEjecutivo) {
                    if ($rowVisionEjecutivo['skUsuarioResponsable'] == $row['skUsuario'] && $rowVisionEjecutivo['iRecursivo'] == 1) {
                        $visionEjecutivoArray[$rowVisionEjecutivo['skUsuario']] = $rowVisionEjecutivo['skUsuario'];
                        $recursividad1 = "SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
                                                    		FROM cat_gruposUsuarios cg
                                                    		LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
                                                    		Where cg.skEstatus = 'AC'
                                                    		AND  ( (rgu.skUsuario = '" . $rowVisionEjecutivo['skUsuario'] . "' AND rgu.iRecursivo = 0) OR cg.skUsuarioResponsable = '" . $rowVisionEjecutivo['skUsuario'] . "' )";
                        $resultVision1 = Conn::query($recursividad1);
                        foreach (  Conn::fetch_assoc_all($resultVision1) as $rowVision1) {

                            if ($rowVision1['skUsuarioResponsable'] == $rowVisionEjecutivo['skUsuario'] && $rowVision1['iRecursivo'] == 1) {
                                $visionEjecutivoArray[$rowVision1['skUsuario']] = $rowVision1['skUsuario'];
                                $recursividad2 = "SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
                                                                                		FROM cat_gruposUsuarios cg
                                                                                		LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
                                                                                		Where cg.skEstatus = 'AC'
                                                                                		AND  ( (rgu.skUsuario = '" . $rowVision1['skUsuario'] . "' AND rgu.iRecursivo = 0) OR cg.skUsuarioResponsable = '" . $rowVision1['skUsuario'] . "' )";
                                $resultVision2 = Conn::query($recursividad2);
                                foreach ( Conn::fetch_assoc_all($resultVision2) as $rowVision2) {

                                    if ($rowVision2['skUsuarioResponsable'] == $rowVision1['skUsuario'] && $rowVision2['iRecursivo'] == 1) {
                                        $visionEjecutivoArray[$rowVision2['skUsuario']] = $rowVision2['skUsuario'];
                                        $recursividad3 = "SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
                                                                                                            		FROM cat_gruposUsuarios cg
                                                                                                            		LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
                                                                                                            		Where cg.skEstatus = 'AC'
                                                                                                            		AND  ( (rgu.skUsuario = '" . $rowVision2['skUsuario'] . "' AND rgu.iRecursivo = 0) OR cg.skUsuarioResponsable = '" . $rowVision2['skUsuario'] . "' )";
                                        $resultVision3 = Conn::query($recursividad3);
                                        foreach ( Conn::fetch_assoc_all($resultVision3) as $rowVision3) {
                                            if ($rowVision3['skUsuarioResponsable'] == $rowVision2['skUsuario'] && $rowVision3['iRecursivo'] == 1) {
                                                $visionEjecutivoArray[$rowVision3['skUsuario']] = $rowVision3['skUsuario'];
                                            }
                                            if ($rowVision3['skUsuarioResponsable'] == $rowVision2['skUsuario'] && $rowVision3['iRecursivo'] == 0) {
                                                $visionEjecutivoArray[$rowVision3['skUsuario']] = $rowVision3['skUsuario'];
                                            }
                                            if ($rowVision3['skUsuario'] == $rowVision2['skUsuarioResponsable']) {
                                                $visionEjecutivoArray[$rowVision3['skUsuarioResponsable']] = $rowVision3['skUsuarioResponsable'];
                                            }
                                        }
                                        $resultVision3->closeCursor();
                                    }
                                    if ($rowVision2['skUsuarioResponsable'] == $rowVision1['skUsuario'] && $rowVision2['iRecursivo'] == 0) {
                                        $visionEjecutivoArray[$rowVision2['skUsuario']] = $rowVision2['skUsuario'];
                                    }
                                    if ($rowVision2['skUsuario'] == $rowVision1['skUsuarioResponsable']) {
                                        $visionEjecutivoArray[$rowVision2['skUsuarioResponsable']] = $rowVision2['skUsuarioResponsable'];
                                    }
                                }
                                $resultVision2->closeCursor();
                            }
                            if ($rowVision1['skUsuarioResponsable'] == $rowVisionEjecutivo['skUsuario'] && $rowVision1['iRecursivo'] == 0) {
                                $visionEjecutivoArray[$rowVision1['skUsuario']] = $rowVision1['skUsuario'];
                            }
                            if ($rowVision1['skUsuario'] == $rowVisionEjecutivo['skUsuarioResponsable']) {
                                $visionEjecutivoArray[$rowVision1['skUsuarioResponsable']] = $rowVision1['skUsuarioResponsable'];
                            }
                        }// CIERRA WHILE $rowVision1
                        $resultVision1->closeCursor();
                    }//CIERRA IF usuarioResponsable y recursividad

                    if ($rowVisionEjecutivo['skUsuario'] == $row['skUsuario']) {
                        $visionEjecutivoArray[$rowVisionEjecutivo['skUsuarioResponsable']] = $rowVisionEjecutivo['skUsuarioResponsable'];
                    }
                }
                $result3->closeCursor();
                $visionEjecutivoArray[$row['skUsuario']] = $row['skUsuario'];

                $_SESSION['usuario'] = array(
                    'skUsuario'                 => $row['skUsuario'],
                    'sNombreUsuario'            => $row['nombreUsuario'],
                    'sUsuario'                  => $row['sUsuario'],
                    'sEmpresa'                  => $row['sEmpresa'],
                    'skArea'                    => $row['skArea'],
                    'skDepartamento'            => $row['skDepartamento'],
                    'sNombrePerfil'             => $row['nombrePerfil'],
                    'tipoUsuario'               => $row['sTipoUsuario'],
                    'correo'                    => $row['correo'],
                    'skRolDigitalizacion'       => $row['skRolDigitalizacion'],
                    'perfiles'                  => $row['skPerfil'],
                    'skUsuarioPerfil'           => $row['skUsuarioPerfil'],
                    'sPaterno'                  => $row['sApellidoPaterno'],
                    'sMaterno'                  => $row['sApellidoMaterno'],
                    'skEmpresaSocio'            => $row['skEmpresaSocio'],
                    'skEmpresa'                 => $row['skEmpresa'],
                    'skEmpresaSocioPropietario' => $row['skEmpresaSocioPropietario'],
                    'sucursales'                => $sucursalesArray,
                    'ambientes'                 => $ambientesArray,
                    'rfc'                       => $rfcArray,
                    'visionEjecutivo'           => $visionEjecutivoArray
                );
            } else {
                return FALSE;
            }
            return TRUE;
        }
        return TRUE;
    }

    /**
     * Verificar sesión
     *
     * Revisa si el usuario esta autenticado y si tiene ademas un perfil seleccionado
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return bool true | false Redirecciona al login si no está logeado o el token es invalido.
     */
    protected function verify_session() {
        if (!$this->token_auth()) {
            $this->data['response'] = FALSE;
            $this->data['message'] = 'Token no válido.';
            $this->data['datos'] = FALSE;
            $this->data['sesionOut'] = true;
            header('Content-Type: application/json');
            echo json_encode($this->data);
            exit;
        }
        // VERIFICA SI EL USUARIO ESTÁ AUTENTICADO Y SI SELECCIONÓ PERFIL
        if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['perfiles'])) {
            if ($this->is_ajax()) {
                //echo '<script type="text/javascript">location.assign("' . SYS_URL . SYS_PROJECT . '/inic/inic-sesi/iniciar-session/' . '");</script>';
                $this->data['response'] = FALSE;
                $this->data['message'] = 'Su sesión ha caducado.';
                $this->data['datos'] = FALSE;
                $this->data['sesionOut'] = true;
                header('Content-Type: application/json');
                echo json_encode($this->data);
                exit;
            }
            $axn = (isset($_POST['axn']) ? $_POST['axn'] : (isset($_GET['axn']) ? $_GET['axn'] : NULL));
            if($axn == 'generarExcel' || $axn == 'pdf'){
                $this->data['response'] = FALSE;
                $this->data['message'] = 'Su sesión ha caducado.';
                $this->data['datos'] = FALSE;
                $this->data['sesionOut'] = true;
                exit(json_encode($this->data));
            }
            //header('Location: ' . SYS_URL . SYS_PROJECT . '/inic/inic-sesi/iniciar-session/');
            header('Location: ' . SYS_URL . SYS_PROJECT . '/inic/inic-sesi/iniciar-session/');
            exit;
        }
        return TRUE;
    }

    /**
     * showError
     *
     * Manda a llamar la pantalla de error cuando es invocada esta función, en caso
     * de que la ejecución sea por ajax, retorna un string de datos.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param String $message Mensaje
     * @param String $errorCode Código del Error
     * @return array | view Retorna un json o la vista con el mensaje de error
     */
    public static function showError($message = 'ERROR', $errorCode = 404) {
        $skDispositivoToken = (isset($_POST['skDispositivoToken']) ? $_POST['skDispositivoToken'] : (isset($_GET['skDispositivoToken']) ? $_GET['skDispositivoToken'] : NULL));
        if (DLOREAN_Model::is_ajax() || $skDispositivoToken) {
            $data = array(
                'ok'=>0,
                'success'=>FALSE,
                'data'=>$errorCode,
                'response'=>FALSE,
                'message'=>$message,
                'datos'=>$errorCode
            );
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'error.php');
        exit;
    }

    /**
     * showMessage
     *
     * Manda a llamar la pantalla de mensaje cuando es invocada esta función, en caso
     * de que la ejecución sea por ajax, retorna un string de datos.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param String $message Mensaje
     * @param String $messageCode Código del Mensaje
     * @return array | view Retorna un json o la vista con el mensaje de error
     */
    public static function showMessage($message = 'Mensaje de Portal Woodward', $messageCode = 200) {
        $skDispositivoToken = (isset($_POST['skDispositivoToken']) ? $_POST['skDispositivoToken'] : (isset($_GET['skDispositivoToken']) ? $_GET['skDispositivoToken'] : NULL));
        if (DLOREAN_Model::is_ajax() || $skDispositivoToken) {
            $data = array(
                'ok'=>1,
                'success'=>TRUE,
                'data'=>$messageCode,
                'response'=>TRUE,
                'message'=>$message,
                'datos'=>$messageCode
            );
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'message.php');
        exit;
    }

    /**
     * Log
     *
     * Crea un archivo de log dentro de core/logs/log
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string $data Contenido para el log
     * @return void NO retorna nada
     */
    public static function log($data, $force = FALSE, $clean = FALSE) {
        if(in_array(ENVIRONMENT, ['DEVELOPMENT','TEST']) || $force === TRUE){
            if($clean === TRUE && file_exists(LOG_LOGFILE)){
                unlink(LOG_LOGFILE);
            }
            if (!file_exists(LOG_LOGFILE)) {
                $file = fopen(LOG_LOGFILE, 'w');
                fclose($file);
                chmod(LOG_LOGFILE, 0777);
            }
            $debug_backtrace = debug_backtrace();
            $log_message  = date('Y-m-d h:i:s')." [PHP " . PHP_VERSION . "] (" . PHP_OS . ")\n";
            $log_message .= "Log Message on line (".$debug_backtrace[0]['line'].") in file ".$debug_backtrace[0]['file']."\n";
            $log_message .= print_r($data, true)."\n\n";
            @file_put_contents(LOG_LOGFILE, $log_message, FILE_APPEND | LOCK_EX);
        }
    }

    /**
     * Error Log
     *
     * Crea un archivo de log de errores dentro de core/logs/error
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string $data Contenido para el log de error
     */
    public static function error($data, $force = FALSE, $clean = FALSE) {
        if(in_array(ENVIRONMENT, ['DEVELOPMENT','TEST']) || $force === TRUE){
            if($clean === TRUE && file_exists(ERROR_LOGFILE)){
                unlink(ERROR_LOGFILE);
            }
            if (!file_exists(ERROR_LOGFILE)) {
                $file = fopen(ERROR_LOGFILE, 'w');
                fclose($file);
                chmod(ERROR_LOGFILE, 0777);
            }
            $debug_backtrace = debug_backtrace();
            $error_message  = date('Y-m-d h:i:s')." [PHP " . PHP_VERSION . "] (" . PHP_OS . ")\n";
            $error_message .= "Error Message on line (".$debug_backtrace[0]['line'].") in file ".$debug_backtrace[0]['file']."\n";
            $error_message .= "Error Type (24) DLOREAN_ERROR => ".print_r($data, true)."\n\n";
            @file_put_contents(ERROR_LOGFILE, $error_message, FILE_APPEND | LOCK_EX);
        }
    }

    /**
     * Registro de accesos
     *
     * Registra los accesos a las vistas de cualquier modulo
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return true|false True o false en caso de eror
     */
    public function log_access() {
        if (ENVIRONMENT !== 'DEVELOPMENT') {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $sIp = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $sIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $sIp = $_SERVER['REMOTE_ADDR'];
            }
            $sql = "CALL stpC_coreAccesosUsuarios (
            /*@skModulo   = */'" . $this->sysController . "',
            /*@skUsuario  = */'" . $_SESSION['usuario']['skUsuario'] . "',
            /*@sIP        = */'" . $sIp . "' )";
            $result = Conn::query($sql);
            if (!$result) {
                return FALSE;
            }
            Conn::free_result($result);
            return TRUE;
        }
        return TRUE;
    }

    /**
     * Verificar petición ajax
     *
     * Detecta si le ejecución de php fue provocada por una peticion ajax
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return true|false True cuando sea por ajax o false en caso contrario.
     */
     public static function is_ajax() {
         if(function_exists('getallheaders')){
 			$headers = apache_request_headers();
 			//print_r($headers);


         if (!isset($headers['X-Requested-With'])) {
             return FALSE;
         }

         if (!strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
             return FALSE;
         }
 		}else{
 			$si =  function () {
 				  $arh = array();
 				  $rx_http = '/\AHTTP_/';
 				  foreach($_SERVER as $key => $val) {
 					if( preg_match($rx_http, $key) ) {
 					  $arh_key = preg_replace($rx_http, '', $key);
 					  $rx_matches = array();
 					  // do some nasty string manipulations to restore the original letter case
 					  // this should work in most cases
 					  $rx_matches = explode('_', $arh_key);
 					  if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
 						foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
 						$arh_key = implode('-', $rx_matches);
 					  }
 					  $arh[$arh_key] = $val;
 					}
 				  }
 				  return( $arh );
 				};
 				$res = $si();

 				if (!isset($res['X-REQUESTED-WITH'])) {
 				               return FALSE;
 				}

                return TRUE;
 		}



 		return TRUE;
     }

    /**
     * Módulo es público
     *
     * Verifica si el módulo es público por medio de la variable de sesión, en caso
     * de que no este establecida la variable de sesión, lo buscará en la base de datos
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return true|false True en caso de ser público o false en caso de ser privado
     */
    protected function public_module() {

        if (!empty($_SESSION['modulos']) && isset($_SESSION['modulos'][$this->sysController]) && ($_SESSION['modulos'][$this->sysController]['publico'] === 1)) {
            return TRUE;
        } elseif (!empty($_SESSION['modulos']) && isset($_SESSION['modulos'][$this->sysController]) && ($_SESSION['modulos'][$this->sysController]['publico'] === 0)) {
            return FALSE;
        }

        // VERIFICAMOS SI ES UN MÓDULO PÚBLICO //
        $result = Conn::query("SELECT * FROM core_modulos_caracteristicas WHERE skCaracteristicaModulo = 'PUBL' AND skModulo = '" . $this->sysController . "'");
        if (!$result) {
            return FALSE;
        }
        $publico = Conn::fetch_assoc($result);

        // VERIFICAMOS CON SESIÓN INICIADA EN EL SISTEMA SI EL MÓDULO EXISTE EN BASE DE DATOS //
        if (is_array($publico) && count($publico) === 0 && isset($_SESSION['modulos']) && !isset($_SESSION['modulos'][$this->sysController])) {
            $this->showError('NO EXISTE EL MÓDULO (' . $this->sysController . ')', 500);
        }

        Conn::free_result($result);

        if ($publico) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Verifica permisos de módulo
     *
     * Verifica si tiene permiso (R,W,D,A) en el módulo de acuerdo al solicitado.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param char $permission Char que representa un tipo de permiso
     * @return true|false True si tiene permiso o false en caso contrario.
     */
    protected function verify_permissions($permission = 'R') {
        if ((isset($_SESSION['modulos'][$this->sysController]) && $_SESSION['modulos'][$this->sysController]['permisos'][$permission] == 1 ) || ($_SESSION['usuario']['tipoUsuario'] == 'A')) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Cargar Módulo
     *
     * Carga el módulo solicitado, verifica si el módulo es público o privado, en caso de ser privado verifica la sesión,
     * Obtiene los permisos, obtiene el menu, verifica si en el módulo el usuario tiene permisos de lectura.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna el Módulo solicitado.
     */
    private function load_module() {

        $sysFunction = $this->sysFunction;

        if ($this->sysModule === NULL) {
            $session = $this->verify_session();
            if ($session) {
                header('Location: ' . SYS_URL . SYS_PROJECT . '/inic/inic-dash/inicio/');
            }else{
                header('Location: ' . SYS_URL . SYS_PROJECT . '/inic/inic-sesi/iniciar-session/');
            }
            exit;
        }

        // VERIFICAR SI EL MÓDULO ES PÚBLICO.
        $publico = $this->public_module();
        if (!$publico) {
            $this->verify_session();

            $skToken = (isset($_POST['skToken']) ? $_POST['skToken'] : (isset($_GET['skToken']) ? $_GET['skToken'] : NULL));
            if (is_null($skToken)) {

                // CARGAMOS CONFIGURACIÓN DE PERMISOS Y MÓDULOS //
                $this->getModulosPermissions();

                // VERIFICAR PERMISOS PARA VER EL MÓDULO //
                if (!$this->verify_permissions('R')) {
                    if (!$this->verify_permissions('W')) {
                        if (!$this->verify_permissions('D')) {
                            $this->showError('NO TIENES PERMISOS PARA ACCEDER AL MÓDULO (' . $this->sysController . ')', 500);
                        }
                    }
                }

                // CARGAMOS MENUS //
                $this->getMenu('LAT');
                $this->getMenu('ACR');
                $this->getMenu('SUP');



            }else{

                // VERIFICAMOS LOS PERMISOS CUANDO SE ENVIA EL TOKEN //
                if($_SESSION['usuario']['tipoUsuario'] != 'A'){
                    $sql = "SELECT * FROM core_modulos_permisos_perfiles WHERE skModulo = '".$this->sysController."' AND skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ") AND skPermiso IN ('R','W','D')";
                    $result = Conn::query($sql);
                    if(!$result){
                        $this->data['response'] = FALSE;
                        $this->data['message'] = 'Hubo un error al intentar acceder al módulo (' . $this->sysController . ')';
                        $this->data['datos'] = FALSE;
                        $this->data['sesionOut'] = true;
                        header('Content-Type: application/json');
                        echo json_encode($this->data);
                        exit;
                    }
                    $records = Conn::fetch_assoc_all($result);
                    if(!$records){
                        $this->data['response'] = FALSE;
                        $this->data['message'] = 'NO TIENES PERMISOS PARA ACCEDER AL MÓDULO (' . $this->sysController . ')';
                        $this->data['datos'] = FALSE;
                        $this->data['sesionOut'] = true;
                        header('Content-Type: application/json');
                        echo json_encode($this->data);
                        exit;
                    }
                }
            }

        }

        // VERIFICA SI EXISTE EL DIRECTORIO DEL MÓDULO.
        if (!is_dir(SYS_PATH . $this->sysModule)) {
            $this->showError('NO EXISTE EL DIRECTORIO (' . $this->sysModule . ')', 404);
        }

        // VERIFICA SI EXISTE EL MODELO DEL MÓDULO.
        if (!file_exists(SYS_PATH . $this->sysModule . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $this->sysModule . ".model.php")) {
            $this->showError('NO EXISTE EL MODELO (' . $this->sysModule . ')', 404);
        }

        // INCLUYE EL MODELO DEL MÓDULO.
        require_once(SYS_PATH . $this->sysModule . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $this->sysModule . ".model.php");

        // VERIFICA SI EXISTE EL CONTROLADOR DEL MÓDULO.
        if (!file_exists(SYS_PATH . $this->sysModule . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $this->sysModule . ".controller.php")) {
            $this->showError('NO EXISTE EL CONTROLADOR (' . $this->sysModule . ')', 404);
        }

        // INCLUYE EL CONTROLADOR DEL MÓDULO.
        require_once(SYS_PATH . $this->sysModule . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $this->sysModule . ".controller.php");
        $sysModule_controller = $this->sysModule . "_Controller";
        $sysModule_model = new $sysModule_controller();

        // VERIFICA SI EL MÉTODO EXISTE EN EL MÓDULO.
        if (!method_exists($sysModule_model, $sysFunction)) {
            $this->showError('NO EXISTE EL MÉTODO (' . $sysFunction . ') DEL CONTROLADOR (' . $this->sysModule . ')', 404);
        }

        $sysModule_model->$sysFunction();
        return TRUE;
    }

    /**
     * Carga una clase
     *
     * Carga una clase (model | controller)
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string $class Nombre del archivo sin extencion.
     * @param string $type Tipo de clase model|controller
     * @param string $path Nombre del modulo principal que alberga dicha clase
     * @return true True si todo sale bien.
     */
    public function load_class($class, $type = 'model', $path = NULL) {
        // OBTIENE LA RUTA ABSOLUTA DE LA CLASE DEL MÓDULO
        if ($path != NULL) {
            $class_path = SYS_PATH . $path . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $class . '.' . $type . '.php';
        } else {
            $class_path = SYS_PATH . $this->sysModule . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $class . '.' . $type . '.php';
        }

        // VERIFICA SI EXISTE LA CLASE DEL MÓDULO.
        if (!file_exists($class_path)) {
            $this->showError('NO SE ENCONTRÓ LA CLASE (' . $class . ') en (' . $class_path . ')', 404);
        }
        require_once($class_path);
        return TRUE;
    }

    /**
     * Carga de vista
     *
     * Carga una vista, basado en el nombre del archivo sin la extencion, solo
     * el primer parametro es obligatorio, poner el parametro de $template como
     * false hara que no imprima nada de la GUI.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string $view Nombre de la vista
     * @param array $data Array de datos que se le pasaran a al vista
     * @param string $path Ruta hacia la vista
     * @param bool $template Bandera de cargar o no el template
     * @return true | string Cuando todo sale bien o un string de error.s
     */
    protected function load_view($view, $data = array(), $path = NULL, $template = TRUE) {
        // OBTIENE LA RUTA ABSOLUTA DE LA VISTA DEL MÓDULO
        if ($path != NULL) {
            $view_path = SYS_PATH . $path . DIRECTORY_SEPARATOR . $view . '.php';
        } else {
            $view_path = SYS_PATH . $this->sysModule . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $view . '.php';
        }

        // VERIFICA SI EXISTE LA VISTA DEL MÓDULO.
        if (!file_exists($view_path)) {
            $this->showError('NO SE ENCONTRÓ LA VISTA (' . $view . ') en (' . $view_path . ')', 404);
        }

        // LOG DE ACCESO A UN MÓDULO.
        $publico = $this->public_module();
        if (!$publico) {
            $this->log_access();
        }

        // VERIFICA SI EL MÓDULO REQUIERE TEMPLATE.
        if ($template) {
            // VERIFICA SI ES UNA PETICIÓN AJAX.
            if ($this->is_ajax()) {
                if (isset($_POST['skComportamiento']) && ($_POST['skComportamiento'] === 'VEMO')) {
                    require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'ventanaModal.header.php');
                    require_once($view_path);
                    require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'ventanaModal.footer.php');
                } elseif (isset($_POST['skComportamiento']) && ($_POST['skComportamiento'] === 'MOWI')) {
                    require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'modalWindow.footer.php');
                    require_once($view_path);
                } elseif (isset($_POST['skComportamiento']) && ($_POST['skComportamiento'] === 'PANE')) {
                    require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'slidePanel.header.php');
                    require_once($view_path);
                    require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'slidePanel.footer.php');
                } else {
                    require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'breadCrumbs.php');
                    require_once($view_path);
                }
                require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'analyticstracking.php');


                $_sBreadCrumb = '';
                if(isset($_SESSION['modulos'][$this->sysController]['breadCrumb'])){
                    $_iBreadCrumb = 1;
                    foreach($_SESSION['modulos'][$this->sysController]['breadCrumb'] AS $row){
                        if(count($_SESSION['modulos'][$this->sysController]['breadCrumb']) == $_iBreadCrumb){
                            $_sBreadCrumb .= $row['sTitulo'];
                            continue;
                        }
                        $_sBreadCrumb .= $row['sTitulo']." / ";
                        $_iBreadCrumb++;
                    }
                }
                echo '<script type="text/javascript">core.modulo = {skModuloPrincipal: "'.$this->sysModule.'", skModulo: "'.$this->sysController.'", skModuloPadre: "'.$_SESSION['modulos'][$this->sysController]['skModuloPadre'].'", titulo: "'.$_SESSION['modulos'][$this->sysController]['titulo'].'", breadcrumb: "'.$_sBreadCrumb.'"};</script>';
                return TRUE;
            }
            require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'header.php');
            require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'breadCrumbs.php');
            require_once($view_path);
            require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'footer.php');
            require_once(CORE_PATH . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'analyticstracking.php');

            $_sBreadCrumb = '';
            if(isset($_SESSION['modulos'][$this->sysController]['breadCrumb'])){
                $_iBreadCrumb = 1;
                foreach($_SESSION['modulos'][$this->sysController]['breadCrumb'] AS $row){
                    if(count($_SESSION['modulos'][$this->sysController]['breadCrumb']) == $_iBreadCrumb){
                        $_sBreadCrumb .= $row['sTitulo'];
                        continue;
                    }
                    $_sBreadCrumb .= $row['sTitulo']." / ";
                    $_iBreadCrumb++;
                }
            }
            echo '<script type="text/javascript">core.modulo = {skModuloPrincipal: "'.$this->sysModule.'", skModulo: "'.$this->sysController.'", skModuloPadre: "'.$_SESSION['modulos'][$this->sysController]['skModuloPadre'].'", titulo: "'.$_SESSION['modulos'][$this->sysController]['titulo'].'", breadcrumb: "'.$_sBreadCrumb.'"};</script>';

        } else {
            // Se Comenta para cargar para envios automáticos la vista más de una vez.
            //require_once($view_path);
            include($view_path);
        }

        return TRUE;
    }

    /**
     * Carga permisos del módulo
     *
     * Carga los permisos de los modulos basad en usuario y su perfil, guardando los
     * datos en la variable global $_SESSION
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     */
    private function getModulosPermissions() {
        ini_set('memory_limit', '-1');

        if (!empty($_SESSION['modulos']) && ENVIRONMENT != 'DEVELOPMENT') {
            return TRUE;
        }

        $ssdata = &$_SESSION['usuario'];
        $sql="SELECT * FROM rel_usuariosConfiguraciones_permisos WHERE skUsuario = '".$ssdata['skUsuario']."' AND skEmpresaSocio = '$ssdata[skEmpresaSocio]' LIMIT 1 ";

            $s_conf = Conn::query($sql);

            $confSettings = Conn::fetch_assoc($s_conf);

        if(ENVIRONMENT == 'PRODUCTION') {
            if(isset($confSettings['iUpdateFlag']) && $confSettings['iUpdateFlag'] == 0){
                $_SESSION['modulos'] = json_decode($confSettings['sPermisos'], true, 512);
                return true;
            }
        }

        $sql = "CALL stpPermisosGenerales (
            'prin-inic',
            0,
            '$ssdata[skEmpresaSocio]',
             null,
             '$ssdata[skUsuario]' )";

        $query = Conn::query($sql);
        $arrayModulos = [];

        $pg = Conn::fetch_assoc_all($query);

        $query->closeCursor();

        foreach ( $pg as $result ) {
            utf8($result);
            $modulo = $result['skModulo'];

            $arrayModulos[$modulo] = [];
            $amd = & $arrayModulos[$modulo];

            $amd['publico'] = $result['iPublico'];
            $amd['permisos']['R'] = $result['peR'];
            $amd['permisos']['W'] = $result['peW'];
            $amd['permisos']['D'] = $result['peD'];
            $amd['permisos']['A'] = $result['peA'];
            $amd['skModuloPadre'] = $result['sModuloPadre'];
            $amd['skModuloPrincipal'] = $result['skModuloPrincipal'];
            $amd['skModulo'] = $result['skModulo'];
            $amd['sNombre'] = $result['sNombre'];
            $amd['titulo'] = $result['sTitulo'];
            $sqlBread ="CALL stpCoreBreadCrumb ( '$modulo', 0 )";

            $query2 = Conn::query($sqlBread);
            $i = 0;
            foreach ( Conn::fetch_assoc_all($query2) as $cbc) {

                utf8($cbc);
                $amd['breadCrumb'][$i]['skModulo'] = $cbc['skModulo'];
                $amd['breadCrumb'][$i]['skModuloPrincipal'] = $cbc['skModuloPrincipal'];
                $amd['breadCrumb'][$i]['skModuloPadre'] = $cbc['skModuloPadre'];
                $amd['breadCrumb'][$i]['sTitulo'] = $cbc['sTitulo'];
                $amd['breadCrumb'][$i]['sNombre'] = $cbc['sNombre'];
                $i++;
            }
            $query2->closeCursor();


            $arrayModulos[$modulo]['botones'] = array();
            $amd_b = & $arrayModulos[$modulo]['botones'];
            $sqlBotones = "
                        SELECT cmb.skModulo, cmb.skModuloPadre, cmb.skEstatus, cmb.skBoton, IF(cmb.sNombre IS NULL, cb.sNombre, cmb.sNombre) AS sNombre, cmb.iPosicion, IF(cmb.sFuncion IS NULL, cb.sFuncion, cmb.sFuncion) AS sFuncion, cmb.skComportamiento, IF(cmb.sIcono IS NULL, cb.sIcono, cmb.sIcono) AS sIcono, cm.skModuloPrincipal, cm.sNombre AS nombreModulo,cmb.skComportamiento
                       FROM core_modulos_botones cmb
                       INNER JOIN cat_usuarios cu ON cu.skUsuario='" . $_SESSION['usuario']['skUsuario'] . "'
                       INNER JOIN core_botones cb oN cb.skBoton = cmb.skBoton
                       INNER JOIN core_modulos cm oN cm.skModulo = cmb.skModuloPadre
                       LEFT JOIN core_modulos_permisos_perfiles cmpp ON cmpp.skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ")
                       AND (cmpp.skModulo = cmb.skModuloPadre OR cmpp.skModulo = cmb.skModulo)
                       AND cmpp.skPermiso = cb.skPermiso
                       WHERE cmb.skModulo='" . $modulo . "'
                       AND cmb.sKEstatus = 'AC'
                       AND (cu.sTipoUsuario='A' OR cmpp.skModulo IS NOT NULL)
                       ORDER BY cmb.iPosicion";

            $Botones = Conn::query($sqlBotones);

            foreach ( Conn::fetch_assoc_all($Botones) as $btnr ) {

                utf8($btnr);
                $amd_b[$btnr['iPosicion']]['skBoton'] = $btnr['skBoton'];
                $amd_b[$btnr['iPosicion']]['skModulo'] = $btnr['skModulo'];
                $amd_b[$btnr['iPosicion']]['skModuloPrincipal'] = $btnr['skModuloPrincipal'];
                $amd_b[$btnr['iPosicion']]['skModuloPadre'] = $btnr['skModuloPadre'];
                $amd_b[$btnr['iPosicion']]['sNombreBoton'] = $btnr['sNombre'];
                $amd_b[$btnr['iPosicion']]['sNombreModulo'] = $btnr['nombreModulo'];
                $amd_b[$btnr['iPosicion']]['sFuncion'] = $btnr['sFuncion'];
                $amd_b[$btnr['iPosicion']]['sIcono'] = $btnr['sIcono'];
                $amd_b[$btnr['iPosicion']]['skComportamiento'] = $btnr['skComportamiento'];

            }

            $Botones->closeCursor();
            $arrayModulos[$modulo]['caracteristicas'] = array();

            $amd_c = & $arrayModulos[$modulo]['caracteristicas'];


            $caracteristicas = Conn::query("SELECT * FROM core_modulos_caracteristicas WHERE skModulo ='" . $modulo . "'");
            foreach ( Conn::fetch_assoc_all($caracteristicas)  as $crtt) {
                $amd_c[$crtt['skCaracteristicaModulo']] = $crtt['skCaracteristicaModulo'];
            }
            $caracteristicas->closeCursor();


            $arrayModulos[$modulo]['menuEmergente'] = array();
            $amd_me = & $arrayModulos[$modulo]['menuEmergente'];
            $sqlMenuEmergente = "SELECT cmme.*,cm.sNombre, cm.skModuloPrincipal
                       FROM core_modulos_menusEmergentes cmme
                       INNER JOIN cat_usuarios cu ON cu.skUsuario='" . $_SESSION['usuario']['skUsuario'] . "'
                       LEFT JOIN core_modulos cm oN cm.skModulo = cmme.skModuloPadre
                       LEFT JOIN core_modulos_permisos_perfiles cmpp ON cmpp.skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ")
                       AND cmpp.skModulo = cmme.skModuloPadre
                       AND cmpp.skPermiso = cmme.skPermiso
                       WHERE cmme.skModulo='" . $modulo . "'
                       AND (cu.sTipoUsuario='A' OR cmpp.skModulo IS NOT NULL)
                       ORDER BY cmme.iPosicion";

            $MenuEmergente = Conn::query($sqlMenuEmergente);
            $m = 0;
            $ultimo = "";
            foreach ( Conn::fetch_assoc_all($MenuEmergente) as $rme) {
                utf8($rme);
                if ($m == 0 && $rme['sTitulo'] == '-') {
                    $ultimo = $rme['sTitulo'];
                } else {
                    $ultimo = "";
                }

                if ($ultimo == '-' && $rme['sTitulo'] == '-') {
                    $ultimo = $rme['sTitulo'];
                } else {
                    $amd_me[$rme['iPosicion']]['skModulo'] = $rme['skModulo'];
                    $amd_me[$rme['iPosicion']]['skModuloPrincipal'] = $rme['skModuloPrincipal'];
                    $amd_me[$rme['iPosicion']]['skModuloPadre'] = $rme['skModuloPadre'];
                    $amd_me[$rme['iPosicion']]['sNombreModulo'] = $rme['sNombre'];
                    $amd_me[$rme['iPosicion']]['sTitulo'] = $rme['sTitulo'];
                    $amd_me[$rme['iPosicion']]['skComportamiento'] = $rme['skComportamiento'];
                    $amd_me[$rme['iPosicion']]['sIcono'] = $rme['sIcono'];
                    $amd_me[$rme['iPosicion']]['iPosicion'] = $rme['iPosicion'];
                    $amd_me[$rme['iPosicion']]['sFuncion'] = $rme['sFuncion'];

                    $ultimo = $rme['sTitulo'];
                }
                $m++;
            }
            $MenuEmergente->closeCursor();
        }

        $_SESSION['modulos'] = $arrayModulos;
        $serial = json_encode($arrayModulos, 512);
        $id = escape( ($confSettings['skUsuarioConfiguracion'] ) ? $confSettings['skUsuarioConfiguracion'] : NULL  );
        $i_conf = Conn::query("CALL stpC_usuarioConfiguracion(
             $id,
             '$ssdata[skUsuario]',
            '$ssdata[skEmpresaSocio]',
             ".escape($serial).",
             0 )");

    }

    /**
     * Obtener menú
     *
     * Obtiene los datos del primer nivel del menú de la base de datos
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string $menu Llave primaria del menú
     */
    protected function getMenu($menu) {

        if (!empty($_SESSION['menu'][$menu]) && ENVIRONMENT != 'DEVELOPMENT') {
            return TRUE;
        }

        $select = "SELECT DISTINCT cm.skModulo,
            cm.iPosicion,
            cm.skModuloPadre,
            cm.skModuloPrincipal,
            cmi.sIcono,
            cm.sTitulo,
            cm.sNombre
            FROM core_modulos cm
            INNER JOIN cat_usuarios cu ON cu.skUsuario='" . $_SESSION['usuario']['skUsuario'] . "'
            INNER JOIN core_modulos_menus mm ON mm.skModulo = cm.skModulo
            LEFT JOIN core_modulos_iconos cmi ON cmi.skModulo = cm.skModulo
            LEFT JOIN core_modulos_permisos_perfiles cmpp ON cmpp.skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ") AND cmpp.skModulo=cm.skModulo
            WHERE   cm.skEstatus='AC'  AND mm.skMenu = '$menu'
            " . (isset($_SESSION['usuario']) ? " AND (cu.sTipoUsuario='A' OR cmpp.skModulo IS NOT NULL)" : "") . "
            ORDER BY cm.iPosicion ASC";

        $query = Conn::query($select);
        $data = array();

        foreach ( Conn::fetch_assoc_all($query) as $result) {
            utf8($result);
            $data[$result['skModulo']] = array(
                'skModulo' => $result['skModulo'],
                'iPosicion' => $result['iPosicion'],
                'skModuloPadre' => $result['skModuloPadre'],
                'skModuloPrincipal' => $result['skModuloPrincipal'],
                'sNombre' => $result['sNombre'],
                'sTitulo' => $result['sTitulo'],
                'sIcono' => $result['sIcono'],
                'subMenu' => array()
            );
            $this->getSubMenu($result['skModulo'], NULL, $data, 1);
        }

        $_SESSION['menu'][$menu] = $data;
    }

    /**
     * Obtener submenú
     *
     * Esta funcion obtiene los datos del submenú.
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param string $skModuloPadre Llave primaria del menú
     * @param string $skModuloSuperPadre Llave primaria del menú
     * @param array $data Referencia al objeto de datos.
     * @param string $nivel Llave primaria del menú
     */
    protected function getSubMenu($skModuloPadre, $skModuloSuperPadre, &$data, $nivel) {
        $select = "SELECT DISTINCT cm.skModulo,
        cm.iPosicion,
        cm.skModuloPadre,
        cm.skModuloPrincipal,
        cmi.sIcono,
        cm.sNombre,
        cm.sTitulo,
        mm.skCaracteristicaModulo
       FROM core_modulos cm
       INNER JOIN cat_usuarios cu ON cu.skUsuario='" . $_SESSION['usuario']['skUsuario'] . "'
       LEFT JOIN core_modulos_iconos cmi ON cmi.skModulo = cm.skModulo
       LEFT JOIN core_modulos_caracteristicas mm ON mm.skModulo = cm.skModulo AND mm.skCaracteristicaModulo = 'OCNA'
       LEFT JOIN core_modulos_permisos_perfiles cmpp ON cmpp.skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ") AND cmpp.skModulo=cm.skModulo
       WHERE  cm.skModuloPadre = '" . $skModuloPadre . "' AND
       mm.skCaracteristicaModulo IS NULL AND
       cm.skEstatus='AC'
       " . (isset($_SESSION['usuario']) ? " AND (cu.sTipoUsuario='A' OR cmpp.skModulo IS NOT NULL)" : "") . "
       ORDER BY cm.iPosicion ASC";
        $query = Conn::query($select);
        foreach ( Conn::fetch_assoc_all($query) as $result) {
            utf8($result);
            $datos = array(
                'skModulo' => $result['skModulo'],
                'iPosicion' => $result['iPosicion'],
                'skModuloPadre' => $result['skModuloPadre'],
                'skModuloPrincipal' => $result['skModuloPrincipal'],
                'sNombre' => $result['sNombre'],
                'sTitulo' => $result['sTitulo'],
                'sIcono' => $result['sIcono'],
                'subMenu' => array()
            );
            if ($nivel == 1) {
                $data[$skModuloPadre]['subMenu'][$result['skModulo']] = $datos;
                $this->getSubMenu($result['skModulo'], $result['skModuloPadre'], $data, 2);
            } else {
                $data[$skModuloSuperPadre]['subMenu'][$skModuloPadre]['subMenu'][$result['skModulo']] = $datos;
            }
        }
    }


    /**
     * sysAPI
     *
     * Consumo de APIS del sistema, los parametros entran en el argumento
     * $params y posee esta forma:
     *
     * [
     *  'POST' => [ ... ], // De establecerse, se sobreescribira $_POST
     *  'GET'  => [ ... ], // De establecerse, se sobreescribira $_GET
     *  '...'  => [ ... ]
     * ]
     *
     * Las superglobales regresan a su valor orginal al terminar la funcion.
     * Todos los valores del array cuya llave no sea post o get se tomarán como
     * argumentos de la funcion a llamar.
     *
     *
     * @param string $model Nombre del modelo
     * @param string $controller Nombre del controlador
     * @param string $callable    Nombre de la funcion
     * @param array $params Parametros
     * @return mixed
     */
    public function sysAPI($model,$controller,$callable, array $params){

        $this->load_class($model, 'model', $model);
        $this->load_class($controller, 'controller',$model);

        $cname = ucfirst($controller).'_Controller';
        $ModuleInstance = new $cname();

        if (!method_exists($ModuleInstance, $callable)) {
            return [ 'success' => false,  'message' => "NO EXISTE EL MÉTODO ($callable) DEL CONTROLADOR ($controller)"];
        }

        $_get  = $_GET;
        $_post = $_POST;

        $_GET = (array_key_exists('GET', $params)) ? $params['GET'] : $_GET;
        $_POST = (array_key_exists('POST', $params)) ? $params['POST'] : $_POST;

        unset($params['GET']);
        unset($params['POST']);

        $response = call_user_func_array([$ModuleInstance, $callable], array_values($params));

        $_GET  = $_get;
        $_POST = $_post;

        return $response;

    }

}
