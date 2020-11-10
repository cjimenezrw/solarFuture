<?php
    $arrayPrincipal = '';
    if($data['datos']){
        $arrayPrincipal = $data['datos'];
    }
 ?>
 <?php if($arrayPrincipal){ ?>
<?php  foreach ($arrayPrincipal as $key => $value) { ?>
    <div class="col-lg-3 col-sm-6 col-xs-12 info-panel">
        <div class="widget widget-shadow">
            <div class="widget-content bg-white padding-20">
                <button type="button" class="btn btn-floating btn-sm <?php echo $value['sColor']; ?>" style="font-size:28px; height:80px;width:80px;">
                    <i class="icon <?php echo $value['sIcono']; ?>"></i>
                </button>
                <span class="margin-left-15 font-weight-400" style="font-size:18px; "><?php echo $value['sTitulo']; ?></span>
                <div class="margin-bottom-0">
                    <?php if ($value['subMenu']) { ?>
                    <ul class="list-group margin-top-10 list-group-dividered list-group-full">
                        <?php foreach ($value['subMenu'] as $key => $subMenu): ?>
                            <?php
                                $tArchivo=SYS_PATH.$subMenu['skModuloPrincipal'].'/view/'.str_replace('-','_',$subMenu['skModulo']).'.php';

                             ?>
                             <?php if((!file_exists($tArchivo))){ ?>
                                    <li class="list-group-item"> <?php echo $subMenu['sTitulo']; ?></li>
                             <?php }else{ ?>
                                    <li class="list-group-item">
                                        <a role="button"
                                        onclick="core.menuLoadModule({ skModulo: '<?php echo $subMenu['skModulo']; ?>', url: '<?php echo '/' . DIR_PATH . SYS_PROJECT . '/' . $subMenu['skModuloPrincipal'] . '/' . $subMenu['skModulo'] . '/' . $subMenu['sNombre'] . '/'; ?>' });" >
                                            <?php echo $subMenu['sTitulo']; ?></a></li>
                             <?php } ?>

                        <?php endforeach; ?>
                    </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php    } ?>
    <?php    } ?>
