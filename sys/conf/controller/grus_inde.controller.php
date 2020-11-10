<?php

Class Grus_inde_Controller Extends Conf_Model {

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
            gu.skGrupoUsuario,
            gu.skUsuarioResponsable,
            gu.skEstatus,
            gu.sNombre,
            gu.sDescripcion,
            gu.dFechaCreacion,
            gu.skUsuarioCreacion,
            gu.dFechaModificacion,
            gu.skUsuarioModificacion,
            ce.sNombre AS estatus,
            CONCAT(cu.sNombre,' ',cu.sApellidoPaterno,' ',cu.sApellidoMaterno) AS responsable
            FROM cat_gruposUsuarios gu
            INNER JOIN core_estatus ce ON ce.skEstatus = gu.skEstatus
            INNER JOIN cat_usuarios cu ON cu.skUsuario = gu.skUsuarioResponsable";
        
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
                'skGrupoUsuario' => $row['skGrupoUsuario'],
                'skUsuarioResponsable' => $row['skUsuarioResponsable'],
                'skEstatus' => $row['skEstatus'],
                'sNombre' => $row['sNombre'],
                'sDescripcion' => $row['sDescripcion'],
                'dFechaCreacion' => (!empty($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'skUsuarioCreacion' => $row['skUsuarioCreacion'],
                'dFechaModificacion' => (!empty($row['dFechaModificacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaModificacion'])) : ''),
                'skUsuarioModificacion' => $row['skUsuarioModificacion'],
                'estatus' => $row['estatus'],
                'responsable' => $row['responsable'],
                'menuEmergente' => parent::menuEmergente($regla, $row['skGrupoUsuario'])
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
