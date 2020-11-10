<?php

Class Vasi_inde_Controller Extends Conf_Model
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
    public function getVariablesSistema()
    {
        //menu Emergente
        //print_r($_SESSION['modulos'][$this->sysController]['menuEmergente']);
        $configuraciones = array();

        $configuraciones['query'] = "SELECT * FROM core_variables ";

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

            $regla = array(
                "menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skVariable'                => $row['skVariable'],
                'skVariableTipo'            => $row['skVariableTipo'],
                'skEstatus'                 => $row['skEstatus'],
                'sNombre'                   => $row['sNombre'],
                'sDescripcion'              => $row['sDescripcion'],
                'sValor'                    => $row['sValor'],
                'dFechaCreacion'            => ($row['dFechaCreacion'] ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'menuEmergente'      => parent::menuEmergente($regla,$row['skVariable'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }
    public function generarExcelVariablesSistema(){
            $data = $this->getVariablesSistema();
            parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
        }
}

