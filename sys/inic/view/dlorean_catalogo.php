<!--<link rel="stylesheet" href="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/inic/view/js/styles/default.css">-->

<script>//hljs.initHighlightingOnLoad();</script>


<div class="page-content" id="xascIndice">
    <div class="documents-wrap articles">
        <ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-xs-2" data-plugin="matchHeight">

            <li>
                <div class="articles-item">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                    <h4 class="title"><a href="" onclick="streamingShow()">Streaming de datos.</a></h4>
                    <p>Emision en tiempo real de datos con php, aplicaciones: Porcentajes, mensajes de proceso...</p>
                </div>
            </li>

            <li>
                <div class="articles-item">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                    <h4 class="title"><a href="article.html" onclick="chronoShow()">Cronometrado de funciones</a></h4>
                    <p>Herramienta para cronometrar tiempos de ejecucion en php.</p>
                </div>
            </li>

            <li>
                <div class="articles-item">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                    <h4 class="title"><a href="article.html" onclick="excelExample()">Ejemplo de excel</a></h4>
                    <p>Funcion de Dlorean para generar archivos de excel.</p>
                </div>
            </li>

            <li>
                <div class="articles-item">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                    <h4 class="title"><a href="article.html" onclick="pdfExample()">Ejemplo de PDF</a></h4>
                    <p>Funcion de Dlorean para generar archivos de PDF.</p>
                </div>
            </li>

            <li>
                <div class="articles-item">
                    <i class="fa fa-file-code-o" aria-hidden="true"></i>
                    <h4 class="title"><a href="article.html">Tabla multiple.</a></h4>
                    <p>Front-end de tabla multiple desarrollada por Dlorean Team.</p>
                </div>
            </li>

            <li>
                <div class="articles-item">
                    <i class="fa fa-file-code-o" aria-hidden="true"></i>
                    <h4 class="title"><a href="article.html">Autocompletados.</a></h4>
                    <p>Autocompletado de datos</p>
                </div>
            </li>

            <li>
                <div class="articles-item">
                    <i class="fa fa-file-code-o" aria-hidden="true"></i>
                    <h4 class="title"><a href="article.html" id="digiInputExample"  >Digitalizacion input.</a></h4>
                    <p>Input dinamico para digitalizacion.</p>
                </div>
            </li>

        </ul>
    </div>
</div>


<div class="col-md-12" id="backListButton">
    <div class="col-md-5"><button type="button" class="btn btn-primary " onclick="showList()">Regresar al listado</button></div>
</div>

<div class="col-md-12">

    <div class="col-md-12 dloreanExample" id="dloreanExampleStreamingContainer">

        <div class="col-md-5">
            <h2 style="text-align: center;">Streaming de datos</h2>

            <div class="col-md-12 well" id="streamDloreanDisplay" style="height: 240px; overflow-x: auto;">

            </div>

            <div class="col-md-12" style="text-align: center; ">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary " id="iniciarStreaming">Iniciar streaming</button>
                </div>
                <div class="col-md-6">                    
                    <button type="button" class="btn btn-secondary" id="limpiarStreamingDisplay">Limpiar display</button>
                </div>
            </div>


        </div>

        <div class="col-md-7">

            <div class="example-wrap">
                <div class="nav-tabs-horizontal" >
                    <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                        <li class="active" role="presentation"><a data-toggle="tab" href="#info_StreamigData" aria-controls="info_StreamigData"
                                                                  role="tab">Info</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#php_StreamigData" aria-controls="php_StreamigData"
                                                   role="tab">PHP</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#html_StreamigData" aria-controls="html_StreamigData"
                                                   role="tab">HTML</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#js_StreamigData" aria-controls="js_StreamigData"
                                                   role="tab">Javascript</a></li>                    
                    </ul>

                    <div class="tab-content padding-top-20">
                        <div class="tab-pane active" id="info_StreamigData" role="tabpanel">
                            <h2>¿Que hace?</h2>

                            <p>Emitir los datos de echo en tiempo real desde php, de esta manera, puedes retornar informacion util en tiempo real de procesos largos.</p>
                            <p>Al momento de escribir esto, se ha implementado en el modulo de Nissan Datastage para mostrar el porcentaje de avance y mensajes del proceso de generar datastage.</p>

                            <h3>¿Como funciona?</h3>
                            <p>Un script php por default almacena toda la informacion que proveas mediante echo en un buffer, el cual se vacia en el output al final de la ejecucion, lo que significa que, si tu proceso demora 30s, no veras los echos hasta el final de la ejecucion.</p>
                            <p>Pero si puedes configurar php para vaciar el buffer cuando tu quieras, y asi, forzar a php a enviar los datos al navegador, ese es el principio basico de como funciona, puedes leer mas en los enlaces de abajo.</p>

                            <ul>
                                <li><a href="http://www.binarytides.com/ajax-based-streaming-without-polling/" target="_blank"> Binarytides no pooling streaming</a></li>
                                <li><a href="http://www.openjs.com/articles/ajax_xmlhttp_using_post.php" target="_blank"> Openjs xmlhttprequest via post</a></li>
                                <li><a href="https://stackoverflow.com/questions/9713058/send-post-data-using-xmlhttprequest" target="_blank">  Stackoverflow xmlhttprequest</a></li>
                                <li><a href="https://stackoverflow.com/questions/4870697/php-flush-that-works-even-in-nginx?noredirect=1&lq=1" target="_blank"> Stackoverflow Flush</a></li>
                            </ul>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="php_StreamigData" role="tabpanel">
                            <pre><code class="php">
