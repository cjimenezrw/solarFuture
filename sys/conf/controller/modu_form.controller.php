<?php

Class modu_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
            private$data = [];
            private$idTran = 'stpCUD_altaModulos';

    public function __construct() {
        parent::init();
    }

    public function __destruct() {
        
    }

    public function guardar() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->conf['axn'] = 'guardar';

        if (isset($_GET['p1']) && !empty($_GET['p1'])) {
            $this->conf['axn'] = 'editar';
        }
        /* DATOS TAB GENERAL */
            $this->conf['skModulo'] = (isset($_POST['skModuloAlta']) ? $_POST['skModuloAlta'] : (isset($_GET['p1']) ? $_GET['p1'] : NULL));
            $this->conf['skModuloPrincipal'] = (isset($_POST['skModuloPrincipal']) ? $_POST['skModuloPrincipal'] : NULL);
            $this->conf['skModuloPadre'] = (isset($_POST['skModuloPadre']) ? $_POST['skModuloPadre'] : NULL);
            $this->conf['sNombre'] = (isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL);
            $this->conf['sTitulo'] = (isset($_POST['sTitulo']) ? $_POST['sTitulo'] : NULL);
            $this->conf['iPosicion'] = (isset($_POST['iPosicion']) ? $_POST['iPosicion'] : NULL);
            $this->conf['sDescripcion'] = (isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : NULL);
            $moduloPermisos = (isset($_POST['moduloPermisos']) ? $_POST['moduloPermisos'] : NULL);
            $skMenu = (isset($_POST['skMenu']) ? $_POST['skMenu'] : NULL);
            $this->conf['sIcono'] = (isset($_POST['sIcono']) ? $_POST['sIcono'] : NULL);
            $this->conf['sColor'] = (isset($_POST['sColor']) ? $_POST['sColor'] : NULL);

        /* DATOS TAB BOTONES */
            $skBoton = (isset($_POST['skBoton']) ? $_POST['skBoton'] : NULL);
            $posicionBoton = (isset($_POST['posicionBoton']) ? $_POST['posicionBoton'] : NULL);
            $moduloPadreBoton = (isset($_POST['moduloPadreBoton']) ? $_POST['moduloPadreBoton'] : NULL);
            $nombreBoton = (isset($_POST['nombreBoton']) ? $_POST['nombreBoton'] : NULL);
            $funcionBoton = (isset($_POST['funcionBoton']) ? $_POST['funcionBoton'] : NULL);
            $iconoBoton = (isset($_POST['iconoBoton']) ? $_POST['iconoBoton'] : NULL);
            $comportamientoBoton = (isset($_POST['comportamientoBoton']) ? $_POST['comportamientoBoton'] : NULL);


        /* DATOS TAB MENU EMERGENTE */
            $moduloPadreME = (isset($_POST['moduloPadreME']) ? $_POST['moduloPadreME'] : NULL);
            $permisoME = (isset($_POST['permisoME']) ? $_POST['permisoME'] : NULL);
            $posicionME = (isset($_POST['posicionME']) ? $_POST['posicionME'] : NULL);
            $funcionME = (isset($_POST['funcionME']) ? $_POST['funcionME'] : NULL);
            $tituloME = (isset($_POST['tituloME']) ? $_POST['tituloME'] : NULL);
            $iconoME = (isset($_POST['iconoME']) ? $_POST['iconoME'] : NULL);
            $comportamientoME = (isset($_POST['comportamientoME']) ? $_POST['comportamientoME'] : NULL);

        /* DATOS TAB CARACTERISTICAS */
            $skCaracteristicaModulo = (isset($_POST['skCaracteristicaModulo']) ? $_POST['skCaracteristicaModulo'] : NULL);

        //SE VALIDAN LOS DATOS RECIBIDOS
        if(!$this->validaciones()){
            return $this->data;
        }
        
        Conn::begin($this->idTran);
        //Guardar datos generales del modulo
            $stpCUD_coreModulos = parent::stpCUD_coreModulos();
            if (!$stpCUD_coreModulos || isset($stpCUD_coreModulos['success']) && $stpCUD_coreModulos['success'] != 1) {
                Conn::rollback($this->idTran);
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar.';
                $this->data['messageSQL'] = $stpCUD_coreModulos['messageSQL'];
                return $this->data;
            }

        // Limpiar Datos de Módulo
            if (isset($_GET['p1']) && !empty($_GET['p1'])) {
                $this->conf['axn'] = 'limpiar_datos_modulos';
                $limpiar_datos_modulos = parent::stpCUD_coreModulos();
                if (!$limpiar_datos_modulos || isset($limpiar_datos_modulos['success']) && $limpiar_datos_modulos['success'] != 1) {
                    Conn::rollback($this->idTran);
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'Hubo un error al guardar.';
                    $this->data['messageSQL'] = $limpiar_datos_modulos['messageSQL'];
                    return $this->data;
                }
            }
        //Guardar iconos del modulo
            if(isset($this->conf['sIcono']) && !empty($this->conf['sIcono'])){
                $this->conf['axn'] = 'guardar_modulos_iconos';
                $guardar_modulos_iconos = parent::stpCUD_coreModulos();
                if (!$guardar_modulos_iconos || isset($guardar_modulos_iconos['success']) && $guardar_modulos_iconos['success'] != 1) {
                    Conn::rollback($this->idTran);
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'Hubo un error al guardar.';
                    $this->data['messageSQL'] = $guardar_modulos_iconos['messageSQL'];
                    return $this->data;
                }
            }

        //Guardar el menú del modulo
            if(isset($skMenu) && !empty($skMenu) && is_array($skMenu)){
                $this->conf['axn'] = 'guardar_modulos_menu';
                foreach ($skMenu as $key => $value) {
                    $this->conf['skMenu'] = $value;
                    $guardar_modulos_menu = parent::stpCUD_coreModulos();
                    if (!$guardar_modulos_menu || isset($guardar_modulos_menu['success']) && $guardar_modulos_menu['success'] != 1) {
                        Conn::rollback($this->idTran);
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al guardar.';
                        $this->data['messageSQL'] = $guardar_modulos_menu['messageSQL'];
                        return $this->data;
                    }
                }
                
            }   

            if (isset($moduloPermisos) && !empty($moduloPermisos) && is_array($moduloPermisos)) {
                //Guardar los permisos del modulo
                $this->conf['axn'] = 'guardar_permisos_modulo';

                foreach ($moduloPermisos as $key => $value) {
                    $this->conf['skPermiso'] = $value;
                    $altaModulosPermisos = parent::stpCUD_coreModulos();
                    if (!$altaModulosPermisos || isset($altaModulosPermisos['success']) && $altaModulosPermisos['success'] != 1) {
                        Conn::rollback($this->idTran);
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al guardar.';
                        $this->data['messageSQL'] = $altaModulosPermisos['messageSQL'];
                        return $this->data;
                    }
                }
            }

            if (isset($skBoton) && !empty($skBoton) && is_array($skBoton)) {
                //Guardar datos de los botones
                $this->conf['axn'] = 'guardar_modulos_botones';
                foreach ($skBoton as $key => $value) {
                    $this->conf['skBoton'] = $value;
                    $this->conf['skModuloPadre'] = isset($moduloPadreBoton[$key]) ? $moduloPadreBoton[$key] : NULL;
                    $this->conf['iPosicion'] = isset($posicionBoton[$key]) ? $posicionBoton[$key] : NULL;
                    $this->conf['sFuncion'] = isset($funcionBoton[$key]) ? $funcionBoton[$key] : NULL;
                    $this->conf['sNombre'] = isset($nombreBoton[$key]) ? $nombreBoton[$key] : NULL;
                    $this->conf['sIcono'] = isset($iconoBoton[$key]) ? $iconoBoton[$key] : NULL;
                    $this->conf['skComportamiento'] = isset($comportamientoBoton[$key]) ? $comportamientoBoton[$key] : NULL;

                    $modulos_botones = parent::stpCUD_coreModulos();
                    if (!$modulos_botones || isset($modulos_botones['success']) && $modulos_botones['success'] != 1) {
                        Conn::rollback($this->idTran);
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al guardar.';
                        $this->data['messageSQL'] = $modulos_botones['messageSQL'];
                        return $this->data;
                    }
                }
            }

            if (isset($moduloPadreME) && !empty($moduloPadreME) && is_array($moduloPadreME)) {

                //Guardar datos de los menus emergentes
                $this->conf['axn'] = 'guardar_modulos_menuEmergente';
                foreach ($moduloPadreME as $key => $value) {
                    $this->conf['skModuloPadre'] = $value;
                    $this->conf['skPermiso'] = isset($permisoME[$key]) ? $permisoME[$key] : NULL;
                    $this->conf['iPosicion'] = isset($posicionME[$key]) ? $posicionME[$key] : NULL;
                    $this->conf['sFuncion'] = isset($funcionME[$key]) ? $funcionME[$key] : NULL;
                    $this->conf['sTitulo'] = isset($tituloME[$key]) ? $tituloME[$key] : NULL;
                    $this->conf['sIcono'] = isset($iconoME[$key]) ? $iconoME[$key] : NULL;
                    $this->conf['skComportamiento'] = isset($comportamientoME[$key]) ? $comportamientoME[$key] : NULL;

                    $modulos_ME = parent::stpCUD_coreModulos();
                    if (!$modulos_ME || isset($modulos_ME['success']) && $modulos_ME['success'] != 1) {
                        Conn::rollback($this->idTran);
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al guardar.';
                        $this->data['messageSQL'] = $modulos_ME['messageSQL'];
                        return $this->data;
                    }
                }
            }

            if (isset($skCaracteristicaModulo) && !empty($skCaracteristicaModulo)) {
                //Guardar datos caracteristicas    
                $this->conf['axn'] = 'guardar_modulos_caracteristicas';
                foreach ($skCaracteristicaModulo as $key => $value) {
                    $this->conf['skCaracteristicaModulo'] = $value;
                    $modulos_caracteristicas = parent::stpCUD_coreModulos();
                    if (!$modulos_caracteristicas || isset($modulos_caracteristicas['success']) && $modulos_caracteristicas['success'] != 1) {
                        Conn::rollback($this->idTran);
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'Hubo un error al guardar.';
                        $this->data['messageSQL'] = $modulos_caracteristicas['messageSQL'];
                        return $this->data;
                    }
                }
            }

        Conn::commit($this->idTran);
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con éxito.';
        return $this->data;
    }

    /*
     * getDatos
     *
     * Funcion para obtener los datos de los Módulos
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return array
     */

    public function getDatos() {
        $this->data = ['success' => TRUE, 'message' => NULL, 'datos' => NULL];

        $this->conf['skModulo'] = (isset($_GET['p1']) && !empty($_GET['p1'])) ? $_GET['p1'] : NULL;
        //se obtienen los tipos de botones de core_botones
        $this->data['tipoBotones'] = parent::_consulta_botones();
        $this->data['caracteristicas'] = parent::_getCaracteristicasModulo();
        $this->data['caracteristicasModulo'] = parent::_consultar_modulos_caracteristicas();
        $this->data['comportamientos'] = parent::_consultar_comportamientos();
        $menu=['id'=>['ACR','LAT','MOB','SUP'],'nombre'=>['Acceso Rápido','Lateral','Mobil','Superior']];
        $this->data['menu']= $menu;
        
        
        if ($this->conf['skModulo']) {
            $this->data['permisosModulo'] = parent::_consultar_modulo_permisos();
            $this->data['modulosMenu'] = parent::_consultar_modulosMenu();
            $this->data['datos'] = parent::_consultar_modulos();

            //DLOREAN_Model::log($this->data,TRUE,TRUE);
            if (!$this->data['datos']) {
                DLOREAN_Model::showError('NO SE ENCONTRÓ EL REGISTRO', 404);
            }

            if (isset($this->data['datos']['skEstatus']) && $this->data['datos']['skEstatus'] == 'EL') {
                DLOREAN_Model::showError('NO SE PUEDE EDITAR UN REGISTRO ELIMINADO', 403);
            }

            $botones = parent::_consultar_modulos_botones();
            $this->data["botones"] = [];
            if ($botones && is_array($botones)) {
                foreach ($botones AS $row) {
                    $input = '<input data-name="' . $row['skBoton'] . '" type="text" name="skBoton[]" value="' . $row['skBoton'] . '" hidden />';
                    $input .= '<input data-name="' . $row['skModuloPadre'] . '" type="text" name="moduloPadreBoton[]" value="' . $row['skModuloPadre'] . '" hidden />';
                    $input .= '<input data-name="' . $row['iPosicion'] . '" type="text" name="posicionBoton[]" value="' . $row['iPosicion'] . '" hidden />';
                    $input .= '<input data-name="' . $row['sNombre'] . '" type="text" name="nombreBoton[]" value="' . $row['sNombre'] . '" hidden />';
                    $input .= '<input data-name="' . $row['sFuncion'] . '" type="text" name="funcionBoton[]" value="' . $row['sFuncion'] . '" hidden />';
                    $input .= '<input data-name="' . $row['sIcono'] . '" type="text" name="iconoBoton[]" value="' . $row['sIcono'] . '" hidden />';
                    $input .= '<input data-name="' . $row['skComportamiento'] . '" type="text" name="comportamientoBoton[]" value="' . $row['skComportamiento'] . '" hidden />';

                    array_push($this->data["botones"], [
                        'id' => $row['skModulo'] . '_' . $row['skModuloPadre'] . '_' . $row['iPosicion'],
                        'skBoton' => $row['skBoton'] . $input,
                        'moduloPadreBoton' => $row['skModuloPadre'],
                        'posicionBoton' => $row['iPosicion'],
                        'nombreBoton' => $row['sNombre'],
                        'funcionBoton' => $row['sFuncion'],
                        'iconoBoton' => $row['sIcono'],
                        'comportamientoBoton' => $row['skComportamiento']
                    ]);
                }
            }

            $ME = parent::_consultar_modulos_menuEmergentes();
            $this->data["ME"] = [];
            if ($ME && is_array($ME)) {
                foreach ($ME AS $row) {
                    $input = '<input data-name="' . $row['skModuloPadre'] . '" type="text" name="moduloPadreME[]" value="' . $row['skModuloPadre'] . '" hidden />';
                    $input .= '<input data-name="' . $row['skPermiso'] . '" type="text" name="permisoME[]" value="' . $row['skPermiso'] . '" hidden />';
                    $input .= '<input data-name="' . $row['skComportamiento'] . '" type="text" name="comportamientoME[]" value="' . $row['skComportamiento'] . '" hidden />';
                    $input .= '<input data-name="' . $row['sTitulo'] . '" type="text" name="tituloME[]" value="' . $row['sTitulo'] . '" hidden />';
                    $input .= '<input data-name="' . $row['iPosicion'] . '" type="text" name="posicionME[]" value="' . $row['iPosicion'] . '" hidden />';
                    $input .= '<input data-name="' . $row['sIcono'] . '" type="text" name="iconoME[]" value="' . $row['sIcono'] . '" hidden />';
                    $input .= '<input data-name="' . $row['sFuncion'] . '" type="text" name="funcionME[]" value="' . $row['sFuncion'] . '" hidden />';


                    array_push($this->data["ME"], [
                        'id' => $row['skModulo'] . '_' . $row['skModuloPadre'] . '_' . $row['iPosicion'],
                        'moduloPadreME' => $row['skModuloPadre'] . $input,
                        'permisoME' => $row['skPermiso'],
                        'comportamientoME' => $row['skComportamiento'],
                        'tituloME' => $row['sTitulo'],
                        'posicionME' => $row['iPosicion'],
                        'iconoME' => $row['sIcono'],
                        'funcionME' => $row['sFuncion']
                    ]);
                }
            }
        }

        return $this->data;
    }

    /*
     * validaciones
     *
     * Funcion VALIDAR los datos de RECIBIDOS
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return bool
     */
    public function validaciones(){
        //SI NO SE INGRESA AL MENOS 1 PERMISO SE RETORNA MENSAJE DE ERROR
        if (!isset($_POST['moduloPermisos']) && empty($_POST['moduloPermisos'])) {
            $this->data = ['success' => FALSE, 'message' => 'ES NECESARIO SELECCIONAR AL MENOS 1 PERMISO PARA EL MÓDULO', 'datos' => NULL];
            return false;
        }

        $validations = [
            'skModulo'=>['message'=>'EL MÓDULO ES'],
            'skModuloPrincipal'=>['message'=>'EL MÓDULO PRINCIPAL ES'],
            'skModuloPadre'=>['message'=>'EL MÓDULO PADRE DEL MÓDULO ES'],
            'sTitulo'=>['message'=>'EL TÍTULO DEL MÓDULO ES'],
            'sNombre'=>['message'=>'EL URI DEL MÓDULO ES'],
            'iPosicion'=>['message'=>'LA POSICIÓN DEL MÓDULO ES']
        ];
        foreach($validations AS $k=>$v){
            if(!isset($this->conf[$k]) || empty(trim($this->conf[$k]))){
                $this->data['success'] = FALSE;
                $this->data['message'] = $v['message'].' REQUERIDO';
                return false;
            }        
        }
        //SE VALIDA CON UNA EXPRESION REGULAR EÑ MODULO
            if( !preg_match("/^([0-9a-z]{4}-[0-9a-z]{4})?$/", $this->conf['skModulo']))
            {
                $this->data = ['success' => FALSE, 'message' => 'EL MÓDULO NO ES VALÍDO  FORMATO xxxx-xxxx.', 'datos' => NULL];
                return false;
            } 
        //SE VALIDA CON UNA EXPRESION REGULAR EÑ MODULO PADRE   
            if( !preg_match("/^([0-9a-z]{4}-[0-9a-z]{4})?$/", $this->conf['skModuloPadre']))
            {
                $this->data = ['success' => FALSE, 'message' => 'EL MÓDULO PADRE NO ES VALÍDO  FORMATO xxxx-xxxx.', 'datos' => NULL];
                return false;
            }
        //SE VALIDA QUE LA POSICIÓN SEA UN NÚMERO
            if(!is_numeric($this->conf['iPosicion'])){
                $this->data = ['success' => FALSE, 'message' => 'LA POSICIÓN DEBE SER UN NÚMERO', 'datos' => NULL];
                return false;
            }
            $validarModulo=$this->validarModulo();
            if( $validarModulo['valid'] != 1){
                $this->data = ['success' => FALSE, 'message' => 'EL MÓDULO YA EXISTE', 'datos' => NULL];
                return false;
            }

        return true;
    }
    /**
     * getCaracteristicasModulo
     *
     * Funcion para consultar caracteristicas del modulo.
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return array
     */
    public function getCaracteristicasModulo() {
        $this->conf['skCaracteristicaModulo'] = (isset($_POST['val']) ? $_POST['val'] : NULL);
        return parent::_getCaracteristicasModulo();
    }

    /*
     * validarModulo
     *
     * Funcion para validar que no exista el responsable.
     *
     * @author Cristhian Eduardo Ureña Fletes <cris_9600_13@hotmail.com>
     * @return array
     */

    public function validarModulo() {
        $this->conf['skModulo'] = (isset($_POST['skModuloAlta']) ? $_POST['skModuloAlta'] : NULL);
        return ['valid' => parent::_validar_modulo()];
    }

}
