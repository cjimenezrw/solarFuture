<?php

Class Vasi_form_Controller Extends Conf_Model
{
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'stpCUD_variablesSistema';

    public function __construct()
    {
        parent::init();
    }

    public function __destruct()
    {

    }

    public function accionesVariables(){
        //exit("<pre>".print_r($_POST,1)."</pre>");
        $this->data = ['success'=>FALSE,'message'=>NULL,'datos'=>NULL];

        $this->conf['skVariableVieja']  = (isset($_POST['skVariableVieja']) ? $_POST['skVariableVieja'] : NULL);
        $this->conf['skVariable']       = (isset($_POST['skVariable']) ? $_POST['skVariable'] : NULL);
        $this->conf['skVariableTipo']   = (isset($_POST['skVariableTipo']) ? $_POST['skVariableTipo'] : NULL);
        $this->conf['sNombre']          = (isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL);
        $this->conf['sDescripcion']     = (isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : NULL);
        $this->conf['sValor']           = (isset($_POST['sValor']) ? $_POST['sValor'] : NULL);
        //PROYECTO
            $sProyecto = (isset($_POST['sProyecto']) ? $_POST['sProyecto'] : NULL);
        //Modulo
            $skModulo = (isset($_POST['skModulo']) ? $_POST['skModulo'] : NULL);
            
        if(empty($sProyecto)){
            $this->data['success'] = false;
            $this->data['message'] = 'El Proyecto es Requerido.';
            return $this->data;
        }
        
        if(empty($skModulo)){
            $this->data['success'] = false;
            $this->data['message'] = 'El Módulo es Requerido';
            return $this->data;
        }
            
        Conn::begin($this->idTran);
        
        $this->conf['axn'] = 'guardar';
        $stpCUD_variablesSistema = parent::stpCUD_variablesSistema();
        if(!$stpCUD_variablesSistema || isset($stpCUD_variablesSistema['success']) && $stpCUD_variablesSistema['success'] != 1){
            Conn::rollback($this->idTran);
            $this->data['success'] = false;
            $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
            return $this->data;
        }
        
        if(isset($_GET['p1'])){
            $this->conf['skVariable']     = (isset($_POST['skVariableVieja']) ? $_POST['skVariableVieja'] : NULL);
        }else{
            $this->conf['skVariable']       = (isset($_POST['skVariable']) ? $_POST['skVariable'] : NULL);
        }
        
 
        
         $this->conf['axn'] = 'delete_proyectos_modulos';
        $delete_proyectos = parent::stpCUD_variablesSistema();
        if(!$delete_proyectos || isset($delete_proyectos['success']) && $delete_proyectos['success'] != 1){
            Conn::rollback($this->idTran);
            $this->data['success'] = false;
            $this->data['message'] = 'Hubo un error al guardar proyectos, intenta de nuevo.';
            return $this->data;
        }
        if(is_array($sProyecto) && !empty($sProyecto)){
            $this->conf['axn'] = 'guardar_proyectos';
            foreach ($sProyecto AS $key => $value){
                $this->conf['sProyecto'] = $value;
                $guardar_proyecto = parent::stpCUD_variablesSistema();
                if(!$guardar_proyecto || isset($guardar_proyecto['success']) && $guardar_proyecto['success'] != 1){
                    Conn::rollback($this->idTran);
                    $this->data['success'] = false;
                    $this->data['message'] = 'Hubo un error al guardar proyectos, intenta de nuevo.';
                    return $this->data;
                }
            }
        }
        
        if(is_array($skModulo) && !empty($skModulo)){
            $this->conf['axn'] = 'guardar_modulos';
            foreach ($skModulo AS $key => $value){
                $this->conf['skModulo'] = $value;
                $guardar_modulos = parent::stpCUD_variablesSistema();
                if(!$guardar_modulos || isset($guardar_modulos['success']) && $guardar_modulos['success'] != 1){
                    Conn::rollback($this->idTran);
                    $this->data['success'] = false;
                    $this->data['message'] = 'Hubo un error al guardar modulos, intenta de nuevo.';
                    return $this->data;
                }
            }
        }
        
        
        
        Conn::commit($this->idTran);
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
        return $this->data;

    }
    public function consultarVariable(){
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['variableTipo'] = parent::consultar_variableTipo();
        $this->data['modulos'] = parent::_variablesSistema_consultar_modulos();
        if (isset($_GET['p1'])) {
            $this->conf['skVariable'] = $_GET['p1'];
            $this->data['datos'] =  parent::consulta_variable();
            $this->data['moduloProyecto'] = parent::consulta_variable_proyecto();
            $this->data['moduloVariables'] = parent::consulta_variable_modulos();
            
            //exit("<pre>".print_r($this->data['moduloVariables'],1)."</pre>");

            if(!$this->data['datos']){
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL REGISTRO',404);
            }

            if(isset($this->data['datos']['skEstatus']) && $this->data['datos']['skEstatus'] == 'EL'){
                DLOREAN_Model::showError('NO SE PUEDE EDITAR UN REGISTRO ELIMINADO',403);   
            }

            return $this->data;
        }
        return $this->data;
        return false;
    }
    public function validarCodigo(){
            return parent::validar_codigo_variable($_POST['skVariable']);
            return false;
    }
    
    public function getModulos(){
        $this->rehu['val'] = isset($_POST['val']) ? $_POST['val'] : NULL;

        $this->data = parent::_getModulosVariables();
        return $this->data;
    }

}
