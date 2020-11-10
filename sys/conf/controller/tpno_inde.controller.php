<?php

Class Tpno_inde_Controller Extends Conf_Model
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
    public function getTiposNotificacion()
    {
        $configuraciones = array();
        $configuraciones['query'] = "SELECT * FROM cat_NotificacionesTipos";

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
                "menuEmergente2" => ($row['skEstatus'] == 'EL' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skTipoNotificacion'  => $row['skTipoNotificacion'],
                'skEstatus'           => $row['skEstatus'],
                'sNombre'             => $row['sNombre'],
                'sDescripcion'        => $row['sDescripcion'],
                'dFechaCreacion'      => ($row['dFechaCreacion'] ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'menuEmergente'       => parent::menuEmergente($regla,$row['skTipoNotificacion'])
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

    public function eliminar($skTipoNotificacion){
        $this->data['success'] = TRUE;

        $sql = "UPDATE cat_notificacionesTipos SET skEstatus = 'EL' WHERE skTipoNotificacion = '".$skTipoNotificacion."'";
        $result = Conn::query($sql);

        if(!$result){
            $this->data['success'] = FALSE;
        }
        return $this->data;
    }

}
