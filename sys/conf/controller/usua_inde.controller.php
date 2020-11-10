<?php

Class Usua_inde_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function getUsuarios() {

        $configuraciones = array();
        $configuraciones['query'] = " SELECT
            cu.skEstatus,
            cu.sUsuario,
            cu.skUsuario,
            cu.sTipoUsuario,
            cu.sNombre,
            cu.sApellidoPaterno,
            cu.sApellidoMaterno,
            cu.Edad,
            cu.sCorreo,
            cu.dFechaCreacion,
            ce.sNombre AS Estatus
            FROM cat_usuarios cu
            INNER JOIN core_estatus ce ON ce.skEstatus = cu.skEstatus";
        // aqui se enviarian los where personalizados por empresa o perfil
        if ($_SESSION['usuario']['tipoUsuario'] != 'A'){
            $configuraciones['query'] .= " WHERE sTipoUsuario IS NULL";
        }
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
            // Reglas de Negocio para Menu Emergente
            $regla = array(
                "menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'Estatus' => $row['Estatus'],
                'skUsuario' => $row['skUsuario'],
                'sNombre' => $row['sNombre'],
                'sUsuario' => $row['sUsuario'],
                'sApellidoPaterno' => $row['sApellidoPaterno'],
                'sTipoUsuario' => $row['sTipoUsuario'],
                'sApellidoMaterno' => $row['sApellidoMaterno'],
                'Edad' => $row['Edad'],
                'sCorreo' => $row['sCorreo'],
                'dFechaCreacion' => ($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'menuEmergente' => parent::menuEmergente($regla, $row['skUsuario'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }

    public function generarExcelUsuario() {
        $data = $this->getUsuarios();
        parent::generar_excel($_POST['title'], $_POST['headers'], $data);
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'],
            $_POST['headers'],
            $this->getUsuarios()
        );
    }

}
