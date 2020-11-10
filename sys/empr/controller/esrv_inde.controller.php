<?php

Class Esrv_inde_Controller Extends Empr_Model
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
    
    public function getServicios(){

        $configuraciones = array();
        $configuraciones['query'] = "
            SELECT
                cs.*,
                CONCAT( cu.sNombre, ' ', cu.sApellidoPaterno, ' ', cu.sApellidoMaterno ) as sUsuarioCreacion,
                ce.sNombre as sEstatus
            FROM
                cat_servicios cs
            INNER JOIN cat_usuarios cu ON
                cu.skUsuario = cs.skUsuarioCreacion
            INNER JOIN core_estatus ce ON ce.skEstatus =  cs.skEstatus";
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
                "menuEmergente1" => ($row['skEstatus'] == 'AC' ? 0 : 1),
                "menuEmergente2" => ($row['skEstatus'] == 'AC' ? 0 : 1)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skServicio'            => $row['skServicio'],
                'sNombre'               => $row['sNombre'],
                'sEstatus'              => $row['sEstatus'],
                'sDescripcion'          => $row['sDescripcion'],
                'dFechaCreacion'        => ($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'sUsuarioCreacion'      => $row['sUsuarioCreacion'],
                'menuEmergente'         => parent::menuEmergente($regla,$row['skServicio'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }
    
    public function generarExcel(){
        $data = $this->getServicios();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }
    
    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->getServicios()
        );
    }
    
    public function eliminar($sk){
        $this->data['success'] = TRUE;

        $sql = "UPDATE cat_servicios SET skEstatus='EL' WHERE skServicio=$sk";
        $result = Conn::query($sql);

        if(!$result){
            $this->data['success'] = FALSE;
        }
        return $this->data;
    }
}
