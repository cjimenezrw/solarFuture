<?php

/**
 * Coem_deta_Controller
 *
 * Controller de módulo de configuraciones de correos de empresas
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
 */
Class Coem_deta_Controller Extends Empr_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    /**
     * getConfiguracionCorreos
     *
     * Módulo para consultar la configuración de correos de empresas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function getConfiguracionCorreos() {
        $this->correo['skEmpresaSocio'] = isset($_GET['p1']) ? $_GET['p1'] : NULL;

        if (empty($this->correo['skEmpresaSocio'])) {
            return FALSE;
        }

        $data = parent::get_configuracionCorreosEmpresas();

        if (!$data) {
            return FALSE;
        }

        return $data;
    }

}
