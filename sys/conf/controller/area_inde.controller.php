<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 01/11/2016
 * Time: 05:34 PM
 */

Class Area_inde_Controller Extends Conf_Model
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

    public function getAreas()
    {

        $configuraciones = array();
        $configuraciones['query'] = " SELECT
            ca.skArea,
            ca.skEstatus,
            ca.sNombre,
            ca.dFechaCreacion,
            ce.sNombre AS Estatus
            FROM cat_areas ca
            INNER JOIN core_estatus ce ON ce.skEstatus = ca.skEstatus";
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
                //"menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skArea'           => $row['skArea'],
                'skEstatus'         => $row['Estatus'],
                'sNombre'           => $row['sNombre'],
                'dFechaCreacion'    => ($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'menuEmergente'      => parent::menuEmergente($regla,$row['skArea'])
            );
            $i++;
        }
        Conn::free_result($result);
        //exit('<pre>'.print_r($data,1).'</pre>');
        return $data;
    }
    public function generarExcelAreas(){
        $data = $this->getAreas();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }
}
