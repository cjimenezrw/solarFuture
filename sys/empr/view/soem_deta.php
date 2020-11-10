<?php
if (isset($data) && !empty($data) ) {
    utf8($data);
    
}


?>



<style>
    .detail{
        width: 25%;
        border: none;
        text-align: left;
    }
    th {

    }

</style>
<div class="container">

    <div class="row">

        <table class=" table-condensed" style="width:100%;" >

            <tbody>                
                <tr>
                    <th><b>Razón social</b></th>
                    <td colspan="3"><?php echo (isset($data['sRazonSocial'])) ? $data['sRazonSocial'] : ''; ?></td>
                </tr>
                <tr>
                    <td class="detail" colspan="4"><hr></td>
                </tr>
                
                
                <tr>
                    <th class="detail"><b>RFC</b></th>
                    <td class="detail"><?php echo (isset($data['sRFC'])) ? $data['sRFC'] : ''; ?></td>
                    
                    <th class="detail"><b>Tipo</b></th>
                    <td class="detail" ><?php echo (isset($data['TipoEmpresa'])) ? $data['TipoEmpresa'] : ''; ?></td>
                </tr>
                
                <tr>
                    <td class="detail" colspan="4"><hr></td>
                </tr>

                <tr>
                    <th class="detail"><b>Nombre Corto</b></th>
                    <td class="detail"><?php echo (isset($data['sAlias'])) ? $data['sAlias'] : ''; ?></td>
                    
                    <th class="detail"><b>Estatus</b></th>
                    <td class="detail" ><?php echo (isset($data['sEstatus'])) ? $data['sEstatus'] : ''; ?></td>
                </tr>
                
                <tr>
                    <th class="detail"><b>Usuario creador</b></th>
                    <td class="detail"><?php echo (isset($data['Creador'])) ? $data['Creador'] : ''; ?></td>

                    <th class="detail"><b>Fecha de Creación</b></th>
                    <td class="detail"><?php echo ($data['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($data['dFechaCreacion'])) : '') ?></td>
                </tr>
            </tbody>

        </table>
        
    </div>
    
</div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
