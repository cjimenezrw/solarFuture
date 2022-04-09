<?php

/**
 * Clase AssetLoader
 *
 * Carga los css y js requeridos por modulo
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
class AssetLoader
{

    /** @var array Contiene la lista de recursos CSS y JS */
    private $dictionary;

    /**
     * Constructor
     *
     * Valida si las constantes que requiere estan establecidas
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return boolean True si la constante ASSETS_PATH_CDN esta establecida o false si no.
     */
    function __construct()
    {
        if (!ASSETS_PATH || !ASSETS_PATH_CDN) {
            echo("Constantes de ASSETS no disponibles");
            return false;
        }
        $this->prepare();

        return true;

    }

    /**
     * Funcion que establece los assets
     *
     * Esta funcion llena el array de  $dictionary con los recursos separados por
     * dos propiedades principales, CSS y JS, y ambos bifurcados en propiedades
     * que definen a que estan atendiendo.
     *
     * Core aplica a todo el template y login solo a la pantalla de login
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return boolean True
     */
    private function prepare()
    {

        $this->dictionary = array(
            "js" => array(
                "core" => array(
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/jquery-ui/jquery-ui.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap/bootstrap.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.js',
                    //ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asscroll/jquery-asScroll.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/mousewheel/jquery.mousewheel.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asscrollbar/jquery-asScrollbar.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asscrollable/jquery-asScrollable.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/ashoverscroll/jquery-asHoverScroll.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-select/bootstrap-select.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/select2/select2.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js?',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/switchery/switchery.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/intro-js/intro.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/screenfull/screenfull.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/slidepanel/jquery-slidePanel.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/typeahead-js/typeahead.jquery.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/typeahead-js/bloodhound.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/gauge-js/gauge.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/custom-toastr-sweetAlerts.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/downloadFiles.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/ckeditor/ckeditor.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/core.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/js/site.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/js/sections/menu.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/js/sections/menubar.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/js/sections/gridmenu.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/js/sections/sidebar.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/configs/config-colors.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/js/configs/config-tour.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/asscrollable.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/js/advanced/scrollable.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/animsition.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/slidepanel.js',
                    //ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/switchery.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/jt-timepicker.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/gauge-js.js',



                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/datatables/jquery.dataTables.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/datatables-bootstrap/dataTables.bootstrap.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/datatables-responsive/dataTables.responsive.js',


                    ASSETS_PATH . ASSETS_VERSION . '/custom/bootstrap-table/bootstrap-table.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/bootstrap-table/locale/bootstrap-table-es-MX.js',


                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/jt-timepicker/jquery.timepicker.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/clockpicker.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/clockpicker/bootstrap-clockpicker.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-select/bootstrap-select.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/bootstrap-select.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-contextmenu/bootstrap-contextmenu.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/js/advanced/context-menu.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/typeahead-js/typeahead.jquery.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/typeahead-js/bloodhound.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/asbreadcrumbs.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/formValidation.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/framework/bootstrap.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asbreadcrumbs/jquery-asBreadcrumbs.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/pace.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/pGenerator.js',

                    /* SE DEJA CON ASSETS_PATH POR CORS */
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/dropify/dropify.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/components/dropify.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/highlight/highlight.pack.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/highlight-js.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/js/advanced/highlight.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-sweetalert/sweet-alert.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/bootstrap-sweetalert.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/dropzone/min/dropzone.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/dropzone/min/dropzone-amd-module.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/amcharts.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/plugins/export/export.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/serial.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/pie.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/themes/light.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/plugins/export/lang/es.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/responsive/responsive.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/clockpicker/jquery-clockpicker.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/clockpicker/bootstrap-clockpicker.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/counterAnimation/waypoints.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/counterAnimation/jquery.counterup.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/title_notifier.js',
                    //ASSETS_PATH_CDN . ASSETS_VERSION . '/jquery.lazyload.min.js',
                    /* SUMMERNOTE */
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/summernote/summernote.min.js',
                    /*Imagenes de previos*/
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/plugins/sticky-header.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/animate-list.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/plugins/action-btn.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/plugins/selectable.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/selectable.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/js/app.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/js/apps/media.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/js/apps/projects.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/isotope/isotope.pkgd.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/jquery-labelauty/jquery-labelauty.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/magnific-popup/jquery.magnific-popup.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/matchheight.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/matchheight/jquery.matchHeight-min.js',
                    /*FIN Imagenes de previos*/
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootbox/bootbox.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/bootbox.min.js',


                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/jquery-labelauty.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/iziToast/iziToast.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/emoji/js/config.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/emoji/js/util.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/emoji/js/jquery.emojiarea.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/emoji/js/emoji-picker.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/emoji/emojione.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/aes-json-format.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/PageTitleNotification.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/dragscroll.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/organigrama/diagram.js',



                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/webui-popover/jquery.webui-popover.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/webui-popover.min.js',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/chartist-js/chartist.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/filament-tablesaw/tablesaw.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/masonry/masonry.pkgd.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/js/components/masonry.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/iziModal/iziModal.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/liveVideo/video.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/tour/anno.js',

                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/moment/moment.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/fullcalendar/fullcalendar.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/fullcalendar/lang/es.js',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/pusher.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/owl-carousel/owl.carousel.js'



                ),
                "login" => array(
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/jquery/jquery.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap/bootstrap.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.js',
                    //ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asscroll/jquery-asScroll.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/mousewheel/jquery.mousewheel.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asscrollable/jquery-asScrollable.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/ashoverscroll/jquery-asHoverScroll.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/modernizr/modernizr.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/breakpoints/breakpoints.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/custom-toastr-sweetAlerts.js',
                ),
                "website" => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/breakpoints/breakpoints.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/custom-toastr-sweetAlerts.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/downloadFiles.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/ckeditor/ckeditor.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/formValidation.min.js',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/framework/bootstrap.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/pace.min.js',
                ),
                'error' => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/modernizr/modernizr.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/breakpoints/breakpoints.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/jquery/jquery.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/bootstrap/bootstrap.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/asscroll/jquery-asScroll.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/mousewheel/jquery.mousewheel.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/asscrollable/jquery-asScrollable.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/ashoverscroll/jquery-asHoverScroll.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/switchery/switchery.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/intro-js/intro.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/screenfull/screenfull.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/slidepanel/jquery-slidePanel.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/core.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/site.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/sections/menu.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/sections/menubar.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/sections/gridmenu.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/sections/sidebar.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/configs/config-colors.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/configs/config-tour.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/components/asscrollable.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/components/animsition.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/components/slidepanel.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/components/switchery.min.js'
                ),
                'recover' => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/jquery/jquery.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/modernizr/modernizr.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/breakpoints/breakpoints.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/breakpoints/breakpoints.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/bootstrap/bootstrap.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/formValidation.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/framework/bootstrap.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/jt-timepicker/jquery.timepicker.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/core.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/js/site.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/components/animsition.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/custom-toastr-sweetAlerts.js'
                ),
                'deli-serv' => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/jquery/jquery.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/modernizr/modernizr.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/breakpoints/breakpoints.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/breakpoints/breakpoints.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/bootstrap/bootstrap.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/formValidation.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/framework/bootstrap.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/jt-timepicker/jquery.timepicker.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/core.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/js/site.min.js',

                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/js/components/animsition.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/custom-toastr-sweetAlerts.js',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/downloadFiles.js'
                )
            ),
            "css" => array(
                "core" => array(
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/css/bootstrap.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/css/bootstrap-extend.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/css/site.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/typeahead-js/typeahead.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asbreadcrumbs/asBreadcrumbs.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/switchery/switchery.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/intro-js/introjs.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/slidepanel/slidePanel.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/flag-icon-css/flag-icon.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/gauge-js/gauge.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/jquery-labelauty/jquery-labelauty.css',


                    /* SE DEJAN CON ASSETS_PATH POR MOTIVOS DE CORS */
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/web-icons/web-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/font-awesome/font-awesome.min.css',


                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/font-awesome-animation.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/fonts/brand-icons/brand-icons.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/datatables-bootstrap/dataTables.bootstrap.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/datatables-responsive/dataTables.responsive.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/tables/datatable.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/apps/projects.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/pages/profile.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-table/bootstrap-table.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/summernote/summernote.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-select/bootstrap-select.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/jt-timepicker/jquery-timepicker.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/clockpicker/clockpicker.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/forms/advanced.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/uikit/dropdowns.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/structure/breadcrumbs.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/formValidation.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/forms/validation.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asscrollable/asScrollable.min.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/pace.css',

                    /* SE DEJA CON ASSETS_PATH POR EL CORS */
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/dropify/dropify.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/dropzone/min/dropzone.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/dropzone/min/basic.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/highlight/styles/default.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/highlight/styles/github-gist.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/highlight/highlight.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/advanced/highlight.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/custom/css/general.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/styleUpdate.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/select2/select2.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-select/bootstrap-select.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/bootstrap-sweetalert/sweet-alert.min.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/js/charts/plugins/export/export.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/prev.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/clockpicker/clockpicker.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/magnific-popup/magnific-popup.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/pages/gallery.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/iziToast/iziToast.min.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/iziModal/iziModal.min.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/animate.min.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/emoji/css/emoji.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/organigrama/diagram.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/webui-popover/webui-popover.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/chartist-js/chartist.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/fonts/weather-icons/weather-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/bootstrap-table/bootstrap-table.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/filament-tablesaw/tablesaw.min.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/advanced/masonry.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/owl-carousel/owl.carousel.css',

                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/fullcalendar/fullcalendar.min.css',

                    ASSETS_PATH . ASSETS_VERSION . '/custom/liveVideo/video.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/tour/anno.css'


                ),
                "login" => array(
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/css/bootstrap.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/css/bootstrap-extend.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/css/site.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/asscrollable/asScrollable.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/switchery/switchery.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/intro-js/introjs.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/slidepanel/slidePanel.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/flag-icon-css/flag-icon.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/web-icons/web-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/brand-icons/brand-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/font-awesome/font-awesome.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/font-awesome-animation.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.css',
                    ASSETS_PATH_CDN . ASSETS_VERSION . '/tpl/examples/css/forms/advanced.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/animate.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/login.css'
                ),
                "website" => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.css',
                ),
                'error' => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/css/bootstrap.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/css/bootstrap-extend.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/css/site.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/asscrollable/asScrollable.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/switchery/switchery.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/intro-js/introjs.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/slidepanel/slidePanel.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/flag-icon-css/flag-icon.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/examples/css/pages/errors.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/web-icons/web-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/brand-icons/brand-icons.min.css',
                ),
                'recover' => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/css/bootstrap.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/css/bootstrap-extend.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/css/site.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/examples/css/pages/forgot-password.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/brand-icons/brand-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/web-icons/web-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/formValidation.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/examples/css/forms/validation.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/font-awesome/font-awesome.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/font-awesome-animation.min.css'
                ),
                'deli-serv' => array(
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/css/bootstrap.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/css/bootstrap-extend.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/css/site.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/animsition/animsition.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/examples/css/pages/forgot-password.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/brand-icons/brand-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/toastr/toastr.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/web-icons/web-icons.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/vendor/formvalidation/formValidation.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/examples/css/forms/validation.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/tpl/global/fonts/font-awesome/font-awesome.min.css',
                    ASSETS_PATH . ASSETS_VERSION . '/custom/css/font-awesome-animation.min.css'
                )

            )
        );
        return true;
    }

    /**
     * Carga los JS
     *
     * Esta funcion retorna una cadena de llamadas html a archivos JS, la cual
     * en algun punto se concatena en el header.php para su uso
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param string $id Cadena que describe que moduos atendera, login, core...
     * @return string Retorna el conjunto de assets JS
     */
    public function getJS($id)
    {
        $JS = '';
        if (!array_key_exists($id, $this->dictionary["js"])) {
            return false;
        }

        foreach ($this->dictionary["js"][$id] as $key => $value) {
            $JS .= "<script src=\"$value\"></script>\n\r";
        }

        return $JS;
    }

    /**
     * Para cargar los CSS
     *
     * Esta funcion retorna una cadena de llamadas html a archivos CSS, que
     * luego se concatena a donde deba necesitarse.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param string $id Cadena que describe que moduos atendera, login, core...
     * @return string Retorna el conjunto de assets CSS
     */
    public function getCSS($id)
    {
        $CSS = '';
        if (!array_key_exists($id, $this->dictionary["css"])) {
            return false;
        }

        foreach ($this->dictionary["css"][$id] as $key => $value) {
            $CSS .= "<link rel=\"stylesheet\" href=\"$value\"> \n\r";
        }

        return $CSS;
    }

}

/*
    "jquery"
    "bootstrap"
    "animsition"
    "jquery-asScrollable"
    "switchery"
    "intro.js"
    "jquery-slidePanel"
    "flag-icon-css"
    "web-icons"
    "brand-icons"
    "modernizr"
    "breakpoints"
    "screenfull"
    "jquery-scrollTo"
    "jquery-asHoverScroll"
    "jquery-placeholder"
    "jquery-asPieProgress"
    "chartist"
    "font-awesome"*/
