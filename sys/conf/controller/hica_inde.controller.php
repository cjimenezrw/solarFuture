<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 04/10/2016
 * Time: 03:55 PM
 */

Class hica_inde_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    //use AutoCompleteTrait;
    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    public function jsonAccesos(){
         return $datosAccesos = parent::consulta_accesos();
    }

    public function getAccessHistory(){

        $configuraciones = array();
        $configuraciones['log'] = true;
        $configuraciones['query'] = " SELECT  concat(cu.sNombre ,' ', cu.sApellidoPaterno) AS usuario, cau.skEstatus, cm.skModulo, cm.sTitulo as Modulo, cau.sIP,
        cau.dFechaCreacion
        FROM core_accesos_usuarios cau
        INNER JOIN core_modulos cm ON cm.skModulo = cau.skModulo
        INNER JOIN cat_usuarios cu ON cu.skUsuario = cau.skUsuario";
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
            utf8($row);
            $data['data'][$i] = array(
                'usuario'           => $row['usuario'],'UTF-8',
                'skEstatus'         => $row['skEstatus'],
                'skModulo'            => $row['skModulo'],
                'Modulo'            => $row['Modulo'],
                'sIP'               => $row['sIP'],
                'dFechaCreacion'    => ($row['dFechaCreacion'] ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])): '')
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
        }

    public function generarExcel(){
        $data = $this->getAccessHistory();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'],
            $_POST['headers'],
            $this->getAccessHistory()
        );
    }
}
