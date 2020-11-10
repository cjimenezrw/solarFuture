<?php
/**
 * Controlador de la vista grup_inde
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
Class Tipo_inde_Controller Extends Empr_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    
    public function consultarTipo(){
       
        $configuraciones = array();
        $configuraciones['query'] = "
            SELECT 
                ceTipos.skEmpresaTipo, 
                ceTipos.skEstatus, 
                ceTipos.sNombre
            FROM cat_empresasTipos ceTipos
            INNER JOIN core_estatus ce ON ce.skEstatus = ceTipos.skEstatus";
        // aqui se enviarian los where personalizados por empresa o perfil
        $data = parent::crear_consulta($configuraciones);
         
        if($data['filters']){
            return $data['data'];
        }
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
                'skEstatus'           => $row['skEstatus'],
                'skEmpresaTipo'           => $row['skEmpresaTipo'],
                'sNombre'           => $row['sNombre'],
                'menuEmergente'     => parent::menuEmergente($regla,$row['skEmpresaTipo'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }
    
    public function generarExcelTipos(){
            $data = $this->consultarTipo();
            parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }
    
}
