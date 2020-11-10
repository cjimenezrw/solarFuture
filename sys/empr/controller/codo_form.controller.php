<?php

/**
 * Grup form controller
 * Controlador de la vista codo_form
 * @author Jonathan Topete <jtopete@woodward.com.mx>
 */
Class Codo_form_Controller Extends Empr_Model {

    private $data = array();

    public function __construct() {
        parent::init();
    }

    public function __destruct() {

    }

    /**
     * Acciones de grupos
     *
     * Esta funcion procesa las acciones CUD de grupos, retornando una respuesta
     * como JSON, que indica a la interfaz si la accion fue exitosa o no
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function accionesGrupos() {

        $this->data['response'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        //Entra si vienen datos por POST para hacer el guardado
        if ($_POST) {
            $this->grupo['skGrupo'] = (isset($_POST['skGrupo']) ? $_POST['skGrupo'] : NULL);
            $this->grupo['skEstatus'] = ($_POST['skEstatus'] ? $_POST['skEstatus'] :NULL);
            $this->grupo['sNombre'] = ($_POST['sNombre'] ? $_POST['sNombre'] : NULL);

            if(isset($_POST['skEmpresaSocio'])){
                $this->grupo['skEmpresaSocio'] = array_filter($_POST['skEmpresaSocio']);

            }
            $skSucursal = parent::acciones_grupo();

            if ($skSucursal) {
                $this->data['success'] = true;
                $this->data['message'] = 'Registro insertado con &eacute;xito.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return true;
            } else {
                //echo "llego aqui";
                $this->data['success'] = false;
                $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
                header('Content-Type: application/json');
                echo json_encode($this->data);
                return false;
            }
        }
        $this->load_view('grup_form', $this->data);
        return true;
    }


    /**
     * Consultar grupo
     *
     * Esta funcion retorna los datos de grupos
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return true | false Retorna true o false si algo salio mal.
     */
    public function consultarGrupo() {
        $this->data['Estatus'] = parent::consultar_estatus();
        if (isset($_GET['p1'])) {
            $this->grupo['skGrupo'] = $_GET['p1'];
            $this->data['datos'] = parent::consulta_grupo();
            $this->data['grupo_empresas'] = parent::consultar_empresasGrupo();
            return $this->data;
        }
        return $this->data;
        return false;
    }

    /**
     * Consultar grupo
     *
     * Función que retorna los datos de empresas
     *
     * @author Jonathan Topete <jtopete@woodward.com.mx>
     * @return true | false Retorna true o false en caso de error.
     */
    public function consultarTipo() {
        $this->data['Estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        if (isset($_GET['p1'])) {
            $this->tiposEmpr['skEmpresaTipo'] = $_GET['p1'];
            $this->data['tipos_documentos'] = $this->consultar_documentos();
            $this->data['datos'] = parent::consulta_tipoEmpr();
            return $this->data;
        }
        return $this->data;
    }

    public function consultar_documentos(){
        $consultar_documentos = parent::consultar_documentos();
        $records = array();
        if ($consultar_documentos) {
            while ($row = Conn::fetch_assoc($consultar_documentos)) {
                utf8($row, false);
                $data = array(
                    'skTipoDocumento'=>$row['skTipoDocumento'],
                    'sNombre'=>$row['sNombre']
                );
                array_push($records,$data);
            }
        }
        return ($records);
    }

    /**
     * guardar
     *
     * Acción para creación o edición de Configuracion Documentos Empresas.
     *
     * @author Jonathan Topete Figueroa <jtopete@woodward.com.mx>
     * @return mixed Retorna un array del resultado de la operación.
     */
    public function guardar() {
        $this->data['success'] = FALSE;
        $this->data['message'] = NULL;
        $this->data['datos'] = FALSE;

        $skEmpresaTipo = (isset($_POST['skEmpresaTipo']) ? $_POST['skEmpresaTipo'] : (isset($_GET['skEmpresaTipo']) ? $_GET['skEmpresaTipo'] : NULL));

        $skDocumento        = (isset($_POST['skTipoDocumento']) ? $_POST['skTipoDocumento'] : (isset($_GET['skTipoDocumento']) ? $_GET['skTipoDocumento'] : NULL));
        $iObligatorio       = (isset($_POST['iObligatorio']) ? $_POST['iObligatorio'] : (isset($_GET['iObligatorio']) ? $_GET['iObligatorio'] : NULL));
        $iOriginal          = (isset($_POST['iOriginal']) ? $_POST['iOriginal'] : (isset($_GET['iOriginal']) ? $_GET['iOriginal'] : NULL));
        $iMultiple          = (isset($_POST['iMultiple']) ? $_POST['iMultiple'] : (isset($_GET['iMultiple']) ? $_GET['iMultiple'] : NULL));
        $iFechaExpiracion   = (isset($_POST['iFechaExpiracion']) ? $_POST['iFechaExpiracion'] : (isset($_GET['iFechaExpiracion']) ? $_GET['iFechaExpiracion'] : NULL));

 /*       if(!$skDocumento || !$iObligatorio || !$iOriginal){
            $this->data['message'] = 'Error, faltan algunos datos';
            return $this->data;
        }*/
        $sqlDel = "DELETE FROM rel_come_confTiposDocEmpr WHERE skEmpresaTipo = '$skEmpresaTipo'";
        $sqlDelete = Conn::query($sqlDel);

        $i = 0;
        foreach($skDocumento AS $k=>$v){
            $this->cd['skEmpresaTipo'] = $skEmpresaTipo;
            $this->cd['skTipoDocumento'] = $skDocumento[$i];
            $this->cd['iObligatorio'] = $iObligatorio[$i];
            $this->cd['iOriginal'] = $iOriginal[$i];
            $this->cd['iMultiple'] = $iMultiple[$i];
            $this->cd['iFechaExpiracion'] = $iFechaExpiracion[$i];
            //$this->cd['skDocumentoConfig'] = (isset($_POST['skDocumentoConfig'][$i]) ? $_POST['skDocumentoConfig'][$i] : NULL);
            $this->cd['skDocumentoConfig'] = NULL;

            //echo $skDocumento[$i] . " - " . $iObligatorio[$i] . " - " . $iOriginal[$i] . " + ";
            if(!parent::stpCU_confTiposDocEmpr()){
                exit("fail");
                break;
            }
            $i++;
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'Configuración guardada con éxito';
        return $this->data;
    }

    public function get_ConfigDocsEmpr(){
        $this->cd['skEmpresaTipo'] = (isset($_GET['p1']) ? $_GET['p1'] : NULL);
        if(is_null($this->cd['skEmpresaTipo']) || empty($this->cd['skEmpresaTipo'])){
            return FALSE;
        }
        $data = parent::getConfigDocsEmpr();
        if(!$data){
            return FALSE;
        }
        $records = array();
        foreach($data AS $k=>$v){
            $io = "NO";
            $ior = "NO";
            $dFe = "NO";
            $iMu = "NO";
            if ($v['iObligatorio'] === "1"){
                $io = "SI";
            }
            if ($v['iOriginal'] === "1"){
                $ior = "SI";
            }
            if ($v['iFechaExpiracion'] === "1"){
                $dFe = "SI";
            }
            if ($v['iMultiple'] === "1"){
                $iMu = "SI";
            }
            $input = '';
            $input .= '<input data-name="'.$v['skDocumentoConfig'].'" type="text" name="skDocumentoConfig[]" value="'.$v['skDocumentoConfig'].'" hidden />';
            $input .= '<input data-name="'.$v['sNombre'].'" type="text" name="skTipoDocumento[]" value="'.$v['skTipoDocumento'].'" hidden/>';
            $input .= '<input data-name="'.$io.'" type="text" name="iObligatorio[]" value="'.$v['iObligatorio'].'" hidden/>';
            $input .= '<input data-name="'.$ior.'" type="text" name="iOriginal[]" value="'.$v['iOriginal'].'" hidden/>';
            $input .= '<input data-name="'.$dFe.'" type="text" name="iFechaExpiracion[]" value="'.$v['iFechaExpiracion'].'" hidden/>';
            $input .= '<input data-name="'.$dFe.'" type="text" name="iMultiple[]" value="'.$v['iMultiple'].'" hidden/>';
            array_push($records,array(
                'id'=>$v['skDocumentoConfig'],
                'skTipoDocumento'=>$v['sNombre'].$input,
                'iObligatorio'=>$io,
                'iOriginal'=>$ior,
                'iFechaExpiracion'=>$dFe,
                'iMultiple'=>$iMu
            ));
            //$input = '';
        }
        //print_r($records);
        //exit();
        return $records;
    }

}