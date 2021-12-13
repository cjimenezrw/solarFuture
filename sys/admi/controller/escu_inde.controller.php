<?php

Class Escu_inde_Controller Extends Admi_Model
{
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function consulta(){

        $configuraciones = array();
        $configuraciones['query'] = " SELECT
        es.*
        ,e.sRFC
        ,e.sNombre AS empresa
        ,e.sNombreCorto
        ,et.sNombre AS empresaTipo 
        ,est.sNombre AS estatus
        ,est.sColor AS estatusColor
        ,est.sIcono AS estatusIcono  
        ,(SELECT SUM(occ.fSaldo) FROM ope_facturas occ WHERE occ.skEmpresaSocioFacturacion = es.skEmpresaSocio AND  occ.skEstatus != 'CA' ) AS fDeudaTotal
        ,(SELECT SUM(occ.fSaldo) FROM ope_facturas occ WHERE (CONVERT(occ.dFechaCreacion,DATE) BETWEEN  CONVERT(NOW(),DATE) AND 
                    CONVERT(DATE_ADD(NOW(),INTERVAL -1 DAY),DATE) ) AND occ.skEmpresaSocioFacturacion = es.skEmpresaSocio  AND occ.skEstatus != 'CA' ) AS fDeuda1Dias
                    
                    ,(SELECT SUM(occ.fSaldo) FROM ope_facturas occ WHERE (CONVERT(occ.dFechaCreacion,DATE) BETWEEN  CONVERT(DATE_ADD(NOW(),INTERVAL -15 DAY),DATE) AND 
                    CONVERT(DATE_ADD(NOW(),INTERVAL -2 DAY),DATE) ) AND occ.skEmpresaSocioFacturacion = es.skEmpresaSocio  AND occ.skEstatus != 'CA' ) AS fDeuda2_15Dias
                    ,(SELECT SUM(occ.fSaldo) FROM ope_facturas occ WHERE (CONVERT(occ.dFechaCreacion,DATE) BETWEEN  CONVERT(DATE_ADD(NOW(),INTERVAL -30 DAY),DATE) AND 
                    CONVERT(DATE_ADD(NOW(),INTERVAL -16 DAY),DATE) ) AND occ.skEmpresaSocioFacturacion = es.skEmpresaSocio  AND occ.skEstatus != 'CA' ) AS fDeuda16_30Dias
                    ,(SELECT SUM(occ.fSaldo) FROM ope_facturas occ WHERE (CONVERT(occ.dFechaCreacion,DATE) BETWEEN  CONVERT(DATE_ADD(NOW(),INTERVAL -45 DAY),DATE) AND 
                    CONVERT(DATE_ADD(NOW(),INTERVAL -31 DAY),DATE) ) AND occ.skEmpresaSocioFacturacion = es.skEmpresaSocio  AND occ.skEstatus != 'CA' ) AS fDeuda31_45Dias
                    ,(SELECT SUM(occ.fSaldo) FROM ope_facturas occ WHERE (CONVERT(occ.dFechaCreacion,DATE) BETWEEN  CONVERT(DATE_ADD(NOW(),INTERVAL -10000 DAY),DATE) AND 
                    CONVERT(DATE_ADD(NOW(),INTERVAL -46 DAY),DATE) ) AND occ.skEmpresaSocioFacturacion = es.skEmpresaSocio  AND occ.skEstatus != 'CA' ) AS fDeuda46Dias
       
        FROM rel_empresasSocios es
        INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
        INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo 
        LEFT JOIN core_estatus est oN est.skEstatus = es.skEstatus
         WHERE 1 = 1 AND es.skEmpresaSocio = (SELECT skEmpresaSocioFacturacion FROM ope_facturas WHERE skEmpresaSocioFacturacion= es.skEmpresaSocio LIMIT 1)  ";

 
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
                $regla = [];
                
                $row['fDeudaTotal'] = (!empty($row['fDeudaTotal']) ? '$ '.number_format($row['fDeudaTotal'],2) : '$ 0.00');
                $row['fDeuda1Dias'] = (!empty($row['fDeuda1Dias']) ? '$ '.number_format($row['fDeuda1Dias'],2) : '$ 0.00');
                $row['fDeuda2_15Dias'] = (!empty($row['fDeuda2_15Dias']) ? '$ '.number_format($row['fDeuda2_15Dias'],2) : '$ 0.00');
                $row['fDeuda16_30Dias'] = (!empty($row['fDeuda16_30Dias']) ? '$ '.number_format($row['fDeuda16_30Dias'],2) : '$ 0.00');
                $row['fDeuda31_45Dias'] = (!empty($row['fDeuda31_45Dias']) ? '$ '.number_format($row['fDeuda31_45Dias'],2) : '$ 0.00');
                $row['fDeuda46Dias'] = (!empty($row['fDeuda46Dias']) ? '$ '.number_format($row['fDeuda46Dias'],2) : '$ 0.00');

                 $row['menuEmergente'] = parent::menuEmergente($regla, $row['skEmpresaSocio']);
                 array_push($data['data'],$row);
        }
        return $data;
        
    }

    public function generarExcel(){
        $data = $this->getEmpresasSociosProveedores();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    public function generarPDF() {
        return parent::generar_pdf(
           $_POST['title'],
           $_POST['headers'],
           $this->getEmpresasSociosProveedores()
        );
    }

    public function guardarProveedor(){
        set_time_limit(-1);
        ini_set('memory_limit', '-1');
        $empresasFile = parent::importData(array(
            'fileName'=>TMP_HARDPATH."configuracion.xlsx",
            'asArray'=>TRUE
            ));

            $arrayEmpresas = array();
            foreach ($empresasFile['proveedores'] as $key => $value) {
                $tot = count($value);
                    for ($e=0; $e < $tot; $e++) {
                            $arrayEmpresas['proveedores'][$e][$key] =$value[$e];
                    }

            }
           
            foreach($arrayEmpresas['proveedores'] as $keyValue => $valueEmpresas) {
                $this->cfdi['skEmpresa'] = NULL;
                $this->cfdi['skEmpresaSocio'] = NULL;
                $this->cfdi['sNombre'] = NULL;
                $this->cfdi['sNombreCorto'] = NULL; 
                $this->cfdi['sRFC'] = NULL; 
                $this->cfdi['sRFC'] = $valueEmpresas['RFC'];
                $this->cfdi['sNombre'] = $valueEmpresas['razon_social'];
                $this->cfdi['skEmpresaTipo']    = 'PROV';      
                $this->obEmpresaSocio();
                $this->cfdi['proveedor'] = $valueEmpresas['tipo_proveedor'];
                $this->obTipoProveedor();
                $this->cfdi['caracteristicas']['CUECON']= (!empty($valueEmpresas['cuenta_contable']) ? substr($valueEmpresas['cuenta_contable'],-4,4) : NULL);
                $this->cfdi['caracteristicas']['TIPPRO']= (!empty($this->cfdi['tipoProveedor']) ? $this->cfdi['tipoProveedor'] : NULL);             
                $this->guardarEmpresa();
               
            
            }
    }

    public function obEmpresaSocio(){
        $sql="SELECT TOP 1 ce.skEmpresa, res.skEmpresaSocio
              FROM cat_empresas ce
              LEFT JOIN rel_empresasSocios res ON ce.skEmpresa = res.skEmpresa AND res.skEmpresaTipo = '".$this->cfdi['skEmpresaTipo']."'
              WHERE ce.sRFC = '".$this->cfdi['sRFC']."' ";
  
          $result = Conn::query($sql);
          if (!$result) {
              return FALSE;
          }
          $record1 =  Conn::fetch_assoc($result);
          $this->cfdi['skEmpresa'] = isset($record1['skEmpresa']) ? $record1['skEmpresa'] : NULL;
          $this->cfdi['skEmpresaSocio'] = isset($record1['skEmpresaSocio']) ? $record1['skEmpresaSocio'] : NULL;
          return true;
      }
    public function obTipoProveedor(){
        $sql="SELECT TOP 1   ce.skTipoProveedor
              FROM cat_tiposProveedores ce 
              WHERE ce.sNombre = '".$this->cfdi['proveedor']."' ";
          $result = Conn::query($sql);
          if (!$result) {
              return FALSE;
          }
          $record1 =  Conn::fetch_assoc($result);
          $this->cfdi['tipoProveedor'] = isset($record1['skTipoProveedor']) ? $record1['skTipoProveedor'] : NULL;
           return true;
    }
    public function guardarEmpresa(){
        $empresa = $this->sysAPI('empr', 'emso_form', 'guardar', [
            'POST' => [
                'skEmpresa' => $this->cfdi['skEmpresa'],
                'skEmpresaSocio'=> $this->cfdi['skEmpresaSocio'],
                'skEmpresaTipo'=> $this->cfdi['skEmpresaTipo'],
                'sNombre' => $this->cfdi['sNombre'],
                'sNombreCorto' => $this->cfdi['sNombreCorto'],
                'sRFC' => $this->cfdi['sRFC'],
                'skEstatus' =>  'AC',
                'skCaracteristicaEmpresaSocio' => $this->cfdi['caracteristicas']
            ]
         ]);
         return $empresa;
    }

    public function guardarConcepto(){
        set_time_limit(-1);
        ini_set('memory_limit', '-1');
        $conceptosFile = parent::importData(array(
            'fileName'=>TMP_HARDPATH."configuracion.xlsx",
            'asArray'=>TRUE
            ));
            $arrayConceptos = array();
            foreach ($conceptosFile['conceptos'] as $key => $value) {
                $tot = count($value);
                    for ($e=0; $e < $tot; $e++) {
                            $arrayConceptos['conceptos'][$e][$key] =$value[$e];
                    }
            }
            foreach($arrayConceptos['conceptos'] as $keyValue => $valueConceptos) {
                $this->cfdi['sNombre'] = NULL;
                $this->cfdi['sCuentaContable'] = NULL;
                $this->cfdi['skCuentaGasto'] = NULL; 
                $this->cfdi['sNombre'] = $valueConceptos['concepto'];
                $this->cfdi['sCuentaContable'] = $valueConceptos['cuenta_contable'];                   
                $this->obCuentaGasto();
                $this->guardarConceptos();          
            }
    }
    public function guardarConceptos(){
        $concepto = $this->sysAPI('cfdi', 'cuga_form', 'guardar', [
            'POST' => [
                'skCuentaGasto' => $this->cfdi['skCuentaGasto'],
                'sNombre'=> $this->cfdi['sNombre'],
                'sCuentaContable'=> $this->cfdi['sCuentaContable'], 
                'skEstatus' =>  'AC'
            ]
         ]);
         return $concepto;
    }
    public function obCuentaGasto(){
        $sql="SELECT TOP 1   ce.skCuentaGasto FROM cat_cuentasGastos ce  WHERE ce.sCuentaContable = '".$this->cfdi['sCuentaContable']."' ";
          $result = Conn::query($sql);
          if (!$result) {
              return FALSE;
          }
          $record1 =  Conn::fetch_assoc($result);
          $this->cfdi['skCuentaGasto'] = isset($record1['skCuentaGasto']) ? $record1['skCuentaGasto'] : NULL;
           return true;
    }

    public function guardarProducto(){
        set_time_limit(-1);
        ini_set('memory_limit', '-1');
        $productosFile = parent::importData(array(
            'fileName'=>TMP_HARDPATH."configuracion.xlsx",
            'asArray'=>TRUE
            ));
            $arrayConceptos = array();
            foreach ($productosFile['productos'] as $key => $value) {
                $tot = count($value);
                    for ($e=0; $e < $tot; $e++) {
                            $arrayConceptos['productos'][$e][$key] =$value[$e];
                    }
            }
            

            foreach($arrayConceptos['productos'] as $keyValue => $valueProductos) {
                $this->cfdi['sNumeroIdentificacion'] = (!empty($valueProductos['clave_producto']) ? $valueProductos['clave_producto'] : NULL); ;
                $this->cfdi['skEmpresaSocioProducto'] = NULL;
                $this->cfdi['skCuentaGasto'] = NULL;                   
                $this->cfdi['skEmpresaSocio'] = '27FECB9C-C5A4-45E2-ABA5-96C152D8FE7D';                   
                $this->cfdi['sCuentaContable'] = (!empty($valueProductos['cuenta_contable']) ? $valueProductos['cuenta_contable'] : NULL);                   
                $this->obCuentaGasto();
                $this->obProductoGuardado();
                $this->guardarProductos();
              
                //$this->guardarProductos();          
            }
           
    }
    public function guardarProductos(){

                $this->cfdi['axn'] = "guardar_empresaSocioProductos";
                $this->cfdi['skEmpresaSocio'] = $this->cfdi['skEmpresaSocio'];
                $this->cfdi['sNumeroIdentificacion'] = $this->cfdi['sNumeroIdentificacion'];
                $this->cfdi['skCuentaGasto'] = $this->cfdi['skCuentaGasto'];
                $this->cfdi['skEmpresaSocioProducto'] = $this->cfdi['skEmpresaSocioProducto'];

                $guardar_empresaSocioProductos = parent::stpCD_empresaSocio_productos();
                if(!$guardar_empresaSocioProductos){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                    return $this->data;
                }
         
    }
    public function obProductoGuardado(){
        $sql="SELECT TOP 1   resp.skEmpresaSocioProducto FROM rel_empresasSocios_productos resp  WHERE resp.skCuentaGasto = '".$this->cfdi['skCuentaGasto']."' AND resp.skEstatus='AC' AND resp.sNumeroIdentificacion = '".$this->cfdi['sNumeroIdentificacion']."'  ";
          $result = Conn::query($sql);
          if (!$result) {
              return FALSE;
          }
          $record1 =  Conn::fetch_assoc($result);
          $this->cfdi['skEmpresaSocioProducto'] = isset($record1['skEmpresaSocioProducto']) ? $record1['skEmpresaSocioProducto'] : NULL;
           return true;
    }
     












}
