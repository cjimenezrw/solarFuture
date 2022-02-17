<?php

Class Emso_form_Controller Extends Empr_Model
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

    /**
    * validarEmpresaSocio
    *
    * Valida que la empresa no esté de alta con la skEmpresaSocioPropietario del usuario logeado
    * esto para que NO se pueda dar de alta la misma empresa con el mismo skEmpresaSocioPropietario
    *
    * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
    * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
    */
    public function validarEmpresaSocio(){
        //$sRFC = isset($_POST['sRFC']) ?  ( ($_POST['sRFC'] === 'XAXX010101000') ?  NULL : $_POST['sRFC'] )    : NULL;
        //$sRFC = isset($_POST['sRFC']) ?  ( ($_POST['sRFC'] === 'XAXX010101000') ?  NULL : ( ($_POST['sRFC'] === 'XEXX010101000') ?  NULL : $_POST['sRFC'] )   )    : NULL;
        $sRFC = (!empty($_POST['sRFC']) ? $_POST['sRFC'] : NULL);
        $sCorreo = (!empty($_POST['sCorreo']) ? $_POST['sCorreo'] : NULL);
        $sTelefono = (!empty($_POST['sTelefono']) ? $_POST['sTelefono'] : NULL);
        $skEmpresaTipo = (!empty($_POST['skEmpresaTipo']) ? $_POST['skEmpresaTipo'] : NULL);
        $skEmpresaSocio = (!empty($_GET['p1']) ? $_GET['p1'] : NULL);

        if($sRFC == 'XAXX010101000'){
            $data['valid'] = TRUE;
            return $data;
        }

        $data = parent::validar_empresaSocio($sRFC,$skEmpresaTipo,$sTelefono,$sCorreo,$skEmpresaSocio);
        $data['valid'] = TRUE;
        if(isset($data['skEmpresaSocio']) && !is_null($data['skEmpresaSocio'])){
            $data['valid'] = FALSE;
        }

        return $data;
    }

    /**
    * consultarSocioEmpresa
    *
    * Obtiene los datos necesarios para el formulario, en caso de editar obtiene los datos a editar.
    *
    * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
    * @return object | false Retorna el objeto de resultados de la consulta o false si algo falla
    */
    public function consultarSocioEmpresa(){
        $this->data['estatus'] = parent::consultar_core_estatus(['AC','IN'],true);
        $this->data['empresasTipos'] = parent::getEmpresasTipos();
         if (isset($_GET['p1'])) {
            $this->empr['skEmpresaSocio'] = (!empty($_GET['p1']) ? $_GET['p1'] : NULL);
            $this->data['datos'] = parent::consultar_empresaSocio($_GET['p1']);
            $this->data['empresasSocios_domicilios'] = parent::_get_empresasSocios_domicilios();
             return $this->data;
        }
        return $this->data;
        return TRUE;
    }

    /**
    * guardar
    *
    * Acción para creación o edición de empresa socio.
    *
    * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
    * @return mixed Retorna un array del resultado de la operación.
    */
    public function guardar(){
        $this->data['success'] = TRUE;
        $this->data['message'] = 'Registro guardado con &eacute;xito.';
        $this->data['datos'] = TRUE;

        $this->empresaSocio['skEmpresaSocio'] = isset($_POST['skEmpresaSocio']) ? $_POST['skEmpresaSocio'] : NULL;
        $this->empresaSocio['skEmpresa'] = isset($_POST['skEmpresa']) ? $_POST['skEmpresa'] : NULL;
        $this->empresaSocio['sRFC'] = isset($_POST['sRFC']) ? $_POST['sRFC'] : NULL;
        $this->empresaSocio['sTelefono'] = (!empty($_POST['sTelefono']) ? $_POST['sTelefono'] : NULL);
        $this->empresaSocio['sCorreo'] = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : NULL;
        $this->empresaSocio['sNombre'] = isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL;
        $this->empresaSocio['sNombreCorto'] = isset($_POST['sNombreCorto']) ? $_POST['sNombreCorto'] : NULL;
        $this->empresaSocio['skEstatus'] = isset($_POST['skEstatus']) ? $_POST['skEstatus'] : NULL;
        $this->empresaSocio['skEmpresaTipo'] = isset($_POST['skEmpresaTipo']) ? $_POST['skEmpresaTipo'] : NULL;
        $this->empresaSocio['domicilios'] = isset($_POST['domicilios']) ? $_POST['domicilios'] : NULL;

        $skCaracteristicaEmpresaSocio = isset($_POST['skCaracteristicaEmpresaSocio']) ? $_POST['skCaracteristicaEmpresaSocio'] : NULL;
        
        $skEmpresaSocio = parent::stpCUD_empresaSocio();
        if(!$skEmpresaSocio){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
            return $this->data;
        }

        $this->empresaSocio['skEmpresaSocio'] = (!empty($skEmpresaSocio["skEmpresaSocio"]) ? $skEmpresaSocio["skEmpresaSocio"] : NULL);
        $this->data['skEmpresaSocio'] = isset($skEmpresaSocio["skEmpresaSocio"]) ? $skEmpresaSocio["skEmpresaSocio"] : NULL;

        $guardar_domicilios = $this->guardar_domicilios();
        if(!$guardar_domicilios['success']){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al guardar los domicilios, intenta de nuevo.';
            return $this->data;
        }
      
        if($skCaracteristicaEmpresaSocio){
            $this->empresaSocio['skEmpresaSocio'] = $this->empresaSocio['skEmpresaSocio'];
            // Eliminamos las características ANTERIORES //
            if(!parent::stpCD_caracteristica_empesaSocio(TRUE)){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro, inténta de nuevo.';
                return $this->data;
            }
            // Insertamos las características NUEVAS //
            foreach($skCaracteristicaEmpresaSocio AS $k=>&$v){
                $this->empresaSocio['skCaracteristicaEmpresaSocio'] = $k;
                $this->empresaSocio['sValor'] = $v;
                if(empty($v)){
                    continue;
                }
                if(!parent::stpCD_caracteristica_empesaSocio()){
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'Hubo un error al guardar el registro, intentá de nuevo.';
                    return $this->data;
                }
            }
        }
        return $this->data;
    }

    public function guardar_domicilios(){
        $this->data['success'] = TRUE;
        $this->empr['skEmpresaSocio'] = $this->empresaSocio['skEmpresaSocio'];

        $this->empr['axn'] = 'delete_empresasSocios_domicilios';
        $stp_empresasSocios_domicilios = parent::stp_empresasSocios_domicilios();
        if(!$stp_empresasSocios_domicilios || isset($stp_empresasSocios_domicilios['success']) && $stp_empresasSocios_domicilios['success'] != 1){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DOMICILIOS';
            return $this->data;
        }

        $this->empr['axn'] = 'guardar_empresasSocios_domicilios';
        if(isset($this->empresaSocio['domicilios']) && is_array($this->empresaSocio['domicilios'])){
            if(isset($this->empresaSocio['domicilios']['skTipoDomicilio']) && is_array($this->empresaSocio['domicilios']['skTipoDomicilio'])){
                for($i=0;$i<count($this->empresaSocio['domicilios']['skTipoDomicilio']);$i++){
                    $this->empr['skEmpresaSocioDomicilio'] = NULL;
                    $this->empr['skEmpresaSocio'] = $this->empresaSocio['skEmpresaSocio'];
                    $this->empr['skTipoDomicilio'] = $this->empresaSocio['domicilios']['skTipoDomicilio'][$i];
                    $this->empr['skEstatus'] = $this->empresaSocio['domicilios']['skEstatus'][$i];
                    $this->empr['skPais'] = $this->empresaSocio['domicilios']['skPais'][$i];
                    $this->empr['skEstado'] = $this->empresaSocio['domicilios']['skEstado'][$i];
                    $this->empr['skMunicipio'] = $this->empresaSocio['domicilios']['skMunicipio'][$i];
                    $this->empr['sColonia'] = $this->empresaSocio['domicilios']['sColonia'][$i];
                    $this->empr['sCalle'] = $this->empresaSocio['domicilios']['sCalle'][$i];
                    $this->empr['sCodigoPostal'] = $this->empresaSocio['domicilios']['sCodigoPostal'][$i];
                    $this->empr['sNumeroExterior'] = $this->empresaSocio['domicilios']['sNumeroExterior'][$i];
                    $this->empr['sNumeroInterior'] = $this->empresaSocio['domicilios']['sNumeroInterior'][$i];
                    $this->empr['sNombre'] = $this->empresaSocio['domicilios']['sNombre'][$i];

                    $stp_empresasSocios_domicilios = parent::stp_empresasSocios_domicilios();
                    if(!$stp_empresasSocios_domicilios || isset($stp_empresasSocios_domicilios['success']) && $stp_empresasSocios_domicilios['success'] != 1){
                        $this->data['success'] = FALSE;
                        $this->data['message'] = 'HUBO UN ERROR AL GUARDAR LOS DOMICILIOS';
                        return $this->data;
                    }
                }
            }
        }

        $this->data['success'] = TRUE;
        $this->data['message'] = 'DATOS DE DOMICILIOS GUARDADOS';
        return $this->data;
    }

    public function rel_caracteristica_empesaTipo(&$skEmpresaTipo){
        $result = parent::getCaracteristica_empesaTipo($skEmpresaTipo);
        if(!$result){
            return false;
        }
        $data = array();
        foreach( $result as $row){
            utf8($row);
            array_push($data,$row);
        }
        return $data;
    }

    public function caracteristicaCatalogo(&$sCatalogo){
        return parent::getCaracteristica_valoresCatalogo($sCatalogo);
    }

    public function getCaracteristicaCatalogo(&$sCatalogo, &$sCatalogoKey, &$sCatalogoNombre){
        $result = parent::getCaracteristica_valoresCatalogo($sCatalogo,$sCatalogoKey,$sCatalogoNombre);
        if(!$result){
            return array();
        }
        $data = array();
        foreach($result AS $row){
            utf8($row, FALSE);
            array_push($data, array(
                'id'=>$row[$sCatalogoKey],
                'nombre'=>$row[$sCatalogoNombre]
            ));
        }
        return $data;
    }

    public function get_tiposDomicilios(){
        $this->empr['sNombre'] = isset($_POST['val']) ? $_POST['val'] : NULL;
        return parent::_get_tiposDomicilios();
    }

    public function get_paises(){
        $this->empr['sNombre'] = isset($_POST['val']) ? $_POST['val'] : NULL;
        return parent::_get_paises();
    }

    public function get_estados(){
        $this->empr['sNombre'] = isset($_POST['val']) ? $_POST['val'] : NULL;
        return parent::_get_estados();
    }

}
