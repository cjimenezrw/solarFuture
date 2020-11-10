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

            <tbody >
                <tr>
                    <th><b>Codigo</b></th>
                    <td colspan="3"><?php echo (isset($result['skSucursal'])) ? $result['skSucursal'] : ''; ?></td>
                </tr>



                <tr>
                    <td class="detail" colspan="4"><hr></td>
                </tr>


                <tr>
                    <th class="detail"><b>Estatus</b></th>
                    <td class="detail" ><?php echo (isset($result['skEstatus'])) ? $result['skEstatus'] : ''; ?></td>

                    <th class="detail"><b>Fecha de Creación</b></th>
                    <td class="detail"><?php echo ($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : '') ?></td>
                </tr>
                <tr>

                    <th class="detail"><b>Nombre</b></th>
                    <td class="detail"><?php echo (isset($result['sNombre'])) ? $result['sNombre'] : ''; ?></td>

                    <th class="detail"><b>Nombre Corto</b></th>
                    <td class="detail"><?php echo (isset($result['sNombreCorto'])) ? $result['sNombreCorto'] : ''; ?></td>
                </tr>

            </tbody>

        </table>
    </div>
</div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
