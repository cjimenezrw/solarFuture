<?php

/**
 * Dacr_inde_Controller
 *
 * Controller de módulo de listado de días de almacenajes por cliente y recinto
 *
 * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
 */
Class Dacr_inde_Controller Extends Empr_Model {

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
     * consultar
     *
     * Módulo para consultar los días de almacenajes por cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function consultar() {

        $configuraciones = array();
        
        $configuraciones['query'] = "SELECT DISTINCT acr.skEmpresaSocioCliente,est.sNombre AS estatus,e.sNombre AS empresa,e.sNombreCorto, e.sRFC
            FROM cat_diasAlmacenajesClientes_recintos acr
            INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = acr.skEmpresaSocioCliente
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN core_estatus est ON est.skEstatus = acr.skEstatus
            WHERE acr.skEstatus = 'AC' AND acr.skEmpresaSocioPropietario = '".$_SESSION['usuario']['skEmpresaSocioPropietario']."'";

        if(!parent::verify_permissions('A')){
            
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

        foreach(Conn::fetch_assoc_all($result) AS $row){
            utf8($row);

            $menuEmergente1 = ($row['skEstatus'] == 'EL') ? 1 : 0;
            $menuEmergente2 = ($row['skEstatus'] == 'EL') ? 1 : 0;

            $reglas = array(
                'menuEmergente1'=>$menuEmergente1,
                'menuEmergente2'=>$menuEmergente2,
            );

            $row['menuEmergente'] = parent::menuEmergente($reglas,$row['skEmpresaSocioCliente']);

            array_push($data['data'],$row);
        }

        return $data;
    }

    /**
     * generarExcel
     *
     * Genera EXCEL de los días de almacenajes por cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return file Retorna un EXCEL | False
     */
    public function generarExcel() {
        parent::generar_excel(
            $_POST['title'],
            $_POST['headers'],
            $this->consultar()
        );
    }

    /**
     * generarPDF
     *
     * Genera PDF de los días de almacenajes por cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return file Retorna un PDF | False
     */
    public function generarPDF() {
        parent::generar_pdf(
            $_POST['title'],
            $_POST['headers'],
            $this->consultar()
        );
    }

    /**
     * eliminar
     *
     * Elimina logicamente la configuración de los días de almacenajes por cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return bool True | False
     */
    public function eliminar(){
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro eliminado con éxito.';
        $this->data['data'] = FALSE;

        $this->lamina['skEmpresaSocioCliente'] = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));

        if(empty($this->lamina['skEmpresaSocioCliente'])){
            return FALSE;
        }

        $skDiaAlmacenaje = parent::get_ProgramacionLamina();

        if(empty($skDiaAlmacenaje[0])){
            return FALSE;
        }
        $data = $skDiaAlmacenaje[0];

        if($data['skEstatus'] != 'NU'){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'No puedes eliminar esta programación.';
        }

        if(!parent::delete_programacion()){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al eliminar el registro.';
        }

        return $this->data;

    }
    
}
