<?php

/**
 * Trait de autocompletes
 *
 * Este trait contendra todos las futuras funciones de autocompletado
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
trait AutoCompleteTrait
{

   

    /**
     * Autocomplete de perfiles
     *
     * Esta funcion invoca la funcion aut_perfiles del Conf_Model, el cual me retorna
     * un json con los datos de los perfiles.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $param Parametro para la busqueda de datos
     * @return string|false Retorna el json de datos o false en caso de error
     */
    public function aut_perfiles($param)
    {
        parent::load_class('conf', 'model', 'conf');
        $conf = new Conf_Model();
        return $conf->aut_perfiles($param);
    }

    /**
     * Autocomplete de Empresas
     *
     * Esta funcion invoca la funcion aut_empresas del Empr_Model, el cual me retorna
     * un json con los datos de las empresas.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $param Parametro para la busqueda de datos
     * @return string|false Retorna el json de datos o false en caso de error
     */
    public function aut_empresas($value)
    {
        parent::load_class('empr', 'model', 'empr');
        $empr = new Empr_Model();
        return $empr->aut_empresas($value);
    }

    public function aut_typeDocs($value)
    {
        parent::load_class('digi', 'model', 'digi');
        $digm = new Digi_Model();
        return $digm->aut_typeDocs($value);
    }

    public function aut_metadatos($value)
    {
        parent::load_class('digi', 'model', 'digi');
        $digm = new Digi_Model();
        return $digm->aut_typeDocs($value);
    }

    /**
     * Autocomplete de clientes
     *
     * Esta funcion invoca la funcion aut_perfiles del Conf_Model, el cual me retorna
     * un json con los datos de los perfiles.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param string $param Parametro para la busqueda de datos
     * @return string|false Retorna el json de datos o false en caso de error
     */
    public function aut_clientes($param)
    {
        parent::load_class('prev', 'model', 'prev');
        $conf = new Conf_Model();
        return $conf->aut_perfiles($param);
    }


    /**
     * Autocomplete de Referencias
     *
     * Esta funcion invoca la funcion aut_referenciasIntegradora del Prev_Model, el cual me retorna
     * un json con las Referencias de Integradora.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $param Parametro para la busqueda de datos
     * @return string|false Retorna el json de datos o false en caso de error
     */
    public function autReferenciasIntegradora($param)
    {
        parent::load_class('prev', 'model', 'prev');
        $prev = new Prev_Model();
        return $prev->aut_referencias_integradora($param);
    }

}
