<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <!--[if IE]>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <![endif]-->
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <!-- Place favicon.ico in the root directory -->
      <link rel="apple-touch-icon" href="https://5studios.net/themes/dashcore3/apple-touch-icon.png">
      <link rel="icon" href="https://portal.softlab.mx:443/sys/serv/view/images/favicon.ico">
      <link href="https://fonts.googleapis.com/css?family=Poppins:100,300,400,500,700,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
      <title>SoftLab</title>
      <!-- themeforest:css -->
      <link rel="stylesheet" href="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/css/lib.min.css">
      <link rel="stylesheet" href="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/css/dashcore.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
      <!-- endinject -->
   </head>
   <body>
      <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
      <![endif]--><!-- ./Making stripe menu navigation -->
      <nav class="st-nav navbar main-nav navigation fixed-top" id="main-nav">
         <div class="container">
            <ul class="st-nav-menu nav navbar-nav">
               <li class="st-nav-section nav-item"><a href="automate-social.html#main" class="navbar-brand"><img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/img/logo.png" alt="Dashcore" class="logo logo-sticky d-inline-block d-md-none"> <img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/img/logo-light.png" alt="Dashcore" class="logo d-none d-md-inline-block"></a></li>
               <!--<li class="st-nav-section st-nav-primary nav-item"><a class="st-root-link nav-link" href="#">Portal SoftLab</a></li>!-->
               <li class="st-nav-section st-nav-secondary nav-item"><a class="btn btn-rounded btn-outline me-3 px-3" href="https://portal.softlab.mx/" target="_blank"><i class="fas fa-sign-in-alt d-none d-md-inline me-md-0 me-lg-2"></i> <span class="d-md-none d-lg-inline">Iniciar Sesión</span> </a></li>
               <!-- Mobile Navigation -->
               <li class="st-nav-section st-nav-mobile nav-item">
                  <button class="st-root-link navbar-toggler" type="button"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
                  <div class="st-popup">
                     <div class="st-popup-container">
                        <a class="st-popup-close-button">Cerrar</a>
                        <div class="st-dropdown-content-group">
                           <h4 class="text-uppercase regular">Contenido</h4>
                           <a class="regular text-primary" href="about.html"><i class="far fa-building me-2"></i> Inicio </a>
                        </div>
                        <div class="st-dropdown-content-group bg-light b-t"><a href="https://portal.softlab.mx/">Iniciar Sesión <i class="fas fa-arrow-right"></i></a></div>
                     </div>
                  </div>
               </li>
            </ul>
         </div>
      </nav>
      <main class="overflow-hidden">
         <!-- ./Page header -->
         <header class="section header text-contrast automate-social-header">
            <div class="shape-wrapper">
               <div class="shape shape-background shape-main gradient gradient-blue-purple"></div>
               <div class="shape shape-background shape-main shadow"></div>
               <div class="shape shape-background shape-top"></div>
               <div class="shape shape-background shape-right"></div>
            </div>
            <div class="container overflow-hidden">
               <div class="row gap-y">
                  <div class="col-lg-6">
                     <h1 class="text-contrast extra-bold display-md-3 display-lg-2 font-lg mb-5">Portal
                     <span class="d-block light font-md">SoftLab</span>
                     </h1>
                     <p class="text-contrast lead">Portal Operativo / Administrativo el cual se adapta a los procesos que su empresa requiera.</p>
                     <a class="btn btn-rounded btn-primary btn-lg rounded-pill" href="https://softlab.mx/#contact">
                        <i class="fa fa-rocket d-inline d-md-none"></i> <span class="d-none d-md-inline">Contáctanos</span>
                     </a>
                  </div>
               </div>
            </div>
            <div class="main-shape-wrapper">
               <div class="bubbles-wrapper">
                  <div data-aos="fade-up">
                     <figure><img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/img/automate-social/header/main-shape.svg" class="img-responsive main-shape floating" alt=""></figure>
                  </div>
               </div>
            </div>
         </header>
         <!-- Features Carousel -->
         <section class="section features-carousel b-b">
            <div class="container pt-0">
               <div class="cards-wrapper">
                  <div class="swiper-container" data-sw-autoplay="3500" data-sw-loop="true" data-sw-nav-arrows=".features-nav" data-sw-show-items="1" data-sw-space-between="30" data-sw-breakpoints='{"768": {"slidesPerView": 3}, "992": {"slidesPerView": 4}}'>
                     <div class="swiper-wrapper px-1">
                        <div class="swiper-slide px-2 px-sm-1">
                           <div class="card border-0 shadow">
                              <div class="card-body">
                                 <p class="bold mt-4"><i class="fas fa-globe-americas" style="font-size: 25px;"></i> <span style="font-size:20px;">Diseño Web</span></p>
                                 <hr class="w-50 mx-auto my-3">
                                 <p class="regular small text-secondary">Diseñamos a medida de cada uno de nuestros clientes. Creamos interfaces de usuario con altos niveles de usabilidad.</p>
                              </div>
                              <div class="card-footer d-flex align-items-center justify-content-around">
                                 <div class="roi">
                                    <p class="text-darker lead bold mb-0">+50</p>
                                    <p class="text-secondary small mt-0">Clientes</p>
                                 </div>
                                 <a href="javascript:;"><i class="fas fa-info-circle fa-2x"></i></a>
                              </div>
                           </div>
                        </div>
                        <div class="swiper-slide px-2 px-sm-1">
                           <div class="card border-0 shadow">
                              <div class="card-body">
                                 <p class="bold mt-4"><i class="fas fa-puzzle-piece" style="font-size: 25px;"></i> <span style="font-size:20px;">Diseño Adaptable</span></p>
                                 <hr class="w-50 mx-auto my-3">
                                 <p class="regular small text-secondary">El uso de smartphones y tablets crece cada día, demandando que los sitios se visualicen correctamente en estos formatos.</p>
                              </div>
                              <div class="card-footer d-flex align-items-center justify-content-around">
                                 <div class="roi">
                                    <p class="text-darker lead bold mb-0">+150</p>
                                    <p class="text-secondary small mt-0">Módulos</p>
                                 </div>
                                 <a href="javascript:;"><i class="fas fa-info-circle fa-2x"></i></a>
                              </div>
                           </div>
                        </div>
                        <div class="swiper-slide px-2 px-sm-1">
                           <div class="card border-0 shadow">
                              <div class="card-body">
                                 <p class="bold mt-4"><i class="fas fa-users" style="font-size: 25px;"></i> <span style="font-size:20px;">Marketin Digital</span></p>
                                 <hr class="w-50 mx-auto my-3">
                                 <p class="regular small text-secondary">Conectamos su plataforma a las redes sociales más usadas, para dar un mayor realce y publicidad a su sitio.</p>
                              </div>
                              <div class="card-footer d-flex align-items-center justify-content-around">
                                 <div class="roi">
                                    <p class="text-darker lead bold mb-0">+120</p>
                                    <p class="text-secondary small mt-0">Publicaciones</p>
                                 </div>
                                 <a href="javascript:;"><i class="fas fa-info-circle fa-2x"></i></a>
                              </div>
                           </div>
                        </div>
                        <div class="swiper-slide px-2 px-sm-1">
                           <div class="card border-0 shadow">
                              <div class="card-body">
                                 <p class="bold mt-4"><i class="fas fa-laptop" style="font-size: 25px;"></i> <span style="font-size:20px;">Portal Web</span></p>
                                 <hr class="w-50 mx-auto my-3">
                                 <p class="regular small text-secondary">Plataforma base, con control de accesos de usuarios a módulos adaptables a las necesidades de su empresa.</p>
                              </div>
                              <div class="card-footer d-flex align-items-center justify-content-around">
                                 <div class="roi">
                                    <p class="text-darker lead bold mb-0">+6</p>
                                    <p class="text-secondary small mt-0">Sistemas Web</p>
                                 </div>
                                 <a href="javascript:;"><i class="fas fa-info-circle fa-2x"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Add Arrows -->
                     <div class="text-primary features-nav features-nav-next"><span class="text-uppercase small">Next</span> <i class="features-nav-icon fas fa-long-arrow-alt-right"></i></div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ./Get Started -->
         <section class="section get-started1" style="width:100% !important;overflow: auto;">
            <div class="container bring-to-front">
               <div class="section-heading text-center">
                  <!--<h2 class="extra-bold">Por que a nosotros SI NOS IMPORTA MUCHO tener un <span style="text-decoration:underline;">Puerto Inteligente y Seguro</span></h2>!-->
                  <h2 class="extra-bold">Consulta de Arribos y Buques</h2>
                  <!--<p class="lead text-muted"><span class="text-primary">SoftLab</span> - El <b>Software</b> que su Empresa <b>Necesita</b></p>!-->
                  <p class="lead text-muted" style="text-align: left;"><span class="text-primary"><b>¡IMPORTANTE!</b></span> - La <b>Veracidad</b> de la información está sujeta al contenido del <b><a href="https://docs.google.com/spreadsheets/d/1QYZFPBQlBCNP_Hkf7gOgNMr6aKxs70qr/edit#gid=1338054736" target="_blank" style="text-decoration:underline;">Archivo Excel</a></b> de <b><a href="https://drive.google.com/drive/folders/1bGt6RPMpBBv-CXInYpyhqetGDf85vaqZ" target="_blank" style="text-decoration:underline;">Google Drive</a></b> proporcionado por <b>API Manzanillo</b></p>
                  <img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/img/updateDRIVE.jpeg" alt="" style="width:100%">
               </div>
               <div class="pb-8 position-relative">
                  <div class="browser shadow-lg mx-auto" data-aos="fade-up" style="width:100% !important">
                     <div class="screen">
                        <table id="example-table" class="display" style="width:100% !important;">
   <thead>
      <tr>
            <th>Código</th>
            <!--
            <th>C. Puerto</th>
            <th>C. Atraque</th>
            <th>T. Tráfico</th>
            !-->
            <th>Buque</th>
            <th>Naviera</th>
            <th>Viaje</th>
            <th>Tramo</th>
            <th>F. Cruce LP</th>
            <th>F. Fondeo</th>
            <th>F. Atraque</th>
            <th>F. Inicio Operaciones</th>
            <th>F. Término Operaciones</th>
            <th>Bandera</th>
            <th>Indicativo Llama</th>
      </tr>
   </thead>
   <tbody>
      <?php
         if(isset($data['get_buques_arribos']) && !empty($data['get_buques_arribos'])){
            foreach($data['get_buques_arribos'] AS $k=>$v){
      ?>
      <tr>
            <td><?php echo $v['sCodigo']; ?></td>
            <!--
            <td><?php echo $v['sCodigoPuerto']; ?></td>
            <td><?php echo $v['sCodigoAtraque']; ?></td>
            <td><?php echo $v['sTipoTrafico']; ?></td>
            !-->
            <td><?php echo $v['sNombre']; ?></td>
            <td><?php echo $v['sLineaNaviera']; ?></td>
            <td><?php echo $v['sViaje']; ?></td>
            <td><?php echo $v['sTramo']; ?></td>

            
            <td><?php echo $v['dFechaCruceLP']; ?></td>
            <td><?php echo $v['dFechaFondeo']; ?></td>
            <td><?php echo $v['dFechaAtraque']; ?></td>
            <td><?php echo $v['dFechaInicioOperaciones']; ?></td>
            <td><?php echo $v['dFechaTerminoOperaciones']; ?></td>
            
            <!--
            <td><?php echo (!empty($v['dFechaCruceLP']) ? date('d/m/Y H:i:s', strtotime($v['dFechaCruceLP'])) : NULL); ?></td>
            <td><?php echo (!empty($v['dFechaFondeo']) ? date('d/m/Y H:i:s', strtotime($v['dFechaFondeo'])) : NULL); ?></td>
            <td><?php echo (!empty($v['dFechaAtraque']) ? date('d/m/Y H:i:s', strtotime($v['dFechaAtraque'])) : NULL); ?></td>
            <td><?php echo (!empty($v['dFechaInicioOperaciones']) ? date('d/m/Y H:i:s', strtotime($v['dFechaInicioOperaciones'])) : NULL); ?></td>
            <td><?php echo (!empty($v['dFechaTerminoOperaciones']) ? date('d/m/Y H:i:s', strtotime($v['dFechaTerminoOperaciones'])) : NULL); ?></td>
            !-->

            <td><?php echo $v['sBandera']; ?></td>
            <td><?php echo $v['sIndicativoLlamada']; ?></td>
      </tr>
      <?php
            }//ENDFORECH
         }//ENDIF
      ?>
   </tbody>
   <tfoot>
      <tr>
            <th>Código</th>
            <th>C. Puerto</th>
            <th>C. Atraque</th>
            <th>T. Tráfico</th>
            <th>Buque</th>
            <th>Naviera</th>
            <th>Viaje</th>
            <th>F. Inicio Operaciones</th>
            <th>F. Término Operaciones</th>
            <th>Bandera</th>
            <th>Indicativo Llama</th>
      </tr>
   </tfoot>
