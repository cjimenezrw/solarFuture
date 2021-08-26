<?php
Class Expe_inde_Controller Extends Docu_Model {

    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'expe_inde';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function consultar(){
        $configuraciones = [];
        //$configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT
            ex.skTipoExpediente, 
            ex.skEstatus, 
            ex.sNombre, 
            ex.sDecripcion, 
            ex.dFechaCreacion, 
            ex.skUsuarioCreacion, 
            ex.dFechaModificacion, 
            ex.skUsuarioModificacion,
            est.sNombre AS estatus,
            est.sIcono AS estatusIcono,
            est.sColor AS estatusColor,
            CONCAT(uC.sNombre,' ',uC.sApellidoPaterno) AS usuarioCreacion
        FROM cat_docu_tiposExpedientes ex
        INNER JOIN core_estatus est ON est.skEstatus = ex.skEstatus
        INNER JOIN cat_usuarios uC ON uC.skUsuario = ex.skUsuarioCreacion";
        
        if(!isset($_POST['filters'])){
            
        }else{

        }

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

                // VALIDACIÓN DEL MENÚ EMERGENTE
                    $validacionesME = [];

                $row['menuEmergente'] = parent::menuEmergente($validacionesME, $row['skTipoExpediente']);
                array_push($data['data'],$row);
        }
        return $data;
    }

    public function generarExcel(){
        parent::generar_excel($_POST['title'], $_POST['headers'], $this->consultar());
    }

    public function generarPDF() {
        parent::generar_pdf($_POST['title'], $_POST['headers'], $this->consultar());
    }

}