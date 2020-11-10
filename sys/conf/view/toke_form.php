<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>

<div class="row">
    <form class="form-horizontal" id="core-guardar" method="post" enctype="multipart/form-data">

        <div class="col-md-12">
            <?php
                if(isset($data['usuarios_token'][0]['sNombre'])){
            ?>
            <p>
                <b>Usuario: </b>
                <?php echo $data['usuarios_token'][0]['sNombre'].' '.$data['usuarios_token'][0]['sApellidoPaterno'].' '.$data['usuarios_token'][0]['sApellidoMaterno']; ?>
            </p>

            <p>
                <b>Correo: </b>
                <?php echo $data['usuarios_token'][0]['sCorreo']; ?>
            </p>

            <h5>Token de servicios web</h5>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th></th>
                        <th>Token</th>
                        <th>Perfil</th>
                        <th>Empresa</th>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($data['usuarios_token']) && ($data['usuarios_token'])){
                                foreach($data['usuarios_token'] AS $k=>$v){
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="skUsuarioPerfil[]" value="<?php echo $v['skUsuarioPerfil']; ?>">
                            </td>
                            <td><?php echo !empty($v['skToken']) ? $v['skToken'] : '-'; ?></td>
                            <td><?php echo $v['perfil']; ?></td>
                            <td><?php echo $v['empresa']; ?></td>
                        </tr>
                        <?php
                                }//ENDFOREACH
                            }//ENDIF
                        ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
                }else{
            ?>
                <h3 class="text-center">Es necesario tener por los men&oacute;s un perfil asignado.</h3>
            <?php }//ENDIF ?>
        </div>

    </form>
</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>

<script type="text/javascript">

    core.formValidaciones.fields = conf.toke_form.validaciones;

    $(document).ready(function () {

        // VALIDACIONES DEL FORMULARIO
        $('#core-guardar').formValidation(core.formValidaciones);

    });

</script>
