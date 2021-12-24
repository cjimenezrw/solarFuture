<?php
Class Appa_inde_Controller Extends Admi_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'aplicaciones'; //Mi procedimiento

    public function __construct() {
        parent::init();
        $this->idTran = 'stpCUD_facturas';
    }

    public function __destruct() {
        
    }
    //AQUÍ VAN LAS FUNCIONES//
    public function consulta(){
        $configuraciones = [];

        //$configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT
        rtfc.fSaldoRestanteFactura
       ,rtfc.fSaldoAnteriorFactura
       ,rtfc.skEstatus
       ,rtfc.skTransaccionPago
       ,rtfc.fImporte AS importeFactura
       ,rtfc.dFechaCreacion AS fechaPago 
       ,occ.fTotal AS totalFactura
       ,occ.iFolio AS folioFactura
       ,occ.skDivisa
       ,cd.sNombre AS nombreDivisa
       ,RIGHT('TRA-' + RIGHT('000000'+ CAST(opt.iFolio AS VARCHAR(6)),6),10) AS folioTransaccion
       ,ce.sNombre AS estatus
       ,ce.sIcono AS estatusIcono
       ,ce.sColor AS estatusColor
       ,eR.sNombre AS empresaResponsable
       ,eC.sNombre AS empresaCliente
       ,CONCAT(uc.sNombre,' ',uc.sApellidoPaterno) AS usuarioCreacion
       ,cfp.sNombre AS formaPago
       ,cfp.sCodigo AS codigoFormaPago
       ,cmp.sNombre AS metodoPago
       ,cmp.sCodigo AS codigoMetodoPago 
       FROM rel_transacciones_facturas rtfc
       INNER JOIN core_estatus ce on ce.skEstatus = rtfc.skEstatus
       LEFT JOIN cat_usuarios uc ON uc.skUsuario =  rtfc.skUsuarioCreacion
       LEFT JOIN ope_facturas occ ON occ.skFactura = rtfc.skFactura
       LEFT JOIN cat_metodosPago cmp ON cmp.sCodigo = occ.skMetodoPago
       LEFT JOIN cat_formasPago cfp ON cfp.sCodigo = occ.skFormaPago
       INNER JOIN ope_transacciones opt ON opt.skTransaccion = rtfc.skTransaccion
       INNER JOIN rel_empresasSocios esR ON esR.skEmpresaSocio = occ.skEmpresaSocioResponsable
       INNER JOIN cat_empresas eR ON eR.skEmpresa = esR.skEmpresa
       LEFT JOIN rel_empresasSocios esC ON esC.skEmpresaSocio = occ.skEmpresaSocioFacturacion
       LEFT JOIN cat_empresas eC ON eC.skEmpresa = esC.skEmpresa
       LEFT JOIN cat_divisas cd ON cd.skDivisa = occ.skDivisa 
        WHERE 1 = 1 ";
        
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
                $regla = [ ];

                $row['fechaPago'] = ($row['fechaPago']) ? date('d/m/Y  H:i:s', strtotime($row['fechaPago'])) : ''; 
                 
               $row['menuEmergente'] = parent::menuEmergente($regla, $row['skTransaccionPago']);
                array_push($data['data'],$row);
        }
        return $data;
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

    /**
     * ME_Cancelar_AP
     *
     * Condición de Menú Emergente Cancelar_AP
     * Solo puede Cancelar_AP SI el skEstatus != EL
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @param type $row
     * @return array
     */
    public function ME_Cancelar_AP(&$row, $function = FALSE){
        if(!$function){
            if(in_array($row['skEstatus'], ['CA']) || !empty($row['complemento'])){
                return SELF::DESHABILITADO;
            }else{
                return SELF::HABILITADO;
            }
            return SELF::OCULTO;
        }else{

            Conn::begin($this->idTran);
            $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];

            $this->admi['axn'] = 'cancelar_transaccion_aplicacion_pago';
            $this->admi['skTransaccionPago'] = (isset($_POST['id']) ? $_POST['id'] : NULL);
            $this->admi['sObservacionCancelacion'] = (isset($_POST['sObservaciones']) ? $_POST['sObservaciones'] : NULL);
    
            if($this->admi['skTransaccionPago']){

                $stpCUD_transacciones = parent::stpCUD_transacciones();
                if(!$stpCUD_transacciones || isset($stpCUD_transacciones['success']) && $stpCUD_transacciones['success'] != 1){
                    $this->data = ['success'=>FALSE,'message'=>'NO SE PUDO CANCELAR EL REGISTRO','datos'=>NULL];
                    Conn::rollback($this->idTran);
                    return $this->data;
                }
            }
            Conn::commit($this->idTran);
            return $this->data;
        }
    }

     
}
    

