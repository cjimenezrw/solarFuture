<?php
Class Cont_inde_Controller Extends Cont_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];
    private $idTran = 'solicitud'; //Mi procedimiento

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
             oca.skContrato
            ,CONCAT('CON-', LPAD(oca.iFolio, 5, 0))  AS iFolio
            ,oca.skEstatus
            ,oca.skEmpresaSocioCliente
            ,oca.skTipoContrato
            ,oca.dFechaInstalacion
            ,oca.iFrecuenciaMantenimientoMensual
            ,oca.iDiaMantenimiento
            ,oca.dFechaProximoMantenimiento
            ,oca.sTelefono
            ,oca.sCorreo
            ,oca.sDomicilio
            ,oca.sObservaciones
            ,oca.skEmpresaSocioPropietario
            ,oca.sObservacionesCancelacion
            ,oca.dFechaCancelacion
            ,oca.skUsuarioCancelacion
            ,oca.dFechaCreacion
            ,oca.skUsuarioCreacion
            ,oca.dFechaModificacion
            ,oca.skUsuarioModificacion
            
            ,est.sNombre AS estatus
            ,est.sColor AS estatusColor
            ,est.sIcono AS estatusIcono

            ,e.sNombre AS cliente

            ,CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion
            ,CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion
            ,CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion

            ,TIPCON.sNombre AS tipoContrato

            FROM ope_contratos oca
            INNER JOIN core_estatus est ON est.skEstatus = oca.skEstatus
            INNER JOIN rel_empresasSocios es ON es.skEmpresaSocio = oca.skEmpresaSocioCliente
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN cat_usuarios uCre ON uCre.skUsuario = oca.skUsuarioCreacion 
            LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = oca.skUsuarioModificacion
            LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = oca.skUsuarioCancelacion
            INNER JOIN rel_catalogosSistemasOpciones TIPCON ON TIPCON.skCatalogoSistema = 'TIPCON' AND TIPCON.skClave = oca.skTipoContrato
            WHERE 1 = 1";
         
        if(!isset($_POST['filters'])){
            $configuraciones['query'] .= "  ";
        }

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

            // REGLA DEL MENÚ EMERGENTE
            $regla = [ 
                "menuEmergente1" => $this->ME_editar($row),
                "menuEmergente2" => $this->ME_generarOrden($row),
                "menuEmergente3" => $this->ME_cancelar($row),
                "menuEmergente4" => self::HABILITADO
            ];

            $row['dFechaInstalacion'] = (!empty($row['dFechaInstalacion']) ? date('d/m/Y', strtotime($row['dFechaInstalacion'])) : ''); 
            $row['dFechaProximoMantenimiento'] = (!empty($row['dFechaProximoMantenimiento']) ? date('d/m/Y', strtotime($row['dFechaProximoMantenimiento'])) : '');
            $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])) : ''; 

            $row['menuEmergente'] = parent::menuEmergente($regla, $row['skContrato']);
            array_push($data['data'],$row);
        }
        return $data;
    }

    public function generarExcel(){ parent::generar_excel($_POST['title'], $_POST['headers'], $this->consulta()); }
    
    public function generarPDF(){ parent::generar_pdf($_POST['title'], $_POST['headers'], $this->consulta()); }

    /* ME_editar
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez>
    * @param type $row
    * @return int
    */
    public function ME_editar(&$row){
        if((in_array($row['skEstatus'], ['AC'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }
    
    /* ME_generarOrden
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez>
    * @param type $row
    * @return int
    */
    public function ME_generarOrden(&$row){
        return self::OCULTO;
        if((in_array($row['skEstatus'], ['AC'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }
    /* ME_cancelar
    *
    * @author Luis Alberto Valdez Alvarez <lvaldez>
    * @param type $row
    * @return int
    */
    public function ME_cancelar(&$row){
        if((in_array($row['skEstatus'], ['AC'])) ){
            return self::HABILITADO;
        }
        return self::DESHABILITADO;
    }
   
    public function cancelar(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cont['axn'] = 'cancelar';
        $this->cont['skContrato'] = (isset($_POST['skContrato']) && !empty($_POST['skContrato'])) ? $_POST['skContrato'] : NULL;

        $stpCUD_contratos = parent::stpCUD_contratos();  
        if(!$stpCUD_contratos || isset($stpCUD_contratos['success']) && $stpCUD_contratos['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL CANCELAR EL CONTRATO. ';
            return $this->data;
        }

        return $this->data;
    } 

    public function generarOrden(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

       
        $this->oper['skContrato'] = (isset($_POST['skContrato']) && !empty($_POST['skContrato'])) ? $_POST['skContrato'] : NULL;

        $generarOrden = $this->sysAPI('admi', 'orse_inde', 'generarOrden', [
            'POST'=>[
                'axn'=>'GE',
                'skProceso'=>'CONT',
                'skCodigo'=>$this->oper['skContrato']
            ]
        ]); 
        if(!$generarOrden || isset($generarOrden['success']) && $generarOrden['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = $generarOrden['message'];
            return $this->data;
        }
         

        

        return $this->data;
    } 

    public function cobros_contratos(){
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        set_time_limit(-1);
        ini_set('memory_limit', '-1');
        $sql=" SELECT 
        oca.dFechaInicioCobro,
        oca.iDiaCorte,
        oca.skContrato,
        oca.skTipoPeriodo,
        oca.skEmpresaSocioCliente,
        YEAR(NOW()) AS iAnio,
        MONTH(NOW()) AS iMes,
        DAY(NOW()) AS iDia,
        rco.skContratoCobro
        FROM ope_contratos oca
        LEFT JOIN rel_contratos_cobros rco ON  rco.skContrato = oca.skContrato AND rco.iAnio = YEAR(NOW())  AND rco.iMes = MONTH(NOW()) AND rco.iDia = oca.iDiaCorte  AND rco.skTipoPeriodo = oca.skTipoPeriodo
        WHERE oca.skEstatus ='AC'
        AND dFechaInicioCobro <= DATE(NOW()) AND iDiaCorte <= DAY(NOW()) AND rco.skContratoCobro IS NULL ";
        
                $result = Conn::query($sql);
                  if (!$result) {
                      return FALSE;
                  }
               $contratos = Conn::fetch_assoc_all($result); 
               if(!empty($contratos)){
               foreach ($contratos as  $value) {

                   $this->cont['skContrato'] = NULL;  
                   $this->cont['skContrato'] = (!empty($value['skContrato']) ? $value['skContrato'] : NULL);
                   $this->cont['skEmpresaSocioCliente'] = (!empty($value['skEmpresaSocioCliente']) ? $value['skEmpresaSocioCliente'] : NULL);
                   $this->cont['skTipoPeriodo'] = (!empty($value['skTipoPeriodo']) ? $value['skTipoPeriodo'] : NULL);
                   $this->cont['iDiaCorte'] = (!empty($value['iDiaCorte']) ? $value['iDiaCorte'] : NULL);
                   $this->cont['sDetallesServicios'] = 'Cobro del Servicio del cliente ';

                    $generarOrden = $this->sysAPI('admi', 'orse_inde', 'generarOrden', [
                        'POST'=>[
                            'axn'=>'GE',
                            'skProceso'=>'CONT',
                            'skCodigo'=>$this->cont['skContrato']
                        ]
                    ]); 
                    if(!$generarOrden || isset($generarOrden['success']) && $generarOrden['success'] != 1){
                        continue;
                    } 

                    $this->cont['skOrdenServicio'] = $generarOrden['skOrdenServicio'];
                    $this->cont['axn'] = 'cobro_contrato';
 
                    $stpCUD_contratos = parent::stpCUD_contratos();  
                    if(!$stpCUD_contratos || isset($stpCUD_contratos['success']) && $stpCUD_contratos['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GENERAR EL CONTRATO. ';
                        return $this->data;
                    }


                    
                }
            }
               return $this->data;
    } 

 
 
}
    

