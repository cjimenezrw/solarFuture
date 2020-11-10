<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 21/07/2018
 * Time: 10:05 AM
 */

Class Cuen_inde_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function getCatalogosCuentas() {

        $configuraciones = array();
        $configuraciones['query'] = "SELECT
                                        rcb.*, cb.sNombre AS sBanco
                                    FROM
                                        rel_cuentasBancos rcb
                                    INNER JOIN cat_bancos cb ON cb.skBanco = rcb.skBanco
                                    WHERE
                                        rcb.skEstatus = 'AC'";

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
        foreach (Conn::fetch_assoc_all($result) AS $row) {
            $regla = [];

            utf8($row);

                $row['sNombre'] = $row['sCuenta'];
                $row['dFechaCreacion'] = (!empty($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '');
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skCuentaBanco']);

                array_push($data['data'], $row);

        }
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
