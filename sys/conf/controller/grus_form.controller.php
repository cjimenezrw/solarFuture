<?php

/**
 * Controller de módulo de agregado de grupos de usuarios
 *
 * Este es el controlador del módulo de agregado de grupos de usuarios (grus-form)
 *
 * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
 */
Class Grus_form_Controller Extends Conf_Model {

    // PUBLIC VARIABLES //
    // PROTECTED VARIABLES //
    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    /**
     * Guardar
     *
     * Módulo para Guardar grupos de usuarios
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed     Retorna un array del resultado de la operación.
     */
    public function guardar() {

        $this->data['success'] = TRUE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        if ($_POST) {
            $this->gruposUsuarios['skGrupoUsuario'] = isset($_POST['skGrupoUsuario']) ? $_POST['skGrupoUsuario'] : NULL;
            $this->gruposUsuarios['skUsuarioResponsable'] = isset($_POST['skUsuarioResponsable']) ? $_POST['skUsuarioResponsable'] : NULL;
            $this->gruposUsuarios['skEstatus'] = isset($_POST['skEstatus']) ? $_POST['skEstatus'] : NULL;
            $this->gruposUsuarios['sNombre'] = isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL;
            $this->gruposUsuarios['sDescripcion'] = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : NULL;
            $skUsuario = isset($_POST['skUsuario']) ? $_POST['skUsuario'] : NULL;
            $iRecursivo = isset($_POST['iRecursivo']) ? $_POST['iRecursivo'] : NULL;

            Conn::begin('stpCU_gruposUsuarios');

            $this->gruposUsuarios['skGrupoUsuario'] = parent::stpCU_gruposUsuarios();

            if (!$this->gruposUsuarios['skGrupoUsuario']) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_gruposUsuarios');
                return $this->data;
            }

            if (!parent::delete_gruposUsuarios_usuarios()) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_gruposUsuarios');
                return $this->data;
            }

            if($skUsuario){
                $i = 0;
                foreach ($skUsuario AS $k => $v) {
                    $this->gruposUsuarios['skUsuario'] = $v;
                    $this->gruposUsuarios['iRecursivo'] = $iRecursivo[$i];
                    if (!parent::stpC_gruposUsuarios_usuarios()) {
                        $this->data['success'] = FALSE;
                        break;
                    }
                    $i++;
                }
            }

            if(!$this->data['success']){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro.';
                Conn::rollback('stpCU_gruposUsuarios');
                return $this->data;
            }

            // RETORNAMOS RESPUESTA //
            $this->data['success'] = TRUE;
            $this->data['message'] = 'Registro guardado con &eacute;xito.';
            $this->data['datos'] = $this->gruposUsuarios['skGrupoUsuario'];
            Conn::commit('stpCU_gruposUsuarios');

            return $this->data;
        }

        return FALSE;
    }

    /**
     * consultar
     *
     * Consultar grupo de usuarios por skGrupoUsuario
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @return mixed     Retorna un array del resultado de la operación.
     */
    public function consultar() {
        $this->data['estatus'] = parent::consultar_core_estatus(array('AC','IN'), true);
        if (isset($_GET['p1'])) {
            $this->gruposUsuarios['skGrupoUsuario'] = $_GET['p1'];
            $this->data['datos'] = parent::consultarGruposUsuarios();
            $this->data['gruposUsuarios_usuarios'] = $this->gruposUsuarios_usuarios();
            return $this->data;
        }
        return $this->data;
    }

    public function gruposUsuarios_usuarios(){
        $gruposUsuarios_usuarios = parent::consultarGruposUsuarios_usuarios();

        if(!$gruposUsuarios_usuarios){
            return FALSE;
        }

        $records = array();
        while($row = Conn::fetch_assoc($gruposUsuarios_usuarios)){
            utf8($row);
            $data = array(
                'id'=>$row['skUsuario'],
                'usuario'=>$row['usuario'],
                'iRecursivo'=>( $row['iRecursivo'] === 1 ) ? 'Si' : 'No'
            );
            $input = '<input data-name="'.$row['usuario'].'" type="text" name="skUsuario[]" value="'.$row['skUsuario'].'" hidden />';
            $input .= '<input data-name="'.$row['iRecursivo'].'" type="text" name="iRecursivo[]" value="'.$row['iRecursivo'].'" hidden />';
            $data['usuario'] = $data["usuario"] . $input;
            array_push($records,$data);
        }

        return json_encode($records);
    }

}
