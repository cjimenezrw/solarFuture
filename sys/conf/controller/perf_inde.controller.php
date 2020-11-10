<?php

Class Perf_inde_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }

    public function obtenerPerfiles() {

        $configuraciones = array();
        $configuraciones['query'] = " SELECT
            cp.skEstatus,
            cp.sNombre,
            cp.dFechaCreacion,
            cp.skPerfil,
            ce.sNombre AS Estatus
            FROM core_perfiles cp
            INNER JOIN core_estatus ce ON ce.skEstatus = cp.skEstatus";
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
            // Reglas de Negocio para Menu Emergente
            $regla = array(
                "menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);

            $data['data'][$i] = array(
                'Estatus' => $row['Estatus'],
                'skPerfil' => $row['skPerfil'],
                'sNombre' => $row['sNombre'],
                'dFechaCreacion' => ($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'menuEmergente' => parent::menuEmergente($regla, $row['skPerfil'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }

    public function generarExcelPerfiles() {
        $data = $this->obtenerPerfiles();
        parent::generar_excel($_POST['title'], $_POST['headers'], $data);
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->obtenerPerfiles()
        );
    }

}
