<?php
Class Cofa_inde_Controller Extends Admi_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'facturas'; //Mi procedimiento

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }
    //AQUÍ VAN LAS FUNCIONES//
    public function consulta(){
        $configuraciones = [];

        //$configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT 
        ofa.skFactura,
        ofa.iFolio,
        ofa.skEstatus,
        ofa.skEstatusPago,
        ofa.dFechaCreacion,
        ofa.skMetodoPago,
        ofa.skFormaPago,
        ofa.skUsoCFDI,
        ofa.skDivisa,
        ofa.sReferencia,
        ofa.fImpuestosRetenidos,
        ofa.fImpuestosTrasladados,
        ofa.fSubtotal,
        ofa.fTotal,
        ofa.fSaldo, 
        IF(ofa.iNoFacturable IS NOT NULL, 'SI',NULL) AS iNoFacturable,
        IF(ofa.skUUIDSAT IS NOT NULL, 'SI',NULL) AS skUUIDSAT,
        cef.sNombre AS facturacion,
        cerp.sNombre AS responsable,
        cu.sNombre AS usuarioCreacion,
        ce.sNombre AS estatus,
        ce.sIcono AS estatusIcono,
        ce.sColor AS estatusColor,
        cep.sNombre AS estatusPago,
        cep.sIcono AS estatusIconoPago,
        cep.sColor AS estatusColorPago

        FROM ope_facturas ofa
        LEFT JOIN core_estatus ce ON ce.skEstatus = ofa.skEstatus
        LEFT JOIN core_estatus cep ON cep.skEstatus = ofa.skEstatusPago
        LEFT JOIN rel_empresasSocios resf ON resf.skEmpresaSocio = ofa.skEmpresaSocioFacturacion
        LEFT JOIN cat_empresas cef ON cef.skEmpresa = resf.skEmpresa
        LEFT JOIN rel_empresasSocios resp ON resp.skEmpresaSocio = ofa.skEmpresaSocioResponsable
        LEFT JOIN cat_empresas cerp ON cerp.skEmpresa = resp.skEmpresa
        LEFT JOIN cat_usuarios cu ON cu.skUsuario = ofa.skUsuarioCreacion
        
        WHERE 1=1 ";
        
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= "   ";
        }

        // SE EJECUTA LA CONSULTA //
        $data = parent::crear_consulta($configuraciones);
        
        // Retorna el Resultado del Query para la Generación de Excel y Reportes Automáticos //
            if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
                return $data['data'];
            }
        
        // FORMATEAMOS LOS DATOS DE LA CONSULTA //
            $result = $data['data'];
            $data['data'] = [];
            foreach (Conn::fetch_assoc_all($result) AS $row) {
                utf8($row);

                
            //REGLA DEL MENÚ EMERGENTE
                $regla = [ 
                    "menuEmergente1" => $this->ME_noFacturable($row),
                    "menuEmergente2" => $this->ME_subirFactura($row),
                    "menuEmergente3" => $this->ME_pagarEfectivo($row)
                ];

                 $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''; 
                 $row['fSubtotal'] = (!empty($row['fSubtotal']) ? '$'.number_format($row['fSubtotal'],2) : '$ 0.00'); 
                 $row['fTotal'] = (!empty($row['fTotal']) ? '$'.number_format($row['fTotal'],2) : '$ 0.00'); 
                 $row['fSaldo'] = (!empty($row['fSaldo']) ? '$'.number_format($row['fSaldo'],2) : '$ 0.00'); 
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skFactura']);
                array_push($data['data'],$row);
        }
        return $data;
    }

     /* ME_noFacturable
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_noFacturable(&$row){
        if((in_array($row['skEstatus'], ['PE'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }

     /* ME_subirFactura
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_subirFactura(&$row){
        if((in_array($row['skEstatus'], ['PE'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }

     /* ME_pagarEfectivo
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_pagarEfectivo(&$row){
        if((in_array($row['skEstatusPago'], [NULL])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }


    //Función para generar excel
    public function generarExcel(){
        $data = $this->consulta();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    //Función para generar PDF
    public function generarPDF() {
        return parent::generar_pdf(
           $_POST['title'], 
           $_POST['headers'], 
           $this->consulta()
        );
    }

    public function noAplica(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->admi['axn'] = 'noAplica';
        $this->admi['skFactura'] = (isset($_POST['skFactura']) && !empty($_POST['skFactura'])) ? $_POST['skFactura'] : NULL;
        $stpCUD_facturas = parent::stpCUD_facturas();
        if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS FINALIZAR LA FACTURA.';
            return $this->data;
        }

        return $this->data;
    } 


    public function pagoEfectivo(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->admi['axn'] = 'pagoEfectivo';
        $this->admi['skFactura'] = (isset($_POST['skFactura']) && !empty($_POST['skFactura'])) ? $_POST['skFactura'] : NULL;
        $consultar_factura = parent::consultar_factura();

        $stpCUD_facturas = parent::stpCUD_facturas();
        if(!$stpCUD_facturas || isset($stpCUD_facturas['success']) && $stpCUD_facturas['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LA FACTURA COMO PAGADA';
            return $this->data;
        }

        $inputData = [
             'skTipoTransaccion'=>'TRAN',
            'skEmpresaSocioResponsable'=>isset($consultar_factura['skEmpresaSocioResponsable']) ? $consultar_factura['skEmpresaSocioResponsable'] : NULL,
            'skDivisa'=>isset($consultar_factura['skDivisa']) ? $consultar_factura['skDivisa'] : NULL,
            'fTipoCambio'=>isset($consultar_factura['fTipoCambio']) ? $consultar_factura['fTipoCambio'] : NULL,
            /**/'skBancoEmisor'=>isset($consultar_factura['skBancoEmisor']) ? $consultar_factura['skBancoEmisor'] : NULL,
            'sBancoCuentaEmisor'=>NULL,
            'dFechaTransaccion'=>isset($consultar_factura['dFechaCreacion']) ? $consultar_factura['dFechaCreacion'] : NULL,
            'sReferencia'=>' Pago en Efectivo de la pre-Factura con Folio: '.$consultar_factura['iFolioFactura'],
            'fImporte'=>isset($consultar_factura['fImporteTotal']) ? $consultar_factura['fImporteTotal'] : NULL,
            'skFormaPago'=>'196DBC4B-A55B-44E3-81CE-BFBBE5D8B430',
             /**/'skBancoReceptor'=>'497D170C-4040-4A32-91A3-0E1C6A51E824',
             /**/'skBancoCuentaReceptor'=>'18A48FE1-17FB-43BB-9D21-BC4815C02990',
            'sObservaciones'=>'Factura Pagada en Efectivo',
            'skEstatus'=>'VA',
            'skFactura'=>isset($consultar_factura['skFactura']) ? $consultar_factura['skFactura'] : NULL

      

        ];

        $guardarTransaccion = $this->sysAPI('admi', 'cotr_form', 'guardar', [
            'POST' => $inputData
         ]);

         if(!$guardarTransaccion || isset($guardarTransaccion['success']) && $guardarTransaccion['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS GENERALES DE FACTURAS.';
            return $this->data;
        }


        return $this->data;
    } 

    

     
}
    

