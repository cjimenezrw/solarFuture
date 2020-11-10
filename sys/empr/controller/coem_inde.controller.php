<?php

/**
 * Coem_inde_Controller
 *
 * Controller de módulo de configuraciones de correos  de empresas para apertura de referencia (coem-inde)
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
 */
Class Coem_inde_Controller Extends Empr_Model {

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
     * Módulo para consultar configuraciones de referncias actuales
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function consultar() {

        $configuraciones = array();

        $configuraciones['query'] = "SELECT DISTINCT et.sNombre AS tipoEmpresa, es.skEmpresaSocio, es.skEstatus, est.sNombre AS estatus, e.sRFC, IIF(e.sNombreCorto IS NOT NULL, e.sNombreCorto, e.sNombre) AS cliente
            ,(SELECT COUNT(*) FROM cat_configuracionCorreos lac WHERE lac.sRFC = e.sRFC AND lac.skEmpresaSocio = es.skEmpresaSocio AND lac.skTipoProceso = 'REAC') AS totalCorreos
            FROM cat_configuracionCorreos lc
            INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = lc.skEmpresaSocio
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN core_estatus est ON est.skEstatus = es.skEstatus
            INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo
            WHERE es.skEstatus = 'AC' AND lc.skTipoProceso = 'REAC' AND es.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

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
                'menuEmergente2'=>$menuEmergente2
            );

            $row['menuEmergente'] = parent::menuEmergente($reglas,$row['skEmpresaSocio']);

            array_push($data['data'],$row);
        }

        return $data;
    }

    /**
     * generarExcel
     *
     * Genera EXCEL de las configuraciones de correos de referncias actuales
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
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
     * Genera PDF de las configuraciones de correos de referncias actuales
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
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
     * Elimina logicamente la configuración de correos de referncias actuales
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return bool True | False
     */
    public function eliminar(){
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro eliminado con éxito.';
        $this->data['data'] = FALSE;

        $this->correo['skEmpresaSocio'] = (isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : NULL));

        if(empty($this->correo['skEmpresaSocio'])){
            return FALSE;
        }

        if(!parent::deleteConfCorreos()){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al eliminar el registro.';
        }

        return $this->data;

    }

}
