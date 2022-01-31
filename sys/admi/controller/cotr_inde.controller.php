<?php
Class Cotr_inde_Controller Extends Admi_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'transacciones'; //Mi procedimiento

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }
    //AQUÍ VAN LAS FUNCIONES//
    public function consulta(){
        $configuraciones = [];

        //$configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT tra.skTransaccion
        ,tra.skEstatus
        ,tra.iFolio AS iFolio
        ,tra.skEmpresaSocioPropietario
        ,tra.skEmpresaSocioResponsable
        ,tra.skEmpresaSocioCliente
        ,tra.sReferencia
        ,tra.skBancoEmisor
        ,tra.sBancoCuentaEmisor
        ,tra.skBancoReceptor
        ,tra.skBancoCuentaReceptor
        ,tra.skFormaPago
        ,tra.skDivisa
        ,tra.fTipoCambio
        ,tra.fImporte
        ,tra.fSaldo
        ,tra.sObservaciones
        ,tra.dFechaTransaccion
        ,tra.skUsuarioCancelacion
        ,tra.dFechaCancelacion
        ,tra.skDocumentoComprobante
        ,tra.sObservacionCancelacion
        ,tra.skUsuarioCreacion
        ,tra.dFechaCreacion
        ,tra.skUsuarioModificacion
        ,tra.dFechaModificacion
        ,tra.skTipoTransaccion
        ,CASE tra.skTipoTransaccion
            WHEN 'TRAN' THEN 'Transferencia'
            WHEN 'NCRE' THEN 'Nota de Crédito'
            WHEN 'SAFA' THEN 'Saldo a Favor'
        END AS tipoTransaccion
        ,est.sNombre AS estatus
        ,est.sIcono AS estatusIcono
        ,est.sColor AS estatusColor
       ,banE.sNombre AS bancoEmisor
        ,banR.sNombre AS bancoReceptor
        ,banCueR.sNumeroCuenta AS sNumeroCuentaReceptor
        ,banCueR.sTitular AS sTitularReceptor
        ,fp.sNombre AS formaPago 
        ,eR.sNombre AS empresaResponsable
        ,eR.sRFC AS empresaResponsableRFC
        ,eC.sNombre AS empresaCliente
        ,eC.sRFC AS empresaClienteRFC
        ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno,' ',ucre.sApellidoMaterno) AS usuarioCreacion
        ,CONCAT(umod.sNombre,' ',umod.sApellidoPaterno,' ',umod.sApellidoMaterno) AS usuarioModificacion
        ,CONCAT(ucan.sNombre,' ',ucan.sApellidoPaterno,' ',ucan.sApellidoMaterno) AS usuarioCancelacion
        FROM ope_transacciones tra
        INNER JOIN core_estatus est ON est.skEstatus = tra.skEstatus
        LEFT JOIN cat_bancos banE ON banE.skBanco = tra.skBancoEmisor
        LEFT JOIN cat_bancos banR ON banR.skBanco = tra.skBancoReceptor
        LEFT JOIN cat_bancosCuentas banCueR ON banCueR.skBancoCuenta = tra.skBancoCuentaReceptor
        INNER JOIN cat_formasPago fp ON fp.skFormaPago = tra.skFormaPago
        INNER JOIN rel_empresasSocios esR ON esR.skEmpresaSocio = tra.skEmpresaSocioResponsable
        INNER JOIN cat_empresas eR ON eR.skEmpresa = esR.skEmpresa
        LEFT JOIN rel_empresasSocios esC ON esC.skEmpresaSocio = tra.skEmpresaSocioCliente
        LEFT JOIN cat_empresas eC ON eC.skEmpresa = esC.skEmpresa
        INNER JOIN rel_empresasSocios Fes ON Fes.skEmpresaSocio = tra.skEmpresaSocioPropietario
        INNER JOIN cat_usuarios ucre ON ucre.skUsuario = tra.skUsuarioCreacion
        LEFT JOIN cat_usuarios umod ON umod.skUsuario = tra.skUsuarioModificacion
        LEFT JOIN cat_usuarios ucan ON ucan.skUsuario = tra.skUsuarioCancelacion WHERE 1=1 ";
        
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
                    "menuEmergente1" => $this->ME_editar($row),
                    "menuEmergente2" => $this->ME_aplicarPago($row)
                ];

                $row['dFechaTransaccion'] = ($row['dFechaTransaccion']) ? date('d/m/Y', strtotime($row['dFechaTransaccion'])) : ''; 
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : ''; 
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skTransaccion']);
                array_push($data['data'],$row);
        }
        return $data;
    }

     /* ME_editar
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_editar(&$row){
        if((in_array($row['skEstatus'], ['AU'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }
     /* ME_editar
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez >
    * @param type $row
    * @return int
    */
    public function ME_aplicarPago(&$row){
        if((in_array($row['skEstatus'], ['AU','PO'])) ){
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

     
}
    

