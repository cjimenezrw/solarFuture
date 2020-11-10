<form action="" method="post" id="searchModulo" onsubmit="event.preventDefault();buscadorModulo();return false;">
    <div class="input-search input-search-dark">
        <i class="input-search-icon wb-search" aria-hidden="true"></i>
        <input class="form-control" name="site-search" id="site-searchModulo" placeholder="Buscar Pagina"
               value="<?php echo(isset($_GET['p1']) ? $_GET['p1'] : ''); ?>" type="text">
        <button class="input-search-close icon wb-close" type="button" aria-label="Close"></button>
    </div>
</form>
<div class="clearfix"></div>

<?php if (isset($data['datos']) && $data['datos'] != false) { ?>
    <div class="clearfix"></div>
    <h1 class="page-search-title">Registros Encontrados Para "<?php echo(isset($_GET['p1']) ? $_GET['p1'] : ''); ?>
        "</h1>
    <ul class="list-group list-group-full list-group-dividered">
        <?php foreach ($data['datos'] as $row){
            $tArchivo = SYS_PATH . $row['skModuloPrincipal'] . '/view/' . str_replace('-', '_', $row['skModulo']) . '.php';
            if ((file_exists($tArchivo))) {
                $function = "core.menuLoadModule({skModulo: '" . $row['skModulo'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $row['skModuloPrincipal'] . '/' . $row['skModulo'] . '/' . $row['sNombre'] . "/'});";
                ?>
                <li class="list-group-item">
                    <h4>
                        <a tabindex="-1" role="button"
                           onclick="<?php echo $function; ?>"><?php echo $row['sTitulo']; ?></a>
                    </h4>

                    <p><?php echo $row['sTitulo']; ?></p>
                </li>
            <?php }
        } ?>
    </ul>

<?php } else { ?>

    <h1>No se encontraron registros para "<?php echo(isset($_GET['p1']) ? $_GET['p1'] : ''); ?>"</h1>


<?php } ?>


<script type="text/javascript">
    function buscadorModulo() {
        url = "<?php echo '/' . DIR_PATH . SYS_PROJECT . '/inic/inic-busc/buscar/'; ?>";
        var busqueda = $("#site-searchModulo").val();
        core.menuLoadModule({skModulo: 'inic-busc', url: url + busqueda + '/'})
    }
    $(document).ready(function () {
        $('#site-searchModulo').keypress(function (e) {
            if (e.which == 13) {
                $('form#searchModulo').submit();
                return false;    //<---- Add this line
            }
        });
    });

</script>
