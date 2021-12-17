<?php

Class Inic_dash_Controller Extends Inic_Model {

    // PUBLIC VARIABLES //

    use AutoCompleteTrait;

    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    /**
     * Guardar Registros de Usuarios Por Modulos
     *
     * Retorna codigos de Registro skFiltroUsuario
     *
     * Argumentos pasados mediente $_POST o $_GET
     *
     * [
     *  'sNombre' => "Informacion del Filtro,
     *  'sJsonfiltro' => JSON con filtros guardados
     * ]
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param $_POST o $_GET
     * @return string skFiltroUsuario.
     */
    public function saveFilters() {

        $skFiltroUsuario    = (isset($_POST['skFiltroUsuario']) ? $_POST['skFiltroUsuario'] : (isset($_GET['skFiltroUsuario']) ? $_GET['skFiltroUsuario'] : NULL));
        $sNombre            = (isset($_POST['sNombre']) ? $_POST['sNombre'] : (isset($_GET['sNombre']) ? $_GET['sNombre'] : NULL));
        $sJsonfiltro        = (isset($_POST['sJson']) ? $_POST['sJson'] : (isset($_GET['sJson']) ? $_GET['sJson'] : NULL));
        $skModulo        = (isset($_POST['skModulo']['skModulo']) ? $_POST['skModulo']['skModulo'] : (isset($_GET['skModulo']['skModulo']) ? $_GET['skModulo']['skModulo'] : NULL));

        $sql = "EXECUTE stpC_usuariosFiltros
        @skFiltroUsuario            = " .escape($skFiltroUsuario) . ",
        @sNombre                    = " .escape($sNombre) . ",
        @sJsonfiltro                = " . escape($sJsonfiltro) . ",
        @skUsuario                  = '" . $_SESSION['usuario']['skUsuario'] . "',
        @skModulo                   = " . escape($skModulo) . "";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        return true;
    }


    public function getFilters() {
        $skModulo        = (isset($_POST['skModulo']['skModulo']) ? $_POST['skModulo']['skModulo'] : (isset($_GET['skModulo']['skModulo']) ? $_GET['skModulo']['skModulo'] : NULL));
        $select = " SELECT * FROM rel_usuariosFiltros_modulos WHERE skUsuarioCreacion = '" . $_SESSION['usuario']['skUsuario'] . "' AND skModulo = '".$skModulo."'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc_all($result);
        //utf8($record);
        return json_encode($record);

    }

    public function removeFilters() {
        $skFiltroUsuario        = (isset($_POST['skFiltroUsuario']) ? $_POST['skFiltroUsuario'] : (isset($_GET['skFiltroUsuario']) ? $_GET['skFiltroUsuario'] : NULL));
        $select = " DELETE FROM rel_usuariosFiltros_modulos WHERE skFiltroUsuario = '" . $skFiltroUsuario . "'";
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        return TRUE;

    }
    public function datosInicial(){
        $this->data['ventaGeneral'] = [];
        

        return $this->data; 
    }

    public function countNotifications() {

        $skUsuario = $_SESSION['usuario']['skUsuario'];
 
 
        $selecttl = "SELECT COUNT(*) AS total 
            FROM rel_notificaciones_usuarios rnu 
            WHERE rnu.skUsuario = ".escape($skUsuario)." AND rnu.skEstatus = 'EN'";
         
        $sql = Conn::query($selecttl);
        $row = Conn::fetch_assoc($sql);
         $total = $row['total'];
     

        $ok = 1;
        $success = true;
        $result = compact("ok", "success", "total");
        
        return $result;
    }

    public function listNotifications()
    {
        $skUsuario      = $_SESSION['usuario']['skUsuario'];
        $skEstatus      = (isset($_POST['skEstatus']) ? $_POST['skEstatus'] : (isset($_GET['skEstatus']) ? $_GET['skEstatus'] : NULL));
 
        $query = "SELECT   cn.dFechaCreacion AS dFechaCreacion, rnu.skEstatus AS skEstatus, rnu.skNotificacion AS skNotificacion, cn.sMensaje AS sMensaje, cn.sNombre AS sNombre, 
                          cn.sIcono AS sIcono, cn.skComportamientoModulo AS skComportamiento, cn.sColor AS sColor, cn.sUrl AS sUrl, cn.sValores AS sValores
                          FROM rel_notificaciones_usuarios rnu
                          INNER JOIN core_notificaciones cn ON cn.skNotificacion = rnu.skNotificacion
                          AND rnu.skUsuario = '$skUsuario'";
 

        if ($skEstatus) {
            $query .= " AND rnu.skEstatus ='" . $skEstatus . "' ";
        }
        $query .= "ORDER BY cn.dFechaCreacion DESC LIMIT 20 ";
    
        $sql = Conn::query($query);
        $dt = Conn::fetch_assoc_all($sql);
        $ok = 1;
        $success = true;

        if (count($dt) > 0) {
            $skNoti = array();
            $i = 0;
            foreach ( $dt as $row) {

                utf8($row, FALSE);
                $date = strtotime($row['dFechaCreacion']);

                if ($date >= strtotime("today"))
                    $date = "Hoy a las " . date('H:i:s', $date);
                else if ($date >= strtotime("yesterday"))
                    $date = "Ayer a las " . date('H:i:s', $date);
                else
                    $date = $row['dFechaCreacion'] ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : '';

                $skNoti[$i] = array(
                    'sNombre'       => $row['sNombre'],
                    'sMensaje'      => $row['sMensaje'], 
                    'sIcono'        => $row['sIcono'],
                    'skComportamiento' => $row['skComportamiento'],
                    'sColor'        => $row['sColor'],
                    'sUrl'          => $row['sUrl'],
                    //'sValor' => (isset(json_decode($row['sValores'], true)['skTrackingPedimento'])) ? json_decode($row['sValores'], true)['skTrackingPedimento'] : $row['sValores'],
                    'sValor'        => json_decode($row['sValores']),
                    'skNotificacion' => $row['skNotificacion'],
                    'dFechaCreacion' => $date,
                    'skEstatus' => $row['skEstatus']
                );
                $i++;
            }
            $data = $skNoti;
            $result = compact("ok", "success", "data");
         
            return $result;
        } else {
            $data = false;
            $result = compact("ok", "success", "data");
         
            return $result;
        }
    }

    public function readNotification() {
        $skNotificacion = (isset($_POST['skNotificacion']) ? $_POST['skNotificacion'] : (isset($_GET['skNotificacion']) ? $_GET['skNotificacion'] : NULL));

        $query = "UPDATE rel_notificaciones_usuarios SET skEstatus = 'LE' WHERE skNotificacion = '$skNotificacion' AND skUsuario = '" . $_SESSION['usuario']['skUsuario'] . "'";
        $sql = Conn::query($query);

        if ($sql) { 
            $ok = 1;
            $success = true;
            $result = compact("ok", "success");
            return $result;
        } 
        $ok = 0;
        $success = false;
        $result = compact("ok", "success");
        return $result;
    }

}
