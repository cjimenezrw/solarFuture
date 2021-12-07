<?php

/**
 * Cotr_deta_Controller
 *
 * Detalles de Transacciones (cotr-deta)
 *
 * @author lvaldez <lvaldez>
 */
Class Cotr_deta_Controller Extends Admi_Model {

    // CONST //
    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran;
 
    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_transacciones';
      }

    public function __destruct() {

    }

    /**
    * consulta
    *
    * Obtenemos los datos del formulario de la transacción
    *
    * @author lvaldez <lvaldez>
    * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
    */

    public function consulta() {
        $this->data = ['success'=>NULL,'message'=>NULL,'datos'=>[]];

        $this->admi['skTransaccion'] = (isset($_POST['skTransaccion']) ? $_POST['skTransaccion'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
        //this->admi['getFacturasSinComprobante'] = (isset($_POST['getFacturasSinComprobante']) ? $_POST['getFacturasSinComprobante']: NULL);

        if(empty($this->admi['skTransaccion'])){
            DLOREAN_Model::showError('NO SE ENCONTRÓ LA TRANFERENCIA',404);
        }

        $this->admi['skEstatus'] = 'AC';
        $this->data['get_bancos'] = parent::_get_bancos();
        $this->data['get_bancosCuentas'] = parent::_get_bancosCuentas();
        $this->data['get_formasPago'] = parent::_get_formasPago();
        //$this->data['historialConexion'] = parent::consultar_transacciones_historial();
        //$this->data['get_transaccionesComprobantes'] = parent::get_transaccionesComprobantes();
        //$this->data['devoluciones'] = parent::get_devoluciones();
        $this->admi['skEstatus'] = NULL;

        $this->data['datos'] = parent::_get_transaccion();
        if(!$this->data['datos']){
            DLOREAN_Model::showError('NO SE ENCONTRÓ LA TRANFERENCIA',404);
        }

        $this->data['get_transaccion_facturas'] = parent::_get_transaccion_facturas();
//exit('<pre>'.print_r($this->data,1).'</pre>');
        return $this->data;
    }



    

}