</table>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ./Why Us -->
         <section class="section why-us">
            <div class="shapes-container">
               <div class="absolute shape-background top right"></div>
            </div>
            <div class="container">
               <div class="section-heading text-center">
                  <h2 class="bold">Integración con tu sistema</h2>
                  <p class="lead text-secondary">Acceso gratuito a través de API REST a la Consulta de Arribos y Buques para que puedas integrarlo a tu sistema.</p>
               </div>
               <div class="row gap-y">
                  <div class="col-md-5 position-relative">
                     <ul class="list-unstyled why-icon-list">
                        <li class="list-item">
                           <div class="d-flex align-items-start">
                              <div class="rounded-circle bg-info shadow-info text-contrast p-3 icon-xl d-flex align-items-center justify-content-center me-3">
                                 <i class="fas fa-laptop" style="font-size: 25px;"></i>
                              </div>
                              <div class="flex-fill">
                                 <h5 class="bold">Integración</h5>
                                 <p class="my-0">Fácil de integrar a tu sistema</p>
                              </div>
                           </div>
                        </li>
                        <li class="list-item">
                           <div class="d-flex align-items-start">
                              <div class="rounded-circle bg-success shadow-success text-contrast p-3 icon-xl d-flex align-items-center justify-content-center me-3">
                                 <i class="fas fa-file-alt" style="font-size: 25px;"></i>
                              </div>
                              <div class="flex-fill">
                                 <h5 class="bold">Documentación</h5>
                                 <p class="my-0">Fácil de implementar, <a href="https://portal.softlab.mx/sys/serv/arri-inde/arribos/" target="_blank">Ver Documentación</a></p>
                              </div>
                           </div>
                        </li>
                        <li class="list-item">
                           <div class="d-flex align-items-start">
                              <div class="rounded-circle bg-alternate shadow-alternate text-contrast p-3 icon-xl d-flex align-items-center justify-content-center me-3">
                                 <i class="fas fa-retweet" style="font-size: 25px;"></i>
                              </div>
                              <div class="flex-fill">
                                 <h5 class="bold">Actualización</h5>
                                 <p class="my-0">Actualización automática de información</p>
                              </div>
                           </div>
                        </li>
                        <li class="list-item">
                           <div class="d-flex align-items-start">
                              <div class="rounded-circle bg-danger shadow-danger text-contrast p-3 icon-xl d-flex align-items-center justify-content-center me-3">
                                 <i class="fas fa-link" style="font-size: 25px;"></i>
                              </div>
                              <div class="flex-fill">
                                 <h5 class="bold">URL API REST</h5>
                                 <p class="my-0">Consulta de <a href="https://portal.softlab.mx/sys/serv/serv-arri/arribos/v1/?axn=consultarBuques" target="_blank">Arribos y Buques</a></p>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div class="col-md-7">
                     <img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/img/automate-social/build.svg" class="img-responsive" alt="">
                  </div>
               </div>
            </div>
         </section>
         <!-- ./Advanced Marketing Automation Solution -->
         <section class="section text-contrast advanced-automation-solution overflow-hidden">
            <div class="shape-wrapper">
               <div class="shape shape-background mountain top shape-left"></div>
            </div>
            <div class="container">
               <div class="section-heading text-center">
                  <h2 class="bold text-contrast">Portal SoftLab</h2>
                  <p class="lead">Portal Administrativo / Operativo para controlar todos los precesos de su empresa de una forma más eficiente, eliminando el error humano, capaz de obtener reportes Operativos y Administrativos en todo momento, así como obtener KPI's</p>
               </div>
               <div class="bg-contrast shadow-lg rounded">
                  <div class="browser">
                     <div class="screen">
                        <!--
                        <img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/img/screens/dash/1.png" class="img-responsive rounded-bottom" alt="">
                        !-->
                        <!-- 1296 743 !-->
                        <img src="https://softlab.mx/img/header.png" class="img-responsive rounded-bottom" alt="" style="width:100%;">
                        
                     </div>
                     
                     <div class="bubbles-speech d-none d-md-block"><span class="absolute small shadow speech-bubble" style="top: 47%; left: 1%;" data-aos="slide-up">Módulos Adaptados</span> <span class="absolute small shadow speech-bubble" style="top: 69%; left: 61%;" data-aos="slide-up">Reportes y KPI's</span> <span class="absolute small shadow speech-bubble" style="top: 15%; left: 85%;" data-aos="slide-up">Información al Instante</span> <span class="absolute small shadow speech-bubble" style="top: 7%; left: 30%;" data-aos="slide-up">Facilidad de Uso</span></div>
                     
                  </div>
               </div>
            </div>
         </section>
         <!-- ./Footer - Four Columns -->
         <footer class="site-footer section" style="background: #273140;">
            <div class="container pb-3 b-t">
               <div class="row gap-y text-center text-md-start">
                  
                  <div class="col-md-4 me-auto">
                     <img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/img/logo.png" alt="" class="logo">
                     <p>El <b>Software</b> que su Empresa <b>Necesita</b></p>
                  </div>
               <div class="row small align-items-center">
                  <div class="col-md-4">
                     <p class="mt-2 mb-md-0 text-secondary text-center text-md-start">© <?php echo date('Y'); ?> SoftLab. Todos los derechos reservados.</p>
                  </div>
                  <div class="col-md-8">
                     <nav class="nav justify-content-center justify-content-md-end">
                        <a href="https://www.facebook.com/softlabmx/" target="_blank" class="btn btn-circle btn-sm btn-secondary me-3 op-4"><i class="fab fa-facebook"></i></a> 
                        <!--<a href="https://wa.me/5213141609368/" target="_blank" class="btn btn-circle btn-sm btn-secondary me-3 op-4"><i class="fab fa-whatsapp"></i></a>!--> 
                     </nav>
                  </div>
               </div>
            </div>
         </footer>
      </main>
      <!-- themeforest:js -->
      <script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/core.min.js"></script>
      <script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/lib.min.js"></script>
      <script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/dashcore.min.js"></script>
      <script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
      <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
      
      
      <script type="text/javascript">
         $(document).ready(function () {
            $('#example-table').DataTable();
            /*$('#example-table').DataTable({
               responsive: true
            });*/
         });
      </script>
      
      <!-- endinject -->
   </body>
</html>