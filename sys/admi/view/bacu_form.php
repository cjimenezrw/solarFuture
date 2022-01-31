<?php
    if(isset($data['datos'])){
        $result = $data['datos'];
    }
?>
<div class="row">
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">
 


    <div class="col-md-12">
        <div class="panel panel-bordered panel-danger panel-line animated slideInLeft">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS GENERALES</h3>
            </div>
            <div class="panel-body container-fluid same-heigth">
                <div class="col-md-12 same-heigth">

                <div class="row row-lg">
                    <input id="skBancoCuenta" name="skBancoCuenta" type="hidden" class="form-control" autocomplete="off" placeholder="skBancoCuenta" value="<?php echo isset($result['skBancoCuenta']) ? $result['skBancoCuenta'] : '' ?>">

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> EMPRESA TITULAR:</h4>
                            <select name="skEmpresaSocioResponsable" id="skEmpresaSocioResponsable" class="form-control" data-plugin="select2" data-ajax--cache="true">
                            <?php
                            if (!empty($result['skEmpresaSocioResponsable'])) {
                                ?>
                                <option value="<?php echo $result['skEmpresaSocioResponsable']; ?>" selected="selected"><?php echo $result['empresaResponsable'] . ' (' . $result['empresaResponsableRFC'] . ')'; ?></option>
                                <?php
                            }//ENDIF
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> BANCO:</h4>
                            <select name="skBanco" id="skBanco" class="form-control" data-plugin="select2" select2Simple>
                                <option value="" disabled="" selected="selected">BANCO</option>
                                <?php
                                    if ($data['get_bancos']) {
                                        foreach ($data['get_bancos'] as $row) {
                                ?>
                                        <option <?php echo(isset($result['skBanco']) && $result['skBanco'] == $row['skBanco'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $row['skBanco']; ?>"><?php echo $row['sNombre']; ?> </option>
                                <?php
                                        }//ENDWHILE
                                    }//ENDIF
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> DIVISA:</h4>
                            <select name="skDivisa" id="skDivisa" class="form-control" data-plugin="select2" select2Simple>
                                <option value="" disabled="" selected="selected">DIVISA</option>
                                <?php
                                    if ($data['get_divisas']) {
                                        foreach ($data['get_divisas'] as $row) {
                                ?>
                                        <option <?php echo(isset($result['skDivisa']) && $result['skDivisa'] == $row['id'] ? 'selected="selected"' : '') ?>
                                            value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?> </option>
                                <?php
                                        }//ENDWHILE
                                    }//ENDIF
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 clearfix"></div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> TITULAR:</h4>
                            <input class="form-control" id="sTitular" name="sTitular" value="<?php echo (isset($result['sTitular'])) ? ($result['sTitular']) : ''; ?>" placeholder="TITULAR" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> CUENTA:</h4>
                            <input class="form-control" id="sNumeroCuenta" name="sNumeroCuenta" value="<?php echo (isset($result['sNumeroCuenta'])) ? ($result['sNumeroCuenta']) : ''; ?>" placeholder="CUENTA" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> CLABE INTERBANCARIA:</h4>
                            <input class="form-control" id="sClabeInterbancaria" name="sClabeInterbancaria" value="<?php echo (isset($result['sClabeInterbancaria'])) ? ($result['sClabeInterbancaria']) : ''; ?>" placeholder="CLABE" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 clearfix"></div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"><span style="color:red;">* </span> CUENTA CONTABLE:</h4>
                            <input class="form-control" id="sCuentaContable" name="sCuentaContable" value="<?php echo (isset($result['sCuentaContable'])) ? ($result['sCuentaContable']) : ''; ?>" placeholder="CUENTA CONTABLE" autocomplete="off" type="text">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <h4 class="example-title"> CUENTA CONTABLE COMPLEMENTARIA:</h4>
                            <input class="form-control" id="sCuentaContableComplementaria" name="sCuentaContableComplementaria" value="<?php echo (isset($result['sCuentaContableComplementaria'])) ? ($result['sCuentaContableComplementaria']) : ''; ?>" placeholder="CUENTA CONTABLE COMPLEMENTARIA" autocomplete="off" type="text">
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <h4 class="example-title">OBSERVACIONES:</h4>
                            <textarea class="form-control" rows="5" id="sObservaciones" name="sObservaciones" placeholder="OBSERVACIONES"><?php echo (isset($result['sObservaciones']) && !empty($result['sObservaciones'])) ? nl2br($result['sObservaciones']) : ''; ?></textarea>
                        </div>
                    </div>

                </div>

                </div>
            </div>
        </div>
    </div>

</form>
</div>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validations;

    $(document).ready(function () {

        $('#core-guardar').formValidation(core.formValidaciones);

        // Obtener Empresas //
            core.autocomplete2('#skEmpresaSocioResponsable', 'getEmpresas', window.location.href, 'EMPRESA TITULAR',{
                skEmpresaTipo : '["CLIE","AGEN","PROP"]'
            });

        $("#skBanco").select2({
            placeholder: "BANCO",
            allowClear: true
        });

        $("#skDivisa").select2({
            placeholder: "DIVISA",
            allowClear: true
        });

    });
</script>
