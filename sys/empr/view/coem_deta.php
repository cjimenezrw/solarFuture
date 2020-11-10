<?php
    $result = $data['datos'][0];
?>


    <div class="row">

            <div class="col-md-12">
                <label class="col-md-3"><b>Empresa:</b> </label>
                <div class="col-md-9">
                    <label><?php echo (!empty($result['cliente'])) ? ($result['cliente']) : 'N/D'; ?></label>
                </div>
            </div>

            <div class="col-md-12">
                <label class="col-md-3"><b>RFC:</b> </label>
                <div class="col-md-3">
                    <label><?php echo (!empty($result['sRFC'])) ? ($result['sRFC']) : 'N/D'; ?></label>
                </div>
                <label class="col-md-3"><b>Tipo Empresa:</b> </label>
                <div class="col-md-3">
                    <label><?php echo (!empty($result['tipoEmpresa'])) ? ($result['tipoEmpresa']) : 'N/D'; ?></label>
                </div>
            </div>

    <?php
        if(!empty($data['datos'])){
    ?>

    <div class="col-md-12 col-xs-12">

        <hr>
        <h3>Correos Electrónicos
            <span>
                <small>(<?php echo !empty($data['datos']) ? count($data['datos']) : 0; ?>)</small>
            </span>
        </h3>

        <div class="input-group margin-top-20"> <span class="input-group-addon">Filtrar</span>
            <input id="filter" type="text" class="form-control" autocomplete="off" placeholder="Escribe aquí...">
        </div>

        <div class="table-responsive clearfix" style="height:400px;overflow-y:visible;font-size: 10pt;">
            <table class="table table-bordered" id="tableMercancias">
                <thead>
                    <th>#</th>
                    <th>Correo Electrónico</th>
                </thead>
                <tbody id="itemsCorreos" class="searchable">
        <?php
            if(!empty($data['datos'])){
                $i = 1;
                foreach($data['datos'] AS $k=>$v){
        ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $v['sCorreo']; ?></td>
                </tr>
        <?php
                $i++;
                }//ENDFOREACH
            }//ENDIF
        ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
        }//ENDIF
    ?>

    </div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

    });
</script>
