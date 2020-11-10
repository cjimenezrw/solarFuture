<style>
.sitemap-list {
  padding: 0;
  margin-bottom: 30px;
  list-style-type: none;
}
.sitemap-list a {
  color: #76838f;
}
.sitemap-list > li:first-child {
  margin-bottom: 25px;
}
.sitemap-list > li.is-single {
  margin-bottom: 10px;
}
.sitemap-list > li > a {
  display: block;
  padding: 14px 15px;
  line-height: 1;
  text-decoration: none;
  border: 1px solid #e4eaec;
  border-radius: 5px;
}
.sitemap-list > li > ul {
  position: relative;
  padding: 10px 10px 20px 40px;
  margin: 0;
  list-style-type: none;
}
.sitemap-list > li > ul a:hover {
  color: #62a8ea;
}
.sitemap-list > li > ul::before {
  position: absolute;
  top: 0;
  left: 20px;
  width: 1px;
  height: 100%;
  content: " ";
  background: #e4eaec;
}
.sitemap-list > li > ul > li > a {
  position: relative;
  display: block;
  min-width: 220px;
  padding: 10px;
  margin-bottom: 5px;
  line-height: 1;
  text-decoration: none;
  border: 1px solid #e4eaec;
}
.sitemap-list > li > ul > li > a::before,
.sitemap-list > li > ul > li > a::after {
  position: absolute;
  top: 50%;
  content: " ";
  background: #e4eaec;
}
.sitemap-list > li > ul > li > a::before {
  left: -20px;
  width: 20px;
  height: 1px;
  margin-top: -1px;
}
.sitemap-list > li > ul > li > a::after {
  left: -23px;
  width: 5px;
  height: 5px;
  margin-top: -3px;
  border-radius: 50%;
}
.sitemap-list-sub {
  position: relative;
  padding: 5px 0 9px 40px;
  margin-top: -5px;
  list-style-type: none;
}
.sitemap-list-sub::before {
  position: absolute;
  top: 0;
  left: 20px;
  width: 1px;
  height: 100%;
  content: " ";
  background: #e4eaec;
}
.sitemap-list-sub > li {
  position: relative;
  line-height: 30px;
}
.sitemap-list-sub > li::before,
.sitemap-list-sub > li::after {
  position: absolute;
  top: 50%;
  left: -22px;
  content: " ";
  background: #e4eaec;
}
.sitemap-list-sub > li::before {
  width: 15px;
  height: 1px;
  margin-top: -1px;
}
.sitemap-list-sub > li::after {
  width: 5px;
  height: 5px;
  margin-top: -3px;
  border-radius: 50%;
}
@media (max-width: 480px) {
  .sitemap-list {
    padding-left: 40px;
    list-style-type: disc;
  }
  .sitemap-list .icon {
    display: none;
  }
  .sitemap-list > li:first-child {
    margin-bottom: 20px;
    margin-left: -16px;
    list-style-type: none;
  }
  .sitemap-list > li > a {
    display: inline;
    padding: 10px;
    border: none;
  }
  .sitemap-list > li > a i {
    display: none;
  }
  .sitemap-list > li > ul {
    padding: 5px 0 5px 26px;
    list-style-type: circle;
  }
  .sitemap-list > li > ul::before {
    display: none;
  }
  .sitemap-list > li > ul > li > a {
    display: inline;
    padding: 10px 0;
    border: none;
  }
  .sitemap-list > li > ul > li > a::before,
  .sitemap-list > li > ul > li > a::after {
    display: none;
  }
  .sitemap-list-sub {
    padding: 5px 0 5px 20px;
    list-style-type: square;
  }
  .sitemap-list-sub::before {
    display: none;
  }
  .sitemap-list-sub > li {
    line-height: normal;
  }
  .sitemap-list-sub > li::before,
  .sitemap-list-sub > li::after {
    display: none;
  }
}

</style>
 <?php
