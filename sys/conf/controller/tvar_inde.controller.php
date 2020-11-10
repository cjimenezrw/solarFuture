<?php

Class Tvar_inde_Controller Extends Conf_Model
{
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct()
    {
        parent::init();
    }

    public function __destruct()
    {

    }

    public function getTiposVariables()
    {

        $configuraciones = array();
        $configuraciones['query'] = " 
            SELECT 
                varT.skVariableTipo, 
                varT.skEstatus, 
                varT.sNombre
            FROM core_variablesTipos varT";
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
            utf8($row);
            $regla = array(
                "menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            
            $data['data'][$i] = array(
                'skEstatus'           => $row['skEstatus'],
                'skVariableTipo'         => $row['skVariableTipo'],
                'sNombre'           => $row['sNombre'],
                'menuEmergente'      => parent::menuEmergente($regla,$row['skVariableTipo'])
            );
            $i++;
        }
        
        Conn::free_result($result);
        return $data;
        }
    
    public function generarExcelTiposVariables(){
            $data = $this->getTiposVariables();
            parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
        }
}
