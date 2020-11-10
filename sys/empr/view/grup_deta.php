<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
    utf8($result);
}
?>



<style>
    .detail{
        width: 25%;
        border: none;
    }
    th {

    }

</style>
<div class="container">


    <div class="row">



        <table class=" table-condensed"style="width:100%;" >

            <tbody>
                <tr>
                    <th class="detail"><b>Estatus</b></th>
                    <td class="detail" ><?php echo (isset($result['skEstatus'])) ? $result['skEstatus'] : ''; ?></td>

                    <th class="detail"><b>Fecha de Creación</b></th>
                    <td class="detail"><?php echo ($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : '') ?></td>
                </tr>
                <tr>

                    <th class="detail"><b>Nombre</b></th>
                    <td class="detail"><?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?></td>
                </tr>
            </tbody>

        </table>
        <div class="col-md-12 col-xs-12 clearfix"><hr></div>
        <div class="col-md-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Empresas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($data['grupo_empresas']){
                                $data['grupo_empresas'] = json_decode($data['grupo_empresas']);
                                foreach($data['grupo_empresas'] AS $k=>$v){
                        ?>
                        <tr>
                            <td>
                                <?php echo $v->empresa; ?>
                            </td>
                        </tr>
                        <?php
                                }//ENDWHILE
                            }//ENDIF
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
