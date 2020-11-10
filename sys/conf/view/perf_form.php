<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>
<style>

    .indent{
        margin-left: 10px;
        margin-right: 10px;
    }
</style>

<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">

    <input type="hidden" name="skPerfil"  id="skPerfil" value="<?php echo (isset($result['skPerfil'])) ? $result['skPerfil'] : ''; ?>">
    <div class=" col-md-12">
        <label class="col-md-2 control-label"><b>Nombre</b> </label>
        <div class="form-group col-md-3">
            <input class="form-control" name="sNombre" value="<?php echo (isset($result['sNombre'])) ? ($result['sNombre']) : ''; ?>" placeholder="Nombre" autocomplete="off" type="text">
        </div>
        <label class="col-md-2 control-label"><b>Clonar De:</b> </label>
        <div class="form-group col-md-3">
            <select  name="skPerfilClonar" id="skPerfilClonar" class="form-control">
                <option value="">Seleccionar</option>
                <?php
                if ($data['Perfiles']) {
                    foreach (  $data['Perfiles'] as $row) {
                        utf8($row);
                        ?>
                        <option  value="<?php echo $row['skPerfil']; ?>"> <?php echo $row['sNombre']; ?> </option>
                        <?php
                    }
                }//ENDWHILE
                ?>
            </select>    </div>
    </div>
    <div class="col-md-12">
        <label class="col-sm-2 control-label"><b>Estatus</b> </label>
        <div class="form-group col-sm-3">
            <select  name="skEstatus" class="form-control">
                <option value="">Seleccionar</option>
                <?php
                if ($data['Estatus']) {
                    foreach ($data['Estatus'] as $row ) {
                        ?>
                        <option  <?php echo (isset($result['skEstatus']) && $result['skEstatus'] == $row['skEstatus'] ? 'selected="selected"' : '') ?> value="<?php echo $row['skEstatus']; ?>"> <?php echo $row['sNombre']; ?> </option>
                        <?php
                    }
                }//ENDWHILE
                ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="col-md-2 control-label"><b>Descripción:</b> </label>
        <div class="col-md-8">
            <textarea class="form-control" id="sDescripcionPerfil" name="sDescripcionPerfil"><?php echo (!empty($result['sDescripcionPerfil'])) ? ($result['sDescripcionPerfil']) : ''; ?></textarea>
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
        <div class="col-md-12">
            <center><h3>Sistema Web</h3></center>
        </div>
        <div class="col-md-2"> </div>

        <div class="col-md-8" style="overflow:auto; border: 1px solid #ddd; height:600px;">

            <ul class="mainUL"></ul>
        </div>

    </div>


    <div class="form-group col-md-12">
        <div class="col-md-12">
            <center><h3>Aplicaciones</h3></center>
        </div>
        <div class="col-md-2"></div>

        <div class="col-md-8" style="overflow:auto; border: 1px solid #ddd; height:600px;">

            <ul class="mainULMobile"></ul>
        </div>
    </div>



    <div class="form-group col-md-12">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <hr>
        </div>
    </div>

    <style>
        .mainUL > li{
            margin-bottom: 18px;
        }
        .wardItemDiv{
            float: right;
            margin-right: 20px;
        }
    </style>


    <div class="form-group col-md-12" >

        <div class="col-md-2"></div>

    </div>
</form>



<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">
    core.formValidaciones.fields = conf.usua_form.validaciones;

    function marcarPadre(hijo) {
        var bSeleccionado = false;
        id = hijo.id.replace(hijo.value + "_", "");
        padre = ("skModulo" + id);

        if (($("input[id=\"R_" + id + "\"]").is(':checked')) || ($("input[id=\"W_" + id + "\"]").is(':checked')) || ($("input[id=\"D_" + id + "\"]").is(':checked')) || ($("input[id=\"A_" + id + "\"]").is(':checked'))) {
            bSeleccionado = true;
        }
        document.getElementById(padre).checked = bSeleccionado;

    }
    function marcarHijos(padre) {
        var bSeleccionado = false;
        marcarPermisos(padre);
        id = padre.id.replace("skModulo", "");
        valor = document.getElementsByName("skModulo" + id)[0].value;
        var arr = document.forms['core-guardar'].elements;
        for (var i = 0; i < arr.length; i++) {
            var el = arr[i];
            if (el.type == 'checkbox') {
                if (el.value.match(valor + ".")) {
                    if (!el.disabled) {
                        el.checked = padre.checked;
                        marcarPermisos(el);
                    }
                }
            }
        }
    }
    function marcarPermisos(padre)
    {

        id = padre.id.replace("skModulo", "");
        if (id != '') {
            if (($("input[id=\"R_" + id + "\"]").is(':disabled') == false)) {
                document.getElementById("R_" + id).checked = padre.checked;
            }
            if (($("input[id=\"W_" + id + "\"]").is(':disabled') == false)) {
                document.getElementById("W_" + id).checked = padre.checked;
            }
            if (($("input[id=\"D_" + id + "\"]").is(':disabled') == false)) {
                document.getElementById("D_" + id).checked = padre.checked;
            }
            if (($("input[id=\"A_" + id + "\"]").is(':disabled') == false)) {
                document.getElementById("A_" + id).checked = padre.checked;
            }
        }
        //		 document.getElementById(padre).checked = true;
    }

    $(document).ready(function () {
        FormValidation.Validator.securePassword = conf.usua_form.securePassword;
        $('#core-guardar').formValidation(core.formValidaciones);
        var web = new conf.perf_tree( <?php echo $data['modulos_json'] ?>, $('.mainUL'), 'web_pstore', 'web');
        web.run();
        dataset = <?php echo $data['modulos_json'] ?>;

        var mob = new conf.perf_tree(<?php echo $data['modulosMobile_json'] ?>, $('.mainULMobile'), 'mob_pstore','mob');
        mob.run();

    });

</script>
