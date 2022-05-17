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
            ,meto.sNombre AS metodoPago
            ,form.sNombre AS formaPago
            ,uso.sNombre AS usoCFDI

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
            LEFT JOIN cat_metodosPago meto ON meto.sCodigo = cit.skMetodoPago
            LEFT JOIN cat_formasPago form ON form.sCodigo = cit.skFormaPago
            LEFT JOIN cat_usosCFDI uso ON uso.sClave = cit.skUsoCFDI
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

        if(isset($params['skUsuarioPersonal']) && !empty($params['skUsuarioPersonal'])){
            $sql .= " AND cit.skCita IN (SELECT skCita FROM rel_citas_personal WHERE skUsuarioPersonal IN (".mssql_where_in($params['skUsuarioPersonal']).")) ";
        }

        if(isset($params['skEmpresaSocioCliente']) && !empty($params['skEmpresaSocioCliente'])){
            $sql .= " AND cit.skEmpresaSocioCliente = " . escape($params['skEmpresaSocioCliente']);
        }

        if(isset($params['sNombre']) && !empty($params['sNombre'])){
            $sql .= " AND cit.sNombreCliente LIKE '%".escape($params['sNombre'],FALSE)."%' ";
        }

        if(isset($params['iFiltroHistorico']) && $params['iFiltroHistorico'] == 0){
            $sql .= " AND DATE_FORMAT(cit.dFechaCita,'%Y-%m-%d') >= DATE_FORMAT(NOW(),'%Y-%m-%d') ";
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

    public function get_empresas() {
        $sql = "SELECT N1.* FROM (
            SELECT
             es.skEmpresaSocio AS id
            ,CONCAT(e.sNombre,' (',e.sRFC,') - ',et.sNombre) AS nombre
            ,es.skEmpresaTipo
            ,e.sNombre AS sNombreEmpresa
            ,e.sCorreo
            ,e.sTelefono
            ,(SELECT
                CONCAT(
                     IF(dom.sCalle IS NOT NULL,dom.sCalle,'')
                    ,IF(dom.sNumeroExterior IS NOT NULL,CONCAT(' #',dom.sNumeroExterior),'')
                    ,IF(dom.sNumeroInterior IS NOT NULL,CONCAT(' Int #',dom.sNumeroInterior),'')
                    ,IF(dom.sColonia IS NOT NULL,CONCAT(', ',dom.sColonia),'')
                    ,IF(dom.skMunicipio IS NOT NULL,CONCAT(', ',dom.skMunicipio),'')
                ) AS sDomicilio
                FROM rel_empresasSocios_domicilios dom 
                WHERE dom.skEmpresaSocio = es.skEmpresaSocio AND dom.skEstatus = 'AC' 
                ORDER BY dom.dFechaCreacion DESC
                LIMIT 1
            ) AS sDomicilio
            ,(SELECT
                IF(dom.skEstado IS NOT NULL,dom.skEstado,'') AS sDomicilio
                FROM rel_empresasSocios_domicilios dom 
                WHERE dom.skEmpresaSocio = es.skEmpresaSocio AND dom.skEstatus = 'AC' 
                ORDER BY dom.dFechaCreacion DESC
                LIMIT 1
            ) AS skEstadoMX
            ,(SELECT
                IF(dom.skMunicipio IS NOT NULL,IF(muni.skMunicipioMX IS NOT NULL,muni.skMunicipioMX,dom.skMunicipio),'') AS skMunicipioMX
                FROM rel_empresasSocios_domicilios dom 
								LEFT JOIN cat_municipiosMX muni ON muni.sNombre = dom.skMunicipio
                WHERE dom.skEmpresaSocio = es.skEmpresaSocio AND dom.skEstatus = 'AC' 
                ORDER BY dom.dFechaCreacion DESC
                LIMIT 1
            ) AS skMunicipioMX
            FROM rel_empresasSocios es
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo
            WHERE es.skEstatus = 'AC' AND e.skEstatus = 'AC' AND es.skEmpresaSocioPropietario = " . escape($_SESSION['usuario']['skEmpresaSocioPropietario']);

        if (isset($this->cita['skEmpresaTipo']) && !empty($this->cita['skEmpresaTipo'])) {
            if (is_array($this->cita['skEmpresaTipo'])) {
                $sql .= " AND es.skEmpresaTipo IN (" . mssql_where_in($this->cita['skEmpresaTipo']) . ") ";
            } else {
                $sql .= " AND es.skEmpresaTipo = " . escape($this->cita['skEmpresaTipo']);
            }
        }

        $sql .= " ) AS N1 ";

        if (isset($this->cita['sNombre']) && !empty(trim($this->cita['sNombre']))) {
            $sql .= " WHERE N1.nombre LIKE '%" . trim($this->cita['sNombre']) . "%' ";
        }

        if (isset($this->cita['skEmpresaSocio']) && !empty($this->cita['skEmpresaSocio'])) {
            $sql .= " WHERE N1.id = " . escape($this->cita['skEmpresaSocio']);
        }

        $sql .= " ORDER BY N1.nombre ASC ";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records,FALSE);
        return $records;
    }

    public function _getCitasCorreos() {

        $sql = "SELECT rcc.sCorreo FROM rel_citas_correos rcc WHERE  rcc.skCita= " . escape($this->cita['skCita']);
   
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        return $records;
    }

    /**
     * consultar_tiposMedidas
     *
     * Obtiene los tipos de medidas activas
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function consultar_tiposMedidas() {
        $sql = "SELECT skUnidadMedida AS id,sNombre AS nombre  FROM cat_unidadesMedidaSAT
        WHERE skEstatus = 'AC' ";
        if (!empty(trim($_POST['val']))) {
            $sql .= " AND sNombre   LIKE '%" . escape($_POST['val'], false) . "%' ";
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

     /**
     * consultar_servicios
     *
     * Obtiene los servicios disponibles
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla.
     */
    public function consultar_servicios() {
        $sql = "SELECT skServicio AS id,sNombre AS nombre  FROM cat_servicios
				WHERE skEstatus = 'AC' ";
        if (!empty(trim($_POST['val']))) {
            if(isset($_POST['filter']) && $_POST['filter'] == 'like'){
                $arr_str = explode(' ',trim($_POST['val']));
                foreach($arr_str AS $str){
                    if(!empty(trim($str))){
                        $sql .= " AND sNombre LIKE '%".escape($str,false)."%' ";
                    }
                }
            }else{
                $sql .= " AND sNombre LIKE '%".escape($_POST['val'],false)."%' ";
            }
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records,FALSE);
        return $records;
    }
    /**
     * consultar_servicios_datos
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function consultar_servicios_datos() {

        $sql = "SELECT   rcp.fPrecioVenta 
        FROM cat_servicios cse 
        LEFT JOIN rel_servicios_precios rcp ON rcp.skServicio = cse.skServicio 
        WHERE cse.skServicio = " . escape($this->cita['skServicio']);

        if (isset($this->cita['skCategoriaPrecio']) && !empty($this->cita['skCategoriaPrecio'])) {
            $sql .= " AND rcp.skCategoriaPrecio = ".escape($this->cita['skCategoriaPrecio'])." LIMIT 1 ";
        }else{
            $sql .= " ORDER BY rcp.fPrecioVenta DESC LIMIT 1 ";
        } 


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc($result);
    }
    /**
     * consultar_servicios_impuestos
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function consultar_servicios_impuestos() {

        $sql = "SELECT DISTINCT
		                cse.skServicio,
                        resi.skImpuesto,
                        resi.skTipoImpuesto,
                        resi.sValor,
                        cse.fPrecioVenta
		                FROM cat_servicios cse
		                INNER JOIN rel_servicios_impuestos resi ON resi.skServicio = cse.skServicio

		                WHERE cse.skServicio = " . escape($this->cita['skServicio']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_servicio_impuestos() {

        $sql = "SELECT DISTINCT
		                cse.skServicio,
                        resi.skImpuesto,
                        resi.skTipoImpuesto,
                        resi.sValor

		                FROM cat_servicios cse
		                INNER JOIN rel_servicios_impuestos resi ON resi.skServicio = cse.skServicio

		                WHERE cse.skServicio = " . escape($this->cita['skServicio']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _getCitaServicios() {

        $sql = "SELECT
        ras.*,
        (cse.sNombre + IF(ras.sDescripcion IS NOT NULL, ' '+ras.sDescripcion,'') ) AS servicioFact,
        cse.sNombre AS servicio, 
        cum.sNombre AS unidadMedida,
        rsir.sValor AS RETIVA,
        rsit.sValor AS TRAIVA,
        (SELECT fImporte FROM rel_citas_serviciosImpuestos rps where rps.skCita = ras.skCita AND rps.skServicio = ras.skServicio AND rps.skImpuesto = 'RETIVA' AND rps.skCitaServicio = ras.skCitaServicio )AS fImpuestosRetenidos,
        (SELECT fImporte FROM rel_citas_serviciosImpuestos rps where rps.skCita = ras.skCita AND rps.skServicio = ras.skServicio AND rps.skImpuesto = 'TRAIVA' AND rps.skCitaServicio = ras.skCitaServicio )AS fImpuestosTrasladados
        
        FROM rel_citas_servicios ras
        LEFT JOIN cat_servicios cse ON cse.skServicio = ras.skServicio 
        LEFT JOIN cat_unidadesMedidaSAT cum ON cum.skUnidadMedida = ras.skUnidadMedida
        LEFT JOIN rel_servicios_impuestos rsir ON rsir.skServicio = ras.skServicio AND rsir.skImpuesto = 'RETIVA'
        LEFT JOIN rel_servicios_impuestos rsit ON rsit.skServicio = ras.skServicio AND rsit.skImpuesto = 'TRAIVA'
        WHERE ras.skCita = " . escape($this->cita['skCita']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        $i = 0;
        foreach ($records as $value) {

            $this->cita['skCitaServicio'] = $value['skCitaServicio'];

            $this->cita['skServicio'] = $value['skServicio'];
            $records[$i]['impuestos'] = $this->_getCitaServicios_impuestos();
            $i++;
        }

        return $records;


        $sql = "SELECT DISTINCT
		                cse.skCitaServicio,
		                cse.skCita,
		                cse.skServicio,
                        cse.skUnidadMedida,
                        cse.fCantidad,
                        cse.fPrecioUnitario,
                        cse.fImporte,
                        cse.sDescripcion,
                        cc.sNombre AS servicio,
                        cc.sCodigo AS sCodigo,
                        cum.sNombre as unidadMedida
		                FROM rel_citas_servicios cse 
                        INNER JOIN cat_servicios cc ON cc.skServicio = cse.skServicio
                        LEFT JOIN cat_unidadesMedidaSAT cum ON cum.skUnidadMedida = cse.skUnidadMedida
		                WHERE cse.skCita = ".escape($this->cita['skCita']);


        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        $i = 0;
        foreach ($records as $value) {

            $this->cita['skCitaServicio'] = $value['skCitaServicio'];

            $this->cita['skServicio'] = $value['skServicio'];
            $records[$i]['impuestos'] = $this->_getCitaServicios_impuestos();
            $i++;
        }
       
        return $records;
    }

    public function _getCitaServicios_impuestos() {

        $sql = "SELECT
        ras.*,
        cti.sNombre AS tipoImpuesto,
        ci.sNombre AS impuesto

        FROM rel_citas_serviciosImpuestos ras
        INNER JOIN cat_impuestos ci ON ci.skImpuesto = ras.skImpuesto
        INNER JOIN cat_tiposImpuestos cti ON cti.skTipoImpuesto = ci.skTipoImpuesto
        WHERE ras.skCita = " . escape($this->cita['skCita']) . " AND ras.skCitaServicio = " . escape($this->cita['skCitaServicio']) . "  AND ras.skServicio= " . escape($this->cita['skServicio']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        return $records;

        $sql = "SELECT	
            ras.skTipoImpuesto  AS tipoImpuesto,
            ci.sNombre AS impuesto
            FROM rel_citas_serviciosImpuestos ras
            INNER JOIN cat_impuestos ci ON ci.skImpuesto = ras.skImpuesto
            WHERE ras.skCita = " . escape($this->cita['skCita']) . " AND ras.skCitaServicio = " . escape($this->cita['skCitaServicio']) . "  AND ras.skServicio = " . escape($this->cita['skServicio']);

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        return $records;
    }

    /**
     * _getDivisas
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getDivisas() {

        $sql = "SELECT DISTINCT
		                cd.skDivisa,
                        cd.sNombre 
		                FROM cat_divisas cd WHERE skEstatus='AC'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }
    /**
     * _getCategorias
     *
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @return array | false Retorna array de datos o false en caso de error
     */
    public function _getCategorias() {

        $sql = "SELECT cso.sNombre,cso.skCatalogoSistemaOpciones AS skCategoriaPrecio  FROM cat_catalogosSistemas cs
        INNER JOIN rel_catalogosSistemasOpciones cso ON cso.skCatalogoSistema = cs.skCatalogoSistema 
        WHERE cs.skCatalogoSistema = 'CATPRE' AND cso.skEstatus = 'AC'";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function _getBancosCuentasResponsable(){
        $sql = "SELECT b.skBanco,b.sNombre as banco,b.sNombreCorto bancoAlias,b.sRFC AS bancoRFC,b.sObservaciones AS sObservacionesBanco,
            bc.skBancoCuenta,bc.skDivisa,bc.sNumeroCuenta,bc.sTitular,bc.sClabeInterbancaria,bc.sObservaciones AS sObservacionesCuenta
            FROM cat_bancos b
            INNER JOIN cat_bancosCuentas bc ON bc.skBanco = b.skBanco
            WHERE b.skEstatus = 'AC' AND bc.skEstatus = 'AC'";

        if (isset($this->cita['skBanco']) && !empty($this->cita['skBanco'])) {
            $sql .= " AND b.skBanco = ".escape($this->cita['skBanco']);
        }

        if (isset($this->cita['skBancoCuenta']) && !empty($this->cita['skBancoCuenta'])) {
            $sql .= " AND bc.skBancoCuenta = ".escape($this->cita['skBancoCuenta']);
        }

        if (isset($this->cita['skEmpresaSocioResponsable']) && !empty($this->cita['skEmpresaSocioResponsable'])) {
            $sql .= " AND bc.skEmpresaSocioPropietario = ".escape($this->cita['skEmpresaSocioResponsable']);
        }

        if (isset($this->cita['EFECTIVO']) && !empty($this->cita['EFECTIVO'])) {
            $sql .= " AND b.sNombre != ".escape($this->cita['EFECTIVO']);
        }

        //exit('<pre>'.print_r($sql,1).'</pre>');
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function consultar_formasPago() {
        $sql = "SELECT CONCAT('(',cf.sCodigo,') ',cf.sNombre)  AS sNombre,cf.sCodigo FROM cat_formasPago cf  WHERE cf.skEstatus = 'AC'  ORDER BY cf.sNombre ASC   ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }
    public function consultar_metodosPago() {
        $sql = "SELECT  CONCAT('(',cm.sCodigo,') ',cm.sNombre) AS sNombre,cm.sCodigo FROM cat_metodosPago cm WHERE cm.skEstatus = 'AC'  ORDER BY cm.sNombre ASC   ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function consultar_usosCFDI() {

        $sql = "SELECT CONCAT('(',cu.sClave,') ',cu.sNombre) AS sNombre,cu.sClave AS sCodigo FROM cat_usosCFDI cu where cu.skEstatus = 'AC' ORDER BY cu.sNombre ASC  ";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        return Conn::fetch_assoc_all($result);
    }

    public function existeOrdenCobro(){
        $sql = "SELECT CONCAT('ORD-', LPAD(os.iFolio, 5, 0))  AS iFolio,os.skEstatus
            FROM rel_ordenesServicios_procesos osp
            INNER JOIN ope_ordenesServicios os ON os.skOrdenServicio = osp.skOrdenServicio
            WHERE os.skEstatus != 'CA' AND osp.skServicioProceso = 'CITA' AND osp.skCodigo = ".escape(isset($this->cita['skCita']) ? $this->cita['skCita'] : NULL)." LIMIT 1;";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc_all($result);
        utf8($record, FALSE);
        if($record){
            return TRUE;
        }else{
            return FALSE;    
        }
    }

    public function stp_cita_agendar(){
        $sql = "CALL stp_cita_agendar (
            ".escape(isset($this->cita['skCita']) ? $this->cita['skCita'] : NULL).",
            ".escape(isset($this->cita['skEstatus']) ? $this->cita['skEstatus'] : NULL).",
            ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']).",
            ".escape(isset($this->cita['skEmpresaSocioFacturacion']) ? $this->cita['skEmpresaSocioFacturacion'] : NULL).",
            ".escape(isset($this->cita['skEmpresaSocioCliente']) ? $this->cita['skEmpresaSocioCliente'] : NULL).",
            ".escape(isset($this->cita['sNombreCliente']) ? $this->cita['sNombreCliente'] : NULL).",
            ".escape(isset($this->cita['sAsunto']) ? $this->cita['sAsunto'] : NULL).",
            ".escape(isset($this->cita['skCategoriaCita']) ? $this->cita['skCategoriaCita'] : NULL).",
            ".escape(isset($this->cita['dFechaCita']) ? $this->cita['dFechaCita'] : NULL).",
            ".escape(isset($this->cita['tHoraInicio']) ? $this->cita['tHoraInicio'] : NULL).",
            ".escape(isset($this->cita['skTipoPeriodo']) ? $this->cita['skTipoPeriodo'] : NULL).",
            ".escape(isset($this->cita['sTelefono']) ? $this->cita['sTelefono'] : NULL).",
            ".escape(isset($this->cita['skEstadoMX']) ? $this->cita['skEstadoMX'] : NULL).",
            ".escape(isset($this->cita['skMunicipioMX']) ? $this->cita['skMunicipioMX'] : NULL).",
            ".escape(isset($this->cita['sDomicilio']) ? $this->cita['sDomicilio'] : NULL).",
            ".escape(isset($this->cita['sObservaciones']) ? $this->cita['sObservaciones'] : NULL).",
            ".escape(isset($this->cita['sInstruccionesServicio']) ? $this->cita['sInstruccionesServicio'] : NULL).",
            ".escape(isset($this->cita['skDivisa']) ? $this->cita['skDivisa'] : NULL).",
            ".escape(isset($this->cita['fTipoCambio']) ? $this->cita['fTipoCambio'] : NULL).",
            ".escape(isset($this->cita['fImporteSubtotal']) ? $this->cita['fImporteSubtotal'] : NULL).",
            ".escape(isset($this->cita['fImpuestosRetenidos']) ? $this->cita['fImpuestosRetenidos'] : NULL).",
            ".escape(isset($this->cita['fImpuestosTrasladados']) ? $this->cita['fImpuestosTrasladados'] : NULL).",
            ".escape(isset($this->cita['fDescuento']) ? $this->cita['fDescuento'] : NULL).",
            ".escape(isset($this->cita['fImporteTotal']) ? $this->cita['fImporteTotal'] : NULL).",
            ".escape(isset($this->cita['fImporteTotalSinIVA']) ? $this->cita['fImporteTotalSinIVA'] : NULL).",

            ".escape(isset($this->cita['sCorreo']) ? $this->cita['sCorreo'] : NULL).",

            ".escape(isset($this->cita['skUsuarioPersonal']) ? $this->cita['skUsuarioPersonal'] : NULL).",

            ".escape(isset($this->cita['skCitaServicio']) ? $this->cita['skCitaServicio'] : NULL).",
            ".escape(isset($this->cita['skServicio']) ? $this->cita['skServicio'] : NULL).",
            ".escape(isset($this->cita['skUnidadMedida']) ? $this->cita['skUnidadMedida'] : NULL).",
            ".escape(isset($this->cita['skImpuesto']) ? $this->cita['skImpuesto'] : NULL).",
            ".escape(isset($this->cita['sDescripcion']) ? $this->cita['sDescripcion'] : NULL).",
            ".escape(isset($this->cita['fCantidad']) ? $this->cita['fCantidad'] : NULL).",
            ".escape(isset($this->cita['fPrecioUnitario']) ? $this->cita['fPrecioUnitario'] : NULL).",
            ".escape(isset($this->cita['fImporte']) ? $this->cita['fImporte'] : NULL).",

            ".escape(isset($this->cita['iNoFacturable']) ? $this->cita['iNoFacturable'] : NULL).",
            ".escape(isset($this->cita['skMetodoPago']) ? $this->cita['skMetodoPago'] : NULL).",
            ".escape(isset($this->cita['skFormaPago']) ? $this->cita['skFormaPago'] : NULL).",
            ".escape(isset($this->cita['skUsoCFDI']) ? $this->cita['skUsoCFDI'] : NULL).",

            ".escape(isset($this->cita['axn']) ? $this->cita['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
        
        if($this->cita['axn'] == 'guardar_cita_servicios'){
            //exit('<pre>'.print_r($sql,1).'</pre>');
        }
        //exit('<pre>'.print_r($sql,1).'</pre>');
        //$this->log($sql,TRUE);

        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] != 1){
            return $result;
        }
        $record = Conn::fetch_assoc($result);
        utf8($record, FALSE);
        return $record;
    }

}