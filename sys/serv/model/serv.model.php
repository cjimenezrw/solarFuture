<?php
Class Serv_Model Extends DLOREAN_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
        protected $serv = [];

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() { }

    public function __destruct() { }

     

    /*public function stpCUD_arribos(){
        $sql = "CALL stpCUD_arribos (
            ".escape(isset($this->arbu['skArribo']) ? $this->arbu['skArribo'] : NULL).",
            ".escape(isset($this->arbu['skBuque']) ? $this->arbu['skBuque'] : NULL).",
            ".escape(isset($this->arbu['skEstatus']) ? $this->arbu['skEstatus'] : NULL).",
            ".escape(isset($this->arbu['sCodigo']) ? $this->arbu['sCodigo'] : NULL).",
            ".escape(isset($this->arbu['sCodigoPuerto']) ? $this->arbu['sCodigoPuerto'] : NULL).",
            ".escape(isset($this->arbu['sCodigoAtraque']) ? $this->arbu['sCodigoAtraque'] : NULL).",
            ".escape(isset($this->arbu['sViaje']) ? $this->arbu['sViaje'] : NULL).",
            ".escape(isset($this->arbu['sIndicativoLlama']) ? $this->arbu['sIndicativoLlama'] : NULL).",
            ".escape(isset($this->arbu['sLineaNaviera']) ? $this->arbu['sLineaNaviera'] : NULL).",
            ".escape(isset($this->arbu['dFechaInicioOperaciones']) ? $this->arbu['dFechaInicioOperaciones'] : NULL).",
            ".escape(isset($this->arbu['dFechaTerminoOperaciones']) ? $this->arbu['dFechaTerminoOperaciones'] : NULL).",

            ".escape(isset($this->arbu['axn']) ? $this->arbu['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
            
        $result = Conn::query($sql);
        if (!$result) { return false; }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }*/


    public function _consultarBuques(){
        $sql = "SELECT N1.* FROM (SELECT 
        cb.skBuque AS codigo,
        cb.sTipoTrafico AS tipoTrafico,
        cb.sLineaNaviera AS lineaNaviera,
        cb.sBandera AS bandera,
        cb.dFechaCreacion AS fechaCreacion

        ,cb.sNombre AS buque
        ,ce.sNombre AS estatus 
        
        FROM cat_buques cb
        INNER JOIN core_estatus ce ON ce.skEstatus = cb.skEstatus 
        WHERE 1 = 1";

        if (!empty($this->serv['codigo'])){
            $sql .= " AND cb.skBuque = ".escape($this->serv['codigo']);
        }
        if (!empty($this->serv['lineaNaviera'])){
            $sql .= "  AND cb.sLineaNaviera LIKE '%" . trim(($this->serv['lineaNaviera'])) . "%' ";
        }
        if (!empty($this->serv['bandera'])){
            $sql .= " AND cb.sBandera = ".escape($this->serv['bandera']);
        }
        if (!empty($this->serv['buque'])) {
            $sql .= " AND cb.sNombre LIKE '%" . trim(($this->serv['buque'])) . "%' ";
        }
        
        
        $sql.=" ) AS N1 WHERE 1 = 1  ";

         
        $sql .= "ORDER BY N1.buque ASC";
      

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

    public function _consultarArribos(){
        $sql = "SELECT N1.* FROM (SELECT 
        oa.sCodigo AS codigoArribo,
				oa.sCodigoPuerto AS codigoPuerto,
				oa.sCodigoAtraque AS codigoAtraque,
				oa.sViaje AS viaje,
				oa.sIndicativoLlamada AS indicativoLlamada,
				oa.sLineaNaviera AS lineaNaviera,
				oa.dFechaInicioOperaciones AS fechaInicioOperaciones,
				oa.dFechaTerminoOperaciones AS fechaTerminoOperaciones,
				cb.sNombre AS buque,
				cb.skBuque AS codigo,
				cb.sBandera AS bandera
        ,ce.sNombre AS estatus
        ,ce.sIcono AS estatusIcono
        ,ce.sColor AS estatusColor  
        FROM ope_arribos oa
				INNER JOIN cat_buques cb ON cb.skBuque = oa.skBuque
        INNER JOIN core_estatus ce ON ce.skEstatus = oa.skEstatus 
        WHERE 1 = 1   ";

        if (!empty($this->serv['codigo'])){
            $sql .= " AND cb.skBuque = ".escape($this->serv['codigo']);
        }
        if (!empty($this->serv['codigoArribo'])){
            $sql .= " AND oa.sCodigo = ".escape($this->serv['codigoArribo']);
        }
        if (!empty($this->serv['lineaNaviera'])){
            $sql .= "  AND oa.sLineaNaviera LIKE '%" . trim(($this->serv['lineaNaviera'])) . "%' ";
        }
        if (!empty($this->serv['bandera'])){
            $sql .= " AND cb.sBandera = ".escape($this->serv['bandera']);
        }
        if (!empty($this->serv['buque'])) {
            $sql .= " AND cb.sNombre LIKE '%" . trim(($this->serv['buque'])) . "%' ";
        }

        if (!empty($this->serv['viaje'])) {
            $sql .= " AND oa.sViaje LIKE '%" . trim(($this->serv['viaje'])) . "%' ";
        }
        
        
        $sql.=" ) AS N1 WHERE 1 = 1  ";

         
        $sql .= "ORDER BY N1.buque ASC";
      

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

}