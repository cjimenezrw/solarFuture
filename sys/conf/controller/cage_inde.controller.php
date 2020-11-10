<?php

Class Cage_inde_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function getCatalogosGenerales() {

        $configuraciones = array();
        $configuraciones['query'] = " SELECT ccs.*, ce.sNombre AS Estatus, cu.sNombre AS usuarioCreacion
            FROM cat_catalogosSistemas ccs
            INNER JOIN core_estatus ce ON ce.skEstatus = ccs.skEstatus
            LEFT JOIN cat_usuarios cu ON cu.skUsuario = ccs.skUsuarioCreacion ";

        // aqui se enviarian los where personalizados por empresa o perfil
        $data = parent::crear_consulta($configuraciones);
        if ($data['filters']) {
            return $data['data'];
        }
        if (isset($_POST['generarExcel'])) {
            return $data['data'];
        }
        $result = $data['data'];
        $data['data'] = array();
        $i = 0;
        while ($row = Conn::fetch_assoc($result)) {
                $regla = [];

            utf8($row);
            $data['data'][$i] = array(
                'skCatalogoSistema' => $row['skCatalogoSistema'],
                'skEstatus' => $row['skEstatus'],
                'sNombre' => $row['sNombre'],
                'usuarioCreacion' => $row['usuarioCreacion'],
                'dFechaCreacion' => (!empty($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'Estatus' => $row['Estatus'],
                'menuEmergente' => parent::menuEmergente($regla, $row['skCatalogoSistema'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }

    public function generarExcel() {
        $data = $this->consultar();
        parent::generar_excel($_POST['title'], $_POST['headers'], $data);
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'],
            $_POST['headers'],
            $this->consultar()
        );
    }
}
