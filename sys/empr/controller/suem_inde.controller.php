<?php

Class Suem_inde_Controller Extends Empr_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }

    public function getSucursales() {
        //menu Emergente
        //print_r($_SESSION['modulos'][$this->sysController]['menuEmergente']);

        $configuraciones = array();
        $configuraciones['query'] = " SELECT cs.skSucursal, cs.skEstatus,cs.sNombre, cs.sNombreCorto, ce.sNombre AS Estatus
        FROM cat_sucursales cs
        INNER JOIN core_estatus ce ON ce.skEstatus = cs.skEstatus ";
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
                'skSucursal' => $row['skSucursal'],
                'sNombre' => $row['sNombre'],
                'sNombreCorto' => $row['sNombreCorto'],
                'menuEmergente' => parent::menuEmergente($regla, $row['skSucursal'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }

    public function generarExcelSucursales() {
        $data = $this->getSucursales();
        parent::generar_excel($_POST['title'], $_POST['headers'], $data);
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->getSucursales()
        );
    }

}
