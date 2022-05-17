<?php
Class Cita_inde_Controller Extends Cita_Model {

    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_inde';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function consultar(){
        $configuraciones = [];
        $configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT 
         cit.skCita
        ,cit.skEstatus
        ,CONCAT('CIT-',RIGHT(CONCAT('0000',CAST(cit.iFolio AS VARCHAR(4))),4)) AS iFolio
        ,cit.skEmpresaSocioPropietario
        ,cit.skEmpresaSocioFacturacion
        ,cit.skEmpresaSocioCliente
        ,cit.sAsunto
        ,cit.skCategoriaCita
        ,cit.dFechaCita
        ,cit.tHoraInicio
        ,cit.tHoraFin
        ,cit.skTipoPeriodo
        ,cit.sTelefono
        ,cit.skEstadoMX
        ,cit.skMunicipioMX
        ,cit.sDomicilio
        ,cit.sObservaciones
        ,cit.sInstruccionesServicio
        ,cit.skDivisa
        ,cit.fTipoCambio
        ,cit.fImporteSubtotal
        ,cit.fImpuestosRetenidos
        ,cit.fImpuestosTrasladados
        ,cit.fDescuento
        ,cit.fImporteTotal
        ,cit.fImporteTotalSinIVA
        ,cit.iNoFacturable
        ,cit.skMetodoPago
        ,cit.skFormaPago
        ,cit.skUsoCFDI
        ,cit.skUsuarioConfirmacion
        ,cit.dFechaConfirmacion
        ,cit.sObservacionesFinalizacion
        ,cit.skUsuarioFinalizacion
        ,cit.dFechaFinalizacion
        ,cit.sObservacionesCancelacion
        ,cit.skUsuarioCancelacion
        ,cit.dFechaCancelacion
        ,cit.skUsuarioCreacion
        ,cit.dFechaCreacion
        ,cit.skUsuarioModificacion
        ,cit.dFechaModificacion

        ,cate.sNombreCategoria
        ,cate.sClaveCategoriaCita
        ,cate.iMinutosDuracion
        ,cate.sColorCategoria

        ,est.sNombre AS estatus
        ,est.sIcono AS estatusIcono
        ,est.sColor AS estatusColor

        ,esMX.sNombre AS estado
        ,muMX.sNombre AS municipio

        ,IF(cit.sNombreCliente IS NOT NULL, cit.sNombreCliente, IF(e_cli.sNombreCorto IS NOT NULL, e_cli.sNombreCorto, e_cli.sNombre)) AS sNombreCliente
        ,IF(e_cli.sNombreCorto IS NOT NULL, e_cli.sNombreCorto, e_cli.sNombre) AS empresaCliente
        ,e_cli.sRFC AS empresaClienteRFC
        ,IF(e_fac.sNombreCorto IS NOT NULL, e_fac.sNombreCorto, e_fac.sNombre) AS empresaFacturacion
        ,e_fac.sRFC AS empresaFacturacionRFC

        ,CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion
        ,CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion
        ,CONCAT(uConf.sNombre,' ',uConf.sApellidoPaterno,' ',uConf.sApellidoMaterno) AS usuarioConfirmacion
        ,CONCAT(uFin.sNombre,' ',uFin.sApellidoPaterno,' ',uFin.sApellidoMaterno) AS usuarioFinalizacion
        ,CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion

        ,di.sNombre AS divisa

        ,CONCAT('ORD-', LPAD(os.iFolio, 5, 0))  AS iFolioOrdenCobro
        ,os_est.sNombre AS estatusOrdenCobro
        ,os_est.sIcono AS estatusIconoOrdenCobro
        ,os_est.sColor AS estatusColorOrdenCobro
        ,IF(os.iNoFacturable IS NOT NULL, os.fImporteTotalSinIva, os.fImporteTotal) AS fImporteTotalOrdenCobro

        ,f.iFolio AS iFolioFactura
        ,f_est.sNombre AS estatusFactura
        ,f_est.sIcono AS estatusIconoFactura
        ,f_est.sColor AS estatusColorFactura
        ,f.fTotal AS fTotalFactura
        ,f.fSaldo AS fSaldoFactura

        ,(
            SELECT SUM(tf.fImporte) AS fTotalAplicacionPago
            FROM rel_transacciones_facturas tf
            INNER JOIN ope_transacciones tr ON tr.skTransaccion = tf.skTransaccion
            INNER JOIN cat_formasPago fp ON fp.skFormaPago = tr.skFormaPago AND fp.sCodigo IN ('03')
            WHERE tf.skFactura = f.skFactura AND tf.skEstatus = 'AC'
        ) AS fTotalAplicacionPagoTransferencia

        ,(
            SELECT SUM(tf.fImporte) AS fTotalAplicacionPago
            FROM rel_transacciones_facturas tf
            INNER JOIN ope_transacciones tr ON tr.skTransaccion = tf.skTransaccion
            INNER JOIN cat_formasPago fp ON fp.skFormaPago = tr.skFormaPago AND fp.sCodigo IN ('01')
            WHERE tf.skFactura = f.skFactura AND tf.skEstatus = 'AC'
        ) AS fTotalAplicacionPagoEfectivo

        FROM ope_citas cit
        INNER JOIN cat_citas_categorias cate ON cate.skCategoriaCita = cit.skCategoriaCita
        INNER JOIN core_estatus est ON est.skEstatus = cit.skEstatus
        INNER JOIN cat_estadosMX esMX ON esMX.skEstadoMX = cit.skEstadoMX
        INNER JOIN cat_municipiosMX muMX ON muMX.skMunicipioMX = cit.skMunicipioMX
        INNER JOIN cat_usuarios uCre ON uCre.skUsuario = cit.skUsuarioCreacion
        INNER JOIN rel_empresasSocios res_cli ON res_cli.skEmpresaSocio = cit.skEmpresaSocioCliente
        INNER JOIN cat_empresas e_cli ON e_cli.skEmpresa = res_cli.skEmpresa
        LEFT JOIN rel_empresasSocios res_fac ON res_fac.skEmpresaSocio = cit.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas e_fac ON e_fac.skEmpresa = res_fac.skEmpresa
        LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = cit.skUsuarioModificacion
        LEFT JOIN cat_usuarios uConf ON uConf.skUsuario = cit.skUsuarioConfirmacion
        LEFT JOIN cat_usuarios uFin ON uFin.skUsuario = cit.skUsuarioFinalizacion
        LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = cit.skUsuarioCancelacion
        LEFT JOIN cat_divisas di ON di.skDivisa = cit.skDivisa

        LEFT JOIN rel_ordenesServicios_procesos osp ON osp.skServicioProceso = 'CITA' AND osp.skCodigo = cit.skCita
        LEFT JOIN ope_ordenesServicios os ON os.skOrdenServicio = osp.skOrdenServicio AND os.skEstatus != 'CA'
        LEFT JOIN core_estatus os_est ON os_est.skEstatus = os.skEstatus
        LEFT JOIN rel_ordenesServicios_facturas osf ON osf.skOrdenServicio = os.skOrdenServicio
        LEFT JOIN ope_facturas f ON f.skFactura = osf.skFactura AND f.skEstatus != 'CA'
        LEFT JOIN core_estatus f_est ON f_est.skEstatus = f.skEstatus

        WHERE 1=1 ";

        if(!isset($_POST['filters'])){
            //$configuraciones['query'] .= " AND cit.skEstatus != 'CA' ";
        }

        // SE EJECUTA LA CONSULTA //
            $data = parent::crear_consulta($configuraciones);
        
        // Retorna el Resultado del Query para la Generación de Excel y Reportes Automáticos //
            if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
                return $data['data'];
            }
        
        // RECORREMOS LOS DATOS DE LA CONSULTA //
            $result = $data['data'];
            $data['data'] = [];
            foreach (Conn::fetch_assoc_all($result) AS $row) {
                utf8($row);

                
            // REGLAS DEL MENÚ EMERGENTE //
                /*
                    1.- Editar
                    2.- Confirmar / Reprogramar
                    3.- Generar Formato
                    4.- Descargar PDF
                    5.- Generar Orden de Servicio
                    6.- Cancelar
                    7.- Finalizar
                    8.- Detalles
                */
                $regla = [
                    'menuEmergente1'=>($row['skEstatus'] == 'PE' ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente2'=>(in_array($row['skEstatus'], ['PE','CF','FI']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente3'=>(in_array($row['skEstatus'], ['PE','CF','FI','VE']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente4'=>(in_array($row['skEstatus'], ['PE','CF','FI','VE']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente5'=>((in_array($row['skEstatus'], ['CF','FI']) && empty($row['iFolioOrdenCobro'])) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente6'=>(in_array($row['skEstatus'], ['PE','CF']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente7'=>(in_array($row['skEstatus'], ['CF']) ? SELF::HABILITADO : SELF::DESHABILITADO),
                    'menuEmergente8'=>SELF::HABILITADO
                ];
            
            // FORMATEO DE DATOS //
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : NULL;
                $row['dFechaCita'] = ($row['dFechaCita']) ? date('d/m/Y', strtotime($row['dFechaCita'])) : NULL;
                $row['dFechaModificacion'] = ($row['dFechaModificacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaModificacion'])) : NULL;
                $row['dFechaConfirmacion'] = ($row['dFechaConfirmacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaConfirmacion'])) : NULL;
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skCita']);
            
            array_push($data['data'],$row);
        }
        return $data;
    }

    public function generarExcel(){
        parent::generar_excel(html_entity_decode($_POST['title']), $_POST['headers'], $this->consultar());
    }

    public function generarPDF(){
        parent::generar_pdf(html_entity_decode($_POST['title']), $_POST['headers'], $this->consultar());
    }

    public function descargarEstadoCuenta(){
        $consultar = $this->consultar();
        $records = Conn::fetch_assoc_all($consultar);
        utf8($records,FALSE);

        $excel_headers = [
             'F. Ticket Servicio'
            ,'Estatus Ticket Servicio'
            ,'Categoría'
            ,'Fecha Creación'
            ,'Cliente'
            ,'Teléfono'
            ,'Domicilio'
            ,'F. Orden Cobro'
            ,'Estatus Orden Cobro'
            ,'F. Factura'
            ,'Estatus Factura'
            ,'Total Factura'
            ,'Total Efectivo'
            ,'Total Transferencia'
            ,'Saldo Factura'
            ,'Observaciones'
        ];

        $excel_data = [];
        foreach($records AS $k=>$v){
            array_push($excel_data,[
                 $v['iFolio']
                ,$v['estatus']
                ,$v['sNombreCategoria']
                ,(($v['dFechaCreacion']) ? date('d/m/Y', strtotime($v['dFechaCreacion'])) : NULL)
                ,$v['empresaCliente']
                ,$v['sTelefono']
                ,$v['sDomicilio']
                ,$v['iFolioOrdenCobro']
                ,$v['estatusOrdenCobro']
                ,$v['iFolioFactura']
                ,$v['estatusFactura']
                ,$v['fTotalFactura']
                ,$v['fTotalAplicacionPagoEfectivo']
                ,$v['fTotalAplicacionPagoTransferencia']
                ,$v['fSaldoFactura']
                ,$v['sObservaciones']
            ]);
        }

        $excel_conf = [
            'fileName' => 'Reporte de Estado de Cuenta - Ticket de Servicio',
            'format' => 'xlsx',
            'pages' => [
                'Estado de Cuenta' => [
                    'startAt' => 'A1',
                    'headers' => $excel_headers,
                    'headersOrientation' => 'H',
                    'data' => $excel_data
                ]
            ]
        ];

        parent::excel($excel_conf);
        return true;
    }

    public function recordatorio_tickets(){
        set_time_limit(-1);
        ini_set('memory_limit', '-1');

        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $RETICK = parent::getVariable('RETICK');
        $dFechaInicio = date('d/m/Y');
        $dFechaFin =date('d/m/Y', strtotime('+'.$RETICK.' day'));

        $_POST['generarExcel'] = true;
        $_POST['headers'] = '[{"title":"Estatus","column":"estatus","dataType":"string"},{"title":"Folio","column":"iFolio","dataType":"string"},{"title":"Folio Orden Cobro","column":"iFolioOrdenCobro","dataType":"string"},{"title":"Folio Factura","column":"iFolioFactura","dataType":"string"},{"title":"Categoría","column":"sNombreCategoria","dataType":"string"},{"title":"Fecha Cita","column":"dFechaCita","dataType":"date"},{"title":"Hora Cita","column":"tHoraInicio","dataType":"string"},{"title":"Cliente","column":"empresaCliente","dataType":"string"},{"title":"Nombre","column":"sNombreCliente","dataType":"string"},{"title":"Teléfono","column":"sTelefono","dataType":"string"},{"title":"Estado","column":"estado","dataType":"string"},{"title":"Municipio","column":"municipio","dataType":"string"},{"title":"Dirección","column":"sDomicilio","dataType":"string"},{"title":"Observaciones","column":"sObservaciones","dataType":"string"},{"title":"Intrucción Servicio","column":"sInstruccionesServicio","dataType":"string"},{"title":"Usuario Confirmación","column":"usuarioConfirmacion","dataType":"string"},{"title":"Fecha Confirmación","column":"dFechaConfirmacion","dataType":"date"},{"title":"Usuario Creación","column":"usuarioCreacion","dataType":"string"},{"title":"Fecha Creación","column":"dFechaCreacion","dataType":"date"}]';
        $_POST['order'] = 'dFechaCita';
        $_POST['orderDir'] = 'asc';

        $_POST['filters'] = [[
             'column'=>'dFechaCita'
            ,'rule'=>'BETWEEN'
            ,'value'=>($dFechaInicio.','.$dFechaFin)
            ,'type'=>'date'
        ]];

        $consultar = $this->consultar();
        $records = Conn::fetch_assoc_all($consultar);
        utf8($records,FALSE);

        $excel_headers = [
             'F. Ticket Servicio'
            ,'Estatus Ticket Servicio'
            ,'Categoría'
            ,'Fecha Creación'
            ,'Fecha Cita'
            ,'Hora Cita'
            ,'Cliente'
            ,'Teléfono'
            ,'Domicilio'
            ,'F. Orden Cobro'
            ,'Estatus Orden Cobro'
            ,'F. Factura'
            ,'Estatus Factura'
            ,'Total Factura'
            ,'Total Efectivo'
            ,'Total Transferencia'
            ,'Saldo Factura'
            ,'Observaciones'
        ];

        $excel_data = [];
        foreach($records AS $k=>$v){
            array_push($excel_data,[
                 $v['iFolio']
                ,$v['estatus']
                ,$v['sNombreCategoria']
                ,(($v['dFechaCreacion']) ? date('d/m/Y', strtotime($v['dFechaCreacion'])) : NULL)
                ,(($v['dFechaCita']) ? date('d/m/Y', strtotime($v['dFechaCita'])) : NULL)
                ,$v['tHoraInicio']
                ,$v['empresaCliente']
                ,$v['sTelefono']
                ,$v['sDomicilio']
                ,$v['iFolioOrdenCobro']
                ,$v['estatusOrdenCobro']
                ,$v['iFolioFactura']
                ,$v['estatusFactura']
                ,$v['fTotalFactura']
                ,$v['fTotalAplicacionPagoEfectivo']
                ,$v['fTotalAplicacionPagoTransferencia']
                ,$v['fSaldoFactura']
                ,$v['sObservaciones']
            ]);
        }


        $file_name = rand(1,1000).time();
        
        $excel_conf = [
            'fileName' => $file_name,
            'fileLocation' => TMP_HARDPATH,
            'format' => 'xlsx',
            'pages' => [
                'Tickets de Servicio' => [
                    'startAt' => 'A1',
                    'headers' => $excel_headers,
                    'headersOrientation' => 'H',
                    'data' => $excel_data
                ]
            ]

        ];

        parent::excel($excel_conf);

        $mensaje = '<style type="text/css">@font-face {  font-family: "Assistant";  font-style: normal;  font-weight: 400;  src: local("Assistant"), local("Assistant-Regular"), url(https://fonts.gstatic.com/s/assistant/v2/2sDcZGJYnIjSi6H75xkzamW5O7w.woff2) format("woff2");  unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;}/* latin */@font-face {  font-family: "Assistant";  font-style: normal;  font-weight: 400;  src: local("Assistant"), local("Assistant-Regular"), url(https://fonts.gstatic.com/s/assistant/v2/2sDcZGJYnIjSi6H75xkzaGW5.woff2) format("woff2");  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}body{  background-color: #f1f4f5;}.div1 {  width: 100%;  height:auto;  background-color:#064480 ;  margin: 0 auto;  border-radius: 5px 5px 0px 0px;  text-align: center;}.div2 {  width: 100%;  height:auto;  background-color:#FFFFFF ;  margin: 0 auto;  text-align: center;}.div3{  width: 100%;  height:auto;  background-color:#ffffff ;  margin: 0 auto;  border-radius: 0px 0px 5px 5px;  text-align: center;}.cont{  width: 50%;  min-width: 500px;  max-width: 700px;  height:auto;  margin: 0 auto;  border-radius: 5px 5px 5px 5px;}.imgMail{  width: 100px;}.imgFooter{  width: 100px;}.title-mail{  color: #ffffff;  font-family: "Assistant"; font-size: 22px;}.message-mail{  color: #000000;  font-family: "Assistant"; font-size: 16px;  font-weight: 600;}.footer-text-mail{  color: #76838f;  font-family: "Assistant"; font-size: 13px;}.footer{  background-color: #f5f5f5;  border-radius: 0px 0px 5px 5px;}.button {  background-color: #064480;  border: none;  color: white;  padding: 10px;  text-align: center;  text-decoration: none;  display: inline-block;  font-size: 16px;  margin: 4px 2px;  cursor: pointer;  border-radius: 4px;}.widget {  box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);  -webkit-box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);  -moz-box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);}</style><center><div style="background-color:#064480; border-radius:5px 5px 0px 0px; height:auto; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; text-align:center; width:700px" class="div1"><div style="text-align:center"><br></div>
        <div style="text-align:center"><br></div>
        <div style="text-align:center"><img data-cke-saved-src="'.SYS_URL.'core/assets/custom/img/mail.png" src="'.SYS_URL.'core/assets/custom/img/mail.png" style="width:100px" class="imgMail"></div>
        <div style="color:#ffffff; font-family:Tahoma,Verdana,Segoe,sans-serif; font-size:22px; text-align:center" class="title-mail">&nbsp;Solar Future Manzanillo</div>
        <div style="text-align:center"><br></div>
        <div style="text-align:center"><br></div>
        </div>
        <div style="height:auto; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; text-align:center; width:700px" class="div2"><div style="text-align:center"><br></div>
        </div>
        <div style="width: 700px; color:#000000; font-family:Tahoma,Verdana,Segoe,sans-serif; font-size:16px; text-align:center" class="message-mail">

        <p><span style="font-weight: bold;">Recordatorio de Citas</span><br><br>

        <p><span style="font-weight: bold;">Fechas</span><br>
        <span style="font-weight: normal;">'.$dFechaInicio.' a '.$dFechaFin.'</span></p>

        <center><div style="border-radius:0px 0px 5px 5px; height:auto; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; text-align:center; width:700px" class="div3"><div style="text-align:center"><br></div>
        <div style="color:#76838f; font-family:Tahoma,Verdana,Segoe,sans-serif; font-size:13px; text-align:center" class="footer-text-mail">Solar Future Manzanillo</div>
        <div style="text-align:center"><br></div>
        <div style="background-color:#f5f5f5; border-radius:0px 0px 5px 5px; text-align:center" class="footer"><img data-cke-saved-src="'.SYS_URL.'core/assets/tpl/images/logoHeader.png" src="'.SYS_URL.'core/assets/tpl/images/logoHeader.png" style="width:100px" class="imgFooter"></div>
        </div>
        </center></center>';

        $sendMail = parent::sendMail([
            'subject' => 'Portal Web - Solar Future',
            'from' => NULL,
            'to' => ['administracion@sfmzo.com'],
            'cc' => ['christian@sfmzo.com','christianjimenezcjs@gmail.com'],
            'bcc' => ['christianjimenezcjs@gmail.com'],
            'msg' => $mensaje,
            'send1by1' => FALSE,
            'msgPriority' => 1,
            'iDeleteFiles' => FALSE,
            'fechaProgramacion'=> NULL,
            'envioInstantaneo' => TRUE,
            'files' => [
                [TMP_HARDPATH.$file_name.'.xlsx','Reporte de Tickets de Servicio.xlsx']
            ]
        ]);

        if(!$sendMail){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL ENVIAR EL CORREO';
            return $this->data;
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'NOTIFICACIÓN ENVIADA CON ÉXITO';
        return $this->data;

    }

    public function formatoPDF(){
        $formatoPDF = $this->sysAPI('cita', 'cita_deta', 'formatoPDF', [
            'GET' => [
                'p1' => (isset($_GET['id']) ? $_GET['id'] :  NULL),
                'directDownloadFile' => true
            ]
         ]);
         return true;
    }

    public function cancelar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cita['axn'] = 'cancelar_cita';
        $this->cita['skCita'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->cita['sObservaciones'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        $this->cita['skEstatus'] = 'CA';

        $stp_cita_agendar = parent::stp_cita_agendar();  
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }

    public function finalizar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cita['axn'] = 'finalizar_cita';
        $this->cita['skCita'] = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : NULL;
        $this->cita['sObservaciones'] = (isset($_POST['sObservaciones']) && !empty($_POST['sObservaciones'])) ? $_POST['sObservaciones'] : NULL;
        $this->cita['skEstatus'] = 'FI';

        $stp_cita_agendar = parent::stp_cita_agendar();  
        if(!$stp_cita_agendar || isset($stp_cita_agendar['success']) && $stp_cita_agendar['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL FINALIZAR EL REGISTRO';
            return $this->data;
        }

        return $this->data;
    }

}