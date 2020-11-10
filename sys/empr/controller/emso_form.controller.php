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
        $sRFC = isset($_POST['sRFC']) ?  ( ($_POST['sRFC'] === 'XAXX010101000') ?  NULL : $_POST['sRFC'] )    : NULL;
        $skEmpresaTipo = isset($_POST['skEmpresaTipo']) ? $_POST['skEmpresaTipo'] : NULL;
        $data = parent::validar_empresaSocio($sRFC,$skEmpresaTipo);
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
        $this->data['corresponsales'] = parent::getCorresponsales();
        $this->data['promotores'] = parent::getPromotores();
        $this->data['catPaises'] = parent::getPaises();
        if (isset($_GET['p1'])) {
            $this->data['datos'] = parent::consultar_empresaSocio($_GET['p1']);
            $this->data['datos2'] = parent::getEmpresasSociosDatos($_GET['p1']);
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
        $this->empresaSocio['sNombre'] = isset($_POST['sNombre']) ? $_POST['sNombre'] : NULL;
        $this->empresaSocio['sNombreCorto'] = isset($_POST['sNombreCorto']) ? $_POST['sNombreCorto'] : NULL;
        $this->empresaSocio['skEstatus'] = isset($_POST['skEstatus']) ? $_POST['skEstatus'] : NULL;
        $this->empresaSocio['skEmpresaTipo'] = isset($_POST['skEmpresaTipo']) ? $_POST['skEmpresaTipo'] : NULL;
        $skCaracteristicaEmpresaSocio = isset($_POST['skCaracteristicaEmpresaSocio']) ? $_POST['skCaracteristicaEmpresaSocio'] : NULL;

        $this->empresaSocio['skDatosEmpreasSocios'] = isset($_POST['skDatosEmpreasSocios']) ? $_POST['skDatosEmpreasSocios'] : NULL;
        $this->empresaSocio['skEmpresaSocioCorresponsal'] = isset($_POST['skEmpresaSocioCorresponsal']) ? $_POST['skEmpresaSocioCorresponsal'] : NULL;
        $this->empresaSocio['skEmpresaSocioPromotor1'] = isset($_POST['skEmpresaSocioPromotor1']) ? $_POST['skEmpresaSocioPromotor1'] : NULL;
        $this->empresaSocio['skEmpresaSocioPromotor2'] = isset($_POST['skEmpresaSocioPromotor2']) ? $_POST['skEmpresaSocioPromotor2'] : NULL;
        $this->empresaSocio['sObservaciones'] = isset($_POST['sObservaciones']) ? $_POST['sObservaciones'] : NULL;

        $skEmpresaSocio = parent::stpCUD_empresaSocio();
        if(!$skEmpresaSocio){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
        }

        $this->empresaSocio['skEmpresaSocio'] = isset($skEmpresaSocio["skEmpresaSocio"]) ? $skEmpresaSocio["skEmpresaSocio"] : NULL;
        $skEmpresaSocioDatos = parent::stpCUD_empresasSociosDatos();
        if(!$skEmpresaSocioDatos){
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al guardar el registro, intenta de nuevo.';
        }


        if($skCaracteristicaEmpresaSocio){
            $this->empresaSocio['skEmpresaSocio'] = $skEmpresaSocio['skEmpresaSocio'];
            // Eliminamos las características ANTERIORES //
            if(!parent::stpCD_caracteristica_empesaSocio(TRUE)){
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error al guardar el registro, inténta de nuevo.';
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
                    break;
                }
            }
        }
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

}
