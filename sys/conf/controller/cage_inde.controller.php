<?php

Class Cage_inde_Controller Extends Conf_Model {

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

    /**
     * getCatalogosGenerales
     *
     * Funcion para obtener los datos de los catalogos de sistemas
     * 
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return ARRAY
     */
    public function getCatalogosGenerales() {

        $configuraciones = [];
        $configuraciones['query'] = "SELECT ccs.*, 
            ce.sNombre AS estatus, 
            CONCAT(cu.sNombre,' ',cu.sApellidoPaterno) AS usuarioCreacion,
            (SELECT COUNT(*) FROM rel_catalogosSistemasOpciones rcs where rcs.skCatalogoSistema = ccs.skCatalogoSistema AND rcs.skEstatus = 'AC') AS n,
            ce.sIcono AS estatusIcono,
            ce.sColor AS estatusColor
            FROM cat_catalogosSistemas ccs
            INNER JOIN core_estatus ce ON ce.skEstatus = ccs.skEstatus
            LEFT JOIN cat_usuarios cu ON cu.skUsuario = ccs.skUsuarioCreacion 
            LEFT JOIN rel_catalogosSistemasOpciones rcso ON rcso.skCatalogoSistema = ccs.skCatalogoSistema
            WHERE rcso.skEstatus ='AC'
            GROUP BY ccs.skCatalogoSistema,ccs.skEstatus,ccs.sNombre,ccs.skUsuarioCreacion,ccs.dFechaCreacion,ccs.skUsuarioModificacion,ccs.dFechaModificacion,ce.skEstatus,ce.sNombre,cu.sNombre,ce.sIcono,ce.sColor,cu.sApellidoPaterno";
            
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
                    menuEmergente1 => EDITAR
                    menuEmergente2 => ELIMINAR
                    menuEmergente3 => DETALLES
                */

                $regla = [
                    "menuEmergente1" => $this->ME_Editar($row),
                    "menuEmergente2" => $this->ME_Eliminar($row)
                ];

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skCatalogoSistema']);
                //exit('<pre>'.print_r($row,1).'</pre>');
                array_push($data['data'],$row);
        }
        return $data;
    }

    /**
     * ME_Editar
     *
     * Condición de Menú Emergente Editar catalogos del sistema
     * Solo puede Editar catalogos del sistema SI el skEstatus != EL
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
     * Condición de Menú Emergente Eliminar catalogos del sistema
     * Solo puede Eliminar catalogos del sistema SI el skEstatus != EL
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
            $this->conf['skCatalogoSistema'] = (isset($_POST['id']) ? $_POST['id'] : NULL);

            if($this->conf['skCatalogoSistema']){
                $stpCU_catalogosSistemas = parent::stpCU_catalogosSistemas();
                if(!$stpCU_catalogosSistemas){
                    $this->data = ['success'=>FALSE,'message'=>'NO SE PUDO ELIMINAR EL REGISTRO','datos'=>NULL];
                    return $this->data;
                }
            }

            return $this->data;
        }
    }

    /**
     * generarExcel
     *
     * Generar Excel
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return file
     */
    public function generarExcel(){
        $data = $this->getCatalogosGenerales();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    /**
     * generarPDF
     *
     * Generar PDF
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return file
     */
    public function generarPDF() {
        parent::generar_pdf($_POST['title'], $_POST['headers'], $this->getCatalogosGenerales());
    }
}
