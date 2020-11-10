<?php

/**
 * Clase de conexion
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
class Conn {

    /**
     *
     * @var int Cantidad actual de reconexiones realizadas
     */
    public static $reconects = 0;

    /**
     *
     * @var int Maximo numero de reintentos para conectar.
     */
    public static $maxReconTy = 4;

    /**
     *
     * @var Object Objeto de conexion PDO a la base de datos principal.
     */
    public static $base = null;

    /**
     *
     * @var array Array asociativo de objetos de conexion a otras bases de datos, su clave es el sNombre de servidores_vinculados
     */
    public static $others = array();

    /**
     *
     * @var array Array de datos de conexion a otras bases de datos.
     */
    public static $credentials = array();

    /**
     *
     * @var array Pose el registro actual de transacciones en progreso array('dbName' => 'nombre de base de datos', 'dsn' => 'tipo de base de datos');
     */
    public static $trsLoc = array();

    /**
     * Constructor
     *
     * Inicia la conexion base del sistema y llama a la funcion
     * Conn::getLinkedServersCredentials().
     * @return boolean
     */
    public function __construct() {
        Conn::initConn();
        Conn::getLinkedServersCredentials();
        return true;
    }

    /**
     *
     */
    public function __destruct() {
        /*Conn::$base = null;
        Conn::$others = null;*/
    }

    /**
     * Inicia todo
     *
     * Inicia la conexion principal y luego obtiene las credenciales de los servidores vinculados
     * registrados en la tabla cat_servidores_vinculados.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @global type $db_connections
     * @return boolean
     */
    public static function initConn() {
        global $db_connections;
        if (!Conn::connect($db_connections[DEFAULT_CONNECTION][ENVIRONMENT])) {
            return false;
        }
        Conn::testing();
    }

    /**
     * Obtiene el dsn
     *
     * Obtiene el dsn a partir de el tipo de servidor que se le pase, esto para hacer mas claro
     * el array de conexies del config.php
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return string | boolean
     */
    public static function getDSN($t) {
        switch ($t) {

            case 'mysql':
                return "mysql";

            case 'mssql':
                return 'dblib';

            case 'posgress':
                return 'pgsql';

            default:
                return 'dblib';
        }
    }

    /**
     * Conecta
     *
     * Crea un objeto de conexion PDO y lo almacena en la variable principal o
     * en el array de conexiones principales basado en el parametro $relatedName,
     * este es opcional.
     *
     * El array de datos $d debe tener la siguiente estructura:
     * array(
     *       'HOST_DB' => 'host direction',
     *       'USER_DB' => 'user',
     *       'PORT_DB' => port,
     *       'PASSWORD_DB' => 'pass',
     *       'DATABASE_DB' => 'databasename',
     *       'TYPE' => 'dsn'
     *   )
     *
     * En caso de que la conexion falle o el objeto de conexion este destruido
     * se intentará conectar hasta un maximo defido en $maxReconTy.
     *
     *
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param array $d
     * @param string $relatedName
     * @return boolean
     */
    public static function connect($d, $relatedName = false) {
        if (!$d || !is_array($d)) {
            return false;
        }
        $dsn = trim($d['TYPE']);
        $hostStr = "";

        if(strpos($d['HOST_DB'], '\\') !== false){
            $hostStr .= $d['HOST_DB'];
        }else{
            $hostStr .= "$d[HOST_DB]";
        }

        try {

            if ($relatedName) {
                Conn::$others[$relatedName] = new PDO("$dsn:host=$hostStr;dbname=$d[DATABASE_DB];charset=UTF-8;timeout=0;connect timeout=0", "$d[USER_DB]", "$d[PASSWORD_DB]");
                Conn::$others[$relatedName]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8
            } else {
		//exit("$dsn:host=$hostStr;dbname=$d[DATABASE_DB];charset=UTF-8;timeout=0;connect timeout=0");
        //Conn::$base = new PDO("$dsn:host=$hostStr;dbname=$d[DATABASE_DB];charset=UTF-8;timeout=0;connect timeout=0", "$d[USER_DB]", "$d[PASSWORD_DB]");
                Conn::$base = new PDO("mysql:host=$hostStr;dbname=$d[DATABASE_DB]", $d["USER_DB"], $d["PASSWORD_DB"]);
                Conn::$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Conn::$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return true;

        } catch (PDOException $e) {

            if(Conn::$reconects < Conn::$maxReconTy){
                Conn::$reconects ++;
                error_log(date('Y-m-d h:i:s'). " - Reintentando conexion   $d[HOST_DB] > $d[DATABASE_DB]  Intento numero: " . Conn::$reconects . "\n", 3, ERROR_LOGFILE);
                usleep(300000);
                Conn::connect($d,$relatedName);
            }else{
                error_log(date('Y-m-d h:i:s'). " - Conexion fallida a  $d[HOST_DB] > $d[DATABASE_DB] :" . $e->getMessage() . "\n", 3, ERROR_LOGFILE);
                DLOREAN_Model::showError('Error al conectar con la base de datos, por favor intente nuevamente onconnect.',9);
                return false;
            }

        }
    }

    /**
     * Obtiene credenciales
     *
     * Obtiene los datos de acceso a servidores vinculados en la tabla
     * cat_servidoresVinculados.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return boolean
     */
    public static function getLinkedServersCredentials() {
        $s = Conn::query("SELECT * FROM cat_servidoresVinculados;");

        if (!$s) {
            return false;
        }

        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
            Conn::$credentials[$row['sNombre']] = array(
                'HOST_DB' => $row['sIP'],
                'USER_DB' => $row['sUsuario'],
                'PORT_DB' => $row['iPuerto'],
                'PASSWORD_DB' => $row['sPassword'],
                'DATABASE_DB' => $row['sBDA'],
                'TYPE' => $row['sDSN']
            );
            Conn::$others[$row['sNombre']] = false;
        }

        return true;
    }

    /**
     * Consulta
     *
     * Ejecuta una consulta sql
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param string $sql Consulta SQL
     * @param string $db Nombre conexion a apuntar
     * @return boolean
     */
    public static function query($sql, $db = false) {
        $r = false;

        Conn::checkOnlineStatus($db);
        if (is_string($db)) {
            if (!array_key_exists($db, Conn::$others)) {
                error_log(date('Y-m-d h:i:s'). " - La base de datos $db no existe.",3, ERROR_LOGFILE);
                return false;
            }

            try {

                $r = Conn::$others[$db]->query($sql);
            } catch (PDOException $e) {
                error_log(date('Y-m-d h:i:s'). " - La consulta ha fallado: \n $sql \n<br>   ERROR: " . $e->getMessage() . "\n",3, ERROR_LOGFILE);
            }
        } else {
            try {
                $r = Conn::$base->query($sql);
            } catch (PDOException $e) {
                error_log(date('Y-m-d h:i:s'). " - La consulta ha fallado: \n $sql \n<br>   ERROR: " . $e->getMessage() . "\n",3, ERROR_LOGFILE);
                //echo "La consulta ha fallado: \n $sql \n<br>   ERROR: " . $e->getMessage() . "\n";
            }
        }
        return $r;
    }

    /**
     * Revisa conexion
     *
     * Determina si la conexion a base de datos esta activa e intenta
     * conectarse en caso de que no esté activa, si la reconexion falla
     * retornara un boleano y escribira en el log de errores que base de
     * datos ha fallado al conectar.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $dbn
     * @return boolean
     */
    public static function checkOnlineStatus($dbn = false) {
        if (!$dbn) {
            try {
                Conn::$base->query('SELECT 1');
                return true;
            } catch (PDOException $e) {

                error_log(date('Y-m-d h:i:s'). " - La conexion base no esta disponible reconectando..." . $e->getMessage() . "\n",3, ERROR_LOGFILE);
                DLOREAN_Model::showError('Error al conectar con la base de datos, por favor intente nuevamente oncheck.',true);
                Conn::initConn();
                return false;
            }
        } else {

            if (!Conn::$others[$dbn]) {
                Conn::connect(Conn::$credentials[$dbn], $dbn);
                return true;
            }

            if (Conn::$others[$dbn]->query('SELECT 1')) {
                return true;
            }
            try {
                Conn::connect(Conn::$credentials[$dbn]);
                return true;
            } catch (PDOException $e) {
                error_log(date('Y-m-d h:i:s'). " - La conexion $dbn no esta disponible..." . $e->getMessage(). "\n",3, ERROR_LOGFILE);
                DLOREAN_Model::showError('Error al conectar con base de datos externa.',10);
                return false;
            }
        }
    }

    /**
     * Iniciar transaccion
     *
     * Inicia una transaccion basado en el id, almacena el id de la transaccion y nombre
     * de la conexion a utilizar dentro de el arrat $trsLoc.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @global type $db_connections
     * @param string $tid Transaction ID
     * @param string $cnname Nombre de base de datos objetivo
     * @return boolean
     */
    public static function begin($tid, $cnname = false) {

        Conn::$trsLoc[$tid] = array('dbName' => $cnname, 'dsn' => false);
        $dsnTMode = false;

        if (!$cnname) {
            global $db_connections;
            $mcc = $db_connections[DEFAULT_CONNECTION][ENVIRONMENT];
            $mcc['TYPE'] = Conn::getDSN($mcc['TYPE']);
            Conn::$trsLoc[$tid]['dsn'] = $mcc['TYPE'];
            Conn::checkOnlineStatus();
            Conn::begingTransAs($tid);
        } else {

            //echo "<br> Begineando transaccion $cnname <br>";
            if (!array_key_exists($cnname, Conn::$others)) {
                Conn::$trsLoc = array();
                return false;
            }
            Conn::$trsLoc[$tid]['dsn'] = Conn::$credentials[$cnname]['TYPE'];
            Conn::checkOnlineStatus($cnname);
            Conn::begingTransAs($tid);
        }
    }

    /**
     * Ejecuta transaccion en base de datos.
     *
     * Utiliza el array $trsLoc para iniciar una transaccion con el ID y
     * la conexion especificada.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $tid
     * @return boolean
     */
    public static function begingTransAs($tid) {

        $dsn = Conn::$trsLoc[$tid]['dsn'];
        $dbTarget = null;

        if (!Conn::$trsLoc[$tid]['dbName']) {
            $dbTarget = &Conn::$base;
        } else {
            $dbTarget = &Conn::$others[Conn::$trsLoc[$tid]['dbName']];
        }

        switch ($dsn) {
            case 'dblib':
                $stmt = $dbTarget->prepare("BEGIN TRAN [$tid];");
                return $stmt->execute();
                break;
            case 'mysql':
                return $dbTarget->beginTransaction();
                break;
            default:
                return false;
        }
    }

    /**
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $tid
     * @return boolean
     */
    public static function commit($tid) {
        $dsn = Conn::$trsLoc[$tid]['dsn'];
        $dbTarget = null;

        if (!Conn::$trsLoc[$tid]['dbName']) {
            $dbTarget = &Conn::$base;
        } else {
            $dbTarget = &Conn::$others[Conn::$trsLoc[$tid]['dbName']];
        }

        switch ($dsn) {
            case 'dblib':
                $stmt = $dbTarget->prepare("COMMIT TRAN [$tid];");
                return $stmt->execute();
                break;
            case 'mysql':
                return $dbTarget->commit();
                break;
            default:
                return false;
        }
    }

    /**
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $tid
     * @return boolean
     */
    public static function rollback($tid) {
        $dsn = Conn::$trsLoc[$tid]['dsn'];
        $dbTarget = null;

        if (!Conn::$trsLoc[$tid]['dbName']) {
            $dbTarget = &Conn::$base;
        } else {
            $dbTarget = &Conn::$others[Conn::$trsLoc[$tid]['dbName']];
        }

        switch ($dsn) {
            case 'dblib':
                // echo "<br> Roleando pa traz la transaccion $tid";
                $stmt = $dbTarget->prepare("ROLLBACK TRAN [$tid];");
                return $stmt->execute();
                break;
            case 'mysql':
                return $dbTarget->rollBack();
                break;
            default:
                return false;
        }
    }

    /**
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $data
     * @return type
     */
    public static function fetch_assoc(&$data) {

        return $data->fetch(PDO::FETCH_ASSOC);
        //return $data->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $data
     * @return type
     */
    public static function fetch_assoc_all(&$data) {
        return $data->fetchall(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $data
     * @return type
     */
    public static function num_rows(&$data) {
        $c = count($data->fetchall());
        $data->execute();
        return $c;
    }

    /**
     * Cierra el cursor
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $data
     * @return type
     */
    public static function free_result(&$data) {
        return $data->closeCursor();
    }

    /**
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $data
     * @return type
     */
    public static function fetch_array(&$data) {
        return $data->fetch();
    }

    public static function num_fields($data) {
        return $data->columnCount();
    }

    public static function fetch_field(&$data) {
        return $data->getColumnMeta();
    }

    public static function testing() {

    }

}
