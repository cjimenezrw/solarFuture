<?php
$result = array();
$result = $data;


$now  =  date('d/m/Y');
$date7 = strtotime("+14 day");
$date7  = date('d/m/Y', $date7);

$date3 = strtotime("+3 day");
$date3  = date('d/m/Y', $date3);

$dates3 = strtotime("-5 day");
$dates3  = date('d/m/Y', $dates3);

$hour  = date('G');
if ( $hour  >= 5 && $hour  <= 11 ) {
    $good = "Buenos Días";
} else if ( $hour  >= 12 && $hour  <= 18 ) {
    $good = "Buenas Tardes";
} else if ( $hour  >= 19 || $hour  <= 4 ) {
    $good = "Buenas Noches";
}

/*echo "<PRE>";
print_r($result);
echo "</PRE>";
die();
*/
?>
<div class="row" data-plugin="matchHeight" data-by-row="true">
    <!-- First Row -->

    
    <div class="col-sm-12 col-xs-12 col-md-12" style="pointer-events:none;">
        <div class="widget widget-shadow padding-20">
            <!--            <iframe id="forecast_embed" type="text/html" frameborder="0" height="100%" width="100%" src="https://forecast.io/embed/#lat=19.1277&lon=-104.2841&name=Manzanillo Mexico&language=es&color=#4c96ea&font=Arial&units=ca"></iframe>-->
            <a class="weatherwidget-io" href="https://forecast7.com/es/19d11n104d34/manzanillo/" data-label_1="MANZANILLO" data-label_2="CLIMA" data-font="Roboto" data-icons="Climacons Animated" data-theme="pure" >MANZANILLO CLIMA</a>
            <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
            </script>
        </div>
    </div>

