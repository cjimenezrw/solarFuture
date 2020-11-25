<?php
Class Pros_inde_Controller Extends Empr_Model{
    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;

    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    
    public function consultar(){
        $configuraciones = [];
        $configuraciones['log'] = TRUE;
        $configuraciones['query'] = "SELECT      
             pros.skProspecto
            ,pros.skEmpresaSocioPropietario
            ,pros.skEstatus
            ,pros.iFolioProspecto
            ,pros.sNombreContacto
            ,pros.sEmpresa
            ,pros.sCorreo
            ,pros.sTelefono
            ,pros.sComentarios
            ,pros.skUsuarioCreacion
            ,pros.dFechaCreacion
            ,pros.skUsuarioModificacion
            ,pros.dFechaModificacion
            ,CONCAT(ucre.sNombre,' ',ucre.sApellidoPaterno) AS usuarioCreacion
            ,est.sNombre AS estatus
            ,est.sIcono AS estatusIcono
            ,est.sColor AS estatusColor
            FROM cat_prospectos pros
            INNER JOIN core_estatus est ON est.skEstatus = pros.skEstatus
            INNER JOIN cat_usuarios ucre ON ucre.skUsuario = pros.skUsuarioCreacion
            WHERE pros.skEmpresaSocioPropietario = ".escape($_SESSION['usuario']['skEmpresaSocioPropietario']);
        
        $data = parent::crear_consulta($configuraciones);
        if(is_array($data) && isset($data['success']) && $data['success'] == false){
            $result['draw'] = isset($_POST['draw']) ? $_POST['draw'] : 0;
            $result['recordsTotal'] = 0;
            $result['recordsFiltered'] = 0;
            $result['data'] = [];
            $result['filters'] = false;
            return $result;
        }
        if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
            return $data['data'];
        }
        $result = $data['data'];
        $data['data'] = [];
        foreach (Conn::fetch_assoc_all($result) AS $row) {
            utf8($row);
            /*
                menuEmergente1 => Editar
                menuEmergente2 => Eliminar
                menuEmergente3 => Detalles
            */
            $regla = [
                "menuEmergente1" => $this->ME_Editar($row),
                "menuEmergente2" => $this->ME_Eliminar($row),
                "menuEmergente3" => self::HABILITADO
            ];
            $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
            $row['menuEmergente'] = parent::menuEmergente($regla, $row['skProspecto']);
            array_push($data['data'],$row);
        }
        return $data;
    }

    public function ME_Editar(&$row, $function = FALSE){
        if(!$function){
            if(in_array($row['skEstatus'], ['NU'])){
                return SELF::HABILITADO;
            }else{
                return SELF::DESHABILITADO;
            }
        }else{
            $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];

            $params = [];
            return $this->data;
        }
    }

    public function ME_Eliminar(&$row, $function = FALSE){
        if(!$function){
            if(in_array($row['skEstatus'], ['NU'])){
                return SELF::HABILITADO;
            }else{
                return SELF::DESHABILITADO;
            }
        }else{
            $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];

            $params = [];
            return $this->data;
        }
    }
    
    public function generarExcel(){
        parent::generar_excel($_POST['title'], $_POST['headers'], $this->consultar());
    }

    public function generarPDF() {
        return parent::generar_pdf($_POST['title'], $_POST['headers'], $this->consultar());
    }
}