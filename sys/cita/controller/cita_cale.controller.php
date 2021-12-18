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
        $this->cita['skCita'] = (isset($_POST['iFolioCita']) ? $_POST['iFolioCita'] : NULL);
        $this->cita['skEstadoMX'] = (isset($_POST['skEstadoMX']) ? $_POST['skEstadoMX'] : NULL);
        $this->cita['skMunicipioMX'] = (isset($_POST['skMunicipioMX']) ? $_POST['skMunicipioMX'] : NULL);
        $this->cita['iFiltroHistorico'] = (isset($_POST['iFiltroHistorico']) ? $_POST['iFiltroHistorico'] : 0);
        $this->cita['skEmpresaSocioCliente'] = (isset($_POST['skEmpresaSocioCliente']) ? $_POST['skEmpresaSocioCliente'] : NULL);
        $this->cita['sNombre'] = (isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL);
        $this->cita['empleado'] = (isset($_POST['empleado']) ? $_POST['empleado'] : NULL);
        
        $this->data['citas'] = parent::_get_citas([
            'skEstatus'=>['CF'],
            'sClaveCategoriaCita'=>$this->cita['sClaveCategoriaCita'],
            'skCita'=>$this->cita['skCita'],
            'skEstadoMX'=>$this->cita['skEstadoMX'],
            'skMunicipioMX'=>$this->cita['skMunicipioMX'],
            'skEmpresaSocioCliente'=>$this->cita['skEmpresaSocioCliente'],
            'sNombre'=>$this->cita['sNombre'],
            'iFiltroHistorico'=>$this->cita['iFiltroHistorico']
        ]);

        $this->data['cat_citas_categorias'] = parent::_get_cat_citas_categorias([
            'skEstatus'=>'AC'
        ]);

        $this->data['cat_estadosMX'] = parent::_get_cat_estadosMX([
            'skEstatus'=>'AC'
        ]);

        $this->data['calendario'] = [];
        if(!empty($this->data['citas'])){
            //exit('<pre>'.print_r(count($this->data['citas']),1).'</pre>');
            //if(count($this->data['citas']))
            foreach($this->data['citas'] AS $row){
                /*if(!isset($this->cita['calendario'][$row['skCita']])){
                    $this->data['calendario'][$row['skCita']] = [
                        'id'=>$row['skCita'],
                        'title'=>$row['estatus']." - ".$row['sNombre']."\n\r".date('H:i:s', strtotime($row['tHoraInicio']))." - ".date('H:i:s', strtotime($row['tHoraFin'])),
                        'display'=>'background',
                        'start'=>$row['dFechaCita'],
                        'end'=>$row['dFechaCita'],
                        'color'=>$row['sColorCategoria'],
                        'skModulo'=>'cita-deta',
                        'sURL'=>'/'.DIR_PATH.'sys/cita/cita-deta/detalles-cita/'.$row['skCita'].'/'
                    ];
                }*/

                array_push($this->data['calendario'],[
                    'id'=>$row['skCita'],
                    'title'=>$row['iFolioCita']." - ".$row['sNombre']."\n\r".date('H:i:s', strtotime($row['tHoraInicio']))." - ".date('H:i:s', strtotime($row['tHoraFin'])),
                    'display'=>'background',
                    'start'=>$row['dFechaCita'],
                    'end'=>$row['dFechaCita'],
                    'color'=>$row['sColorCategoria'],
                    'skModulo'=>'cita-deta',
                    'sURL'=>'/'.DIR_PATH.'sys/cita/cita-deta/detalles-cita/'.$row['skCita'].'/'
                ]);

                $index = array_search($row['sClaveCategoriaCita'],array_column($this->data['cat_citas_categorias'],'sClaveCategoriaCita'));
                if($index !== false){
                    if(!isset($this->data['cat_citas_categorias'][$index]['iCantidadCitas'])){
                        $this->data['cat_citas_categorias'][$index]['iCantidadCitas'] = 1;
                    }else{
                        $this->data['cat_citas_categorias'][$index]['iCantidadCitas'] += 1;
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
    
    public function get_cat_municipiosMX(){
        $this->data = ['success' => TRUE, 'message' => 'MUNICIPIOS DISPONIBLES CARGADOS', 'datos' => NULL];

        $this->cita['skEstadoMX'] = (isset($_POST['skEstadoMX']) && !empty($_POST['skEstadoMX'])) ? $_POST['skEstadoMX'] : NULL;

        $this->data['cat_municipiosMX'] = parent::_get_cat_municipiosMX([
            'skEstadoMX'=>$this->cita['skEstadoMX'],
            'skEstatus'=>'AC'
        ]);

        return $this->data;
    }

    public function get_iFolioCita(){
        $this->cita['iFolioCita'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $sql = "SELECT N1.skCita AS id, N1.iFolioCita AS nombre FROM (
            SELECT 
                cit.skCita,
                CONCAT('CIT',RIGHT(CONCAT('0000',CAST(cit.iFolioCita AS VARCHAR(4))),4)) AS iFolioCita,
                cit.skCategoriaCita,
                cit.skEstatus,
                cit.dFechaCita,
                cit.tHoraInicio,
                cit.tHoraFin,
                cit.skTipoPeriodo,
                cit.skEmpresaSocioCliente,
                cit.sNombre,
                cit.sTelefono,
                cit.sCorreo,
                cit.skEstadoMX,
                cit.skMunicipioMX,
                cit.sDomicilio,
                cit.sObservaciones,
                cit.sInstruccionesServicio,
                cit.skUsuarioConfirmacion,
                cit.dFechaConfirmacion,
                cit.sObservacionesCancelacion,
                cit.skUsuarioCancelacion,
                cit.dFechaCancelacion,
                cit.skUsuarioCreacion,
                cit.dFechaCreacion,
                cit.skUsuarioModificacion,
                cit.dFechaModificacion,
                cate.sNombreCategoria,
                cate.iMinutosDuracion,
                cate.sColorCategoria,
                est.sNombre AS estatus,
                est.sIcono AS estatusIcono,
                est.sColor AS estatusColor,
                esMX.sNombre AS estado,
                muMX.sNombre AS municipio,
                CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion,
                CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion,
                CONCAT(uConf.sNombre,' ',uConf.sApellidoPaterno,' ',uConf.sApellidoMaterno) AS usuarioConfirmacion,
                CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion,
                e.sNombre AS empresaCliente,
                e.sRFC AS empresaRFC
            FROM ope_citas cit
                LEFT JOIN cat_citas_categorias cate ON cate.skCategoriaCita = cit.skCategoriaCita
                INNER JOIN core_estatus est ON est.skEstatus = cit.skEstatus
                INNER JOIN cat_estadosMX esMX ON esMX.skEstadoMX = cit.skEstadoMX
                INNER JOIN cat_municipiosMX muMX ON muMX.skMunicipioMX = cit.skMunicipioMX
                INNER JOIN cat_usuarios uCre ON uCre.skUsuario = cit.skUsuarioCreacion
                LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = cit.skUsuarioModificacion
                LEFT JOIN cat_usuarios uConf ON uConf.skUsuario = cit.skUsuarioConfirmacion
                LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = cit.skUsuarioCancelacion
                LEFT JOIN rel_empresasSocios es ON es.skEmpresaSocio = cit.skEmpresaSocioCliente
                LEFT JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
                WHERE cit.skEstatus = 'CF' AND cit.iFolioCita IS NOT NULL
            ) AS N1 
            WHERE 1=1 ";

        if(isset($this->cita['iFolioCita']) && !empty(trim($this->cita['iFolioCita']))){
            $sql .= " AND N1.iFolioCita LIKE '%".escape($this->cita['iFolioCita'],FALSE)."%' ";
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
        $this->cita['sNombre'] = (isset($_POST['val']) && !empty($_POST['val'])) ? $_POST['val'] : NULL;

        $sql = "SELECT N1.sNombre AS id, N1.sNombre AS nombre FROM (
            SELECT 
                cit.skCita,
                CONCAT('CIT',RIGHT(CONCAT('0000',CAST(cit.iFolioCita AS VARCHAR(4))),4)) AS iFolioCita,
                cit.skCategoriaCita,
                cit.skEstatus,
                cit.dFechaCita,
                cit.tHoraInicio,
                cit.tHoraFin,
                cit.skTipoPeriodo,
                cit.skEmpresaSocioCliente,
                cit.sNombre,
                cit.sTelefono,
                cit.sCorreo,
                cit.skEstadoMX,
                cit.skMunicipioMX,
                cit.sDomicilio,
                cit.sObservaciones,
                cit.sInstruccionesServicio,
                cit.skUsuarioConfirmacion,
                cit.dFechaConfirmacion,
                cit.sObservacionesCancelacion,
                cit.skUsuarioCancelacion,
                cit.dFechaCancelacion,
                cit.skUsuarioCreacion,
                cit.dFechaCreacion,
                cit.skUsuarioModificacion,
                cit.dFechaModificacion,
                cate.sNombreCategoria,
                cate.iMinutosDuracion,
                cate.sColorCategoria,
                est.sNombre AS estatus,
                est.sIcono AS estatusIcono,
                est.sColor AS estatusColor,
                esMX.sNombre AS estado,
                muMX.sNombre AS municipio,
                CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion,
                CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion,
                CONCAT(uConf.sNombre,' ',uConf.sApellidoPaterno,' ',uConf.sApellidoMaterno) AS usuarioConfirmacion,
                CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion,
                e.sNombre AS empresaCliente,
                e.sRFC AS empresaRFC
            FROM ope_citas cit
                LEFT JOIN cat_citas_categorias cate ON cate.skCategoriaCita = cit.skCategoriaCita
                INNER JOIN core_estatus est ON est.skEstatus = cit.skEstatus
                INNER JOIN cat_estadosMX esMX ON esMX.skEstadoMX = cit.skEstadoMX
                INNER JOIN cat_municipiosMX muMX ON muMX.skMunicipioMX = cit.skMunicipioMX
                INNER JOIN cat_usuarios uCre ON uCre.skUsuario = cit.skUsuarioCreacion
                LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = cit.skUsuarioModificacion
                LEFT JOIN cat_usuarios uConf ON uConf.skUsuario = cit.skUsuarioConfirmacion
                LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = cit.skUsuarioCancelacion
                LEFT JOIN rel_empresasSocios es ON es.skEmpresaSocio = cit.skEmpresaSocioCliente
                LEFT JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
                WHERE cit.skEstatus = 'CF' AND cit.sNombre IS NOT NULL
            ) AS N1 
            WHERE 1=1 ";

        if(isset($this->cita['sNombre']) && !empty(trim($this->cita['sNombre']))){
            $sql .= " AND N1.sNombre LIKE '%".escape($this->cita['sNombre'],FALSE)."%' ";
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
                cit.skCita,
                CONCAT('CIT',RIGHT(CONCAT('0000',CAST(cit.iFolioCita AS VARCHAR(4))),4)) AS iFolioCita,
                cit.skCategoriaCita,
                cit.skEstatus,
                cit.dFechaCita,
                cit.tHoraInicio,
                cit.tHoraFin,
                cit.skTipoPeriodo,
                cit.skEmpresaSocioCliente,
                cit.sNombre,
                cit.sTelefono,
                cit.sCorreo,
                cit.skEstadoMX,
                cit.skMunicipioMX,
                cit.sDomicilio,
                cit.sObservaciones,
                cit.sInstruccionesServicio,
                cit.skUsuarioConfirmacion,
                cit.dFechaConfirmacion,
                cit.sObservacionesCancelacion,
                cit.skUsuarioCancelacion,
                cit.dFechaCancelacion,
                cit.skUsuarioCreacion,
                cit.dFechaCreacion,
                cit.skUsuarioModificacion,
                cit.dFechaModificacion,
                cate.sNombreCategoria,
                cate.iMinutosDuracion,
                cate.sColorCategoria,
                est.sNombre AS estatus,
                est.sIcono AS estatusIcono,
                est.sColor AS estatusColor,
                esMX.sNombre AS estado,
                muMX.sNombre AS municipio,
                CONCAT(uCre.sNombre,' ',uCre.sApellidoPaterno,' ',uCre.sApellidoMaterno) AS usuarioCreacion,
                CONCAT(uMod.sNombre,' ',uMod.sApellidoPaterno,' ',uMod.sApellidoMaterno) AS usuarioModificacion,
                CONCAT(uConf.sNombre,' ',uConf.sApellidoPaterno,' ',uConf.sApellidoMaterno) AS usuarioConfirmacion,
                CONCAT(uCan.sNombre,' ',uCan.sApellidoPaterno,' ',uCan.sApellidoMaterno) AS usuarioCancelacion,
                e.sNombre AS empresaCliente,
                e.sRFC AS empresaRFC
            FROM ope_citas cit
                LEFT JOIN cat_citas_categorias cate ON cate.skCategoriaCita = cit.skCategoriaCita
                INNER JOIN core_estatus est ON est.skEstatus = cit.skEstatus
                INNER JOIN cat_estadosMX esMX ON esMX.skEstadoMX = cit.skEstadoMX
                INNER JOIN cat_municipiosMX muMX ON muMX.skMunicipioMX = cit.skMunicipioMX
                INNER JOIN cat_usuarios uCre ON uCre.skUsuario = cit.skUsuarioCreacion
                LEFT JOIN cat_usuarios uMod ON uMod.skUsuario = cit.skUsuarioModificacion
                LEFT JOIN cat_usuarios uConf ON uConf.skUsuario = cit.skUsuarioConfirmacion
                LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = cit.skUsuarioCancelacion
                LEFT JOIN rel_empresasSocios es ON es.skEmpresaSocio = cit.skEmpresaSocioCliente
                LEFT JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
                WHERE cit.skEstatus = 'CF' AND cit.skEmpresaSocioCliente IS NOT NULL
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