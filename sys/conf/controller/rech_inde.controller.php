<?php

/**
 * Controller de módulo de consulta de mercancias
 *
 * Este es el controlador del módulo de mercancias
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
 */
Class Rech_inde_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    /**
     * Consultar
     *
     * Consulta de mercancias
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@softlab.mx>
     * @return miced Retorna Array de datos de sellos.
     */
    public function consultar() {
        $configuraciones = array();
        $configuraciones['query'] = "SELECT cme.* ,ce.sNombre AS  estatus,cu.sNombre AS usuarioCreacion
                                    FROM cat_rechazosRevalidacion cme
                                    INNER JOIN core_estatus ce ON ce.skEstatus = cme.skEstatus
                                    INNER JOIN cat_usuarios cu ON cu.skUsuario = cme.skUsuarioCreacion ";


        $data = parent::crear_consulta($configuraciones);
        if($data['filters']){
            return $data['data'];
        }
        if(isset($_POST['generarExcel'])){
            return $data['data'];
        }
        $result = $data['data'];
        $data['data'] = array();
        foreach(Conn::fetch_assoc_all($result) AS $row){
            utf8($row);
            $reglas = array(
               // 'menuEmergente1'=>($row['skEstatus']!='AC') ? 1 : 0
            );
            array_push($data['data'],array(
                'sNombre'            => $row['sNombre'],
                'usuarioCreacion'            => $row['usuarioCreacion'],
                'estatus'            => $row['estatus'],
                'dFechaCreacion'     => ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '',
                'menuEmergente'      => parent::menuEmergente($reglas,$row['skRechazoRevalidacion'])
            ));
        }
        return $data;
    }

    public function generarExcel() {
        $data = $this->consultar();
        parent::generar_excel($_POST['title'], $_POST['headers'], $data);
    }

    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'],
            $_POST['headers'],
            $this->consultar()
        );
    }



}
