<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 01/11/2016
 * Time: 05:18 PM
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
core.dataTableConf = conf.depa_inde.dataTableConf;
    $(document).ready(function () {
        core.dataTable();
    });
</script>
