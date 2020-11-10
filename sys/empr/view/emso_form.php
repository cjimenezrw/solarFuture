<?php
if (isset($data['datos'])) {
    $result = $data['datos'];
    $result2 = $data['datos2'];
    utf8($result);
    utf8($result2);

}
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
    <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
        <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
            <li class="active" role="presentation">
                <a data-toggle="tab" href="#general" aria-controls="general" role="tab">General</a>
            </li>
            <li role="presentation">
                <a data-toggle="tab" href="#caracteristicas" aria-controls="caracteristicas" role="tab">Caracter&iacute;sticas</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active animation-slide-left" id="general" role="tabpanel">

                <div class="row margin-20">
                  <input type="hidden" name="skEmpresaSocio"  id="skEmpresaSocio" value="<?php echo (isset($result['skEmpresaSocio'])) ? $result['skEmpresaSocio'] : ''; ?>">
                    <input type="hidden" name="skDatosEmpreasSocios"  id="skDatosEmpreasSocios" value="<?php echo (isset($result['skDatosEmpreasSocios'])) ? $result['skDatosEmpreasSocios'] : ''; ?>">
                    <input type="hidden" name="skEmpresa"  id="skEmpresa" value="<?php echo (isset($result['skEmpresa'])) ? $result['skEmpresa'] : ''; ?>">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>RFC:</b> </label>
                        <div class="col-md-3">
                            <input class="form-control" maxlength="13" <?php if (isset($result['sRFC'])) { ?>disabled="disabled"<?php }//ENDIF  ?>  name="sRFC" value="<?php echo (isset($result['sRFC'])) ? utf8_encode($result['sRFC']) : ''; ?>" placeholder="RFC" autocomplete="off" type="text" onblur="empr.emso_form.getEmpresaSocio(this);">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <hr>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="col-sm-2 control-label"><b>Estatus:</b> </label>
                        <div class="form-group col-sm-3">
                            <select id="skEstatus" name="skEstatus" class="form-control">
                                <option value="">Seleccionar</option>
                                <?php
                                if ($data['estatus']) {
                                    foreach (  $data['estatus'] as $row) {
                                        utf8($row);
                                        ?>
                                        <option <?php echo(isset($result['skEstatus']) && $result['skEstatus'] == $row['skEstatus'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $row['skEstatus']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                        <?php
                                        }//ENDWHILE
                                    }//ENDIF
                                    ?>
                            </select>

                        </div>
                        <label class="col-sm-2 control-label"><b>Tipo Empresa:</b> </label>
                        <div class="form-group col-sm-3">
                            <select id="skEmpresaTipo" name="skEmpresaTipo" class="form-control" onchange="empr.emso_form.change_skEmpresaTipo(this);empr.emso_form.revalidarFormulario();">
                                <option value="">Seleccionar</option>
                                <?php
                                if ($data['empresasTipos']) {
                                    foreach (  $data['empresasTipos'] as $row) {
                                        utf8($row);
                                        ?>
                                        <option <?php echo(isset($result['skEmpresaTipo']) && $result['skEmpresaTipo'] == $row['skEmpresaTipo'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $row['skEmpresaTipo']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                    }//ENDWHILE
                                }//ENDIF
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b>Nombre:</b> </label>
                        <div class="form-group col-md-3">
                            <input class="form-control" id="sNombre" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="Nombre" autocomplete="off" type="text">
                        </div>
                        <label class="col-md-2 control-label"><b>Nombre Corto:</b> </label>
                        <div class="form-group col-md-3">
                            <input class="form-control" id="sNombreCorto" name="sNombreCorto" value="<?php echo (isset($result['sNombreCorto'])) ? ($result['sNombreCorto']) : ''; ?>"  placeholder="Nombre Corto" autocomplete="off" type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="col-sm-2 control-label"><b>Corresponsalia:</b> </label>
                        <div class="form-group col-sm-3">
                            <select id="skEmpresaSocioCorresponsal" name="skEmpresaSocioCorresponsal" class="form-control">
                                <option value="">Seleccionar</option>
                                <?php
                                if ($data['corresponsales']) {
                                    foreach (  $data['corresponsales'] as $row) {
                                        utf8($row);
                                        ?>
                                        <option <?php echo(isset($result2['skEmpresaSocioCorresponsal']) && $result2['skEmpresaSocioCorresponsal'] == $row['skEmpresaSocio'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $row['skEmpresaSocio']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                        <?php
                                        }//ENDWHILE
                                    }//ENDIF
                                    ?>
                            </select>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <label class="col-sm-2 control-label"><b>Promotor 1:</b> </label>
                        <div class="form-group col-sm-3">
                            <select id="skEmpresaSocioPromotor1" name="skEmpresaSocioPromotor1" class="form-control">
                                <option value="">Seleccionar</option>
                                <?php
                                if ($data['promotores']) {
                                    foreach (  $data['promotores'] as $row) {
                                        utf8($row);
                                        ?>
                                        <option <?php echo(isset($result2['skEmpresaSocioPromotor1']) && $result2['skEmpresaSocioPromotor1'] == $row['skEmpresaSocio'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $row['skEmpresaSocio']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                        <?php
                                        }//ENDWHILE
                                    }//ENDIF
                                    ?>
                            </select>

                        </div>
                        <label class="col-sm-2 control-label"><b>Promotor 2:</b> </label>
                        <div class="form-group col-sm-3">
                            <select id="skEmpresaSocioPromotor2" name="skEmpresaSocioPromotor2" class="form-control"  >
                                <option value="">Seleccionar</option>
                                <?php
                                if ($data['promotores']) {
                                    foreach (  $data['promotores'] as $row) {
                                        utf8($row);
                                        ?>
                                        <option <?php echo(isset($result2['skEmpresaSocioPromotor2']) && $result2['skEmpresaSocioPromotor2'] == $row['skEmpresaSocio'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $row['skEmpresaSocio']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                    <?php
                                    }//ENDWHILE
                                }//ENDIF
                                ?>
                            </select>

                        </div>
                    </div>






                    <div class="col-md-12">
                        <label class="col-md-2 control-label"><b>Observaciones: </b> </label>
                        <div class="form-group col-md-8">
                            <textarea class="form-control input-sm max-width-100" name="sObservaciones" rows="4" cols="50" placeholder="Añada sus observaciones"><?php echo (isset($result2['sObservaciones'])) ? ($result2['sObservaciones']) : ''; ?></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CARACTERÍSTICAS DE EMPRESAS SOCIOS !-->

            <div class="tab-pane animation-slide-left" id="caracteristicas" role="tabpanel">
                <div class="row margin-20">
                    <div class="col-md-12" id="rel_caracteristica_empesaTipo">
                        <?php
                            if(isset($result['skEmpresaTipo'])){
                                $rel_caracteristica_empesaTipo = $this->getCaracteristica_empesaTipo($result['skEmpresaTipo']);
                                $caracteristica_skEmpresaSocio = $this->getCaracteristica_skEmpresaSocio($result['skEmpresaSocio']);
                                $valCaracteristicas = array();
                                foreach($caracteristica_skEmpresaSocio as $rec ){
                                    utf8($rec);
                                    array_push($valCaracteristicas,$rec);
                                }
                                $key_autocomplete2 = array();
                                foreach($rel_caracteristica_empesaTipo as $row){
                                    utf8($row);
                                    // OBTENEMOS EL VALOR GUARDADO DE LA CARACTERÍSTICA //
                                    $val_caracteristica = '';
                                    foreach($valCaracteristicas AS $key=>&$valor){
                                        if($valor['skCaracteristicaEmpresaSocio'] == $row['skCaracteristicaEmpresaSocio']){
                                            $val_caracteristica = $valor['sValor'];
                                        }
                                    }
                                    switch ($row['skCaracteristicaTipo']){
                                        case 'LI':
                                        ?>
                                            <div class="col-md-12">
                                                <label class="col-md-2 control-label"><b><?php echo $row['sNombre']; ?>:</b> </label>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" maxlength="500" id="<?php echo $row['skCaracteristicaEmpresaSocio']; ?>" name="skCaracteristicaEmpresaSocio[<?php echo $row['skCaracteristicaEmpresaSocio']; ?>]" value="<?php echo $val_caracteristica; ?>" placeholder="<?php echo $row['sNombre']; ?>" autocomplete="off" type="text">
                                                </div>
                                            </div>
                                        <?php
                                            break;
                                        case 'OP':
                                        ?>
                                            <div class="col-md-12">
                                                <label class="col-md-2 control-label"><b><?php echo $row['sNombre']; ?>:</b> </label>
                                                <div class="form-group col-md-3">
                                                    <select id="<?php echo $row['skCaracteristicaEmpresaSocio']; ?>" name="skCaracteristicaEmpresaSocio[<?php echo $row['skCaracteristicaEmpresaSocio']; ?>]" data-plugin="select2" data-ajax--cache="true">
                                                        <option value="">Seleccionar</option>
                                                        <?php
                                                        $op = $this->getCaracteristica_valoresCatalogo($row['sCatalogo'],$row['sCatalogoKey'],$row['sCatalogoNombre']);
                                                        if($op){
                                                            array_push($key_autocomplete2, array(
                                                                'skCaracteristicaEmpresaSocio'=>$row['skCaracteristicaEmpresaSocio'],
                                                                'sNombre'=>$row['sNombre'],
                                                                'sCatalogo'=>$row['sCatalogo'],
                                                                'sCatalogoKey'=>$row['sCatalogoKey'],
                                                                'sCatalogoNombre'=>$row['sCatalogoNombre']
                                                            ));
                                                            foreach($op as $val){
                                                                utf8($val);
                                                        ?>
                                                            <option <?php echo(($val_caracteristica == $val[$row['sCatalogoKey']]) ? 'selected="selected"' : '') ?>
                                                                value="<?php echo $val[$row['sCatalogoKey']]; ?>"><?php echo $val[$row['sCatalogoNombre']]; ?></option>
                                                        <?php
                                                            }//ENDWHILE
                                                        }//ENDIF
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php
                                            break;
                                        case 'DE':
                                        ?>
                                            <div class="form-group col-md-12">
                                                <label class="col-md-2 control-label"><b><?php echo $row['sNombre']; ?>:</b> </label>
                                                <div class="col-md-3">
                                                    <div class="checkbox-custom checkbox-primary">
                                                        <input id="<?php echo $row['skCaracteristicaEmpresaSocio']; ?>" value="1"
                                                               name="skCaracteristicaEmpresaSocio[<?php echo $row['skCaracteristicaEmpresaSocio']; ?>]"
                                                               <?php echo (!empty($val_caracteristica)) ? 'checked' : ''; ?>
                                                               type="checkbox">
                                                        <label for="<?php echo $row['skCaracteristicaEmpresaSocio']; ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            break;
                                    }
                                }//ENDWHILE
                            }//ENDIF
                        ?>
                    </div>
                </div>
            </div>




        </div>
    </div>
</form>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    core.formValidaciones.fields = empr.emso_form.validaciones;

    $(document).ready(function () {

        $('#core-guardar').formValidation(core.formValidaciones);

        // AutoComplete2 Características EmpresasSocios //
        <?php
        if(isset($key_autocomplete2) && $key_autocomplete2){
            foreach($key_autocomplete2 AS $k=>&$v){
        ?>
        core.autocomplete2('#<?php echo $v['skCaracteristicaEmpresaSocio']; ?>', 'getCaracteristicaCatalogo', window.location.href + '?sCatalogo=<?php echo $v['sCatalogo'];?>&sCatalogoKey=<?php echo $v['sCatalogoKey'];?>&sCatalogoNombre=<?php echo $v['sCatalogoNombre'];?>', '<?php echo $v['sNombre']; ?>');
        <?php
            }//ENDFOREACH
        }//ENDIF
        ?>
        $("#skPais").select2();

    });

    function guardarEmpresas(obj){
        if (core.SYS_URL + "sys/come/docu-inde/documentos-empresas/" == core.lastUrl) {
            obj.url = '/sys/come/docu-inde/documentos-empresas/';
        }
        core.guardar(obj);
    }

    function consultarEmpresas(obj){
        if (core.SYS_URL + "sys/come/docu-inde/documentos-empresas/" == core.lastUrl) {
            obj.url = '/sys/come/docu-inde/documentos-empresas/';
        }
        core.menuLoadModule(obj);
    }
</script>
