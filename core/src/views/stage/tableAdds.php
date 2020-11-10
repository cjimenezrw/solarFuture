<div id="context-menu">
    <ul class="dropdown-menu" role="menu">
    </ul>
</div>

<!-- Modal de filtros -->
<div class="modal fade example-modal-lg" id="filterModal" aria-hidden="true"
     aria-labelledby="filterModal" role="dialog" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Filtros</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <button class="btn btn-primary btn-outline margin-right-20 pull-right" id="addFilter"
                            type="button" onclick="core.dataTable.addFilter()">Añadir Filtro +
                    </button>
                    <div class="row">
                        <div class="col-sm-4 margin-left-20">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="checkbox-custom checkbox-default" data-toggle="tooltip" title="Predeterminado">
                                          <input type="checkbox" id="filtroPredeterminado" name="inputCheckbox">
                                          <label for="inputCheckbox"></label>
                                        </span>
                                    </span>
                                    <select title="Seleccione Filtro" class="filter-select2 pull-left width-250" data-plugin="selectpicker"></select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="filterContainer">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveFilter" class="btn btn-success pull-left"
                        data-dismiss="modal" onclick="core.dataTable.saveFilter(false);">Guardar
                </button>
                <button type="button" id="removeFilter" class="btn btn-danger pull-left"
                        data-dismiss="modal" onclick="core.dataTable.removeFilter(false);">Eliminar
                </button>
                <button type="button" id="clearFilter" title="Alt + L" class="btn btn-default" data-dismiss="modal"
                        onclick="core.dataTable.sendFilters(false);">Ignorar
                </button>
                <button type="button" class="btn btn-primary" title="Ctrl + Alt + A" data-dismiss="modal"
                        onclick="core.dataTable.sendFilters(true);">Aplicar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });

        $(document).keydown(function (e) {

            var b = $("#optionsBreadcrumb");

            if (e.keyCode == 70 && e.altKey && e.ctrlKey) {
                $('#filtButt').trigger('click');
            }

            if (e.keyCode == 65 && e.altKey && e.ctrlKey) {
                core.dataTable.sendFilters(true);
            }

            if (e.keyCode == 66 && e.altKey) {
                $('.wb-search').trigger('click');
            }

            if (e.keyCode == 78 && e.altKey) {
                b.find("a[data-original-title='Nuevo']").trigger("click");
            }

            if (e.keyCode == 71 && e.altKey) {
                b.find("a[data-original-title='Guardar']").trigger("click");
            }

            if (e.keyCode == 88 && e.altKey) {
                b.find("a[data-original-title='Excel']").trigger("click");
            }

            if (e.keyCode == 80 && e.altKey) {
                b.find("a[data-original-title='PDF']").trigger("click");
            }

            if (e.keyCode == 76 && e.altKey) {
                $('#clearFilter').trigger('click');
            }
        });

        $('#filterContainer').bind("DOMSubtreeModified", function () {
            if ($('.alert').length > 0) {
                $('#saveFilter').show();
            } else {
                $('#saveFilter').hide();
            }
        });

        var fs2 = $('.filter-select2');
        if ($('.filter-select2 option').find('option:not(:disabled)').length == 0) {
            fs2.hide();
        }

        $(document.body).on("change",".filter-select2",function(){

  /*          if ($(".filter-select2 :selected").val()){
                $('#saveFilter').hide();
                $('#removeFilter').show();
            }else {
                $('#removeFilter').hide();
                if ($('.alert').length > 0){
                    $('#saveFilter').show();
                }
            }*/

            fs2.on("select2:unselect", function (e) {
                $('#filtroPredeterminado').prop('checked', false);
                $('#removeFilter').hide();
                $('#saveFilter').hide();
                if ($('.alert').length > 0){
                    $('#saveFilter').show();
                }
            });

            fs2.on('select2:select', function (e) {
                //var data = e.params.data;

                if ($(".filter-select2 :selected").attr('predeterminado') == "true"){
                    $('#filtroPredeterminado').prop('checked', true);
                }else {
                    $('#filtroPredeterminado').prop('checked', false);
                }

                $('#saveFilter').hide();
                $('#removeFilter').show();
                if ($('.alert').length > 0){
                    $('#saveFilter').show();
                }
            });

        });

        fs2.select2({
            placeholder: "Sin Filtro",
            allowClear: true
        });

        var ckbox = $('#filtroPredeterminado');
        ckbox.on('click',function () {
            if ($(".filter-select2 :selected").val() == undefined){
                $('#filtroPredeterminado').prop('checked', false);
                return;
            }
            var skFiltro = $(".filter-select2 :selected").attr('skFiltroUsuario');
            if (ckbox.is(':checked')) {
                $.ajax({
                    type: "POST",
                    url: core.SYS_URL + "sys/inic/inic-dash/save-filters/",
                    global: false,
                    data: {
                        axn: 'saveFilters',
                        skModulo: core.module,
                        skFiltroUsuario: skFiltro
                    },
                    success: function (data) {
                        core.dataTable.getFilters();
                    }
                });

            } else {
                $.ajax({
                    type: "POST",
                    url: core.SYS_URL + "sys/inic/inic-dash/save-filters/",
                    global: false,
                    data: {
                        axn: 'saveFilters',
                        skModulo: core.module,
                        skFiltroUsuario: skFiltro
                    },
                    success: function (data) {
                        core.dataTable.getFilters();
                        $('#removeFilter').hide();
                    }
                });
                //core.dataTable.getFilters();
            }
        });

    });

</script>