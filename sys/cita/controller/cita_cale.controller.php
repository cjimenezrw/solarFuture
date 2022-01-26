<?php
Class Cita_cale_Controller Extends Cita_Model {
    
    // CONST //

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];
        private $idTran = 'cita_cale';

    public function __construct() {
        parent::init();
    }

    public function __destruct() { }

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->cita['sClaveCategoriaCita'] = (isset($_POST['sClaveCategoriaCita']) ? $_POST['sClaveCategoriaCita'] : NULL);
        $this->cita['skCita'] = (isset($_POST['iFolio']) ? $_POST['iFolio'] : NULL);
        $this->cita['skEstadoMX'] = (isset($_POST['skEstadoMX']) ? $_POST['skEstadoMX'] : NULL);
        $this->cita['skMunicipioMX'] = (isset($_POST['skMunicipioMX']) ? $_POST['skMunicipioMX'] : NULL);
        $this->cita['skUsuarioPersonal'] = (isset($_POST['skCitaPersonal_array']) ? $_POST['skCitaPersonal_array'] : NULL);
        $this->cita['iFiltroHistorico'] = (isset($_POST['iFiltroHistorico']) ? $_POST['iFiltroHistorico'] : 0);
        $this->cita['skEmpresaSocioCliente'] = (isset($_POST['skEmpresaSocioCliente']) ? $_POST['skEmpresaSocioCliente'] : NULL);
        $this->cita['sNombre'] = (isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL);
        $this->cita['empleado'] = (isset($_POST['empleado']) ? $_POST['empleado'] : NULL);

        if($this->cita['sClaveCategoriaCita'] == 'DEFAULT'){
            $this->cita['sClaveCategoriaCita'] = NULL;
        }
        
        $this->data['citas'] = parent::_get_citas([
            'skEstatus'=>(!empty($this->cita['iFiltroHistorico']) ? ['PE','CF','FI','VE'] : ['PE','CF','FI','VE']),
            'sClaveCategoriaCita'=>$this->cita['sClaveCategoriaCita'],
            'skCita'=>$this->cita['skCita'],
            'skEstadoMX'=>$this->cita['skEstadoMX'],
            'skMunicipioMX'=>$this->cita['skMunicipioMX'],
            'skUsuarioPersonal'=>$this->cita['skUsuarioPersonal'],
            'skEmpresaSocioCliente'=>$this->cita['skEmpresaSocioCliente'],
            'sNombre'=>$this->cita['sNombre'],
            'iFiltroHistorico'=>$this->cita['iFiltroHistorico']
        ]);

        $this->data['citas'] = (isset($this->data['citas'][0]) ? $this->data['citas'] : (!empty($this->data['citas']) ? [$this->data['citas']] : []));

        $this->data['cat_citas_categorias'] = parent::_get_cat_citas_categorias([
            'skEstatus'=>'AC'
        ]);

        $this->data['cat_estadosMX'] = parent::_get_cat_estadosMX([
            'skEstatus'=>'AC'
        ]);
        
        $this->data['iCantidadCitasTotal'] = 0;
        $this->data['calendario'] = [];
        if(!empty($this->data['citas'])){
            foreach($this->data['citas'] AS $key=>$row){

                array_push($this->data['calendario'],[
                    'id'=>$row['skCita'],
                    'title'=>"#".$row['iFolio']." - ".$row['sNombreCliente']."\n\r".date('H:i:s', strtotime($row['tHoraInicio']))." - ".date('H:i:s', strtotime($row['tHoraFin'])),
                    'display'=>'background',
                    'start'=>$row['dFechaCita'].' '.date('H:i:s', strtotime($row['tHoraInicio'])),
                    'end'=>$row['dFechaCita'].' '.date('H:i:s', strtotime($row['tHoraFin'])),
                    'color'=>$row['sColorCategoria'],
                    'backgroundColor'=>''.$row['sColorCategoria'],
                    'borderColor'=>''.$row['sColorCategoria'],
                    'skModulo'=>'cita-deta',
                    'sURL'=>'/'.DIR_PATH.'sys/cita/cita-deta/detalles-cita/'.$row['skCita'].'/'
                ]);

                $index = array_search($row['sClaveCategoriaCita'],array_column($this->data['cat_citas_categorias'],'sClaveCategoriaCita'));
                if($index !== false){
                    if(!isset($this->data['cat_citas_categorias'][$index]['iCantidadCitas'])){
                        $this->data['cat_citas_categorias'][$index]['iCantidadCitas'] = 1;
                        $this->data['iCantidadCitasTotal'] += 1;
                    }else{
                        $this->data['cat_citas_categorias'][$index]['iCantidadCitas'] += 1;
                        $this->data['iCantidadCitasTotal'] += 1;
                    }
                }

            }
        }

        //exit('<pre>'.print_r($this->data,1).'</pre>');
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

        $sql .= " LIMIT 10 ";
        
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;

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

    public function get_iFolio(){
        $this->cita['iFolio'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $sql = "SELECT N1.skCita AS id, N1.iFolio AS nombre FROM (
            SELECT 
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
            WHERE cit.skEstatus IN ('PE','CF','FI','VE')
            ) AS N1 
            WHERE 1=1 ";

        if(isset($this->cita['iFolio']) && !empty(trim($this->cita['iFolio']))){
            $sql .= " AND N1.iFolio LIKE '%".escape($this->cita['iFolio'],FALSE)."%' ";
        }

        $sql .= " LIMIT 10 ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function get_sNombre(){
        $this->cita['sNombreCliente'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $sql = "SELECT N1.sNombreCliente AS id, N1.sNombreCliente AS nombre FROM (
            SELECT 
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
            WHERE cit.skEstatus IN ('PE','CF','FI','VE')
            ) AS N1 
            WHERE 1=1 ";

        if(isset($this->cita['sNombreCliente']) && !empty(trim($this->cita['sNombreCliente']))){
            $sql .= " AND N1.sNombreCliente LIKE '%".escape($this->cita['sNombreCliente'],FALSE)."%' ";
        }

        $sql .= " LIMIT 10 ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function get_cliente(){
        $this->cita['empresaCliente'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $sql = "SELECT N1.skEmpresaSocioCliente AS id, N1.empresaCliente AS nombre FROM (
            SELECT 
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
            WHERE cit.skEstatus IN ('PE','CF','FI','VE')
            ) AS N1 
            WHERE 1=1 ";

        if(isset($this->cita['empresaCliente']) && !empty(trim($this->cita['empresaCliente']))){
            $sql .= " AND N1.empresaCliente LIKE '%".escape($this->cita['empresaCliente'],FALSE)."%' ";
        }

        $sql .= " LIMIT 10 ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

}