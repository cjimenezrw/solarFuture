<?php

Class Vasi_inde_Controller Extends Conf_Model
{

    // CONST //
        const HABILITADO = 0;
        const DESHABILITADO = 1;
        const OCULTO = 2;
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
        private $data = [];

    public function __construct()
    {
        parent::init();
    }

    public function __destruct()
    {

    }
    public function getVariablesSistema()
    {
        //menu Emergente
        //print_r($_SESSION['modulos'][$this->sysController]['menuEmergente']);
        $configuraciones = [];

        $configuraciones['query'] = "SELECT cv.*
            ,ce.sNombre AS estatus
            ,ce.sIcono AS estatusIcono
            ,ce.sColor AS estatusColor
            ,CONCAT(u.sNombre,' ',u.sApellidoPaterno) AS usuarioCreacion
            FROM core_variables cv
            INNER JOIN core_estatus ce on ce.skEstatus = cv.skEstatus
            INNER JOIN cat_usuarios u ON u.skUsuario =  cv.skUsuarioCreacion";

        // aqui se enviarian los where personalizados por empresa o perfil
        $data = parent::crear_consulta($configuraciones);
        // Retorna el Resultado del Query para la Generación de Excel y Reportes Automáticos //
            if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico']) || $data['filters']) {
                return $data['data'];
            }

        $result = $data['data'];
        $data['data'] = [];
        foreach (Conn::fetch_assoc_all($result) AS $row) {
                utf8($row);

                /*
                    menuEmergente1 => Editar
                    menuEmergente2 => -
                    menuEmergente3 => Inactivar/Activar
                    menuEmergente4 => Eliminar
                */

                $regla = [
                    "menuEmergente1" => $this->ME_Editar($row),
                    "menuEmergente3" => $this->ME_Inactivar_Activar($row),
                    "menuEmergente4" => $this->ME_Eliminar($row)
                ];

                $row['dFechaCreacion'] = ($row['dFechaCreacion']) ? date('d/m/Y  H:i:s', strtotime($row['dFechaCreacion'])) : '';
                $row['menuEmergente'] = parent::menuEmergente($regla, $row['skVariable']);
                //exit('<pre>'.print_r($row,1).'</pre>');
                array_push($data['data'],$row);
        }
        return $data;
    }
    public function generarExcelVariablesSistema(){
        $data = $this->getVariablesSistema();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }

    /**
     * ME_Editar
     *
     * Condición de Menú Emergente Editar
     * Solo puede Editar skEstatus != EL
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @param type $row
     * @return int
     */
    public function ME_Editar(&$row){
        if(in_array($row['skEstatus'],['EL'])){
            return SELF::DESHABILITADO;
        }else{
            return SELF::HABILITADO;
        }
    }

    /**
     * ME_Eliminar
     *
     * Condición de Menú Emergente ELiminar
     * Solo puede Eliminar variables SI el skEstatus != EL
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

            $this->conf['axn'] = 'cambiar_estatus';
            $this->conf['skVariable'] = (isset($_POST['id']) ? $_POST['id'] : NULL);
            $this->conf['skEstatus'] = 'EL';

            if($this->conf['skVariable']){
                $stpCUD_variablesSistema = parent::stpCUD_variablesSistema();
                if(!$stpCUD_variablesSistema){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = isset($stpCUD_variablesSistema['message']) ? $stpCUD_variablesSistema['message'] : 'Hubo un error al inactivar la variable.';
                    $this->data['messageSQL'] = isset($stpCUD_variablesSistema['messageSQL']) ? $stpCUD_variablesSistema['messageSQL'] : 'Hubo un error al inactivar la variable.';
                    return $this->data;
                }
            }

            return $this->data;
        }
    }

     /**
     * ME_Inactivar_Activar
     *
     * Condición de Menú Emergente Inactivar Y Activar
     * Solo puede Inactivar variables SI el skEstatus = 'AC' y Activar Si el skEstatus = 'IN'
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @param type $row
     * @return int
     */
    public function ME_Inactivar_Activar(&$row, $function = FALSE){
        if(!$function){
            if(in_array($row['skEstatus'], ['IN'])){
                return ["titulo" => "Activar"];
            }else{
                if(in_array($row['skEstatus'], ['EL'])){
                    return SELF::DESHABILITADO;
                }else{
                    return ["titulo"=>"Inactivar"];
                }
            }
        }else{
            $this->data = ['success'=>TRUE,'message'=>NULL,'datos'=>NULL];

            $this->conf['axn'] = 'cambiar_estatus';
            $this->conf['skVariable'] = (isset($_POST['id']) ? $_POST['id'] : NULL);
            $this->conf['skEstatus'] = (isset($_POST['skEstatus']) ? $_POST['skEstatus'] : NULL);

            if($this->conf['skEstatus'] == 'IN'){
                $this->conf['skEstatus'] = 'AC';
            }elseif($this->conf['skEstatus'] == 'AC'){
                $this->conf['skEstatus'] = 'IN';
            }

            if($this->conf['skVariable']){
                $stpCUD_variablesSistema = parent::stpCUD_variablesSistema();
                if(!$stpCUD_variablesSistema){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = isset($stpCUD_variablesSistema['message']) ? $stpCUD_variablesSistema['message'] : 'Hubo un error al inactivar/activar la variable.';
                    $this->data['messageSQL'] = isset($stpCUD_variablesSistema['messageSQL']) ? $stpCUD_variablesSistema['messageSQL'] : 'Hubo un error al inactivar/activar la variable.';
                    return $this->data;
                }
            }
            $this->data['success'] = true;
            return $this->data;
        }

    }
}

