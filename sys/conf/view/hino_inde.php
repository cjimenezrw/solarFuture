<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 25/01/2017
 * Time: 04:24 PM
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

<script src="<?php echo SYS_URL; ?>sys/conf/view/js/conf.js"></script>
<script type="text/javascript">
core.dataTableConf = conf.hino_inde.dataTableConf;
    $(document).ready(function () {
        core.dataTable();
    });
</script>
