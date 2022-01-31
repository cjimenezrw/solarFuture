<?php

Class Emso_inde_Controller Extends Empr_Model
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
    
    public function getEmpresasSocios(){

        $configuraciones = array();
        $configuraciones['query'] = " SELECT 
            es.*
            ,IF(e.sRFC IS NOT NULL,e.sRFC,IF(e.sTelefono IS NOT NULL,e.sTelefono,IF(e.sCorreo IS NOT NULL,e.sCorreo,NULL))) AS sRFC
            ,e.sNombre AS empresa
            ,e.sNombreCorto
            ,et.sNombre AS empresaTipo
            ,ep.sRFC AS RfcPropietario
            ,ep.sNombre AS empresaPropietario 
            ,est.sNombre AS estatus
            FROM rel_empresasSocios es
            INNER JOIN cat_empresas e ON e.skEmpresa = es.skEmpresa
            INNER JOIN cat_empresasTipos et ON et.skEmpresaTipo = es.skEmpresaTipo
            INNER JOIN rel_empresasSocios esp ON esp.skEmpresaSocio = es.skEmpresaSocioPropietario
            INNER JOIN cat_empresas ep ON ep.skEmpresa = esp.skEmpresa
            INNER JOIN core_estatus est oN est.skEstatus = es.skEstatus";
        
        if(!parent::verify_permissions('A')){
            $configuraciones['query'] .= " WHERE es.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);
        }
        
        
        $data = parent::crear_consulta($configuraciones);
        if($data['filters']){ return $data['data']; }
        if(isset($_POST['generarExcel'])){ 
            return $data['data']; 
        }
        $result = $data['data'];
        $data['data'] = array();
        $i=0;
        while ($row = Conn::fetch_assoc($result)) {
            // Reglas de Negocio para Menu Emergente
            $regla = array(
                "menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            utf8($row);
            $data['data'][$i] = array(
                'skEmpresaSocio'=>$row['skEmpresaSocio'],
                'skEmpresa'=>$row['skEmpresa'],
                'skEmpresaSocioPropietario'=>$row['skEmpresaSocioPropietario'],
                'skEmpresaTipo'=>$row['skEmpresaTipo'],
                'skEstatus'=>$row['skEstatus'],
                'dFechaCreacion'=>($row['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'skUsuarioCreacion'=>$row['skUsuarioCreacion'],
                'dFechaModificacion'=>($row['dFechaModificacion'] ? date('d/m/Y  H:i:s', strtotime($row['dFechaModificacion'])): ''),
                'skUsuarioModificacion'=>$row['skUsuarioModificacion'],
                'sRFC'=>$row['sRFC'],
                'empresa'=>$row['empresa'],
                'sNombreCorto'=>$row['sNombreCorto'],
                'empresaTipo'=>$row['empresaTipo'],
                'RfcPropietario'=>$row['RfcPropietario'],
                'empresaPropietario'=>$row['empresaPropietario'],
                'estatus'=>$row['estatus'],
                'menuEmergente'      => parent::menuEmergente($regla,$row['skEmpresaSocio'])
            );
            $i++;
        }
        Conn::free_result($result);
        return $data;
    }
    
    public function generarExcel(){
        $data = $this->getEmpresasSocios();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }
    
    public function generarPDF() {
        return parent::generar_pdf(
            $_POST['title'], 
            $_POST['headers'], 
            $this->getEmpresasSocios()
        );
    }
}
