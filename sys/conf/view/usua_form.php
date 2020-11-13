<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<div class="row">
    <form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">
        <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                <li class="active" role="presentation"><a data-toggle="tab" href="#general" aria-controls="general"
                                                          role="tab">General</a></li>
                <li role="presentation"><a data-toggle="tab" href="#perfiles"
                                           aria-controls="perfiles"
                                           role="tab">Perfiles</a></li>
                <li role="presentation"><a data-toggle="tab" href="#picture" aria-controls="picture"
                                           role="tab">Avatar</a>
                </li>
                <li role="presentation">
                    <a data-toggle="tab" href="#caracteristicas" aria-controls="caracteristicas" role="tab">Caracter&iacute;sticas</a>
                </li>
            </ul>
            <div class="tab-content">


                <div class="tab-pane active animation-slide-left" id="general" role="tabpanel">

                    <div class="row margin-20">

                        <input type="hidden" name="skUsuario" id="skUsuario"
                               value="<?php echo (isset($result['skUsuario'])) ? $result['skUsuario'] : ''; ?>">

                        <div class=" col-md-12">
                            <label class="col-md-2 control-label"><b>Nombre Usuario</b> </label>

                            <div class="form-group col-md-3">
                                <div class="input-group input-group-icon">
                                <span class="input-group-addon">
                                    <span class="icon wb-user" aria-hidden="true"></span>
                                </span>
                                    <input class="form-control" maxlength="30"
                                           <?php if (isset($result['skUsuario'])) { ?>disabled="disabled"<?php }//ENDIF  ?>
                                           name="sUsuario"
                                           value="<?php echo (isset($result['sUsuario'])) ? ($result['sUsuario']) : ''; ?>"
                                           placeholder="Nombre Usuario" autocomplete="off" type="text">
                                </div>
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
                            <label class="col-sm-2 control-label"><b>Estatus</b> </label>

                            <div class="form-group col-sm-3">

                                <select name="skEstatus" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php
                                    if ($data['Estatus']) {
                                        foreach ($data['Estatus'] as $row ) {
                                            ?>
                                            <option <?php echo(isset($result['skEstatus']) && $result['skEstatus'] == $row['skEstatus'] ? 'selected="selected"' : '') ?>
                                                value="<?php echo $row['skEstatus']; ?>"> <?php echo $row['sNombre']; ?> </option>
                                            <?php
                                        }
                                    }//ENDWHILE
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b>Nombres</b> </label>

                            <div class="form-group col-md-3">
                                <input class="form-control" name="sNombre"
                                       value="<?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?>"
                                       placeholder="Nombre" autocomplete="off" type="text">
                            </div>
                            <label class="col-md-2 control-label"><b>Correo Electronico</b> </label>

                            <div class="form-group col-md-3">
                                <div class="input-group input-group-icon">
                                <span class="input-group-addon">
                                    <span class="icon wb-envelope" aria-hidden="true"></span>
                                </span>
                                    <input class="form-control" name="sCorreo"
                                           value="<?php echo (isset($result['sCorreo'])) ? $result['sCorreo'] : ''; ?>"
                                           placeholder="Correo Electronico" autocomplete="off" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-2 control-label"><b>Apellido Paterno</b> </label>

                            <div class="form-group col-md-3">
                                <input class="form-control" name="sApellidoPaterno"
                                       value="<?php echo (isset($result['sApellidoPaterno'])) ? $result['sApellidoPaterno'] : ''; ?>"
                                       placeholder="Apellido Paterno" autocomplete="off" type="text">
                            </div>
                            <label class="col-md-2 control-label"><b>Apellido Materno</b> </label>

                            <div class="form-group col-md-3">
                                <input class="form-control" name="sApellidoMaterno"
                                       value="<?php echo (isset($result['sApellidoMaterno'])) ? $result['sApellidoMaterno'] : ''; ?>"
                                       placeholder="Apellido Materno" autocomplete="off" type="text">
                            </div>


                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <hr>
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
                            <label class="col-md-2 control-label"><b>Contrase&ntilde;a</b> </label>

                            <div class="form-group col-md-3">
                                <input class="form-control input-sm" name="sPassword"
                                       value="<?php echo (isset($result['sPassword'])) ? $result['sPassword'] : ''; ?>"
                                       placeholder="Contrase&ntilde;a" type="password"
                                       data-fv-identical="true" data-fv-identical-field="sPasswordConfirmar"
                                       data-fv-identical-message="Las contrase&ntilde;as no son iguales">
                            </div>
                            <label class="col-md-2 control-label"><b>Confirmar Contrase&ntilde;a</b> </label>

                            <div class=" form-group col-md-3">
                                <input class="form-control input-sm" name="sPasswordConfirmar"
                                       value="<?php echo (isset($result['sPassword'])) ? $result['sPassword'] : ''; ?>"
                                       placeholder="Contrase&ntilde;a" type="password"
                                       data-fv-identical="true" data-fv-identical-field="sPassword"
                                       data-fv-identical-message="Las contrase&ntilde;as no son iguales">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane animation-slide-left" id="perfiles" role="tabpanel">

                    <div class="row margin-20" id="profileBoil">
                        <?php if($_SESSION['usuario']['tipoUsuario'] == 'A'){ ?>
                        <div class="form-group col-md-12">
                            <label class="col-md-2 control-label"><b>Administrador</b></label>

                            <div class="col-md-3">
                                <div class="checkbox-custom checkbox-primary">
                                    <input id="sTipoUsuario" value="A"
                                           name="sTipoUsuario" <?php echo (isset($result['sTipoUsuario']) && !empty($result['sTipoUsuario']) ) ? 'checked' : ''; ?>
                                           type="checkbox">
                                    <label for="sTipoUsuario"></label>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-20 col-md-12">
                            <hr>
                        </div>
                      <?php } ?>

                        <div class="col-md-12">
                            <label class="col-md-2"><h4> Perfiles</h4></label>
                        </div>

                        <div class="well tableMultiple1-panelEdit col-md-12">
                            <p class="tableMultiple1-editAndo text-center"></p>

                            <div class="col-md-4">
                                <label class="control-label"><b> Empresa</b></label>
                                <select id="skEmpresaSocio" select2 data-plugin="select2" data-ajax--cache="true"></select>
                            </div>

                            <div class="col-md-4">
                                <label class="control-label"><b> Perf&iacute;l</b></label>
                                <select id="skPerfil" data-plugin="select2" select2 data-ajax--cache="true"></select>
                            </div>


                            <div class="col-md-12">
                                <button id="tableMultiple1-addRow" onclick="tableMultiple1_addNewRow();" class="btn btn-primary"><i
                                        class="fa fa-plus"
                                        aria-hidden="true"></i> Agregar
                                </button>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="example">
                                <div id="toolbar">
                                    <button id="tableMultiple1-removeRowTableMultiple"
                                            class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                                        <i class="fa fa-trash"></i> Borrar
                                    </button>
                                </div>
                                <table id="tableMultiple1" data-toggle="table" data-toolbar="#toolbar"
                                       data-query-params="queryParams" data-mobile-responsive="true"
                                       data-height="400" data-pagination="false" data-icon-size="outline"
                                       data-search="true" data-unique-id="id">
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="tab-pane animation-slide-left" id="picture" role="tabpanel">

                    <div class="row margin-20">
                        <div class="col-md-12">
                            <div class="example-wrap">
                                <h4 class="example-title">Imagen Personal</h4>

                                <div class="example">
                                    <input class="dropify" type="file" name="avatar" id="input-file-max-fs"
                                           data-plugin="dropify"
                                           data-allowed-file-extensions="pdf png jpg" data-height="325"
                                        <?php
                                        if (isset($result['sFoto'])) {
                                            if ($result['sFoto'] != '') {
                                                echo 'data-default-file="' . ASSETS_PATH.'profiles/'. $result['sFoto'] . '"';
                                            }
                                        } else {
                                        }

                                        ?> />

                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="text" value="false" id="picDel" name="picDel" hidden>
                    <input type="text" value="<?php echo (isset($result['sFoto'])) ? ($result['sFoto']) : '';?>"
                           name="pictureName"
                           hidden>
                    <input type="text" value="<?php echo (isset($result['sUsuario'])) ? ($result['sUsuario']) : ''; ?>"
                           name="sUsuarioViejo" hidden>

                </div>


                <!-- CARACTERÍSTICAS DE USUARIOS !-->

                <div class="tab-pane animation-slide-left" id="caracteristicas" role="tabpanel">
                    <div class="row margin-20">
                        <div class="col-md-12" id="rel_caracteristica_empesaTipo">
                            <?php

                                    $getCaracteristicas_usuarios = $this->getCaracteristicas_usuarios();
                                    $valCaracteristicas = array();
                                    if(isset($result['skUsuario'])){
                                        $getCaracteristicas_skUsuario = $this->getCaracteristicas_skUsuario($result['skUsuario']);
                                        foreach(  $getCaracteristicas_skUsuario as $rec){
                                            utf8($rec);
                                            array_push($valCaracteristicas,$rec);
                                        }
                                    }
                                    $key_autocomplete2 = array();
                                    foreach (   $getCaracteristicas_usuarios as $row){
                                        utf8($row);
                                        // OBTENEMOS EL VALOR GUARDADO DE LA CARACTERÍSTICA //
                                        $val_caracteristica = '';
                                        if(isset($result['skUsuario'])){
                                            foreach($valCaracteristicas AS $key=>&$valor){
                                                if($valor['skCaracteristicaUsuario'] == $row['skCaracteristicaUsuario']){
                                                    $val_caracteristica = $valor['sValor'];
                                                }
                                            }
                                        }else{
                                            $val_caracteristica = $row['sValorDefault'];
                                        }
                                        switch ($row['skCaracteristicaTipo']){
                                            case 'LI':
                                            ?>
                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label"><b><?php echo $row['sNombre']; ?>:</b> </label>
                                                    <div class="form-group col-md-3">
                                                        <input class="form-control" maxlength="500" id="<?php echo $row['skCaracteristicaUsuario']; ?>" name="skCaracteristicaUsuario[<?php echo $row['skCaracteristicaUsuario']; ?>]" value="<?php echo $val_caracteristica; ?>" placeholder="<?php echo $row['sNombre']; ?>" autocomplete="off" type="text">
                                                    </div>
                                                </div>
                                            <?php
                                                break;
                                            case 'OP':
                                            ?>
                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label"><b><?php echo $row['sNombre']; ?>:</b> </label>
                                                    <div class="form-group col-md-3">
                                                        <select id="<?php echo $row['skCaracteristicaUsuario']; ?>" name="skCaracteristicaUsuario[<?php echo $row['skCaracteristicaUsuario']; ?>]" data-plugin="select2" data-ajax--cache="true">
                                                            <option value="">Seleccionar</option>
                                                            <?php
                                                            $op = $this->getCaracteristica_valoresCatalogo($row['sCatalogo'],$row['sCatalogoKey'],$row['sCatalogoNombre']);
                                                            if($op){
                                                                array_push($key_autocomplete2, array(
                                                                    'skCaracteristicaUsuario'=>$row['skCaracteristicaUsuario'],
                                                                    'sNombre'=>$row['sNombre'],
                                                                    'sCatalogo'=>$row['sCatalogo'],
                                                                    'sCatalogoKey'=>$row['sCatalogoKey'],
                                                                    'sCatalogoNombre'=>$row['sCatalogoNombre']
                                                                ));
                                                                foreach ($op as $val){
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
                                                            <input id="<?php echo $row['skCaracteristicaUsuario']; ?>" value="1"
                                                                   name="skCaracteristicaUsuario[<?php echo $row['skCaracteristicaUsuario']; ?>]"
                                                                   <?php echo (!empty($val_caracteristica)) ? 'checked' : ''; ?>
                                                                   type="checkbox">
                                                            <label for="<?php echo $row['skCaracteristicaUsuario']; ?>"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                break;
                                        }
                                    }//ENDWHILE
                                //}//ENDIF
                            ?>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </form>
    <table id="table"></table>
</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    core.formValidaciones.fields = conf.usua_form.validaciones;

    function tableMultiple1_addNewRow(index) {

        var skE = $("#skEmpresaSocio");
        var skP = $("#skPerfil");
        var skU = $("#skUsuarioPerfil");

        if (skE.val() == null || skP.val() == null) {
            toastr.warning("Por favor complete los campos.");
            return;
        }

        var params = {
            "empresa": {"id": "skEmpresaSocio", "type": "selected"},
            "perfil": {"id": "skPerfil", "type": "selected"}
        };

        core.tableMultipleAddRow($('#tableMultiple1'), params, 'skUsuarioPerfil', index);
    }

    var params = {
        datos: {
            columns: [{
                field: 'state',
                checkbox: true,
                align: 'center',
                valign: 'middle'
            }, {
                field: 'empresa',
                title: 'Empresa'
            }, {
                field: 'perfil',
                title: 'Perfil'
            }, {
                field: 'id',
                title: 'ID'
            }],
            data: <?php echo (isset($data['usuario_perfiles'])) ? ($data['usuario_perfiles']) : json_encode([]); ?>
        }
    };

    $(document).ready(function () {

        core.tableMultiple($("#tableMultiple1"), params);

        // VALIDACIONES DEL FORMULARIO
        FormValidation.Validator.securePassword = conf.usua_form.securePassword;
        $('#core-guardar').formValidation(core.formValidaciones);

        // AUTOCOMPLETE (Empresas)
        core.autocomplete2('#skEmpresaSocio', 'aut_empresas', window.location.href, 'Buscar Empresa');

        // AUTOCOMPLETE (Perfiles)
        core.autocomplete2('#skPerfil', 'aut_perfiles', window.location.href, 'Buscar Perfil');



        // CARGA DE IMAGEN DE USUARIO
        var drEvent = $('.dropify').dropify();

        drEvent.on('dropify.beforeClear', function (event, element) {
            return confirm("Desea eliminar su imagen de perfil?");
        });

        drEvent.on('dropify.afterClear', function (event, element) {
            $('#picDel').val('true');
        });

        // AutoComplete2 Características EmpresasSocios //
        <?php
        if(isset($key_autocomplete2) && $key_autocomplete2){
            foreach($key_autocomplete2 AS $k=>&$v){
        ?>
            core.autocomplete2('#<?php echo $v['skCaracteristicaUsuario']; ?>', 'getCaracteristicaCatalogo' , window.location.href + '?sCatalogo=<?php echo $v['sCatalogo'];?>&sCatalogoKey=<?php echo $v['sCatalogoKey'];?>&sCatalogoNombre=<?php echo $v['sCatalogoNombre'];?>', '<?php echo $v['sNombre']; ?>');
        <?php
            }//ENDFOREACH
        }//ENDIF
        ?>

        core.formChage();

    });

</script>
