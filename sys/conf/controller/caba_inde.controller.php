<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 28/04/2018
 * Time: 11:54 AM
 */

Class Caba_inde_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function getCatalogosBancos() {

        $configuraciones = array();
        $configuraciones['query'] = "SELECT * FROM cat_bancos WHERE skEstatus = 'AC'";

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
                'skBanco' => $row['skBanco'],
                'sNombre' => $row['sNombre'],
                'sDescripcion' => $row['sDescripcion'],
                'dFechaCreacion' => (!empty($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'skEstatus' => $row['skEstatus'],
                'menuEmergente' => parent::menuEmergente($regla, $row['skBanco'])
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
