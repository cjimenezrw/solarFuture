<?php

Class Modu_inde_Controller Extends Conf_Model {
    
    
       // CONST //
    const HABILITADO = 0;
    const DESHABILITADO = 1;
    const OCULTO = 2;

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = [];

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }

    //AQUÍ VAN LAS FUNCIONES//
    public function getModulos(){
    	$configuraciones = [];

        /*    
        */

        $configuraciones['query'] = "SELECT cm.*
            ,ce.sNombre AS estatus
            ,ce.sIcono AS estatusIcono
            ,ce.sColor AS estatusColor
            ,cmp.sTitulo as moduloPadre
            ,CONCAT(uc.sNombre,' ',uc.sApellidoPaterno) AS usuarioCreacion
            ,CONCAT(um.sNombre,' ',um.sApellidoPaterno) AS usuarioModificacion
            FROM core_modulos cm
            INNER JOIN core_estatus ce on ce.skEstatus = cm.skEstatus
            LEFT JOIN cat_usuarios uc ON uc.skUsuario =  cm.skUsuarioCreacion
            LEFT JOIN cat_usuarios um ON um.skUsuario =  cm.skUsuarioCreacion
            LEFT JOIN core_modulos cmp ON cmp.skModulo = cm.skModuloPadre";
            

        // FILTROS //

        // SE EJECUTA LA CONSULTA //
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

                /*
                    menuEmergente1 => Editar
                    menuEmergente2 => -
                    menuEmergente3 => Eliminar
                    menuEmergente3 => Detalles
                */

                $regla = [
                   "menuEmergente1" => $this->ME_Editar($row),
                   "menuEmergente2" => $this->ME_Eliminar($row)
                ];

                $row['dFechaModificacion'] = ($row['dFechaModificacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaModificacion'])) : '';
                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skModulo']);
                //exit('<pre>'.print_r($row,1).'</pre>');
                array_push($data['data'],$row);
        }
        return $data;
    }

    /**
     * ME_Editar
     *
     * Condición de Menú Emergente Editar
     * Solo puede Editar SI el skEstatus != EL
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @param type $row
     * @return int
     */
    public function ME_Editar(&$row){
        if(in_array($row['skEstatus'], ['EL'])){
            return SELF::DESHABILITADO;
        }else{
            return SELF::HABILITADO;
        }
    }
    
    /**
     * ME_Eliminar
     *
     * Condición de Menú Emergente Editar
     * Solo puede Editar SI el skEstatus != EL
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @param type $row
     * @return int
     */
    public function ME_Eliminar(&$row, $function = FALSE){
        if(!$function){
            if(in_array($row['skEstatus'], ['EL'])){
                return SELF::DESHABILITADO;
            }else{
                return SELF::HABILITADO;
            }
        }else{
            $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];

            $this->conf['axn'] = (isset($_POST['axn']) ? $_POST['axn'] : NULL);
            $this->conf['skModulo'] = (isset($_POST['id']) ? $_POST['id'] : NULL);

            if($this->conf['skModulo']){
                $stpCUD_eliminarModulo = parent::stpCUD_coreModulos();
                if(!$stpCUD_eliminarModulo){
                    $this->data = ['success'=>FALSE,'message'=>'NO SE PUDO ELIMINAR EL REGISTRO','datos'=>NULL];
                    return $this->data;
                }
            }

            return $this->data;
        }
    }

    public function generarExcel(){
        $data = $this->getModulos();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    public function generarPDF() {
        return parent::generar_pdf(
           $_POST['title'], 
           $_POST['headers'], 
           $this->getModulos()
        );
    }
}