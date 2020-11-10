<?php

/**
 * Coem_form_Controller
 *
 * Controller de módulo de configuraciones de referencias actuales
 *
 * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
 */
Class Coem_form_Controller Extends Empr_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    /**
     * guardar
     *
     * Módulo guardar configuración de correos lámina
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed Array | False
     */
    public function guardar() {

        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro agregado con éxito.';
        $this->data['data'] = FALSE;

        $this->correo['skEmpresaSocio'] = (isset($_POST['skEmpresaSocio']) ? $_POST['skEmpresaSocio'] : (isset($_GET['skEmpresaSocio']) ? $_GET['skEmpresaSocio'] : NULL));
        $empresa = (isset($_POST['empresa']) ? $_POST['empresa'] : NULL);

        $this->correo['skTipoProceso'] = 'REAC';

        $this->correo['skEmpresaSocio'] = ($this->correo['skEmpresaSocio']) ? $this->correo['skEmpresaSocio'] : $empresa;

        $correos = (isset($_POST['sCorreo']) ? $_POST['sCorreo'] : NULL);

        Conn::begin('stpCU_confCorreosEmpresas');

        if(!parent::deleteConfCorreosEmpresas()){
            Conn::rollback('stpCU_confCorreosEmpresas');
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al guardar la configuración.';
            return $this->data;
        }

        if(is_array($correos)){
            $flag = true;
            foreach($correos AS $row){
                $this->correo['sCorreo'] = $row;
                $confCorreos = parent::stpCU_confCorreosEmpresas();
                if(!$confCorreos){
                    $flag = false;
                    break;
                }
            }

            if(!$flag){
                Conn::rollback('stpCU_confCorreosEmpresas');
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar la configuración.';
                return $this->data;
            }
        }



        Conn::commit('stpCU_confCorreosEmpresas');
        return $this->data;

    }

    /**
     * getConfiguracionCorreos
     *
     * Módulo para consultar la configuración de referencias actuales
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
        $correos = [];

        foreach ($data as $row) {
            array_push($correos, array(
                'id' => $row['skConfiguracionCorreo'],
                'sCorreo' => $row['sCorreo'] . "
            <input data-name=\"$row[sCorreo]\" name=\"sCorreo[]\" value=\"$row[sCorreo]\" type=\"text\" hidden>"
            ));
        }

        return ['cliente' => $data[0], 'correos' => json_encode($correos)];
    }

    /**
     * getEmpresas
     *
     * Módulo para consultar las empresas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function getEmpresas(){

        $this->empr['skEmpresaSocio'] = (isset($_POST['skEmpresaSocio']) ? $_POST['skEmpresaSocio'] : NULL);
        $this->empr['skEmpresaTipo'] = 'CLIE';
        $this->empr['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);

        $data = parent::get_empresas();
        if(!$data){
            return FALSE;
        }
        return $data;
    }

    /**
     * validarConfiguracion
     *
     * Módulo para consultar las empresas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function validarConfiguracion(){

        $this->correo['skEmpresaSocio'] = isset($_POST['empresa']) ? $_POST['empresa'] : NULL;

        if (empty($this->correo['skEmpresaSocio'])) {
            return FALSE;
        }

        $data = parent::get_configuracionCorreosEmpresas();

        if(!$data){
            return array('valid'=>true);
        }

        return array('valid'=>false);

    }

}
