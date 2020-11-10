<?php
$result = array();
if (isset($data['datos'])) {
    $result = $data['datos'];
}
?>


<style>
    .detail{
        width: 25%;
        border: none;
    }
    .msgDetaDeta {
    padding: 5px;
    text-align: left;
    width: 20%;
    }

</style>
<div class="container">

    <div class="row">

        <table style="width:100%;" >

            <tbody style="width:100%;" >

                <tr>
                    <th class="msgDetaDeta"  colspan="2"><b>Asunto</b></th>
                    <td class="msgDetaDeta" colspan="4"><?php echo (isset($result['sAsunto'])) ? $result['sAsunto'] : ''; ?></td>
                </tr>

                <tr>
                    <td class="msgDetaDeta"  colspan="6"><hr></td>
                </tr>


                <tr>
                    <th class="msgDetaDeta"  colspan="2"><b>Emisor</b></th>
                    <td class="msgDetaDeta"  colspan="4"><?php

                        echo(isset($result['sEmisor'])) ? str_replace('"', '', $result['sEmisor']) : '' ;
                    ?></td>
                </tr>
                <tr>
                    <th class="msgDetaDeta"  colspan="2"><b>Para</b></th>
                    <td class="msgDetaDeta"  colspan="4"><?php
                        echo implode(', ',
                                json_decode(
                                    (isset($result['sDestinatario'])) ? $result['sDestinatario'] : '[]'
                                )
                            );
                        ?></td>
                </tr>
                <tr>
                    <th class="msgDetaDeta"  colspan="2"><b>CC</b></th>
                    <td class="msgDetaDeta"  colspan="4"><?php
                    echo implode(', ',
                                json_decode(
                                    str_replace('&quot;', '"',
                                        (isset($result['sCopia'])) ? $result['sCopia'] : '[]'
                                    )
                                )
                            );?></td>
                </tr>

                <tr>
                    <th class="msgDetaDeta"  colspan="2"><b>CCO</b></th>
                    <td class="msgDetaDeta"  colspan="4"><?php
                    echo implode(',',
                                json_decode(
                                    str_replace('&quot;', '"',
                                        (isset($result['sCopiaOculta'])) ? $result['sCopiaOculta'] : '[]'
                                    )
                                )
                            );?></td>
                </tr>

                <tr>
                    <td class="msgDetaDeta"  colspan="6"><hr></td>
                </tr>

                <tr rowspan="16">
                    <th class="msgDetaDeta"  colspan="2"><b>Contenido:</b></th>
                    <td class="msgDetaDeta"  colspan="4"><?php echo html_entity_decode((isset($result['sContenido'])) ? $result['sContenido'] : '' ); ?></td>

                </tr>

                <tr>
                    <td class="msgDetaDeta"  colspan="6"><hr></td>
                </tr>
                <tr>
                    <th class="msgDetaDeta"  colspan="2"><b>Fecha de creacion</b></th>
                    <td class="msgDetaDeta"  colspan="2" ><?php echo ($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : '') ?></td>

                </tr>

               <tr>
                    <th class="msgDetaDeta"  colspan="2"><b>Enviado</b></th>
                    <td class="msgDetaDeta"  colspan="3" ><?php
                if (isset($result['skEstatus']) && $result['skEstatus'] === 'EN') {
                    echo '<b>Mensaje enviado el: </b>' . date('d/m/Y  H:i:s', strtotime($result['dFechaEnvio']));
                }

                if (isset($result['skEstatus']) && $result['skEstatus'] === 'NU') {
                    echo '<b>Este mensaje no ha sido enviado</b>';

                }
                ?></td>


            </tbody>

        </table>

    </div>






<!--    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2" style="text-align:right;"><b>Asunto:</b></div>
            <div class="col-md-10"><?php echo (isset($result['sAsunto'])) ? $result['sAsunto'] : ''; ?></div>

        </div>
    </div>
    <div class="clearfix"><br></div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2" style="text-align:right;"><b>De:</b></div>
            <div class="col-md-10"><?php echo (isset($result['sEmisor'])) ? $result['sEmisor'] : ''; ?></div>
        </div>
        <div class="col-md-12">
            <div class="col-md-2" style="text-align:right;"><b>Para:</b></div>
            <div class="col-md-10"><?php echo (isset($result['sDestinatario'])) ? $result['sDestinatario'] : ''; ?></div>
        </div>
        <div class="col-md-12">
            <div class="col-md-2" style="text-align:right;"><b>CC:</b></div>
            <div class="col-md-10"><?php echo (isset($result['sCopia'])) ? $result['sCopia'] : ''; ?></div>
        </div>
        <div class="col-md-12">
            <div class="col-md-2" style="text-align:right;"><b>CCO:</b></div>
            <div class="col-md-10"><?php echo (isset($result['sCopiaOculta'])) ? $result['sCopiaOculta'] : ''; ?></div>
        </div>

    </div>
    <div class="clearfix"><br></div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-10 pull-right">
                <?php echo html_entity_decode((isset($result['sContenido'])) ? $result['sContenido'] : '' ); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <hr>

            <div class="col-md-6 pull-right">
                <?php
                if (isset($result['skEstatus']) && $result['skEstatus'] === 'EN') {
                    echo '<b>Mensaje enviado el: </b>' . date('d/m/Y  H:i:s', strtotime($result['dFechaEnvio']));
                }

                if (isset($result['skEstatus']) && $result['skEstatus'] === 'NU') {
                    echo '<b>Este mensaje no ha sido enviado</b>';
                    ;
                }
                ?>
            </div>
            <div class="col-md-6 pull-right"><b>Registro de mensaje creado el :</b> <?php echo ($result['dFechaCreacion'] ? date('d/m/Y  H:i:s', strtotime($result['dFechaCreacion'])) : '') ?></div>

        </div>
    </div>-->


</div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
