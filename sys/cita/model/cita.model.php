<?php
Class Cita_Model Extends DLOREAN_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
        protected $oper = [];

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() { }

    public function __destruct() { }

    public function _get_cat_citas_categorias($params = []){
        $sql = "SELECT cate.* FROM cat_citas_categorias cate WHERE 1=1 ";

        if(isset($params['skEstatus']) && !empty($params['skEstatus'])){
            if(is_array($params['skEstatus'])){
                $sql .= " AND cate.skEstatus IN (" . mssql_where_in($params['skEstatus']) . ") ";
            }else{
                $sql .= " AND cate.skEstatus = " . escape($params['skEstatus']);
            }
        }

        $sql .= " ORDER BY cate.sNombreCategoria ASC ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_horarios_disponibles($params = []){
        $sql = "SELECT 
        DIASEM.sNombre AS diaSemana, HOUR(TIMEDIFF(disp.tHoraFin,disp.tHoraInicio)) AS diferenciaHoras, HOUR(disp.tHoraInicio) AS horaInicio, HOUR(disp.tHoraFin) AS horaFin, disp.* 
        FROM cat_citas_disponibles disp 
        INNER JOIN rel_catalogosSistemasOpciones DIASEM ON DIASEM.skCatalogoSistema = 'DIASEM' AND DIASEM.skCatalogoSistemaOpciones = disp.skDiaSemana
        WHERE DIASEM.skClave =
        CASE
            WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 1 THEN 'DOMING'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 2 THEN 'LUNESS'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 3 THEN 'MARTES'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 4 THEN 'MIERCO'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 5 THEN 'JUEVES'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 6 THEN 'VIERNE'
            ELSE 'SABADO'
        END
        ORDER BY DIASEM.dFechaCreacion ASC;";
        
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

    public function _get_horarios_descansos($params = []){
        $sql = "SELECT 
        DIASEM.sNombre AS diaSemana, HOUR(TIMEDIFF(des.tHoraFin,des.tHoraInicio)) AS diferenciaHoras, HOUR(des.tHoraInicio) AS horaInicio, HOUR(des.tHoraFin) AS horaFin, des.* 
        FROM cat_citas_descanso des 
        INNER JOIN rel_catalogosSistemasOpciones DIASEM ON DIASEM.skCatalogoSistema = 'DIASEM' AND DIASEM.skCatalogoSistemaOpciones = des.skDiaSemana
        WHERE DIASEM.skClave =
        CASE
            WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 1 THEN 'DOMING'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 2 THEN 'LUNESS'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 3 THEN 'MARTES'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 4 THEN 'MIERCO'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 5 THEN 'JUEVES'
                WHEN DAYOFWEEK(".escape($params['dFechaCita']).") = 6 THEN 'VIERNE'
            ELSE 'SABADO'
        END
        ORDER BY DIASEM.dFechaCreacion ASC;";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

    public function _get_horarios_disponibles_excepciones($params = []){
        $sql = "SELECT 
        HOUR(TIMEDIFF(exe.tHoraFin,exe.tHoraInicio)) AS diferenciaHoras, HOUR(exe.tHoraInicio) AS horaInicio, HOUR(exe.tHoraFin) AS horaFin, exe.* 
        FROM cat_citas_disponibles_excepciones exe
        WHERE exe.dFechaDisponibleExcepcion = ".escape($params['dFechaCita'])."
        ORDER BY exe.dFechaCreacion ASC;";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

    public function _get_horarios_descansos_excepciones($params = []){
        $sql = "SELECT 
        HOUR(TIMEDIFF(exedes.tHoraFin,exedes.tHoraInicio)) AS diferenciaHoras, HOUR(exedes.tHoraInicio) AS horaInicio, HOUR(exedes.tHoraFin) AS horaFin, exedes.* 
        FROM cat_citas_descanso_excepciones exedes
        WHERE exedes.dFechaDisponibleExcepcion = ".escape($params['dFechaCita'])."
        ORDER BY exedes.dFechaCreacion ASC;";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

    public function _get_cat_estadosMX($params = []){
        $sql = "SELECT esta.* FROM cat_estadosMX esta WHERE 1=1 ";

        if(isset($params['skEstatus']) && !empty($params['skEstatus'])){
            if(is_array($params['skEstatus'])){
                $sql .= " AND esta.skEstatus IN (" . mssql_where_in($params['skEstatus']) . ") ";
            }else{
                $sql .= " AND esta.skEstatus = " . escape($params['skEstatus']);
            }
        }

        $sql .= " ORDER BY esta.sNombre ASC ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_cat_municipiosMX($params = []){
        $sql = "SELECT muni.*, esta.sNombre AS estado 
        FROM cat_municipiosMX muni 
        INNER JOIN cat_estadosMX esta ON esta.skEstadoMX = muni.skEstadoMX 
        WHERE 1=1 ";

        if(isset($params['skEstatus']) && !empty($params['skEstatus'])){
            if(is_array($params['skEstatus'])){
                $sql .= " AND muni.skEstatus IN (" . mssql_where_in($params['skEstatus']) . ") ";
            }else{
                $sql .= " AND muni.skEstatus = " . escape($params['skEstatus']);
            }
        }

        if(isset($params['skEstadoMX']) && !empty($params['skEstadoMX'])){
            if(is_array($params['skEstadoMX'])){
                $sql .= " AND muni.skEstadoMX IN (" . mssql_where_in($params['skEstadoMX']) . ") ";
            }else{
                $sql .= " AND muni.skEstadoMX = " . escape($params['skEstadoMX']);
            }
        }

        $sql .= " ORDER BY muni.sNombre ASC ";

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;
    }

    public function _get_citas($params = []){
        $sql = "SELECT 
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
            cit.sObservacionesFinalizacion,
            cit.skUsuarioFinalizacion,
            cit.dFechaFinalizacion,
            cit.sObservacionesCancelacion,
            cit.skUsuarioCancelacion,
            cit.dFechaCancelacion,
            cit.skUsuarioCreacion,
            cit.dFechaCreacion,
            cit.skUsuarioModificacion,
            cit.dFechaModificacion,
            cate.sNombreCategoria,
            cate.sClaveCategoriaCita,
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
            CONCAT(uFin.sNombre,' ',uFin.sApellidoPaterno,' ',uFin.sApellidoMaterno) AS usuarioFinalizacion,
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
            LEFT JOIN cat_usuarios uFin ON uFin.skUsuario = cit.skUsuarioFinalizacion
            LEFT JOIN cat_usuarios uCan ON uCan.skUsuario = cit.skUsuarioCancelacion
            LEFT JOIN rel_empresasSocios es ON es.skEmpresaSocio = cit.skEmpresaSocioCliente
            LEFT JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            WHERE 1=1 ";

        if(isset($params['skEstatus']) && !empty($params['skEstatus'])){
            if(is_array($params['skEstatus'])){
                $sql .= " AND cit.skEstatus IN (" . mssql_where_in($params['skEstatus']) . ") ";
            }else{
                $sql .= " AND cit.skEstatus = " . escape($params['skEstatus']);
            }
        }

        if(isset($params['skCita']) && !empty($params['skCita'])){
            $sql .= " AND cit.skCita = " . escape($params['skCita']);
        }

        if(isset($params['skCategoriaCita']) && !empty($params['skCategoriaCita'])){
            $sql .= " AND cit.skCategoriaCita = " . escape($params['skCategoriaCita']);
        }

        if(isset($params['sClaveCategoriaCita']) && !empty($params['sClaveCategoriaCita'])){
            $sql .= " AND cate.sClaveCategoriaCita = " . escape($params['sClaveCategoriaCita']);
        }

        if(isset($params['skEstadoMX']) && !empty($params['skEstadoMX'])){
            $sql .= " AND cit.skEstadoMX = " . escape($params['skEstadoMX']);
        }

        if(isset($params['skMunicipioMX']) && !empty($params['skMunicipioMX'])){
            $sql .= " AND cit.skMunicipioMX = " . escape($params['skMunicipioMX']);
        }

        if(isset($params['skEmpresaSocioCliente']) && !empty($params['skEmpresaSocioCliente'])){
            $sql .= " AND cit.skEmpresaSocioCliente = " . escape($params['skEmpresaSocioCliente']);
        }

        if(isset($params['sNombre']) && !empty($params['sNombre'])){
            $sql .= " AND cit.sNombre LIKE '%".escape($params['sNombre'],FALSE)."%' ";
        }

        if(!isset($params['iFiltroHistorico']) || empty($params['iFiltroHistorico'])){
            //$sql .= " AND cit.dFechaCreacion >= NOW() ";
        }

        $sql .= " ORDER BY cit.dFechaCreacion DESC; ";
//exit('<pre>'.print_r($sql,1).'</pre>');
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        if(isset($params['skCita']) && !empty($params['skCita'])){
            $records = Conn::fetch_assoc($result);
        }else{
            $records = Conn::fetch_assoc_all($result);
        }

        utf8($records, FALSE);
        return $records;
    }

    public function _get_citas_personal($params = []){
        $sql = "SELECT 
            per.skUsuarioPersonal,
            CONCAT(u.sNombre,' ',u.sApellidoPaterno,' ',u.sApellidoMaterno) AS nombre
        FROM rel_citas_personal per
        INNER JOIN cat_usuarios u ON u.skUsuario = per.skUsuarioPersonal
        WHERE per.skEstatus = 'AC' ";

        if(isset($params['skCita']) && !empty($params['skCita'])){
            $sql .= " AND per.skCita = ".escape($params['skCita']);
        }

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records, FALSE);
        return $records;

    }

    public function stp_cita_agendar(){
        $sql = "CALL stp_cita_agendar (
            ".escape(isset($this->cita['skCita']) ? $this->cita['skCita'] : NULL).",
            ".escape(isset($this->cita['skCategoriaCita']) ? $this->cita['skCategoriaCita'] : NULL).",
            ".escape(isset($this->cita['skEstatus']) ? $this->cita['skEstatus'] : NULL).",
            ".escape(isset($this->cita['dFechaCita']) ? $this->cita['dFechaCita'] : NULL).",
            ".escape(isset($this->cita['tHoraInicio']) ? $this->cita['tHoraInicio'] : NULL).",
            ".escape(isset($this->cita['skEmpresaSocioCliente']) ? $this->cita['skEmpresaSocioCliente'] : NULL).",
            ".escape(isset($this->cita['sNombre']) ? $this->cita['sNombre'] : NULL).",
            ".escape(isset($this->cita['sTelefono']) ? $this->cita['sTelefono'] : NULL).",
            ".escape(isset($this->cita['sCorreo']) ? $this->cita['sCorreo'] : NULL).",
            ".escape(isset($this->cita['skEstadoMX']) ? $this->cita['skEstadoMX'] : NULL).",
            ".escape(isset($this->cita['skMunicipioMX']) ? $this->cita['skMunicipioMX'] : NULL).",
            ".escape(isset($this->cita['sDomicilio']) ? $this->cita['sDomicilio'] : NULL).",
            ".escape(isset($this->cita['sObservaciones']) ? $this->cita['sObservaciones'] : NULL).",
            ".escape(isset($this->cita['skUsuarioPersonal']) ? $this->cita['skUsuarioPersonal'] : NULL).",
            ".escape(isset($this->cita['sInstruccionesServicio']) ? $this->cita['sInstruccionesServicio'] : NULL).",
            ".escape(isset($this->cita['skUsuarioConfirmacion']) ? $this->cita['skUsuarioConfirmacion'] : NULL).",

            ".escape(isset($this->cita['axn']) ? $this->cita['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
//exit('<pre>'.print_r($sql,1).'</pre>');
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

}