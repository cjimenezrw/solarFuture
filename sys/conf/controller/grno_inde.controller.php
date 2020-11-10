<?php

Class Grno_inde_Controller Extends Conf_Model {

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
        $configuraciones['query'] = " SELECT 
            gu.skGrupoNotificacion,
            gu.skEstatus,
            gu.sNombre,
            gu.sDescripcion,
            gu.dFechaCreacion,
            ce.sNombre AS estatus,
            ces.sNombre AS empresaPropietaria
            FROM cat_gruposNotificaciones gu
            INNER JOIN core_estatus ce ON ce.skEstatus = gu.skEstatus
            INNER JOIN rel_empresasSocios res ON res.skEmpresaSocio = gu.skEmpresaSocioPropietario
            INNER JOIN cat_empresas ces ON ces.skEmpresa = res.skEmpresa
            WHERE gu.skEmpresaSocioPropietario = '".$_SESSION['usuario']['skEmpresaSocioPropietario']."' ";

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
                'menuEmergente1' => ($row['skEstatus'] == 'EL' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skGrupoNotificacion' => $row['skGrupoNotificacion'],
                'skEstatus' => $row['skEstatus'],
                'sNombre' => $row['sNombre'],
                'sDescripcion' => $row['sDescripcion'],
                'empresaPropietaria' => $row['empresaPropietaria'],
                'dFechaCreacion' => (!empty($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'estatus' => $row['estatus'],
                'menuEmergente' => parent::menuEmergente($regla, $row['skGrupoNotificacion'])
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
