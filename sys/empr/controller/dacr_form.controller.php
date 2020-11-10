<?php

/**
 * Dacr_form_Controller
 *
 * Controlador del módulo para configurar los días de almacenajes por cliente y recinto
 *
 * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
 */
Class Dacr_form_Controller Extends Empr_Model {

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
     * guardar
     *
     * Módulo para guardar las programaciones de lámina
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function guardar() {
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro agregado con éxito.';
        $this->data['data'] = FALSE;
        
        $this->empr['skEmpresaSocioCliente'] = (!empty($_POST['skEmpresaSocio']) ? $_POST['skEmpresaSocio'] : (!empty($_POST['skEmpresaSocioCliente']) ? $_POST['skEmpresaSocioCliente'] : NULL));
        $this->empr['skEstatus'] = 'AC';
        
        
        $this->empr['skDiaAlmacenaje'] = (!empty($_POST['skDiaAlmacenaje']) ? $_POST['skDiaAlmacenaje'] : NULL);
        $skDiaAlmacenaje = (!empty($_POST['skDiaAlmacenaje']) ? $_POST['skDiaAlmacenaje'] : NULL);
        $skEmpresaSocioRecinto = (!empty($_POST['skEmpresaSocioRecinto']) ? $_POST['skEmpresaSocioRecinto'] : NULL);
        $iDiasAlmacenajes = (!empty($_POST['iDiasAlmacenajes']) ? $_POST['iDiasAlmacenajes'] : NULL);
        
        Conn::begin('diasAlmacenajes');
        
        if(!$this->delete_diasAlmacenajeClienteRecinto()){
            Conn::rollback('diasAlmacenajes');
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al procesar la configuración.';
            return $this->data;
        }
        
        if(!$skEmpresaSocioRecinto){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Error al configurar los días libres de almancenajes para los recintos.';
            return $this->data;
        }
        
        $i = 0;
        foreach($skEmpresaSocioRecinto AS $row){
            $this->empr['skDiaAlmacenaje'] = $skDiaAlmacenaje[$i];
            $this->empr['skEmpresaSocioRecinto'] = $row;
            $this->empr['iDiasAlmacenajes'] = $iDiasAlmacenajes[$i];
            if(!parent::stpCU_diasAlmacenajeClienteRecinto()){
                Conn::rollback('diasAlmacenajes');
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar la configuración.';
                return $this->data;
            }
            $i++;
        }
        
        Conn::commit('diasAlmacenajes');
        return $this->data;
    }
     
    
    /**
     * getAlmacenajesClientesRecintos
     *
     * Consulta la configuración de días libres de almacenajes por cliente y recinto
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function getAlmacenajesClientesRecintos() {
        $this->empr['skEmpresaSocioCliente'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);
        $this->empr['skEstatus'] = 'AC';
        
        if(empty($this->empr['skEmpresaSocioCliente'])){
            return FALSE;
        }
        
        $get_almacenajesClientesRecintos = parent::get_almacenajesClientesRecintos();
        
        if(!$get_almacenajesClientesRecintos){
            return FALSE;
        }
        
        $diasLibres = array();
        foreach($get_almacenajesClientesRecintos AS $k=>$v){
            $input = '';
            $input .= '<input data-name="'.$v['skDiaAlmacenaje'].'" type="text" name="skDiaAlmacenaje[]" value="'.$v['skDiaAlmacenaje'].'" hidden />';
            $input .= '<input data-name="'.$v['recintoCorto'].'" type="text" name="skEmpresaSocioRecinto[]" value="'.$v['skEmpresaSocioRecinto'].'" hidden/>';
            $input .= '<input data-name="'.$v['iDiasAlmacenajes'].'" type="text" name="iDiasAlmacenajes[]" value="'.$v['iDiasAlmacenajes'].'" hidden/>';
            array_push($diasLibres,array(
                'id'=>$v['skDiaAlmacenaje'],
                'skEmpresaSocioRecinto'=>$v['recintoCorto'].$input,
                'iDiasAlmacenajes'=>$v['iDiasAlmacenajes']
            ));
            $input = '';
        }
        $get_almacenajesClientesRecintos['diasLibres'] = $diasLibres;
        
        return $get_almacenajesClientesRecintos;
    }
    
    /**
     * getClientes
     *
     * Módulo para consultar Clientes
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function getClientes(){
        $this->empr['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        $this->empr['skEmpresaTipo'] = 'CLIE';
        $data = parent::get_empresas();
        if(!$data){
            return FALSE;
        }
        return $data;
    }
    
    /**
     * getRecintos
     *
     * Módulo para consultar Recintos
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed Retorna un array de datos | False
     */
    public function getRecintos(){
        $this->empr['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        $this->empr['skEmpresaTipo'] = 'RECI';
        $data = parent::get_empresas();
        if(!$data){
            return FALSE;
        }
        return $data;
    }
    
    public function validarConfiguracion(){
        $this->empr['skEmpresaSocioCliente'] = (isset($_POST['skEmpresaSocio']) ? $_POST['skEmpresaSocio'] : (isset($_GET['skEmpresaSocio']) ? $_GET['skEmpresaSocio'] : NULL));
        $sql = "SELECT DISTINCT acr.skEmpresaSocioCliente FROM cat_diasAlmacenajesClientes_recintos acr WHERE acr.skEstatus != 'EL' AND acr.skEmpresaSocioCliente = ". escape($this->empr['skEmpresaSocioCliente']);
        
        $result = Conn::query($sql);
        if(!$result){
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        if(!$record){
            return array('valid'=>true);
        }
        return array('valid'=>false);
    }

}
