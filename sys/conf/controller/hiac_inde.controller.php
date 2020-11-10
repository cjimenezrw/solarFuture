<?php

/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 14/10/2016
 * Time: 12:01 PM
 */
Class hiac_inde_Controller Extends Conf_Model
{
    // PUBLIC VARIABLES //

    //use AutoCompleteTrait;
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

    public function jsonAccesos()
    {
        return $datosAccesos = parent::consulta_accesos();
    }

    public function getActionsHistory()
    {

        $configuraciones = array();
        $configuraciones['query'] = " SELECT  CONCAT(cu.sNombre, ' ', cu.sApellidoPaterno, ' ', cu.sApellidoMaterno) AS 'usuario', cau.dFechaCreacion, 
             cm.skModulo, cm.sTitulo, cau.skCodigo, cau.sTabla, cau.sDescripcion, cau.sDatosHistorial
             FROM core_acciones_usuarios cau
             INNER JOIN core_modulos cm ON cm.skModulo = cau.skModulo
             LEFT JOIN cat_usuarios cu ON cu.skUsuario = cau.skUsuario";
        
        // aqui se enviarian los where personalizados por empresa o perfil
        $data = parent::crear_consulta($configuraciones);
        if ($data['filters']) {
            return $data['data'];
        }
        if(isset($_POST['generarExcel'])){
            return $data['data'];
        }
        $result = $data['data'];
        $data['data'] = array();
        $i = 0;
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);
            $data['data'][$i] = array(
                'usuario' => $row['usuario'],
                'dFechaCreacion' => ($row['dFechaCreacion'] ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : ''),
                'skModulo' => $row['skModulo'],
                'sTitulo' => $row['sTitulo'],
                'skCodigo' => $row['skCodigo'],
                'sTabla' => $row['sTabla'],
                'sDescripcion' => $row['sDescripcion'],
                'sDatosHistorial' => $row['sDatosHistorial']
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }
    
    public function generarExcel(){
        $data = $this->getActionsHistory();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->getActionsHistory()
        );
    }
}
