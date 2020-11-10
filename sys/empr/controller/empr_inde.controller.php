<?php

Class Empr_inde_Controller Extends Empr_Model
{
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    
    public function getEmpresas(){

        $configuraciones = array();
        $configuraciones['query'] = " SELECT
            ce.skEmpresa,
            ce.skEstatus,
            ce.sNombre,
            ce.sRFC,
            ce.sNombreCorto,
            ce.dFechaCreacion,
            ce.skUsuarioCreacion,
            ce.dFechaModificacion,
            ce.skUsuarioModificacion,
            cu.sNombre AS nombreUsuario,
            cu.sApellidoPaterno,
            cu.sApellidoMaterno,
            ces.sNombre AS estatus
            FROM cat_empresas ce
            INNER JOIN core_estatus ces ON ces.skEstatus = ce.skEstatus
            INNER JOIN cat_usuarios cu ON cu.skUsuario = ce.skUsuarioCreacion";
        // aqui se enviarian los where personalizados por empresa o perfil
        $data = parent::crear_consulta($configuraciones);
        if($data['filters']){ return $data['data']; }
        if(isset($_POST['generarExcel'])){ 
            return $data['data']; 
        }
        $result = $data['data'];
        $data['data'] = array();
        $i=0;
        while ($row = Conn::fetch_assoc($result)) {
            // Reglas de Negocio para Menu Emergente
            $regla = array(
                "menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skEmpresa'=>$row['skEmpresa'],
                'skEstatus'=>$row['skEstatus'],
                'sNombre'=>$row['sNombre'],
                'sRFC'=>$row['sRFC'],
                'sNombreCorto'=>$row['sNombreCorto'],
                'dFechaCreacion'=>($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'skUsuarioCreacion'=>$row['skUsuarioCreacion'],
                'dFechaModificacion'=>($row['dFechaModificacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaModificacion'])): ''),
                'nombreUsuario'=>$row['nombreUsuario'],
                'sApellidoPaterno'=>$row['sApellidoPaterno'],
                'sApellidoMaterno'=>$row['sApellidoMaterno'],
                'estatus'           => $row['estatus'],
                'menuEmergente'      => parent::menuEmergente($regla,$row['skEmpresa'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }
    
    public function generarExcel(){
        $data = $this->getEmpresas();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }
    
    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->getEmpresas()
        );
    }
}
