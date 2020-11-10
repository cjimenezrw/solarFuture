<!--<div class="row margin-vertical-5">-->
<!--    <button id="filtButt" class="btn btn-primary" data-target="#examplePositionCenter" data-toggle="modal" type="button">Filtrar-->
<!--    </button>-->
<!--</div>-->
<div class="row" id="div-table">
    <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable" id="core-dataTable">
        <thead>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.dataTableConf = conf.usua_inde.dataTableConf;
    $(document).ready(function () {
        core.dataTable();
    });
</script>
