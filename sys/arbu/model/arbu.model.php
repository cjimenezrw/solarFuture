<?php
Class Arbu_Model Extends DLOREAN_Model {

    // CONST //
    
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //
        protected $arbu = [];

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct() { }

    public function __destruct() { }

    public function stpCUD_buques(){
        $sql = "CALL stpCUD_buques (
            ".escape(isset($this->arbu['skBuque']) ? $this->arbu['skBuque'] : NULL).",
            ".escape(isset($this->arbu['sNombre']) ? $this->arbu['sNombre'] : NULL).",
            ".escape(isset($this->arbu['sTipoTrafico']) ? $this->arbu['sTipoTrafico'] : NULL).",
            ".escape(isset($this->arbu['skEstatus']) ? $this->arbu['skEstatus'] : NULL).",
            ".escape(isset($this->arbu['sLineaNaviera']) ? $this->arbu['sLineaNaviera'] : NULL).",
            ".escape(isset($this->arbu['sBandera']) ? $this->arbu['sBandera'] : NULL).",

            ".escape(isset($this->arbu['axn']) ? $this->arbu['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
            if($this->arbu['axn'] == 'guardar_buque' && trim($this->arbu['sNombre']) == 'RDO CONCORD'){
                $this->log($sql,TRUE);
            }
        $result = Conn::query($sql);
        if (!$result) { return false; }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

    public function stpCUD_arribos(){
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
            ".escape(isset($this->arbu['dFechaAtraque']) ? $this->arbu['dFechaAtraque'] : NULL).",
            ".escape(isset($this->arbu['dFechaCruceLP']) ? $this->arbu['dFechaCruceLP'] : NULL).",
            ".escape(isset($this->arbu['dFechaFondeo']) ? $this->arbu['dFechaFondeo'] : NULL).",
            ".escape(isset($this->arbu['sTramo']) ? $this->arbu['sTramo'] : NULL).",

            ".escape(isset($this->arbu['axn']) ? $this->arbu['axn'] : NULL).",
            ".escape($_SESSION['usuario']['skUsuario']).",
            ".escape($this->sysController).")";
            
        $result = Conn::query($sql);
        if (!$result) { return false; }
        $record = Conn::fetch_assoc($result);
        utf8($record);
        return $record;
    }

    public function _get_buques_arribos(){
        $sql = "SELECT 
                b.skBuque,b.sNombre,b.sTipoTrafico,b.sLineaNaviera,b.sBandera,
                a.sCodigo,a.sCodigoPuerto,a.sCodigoAtraque,a.sViaje,a.sIndicativoLlamada,
                
                IF(FROM_UNIXTIME((dFechaInicioOperaciones - 25569) * 86400) IS NOT NULL,FROM_UNIXTIME((dFechaInicioOperaciones - 25569) * 86400),dFechaInicioOperaciones) AS dFechaInicioOperaciones,
                IF(FROM_UNIXTIME((dFechaTerminoOperaciones - 25569) * 86400) IS NOT NULL,FROM_UNIXTIME((dFechaTerminoOperaciones - 25569) * 86400),dFechaTerminoOperaciones) AS dFechaTerminoOperaciones,
                IF(FROM_UNIXTIME((dFechaAtraque - 25569) * 86400) IS NOT NULL,FROM_UNIXTIME((dFechaAtraque - 25569) * 86400),dFechaAtraque) AS dFechaAtraque,
                IF(FROM_UNIXTIME((dFechaCruceLP - 25569) * 86400) IS NOT NULL,FROM_UNIXTIME((dFechaCruceLP - 25569) * 86400),dFechaCruceLP) AS dFechaCruceLP,
                IF(FROM_UNIXTIME((dFechaFondeo - 25569) * 86400) IS NOT NULL,FROM_UNIXTIME((dFechaFondeo - 25569) * 86400),dFechaFondeo) AS dFechaFondeo,
                
                a.sTramo
            FROM cat_buques b
            INNER JOIN ope_arribos a ON a.skBuque = b.skBuque
            WHERE b.skEstatus = 'AC' AND a.skEstatus = 'AC' ORDER BY dFechaInicioOperaciones DESC";

/*
a.dFechaInicioOperaciones,
                a.dFechaTerminoOperaciones,
                a.dFechaAtraque,
                a.dFechaCruceLP,
                a.dFechaFondeo,
*/

        $result = Conn::query($sql);
        if (!$result) { return false; }
        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }

}