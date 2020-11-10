<?php

/**
 * Controlador de la vista grup_inde
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
Class Prom_form_Controller Extends Empr_Model {

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
     * Acciones de Tipos
     *
     * Esta funcion procesa las acciones CUD de tipos de empresa, retornando una respuesta
     * como JSON, que indica a la interfaz si la accion fue exitosa o no
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function guardar() {

        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->prom['skPromotor'] = (isset($_POST['skPromotor']) ? $_POST['skPromotor'] : NULL);
            $this->prom['skEstatus'] = ($_POST['skEstatus'] ? $_POST['skEstatus'] : NULL);
            $this->prom['sNombre'] = ($_POST['sNombre'] ? $_POST['sNombre'] : NULL);
            $this->prom['sCorreo'] = ($_POST['sCorreo'] ? $_POST['sCorreo'] : NULL);
            $skPromotor = parent::stpCUD_promotores();
        
            if ($skPromotor) {
                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            } else {
                //echo "llego aqui";
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
            }
        }

        $this->load_view('prom_inde', $this->data);
        return true;
    }

    /**
     * Consultar grupo
     *
     * Esta funcion retorna los datos de grupos
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function consultarPromotor() {
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        if (isset($_GET['p1'])) {
            $this->prom['skPromotor'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_promotor();
            return $this->data;
        }
        return $this->data;
    }



}
