<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 06/01/2017
 * Time: 09:59 AM
 */

Class Apus_deta_Controller Extends Conf_Model
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

    public function getAplicaciones()
    {

        $configuraciones = array();
        $configuraciones['query'] = "SELECT
            rd.sModelo,
            rd.sOperadora,
            rd.sIdDispositivo,
            rd.skAplicacion,
            rd.dFechaCreacion,
            rd.sOsVersion,
            rd.sVersionApp,
            rd.skDispositivoToken,
            ca.sNombre,
            ca.sApellidoPaterno,
            ca.sApellidoMaterno
            FROM rel_dispositivo_token rd
            LEFT JOIN cat_usuarios ca ON ca.skUsuario = rd.skUsuario
            WHERE 1=1";
        if($_GET['p1']){
            $configuraciones['query'] .= "AND rd.skAplicacion = '".$_GET['p1']."'";
        }

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
                //"menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'sModelo'             => $row['sModelo'],
                'sOperadora'          => $row['sOperadora'],
                'sIdDispositivo'      => $row['sIdDispositivo'],
                'skAplicacion'        => $row['skAplicacion'],
                'sOsVersion'          => $row['sOsVersion'],
                'sVersionApp'         => $row['sVersionApp'],
                'skDispositivoToken'  => $row['skDispositivoToken'],
                'dFechaCreacion'      => ($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'sNombre'             => $row['sNombre']. ' ' . $row['sApellidoPaterno'] . ' ' . $row['sApellidoMaterno'],
                'menuEmergente'      => parent::menuEmergente($regla,$row['skDispositivoToken'])
            );
            $i++;
        }
        Conn::free_result($result);
        //exit('<pre>'.print_r($data,1).'</pre>');
        return $data;
    }
    public function generarExcelAplicaciones(){
        $data = $this->getAplicaciones();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }
    
    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->getAplicaciones()
        );
    }

    public function eliminar($id){
        $this->data['success'] = TRUE;
        
        $sql = "DELETE FROM rel_dispositivo_token WHERE skDispositivoToken='".$id."'";
        $result = Conn::query($sql);

        if(!$result){
            $this->data['success'] = FALSE;
        }
        return $this->data;
    }
}
