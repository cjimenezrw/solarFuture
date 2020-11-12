<?php

Class Inic_Model Extends DLOREAN_Model {

    // PUBLIC VARIABLES //
    // PUBLIC VARIABLES //
    public $venta = [];
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();
    protected $buscar = array();
    protected $data2 = array();
    protected $mail = array();
    protected $recuperar = array();
    protected $estadistica = array();

    public function __construct() {

    }

    public function __destruct() {

    }

    protected function verificar_usuario(&$data) {
        $secret = GR_SECRET_KEY;
        $user = str_replace("'", "", $data['usuario']);
        $pass = $data['password'];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,            'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $data['g-recaptcha-response']);
        curl_setopt($curl, CURLOPT_USERAGENT,      'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
        curl_setopt($curl, CURLOPT_REFERER,        'http://www.google.com');
        curl_setopt($curl, CURLOPT_ENCODING,       'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER,    TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT,        15);
        $htm = curl_exec($curl);
        curl_close($curl);

        $responseData = json_decode($htm);

        /*if (!$responseData->success) {
            return false;
        }*/

        $select = "SELECT skUsuario, salt, hash1 FROM cat_usuarios WHERE (sCorreo = '$user' OR sUsuario = '$user') AND (skEstatus = 'AC') LIMIT 1";


        $result = Conn::query($select);

        if ($result) {
            $row = Conn::fetch_assoc($result);
            if (count($row) > 0) {

                $hash = parent::desencriptar($pass, $row['salt']);

                if ($row['hash1'] == $hash) {
                    return $row['skUsuario'];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function verificar_perfil(&$skUsuario) {
        $select = "SELECT DISTINCT rup.skEmpresaSocio, rup.skUsuario,   ce.sNombre AS Empresa
        FROM rel_usuarios_perfiles rup
        INNER JOIN rel_empresasSocios re ON re.skEmpresaSocio = rup.skEmpresaSocio
        INNER JOIN cat_empresas ce ON ce.skEmpresa = re.skEmpresa
        WHERE rup.skUsuario = '" . $skUsuario . "'";
        $result = Conn::query($select);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    protected function verificar_perfil_mobile(&$skUsuario, $app) {
        $select = "SELECT rup.*, re.skEmpresaSocioPropietario,cp.sNombre, ce.sNombre AS Empresa, ca.skPerfil, rt.skToken
        FROM rel_usuarios_perfiles rup
        INNER JOIN core_perfiles cp ON cp.skPerfil = rup.skPerfil
        INNER JOIN rel_empresasSocios re ON re.skEmpresaSocio = rup.skEmpresaSocio
        INNER JOIN cat_empresas ce ON ce.skEmpresa = re.skEmpresa
        INNER JOIN rel_usuarios_token rt ON rt.skUsuarioperfil = rup.skUsuarioPerfil
        INNER JOIN core_aplicaciones_perfiles ca ON ca.skAplicacion = '" . $app . "'
        WHERE rup.skUsuario = '" . $skUsuario . "' AND rup.skPerfil = ca.skPerfil";
        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }
    }

    protected function datos_session(&$data) {
        $select = "SELECT DISTINCT cu.sTipoUsuario,
            cu.skUsuario,
            cu.sApellidoPaterno,
            cu.sApellidoMaterno,
            cu.sUsuario,
            cu.skGrupo,
            cu.skArea,
            cu.skDepartamento,
            cu.sFoto,
            cu.salt,
            cu.hash1,
            cu.sNombre AS nombreUsuario,
            cu.sCorreo AS correo,
            cu.skRolDigitalizacion,
            es.skEmpresaSocio,
            es.skEmpresa,
            es.skEmpresaSocioPropietario,
            ce.sNombre AS sEmpresa,
            rup.skUsuario,
            rcu.sValor AS CRYKEY,
            rcp.sValor AS PUEGEN
        FROM rel_usuarios_perfiles rup
        INNER JOIN cat_usuarios cu ON cu.skUsuario = rup.skUsuario
        INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = rup.skEmpresaSocio
        INNER JOIN cat_empresas ce ON ce.skEmpresa = es.skEmpresa
        LEFT JOIN rel_caracteristicasUsuarios_usuarios rcu ON rcu.skusuario = cu.skusuario AND rcu.skCaracteristicaUsuario = 'CRYKEY'
        LEFT JOIN rel_caracteristicasUsuarios_usuarios rcp ON rcp.skusuario = cu.skusuario AND rcp.skCaracteristicaUsuario = 'PUEGEN'
        WHERE rup.skUsuario = '" . $data['skUsuario'] . "'  AND  rup.skEmpresaSocio = '" . $data['skEmpresaSocio'] . "' ";

        $result = Conn::query($select);
        if ($result) {
            $row = Conn::fetch_assoc($result);
            if (count($row) > 0) {

                $hash = parent::desencriptar($data['password'], $row['salt']);
                if ($row['hash1'] == $hash) {
                    return $row;
                } else {
                    return false;
                }
            } else {
                return false;
            }


        } else {
            return false;
        }
    }



    protected function obtener_canales($skUsuario) {
        $select = "SELECT rup.skGrupoNotificacion
        FROM rel_gruposNotificaciones_usuarios  rup
        WHERE rup.skUsuario = '" . $skUsuario . "'";

        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }
    }

    protected function obtener_perfiles($skUsuario,$skEmpresaSocio) {
        $select = "SELECT rup.skPerfil
        FROM rel_usuarios_perfiles  rup
        WHERE rup.skUsuario = '" . $skUsuario . "' AND rup.skEmpresaSocio = '".$skEmpresaSocio."' ";

        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }
    }

    protected function obtener_servidores($sucursales) {
        $add_quotes = function ($value) {
            return sprintf("'%s'", $value);
        };

        $select = "SELECT sv.skServidorVinculado
        FROM rel_sucursales_servidoresVinculados  sv
        WHERE skSucursal  IN (" . implode(',', array_map($add_quotes, $sucursales)) . ")";

        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }
    }

    protected function obtener_rfcs($skGrupo) {
        $select = "SELECT DISTINCT ce.sRFC
        FROM rel_gruposEmpresas  rge
        INNER JOIN rel_empresasSocios res ON res.skEmpresaSocio = rge.skSocioEmpresa
        INNER JOIN cat_empresas ce ON ce.skEmpresa = res.skEmpresa
        WHERE rge.skGrupo = '" . $skGrupo . "'";
        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }
    }



    protected function obtener_rfc($skEmpresaSocio) {
        $select = "SELECT DISTINCT ce.sRFC
        FROM rel_empresasSocios res
        INNER JOIN cat_empresas ce ON ce.skEmpresa = res.skEmpresa
        WHERE res.skEmpresaSocio = '" . $skEmpresaSocio . "'";
        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }
    }

    protected function modulos_principales(&$data) {
        $select = "SELECT DISTINCT cm.skModulo,
                        cm.iPosicion,
                        cm.skModuloPadre,
                        cm.skModuloPrincipal,
                        cmi.sIcono,
                        cmi.sColor,
                        cm.sTitulo,
                        cm.sNombre
                        FROM core_modulos cm
                        INNER JOIN cat_usuarios cu ON cu.skUsuario='" . $_SESSION['usuario']['skUsuario'] . "'
                        LEFT JOIN core_modulos_iconos cmi ON cmi.skModulo = cm.skModulo
                        LEFT JOIN core_modulosPrincipales cmp ON cmp.skModuloPrincipal = cm.skModuloPrincipal
                        LEFT JOIN core_modulos_permisos_perfiles cmpp ON cmpp.skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ") AND cmpp.skModulo=cm.skModulo
                        WHERE   cm.skEstatus='AC'  AND cm.skModuloPadre = '" . $data['skModuloInicio'] . "'
                        " . (isset($_SESSION['usuario']) ? " AND (cu.sTipoUsuario='A' OR cmpp.skModulo IS NOT NULL)" : "") . "
                        ORDER BY cm.iPosicion ASC";


        $query = Conn::query($select);
        $data = array();
        foreach (Conn::fetch_assoc_all($query) as $result) {
            utf8($result);
            $data[$result['skModulo']] = array(
                'skModulo' => $result['skModulo'],
                'iPosicion' => $result['iPosicion'],
                'skModuloPadre' => $result['skModuloPadre'],
                'skModuloPrincipal' => $result['skModuloPrincipal'],
                'sNombre' => $result['sNombre'],
                'sTitulo' => $result['sTitulo'],
                'sIcono' => $result['sIcono'],
                'sColor' => $result['sColor'],
                'subMenu' => array()
            );
            $this->modulos_secundarios($result['skModulo'], $data);
        }
        $query->closeCursor();
        $result = $data;

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    protected function modulos_secundarios($skModuloPadre, &$data) {
        $select = "SELECT DISTINCT cm.skModulo,
        cm.iPosicion,
        cm.skModuloPadre,
        cm.skModuloPrincipal,
        cmi.sIcono,
        cm.sNombre,
        cm.sTitulo
       FROM core_modulos cm
       INNER JOIN cat_usuarios cu ON cu.skUsuario='" . $_SESSION['usuario']['skUsuario'] . "'
       LEFT JOIN core_modulos_iconos cmi ON cmi.skModulo = cm.skModulo
       LEFT JOIN core_modulos_caracteristicas MM ON MM.skModulo = cm.skModulo
       LEFT JOIN core_modulos_permisos_perfiles cmpp ON cmpp.skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ") AND cmpp.skModulo=cm.skModulo
       WHERE  cm.skModuloPadre = '" . $skModuloPadre . "' AND
       cm.skEstatus='AC'
       " . (isset($_SESSION['usuario']) ? " AND (cu.sTipoUsuario='A' OR cmpp.skModulo IS NOT NULL)" : "") . "
       ORDER BY cm.iPosicion ASC";

        $query = Conn::query($select);
        foreach (Conn::fetch_assoc_all($query) as $result) {
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
            $data[$skModuloPadre]['subMenu'][$result['skModulo']] = $datos;
        }
        $query->closeCursor();
    }

    protected function verificar_correo(&$data) {
        $correo = str_replace("'", "", $data['email']);
        $select = "SELECT TOP 1 sCorreo FROM cat_usuarios WHERE (sCorreo = '$correo') AND (skEstatus = 'AC')";

        $result = Conn::query($select);

        if ($result) {
            if (count($result->fetchall()) > 0) {
                $result->closeCursor();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function change_pass() {

        $sql = "EXECUTE stpC_nuevClave
            @token             = " . $this->data2['token'] . ",
            @salt              = " . $this->data2['salt'] . ",
            @hash              = " . $this->data2['hash'] . ",
            @skModulo          = 'inic-recu'";

        $result = Conn::query($sql);
        //$codigo = Conn::fetch_assoc($result);
        if (!$result) {
            return false;
        }
        return true;
    }

    public function verificar_token(&$data) {

        $token = str_replace("'", "", $data['token']);
        $select = "SELECT TOP 1 rp.skUsuario, rp.sToken, u.sUsuario
            FROM rel_usuarios_recuperarPassword rp
            INNER JOIN cat_usuarios u ON u.skUsuario = rp.skUsuario
            WHERE u.skEstatus = 'AC' AND rp.sToken = ".escape($token);

        $result = Conn::query($select);

        if ($result) {
            $row = Conn::fetch_assoc($result);
            $result->closeCursor();
            if (count($row) > 0) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function save_recu() {

        $sql = "EXECUTE stpC_recClave
            @mail             = " . $this->mail['email'] . ",
            @sIP              = " . $this->mail['sIP'] . ",
            @skModulo         = 'inic-recu'";

        $result = Conn::query($sql);

        if (!$result) {
            return false;
        }

        $row = Conn::fetch_assoc($result);
        $result->closeCursor();
        return $row["sToken"];
    }

    public function buscar_modulo() {

        $sql = "SELECT DISTINCT cm.skModulo,
            cm.iPosicion,
            cm.skModuloPadre,
            cm.skModuloPrincipal,
            cmi.sIcono,
            cm.sTitulo,
            cm.sNombre
            FROM core_modulos cm
            INNER JOIN cat_usuarios cu ON cu.skUsuario='" . $_SESSION['usuario']['skUsuario'] . "'
            LEFT JOIN core_modulos_iconos cmi ON cmi.skModulo = cm.skModulo
            LEFT JOIN core_modulos_permisos_perfiles cmpp ON cmpp.skPerfil IN (".mssql_where_in($_SESSION['usuario']['perfiles']). ") AND cmpp.skModulo=cm.skModulo
            WHERE   cm.skEstatus='AC'
            " . (isset($_SESSION['usuario']) ? " AND (cu.sTipoUsuario='A' OR cmpp.skModulo IS NOT NULL)" : "") . "
            AND cm.sTitulo LIKE '%" . ($this->buscar['sBuscar'] ? $this->buscar['sBuscar'] : '') . "%'
            ORDER BY cm.iPosicion ASC";

        $query = Conn::query($sql);
        if ($query) {
            $records = Conn::fetch_assoc_all($query);
            if (count($records) > 0) {
                return $records;
            } else {
                return false;
            }
        }
        return false;
    }

    public function cargar_Mapa() {
        $sql = "CALL stpPermisosGenerales (
            /*@sModulo      = */'prin-inic',
            /*@iNivel         = */0,
            /*@skEmpresaSocio = */'" . $_SESSION['usuario']['skEmpresaSocio'] . "',
            /*@skPerfil       = */NULL,
            /*@skUsuario      = */'" . $_SESSION['usuario']['skUsuario'] . "')";

        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function estadistica_accesos() {
        $sql = "EXECUTE stpEstadisticaAccessos
                @skUsuario      = " . escape($this->estadistica['skUsuario']) . ",
                @skModulo       = " . escape($this->estadistica['skModulo']) . ",
                @tBase          = " . escape($this->estadistica['tBase']) . ",
                @tPeriodo       = " . escape($this->estadistica['tPeriodo']) . "";
        $result = Conn::query($sql);
        /*
          $sql="EXECUTE stpEstadisticaPedimentosPagados
          @skEjecutivo      = ".escape($this->estadistica['skEjecutivo']).",
          @sRazonSocial       = ".escape($this->estadistica['sRazonSocial']).",
          @tBase          = ".escape($this->estadistica['tBase']).",
          @tPeriodo       = ".escape($this->estadistica['tPeriodo'])."";
          $result = Conn::query($sql); */
        if (!$result) {
            return false;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function get_tokenDevice() {
        $sql = "EXECUTE stpC_loginDispositivo
            @sModelo            = " . escape($this->device['sModelo']) . ",
            @skUsuario          = " . escape($this->device['skUsuario']) . ",
            @sOperadora         = " . escape($this->device['sOperadora']) . ",
            @skAplicacion       = " . escape($this->device['skAplicacion']) . ",
            @sOsVersion         = " . escape($this->device['sOsVersion']) . ",
            @sVersionApp        = " . escape($this->device['sVersionApp']) . ",
            @sIdPlayer          = " . escape($this->device['sIdPlayer']) . ",
            @sIdGcm             = " . escape($this->device['sIdGcm']) . ",
            @sIdDispositivo     = " . escape($this->device['sIdDispositivo']);

        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        return $record['sToken'];
    }

    public function remove_tokenDevice()
    {
        $sql = "DELETE FROM rel_dispositivo_token
			WHERE skDispositivoToken = " . escape($this->device['skDispositivoToken']) . " AND sIdDispositivo = " . escape($this->device['sIdDispositivo']) . " ";

        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
        return true;
    }

    protected function contactos_chat()
    {

        $add_quotes = function($value) {
        return sprintf("'%s'", $value);
        };
        $skuser = $_SESSION['usuario']['skUsuario'];
        $skEmpresaSocio = $_SESSION['usuario']['skEmpresaSocio'];
        $arrayEmpresaPropietario = array();
        $selectPropietario = "SELECT DISTINCT res.skEmpresaSocioPropietario AS socioPropietario
                            FROM rel_usuarios_perfiles rup
                             INNER JOIN rel_empresasSocios res ON res.skEmpresaSocio = rup.skEmpresaSocio
                             WHERE rup.skUsuario = '" . $skuser . "'  AND res.skEmpresaTipo = 'PROP' ";

        $result = Conn::query($selectPropietario);
        $propietarios = Conn::fetch_assoc_all($result);
        foreach ($propietarios as $rowPropietarios) {
            if ($rowPropietarios['socioPropietario']) {
                $arrayEmpresaPropietario[$rowPropietarios['socioPropietario']] = $rowPropietarios['socioPropietario'];
            }
        }

        $select = "SELECT DISTINCT n1.* FROM (
SELECT cu.skUsuario, cu.sNombre, cu.sApellidoPaterno, cu.sApellidoMaterno, cu.sFoto, cu.sCorreo, ca.sNombre AS skArea, cd.sNombre AS skDepartamento, RUE.sNombre AS extension, (
SELECT count(*) FROM core_chats cc WHERE cc.skUsuarioEmisor = cu.skUsuario AND cc.skEstatus = 'NL' AND cc.skUsuarioRemitente = '" . $skuser . "') AS NL,
 ( SELECT sMensaje FROM cat_chatLastMessage cc1
 WHERE (cc1.skConversation = CONCAT(cu.skUsuario, '-', '" . $skuser . "') OR cc1.skConversation = CONCAT('" . $skuser . "', '-', cu.skUsuario) ) ) AS mensaje
 FROM cat_usuarios cu
 INNER JOIN rel_usuarios_perfiles rup ON rup.skUsuario = cu.skUsuario AND rup.skEmpresaSocio IN (".implode(',', array_map($add_quotes,$arrayEmpresaPropietario)).")
 LEFT JOIN cat_usuarios RUE ON RUE.skUsuario = cu.skUsuario
 INNER JOIN cat_areas ca ON ca.skArea = cu.skArea
 INNER JOIN cat_departamentos cd ON cd.skDepartamento = cu.skDepartamento
 WHERE NOT cu.skUsuario = '" . $skuser . "')  AS n1
 ORDER BY n1.NL DESC, n1.sNombre ASC";

        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }

    }

    protected function acciones_panel()
    {
        $skuser = $_SESSION['usuario']['skUsuario'];
        $select = "SELECT TOP 10 au.sDescripcion, au.dFechaCreacion, cu.sNombre as sNombre
                    FROM core_acciones_usuarios au
                    INNER JOIN cat_usuarios cu ON au.skUsuario = cu.skUsuario
                    WHERE au.skUsuario = '$skuser'
                    ORDER BY dFechaCreacion DESC";

        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);;
        } else {
            return false;
        }

    }

    protected function noti_settings()
    {
        $skuser = $_SESSION['usuario']['skUsuario'];
        $select = "SELECT cn.sDescripcion, cn.skTipoNotificacion, cn.sNombre, cm.skUsuario
        FROM cat_notificacionesTipos cn
        LEFT JOIN rel_notificacionesMensajes_usuariosAjustes cm ON cm.skUsuario = '$skuser' AND cm.skTipoNotificacion = cn.skTipoNotificacion
        WHERE cn.skEstatus = 'AC' AND cn.iObligatoria = 0 ORDER BY cn.sNombre ASC";

        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }

    }

    protected function noti_config()
    {
        $skuser = $_SESSION['usuario']['skUsuario'];

        $sql = "EXECUTE stpCD_notiConfig
            @skTipoNotificacion     = " . escape($this->config['id']) . ",
            @skusuario              = " . escape($skuser) . ",
            @estatus                = " . escape($this->config['estatus']);

        $result = Conn::query($sql);
        if ($result) {
            $channels = array();
            foreach(Conn::fetch_assoc_all($result) AS $row){
                array_push($channels,$row['skGrupoNotificacion']);
            }
            return $channels;
        } else {
            return false;
        }

    }

    protected function save_message()
    {
        $skuser = $_SESSION['usuario']['skUsuario'];

        $skConversation = array($skuser, $this->message['skUsuarioRemitente']);
        sort($skConversation);
        $skConversation = implode("-",$skConversation);
        $removeLineBreaks = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', $this->message['sMensaje']);
        $shorMessage = substr($removeLineBreaks, 0, 50);

        $sql = "EXECUTE stpC_chats
            @skUsuarioEmisor          = " . escape($skuser) . ",
            @sMensaje                 = " . escape($this->message['sMensaje']) . ",
            @skConversation           = " . escape($skConversation) . ",
            @sMensajeCorto            = " . escape($shorMessage) . ",
            @skUsuarioRemitente       = " . escape($this->message['skUsuarioRemitente']);

        $result = Conn::query($sql);
        if (!$result) {
            return false;
        }
       $record = Conn::fetch_assoc($result);
        return $record['skChat'];
    }

    protected function get_messages()
    {

        $skuser = $_SESSION['usuario']['skUsuario'];

        $select = "SELECT TOP 30 cc.sMensaje, cc.dFechaCreacion, cc.skUsuarioEmisor, cu.sFoto
                FROM
                    core_chats cc
                    INNER JOIN cat_usuarios cu ON cc.skUsuarioEmisor = cu.skUsuario
                WHERE
                    (
                        skUsuarioEmisor = '" . $skuser . "'
                        AND skUsuarioRemitente = '" . $this->message['skUsuario'] . "'
                    )
                OR (
                    skUsuarioEmisor = '" . $this->message['skUsuario'] . "'
                    AND skUsuarioRemitente = '" . $skuser . "'
                )
                ORDER BY
                    dFechaCreacion DESC";

        $result = Conn::query($select);
        if ($result) {
            return Conn::fetch_assoc_all($result);
        } else {
            return false;
        }

    }

    protected function read_messages()
    {
        $skuser = $_SESSION['usuario']['skUsuario'];

        $select = "UPDATE core_chats SET skEstatus = 'LE' WHERE skEstatus = 'NL' AND skUsuarioRemitente = '" . $skuser . "'
        AND skUsuarioEmisor = '" . $this->message['skUsuario'] . "';";
        $result = Conn::query($select);
        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * getPublicacionCommentTree
     *
     * Genera el arbol de comentarios de una publicacion, añade votos
     * obtenidos con <b><i>getVotes</i></b> ordenados por skComentario.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $skPublicacion
     * @return boolean | array
     */
    protected function getCommentTree($skPublicacion) {

        $c = Conn::query("SELECT
            rpc.*,
            c_u.sUsuario,
            c_u.sFoto,
            c_u.sNombre,
            c_u.sApellidoPaterno,
            c_u.sApellidoMaterno,
            c_u.sApellidoMaterno,
            CONCAT(c_u.sNombre, ' ',c_u.sApellidoPaterno ) as sNombres
        FROM
            rel_publicaciones_comentarios rpc
        INNER JOIN cat_usuarios c_u ON
            rpc.skUsuarioCreacion = c_u.skUsuario
        WHERE
            rpc.skPublicacion = $skPublicacion OR
            rpc.skIdentificador = $skPublicacion
        ORDER BY
            skComentarioPadre ASC,
            dFechaCreacion ASC	");

        if (!$c) {
            return false;
        }

        $cp = [];
        $poolCm = Conn::fetch_assoc_all($c);
        $tcp = count($poolCm);

        foreach ($poolCm as $leCom) {
            utf8($leCom);
            $leCom['respuestas'] = [];
            $leCom['votes'] = [];
            $leCom['dFechaCreacion'] = date('d/m/Y h:i:s', strtotime($leCom['dFechaCreacion']));
            $leCom['totalComments'] = $tcp;

            $fullNameImage = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . DIR_PATH . 'core/assets/profiles/' . $leCom['sFoto'];
            $leCom['fotoPerfil'] = ( file_exists($fullNameImage) && !empty($leCom['sFoto']) ? SYS_URL . 'core/assets/profiles/' . $leCom['sFoto'] : SYS_URL . 'core/assets/tpl/global/portraits/user.png' );

            if (isset($this->data['votes'][$leCom['skComentario']])) {
                $leCom['votes'] = $this->data['votes'][$leCom['skComentario']];
            }

            if (empty($leCom['skComentarioPadre'])) {
                $cp[$leCom['skComentario']] = $leCom;
                continue;
            }

            array_push($cp[$leCom['skComentarioPadre']]['respuestas'], $leCom);
        }

        return $cp;
    }

     
}
