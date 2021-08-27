<?php
require_once(SYS_PATH.'docu/controller/docu_serv_caracteristicas.controller.php');
Class Docu_serv_Controller Extends Docu_Model {
    
    // TRAITS //
        use Docu_serv_caracteristicas_Controller;
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'docu_serv';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function guardar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'data' => NULL];
        //Conn::begin($this->idTran);

        // OBTENER DATOS DE ENTRADA
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        // VALIDAR DATOS DE ENTRADA
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }
        // OBTENEMOS LA CONFIGURACIÓN DEL DOCUMENTO
            $configuracion_tipoExpediente_tipoDocumento = $this->configuracion_tipoExpediente_tipoDocumento();
            $this->data['data'] = NULL;
            $this->data['configuraciones'] = $configuracion_tipoExpediente_tipoDocumento['data'];

        // VALIDAR CONFIGURACIÓN DE EXPEDIENTE DOCUMENTO
            $validar_expediente_documento = $this->validar_expediente_documento();
            
            if(!$validar_expediente_documento['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }
            
        // GUARDAR
            $guardar_documento = $this->guardar_documento();
            if(!$guardar_documento['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        // SUBIR DOCUMENTO
            $subir_documento = $this->subir_documento();
            if(!$subir_documento['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        // CARACTERÍSTICAS DE DOCUMENTO
            $caracteristicas_documento = $this->caracteristicas_documento();
            if(!$caracteristicas_documento['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

            $this->data['data'] = [
                'skDocumento'=>array_column($this->docu['docu_file_array'], 'skDocumento')
            ];

        // RETORNAMOS LOS RESULTADOS
            //Conn::commit($this->idTran);
            $this->data['success'] = TRUE;
            $this->data['message'] = 'DOCUMENTO GUARDADO CON ÉXITO';
            return $this->data;
    }

    public function validar_expediente_documento(){

        if(!isset($_FILES['docu_file']) || empty($_FILES['docu_file']['name'])){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'NO SE RECIBIÓ EL DOCUMENTO';
            return $this->data;
        }
       
        $this->docu['docu_file_array'] = [];
        if(is_array($_FILES['docu_file']['name'])){
            $FILE_KEYS = array_keys($_FILES['docu_file']);
            for($i = 0; $i < count($_FILES['docu_file']['name']); $i++){  
                foreach ($FILE_KEYS AS $k){
                    $this->docu['docu_file_array'][$i][$k] = $_FILES['docu_file'][$k][$i];
                }
            }
        }else{
            $this->docu['docu_file_array'] = [
                [
                    'name'=>$_FILES['docu_file']['name'],
                    'type'=>$_FILES['docu_file']['type'],
                    'tmp_name'=>$_FILES['docu_file']['tmp_name'],
                    'error'=>$_FILES['docu_file']['error'],
                    'size'=>$_FILES['docu_file']['size']
                ]
            ];
        }

        foreach($this->docu['docu_file_array'] AS $k=>&$v){

            // VALIDAMOS LAS EXTENSIONES DE DOCUMENTO //
                if(!in_array($v['type'], $this->data['configuraciones']['contentTypes'])){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'SOLO SE ACEPTAN LAS EXTENSIONES: '.implode(', ',$this->data['configuraciones']['extensiones']);
                    return $this->data;
                }

                $v['sExtension'] = $this->data['configuraciones']['extensiones'][array_search($v['type'], $this->data['configuraciones']['contentTypes'])];

            // CARACTERÍSTICA PESO DE DOCUMENTO EN MB (SIZEDO) //
                if(!isset($this->data['configuraciones']['caracteristicas']['SIZEDO'])){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'FALTA CONFIGURACIÓN DE PESO MÁXIMO PERMITIDO (Expediente: '.$this->data['configuraciones']['tipoExpediente'].', Documento: '.$this->data['configuraciones']['tipoDocumento'].')';
                    return $this->data;
                }

                $skCaracteristica = $this->data['configuraciones']['caracteristicas']['SIZEDO']['skCaracteristica'];
                if(!method_exists($this, $skCaracteristica)){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'NO SE ENCONTRÓ EL MÉTODO DE LA CARACTERÍSTICA ('.$this->data['configuraciones']['caracteristicas']['SIZEDO']['sNombre'].')';
                    return $this->data;
                }

                $caracteristica = $this->$skCaracteristica([
                    'caracteristica'=>$this->data['configuraciones']['caracteristicas']['SIZEDO'],
                    'peso_bytes'=>$v['size']
                ]);
                
                if(!$caracteristica || isset($caracteristica['success']) && $caracteristica['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = $caracteristica['message'];
                    return $this->data;
                }
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'EXTENSIÓN DE DOCUMENTO VALIDADA';
        return $this->data;
    }

    public function guardar_documento(){
        $this->data['success'] = TRUE;
        $this->docu['axn'] = 'guardar_documento';

        foreach($this->docu['docu_file_array'] AS $k=>&$v){
            $stp_docu_documentos = parent::stp_docu_documentos();
            if(!$stp_docu_documentos || isset($stp_docu_documentos['success']) && $stp_docu_documentos['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL DOCUMENTO';
                $this->data['messageSQL'] = (isset($stp_docu_documentos['messageSQL']) ? $stp_docu_documentos['messageSQL'] : NULL);
                return $this->data;
            }

            $v['skDocumento'] = $stp_docu_documentos['skDocumento'];
            $v['sConsecutivo'] = $stp_docu_documentos['sConsecutivo'];
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DOCUMENTO GUARDADO';
        return $this->data;
    }

    public function subir_documento(){
        $this->data['success'] = TRUE;
        $this->docu['axn'] = 'subir_documento';

        $DOCUME = parent::getVariable('DOCUME');
        $EXPEDIENTE = DIR_PROJECT.$DOCUME.'expedientes/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/';
        $THUMBNAIL = DIR_PROJECT.$DOCUME.'thumbnails/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/';

        foreach($this->docu['docu_file_array'] AS $k=>&$v){
            $this->docu['skDocumento'] = $v['skDocumento'];
            $this->docu['sExtension'] = $v['sExtension'];
            $this->docu['sExtensiona'] = $v['sExtension'];
            $this->docu['sNombre'] = $this->docu['skTipoExpediente'].'_'.$this->docu['skTipoDocumento'].'_'.$v['sConsecutivo'].'.'.$v['sExtension'];
            $this->docu['sNombreOriginal'] = $v['name'];
            $this->docu['sUbicacion'] = 'expedientes/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/'.$this->docu['sNombre'];
            $this->docu['sUbicacionThumbnail'] = NULL;
            
            if(!is_dir($EXPEDIENTE)) {
                if(!mkdir($EXPEDIENTE, 0777, TRUE)) {
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'NO SE PUDO CREAR EL DIRECTORIO DEL EXPEDIENTE';
                    return $this->data;
                }
            }

            if(!move_uploaded_file($v['tmp_name'], $EXPEDIENTE.$this->docu['sNombre'])){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL MOVER EL DOCUMENTO';
                return $this->data;
            }
    
            chmod($EXPEDIENTE.$this->docu['sNombre'], 0777);

            // CARACTERÍSTICA GENERAR THUMBNAIL (THUMBN) //
                if(isset($this->data['configuraciones']['caracteristicas']['THUMBN'])){

                    if(!is_dir($THUMBNAIL)) {
                        if(!mkdir($THUMBNAIL, 0777, TRUE)) {
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'NO SE PUDO CREAR EL DIRECTORIO DEL EXPEDIENTE';
                            return $this->data;
                        }
                    }

                    $skCaracteristica = $this->data['configuraciones']['caracteristicas']['THUMBN']['skCaracteristica'];
                    if(!method_exists($this, $skCaracteristica)){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'NO SE ENCONTRÓ EL MÉTODO DE LA CARACTERÍSTICA ('.$this->data['configuraciones']['caracteristicas']['THUMBN']['sNombre'].')';
                        return $this->data;
                    }

                    $caracteristica = $this->$skCaracteristica([
                        'caracteristica'=>$this->data['configuraciones']['caracteristicas']['THUMBN'],
                        'directory'=>$THUMBNAIL,
                        'source'=>$EXPEDIENTE.$this->docu['sNombre'],
                        'destination'=>$THUMBNAIL.$this->docu['sNombre'],
                        'width'=>NULL,
                        'height'=>NULL
                    ]);
                    
                    if(!$caracteristica || isset($caracteristica['success']) && $caracteristica['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = $caracteristica['message'];
                        return $this->data;
                    }

                    $this->docu['sUbicacionThumbnail'] = 'thumbnails/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/'.$this->docu['sNombre'];
                }
            
            // ACTUALIZAMOS LA UBICACIÓN DEL DOCUMENTO
                $stp_docu_documentos = parent::stp_docu_documentos();

                if(!$stp_docu_documentos || isset($stp_docu_documentos['success']) && $stp_docu_documentos['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL SUBIR EL DOCUMENTO';
                    $this->data['messageSQL'] = (isset($stp_docu_documentos['messageSQL']) ? $stp_docu_documentos['messageSQL'] : NULL);
                    return $this->data;
                }

        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DOCUMENTO SUBIDO';
        return $this->data;
    }

    public function caracteristicas_documento(){
        $this->data['success'] = TRUE;
        $this->docu['axn'] = 'caracteristicas_documento';

        $this->data['success'] = TRUE;
        $this->data['message'] = 'CARACTERÍSTICAS DE DOCUMENTO APLICADAS';
        return $this->data;
    }

    public function configuracion_tipoExpediente_tipoDocumento(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'data' => NULL];

        // OBTENER DATOS DE ENTRADA
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        // OBTENEMOS LOS DATOS GENERALES DEL TIPO DE EXPEDIENTE Y EL TIPO DE DOCUMENTO
            $_get_tiposExpedientes_tiposDocumentos = parent::_get_tiposExpedientes_tiposDocumentos();
            $this->data['data'] = $_get_tiposExpedientes_tiposDocumentos[0];

        // OBTENEMOS LAS EXTENSIONES DEL TIPO DE DOCUMENTO
            $_get_tiposDocumentos_extensiones = parent::_get_tiposDocumentos_extensiones();
            $this->data['data']['extensiones'] = array_column($_get_tiposDocumentos_extensiones,'sExtension');
            $this->data['data']['contentTypes'] = array_column($_get_tiposDocumentos_extensiones,'sContentType');

        // OBTENEMOS LAS CARACTERISTICAS DEL TIPO DE DOCUMENTO
            $_get_tiposDocumentos_caracteristicas = parent::_get_tiposDocumentos_caracteristicas();
            $this->data['data']['caracteristicas'] = [];
            foreach($_get_tiposDocumentos_caracteristicas AS $k=>$v){
                $this->data['data']['caracteristicas'][$v['skCaracteristica']] = $v;
            }

        return $this->data;
    }

    public function get_documentos(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'data' => []];

        // OBTENER DATOS DE ENTRADA
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        // VALIDAMOS QUE VENGAN LOS FILTROS
            if(!isset($this->docu['skCodigo']) || empty($this->docu['skCodigo'])){
                if(empty($this->docu['skDocumento']) || empty($this->docu['caracteristicas'])){
                    return $this->data;        
                }
            }


        // OBTENEMOS LOS DOCUMENTOS
            $this->docu['skEstatus'] = 'AC';
            $_get_documentos = parent::_get_documentos();
            $this->data['data'] = $_get_documentos;

            return $this->data;
    }

    public function eliminar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'data' => []];
        //Conn::begin($this->idTran);

        // OBTENER DATOS DE ENTRADA
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        // ELIMINAR DOCUMENTO
            $eliminar_documento_trash = $this->eliminar_documento_trash();
            if(!$eliminar_documento_trash['success']){
                //Conn::rollback($this->idTran);
                return $this->data;
            }

        // RETORNAMOS LOS RESULTADOS
            //Conn::commit($this->idTran);
            $this->data['data'] = $this->docu;
            $this->data['success'] = TRUE;
            $this->data['message'] = 'DOCUMENTO ELIMINADO CON ÉXITO';
            return $this->data;
    }

    public function eliminar_documento_trash(){
        $this->data['success'] = TRUE;
        $this->docu['axn'] = 'eliminar_documento_trash';

        $_get_documentos = parent::_get_documentos();
        $this->docu['skTipoExpediente'] = $_get_documentos[0]['skTipoExpediente'];
        $this->docu['skTipoDocumento'] = $_get_documentos[0]['skTipoDocumento'];
        $this->docu['skCodigo'] = $_get_documentos[0]['skCodigo'];
        $this->docu['sNombre'] = $_get_documentos[0]['sNombre'];
        $this->docu['sUbicacionThumbnail'] = $_get_documentos[0]['sUbicacionThumbnail'];

        $this->docu['sUbicacion'] = 'trash_expedientes/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/'.$this->docu['sNombre'];

        $DOCUME = parent::getVariable('DOCUME');
        $EXPEDIENTE = DIR_PROJECT.$DOCUME.'expedientes/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/';
        $EXPEDIENTE_TRASH = DIR_PROJECT.$DOCUME.'trash_expedientes/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/';

        $THUMBNAIL = DIR_PROJECT.$DOCUME.'thumbnails/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/';
        $THUMBNAIL_TRASH = DIR_PROJECT.$DOCUME.'trash_thumbnails/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/';

        // EXPEDIENTE //
            if(!is_dir($EXPEDIENTE_TRASH)) {
                if(!mkdir($EXPEDIENTE_TRASH, 0777, TRUE)) {
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'NO SE PUDO CREAR EL DIRECTORIO TRASH DEL EXPEDIENTE';
                    return $this->data;
                }
            }

            if(!copy($EXPEDIENTE.$this->docu['sNombre'], $EXPEDIENTE_TRASH.$this->docu['sNombre'])){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL MOVER EL DOCUMENTO';
                return $this->data;
            }

            chmod($EXPEDIENTE_TRASH.$this->docu['sNombre'], 0777);

            unlink($EXPEDIENTE.$this->docu['sNombre']);

        // THUMBNAIL //
            if(!empty($this->docu['sUbicacionThumbnail'])){
                $this->docu['sUbicacionThumbnail'] = 'trash_thumbnails/'.$this->docu['skTipoExpediente'].'/'.$this->docu['skCodigo'].'/'.$this->docu['sNombre'];
                if(!is_dir($THUMBNAIL_TRASH)) {
                    if(!mkdir($THUMBNAIL_TRASH, 0777, TRUE)) {
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'NO SE PUDO CREAR EL DIRECTORIO TRASH DEL THUMBNAIL';
                        return $this->data;
                    }
                }

                if(!copy($THUMBNAIL.$this->docu['sNombre'], $THUMBNAIL_TRASH.$this->docu['sNombre'])){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL MOVER EL THUMBNAIL DEL DOCUMENTO';
                    return $this->data;
                }

                chmod($THUMBNAIL_TRASH.$this->docu['sNombre'], 0777);

                unlink($THUMBNAIL.$this->docu['sNombre']);
            }
            
        // ACTUALIZAMOS LA UBICACIÓN DEL DOCUMENTO
            $stp_docu_documentos = parent::stp_docu_documentos();

            if(!$stp_docu_documentos || isset($stp_docu_documentos['success']) && $stp_docu_documentos['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL ELIMINAR EL DOCUMENTO';
                return $this->data;
            }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DOCUMENTO ELIMINADO';
        return $this->data;
    }

    /*
    * getInputData
    *
    * Obtener los datos de entrada
    *
    * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
    * @return Array ['success'=>NULL,'message'=>NULL,'data'=>NULL]
    */
    private function getInputData(){

        $this->data['success'] = TRUE;

        if(!$_POST && !$_GET){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'NO SE RECIBIERON DATOS';
            return $this->data;
        }

        if($_POST){
            foreach($_POST AS $key=>$val){
                if(!is_array($val)){
                    $this->docu[$key] = $val;
                    continue;
                }else{
                    $this->docu[$key] = $val;
                    continue;
                }
            }
        }

        if($_GET){
            foreach($_GET AS $key=>$val){
                if(!is_array($val)){
                    $this->docu[$key] = $val;
                    continue;
                }else{
                    $this->docu[$key] = $val;
                    continue;
                }
            }
        }

        return $this->data;
    }

    /**
     * validar_datos_entrada
     *
     * Valida los datos de entrada
     *
     * @author Christian Josué Jiménez Sánchez <christianjimenezcjs@gmail.com>
     * @return Array ['success'=>NULL,'message'=>NULL,'data'=>NULL]
     */
    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        $this->data['message'] = "";


        $validations = [
            'skTipoExpediente'=>['message'=>'TIPO DE EXPEDIENTE'],
            'skTipoDocumento'=>['message'=>'TIPO DE DOCUMENTO'],
            'skCodigo'=>['message'=>'CÓDIGO']
        ];

        foreach($validations AS $k=>$v){
            if(!isset($this->docu[$k]) || empty(trim($this->docu[$k]))){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return $this->data;
            }
            if(isset($v['validations'])){
                foreach($v['validations'] AS $valid){
                    switch ($valid) {
                        case 'integer':
                            $this->docu[$k] = str_replace(',','',$this->docu[$k]);
                            if(!preg_match('/^[0-9]+$/', $this->docu[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                return $this->data;
                            }
                        break;
                        case 'decimal':
                            $this->docu[$k] = str_replace(',','',$this->docu[$k]);
                            if(!preg_match('/^[0-9.]+$/', $this->docu[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                return $this->data;
                            }
                        break;
                        case 'date':
                            $this->docu[$k] = date('Y-m-d', strtotime(str_replace('/', '-', $this->docu[$k])));
                            if(!preg_match('/^[0-9\/-]+$/', $this->docu[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - FECHA NO VALIDA';
                                return $this->data;
                            }
                        break;
                    }
                }
            }
        }

        return $this->data;
    }

}