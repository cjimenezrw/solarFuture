<?php

Class Soem_inde_Controller Extends Empr_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    public function getSolicitudesEmpresas() {
        //menu Emergente
        //print_r($_SESSION['modulos'][$this->sysController]['menuEmergente']);

        $configuraciones = array();
        $configuraciones['query'] = "
            SELECT
                    e.sNombre as Estatus,
                    CONCAT( u.sNombre, ' ', u.sApellidoPaterno, ' ', u.sApellidoMaterno ) as Creador,
                    cet.sNombre as TipoEmpresa,
                    ose.*
            FROM
                    ope_solicitudesEmpresas ose
            INNER JOIN core_estatus e ON
                    e.skEstatus = ose.skEstatus
            INNER JOIN cat_usuarios u ON
                    u.skUsuario = ose.skUsuarioCreacion
            INNER JOIN cat_empresasTipos cet ON cet.skEmpresaTipo = ose.skEmpresaTipo";
        
        if(!parent::verify_permissions('A')){
            $configuraciones['query'] .= " WHERE ose.skEstatus = 'AC' AND ose.skUsuarioCreacion = ".escape($_SESSION['usuario']['skUsuario']);
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
                'Estatus'       => $row['Estatus'],
                'skSolicitudEmpresa'    => $row['skSolicitudEmpresa'],
                'sRazonSocial'  => $row['sRazonSocial'],
                'sAlias'        => $row['sAlias'],
                'sRFC'          => $row['sRFC'],
                'TipoEmpresa'   => $row['TipoEmpresa'],
                'Creador'       => $row['Creador'],
                'dFechaCreacion'=>($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'menuEmergente' => parent::menuEmergente($regla, $row['skSolicitudEmpresa'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }

    public function generarExcel() {
        $data = $this->getSolicitudesEmpresas();
        parent::generar_excel($_POST['title'], $_POST['headers'], $data);
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'],
            $_POST['headers'],
            $this->getSolicitudesEmpresas()
        );
    }

    public function eliminar(){
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro eliminado con éxito.';
        $this->data['data'] = FALSE;

        $sk = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));

        $eliminar = parent::eliminar_solicitudEmpresa(escape($sk));

        if(!$eliminar){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al eliminar el registro.';
        }

        return $this->data;
    }
    public function rechazar(){
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro eliminado con éxito.';
        $this->data['data'] = FALSE;

        $sk = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));

        $eliminar = parent::rechazar_solicitudEmpresa(escape($sk));

        if(!$eliminar){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al eliminar el registro.';
        }

        return $this->data;
    }

    public function aprobar(){
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
        $this->data['data'] = FALSE;

        $sk = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));
        $a = parent::aprobar_solicitudEmpresa(escape($sk));
        if(!$a){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al agregar el registro.';
        }

        return $this->data;
    }

    public function solInfo(){
        return parent::sltInfo(escape($_POST['skSolicitudEmpresa']));
    }
}
