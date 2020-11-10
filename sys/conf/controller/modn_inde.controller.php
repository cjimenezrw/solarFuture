<?php

Class Modn_inde_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function consultar() {
        $configuraciones = array();
        $configuraciones['query'] = "SELECT cmn.*, 
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
            INNER JOIN core_estatus est ON est.skEstatus = cmn.skEstatus";

        $data = parent::crear_consulta($configuraciones);

        if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
            return $data['data'];
        }

        $result = $data['data'];
        $data['data'] = array();
        foreach (Conn::fetch_assoc_all($result) AS $row) {
            utf8($row);
            $regla = array();
            
            $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
            $row['menuEmergente'] = parent::menuEmergente($regla, $row['skModuloDetalle']);
            array_push($data['data'],$row);
        }
        return $data;
    }

    public function generarExcel() {
        parent::generar_excel($_POST['title'], $_POST['headers'], $this->consultar());
    }

    public function generarPDF() {
        parent::generar_pdf($_POST['title'], $_POST['headers'], $this->consultar());
    }

}