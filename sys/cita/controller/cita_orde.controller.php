<?php
Class Cita_orde_Controller Extends Cita_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_orde';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function guardar() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        Conn::begin($this->idTran);

        // Obtener datos de entrada de información
            $getInputData = $this->getInputData();
            if(!$getInputData['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // Validamos los datos de entrada
            $validar_datos_entrada = $this->validar_datos_entrada();
            if(!$validar_datos_entrada['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

            $this->cita['skCita'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);

        // guardar_datosFacturacion_cita 
            $guardar_datosFacturacion_cita = $this->guardar_datosFacturacion_cita();
            if(!$guardar_datosFacturacion_cita['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        // Guardar Servicios
            $guardar_cita_servicios = $this->guardar_cita_servicios();
            if(!$guardar_cita_servicios['success']){
            Conn::rollback($this->idTran);
                return $this->data;
            }
            
        // GENERAR ORDEN DE SERVICIO 
            $generar_ordenServicio = $this->generar_ordenServicio();
            if(!$generar_ordenServicio['success']){
                Conn::rollback($this->idTran);
                return $this->data;
            }

        Conn::commit($this->idTran);
        $this->data['datos'] = $this->cita;
        $this->data['success'] = TRUE;
        $this->data['message'] = 'REGISTRO GUARDADO CON ÉXITO.';
        return $this->data;
    }

    public function guardar_datosFacturacion_cita(){
        $this->data['success'] = TRUE;
        $this->cita['axn'] = 'guardar_datosFacturacion_cita';
        $this->cita['skEstatus'] = 'CF';

        $stp_cita_agendar = parent::stp_cita_agendar();
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DATOS DE LA CITA';
            return $this->data;
        }

        $this->cita['skCita'] = $stp_cita_agendar['skCita'];

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CITA GUARDADOS';
        return $this->data;

    }

    public function guardar_cita_servicios(){
        $this->data['success'] = TRUE;
          
        $delete = "DELETE FROM rel_citas_servicios WHERE skCita = ".escape($this->cita['skCita']);
        $result = Conn::query($delete);

        $delete = "DELETE FROM rel_citas_serviciosImpuestos WHERE skCita = ".escape($this->cita['skCita']);
        $result = Conn::query($delete);

        $this->cita['axn'] = 'guardar_cita_servicios';
        if(!empty($this->cita['servicios'])){
            foreach ($this->cita['servicios'] AS $srv){
                $this->cita['axn'] = 'guardar_cita_servicios';

                // AQUI VAN LOS SERVICIOS NORMALES.
                $this->cita['skServicio']           = (isset($srv['skServicio']) ? $srv['skServicio'] : NULL);
                $this->cita['sDescripcion']         = (isset($srv['sDescripcionConcepto']) ? $srv['sDescripcionConcepto'] : NULL);
                $this->cita['fCantidad']            = (isset($srv['fCantidad']) ? str_replace(',','',$srv['fCantidad']) : NULL);
                $this->cita['skUnidadMedida']       = (isset($srv['skUnidadMedida']) ? str_replace(',','',$srv['skUnidadMedida']) : NULL);
                $this->cita['fPrecioUnitario']      = (isset($srv['fPrecioUnitario']) ? str_replace(',','',$srv['fPrecioUnitario']) : NULL);
                $this->cita['fImporte']             = (isset($srv['fImporte']) ? str_replace(',','',$srv['fImporte']) : NULL);
                $this->cita['fDescuento']           = (isset($srv['fDescuento']) ? str_replace(',','',$srv['fDescuento']) : NULL);
                $this->cita['fImpuestosTrasladados']  = (isset($srv['fImpuestosTrasladados']) ? str_replace(',','',$srv['fImpuestosTrasladados']) : NULL);
                $this->cita['fImpuestosRetenidos']    = (isset($srv['fImpuestosRetenidos']) ? str_replace(',','',$srv['fImpuestosRetenidos']) : NULL);

                //VALIDACION DE DATOS
                if(empty($this->cita['skUnidadMedida']) || empty($this->cita['fCantidad']) || empty($this->cita['skServicio']) ){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'FALTA LLENAR CAMPO REQUERIDO EN SERVICIO';
                    return $this->data;
                }

                $stp_cita_agendar = parent::stp_cita_agendar();
                if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL SERVICIO';
                    return $this->data;
                }
                $this->cita['skCitaServicio'] = $stp_cita_agendar['skCitaServicio'];

                if(!empty($this->cita['fImpuestosTrasladados'])){
                        $this->cita['axn'] = "guardar_cita_serviciosImpuestos";
                        $this->cita['skImpuesto'] = "TRAIVA";
                        $this->cita['fImporte']  = (isset($srv['fImpuestosTrasladados']) ? str_replace(',','',$srv['fImpuestosTrasladados']) : NULL);
                        $stp_cita_agendar = parent::stp_cita_agendar();
                        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL SERVICIO';
                            return $this->data;
                        }
                }
                if(!empty($this->cita['fImpuestosRetenidos'])){
                        $this->cita['axn'] = "guardar_cita_serviciosImpuestos";
                        $this->cita['skImpuesto'] = "RETIVA";
                        $this->cita['fImporte']    = (isset($srv['fImpuestosRetenidos']) ? str_replace(',','',$srv['fImpuestosRetenidos']) : NULL);
                        $stp_cita_agendar = parent::stp_cita_agendar();
                        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                            $this->data['success'] = FALSE;
                            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL IMPUESTO DEL SERVICVIO';
                            return $this->data;
                        }
                }

            }
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'SERVICIOS DE ORDENES GUARDADOS';
        return $this->data;
    }

    /**
       * generar_orden
       *
       * Guardar generar_orden
       *
       * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
       * @return Array ['success'=>NULL,'message'=>NULL,'datos'=>NULL]
       */
      public function generar_ordenServicio(){
        $this->data['success'] = TRUE;
        $this->cita['axn'] = 'generar_orden';

        $generarOrden = $this->sysAPI('admi', 'orse_inde', 'generarOrden', [
            'POST'=>[
                'axn'=>'GE',
                'skProceso'=>'CITA',
                'skCodigo'=>$this->cita['skCita']
            ]
        ]);
        
        if(!$generarOrden || isset($generarOrden['success']) && $generarOrden['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = $generarOrden['message'];
            return $this->data;
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'ORDEN GENERADA CON EXITO';
        return $this->data;
    }

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
                    $this->cita[$key] = $val;
                    continue;
                }else{
                    $this->cita[$key] = $val;
                    continue;
                }
            }
        }

        if($_GET){
            foreach($_GET AS $key=>$val){
                if(!is_array($val)){
                    $this->cita[$key] = $val;
                    continue;
                }else{
                    $this->cita[$key] = $val;
                    continue;
                }
            }
        }

        return $this->data;
    }

    private function validar_datos_entrada(){
        $this->data['success'] = TRUE;
        $this->data['message'] = "";


        $validations = [
        //'skCategoriaCita'=>['message'=>'CATEGORÍA'],
        //'dFechaCita'=>['message'=>'FECHA DE CITA','validations'=>['date']],
        //'tHoraInicio'=>['message'=>'CATEGORÍA'],
        //'sNombre'=>['message'=>'NOMBRE'],
        //'sTelefono'=>['message'=>'TELÉFONO'],
        //'sCorreo'=>['message'=>'CORREO'],
        //'skEstadoMX'=>['message'=>'ESTADO'],
        //'skMunicipioMX'=>['message'=>'MUNICIPIO'],
        //'sDomicilio'=>['message'=>'DOMICILIO']
        ];

        foreach($validations AS $k=>$v){
            if(!isset($this->cita[$k]) || empty(trim($this->cita[$k]))){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return $this->data;
            }
            if(isset($v['validations'])){
                foreach($v['validations'] AS $valid){
                    switch ($valid) {
                        case 'integer':
                            $this->cita[$k] = str_replace(',','',$this->cita[$k]);
                            if(!preg_match('/^[0-9]+$/', $this->cita[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS';
                                return $this->data;
                            }
                        break;
                        case 'decimal':
                            $this->cita[$k] = str_replace(',','',$this->cita[$k]);
                            if(!preg_match('/^[0-9.]+$/', $this->cita[$k])){
                                $this->data['success'] = FALSE;
                                $this->data['message'] = $v['message'].' - INGRESAR NÚMEROS ENTEROS / DECIMALES';
                                return $this->data;
                            }
                        break;
                        case 'date':
                            $this->cita[$k] = date('Ymd', strtotime(str_replace('/', '-', $this->cita[$k])));
                            if(!preg_match('/^[0-9\/-]+$/', $this->cita[$k])){
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

    public function guardar_agendarCita(){
        $this->data['success'] = TRUE;
        $this->cita['axn'] = 'guardar_agendarCita';
        $this->cita['skEstatus'] = 'PE';

        $stp_cita_agendar = parent::stp_cita_agendar();
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LA CITA';
            return $this->data;
        }

        $this->cita['skCita'] = (isset($stp_cita_agendar['skCita']) ? $stp_cita_agendar['skCita'] : NULL);

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CITA GUARDADOS';
        return $this->data;
    }

    public function guardar_cita_correos(){
        $this->data['success'] = TRUE;
        $this->cita['axn'] = 'guardar_cita_correos';
      
        $delete="DELETE FROM rel_citas_correos WHERE skCita = ".escape($this->cita['skCita']);
        $result = Conn::query($delete);
       
        if(!empty($this->cita['sCorreos'])){
            $array_correos = $this->cita['sCorreos'];
            foreach ($array_correos AS $correo){
                $this->cita['axn'] = 'guardar_cita_correos';
                $this->cita['sCorreo']         = (!empty($correo) ? $correo : NULL);         
                 $stp_cita_agendar = parent::stp_cita_agendar();
                if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS CORREOS DE LA CITA';
                    return $this->data;
                }
            }
        }
        
        $this->data['success'] = TRUE;
        $this->data['message'] = 'CORREOS GUARDADOS CON ÉXITO';
        return $this->data;
}

    public function confirmar_cita_personal(){
        $this->data['success'] = TRUE;

        // BORRAMOS EL PERSONAL ACTUAL DE LA CITA //
            $this->cita['axn'] = 'delete_cita_personal';
            $stp_cita_agendar = parent::stp_cita_agendar();
            if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'HUBO UN ERROR AL CONFIGURAR EL PERSONAL DE LA CITA';
                return $this->data;
            }

        // GUARDAMOS EL PERSONAL DE LA CITA //
            $this->cita['axn'] = 'confirmar_cita_personal';
            $this->cita['skEstatus'] = 'AC';
            if(!empty($this->cita['skCitaPersonal_array'])){
                foreach($this->cita['skCitaPersonal_array'] AS $k=>$v){
                    $this->cita['skUsuarioPersonal'] = $v;
                    
                    $stp_cita_agendar = parent::stp_cita_agendar();
                    if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR EL PERSONAL DE LA CITA';
                        return $this->data;
                    }
    
                }
            }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE CITA GUARDADOS';
        return $this->data;
    }

    public function get_horarios_disponibles(){
        $this->data = ['success' => TRUE, 'message' => 'HORARIOS DISPONIBLES CARGADOS', 'datos' => NULL];

        $this->cita['dFechaCita'] = (isset($_POST['dFechaCita']) && !empty($_POST['dFechaCita'])) ? date('Ymd', strtotime(str_replace('/', '-', $_POST['dFechaCita']))) : NULL;

        $this->data['horarios_disponibles'] = parent::_get_horarios_disponibles([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        $this->data['horarios_descansos'] = parent::_get_horarios_descansos([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        $this->data['horarios_disponibles_excepciones'] = parent::_get_horarios_disponibles_excepciones([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        $this->data['horarios_descansos_excepciones'] = parent::_get_horarios_descansos_excepciones([
            'dFechaCita'=>$this->cita['dFechaCita']
        ]);

        return $this->data;
    }

    public function get_cat_municipiosMX(){
        $this->data = ['success' => TRUE, 'message' => 'MUNICIPIOS DISPONIBLES CARGADOS', 'datos' => NULL];

        $this->cita['skEstadoMX'] = (isset($_POST['skEstadoMX']) && !empty($_POST['skEstadoMX'])) ? $_POST['skEstadoMX'] : NULL;

        $this->data['cat_municipiosMX'] = parent::_get_cat_municipiosMX([
            'skEstadoMX'=>$this->cita['skEstadoMX'],
            'skEstatus'=>'AC'
        ]);

        return $this->data;
    }

    public function get_personal(){
        $this->cita['nombre'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $sql = "SELECT N1.* FROM (
            SELECT
                u.skUsuario AS id,CONCAT(u.sNombre,' ',u.sApellidoPaterno,' ',u.sApellidoMaterno) AS nombre
            FROM cat_usuarios u 
                WHERE u.skEstatus = 'AC'
            ) AS N1 WHERE 1=1 ";

        if(isset($this->cita['nombre']) && !empty(trim($this->cita['nombre']))){
            $sql .= " AND N1.nombre LIKE '%".escape($this->cita['nombre'],FALSE)."%' ";
        }

        $sql .= " LIMIT 10; ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;

    }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];
        $this->cita['skCita'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        
        $this->data['cat_citas_categorias'] = parent::_get_cat_citas_categorias([
            'skEstatus'=>'AC'
        ]);

        $this->data['cat_estadosMX'] = parent::_get_cat_estadosMX([
            'skEstatus'=>'AC'
        ]);

        $this->data['formaPago'] = parent::consultar_formasPago();
        $this->data['metodoPago'] = parent::consultar_metodosPago();
        $this->data['usoCFDI'] = parent::consultar_usosCFDI(); 

        $this->data['divisas'] = parent::_getDivisas();
        $this->data['categoria'] = parent::_getCategorias();
        
        // TIPO DE CAMBIO
            $this->data['fTipoCambio'] = parent::getVariable('TIPOCA');

        // BANCOS Y CUENTAS BANCARIAS
            $this->vent['skEmpresaSocioResponsable'] = $_SESSION['usuario']['skEmpresaSocio'];
            $getBancosCuentasResponsable = $this->getBancosCuentasResponsable();
            $this->data['get_bancosReceptor'] = isset($getBancosCuentasResponsable['datos']['bancos']) ? $getBancosCuentasResponsable['datos']['bancos']: [];
            $this->data['get_bancosCuentasReceptor'] = isset($getBancosCuentasResponsable['datos']['cuentasBancarias']) ? $getBancosCuentasResponsable['datos']['cuentasBancarias']: [];

        if(!empty($this->cita['skCita'])){
            
            $this->data['datos'] = parent::_get_citas([
                'skCita'=>$this->cita['skCita']
            ]);

            $this->data['citas_personal'] = parent::_get_citas_personal([
                'skCita'=>$this->cita['skCita']
            ]);

            $this->data['citas_correos'] = parent::_getCitasCorreos();

            $this->data['cat_municipiosMX'] = parent::_get_cat_municipiosMX([
                'skEstadoMX'=>$this->data['datos']['skEstadoMX'],
                'skEstatus'=>'AC'
            ]);
            
            $this->cita['dFechaCita'] = (isset($this->data['datos']['dFechaCita']) && !empty($this->data['datos']['dFechaCita'])) ? date('Ymd', strtotime(str_replace('/', '-', $this->data['datos']['dFechaCita']))) : NULL;

            $this->data['horarios_disponibles'] = parent::_get_horarios_disponibles([
                'dFechaCita'=>$this->cita['dFechaCita']
            ]);

            $this->data['horarios_descansos'] = parent::_get_horarios_descansos([
                'dFechaCita'=>$this->cita['dFechaCita']
            ]);

            $this->data['horarios_disponibles_excepciones'] = parent::_get_horarios_disponibles_excepciones([
                'dFechaCita'=>$this->cita['dFechaCita']
            ]);

            $this->data['horarios_descansos_excepciones'] = parent::_get_horarios_descansos_excepciones([
                'dFechaCita'=>$this->cita['dFechaCita']
            ]);

            $this->data['serviciosCita'] = parent::_getCitaServicios();

        }

        //exit('<pre>'.print_r($this->data,1).'</pre>');
        return
         $this->data;
    }

    public function getBancosCuentasResponsable(){
        $data = ['success'=>TRUE,'message'=>NULL,'datos'=>['bancos'=>[],'cuentasBancarias'=>[]]];
        $this->vent['skEmpresaSocioResponsable'] = isset($_POST['skEmpresaSocioResponsable']) ? $_POST['skEmpresaSocioResponsable'] : $this->vent['skEmpresaSocioResponsable'];
        
        $_getBancosCuentasResponsable = parent::_getBancosCuentasResponsable();
        if(!$_getBancosCuentasResponsable){
            $data['success'] = FALSE;
            $data['message'] = 'HUBO UN ERROR AL CONSULTAR LAS CUENTAS BANCARIAS';
            return $data;
        }
        
        foreach($_getBancosCuentasResponsable AS $row){
            if(!isset($data['datos']['bancos'][$row['skBanco']])){
                $data['datos']['bancos'][$row['skBanco']] = $row;
            }
            $data['datos']['cuentasBancarias'][$row['skBanco']][] = $row;
        }
        return $data;
    }

    public function get_empresas(){
        $this->cita['sNombre'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        if(isset($_POST['skEmpresaTipo']) && !empty($_POST['skEmpresaTipo'])){
            $skEmpresaTipo = json_decode($_POST['skEmpresaTipo'], true, 512);
            if(!is_array($skEmpresaTipo)){
                $skEmpresaTipo = $_POST['skEmpresaTipo'];
            }
            $this->cita['skEmpresaTipo'] = $skEmpresaTipo;
        }
        return parent::get_empresas();
    }

    public function get_medidas(){
        return parent::consultar_tiposMedidas();
    }

    public function get_servicios(){
        return parent::consultar_servicios();
    }

    public function get_servicio_impuestos(){
        $this->cita['skServicio'] = (isset($_POST['skServicio']) ? $_POST['skServicio'] : NULL);
        return parent::consultar_servicio_impuestos();
    }

    public function get_servicios_datos(){
        $this->cita['skServicio'] = (isset($_POST['skServicio']) ? $_POST['skServicio'] : NULL);
        $this->cita['skCategoriaPrecio'] = (isset($_POST['skCategoriaPrecio']) ? $_POST['skCategoriaPrecio'] : NULL);
        return parent::consultar_servicios_datos();
    }

}