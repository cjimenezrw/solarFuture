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

    public function consulta()
    {

        $configuraciones = array();
        $configuraciones['query'] = " SELECT
            ca.skNotificacionMensaje,
            ca.sNombre,
	    ca.sClaveNotificacion,
            ca.skEstatus,
            ca.sMensaje,
            ca.dFechaCreacion,
            ce.sNombre AS estatus,
            ce.sIcono AS estatusIcono,
            ce.sColor AS estatusColor
            FROM cat_notificacionesMensajes ca
            INNER JOIN core_estatus ce ON ce.skEstatus = ca.skEstatus";
        // aqui se enviarian los where personalizados por empresa o perfil

        // SE EJECUTA LA CONSULTA //
        $data = parent::crear_consulta($configuraciones);
        
        // Retorna el Resultado del Query para la Generación de Excel y Reportes Automáticos //
            if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
                return $data['data'];
            }
        
        // FORMATEAMOS LOS DATOS DE LA CONSULTA //
            $result = $data['data'];
            $data['data'] = [];
            foreach (Conn::fetch_assoc_all($result) AS $row) {
                utf8($row);

                /*
                */
                
            //REGLA DEL MENÚ EMERGENTE
                $regla = [ ];

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skNotificacionMensaje']);
                array_push($data['data'],$row);
        }
        return $data;
    }
    public function generarExcel(){
        $data = $this->consulta();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    public function pruebaNotificacion(){

        $usuarios = ["4A647C79-A965-4688-94F4-E11F4734CD18","4C6261E6-AEA6-4CC7-B7F5-C3479FC5F6DA"];
        $conf = [
            'SYS_URL' => SYS_URL, 
            'skCodigo' => "aaaa",
            'sNombre' => "pipo",
        ];

        parent::notify("PRUEBA",$conf,$usuarios);
    }

    public function pruebaArchivo(){
        echo TMP_HARDPATH;
        die();
       
    }



    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'],
            $_POST['headers'],
            $this->consulta()
        );
    }
}
