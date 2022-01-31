<?php

/**
 * Banc_inde_Controller
 *
 * Consulta de Bancos (banc-inde)
 *
 * @author lvaldez
 */
Class Banc_inde_Controller Extends Admi_Model {

    // CONST //
        const ENABLED = 0;
        const DISABLED = 1;
        const HIDDEN = 2;
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran; 

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_bancos'; 
    }

    public function __destruct() {

    }

    public function consultar(){

        $configuraciones = [];
        $configuraciones['query'] = "SELECT
            b.*
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno,' ',ucre.sApellidoMaterno) AS usuarioCreacion
            ,IF(b.skUsuarioModificacion IS NOT NULL,CONCAT(umod.sNombre,' ',umod.sApellidoPaterno,' ',umod.sApellidoMaterno),NULL) AS usuarioModificacion
            FROM cat_bancos b
            INNER JOIN core_estatus est ON est.skEstatus = b.skEstatus
            INNER JOIN cat_usuarios ucre ON ucre.skUsuario = b.skUsuarioCreacion
            LEFT JOIN cat_usuarios umod ON umod.skUsuario = b.skUsuarioModificacion
            WHERE b.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

        if(!$this->verify_permissions('A')){
            if(!isset($_POST['filters'])){

            }else{

            }
        }else{
            if(!isset ($_POST['filters'])){

            }
        }

        $data = parent::crear_consulta($configuraciones);

        if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
            return $data['data'];
        }

        $result = $data['data'];
        $data['data'] = [];
        foreach (Conn::fetch_assoc_all($result) AS $row) {
            utf8($row);
            $regla = [];

            // menuEmergente1 => Editar
            // menuEmergente2 => -
            // menuEmergente3 => Eliminar
            // menuEmergente4 => Detalles

            $regla = [
                'menuEmergente1'=>$this->ME_Editar($row)
            ];
            
            $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : '';
            $row['menuEmergente'] = parent::menuEmergente($regla, $row['skBanco']);
            array_push($data['data'],$row);
        }
        return $data;
    }

    public function generarExcel() {
        parent::generar_excel($_POST['title'], $_POST['headers'], $this->consultar());
    }

    public function generarPDF() {
        parent::generar_pdf($_POST['title'], $_POST['headers'], $this->consultar());
    }

  /**
     * ME_Editar
     *
     * Condición de Menú Emergente Editar Banco
     * Solo puede Editar si el Banco está en
     * skEstatus = AC (Activo)
     *
     * @author lvaldez
     * @param type $row
     * @return int
     */
    public function ME_Editar(&$row){
        if($row['skEstatus'] == 'AC'){
            return self::ENABLED;
        }
        return self::DISABLED;
    }
    
    
  
    
}