/* while ($row = Conn::fetch_assoc($data['mapa'])) {
        utf8($row);
        echo $row['sTitulo']."<br>";

    }*/
 ?>
 <?php if($data['mapa']){

   ?>
   <?php
   $arrayMapa = array();
   $padre0 = '';
   $padre1 = '';
   $padre2 = '';
   $html = '';
   $count = 1;
   foreach ($data['mapa'] as $row) {
     utf8($row);
     if($row['eNivel'] == '0'){
       $padre0=$row['skModulo'];
     }
     if($row['eNivel'] == '1'){
       $padre1=$row['skModulo'];
     }
     if($row['eNivel'] == '2'){
       $padre2=$row['skModulo'];
     }
        $modulo = $row['skModulo'];

       if($row['eNivel'] == '0'){
       $arrayMapa[$row['skModulo']]['skModulo'] = $row['skModulo'];
       $arrayMapa[$row['skModulo']]['eNivel'] = $row['eNivel'];
       $arrayMapa[$row['skModulo']]['sNombre'] = $row['sNombre'];
       $arrayMapa[$row['skModulo']]['skModuloPrincipal'] = $row['skModuloPrincipal'];
       $arrayMapa[$row['skModulo']]['sModuloPadre'] = $row['sModuloPadre'];
       $arrayMapa[$row['skModulo']]['sIcono'] = (isset($row['sIcono']) ? $row['sIcono'] : '');
       $arrayMapa[$row['skModulo']]['sTitulo'] = trim(($row['sTitulo']));
       $arrayMapa[$row['skModulo']]['contador'] = $count;
       $arrayMapa[$row['skModulo']]['subMenu'] = array();
       $count++;
      }
      if($row['eNivel'] == '1'){
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModulo'] = $row['skModulo'];
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['eNivel'] = $row['eNivel'];
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sNombre'] = $row['sNombre'];
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModuloPrincipal'] = $row['skModuloPrincipal'];
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sModuloPadre'] = $row['sModuloPadre'];
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sIcono'] = (isset($row['sIcono']) ? $row['sIcono'] : '');
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sTitulo'] = trim(($row['sTitulo']));
      $arrayMapa[$row['sModuloPadre']]['subMenu'][$row['skModulo']]['subMenu'] = array();
     }
     if($row['eNivel'] == '2'){
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModulo'] = $row['skModulo'];
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['eNivel'] = $row['eNivel'];
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sNombre'] = $row['sNombre'];
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModuloPrincipal'] = $row['skModuloPrincipal'];
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sModuloPadre'] = $row['sModuloPadre'];
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sIcono'] = (isset($row['sIcono']) ? $row['sIcono'] : '');
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sTitulo'] = trim(($row['sTitulo']));
     $arrayMapa[$padre0]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['subMenu'] = array();
    }
    if($row['eNivel'] == '3'){
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModulo'] = $row['skModulo'];
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['eNivel'] = $row['eNivel'];
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sNombre'] = $row['sNombre'];
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModuloPrincipal'] = $row['skModuloPrincipal'];
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sModuloPadre'] = $row['sModuloPadre'];
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sIcono'] = (isset($row['sIcono']) ? $row['sIcono'] : '');
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sTitulo'] = trim(($row['sTitulo']));
    $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['subMenu'] = array();
   }
   if($row['eNivel'] == '4'){
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModulo'] = $row['skModulo'];
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['eNivel'] = $row['eNivel'];
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sNombre'] = $row['sNombre'];
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['skModuloPrincipal'] = $row['skModuloPrincipal'];
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sModuloPadre'] = $row['sModuloPadre'];
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sIcono'] = (isset($row['sIcono']) ? $row['sIcono'] : '');
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['sTitulo'] = trim(($row['sTitulo']));
   $arrayMapa[$padre0]['subMenu'][$padre1]['subMenu'][$padre2]['subMenu'][$row['sModuloPadre']]['subMenu'][$row['skModulo']]['subMenu'] = array();
  }


    }




if (!empty($arrayMapa)) {
/*  echo "<PRE>";
  print_r($arrayMapa);
  echo "</PRE>";*/
  foreach ($arrayMapa as $modulos => $value) {
    if($value['contador'] == 5 || $value['contador'] == 9){ ?>
      <div class="clearfix">   </div>
    <?php }
    $tArchivo=SYS_PATH.$value['skModuloPrincipal'].'/view/'.str_replace('-','_',$value['skModulo']).'.php';
    ?>
    <div class="col-xlg-3 col-lg-6 col-md-6 col-sm-6">
    <ul class="sitemap-list">
      <li>
        <?php if((!file_exists($tArchivo))){ ?>
                             <a href="#">
                      <?php }else{ ?>
                        <a  role="button"
                        onclick="core.menuLoadModule({ skModulo: '<?php echo $value['skModulo']; ?>', sModuloPadre: '<?php echo $value['sModuloPadre']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModulo'] . '/' . $value['sNombre'] . '/'; ?>' });"
                        >
                        <?php } ?>
      <i class="<?php echo $value['sIcono'];?>"></i>
      <?php if((file_exists($tArchivo))){ ?>
      <i class="icon wb-link pull-right"></i>
      <?php } ?>
      <span <?php echo (file_exists($tArchivo) ? 'class="text-primary"' : '');?>><?php echo $value['sTitulo'];?> </span>
      </a>
      <?php if ($value['subMenu']) { ?>
          <ul>
            <?php foreach ($arrayMapa[$value['skModulo']]['subMenu'] as $key => $valueSubmenu) { ?>
              <?php
                                $tArchivo2=SYS_PATH.$valueSubmenu['skModuloPrincipal'].'/view/'.str_replace('-','_',$valueSubmenu['skModulo']).'.php';

              ?>
              <li>
                <?php if((!file_exists($tArchivo2))){ ?>
                                  <a href="#">   <span>
                              <?php }else{ ?>
                                <a  role="button"
                                onclick="core.menuLoadModule({ skModulo: '<?php echo $valueSubmenu['skModulo']; ?>', sModuloPadre: '<?php echo $valueSubmenu['sModuloPadre']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $valueSubmenu['skModuloPrincipal'] . '/' . $valueSubmenu['skModulo'] . '/' . $valueSubmenu['sNombre'] . '/'; ?>' });"
                                >
                                <?php } ?>
              <i class="<?php echo (file_exists($tArchivo2) ? 'icon wb-link' : '');?>  pull-right"></i>
              <span <?php echo (file_exists($tArchivo2) ? 'class="text-primary"' : '');?> ><?php echo $valueSubmenu['sTitulo'];?> </span>
              <?php if (!file_exists($tArchivo2)){ echo "</span></a>";}else{ echo "</a>";} ?>
              <?php if ($value['subMenu']) { ?>
                  <ul class="sitemap-list-sub">
                    <?php foreach ($arrayMapa[$value['skModulo']]['subMenu'][$valueSubmenu['skModulo']]['subMenu'] as $key => $value2) {
                      $tArchivo3=SYS_PATH.$value2['skModuloPrincipal'].'/view/'.str_replace('-','_',$value2['skModulo']).'.php';
                      ?>
                      <li role="presentation">
                        <?php if((file_exists($tArchivo3))){ ?>
                        <a  role="button"
                        onclick="core.menuLoadModule({ skModulo: '<?php echo $value2['skModulo']; ?>', sModuloPadre: '<?php echo $value2['sModuloPadre']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $value2['skModuloPrincipal'] . '/' . $value2['skModulo'] . '/' . $value2['sNombre'] . '/'; ?>' });"
                        >
                        <?php } ?>
                          <i class="<?php echo $value2['sIcono'];?> "></i>
                          <span <?php echo (file_exists($tArchivo3) ? 'class="text-primary"' : '');?>><?php echo $value2['sTitulo'];?> </span>
                          <?php if((file_exists($tArchivo3))){ ?>
                        </a>
                        <?php  } ?>
                      </li>
                    <?php } ?>
                  </ul>
              <?php } ?>
            </li>
              <?php } ?>
          </ul>
                  <?php } ?>

    </li>

    </ul>
  </div>

<?php  }



}

}
?>
