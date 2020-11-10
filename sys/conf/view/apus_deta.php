<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 06/01/2017
 * Time: 09:44 AM
 */
?>


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
core.dataTableConf = conf.apus_deta.dataTableConf;
    $(document).ready(function () {
        core.dataTable();
    });
</script>