/*
 * Codigo de las funciones en helper.php
 */

streamingStart();
$datosXD = 'Proceso turbo mega super hiper requete mortalmente largo.';

foreach( explode( ' ', $datosXD) as $word){
    streamData($word);
    sleep(1);
}

streamigStop(); 
                            </code></pre>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="html_StreamigData" role="tabpanel">
                            <pre><code class="html">
                                    <?php echo htmlspecialchars("<h2 style=\"text-align: center;\">Streaming de datos</h2>            
<div class=\"col-md-12 well\" id=\"streamDloreanDisplay\" style=\"height: 240px; overflow-x: auto;\"></div>

<div class=\"col-md-12\" style=\"text-align: center; \">
    <div class=\"col-md-6\">
        <button type=\"button\" class=\"btn btn-primary btn-lg\" id=\"iniciarStreaming\">Iniciar streaming</button>
    </div>
    <div class=\"col-md-6\">                    
        <button type=\"button\" class=\"btn btn-secondary btn-lg\" id=\"limpiarStreamingDisplay\">Limpiar display</button>
    </div>
</div>"); ?>
                       </code></pre>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="js_StreamigData" role="tabpanel">
                            <pre><code class="javascript">
                                    <?php echo htmlspecialchars("$('#streamDloreanDisplay').empty();
$('#iniciarStreaming').prop('disabled', true);
if($(\"#iniciarStreaming\").is(\":disabled\")){
    return;
}
if (!window.XMLHttpRequest) {
    console.error(\"Tu navegador no soporta XMLHttpRequest nativo.\");
    return;
}

try {
    var xhr = new XMLHttpRequest();
    xhr.previous_text = '';

    xhr.onerror = function () {
        console.info(\"[XHR] Fatal Error.\");

    };
    xhr.onreadystatechange = function () {
        try {

            if (xhr.readyState === 4) {
                $('#streamDloreanDisplay').append('Streaming terminado');
                $('#iniciarStreaming').prop('disabled', false);
            }

            if (xhr.readyState > 2) {
                var new_response = xhr.responseText.substring(xhr.previous_text.length);
                $('#streamDloreanDisplay').append( new_response + '<br>' );
                xhr.previous_text = xhr.responseText;
            }
        } catch (e) {
        }
    };

    xhr.open(\"GET\", window.location.href + \"?axn=longProcesWithStreamingExample\", true);
    xhr.send();

} catch (e) {
    console.error(\"Stream fallido\");
}"); ?>
                            </code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="col-md-12 dloreanExample" id="dloreanExampleChronoContainer">

        <div class="col-md-5">
            <h2 style="text-align: center;">Chronometrado</h2>

            <div class="col-md-12 well" id="chronArrayRepresentation" style="height: 280px; overflow-x: auto;">

            </div>

            <div class="col-md-12" style="text-align: center; ">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary " id="chronTest">Mostrar ejemplo</button>
                </div>
                <div class="col-md-6">                    
                    <button type="button" class="btn btn-secondary" id="limpiarChronoDisplay">Limpiar display</button>
                </div>
            </div>


        </div>

        <div class="col-md-7">

            <div class="example-wrap">
                <div class="nav-tabs-horizontal" >

                    <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                        <li class="active" role="presentation"><a data-toggle="tab" href="#info_Chrono" aria-controls="info_Chrono" role="tab">Info</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#php_Chrono" aria-controls="php_Chrono" role="tab">PHP</a></li>                  
                    </ul>

                    <div class="tab-content padding-top-20">
                        <div class="tab-pane active" id="info_Chrono" role="tabpanel">                            
                            <h2>¿Que hace?</h2>
                            <p>Crea un array asociativo de marcas, guardando el registro del microtime de inicio, fin y segundos de diferencia.</p>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="php_Chrono" role="tabpanel">
                            <pre><code class="php"><?php echo htmlspecialchars("
/*
 * Codigo de las funciones en helper.php
 */

function turboFuncion_A(){
    chronStart();                    
    sleep(rand(1, 3));
    chronEnd();
}   

function turboFuncionNoES_C(){
    chronStart('SubCosa1');
    sleep(rand(1, 2));
    chronEnd('SubCosa1');
}  

chronStart('General');    
turboFuncion_A();
turboFuncionNoES_C();
chronEnd('General');  

echo('<pre>'. print_r(getChronArray(), 1).'</pre>');
                            "); ?></code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="col-md-12 dloreanExample" id="dloreanExampleExcelFunction">

        <div class="col-md-5">
            <h2 style="text-align: center;">Excel</h2>

            <div class="col-md-12" style="height: 280px;">
                <button type="button" class="btn btn-primary btn-block"  style="height: 280px;" id="excelTestButton" ><b>Descargar excel</b></button>
            </div>
            

        </div>

        <div class="col-md-7">

            <div class="example-wrap">
                <div class="nav-tabs-horizontal" >
                    
                    <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                        <li class="active" role="presentation"><a data-toggle="tab" href="#info_ExcelFunct" aria-controls="info_ExcelFunct" role="tab">Info</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#php_ExcelFunction" aria-controls="php_ExcelFunction" role="tab">PHP</a></li>                  
                    </ul>

                    <div class="tab-content padding-top-20">
                        <div class="tab-pane active" id="info_ExcelFunct" role="tabpanel">                            
                            <h2>¿Que es?</h2>
                            <p>Es una funcion que provee una interfaz a la libreria PHPEXCEL, genera un archvo xls|xlsx a partir de un array, puedes leer la documentacion de la funcion para ver el formato correspondiente:</p>
                            <p>Para aplicar un estilo sobre las celdas, en vez de proveer  un valor como cadena, aplica un array, aqui tienes un ejemplo del array:</p>
                            <pre><code class="php"><?php echo htmlspecialchars("
\$ar = [
    'fileName' =>'SimonCamion',
    'format' => 'xlsx',
    'pages' => [
        'Hoja Zuculentonga' => [
            'startAt' => 'A1',
            'headers' => ['IF','NO',[ 
                        'value' => 'THEN SI', 
                        'merge' => 2, 
                        'font' => [
                            'bold'      => true,
                            'italic'    => true,
                            'color'     => ['rgb' => '003399'] 
                        ]
                    ], 'equis','de'],
            'headersOrientation' => 'H',
            'data' => [
                [
                    'Simon',
                    'Camion',
                    [ 
                        'value' => 'DIGIMOOOOOON', 
                        'merge' => 2, 
                        'font' => [
                            'bold'      => true,
                            'italic'    => true,
                            'color'     => ['rgb' => '003399'] 
                        ],
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FF0000')
                        ]
                    ],
                    'Equis de',
                    'Si'
                ],['si','si','si','si','Bueno...no']

            ]
        ]
    ]
]
"); ?></code></pre>
                            
                            <ul>
                                <li><a href="https://github.com/PHPOffice/PHPExcel" target="_blank"> Repositorio oficial</a></li>
                                <li><a href="https://github.com/PHPOffice/PHPExcel/wiki/Documentation" target="_blank"> PHPEXCEL Wiki</a></li>
                            </ul>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="php_ExcelFunction" role="tabpanel">
                            <pre><code class="php"><?php echo htmlspecialchars("
\$this->excel([
    'fileName' =>'SimonCamion',
    'format' => 'xlsx',
    'pages' => [
        'Hoja Zuculentonga' => [
            'startAt' => 'A1',
            'headers' => ['IF','NO',[ 
                        'value' => 'THEN SI', 
                        'merge' => 2, 
                        'font' => [
                            'bold'      => true,
                            'italic'    => true,
                            'color'     => ['rgb' => '003399'] 
                        ]
                    ], 'equis','de'],
            'headersOrientation' => 'H',
            'data' => [
                [
                    'Simon',
                    'Camion',
                    [ 
                        'value' => 'DIGIMOOOOOON', 
                        'merge' => 2, 
                        'font' => [
                            'bold'      => true,
                            'italic'    => true,
                            'color'     => ['rgb' => '003399'] 
                        ],
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FF0000')
                        ]
                    ],
                    'Equis de',
                    'Si'
                ],['si','si','si','si','Bueno...no']

            ]
        ]
    ]
]);
                            "); ?></code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="col-md-12 dloreanExample" id="dloreanExampleDigiInputl">

        <div class="col-md-5">
            <h2 style="text-align: center;">Plugin digitalizacion</h2>
            <div class="col-md-12" id="turboEjemploMultipleDigiInput" ></div>
            <div class="col-md-12" id="turboEjemploUnSoloLeFILESAURIO" ></div>
            <div class="col-md-12" id="turboEjemploERRORDELAPTAMADRE" ></div>
        </div>

        <div class="col-md-7">

            <div class="example-wrap">
                <div class="nav-tabs-horizontal" >
                    <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                        <li class="active" role="presentation"><a data-toggle="tab" href="#info_DigiInput" aria-controls="info_DigiInput"
                            role="tab">Info</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#html_DigiInput" aria-controls="html_DigiInput"
                            role="tab">HTML</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#js_DigiInput" aria-controls="js_DigiInput"
                            role="tab">Javascript</a></li>                    
                    </ul>

                    <div class="tab-content padding-top-20">
                        <div class="tab-pane active" id="info_DigiInput" role="tabpanel">
                            <h2>¿Que esta wea?</h2>

                            <p>Es un sencillo plugin JQuery que se encarga de crear configurar un input de tipo file basado en las configuraciones provistas por digitalizacion.</p>
                            <p>Las opciones para este plugin son:</p>
                            <pre>
{
    expediente      : 'Expediente', 
    name:           : 'Nombrezuculento'
    tipdoc          : 'Tipo de documento',
    skDocumento     : 'Char 36 de documento digitalizacion',
    selector        : '[{ Metadatos suzulentos para seleccionar documento(s)}]',
    dropzoneConfig  : { objeto de configuracion de dropzone.}
    allowDelete     : true|false // Permite eliminar documentos,
    deleteCallBack  : function(e){ console.log('Funcion opcional pa despues del deleteo intenso'); }
}                              

                            </pre>
                            
                            <p>Tanto si es archivo multiple o unico, se crea un objeto :</p>
                            <code>window.digiInputs.name</code><br>
                            <p>La llave <i> name</i> contiene un objeto con la funcion <i><b>getInputFile</b></i> la cual retorna 3 posibles valores: </p>
                            <br>
                            <ul>
                                <li>Array de objetos file</li>
                                <li>Objeto file</li>
                                <li>False</li>
                            </ul>

                        </div>

                        <div class="tab-pane dloreanCodeExampleHolder" id="html_DigiInput" role="tabpanel">
                            <pre><code class="html">
                                    <?php echo htmlspecialchars("
<div class=\"col-md-12\" id=\"turboEjemploMultipleDigiInput\" ></div>
<div class=\"col-md-12\" id=\"turboEjemploUnSoloLeFILESAURIO\" ></div>
<div class=\"col-md-12\" id=\"turboEjemploERRORDELAPTAMADRE\" ></div>"); ?>
                       </code></pre>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="js_DigiInput" role="tabpanel">
                            <pre><code class="javascript">
                                    <?php echo htmlspecialchars("
$('#turboEjemploMultipleDigiInput').digiInput({
    expediente : 'PREV',
    name:'zukistrukastico',
    tipdoc : 'FCOM',
    selector : '[{\"clave\":\"ORIGEN\",\"valor\":\"PREV\"},{\"clave\":\"EXPEDI\",\"valor\":\"PREV\"},{\"clave\":\"IDPSRV\",\"valor\":\"153ECE51-1C77-4D5E-94EF-280BE675DC50\"},{\"clave\":\"TIPDOC\",\"valor\":\"FCOM\"}]',
    allowDelete: true,
    deleteCallBack : function(xd){
        console.info('Funcion de llamada Pa traztl', xd);
    }
});

$('#turboEjemploUnSoloLeFILESAURIO').digiInput({
    expediente : 'GRAN',
    name:'fantabulosotl',
    tipdoc : 'PEDS',
    skDocumento : '782D11BE-2B15-47B8-8288-B04972DFD1E0',
    allowDelete: false
});

$('#turboEjemploERRORDELAPTAMADRE').digiInput({
    expediente : 'UFFFMEN',
    name:'ipsofactoso',
    tipdoc : 'AQUETRUENAWE',
    selector : 'Pa que me molesto en esto... ',
    allowDelete: true
});"); ?>
                            </code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="col-md-12 dloreanExample" id="dloreanExamplePDF">

        <div class="col-md-5">
            <h2 style="text-align: center;">PDF</h2>
            <div class="col-md-12" style="height: 180px;">
                <button type="button" class="btn btn-primary btn-block"  style="height: 180px;" id="uniquePDF" ><b>Descargar PDF</b></button>
            </div>
            <div class="col-md-12" style="height: 180px;">
                <button type="button" class="btn btn-primary btn-block"  style="height: 180px;" id="multiPDF" ><b>Descargar PDF Multiple</b></button>
            </div>
        </div>

        <div class="col-md-7">

            <div class="example-wrap">
                <div class="nav-tabs-horizontal" >
                    <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                        <li class="active" role="presentation"><a data-toggle="tab" href="#info_PDF" aria-controls="info_PDF" role="tab">Info</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#php_PDFUNICO" aria-controls="php_PDFUNICO" role="tab">PHP Unico</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#php_PDFMultiple" aria-controls="php_PDFMultiple" role="tab">PHP Multiple</a></li>                    
                    </ul>

                    <div class="tab-content padding-top-20">
                        <div class="tab-pane active" id="info_PDF" role="tabpanel">
                            <h2>¿Que es ?</h2>
                            <p>Es una funcion del core que sirve de interfaz de la clase mpdf, recibe un array de configuracion y retorna un archivo pdf.</p>
                            <p>La funcion acepta un arreglo asociativo de configuracion o bien un array de arreglos de configuracion, en caso de esto ultimo la funcion retornara un archivo con la configuracion de pagina del primero:</p>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="php_PDFUNICO" role="tabpanel">
                            <pre><code class="php">
<?php echo htmlspecialchars("
/* PDF unico.
 * Puedes incluir html de vistas externas preprocesadas con php asi :

ob_start();
\$this->load_view('nomi_format_pdf', ['array' => 'de datinis'], NULL, false);
\$objects = ob_get_contents();
ob_end_clean(); 

 * Ahora  \$objects es una cadena de texto con html de la vista y la puedes
 * incluir en la configuracion de  ~~content~~
*/

\$this->pdf([
    'waterMark' => [
        'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
        'opacity' => .05,
        'size' => [100, 90]
    ],
    'content' => '<b>Uff men este es un PE DE EFE de array UNICO.</b>',
    'pdf' => [
        // <-  ->?  ^ 
        'contentMargins' => [15, 15, 25, 25],
        'format' => 'Letter',
        'footerMargin' => 5,
        'headerMargin' => 5,
        'directDownloadFile' => true,
        'fileName' => 'Le pedeefe unico no multiple.pdf'
    ]
]);"); ?>
                            </code></pre>
                        </div>
                        <div class="tab-pane dloreanCodeExampleHolder" id="php_PDFMultiple" role="tabpanel">
                            <pre><code class="php">
<?php echo htmlspecialchars("
\$this->pdf([[
        'waterMark' => [
            'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
            'opacity' => .05,
            'size' => [100, 90]
        ],
        'content' => '<b>HABEMUS WEA!.</b>',
        'pdf' => [
            // <-  ->?  ^ 
            'contentMargins' => [15, 15, 25, 25],
            'format' => 'Letter',
            'vertical' => false,
            'footerMargin' => 5,
            'headerMargin' => 5,
            'directDownloadFile' => true,
            'fileName' => 'LE multipletltltltltlt.pdf'
        ]
    ],[
        'content' => '<b>SISISISSIISISISIS BUENO NO....2 </b>',
        'header' => '<div>Hider personalizado futer default </div>',
        'defaultHeader' => true,
        'footer' => false,
        'pdf' => [

            'contentMargins' => [15, 15, 25, 25],
            'format' => 'Letter-L',
            'vertical' => true,
            'footerMargin' => 5,
            'headerMargin' => 5,
        ]
    ],[
        'waterMark' => [
            'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
            'opacity' => .09,
            'size' => [100, 90]
        ],
        'content' => '<b>HIDER Y FUTER PERSONALIXAO </b>',
        'header' => '<div>Tu mama</div>',
        'footer' => '<div>No es tu mama</div>',
        'defaultFooter' => false ,
        'defaultHeader' => false ,
        'pdf' => [
            // <-  ->?  ^ 
            'contentMargins' => [15, 15, 25, 25],
            'format' => 'Letter',
            'vertical' => false,
            'footerMargin' => 5,
            'headerMargin' => 5
        ]
    ],[
        'waterMark' => [
            'imgsrc' => CORE_PATH . 'assets/tpl/images/logoOriginal.png',
            'opacity' => .09,
            'size' => [100, 90]
        ],
        'content' => '<b>Solo futer perzonalizado 444444   NO 24  <br> El hijo del papá</b>',
        'footer' => '<div>Ufff men tengo pie de atleta... no de chef.</div>',
        'defaultFooter' => false,
        'pdf' => [
            // <-  ->?  ^ 
            'contentMargins' => [15, 15, 25, 25],
            'format' => 'Letter',
            'vertical' => false,
            'footerMargin' => 5,
            'headerMargin' => 5
        ]
    ],[

        'content' => '<b>NO MARCA DE AGUA PERRRAS!</b>',
        'defaultWatermark' => false,
        'pdf' => [
            // <-  ->?  ^ 
            'contentMargins' => [15, 15, 25, 25],
            'format' => 'Letter',
            'vertical' => true,
            'footerMargin' => 5,
            'headerMargin' => 5
        ]
    ],[

        'content' => '<b>Con marca que es de agua! No de grasa, no de arena. <br> DE AGUA </b>',
        'pdf' => [
            // <-  ->?  ^ 
            'contentMargins' => [15, 15, 25, 25],
            'format' => 'Letter',
            'vertical' => true,
            'footerMargin' => 5,
            'headerMargin' => 5
        ]
    ] ]);"); ?>
                            </code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/js/highlight/highlight.js"></script>

<script>

        $("a").click(function (event) {
            event.preventDefault();
        });

        $('.dloreanExample').hide();
        $('#backListButton').hide();

        function showList() {
            $('#xascIndice').show(500);
            $('.dloreanExample').hide();
            $('#backListButton').hide();
        }

        function hideList() {
            $('#xascIndice').hide(500);
            $('#backListButton').show();
        }

        function streamingShow() {
            hideList();
            $('#dloreanExampleStreamingContainer').show();
            $('.dloreanCodeExampleHolder > pre code').each(function (i, block) {
                hljs.highlightBlock(block);
            });

            $('#limpiarStreamingDisplay').click(function () {
                $('#streamDloreanDisplay').empty();
            });
            $('#iniciarStreaming').click(function (e) {
                e.stopPropagation();

                if ($("#iniciarStreaming").is(":disabled")) {
                    return;
                }

                $('#iniciarStreaming').prop('disabled', true);

                $('#streamDloreanDisplay').empty();

                if (!window.XMLHttpRequest) {
                    console.error("Tu navegador no soporta XMLHttpRequest nativo.");
                    return;
                }

                try {
                    var xhr = new XMLHttpRequest();
                    xhr.previous_text = '';

                    xhr.onerror = function () {
                        console.info("[XHR] Fatal Error.");
                    };

                    xhr.onreadystatechange = function () {
                        try {

                            if (xhr.readyState === 4) {
                                $('#streamDloreanDisplay').append('<p>' + 'Streaming terminado' + '</p>');
                                $('#iniciarStreaming').prop('disabled', false);
                            }

                            if (xhr.readyState > 2) {
                                var new_response = xhr.responseText.substring(xhr.previous_text.length);
                                $('#streamDloreanDisplay').append(new_response + '<br>');
                                xhr.previous_text = xhr.responseText;
                            }
                        } catch (e) {
                        }
                    };

                    xhr.open("GET", window.location.href + "?axn=longProcesWithStreamingExample", true);
                    xhr.send();

                } catch (e) {
                    console.error("Stream fallido");
                }

            });

        }

        function chronoShow() {
            hideList();
            $('#dloreanExampleChronoContainer').show();

            $('#chronTest').click(function (e) {
                e.stopPropagation();

                if ($("#chronTest").is(":disabled")) {
                    return;
                }

                $('#chronTest').prop('disabled', true);

                $.ajax({
                    url: window.location.href,
                    type: "POST",
                    data: {axn: 'ChronoShow'},
                    dataType: 'text',
                    async: true,
                    success: function (res) {
                        $('#chronArrayRepresentation').empty().append(res);
                        $('#chronTest').prop('disabled', false);
                    }
                });

            });

            $('#limpiarChronoDisplay').click(function () {
                $('#chronArrayRepresentation').empty();
            });
        }

        function excelExample() {
            hideList();
            $('#dloreanExampleExcelFunction').show();
            $('#excelTestButton').click(function (e) {
                core.download(window.location.href, 'POST', {axn: 'excelExample'});
                e.stopPropagation();
            });
        }

        function autocompleteExample() {

        }

        function pdfExample() {
            hideList();
            $('#dloreanExamplePDF').show();
            
            $('.dloreanExamplePDF > pre > code').each(function (i, block) {
                hljs.highlightBlock(block);
            });
            
            $('#uniquePDF').click(function (e) {
                core.download(window.location.href, 'POST', {axn: 'uniPEDEEFE'});
                e.stopPropagation();
            });
            
            $('#multiPDF').click(function (e) {
                core.download(window.location.href, 'POST', {axn: 'multiPEDEEFE'});
                e.stopPropagation();
            });
            
        }


        $(document).ready(function () {

            $('#digiInputExample').click(function () {
                hideList();
                $('#dloreanExampleDigiInputl').show();
                $('.dloreanExampleDigiInputl > pre code').each(function (i, block) {
                    hljs.highlightBlock(block);
                });
                $('#turboEjemploMultipleDigiInput').digiInput({
                    expediente: 'PREV',
                    name:'zukistrukastico',
                    tipdoc: 'FCOM',
                    selector: '[{"clave":"ORIGEN","valor":"PREV"},{"clave":"EXPEDI","valor":"PREV"},{"clave":"IDPSRV","valor":"153ECE51-1C77-4D5E-94EF-280BE675DC50"},{"clave":"TIPDOC","valor":"FCOM"}]',
                    allowDelete: true,
                    deleteCallBack: function (xd) {
                        console.info('Funcion de llamada Pa traztl', xd);
                    }
                });
                $('#turboEjemploUnSoloLeFILESAURIO').digiInput({
                    expediente: 'GRAN',
                    name:'fantabulosotl',
                    tipdoc: 'PEDS',
                    skDocumento: 'A33CAA35-AE87-4B5A-9BA6-A43F4C168C4F',
                    allowDelete: true
                });
                $('#turboEjemploERRORDELAPTAMADRE').digiInput({
                    expediente: 'UFFFMEN',
                    name:'ipsofactoso',
                    tipdoc: 'AQUETRUENAWE',
                    selector: 'Pa que me molesto en esto... ',
                    allowDelete: true
                });
            });


        });


</script>