</div>
<script type="text/javascript">

    $(document).ready(function () {

        $('.widget').matchHeight();

        $('.page-header').after('<div class="page-header page-header-image height-300 margin-bottom-30"><div class="text-center blue-grey-800 margin-top-50 margin-xs-0"><canvas id="scene"></canvas><div class="font-size-50  blue-grey-800"><?php echo $good . " " . $_SESSION["usuario"]["sNombreUsuario"]; ?></div><ul class="list-inline font-size-14"><li><i class="fa fa-home" aria-hidden="true"></i> <?php echo $_SESSION["usuario"]["sEmpresa"]; ?> </li><li class="margin-left-20"> <i class="icon wb-calendar margin-right-5" aria-hidden="true"></i> <?php echo date("d/m/Y"); ?> </li></ul> </div></div><input id="copy" type="text" value="SoftLab" hidden />');

        $('.page-header+.page-content').css({"padding-top":0});
        $('.page-header-fixed').css({"margin-top":"-95px"});
        $('.page-header-image').css({"margin-top":"95px"});


        //loadChart('ini');
        //$('.table').bootstrapTable({});
        //$('.selectpicker').selectpicker({});
        $('.count').counterUp({
            delay: 10,
            time: 1000
        });

        var _0xadee=['\x66\x6f\x6e\x74','\x70\x78\x20\x73\x61\x6e\x73\x2d\x73\x65\x72\x69\x66','\x74\x65\x78\x74\x41\x6c\x69\x67\x6e','\x63\x65\x6e\x74\x65\x72','\x66\x69\x6c\x6c\x54\x65\x78\x74','\x76\x61\x6c\x75\x65','\x67\x65\x74\x49\x6d\x61\x67\x65\x44\x61\x74\x61','\x67\x6c\x6f\x62\x61\x6c\x43\x6f\x6d\x70\x6f\x73\x69\x74\x65\x4f\x70\x65\x72\x61\x74\x69\x6f\x6e','\x73\x63\x72\x65\x65\x6e','\x72\x6f\x75\x6e\x64','\x6c\x65\x6e\x67\x74\x68','\x72\x65\x6e\x64\x65\x72','\x71\x75\x65\x72\x79\x53\x65\x6c\x65\x63\x74\x6f\x72','\x67\x65\x74\x43\x6f\x6e\x74\x65\x78\x74','\x23\x32\x39\x35\x31\x64\x35','\x23\x46\x46\x46','\x23\x30\x30\x30','\x23\x30\x63\x31\x65\x33\x62','\x70\x72\x6f\x74\x6f\x74\x79\x70\x65','\x62\x65\x67\x69\x6e\x50\x61\x74\x68','\x61\x72\x63','\x66\x69\x6c\x6c','\x73\x71\x72\x74','\x6b\x65\x79\x75\x70','\x72\x65\x73\x69\x7a\x65','\x6d\x6f\x75\x73\x65\x6d\x6f\x76\x65','\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72','\x74\x6f\x75\x63\x68\x6d\x6f\x76\x65','\x63\x6c\x69\x63\x6b','\x33\x38\x2c\x33\x38\x2c\x34\x30\x2c\x34\x30\x2c\x33\x37\x2c\x33\x39\x2c\x33\x37\x2c\x33\x39\x2c\x36\x36\x2c\x36\x35','\x70\x75\x73\x68','\x6b\x65\x79\x43\x6f\x64\x65','\x74\x6f\x53\x74\x72\x69\x6e\x67','\x69\x6e\x64\x65\x78\x4f\x66','\x2e\x6c\x69\x73\x74\x2d\x69\x6e\x6c\x69\x6e\x65','\x68\x69\x64\x65','\x2e\x70\x61\x67\x65\x2d\x68\x65\x61\x64\x65\x72\x2d\x69\x6d\x61\x67\x65','\x63\x73\x73','\x62\x61\x63\x6b\x67\x72\x6f\x75\x6e\x64\x2d\x69\x6d\x61\x67\x65','\x75\x72\x6c\x28\x68\x74\x74\x70\x73\x3a\x2f\x2f\x73\x6f\x66\x74\x6c\x61\x62\x2e\x6d\x78\x2f\x69\x6d\x67\x2f\x62\x61\x63\x6b\x67\x72\x6f\x75\x6e\x64\x2e\x6a\x70\x67\x29','\x69\x6e\x73\x65\x74\x20\x30\x20\x30\x20\x30\x20\x31\x30\x30\x30\x70\x78\x20\x72\x67\x62\x61\x28\x32\x35\x35\x2c\x20\x32\x35\x35\x2c\x20\x32\x35\x35\x2c\x20\x30\x2e\x34\x35\x29','\x62\x61\x63\x6b\x67\x72\x6f\x75\x6e\x64\x2d\x70\x6f\x73\x69\x74\x69\x6f\x6e','\x23\x73\x63\x65\x6e\x65','\x72\x61\x6e\x64\x6f\x6d','\x64\x65\x73\x74','\x61\x63\x63\x58','\x61\x63\x63\x59','\x66\x72\x69\x63\x74\x69\x6f\x6e','\x63\x6f\x6c\x6f\x72','\x66\x6c\x6f\x6f\x72','\x63\x6c\x69\x65\x6e\x74\x58','\x63\x6c\x69\x65\x6e\x74\x59','\x74\x6f\x75\x63\x68\x65\x73','\x77\x69\x64\x74\x68','\x69\x6e\x6e\x65\x72\x57\x69\x64\x74\x68','\x68\x65\x69\x67\x68\x74','\x69\x6e\x6e\x65\x72\x48\x65\x69\x67\x68\x74','\x63\x6c\x65\x61\x72\x52\x65\x63\x74'];(function(_0x2bcea4,_0x457e4b){var _0x726739=function(_0x305b21){while(--_0x305b21){_0x2bcea4['\x70\x75\x73\x68'](_0x2bcea4['\x73\x68\x69\x66\x74']());}};_0x726739(++_0x457e4b);}(_0xadee,0x1ed));var _0xeade=function(_0x5ca669,_0x270dfe){_0x5ca669=_0x5ca669-0x0;var _0xb6d7f7=_0xadee[_0x5ca669];return _0xb6d7f7;};var kkeys=[],konami=_0xeade('0x0');$(document)['\x6b\x65\x79\x64\x6f\x77\x6e'](function(_0x93661a){kkeys[_0xeade('0x1')](_0x93661a[_0xeade('0x2')]);if(kkeys[_0xeade('0x3')]()[_0xeade('0x4')](konami)>=0x0){$(_0xeade('0x5'))['\x68\x69\x64\x65']();$('\x2e\x66\x6f\x6e\x74\x2d\x73\x69\x7a\x65\x2d\x35\x30')[_0xeade('0x6')]();$(_0xeade('0x7'))[_0xeade('0x8')](_0xeade('0x9'),_0xeade('0xa'));$('\x2e\x70\x61\x67\x65\x2d\x68\x65\x61\x64\x65\x72\x2d\x69\x6d\x61\x67\x65')[_0xeade('0x8')]('\x62\x6f\x78\x2d\x73\x68\x61\x64\x6f\x77',_0xeade('0xb'));$(_0xeade('0x7'))[_0xeade('0x8')](_0xeade('0xc'),'\x63\x65\x6e\x74\x65\x72');$(_0xeade('0xd'))['\x73\x68\x6f\x77']();window['\x73\x63\x72\x6f\x6c\x6c\x54\x6f'](0x0,0x0);function _0x44e492(_0x25328f,_0x5effb8){this['\x78']=Math[_0xeade('0xe')]()*_0x357dfc,this['\x79']=Math[_0xeade('0xe')]()*_0x48c2e0,this[_0xeade('0xf')]={'\x78':_0x25328f,'\x79':_0x5effb8},this['\x72']=0x5*Math[_0xeade('0xe')]()+0x2,this['\x76\x78']=0x14*(Math['\x72\x61\x6e\x64\x6f\x6d']()-0.5),this['\x76\x79']=0x14*(Math['\x72\x61\x6e\x64\x6f\x6d']()-0.5),this[_0xeade('0x10')]=0x0,this[_0xeade('0x11')]=0x0,this[_0xeade('0x12')]=0.05*Math['\x72\x61\x6e\x64\x6f\x6d']()+0.94,this[_0xeade('0x13')]=_0x50a7f8[Math[_0xeade('0x14')](0x6*Math[_0xeade('0xe')]())];}function _0x5723b1(_0x1381ee){_0x40aeda['\x78']=_0x1381ee[_0xeade('0x15')],_0x40aeda['\x79']=_0x1381ee[_0xeade('0x16')];}function _0x2da6a4(_0x56c2ec){_0x56c2ec[_0xeade('0x17')]['\x6c\x65\x6e\x67\x74\x68']>0x0&&(_0x40aeda['\x78']=_0x56c2ec[_0xeade('0x17')][0x0][_0xeade('0x15')],_0x40aeda['\x79']=_0x56c2ec[_0xeade('0x17')][0x0][_0xeade('0x16')]);}function _0x20145b(_0x1e750b){_0x40aeda['\x78']=-0x270f,_0x40aeda['\x79']=-0x270f;}function _0x2dff17(){_0x357dfc=_0x24bac2[_0xeade('0x18')]=window[_0xeade('0x19')],_0x48c2e0=_0x24bac2[_0xeade('0x1a')]=window[_0xeade('0x1b')],_0x5f2333[_0xeade('0x1c')](0x0,0x0,_0x24bac2['\x77\x69\x64\x74\x68'],_0x24bac2[_0xeade('0x1a')]),_0x5f2333[_0xeade('0x1d')]='\x62\x6f\x6c\x64\x20'+_0x357dfc/0xa+_0xeade('0x1e'),_0x5f2333[_0xeade('0x1f')]=_0xeade('0x20'),_0x5f2333[_0xeade('0x21')](_0x305817[_0xeade('0x22')],_0x357dfc/0x2,_0x48c2e0/0x2);var _0x10fc73=_0x5f2333[_0xeade('0x23')](0x0,0x0,_0x357dfc,_0x48c2e0)['\x64\x61\x74\x61'];_0x5f2333[_0xeade('0x1c')](0x0,0x0,_0x24bac2[_0xeade('0x18')],_0x24bac2[_0xeade('0x1a')]),_0x5f2333[_0xeade('0x24')]=_0xeade('0x25'),_0x59fd17=[];for(var _0x3d3f90=0x0;_0x3d3f90<_0x357dfc;_0x3d3f90+=Math[_0xeade('0x26')](_0x357dfc/0x96))for(var _0x9acaaf=0x0;_0x9acaaf<_0x48c2e0;_0x9acaaf+=Math['\x72\x6f\x75\x6e\x64'](_0x357dfc/0x96))_0x10fc73[0x4*(_0x3d3f90+_0x9acaaf*_0x357dfc)+0x3]>0x96&&_0x59fd17[_0xeade('0x1')](new _0x44e492(_0x3d3f90,_0x9acaaf));_0x17a7c1=_0x59fd17[_0xeade('0x27')];}function _0x1bc416(){0x5===++_0x511cac&&(_0x511cac=0x0);}function _0x59c340(_0x1e119e){requestAnimationFrame(_0x59c340),_0x5f2333['\x63\x6c\x65\x61\x72\x52\x65\x63\x74'](0x0,0x0,_0x24bac2['\x77\x69\x64\x74\x68'],_0x24bac2[_0xeade('0x1a')]);for(var _0x410163=0x0;_0x410163<_0x17a7c1;_0x410163++)_0x59fd17[_0x410163][_0xeade('0x28')]();}var _0x24bac2=document[_0xeade('0x29')](_0xeade('0xd')),_0x5f2333=_0x24bac2[_0xeade('0x2a')]('\x32\x64'),_0x59fd17=[],_0x17a7c1=0x0,_0x40aeda={'\x78':0x0,'\x79':0x0},_0x511cac=0x1,_0x50a7f8=[_0xeade('0x2b'),_0xeade('0x2c'),_0xeade('0x2d'),_0xeade('0x2e'),'\x23\x34\x35\x35\x38\x36\x62'],_0x305817=document[_0xeade('0x29')]('\x23\x63\x6f\x70\x79'),_0x357dfc=_0x24bac2[_0xeade('0x18')]=window[_0xeade('0x19')],_0x48c2e0=_0x24bac2[_0xeade('0x1a')]=window[_0xeade('0x1b')];_0x44e492[_0xeade('0x2f')]['\x72\x65\x6e\x64\x65\x72']=function(){this[_0xeade('0x10')]=(this[_0xeade('0xf')]['\x78']-this['\x78'])/0x3e8,this[_0xeade('0x11')]=(this[_0xeade('0xf')]['\x79']-this['\x79'])/0x3e8,this['\x76\x78']+=this[_0xeade('0x10')],this['\x76\x79']+=this[_0xeade('0x11')],this['\x76\x78']*=this[_0xeade('0x12')],this['\x76\x79']*=this[_0xeade('0x12')],this['\x78']+=this['\x76\x78'],this['\x79']+=this['\x76\x79'],_0x5f2333['\x66\x69\x6c\x6c\x53\x74\x79\x6c\x65']=this[_0xeade('0x13')],_0x5f2333[_0xeade('0x30')](),_0x5f2333[_0xeade('0x31')](this['\x78'],this['\x79'],this['\x72'],0x2*Math['\x50\x49'],!0x1),_0x5f2333[_0xeade('0x32')]();var _0x11575c=this['\x78']-_0x40aeda['\x78'],_0xf1066e=this['\x79']-_0x40aeda['\x79'];Math[_0xeade('0x33')](_0x11575c*_0x11575c+_0xf1066e*_0xf1066e)<0x46*_0x511cac&&(this[_0xeade('0x10')]=(this['\x78']-_0x40aeda['\x78'])/0x64,this[_0xeade('0x11')]=(this['\x79']-_0x40aeda['\x79'])/0x64,this['\x76\x78']+=this[_0xeade('0x10')],this['\x76\x79']+=this[_0xeade('0x11')]);},_0x305817['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0xeade('0x34'),_0x2dff17),window['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0xeade('0x35'),_0x2dff17),window['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0xeade('0x36'),_0x5723b1),window[_0xeade('0x37')](_0xeade('0x38'),_0x2da6a4),window[_0xeade('0x37')](_0xeade('0x39'),_0x1bc416),window[_0xeade('0x37')]('\x74\x6f\x75\x63\x68\x65\x6e\x64',_0x20145b),_0x2dff17(),requestAnimationFrame(_0x59c340);}});

        //plyr.setup('.plyr');
        //videojs(document.querySelector('.video-js'));
        //$(".flowplayer").flowplayer();

});

</script>
