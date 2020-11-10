</div> <!-- id="view-content" !-->
</div>
</div>
</div>

</div>
</div>
<footer class="site-footer">
    <div class="site-footer-legal"> &copy; <?php echo date('Y'); ?>  <a href="<?php echo SYS_URL; ?>"><?php echo WEBTITLE; ?></a></div>
    <div class="site-footer-right">
        Creado  por <a href="<?php echo DEVELOPER_WEBSITE; ?>" target="_blank"><?php echo DEVELOPER; ?></a>
    </div>
</footer>

<div id="mowi-div"></div>

<?php echo $load->getJS('core');
require_once(CORE_PATH.'src/notifications/listenChannel.php');
?>

<script type="text/javascript">
function buscador() {
   url = "<?php echo '/' . DIR_PATH . SYS_PROJECT . '/inic/inic-busc/buscar/'; ?>";
  var busqueda = $( "#site-search" ).val();
  core.menuLoadModule({ skModulo: 'inic-busc', url: url+busqueda+'/' })

  }

$(document).ready(function(){

  $('#site-search').keypress(function (e) {
  if (e.which == 13) {

    $('form#search').submit();

    return false;    //<---- Add this line
  }
});

  });


(function(document, window, $) {
  'use strict';
  var Site = window.Site;
  $(document).ready(function() {
    Site.run();
  });
})(document, window, jQuery);
</script>
</body>
</html>
