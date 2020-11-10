<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 15/02/2017
 * Time: 05:16 PM
 */
Class Inic_slid_Controller Extends Inic_Model
{
    // PUBLIC VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct()
    {
        parent::init();
    }

    public function __destruct()
    {

    }

    public function getContactList()
    {

        require_once(CORE_PATH . 'src/notifications/pusher/Pusher.php');
        $options = array(
            'encrypted' => true
        );
        $pusher = new Pusher(
            PUSHER_KEY, // APP_KEY
            PUSHER_SECRET, // APP_SECRET
            PUSHER_APP_ID, // APP_ID
            $options // OPTIONS
        );
        $channs = (array)$pusher->get_channels()->channels;

        $ok = 1;
        $success = true;
        $contactList = parent::contactos_chat();
        $contacts = array();

        //$removeUrl = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";

        function parseUrl($string)
        {
            return $string;
            $ext = array('.jpg', '.png', '.gif', 'youtube');
            foreach ($ext as $bad) {
                $place = strpos(strtolower($string), $bad);
                if (!empty($place)) {
                    return '<b>Imagen</b>';
                }
            }
            return $string;
        }

        function array_orderby()
        {
            $args = func_get_args();
            $data = array_shift($args);
            foreach ($args as $n => $field) {
                if (is_string($field)) {
                    $tmp = array();
                    foreach ($data as $key => $row)
                        $tmp[$key] = $row[$field];
                    $args[$n] = $tmp;
                }
            }
            $args[] = &$data;
            call_user_func_array('array_multisort', $args);
            return array_pop($args);
        }

        if ($contactList) {
            //While para pintar los contactos
            $i = 0;
            foreach ($contactList as $row2) {
               utf8($row2, false);

                if(array_key_exists($row2['skUsuario'], $channs)) {
                    $status = "1";
                }else{
                    $status = "0";
                }
                //$row2 = array_map("htmlentities", $row2);
                $messageString = ($row2['mensaje']);
                //$messageString = htmlentities($row2['mensaje']);
                $contacts[$i] = array(
                    'sNombre' => $row2['sNombre'],
                    'sApellidoPaterno' => $row2['sApellidoPaterno'],
                    'skUsuario' => $row2['skUsuario'],
                    'sCorreo' => $row2['sCorreo'],
                    'skArea' => $row2['skArea'],
                    'extension' => ($row2['extension'] ? $row2['extension']: 'N/D'),
                    'skDepartamento' => $row2['skDepartamento'],
                    'mensaje' => ($messageString != null) ? parseUrl($messageString) : 'No hay conversación',
                    'NL' => $row2['NL'],
                    'status' => $status,
                    'sFoto' => $row2['sFoto'] ? ASSETS_PATH . 'profiles/' . $row2['sFoto'] : ASSETS_PATH . 'tpl/' . 'global/portraits/user.png',
                );
                $i++;
            }
        } else {
            $ok = 0;
            $success = false;
            $result = compact("ok", "success");
            return $result;
        }
        $sorted = array_orderby($contacts, 'NL', SORT_DESC, 'status', SORT_DESC);
        $data = $sorted;
        $result = compact("ok", "success", "data");
        //exit(print_r($result));
        return $result;
    }

    public function getActionsList()
    {
        $ok = 1;
        $success = true;
        $actionsList = parent::acciones_panel();
        $actions = array();
        if ($actionsList) {
            //While para pintar los contactos
            $i = 0;
            foreach ($actionsList as $row) {

                $actions[$i] = array(
                    'sDescripcion' => $row['sDescripcion'],
                    'sNombre' => $row['sNombre'],
                    'dFechaCreacion' => ($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '')
                );
                $i++;
            }
        } else {
            $ok = 0;
            $success = false;
            $result = compact("ok", "success");
            return $result;
        }
        $data = $actions;
        $result = compact("ok", "success", "data");
        return $result;
    }

    public function sendMessage()
    {
        require_once(CORE_PATH . 'src/Crypto/cryptojs-aes.php');

        function parseUrl($string)
        {
            return $string;
            $regex = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
            $url = preg_replace($regex, 'http$2://$4', $string);

            $ext = array('.jpg', '.png', '.gif', 'youtube');
            foreach ($ext as $bad) {
                $place = strpos(strtolower($string), $bad);
                if (!empty($place)) {
                    return $url;
                }
            }
            return preg_replace($regex, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $url);
        }

        $this->message['sMensaje'] = (isset($_POST['sMensaje']) ? $_POST['sMensaje'] : (isset($_GET['message']) ? $_GET['sMensaje'] : NULL));
        $this->message['messageOriginal'] = (isset($_POST['messageOriginal']) ? $_POST['messageOriginal'] : (isset($_GET['messageOriginal']) ? $_GET['messageOriginal'] : NULL));
        $this->message['skUsuarioRemitente'] = (isset($_POST['skUsuarioRemitente']) ? $_POST['skUsuarioRemitente'] : (isset($_GET['skUsuarioRemitente']) ? $_GET['skUsuarioRemitente'] : NULL));

        $q = "SELECT sValor FROM rel_caracteristicasUsuarios_usuarios rcu WHERE rcu.skusuario = '" . $this->message['skUsuarioRemitente'] . "' AND rcu.skCaracteristicaUsuario = 'CRYKEY'";

        $result = Conn::query($q);
        if (!$result) {
            return false;
        }
        $record = Conn::fetch_assoc($result);
        $CRYKEY = ($record['sValor'] ? $record['sValor'] : $this->message['skUsuarioRemitente']);

        $actionsList = parent::save_message();
        //$actions = array();

        if (!$actionsList) {
            $ok = 0;
            $success = false;
            $result = compact("ok", "success");
            return $result;
        }

        require_once(CORE_PATH . 'src/notifications/pusher/Pusher.php');

        $options = array(
            'encrypted' => true
        );

        $pusher = new Pusher(
            PUSHER_KEY, // APP_KEY
            PUSHER_SECRET, // APP_SECRET
            PUSHER_APP_ID, // APP_ID
            $options // OPTIONS
        );

        $messageHtml = htmlentities($this->message['sMensaje']);
        $messageOriginal = htmlentities($this->message['messageOriginal']);

        $ok = 1;
        $success = true;
        $dFechaCreacion = date('d/m/Y H:i:s');
        $message = nl2br($messageHtml);
        $shortMessage = (strlen($messageOriginal) > 23) ? substr($messageOriginal, 0, 21) . '...' : $messageOriginal;
        $emisor = $_SESSION['usuario']['skUsuario'];
        $user = $_SESSION['usuario']['sNombreUsuario'];
        $skTipoNotificacion = 'CHAT';
        $img = $_SESSION['usuario']['sFoto'] ? ASSETS_PATH . 'profiles/' . $_SESSION['usuario']['sFoto'] : ASSETS_PATH . 'tpl/' . 'global/portraits/user.png';

        $user = html_entity_decode($user);
        $shortMessage = html_entity_decode($shortMessage);

        /*        $notificacion['dFechaCreacion'] = date('d/m/Y H:i:s');
                $notificacion['message'] = $this->message['sMensaje'];
                $notificacion['shortMessage'] = (strlen($this->message['sMensaje']) > 23) ? substr($this->message['sMensaje'],0,21).'...' : $this->message['sMensaje'];
                $notificacion['emisor'] = $_SESSION['usuario']['skUsuario'];
                $notificacion['user'] = $_SESSION['usuario']['sNombreUsuario'];
                $notificacion['skTipoNotificacion'] = 'CHAT';
                $notificacion['img'] = $_SESSION['usuario']['sFoto'] ? ASSETS_PATH . 'profiles/' . $_SESSION['usuario']['sFoto'] : ASSETS_PATH . 'tpl/' . 'global/portraits/user.png';*/

        $result = json_encode(compact("ok", "success", "dFechaCreacion", "message", "shortMessage", "emisor", "user", "skTipoNotificacion", "img"));

        //exit($result);

        $pusher->trigger($this->message['skUsuarioRemitente'], 'notify', cryptoJsAesEncrypt($CRYKEY, $result));

        $data['img'] = $_SESSION['usuario']['sFoto'] ? ASSETS_PATH . 'profiles/' . $_SESSION['usuario']['sFoto'] : ASSETS_PATH . 'tpl/' . 'global/portraits/user.png';
        $data['dFechaCreacion'] = date('H:i');
        $data['sMensaje'] = nl2br($messageHtml);
        $result = compact("ok", "success", "data");
        return $result;
    }

    public function getMessages()
    {
        function parseUrl($string)
        {
            return $string;
            $regex = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
            $url = preg_replace($regex, 'http$2://$4', $string);

            $ext = array('.jpg', '.png', '.gif', 'youtube');
            foreach ($ext as $bad) {
                $place = strpos(strtolower($string), $bad);
                if (!empty($place)) {
                    return $url;
                }
            }
            return preg_replace($regex, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $url);
        }

        $this->message['skUsuario'] = (isset($_POST['skUsuario']) ? $_POST['skUsuario'] : (isset($_GET['skUsuario']) ? $_GET['skUsuario'] : NULL));

        $ok = 1;
        $success = true;
        $messagesList = parent::get_messages();
        //die(print_r($messagesList));
        $messages = array();

        utf8($messagesList, false);

        if ($messagesList) {

            $i = 0;
            foreach ($messagesList as $row) {

                $emisor = 0;
                if ($row['skUsuarioEmisor'] == $_SESSION['usuario']['skUsuario']) {
                    $emisor = 1;
                }

                $messages[$i] = array(
                    'sMensaje' => nl2br(parseUrl(htmlentities($row['sMensaje']))),
                    'emisor' => $emisor,
                    'sFoto' => $row['sFoto'] ? ASSETS_PATH . 'profiles/' . $row['sFoto'] : ASSETS_PATH . 'tpl/' . 'global/portraits/user.png',
                    'dFechaCreacion' => ($row['dFechaCreacion'] ? date('d/m/y  H:i', strtotime($row['dFechaCreacion'])) : '')
                );
                $i++;
            }
        } else {
            $ok = 0;
            $success = false;
            $data = $messages;
            $result = compact("ok", "success", "data");
            return $result;
        }

        if (parent::read_messages())

            $data = $messages;
        $result = compact("ok", "success", "data");
        return $result;
    }

    public function countMessages()
    {
        $skUsuario = (isset($_POST['skUsuario']) ? $_POST['skUsuario'] : (isset($_GET['skUsuario']) ? $_GET['skUsuario'] : $_SESSION['usuario']['skUsuario']));

        $selecttl = "SELECT COUNT(*) AS total FROM core_chats WHERE skUsuarioRemitente = '$skUsuario' AND skEstatus = 'NL'";
        $sql = Conn::query($selecttl);
        $row = Conn::fetch_assoc($sql);
        $sql->closeCursor();
        $total = $row['total'];
        $ok = 1;
        $success = true;
        $result = compact("ok", "success", "total");
        return $result;
    }

    public function notiSettings()
    {
        $ok = 1;
        $success = true;
        $actionsList = parent::noti_settings();
        $actions = array();
        if ($actionsList) {
            //While para pintar los contactos
            $i = 0;
            foreach ($actionsList as $row) {

                $actions[$i] = array(
                    'sNombre' => $row['sNombre'],
                    'skTipoNotificacion' => $row['skTipoNotificacion'],
                    'sDescripcion' => $row['sDescripcion'],
                    'val' => ($row['skUsuario'] ? '' : 'checked')
                );
                $i++;
            }
        } else {
            $ok = 0;
            $success = false;
            $result = compact("ok", "success");
            return $result;
        }
        $data = $actions;
        $result = compact("ok", "success", "data");
        return $result;
    }

    public function notiConfigChange()
    {
        $this->config['id'] = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));
        $this->config['estatus'] = (isset($_POST['estatus']) ? $_POST['estatus'] : (isset($_GET['estatus']) ? $_GET['estatus'] : NULL));

        $ok = 1;
        $success = true;
        $res = parent::noti_config();
        if (!$res) {
            $ok = 0;
            $success = false;
            $result = compact("ok", "success","res");
            return $result;
        }
        if($this->config['estatus'] === 'true'){
            foreach($res AS $row){
                $_SESSION['usuario']['canales'][$row] = $row;
            }
        }else{
            foreach($res AS $row){
                unset($_SESSION['usuario']['canales'][$row]);
            }
        }
        $result = compact("ok", "success","res");
        return $result;
    }

}
