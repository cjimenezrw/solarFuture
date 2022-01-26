<?php
Class Cita_deta_Controller Extends Cita_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_deta';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

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

    public function formatoPDF() {
        //exit('<pre>'.print_r($_SESSION['usuario'],1).'</pre>');
        $this->data = $this->getDatos();

        $HEACOT = parent::getVariable('HEACOT');
        $this->data['PIECOT'] = parent::getVariable('PIECOT');
        
        ob_start();
            $this->load_view('formato_cita', $this->data, NULL, FALSE);
            $formato_cita = ob_get_contents();
        ob_end_clean();

        parent::pdf([
            [
                'content' => $formato_cita,
                'defaultWatermark' => false,
                'header' => '
                <div class="pdf_cabecera">
                    <div style="width:40%;float: left;"><img style=""  src="' . CORE_PATH . 'assets/tpl/images/logoOriginal.png" width="300" height="100"></div>
                    <div style="width:57%;float: left;background-color:#FFFFFF; color:white;padding-top:35px;padding-left:15px;border-left:.5px solid gray;color:#cecece;">
                    <span class="bold" style="font-size: 9px;text-transform: uppercase;color:#000000;">'.$_SESSION['usuario']['sEmpresa'].'</span><br>
                    <span class="bold" style="font-size: 9px;text-transform: uppercase;color:#000000;">RFC: '.array_keys($_SESSION['usuario']['rfc'])[0].'</span><br>
                    <span style="font-size: 9px;color:#000000;">'.$HEACOT.'</span>
                    </div>
                    <hr style="color:#cecece;">
                </div>',
                'footer' => '<div></div>',
                'defaultFooter' => false,
                'defaultHeader' => false,
                'pdf' => [
                    'contentMargins' => [10, 15, 35, 5],
                    'format' => 'LETTER',
                    'vertical' => 'L',
                    'footerMargin' => 5,
                    'headerMargin' => 5,
                    'fileName' => 'Cita '.$this->data['datos']['iFolio'].'.pdf',
                    'directDownloadFile' => (isset($_GET['directDownloadFile']) && $_GET['directDownloadFile'] == true ? true : false)
                ]
            ]
            
        ]);

        return true;
    }

}