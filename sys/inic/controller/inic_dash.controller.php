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
        $this->data['ventaGeneral'] = parent::consultaVenta();
        $this->venta['skTipoCaja'] = '95E4D624-DAF5-45A8-9F88-AA7D990B9809';
        $this->data['caja1'] = parent::consultaVenta();
        $this->venta['skTipoCaja'] = '57CADC4F-DD40-4023-81AE-5C8D9C117769';
        $this->data['caja2'] = parent::consultaVenta();
        $this->venta['skTipoCaja'] = '88894A41-FFEA-4507-8AD6-95CA8FB61E4A';
        $this->data['caja3'] = parent::consultaVenta();


        return $this->data;
        return true;
    }

}
