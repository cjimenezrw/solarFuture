<?php
    if (isset($data['datos'])) {
        $result = $data['datos'];
    } 
    //exit('<pre>'.print_r($result,1).'</pre>');
?>
<form class="form-horizontal" id="core-guardar" method="post"  enctype="multipart/form-data">

<div class="row">

    <div class="col-md-6">
        <div class="panel panel-bordered panel-primary panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS DE INVENTARIO</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg col-md-12">

                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">NOMBRE :</h4>
                                <p><?php echo (!empty($result['sNombre'])) ? $result['sNombre'] : '';?> </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">CÓDIGO</h4>
                                <p><?php echo (!empty($result['sCodigo'])) ? $result['sCodigo'] : '-'; ?> </p>
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">CLAVE PRODUCTO/ SERVICIO :</h4>
                                <p><?php echo (!empty($result['iClaveProductoServicio'])) ? $result['iClaveProductoServicio'] : '';?> </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">UNIDAD DE MEDIDA</h4>
                                <p><?php echo (!empty($result['unidadMedida'])) ? $result['unidadMedida'] : '-'; ?> </p>
                            </div>
                        </div>
                    
                        <div class="col-md-12 clearfix"><hr></div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">Kwh</h4>
                                <p><?php echo (!empty($result['fKwh'])) ? number_format($result['fKwh'],2) : '-'; ?> </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">METROS 2</h4>
                                <p><?php echo (!empty($result['fMetros2'])) ? $result['fMetros2'] : '-'; ?> </p>
                            </div>
                        </div>

                        <div class="col-md-12"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">CATEGORÍA PRODUCTO</h4>
                                <p><?php echo (!empty($result['categoriaProducto'])) ? $result['categoriaProducto'] : '-'; ?> </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">PROVEEDOR</h4>
                                <p><?php echo (!empty($result['proveedor'])) ? $result['proveedor'] : '-'; ?> </p>
                            </div>
                        </div>

                        <div class="col-md-12 clearfix"><hr></div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">PRECIO DE COMPRA</h4>
                                <p><?php echo (!empty($result['fPrecioCompra'])) ? number_format($result['fPrecioCompra'],2) : '-'; ?> </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">PRECIO DE VENTA</h4>
                                <p><?php echo (!empty($result['fPrecioVenta'])) ? number_format($result['fPrecioVenta'],2) : '-'; ?> </p>
                            </div>
                        </div>

                        <div class="col-md-12"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h4 class="example-title">DESCRIPCIÓN:</h4>
                                <p><?php echo (!empty($result['sDescripcion'])) ? $result['sDescripcion'] : '-'; ?> </p>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-bordered panel-dark panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS GENERALES</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg col-md-12">

            <!--
                <div class="col-md-6">
                    <div class="form-group">
                        <h4 class="example-title">MARCA</h4>
                        <p><?php echo (!empty($result['proveedor'])) ? $result['proveedor'] : '-'; ?> </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <h4 class="example-title">MODELO</h4>
                        <p><?php echo (!empty($result['proveedor'])) ? $result['proveedor'] : '-'; ?> </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <h4 class="example-title">NÚMERO DE SERIE</h4>
                        <p><?php echo (!empty($result['proveedor'])) ? $result['proveedor'] : '-'; ?> </p>
                    </div>
                </div>
            !-->

                <!--<div class="form-group col-md-12 ">!-->
                        
                                    <div class="well tableMultiple-panelEdit col-md-12">
                                        <p class="tableMultiple-editAndo text-center"></p>
                                        <div class="form-group col-md-12">
                        
                                            <!-- YOUR CODE BEGIN HERE -->

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="example-title">MARCA</h4>
                                                        <input class="form-control" data-plugin="inputText" inputtext="" id="sMarca" placeholder="MARCA" autocomplete="off" type="text"/> 
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="example-title">MODELO</h4>
                                                        <input class="form-control" data-plugin="inputText" inputtext="" id="sMarca" placeholder="MARCA" autocomplete="off" type="text"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="example-title">NÚMERO DE SERIE</h4>
                                                        <input class="form-control" data-plugin="inputText" inputtext="" id="sNumeroSerie" placeholder="NÚMERO DE SERIE" autocomplete="off" type="text"/> 
                                                    </div>
                                                </div>

                        
                                            <!-- YOUR CODE END HERE -->
                                            
                                                <div class="col-md-12 clearfix"><hr></div>

                                                <div class="col-md-12">
                                                    <button id="tableMultiple-addRow" onclick="tableMultiple_addNewRow();" class="btn btn-primary col-md-12">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                                    </button>
                                                </div>

                                        </div>
                                    </div>
                        
                                    <div class="col-md-12">
                                        <div class="example">
                                            <div id="toolbar">
                                                <button id="tableMultiple-removeRowTableMultiple" class="btn btn-direction btn-bottom btn-danger btn-outline" disabled>
                                                    <i class="fa fa-trash"></i> Borrar
                                                </button>
                                            </div>
                                            <table id="tableMultiple" data-toggle="table" data-toolbar="#toolbar"
                                                   data-query-params="queryParams" data-mobile-responsive="true"
                                                   data-height="400" data-pagination="false" data-icon-size="outline"
                                                   data-search="true" data-unique-id="id">
                                            </table>
                                        </div>
                                    </div>
                        
                                </div>

                <!--</div>!-->
            </div>
        </div>
    </div>

</div>
</form>
<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/<?php echo VERSION; ?>/<?php echo $this->sysModule; ?>.js"></script>
<script type="text/javascript">
    core.formValidaciones.fields = <?php echo $this->sysModule; ?>.<?php echo $this->sysFunction; ?>.validaciones;
    $(document).ready(function () {
        $('#core-guardar').formValidation(core.formValidaciones);
    });
</script>