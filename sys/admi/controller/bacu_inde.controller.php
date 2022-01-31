<?php

/**
 * Bacu_inde_Controller
 *
 * Consulta de Cuentas Bancarias (bacu-inde)
 *
 * @author lvaldez
 */
Class Bacu_inde_Controller Extends Admi_Model {

    // CONST //
        const ENABLED = 0;
        const DISABLED = 1;
        const HIDDEN = 2;
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran;
        private $skPuestoGral;
        private $visionUsuario;

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_bancoCuentas'; 
    }

    public function __destruct() {

    }

    public function consultar(){

        $configuraciones = [];
        $configuraciones['query'] = "SELECT DISTINCT
             bc.*
            ,b.sNombre AS banco
            ,b.sNombreCorto AS bancoCorto
            ,d.sNombre AS divisa
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno,' ',ucre.sApellidoMaterno) AS usuarioCreacion
            ,IF(bc.skUsuarioModificacion IS NOT NULL,CONCAT(umod.sNombre,' ',umod.sApellidoPaterno,' ',umod.sApellidoMaterno),NULL) AS usuarioModificacion
            ,empr.sNombre AS empresaTitular
            FROM cat_bancosCuentas bc
            INNER JOIN cat_bancos b ON b.skBanco = bc.skBanco
            INNER JOIN cat_divisas d ON d.skDivisa = bc.skDivisa
            INNER JOIN core_estatus est ON est.skEstatus = bc.skEstatus
            INNER JOIN cat_usuarios ucre ON ucre.skUsuario = bc.skUsuarioCreacion
            LEFT JOIN cat_usuarios umod ON umod.skUsuario = bc.skUsuarioModificacion
            LEFT JOIN rel_empresasSocios res ON res.skEmpresaSocio = bc.skEmpresaSocioResponsable
            left JOIN cat_empresas empr ON empr.skEmpresa= res.skEmpresa
            WHERE  bc.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

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
            $row['menuEmergente'] = parent::menuEmergente($regla, $row['skBancoCuenta']);
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
