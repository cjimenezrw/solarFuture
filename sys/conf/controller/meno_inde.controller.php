<?php

Class Meno_inde_Controller Extends Conf_Model
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

    public function getMensajesNotificacion()
    {

        $configuraciones = array();
        $configuraciones['query'] = " SELECT
            ca.skNotificacionMensaje,
            ca.sNombre,
            ca.skEstatus,
            ca.sMensaje,
            ca.dFechaCreacion,
            ce.sNombre AS Estatus
            FROM cat_notificacionesMensajes ca
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
            $regla = array(
                //"menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skEstatus'         => $row['Estatus'],
                'sNombre'           => $row['sNombre'],
                'sMensaje'          => $row['sMensaje'],
                'dFechaCreacion' => ($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'menuEmergente'     => parent::menuEmergente($regla,$row['skNotificacionMensaje'])
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
}
