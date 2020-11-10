<?php

/*
 * Controlador de la vista grup_inde
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */

Class Grup_inde_Controller Extends Empr_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }

    public function getGrupos() {

        $configuraciones = array();
        $configuraciones['query'] = "
            SELECT 
                grEm.skGrupo, 
                grEm.skEstatus, 
                grEm.dFechaCreacion, 
                grEm.sNombre, 
                grEm.skUsuarioCreacion
            FROM cat_gruposEmpresas grEm 
            INNER JOIN core_estatus ce ON ce.skEstatus = grEm.skEstatus";

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
                "menuEmergente1" => ($row['skEstatus'] == 'EL' ? 1 : 0)
            );
            utf8($row);

            $data['data'][$i] = array(
                'skEstatus' => $row['skEstatus'],
                'skGrupo' => $row['skGrupo'],
                'sNombre' => $row['sNombre'],
                'dFechaCreacion' => ($row['dFechaCreacion'] ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'skUsuarioCreacion' => $row['skUsuarioCreacion'],
                'menuEmergente' => parent::menuEmergente($regla, $row['skGrupo'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }

    public function generarExcelGrupos() {
        $data = $this->getGrupos();
        parent::generar_excel($_POST['title'], $_POST['headers'], $data);
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->getGrupos()
        );
    }

}
