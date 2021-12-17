<?php

/**
 * Trait de funciones del DLOREAN
 *
 * Este trait contiene funciones no criticas del nucleo que son
 * reutilizables en cual quier sitio, SIMON CAMION.
 *
 * @author DLOREAN Team
 */
trait DLOREAN_Functions {

    public $pusherInstance = false;

    /**
     * pdf
     *
     * Genera un archivo PDF a partir de un array asociativo con las siguientes claves y valores:
     *
     * <pre>
     * &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>footer</i></b>] => text/html|FALSE| NO DEFINIR
     * &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>header</i></b>] => text/html|FALSE| NO DEFINIR
     * </pre>
     *
     * <p><i>header</i> y <i>footer</i> se comportan distinto dependiendo de su valor:
      <ul>
      <li>text/html       => Se establece html provisto por usuario. </li>
      <li>FALSE   => Se establece contenido vacio.</li>
      <li>NO DEFINIR     => Se establece un contenido por defecto</li>
      </ul>
     * </p>
     *
     * <pre>
      &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>content</i></b>]   => text/html
      &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>css</i></b>]       => text/css|RUTA ABSOLUTA DE ARCHIVO
      &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>waterMark</i></b>] => Array(
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>imgsrc</i>]  => RUTA ABSOLUTA A IMAGEN
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>opacity</i>] => Float de 0.0 a 1.0
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>size</i>]    => D|P|F|INT|[ancho,alto]
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>place</i>]   => P|F|[int X,int Y]
      &nbsp;&nbsp;&nbsp;&nbsp)
     * </pre>
     *
     * <p><b><i>waterMark</i></b><br> Puedes no declarar esta propiedad para omitirla<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;<i>size</i>:
     * <ul>
     *  <li>'D' => Default del la imagen</li>
     *  <li>'P' => Redimensiona para abarcar toda la pagina, mantiene relacion de aspecto</li>
     *  <li>'F' => Redimensiona para abarcar toda el area de impresion, mantiene relacion de aspecto</li>
     *  <li>int => Redimensiona a un tamaño en milimetros, mantiene relacion de aspecto</li>
     *  <li>[ancho,alto] => Redimensionar en milimetros.</li>
     * </ul>
     * &nbsp;&nbsp;&nbsp;&nbsp;<i>place</i>:
     * <ul>
     *  <li>'D' => Default del la imagen</li>
     *  <li>'F' => Redimensiona para abarcar toda el area de impresion, mantiene relacion de aspecto</li>
     *  <li>[ancho,alto] => Redimensionar en milimetros.</li>
     * </ul>
     * </p>
     *
     * <pre>
     * &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>protection</i></b>] => Array(
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>permissions</i>] => ['Accion permitida ' ....]
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>userPass</i>]    => Clave de usuario, puede estar en blanco.
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>ownerPass</i>]   => Clave de propietario, puede estar en blanco.
     * &nbsp;&nbsp;&nbsp;&nbsp)
     * </pre>
     *
     * <p>&nbsp;&nbsp;&nbsp;&nbsp;<i>permissions</i>:
     * <ul>
     *  <li>copy</li>
     *  <li>print</li>
     *  <li>modify</li>
     *  <li>annot-forms</li>
     *  <li>fill-forms</li>
     *  <li>extract</li>
     *  <li>assemble</li>
     *  <li>print-highres</li>
     * </ul>
     * </p>
     *
      <pre>
      &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>pdf</i></b>] => Array(
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>contentMargins</i>] => [int izquierda, int ferecha, int arriba, int abajo]
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>format</i>] => LETTER
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>vertical</i>] => TRUE | FALSE
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>footerMargin</i>] => 5
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>headerMargin</i>] => 5
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>font-size</i>] => 12
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>font</i>] => Times
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>directDownloadFile</i>] => TRUE | FALSE
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<i>fileName</i>] => Nombre.pdf
      &nbsp;&nbsp;&nbsp;&nbsp;)
      </pre>
     *
     * <p> Esta funcion tambien acepta un array de arreglos de configuracion, lo que creara
     * un solo archivo, se tomará el primer arreglo como la configuracion por defecto de todo
     * el archivo, puede que no quieras eso en todas las paginas, a si que puedes agregar las
     * siguientes claves y valores en su configuracion:
     * </p>
     *
     * <pre>
     * &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>defaultWatermark</i></b>] => TRUE | FALSE
     * &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>defaultHeader</i></b>] => TRUE | FALSE
     * &nbsp;&nbsp;&nbsp;&nbsp;[<b><i>defaultFooter</i></b>] => TRUE | FALSE
     * </pre>
     *
     * @author Samuel Perez <sperez@woodward.com.mx>
     * @link https://mpdf.github.io/ Documentacion completa de mpdf
     * @param array $arg
     * @return boolean|file
     */
    public function pdf(array $arg) {

        if (array_keys(array_keys($arg)) !== array_keys($arg)) {
            return $this->_pdf($arg);
        }

        $mainPDF = array_shift($arg);
        $mainPDF['forceInstanceReturn'] = true;

        $mainPDF['header'] = ($mainPDF['header'] === false ) ? '
                    <div class="pdf_cabecera">
                        <div class="pdf_left"><img style=""  src="' . IMAGE_LOGO_PDF . '" width="120"></div>
                        <div class="pdf_centro">
                          <h3>Documento</h3>
                        </div>
                        <div class="leFlotar"></div>
                      </div>' : $mainPDF['header'];

        $mainPDF['footer'] = ($mainPDF['footer'] === false ) ? '<div class="pdf_cabecera" style="color:gray">
                        <div class="pdf_left">
                            <div class="pdf_fontStyle">' . COMPANY . '</div>
                            <div class="pdf_fontStyle">' . date_format(new DateTime(), 'd/m/Y H:i:s') . '</div>
                        </div>
                        <div class="pdf_centro pdf_fontStyle">' . SYS_URL . '</div>
                        <div class="pdf_left fpag pdf_fontStyle">Página {PAGENO} de {nb} </div>
                    </div>' : $mainPDF['footer'];

        $mainInstance = $this->_pdf($mainPDF);
        //$mainInstance->SetImportUse();

        foreach ($arg as $otherPDF) {

            if (empty($otherPDF)) {
                continue;
            }

            $leNameTMP = sha1($mainPDF['pdf']['fileName'] . (string) microtime(true) . rand(0, 2024)) . '.pdf';
            $otherPDF['tempForce'] = $leNameTMP;
            $this->_pdf($otherPDF);
            $pagecount = $mainInstance->SetSourceFile(TMP_HARDPATH . $leNameTMP);

            for ($i = 1; $i <= $pagecount; $i++) {
                $l = (!$otherPDF['pdf']['vertical']) ? 'L' : 'P';
                $mainInstance->AddPage($l);
                $mainInstance->showWatermarkImage = (isset($otherPDF['defaultWatermark'])) ? $otherPDF['defaultWatermark'] : true;

                if (isset($otherPDF['defaultHeader']) && !$otherPDF['defaultHeader']) {
                    $mainInstance->SetHTMLHeader('<div></div>', '', true);
                } else {
                    $mainInstance->SetHTMLHeader((!empty($otherPDF['header']) ? $otherPDF['header'] : $mainPDF['header']), '', true);
                }

                if (isset($otherPDF['defaultFooter']) && !$otherPDF['defaultFooter']) {
                    $mainInstance->SetHTMLFooter('<div></div>', '', true);
                } else {
                    $mainInstance->SetHTMLFooter((!empty($otherPDF['footer']) ? $otherPDF['footer'] : $mainPDF['footer']), '', true);
                }

                $import_page = $mainInstance->ImportPage($i);
                $mainInstance->UseTemplate($import_page);
            }

            unlink(TMP_HARDPATH . $leNameTMP);
        }


        if (isset($mainPDF['pdf']['location']) && is_string($mainPDF['pdf']['location'])) {
            $mainInstance->Output($mainPDF['pdf']['location'] . $mainPDF['pdf']['fileName'], 'F');
            return true;
        }

        if (isset($mainPDF['pdf']['directDownloadFile']) && $mainPDF['pdf']['directDownloadFile'] == true) {
            $mainInstance->Output($mainPDF['pdf']['fileName'], 'D');
        }

        $mainInstance->Output($mainPDF['pdf']['fileName'], 'I');
    }

    protected function _pdf(array $arg) {
        require_once CORE_PATH . 'assets/vendor/autoload.php';

        $defaultCss = false;
        $defaultContent = array(// <editor-fold defaultstate="collapsed" desc="Default Cont">


            'CSS' => '
                    body{
                        color:#2b2b2b;
                        font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
                    }
                    .pdf_cabecera{
                        height: 52px;
                        width: 100%;
                        margin: 0px 0px 0px 0px;
                        padding: 0px 0px 0px 0px;
                        float:left;
                    }
                    .pdf_centro{
                        text-align:center;
                        width:69%;
                        float:left;
                    }
                    .pdf_left{
                        width:15%;
                        float: left;
                    }
                    .pdf_right{
                        width:15%;
                        float: left;
                    }
                    .fpag {
                        width:14%;
                    }
                    .pdf_fontStyle{
                        font-weight: bold;
                        font-size:10px;
                        text-align:center;
                    }
                    .margin-top{
                        margin-top: 5px;
                    }
                    .borde{
                        border: .5px solid red;
                    }
                    .border{
                        border: .5px solid #757575;
                    }
                    .border-top{
                        border-top: .5px solid #757575;
                    }
                    .border-bottom{
                        border-bottom: .5px solid #757575;
                    }
                    .border-right{
                        border-right: .5px solid #757575;
                    }
                    .border-left{
                        border-left: .5px solid #757575;
                    }
                    .bold{
                        font-weight: bold;
                        float: left;
                    }
                    .pull-down{
                        position: absolute;
                        bottom: 120px;
                    }
                    .pull-right{
                        float: right;
                    }
                    .pull-left{
                        float: left;
                    }
                    table{
                        border: none;
                        float: left;
                    }
                    .text-left{
                        text-align: left;
                    }
                    .text-center{
                        text-align: center;
                    }
                    .text-right{
                        text-align: right;
                    }
                    .text-justify{
                        text-align: justify;
                    }

                    .table-bordered {
                        border: 1px solid #ddd !important;
                    }

                    .table-bordered > thead{
                        border: 1px solid #ddd;
                    }
                    .clearfix{
                        width:  95%;
                        margin-top: 15px;
                        min-height: 15px;
                        float: left;
                    }
                    .col-md-1{
                        width: 8.333333333%;
                        float: left;
                    }
                    .col-md-2{
                        width: 16.666666666%;
                        float: left;
                    }
                    .col-md-3{
                        width: 24.999999999%;
                        float: left;
                    }
                    .col-md-4{
                        width: 33.333333332%;
                        float: left;
                    }
                    .col-md-5{
                        width: 41.666666665%;
                        float: left;
                    }
                    .col-md-6{
                        width: 49.999999998%;
                        float: left;
                    }
                    .col-md-7{
                        width: 58.333333331%;
                        float: left;
                    }
                    .col-md-8{
                        width: 66.666666664%;
                        float: left;
                    }
                    .col-md-9{
                        width: 74.999999997%;
                        float: left;
                    }
                    .col-md-10{
                        width: 83.33333333%;
                        float: left;
                    }
                    .col-md-11{
                        width: 91.666666663%;
                        float: left;
                    }
                    .col-md-12{
                        width: 99.999999996%;
                        float: left;
                    }
                    .col-md-offset-1{
                        margin-left:  4%;
                    }
                    .col-md-offset-2{
                        margin-left:  12%;
                    }
                    .col-md-offset-3{
                        margin-left:  20%;
                    }
                    .col-md-offset-4{
                        margin-left:  29%;
                    }
                    .col-md-offset-5{
                        margin-left:  37%;
                    }
                    .col-md-offset-6{
                        margin-left:  45%;
                    }
                    .col-md-offset-7{
                        margin-left:  54%;
                    }
                    .col-md-offset-8{
                        margin-left:  62%;
                    }
                    .col-md-offset-9{
                        margin-left:  70%;
                    }
                    .col-md-offset-10{
                        margin-left:  79%;
                    }
                    .col-md-offset-11{
                        margin-left:  87%;
                    }
                    .col-md-offset-12{
                        margin-left:  95%;
                    }
                    ',
            'header_HTML' => '
                    <div class="pdf_cabecera">
                        <div class="pdf_left"><img style=""  src="' . IMAGE_LOGO_PDF . '" width="120"></div>
                        <div class="pdf_centro">
                          <h3>Documento</h3>
                        </div>
                        <div class="leFlotar"></div>
                      </div>',
            'footer_HTML' => '
                    <div class="pdf_cabecera" style="color:gray">
                        <div class="pdf_left">
                            <div class="pdf_fontStyle">' . COMPANY . '</div>
                            <div class="pdf_fontStyle">' . date_format(new DateTime(), 'd/m/Y H:i:s') . '</div>
                        </div>
                        <div class="pdf_centro pdf_fontStyle">' . SYS_URL . '</div>
                        <div class="pdf_left fpag pdf_fontStyle">Página {PAGENO} de {nb} </div>
                    </div>'
                // </editor-fold>
        );

        $a = $arg["pdf"];
        $leLandskapetl = (isset($a['vertical']) && !$a['vertical']) ? '-L' : '';

        if (!$a) {
            return false;
        }

        $mpdf = new Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => (isset($a['format']) && is_array($a['format']) ? $a['format'] : $a['format'].$leLandskapetl), //Formato y orientacion
            'orientation' => 'P', //Formato y orientacion
            'default_font_size' => (isset($a['font-size'])) ? $a['font-size'] : 12, //Tamaño default
            'default_font' => (isset($a['font'])) ? $a['font'] : 'Times', //Fuente default
            'margin_left' => $a['contentMargins'][0], //Margen izq
            'margin_right' => $a['contentMargins'][1], //Margen der
            'margin_top' => $a['contentMargins'][2], //Margen arriba
            'margin_bottom' => $a['contentMargins'][3], //Margen abajo
            'margin_header' => $a['headerMargin'], //Margen header
            'margin_footer' => $a['footerMargin'] //Margen footer
        ]);

        if (isset($arg['protection']) && is_array($arg['protection'])) {
            $prot = &$arg['protection'];
            $mpdf->SetProtection($prot['permissions'], $prot['userPass'], $prot['ownerPass'], 128);
        }

        if (isset($arg['existingFile']) && !empty($arg['existingFile']) && file_exists($arg['existingFile'])) {
            //$mpdf->SetImportUse();
            $pagecount = $mpdf->SetSourceFile($arg['existingFile']);
            for ($i = 1; $i <= $pagecount; $i++) {
                $import_page = $mpdf->ImportPage($i);
                $mpdf->UseTemplate($import_page);
                if ($i < $pagecount) {
                    $mpdf->AddPage();
                }
            }
        }

        /* $mpdf->WriteHTML(
          file_get_contents(CORE_PATH . 'assets/tpl/global/css/bootstrap.min.css'), 1); */

        if (isset($arg["waterMark"]) && is_array($arg["waterMark"])) {

            $w = $arg["waterMark"];

            $mpdf->SetWatermarkImage(
                    $w['imgsrc'], $w['opacity'], $w['size'], (isset($w['place']) ? $w['place'] : 'P')
            );

            $mpdf->showWatermarkImage = true;
        }

        if (isset($arg['css']) && $arg['css'] && file_exists($arg['css'])) {

            $css = file_get_contents($arg['css']);
            $mpdf->WriteHTML($css, 1);
        } elseif(isset($arg['css']) && strlen($arg['css']) > 0) {
            $mpdf->WriteHTML($arg['css'], 1);
        }

        // Estilos Default
        if (!$defaultCss) {
            $mpdf->WriteHTML($defaultContent['CSS'], 1);
            $defaultCss = true;
        }

        if (isset($arg['header'])) {
            if ($arg['header'] != strip_tags($arg['header'])) {
                $mpdf->SetHTMLHeader($arg['header']);
            } else {
                if ($arg['header']) {
                    $mpdf->SetHTMLHeader($defaultContent['header_HTML']);
                } else {
                    $mpdf->SetHTMLHeader('<div></div>');
                }
            }
        } else {
            $mpdf->SetHTMLHeader($defaultContent['header_HTML']);
        }

        if (isset($arg['footer'])) {
            if ($arg['footer'] != strip_tags($arg['footer'])) {
                $mpdf->SetHTMLFooter($arg['footer']);
            } else {
                if ($arg['footer']) {
                    $mpdf->SetHTMLFooter($defaultContent['footer_HTML']);
                } else {
                    $mpdf->SetHTMLFooter('<div></div>');
                }
            }
        } else {
            $mpdf->SetHTMLFooter($defaultContent['footer_HTML']);
        }


        if ($arg['content'] != strip_tags($arg['content'])) {
            $mpdf->WriteHTML($arg['content']);
        } elseif (file_exists($arg['content'])) {
            ob_start();
            require_once($arg['content']);
            $content = ob_get_clean();
            $mpdf->WriteHTML($content);
        }

        //Se escribe contenido

        if (isset($arg['forceInstanceReturn'])) {
            return $mpdf;
        }

        if (isset($arg['tempForce'])) {
            $mpdf->Output(TMP_HARDPATH . $arg['tempForce'], 'F');
            return true;
        }

        if (isset($a['location']) && is_string($a['location'])) {
            $mpdf->Output($a['location'] . $a['fileName'], 'F');
            return true;
        }

        if (isset($a['directDownloadFile']) && $a['directDownloadFile'] == true) {
            $mpdf->Output($a['fileName'], 'D');
        }

        $mpdf->Output($a['fileName'], 'I');
    }

    public function pdfAddText($conf = FALSE) {

      require_once CORE_PATH . 'assets/vendor/autoload.php';


      $mpdf = new Mpdf\Mpdf();
      //$mpdf->SetImportUse();
      $mpdf->SetSourceFile($conf['rutaFinal']);
      $template = $mpdf->ImportPage(1);
      $mpdf->UseTemplate($template);
      if(!empty($conf['WriteText'])){
        $mpdf->SetFont((!empty($conf['family']) ? $conf['family'] : 'Arial'),(!empty($conf['style']) ? $conf['style'] : '') ,(!empty($conf['size']) ? $conf['size'] :12) );

        $mpdf->WriteText((!empty($conf['w']) ? $conf['w'] : 124) ,(!empty($conf['h']) ? $conf['h'] : 6), $conf['texto']);
      }
      if(!empty($conf['WriteCell'])){
        $mpdf->SetXY((!empty($conf['w']) ? $conf['w'] : 124),(!empty($conf['h']) ? $conf['h'] : 6)); 
        $mpdf->SetFont((!empty($conf['family']) ? $conf['family'] : 'Arial'),(!empty($conf['style']) ? $conf['style'] : '') ,(!empty($conf['size']) ? $conf['size'] :12) );

        $mpdf->WriteCell(40,20, $conf['texto'],0,0,'L',true);
          }

      $mpdf->Output($conf['location'] . $conf['fileName'], 'F');

    }
    public function pdfCombineFiles($conf = FALSE) {

      require_once CORE_PATH . 'assets/vendor/autoload.php';


      $mpdf = new Mpdf\Mpdf();
     
      if (!empty($conf['filesNames'])) {

           $filesTotal = sizeof($conf['filesNames']);
           $fileNumber = 1;
        $fileNameDescarga = "comprobantes.pdf";
        if(!empty($conf['outFile'])){
            $fileNameDescarga = $conf['outFile'];
        }
           //$mpdf->SetImportUse();

           /*if (!file_exists($conf['outFile'])) {
               $handle = fopen($conf['outFile'], 'w');
               fclose($handle);
           }*/

		
           foreach ($conf['filesNames'] as $fileName) {
               if (file_exists($fileName)) {

                   $pagesInFile = $mpdf->SetSourceFile($fileName);
                   for ($i = 1; $i <= $pagesInFile; $i++) {
                       $tplId = $mpdf->ImportPage($i);
                       $mpdf->UseTemplate($tplId);
                       if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
                           $mpdf->WriteHTML('<pagebreak />');
                       }
                   }
               }
               $fileNumber++;
           }
            $mpdf->Output($fileNameDescarga, 'D');

       }
    }

    public function pdfToText($conf = FALSE) {

      require_once CORE_PATH . 'src/DLOREAN.pdf2text.php';

      $a = new PDF2Text();
      $a->setFilename($conf['rutaArchivo']);
      $a->decodePDF();
      return $a->output();

    }

    /**
     * Inserta datos de headers
     *
     * Esta funcion es llamada desde una funcion anonima en un array_walk, lo que
     * hace es recivir los datos de cabeceras y escribirlos horizontal o verticalmente
     * en el objeto de PHPExcel
     *
     * @author Samuel Perez  <sperez@woodward.com.mx>
     *
     * @param mixed $item Dato iterado pasado por referencia
     * @param string $hO Define la orientacion de los headers 'H'|'V'
     * @param int $current Indice de pagina actual objetivo
     * @param object $objPHPExcel Objeto de tipo PHPExcel
     * @param string $s Coordenada de columna de hoja de calculo
     * @param integer $in Coordenada de fila de hoja de calculo
     *
     * @return true|false Retorna true si la insercion fue exitosa o false en caso de error
     */
    public function excel_headerSet(&$item, $hO, $current, $objPHPExcel, &$s, &$in) {
        if ($hO === 'H') {

            if (is_array($item)) {

                $objPHPExcel->setActiveSheetIndex($current)
                        ->setCellValue($s . $in, $item['value']);

                $objPHPExcel->getActiveSheet()->getStyle($s . $in)
                        ->applyFromArray($item);

                if (isset($item['merge'])) {
                    $mergeSteps = (int) $item['merge'];
                    $coordRange = $s . $in . ':';

                    for ($imerg = 1; $imerg <= $mergeSteps - 1; $imerg ++) {
                        ++$s;
                    }

                    $coordRange .= $s . $in;

                    $objPHPExcel->getActiveSheet()->mergeCells($coordRange);
                }
            } else {
                $objPHPExcel->setActiveSheetIndex($current)
                        ->setCellValue($s . $in, $item);

                $objPHPExcel->getActiveSheet()->getStyle($s . $in)
                        ->getFont()->setBold(true);

                $objPHPExcel->getActiveSheet()
                        ->getColumnDimension($s)
                        ->setAutoSize(true);
            }

            ++$s;
        } elseif ($hO === 'V') {
            $objPHPExcel->setActiveSheetIndex($current)
                    ->setCellValue($s . $in, $item);

            $objPHPExcel->getActiveSheet()
                    ->getStyle($s . $in)
                    ->getFont()
                    ->setBold(true);
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($s)
                    ->setAutoSize(true);
            $in++;
        } else {
            return false;
        }
        return true;
    }

    /**
     * Imprime datos en archivo Excel
     *
     * Recibe un array con los datos y configuracion de un nuevo archivo en
     * formato de excel, soporta creacion de formatos de .xls y .xlsx. El arrray
     * de datos deberá tener la siguiente estructura:
     * <pre>
     * {
     *  "fileName":"nombreArchivo",
     *  "fileLocation":"",
     *  "format":   "xls|xlsx",
     *  "template": "Ruta absoluta" | No definir
     *  "pages": {
     *      "Pagina1":{
     *          "startAt": "A1",   //Posicion de inicio
     *          "headers": ["Cosa1", "Cosa2" ...],
     *          "headersOrientation": 'H|V'
     *          "data": [['a','b'... ],['c','d'..]... ]
     *       } ...
     *   }
     * }
     * </pre>
     *
     *
     * Para aplicar estilos, tanto en los campos de headers como en datos,
     * reemplaza el valor por un array con esta forma:
     *
     * [
     *  'value' => 'Valor de la celda',
     *  'merge' => 2, //Celdas a fusionar de manera horizontal
     *  'font' => [
     *      'bold' => true,
     *      'italic' => true,
     *      'color' => [ 'rgb' => '00123' ],
     *
     *  ],
     *  'fill' => [
     *      'type' => 'solid' // Definidos en clase: PHPExcel_Style_Fill,
     *      'color' => ['rgb' => 'FF0000']
     *  ]
     * ]
     *
     * <strong>Nota importante:</strong> Si quieres que retorne archivo en vez de
     * guardarlo en una ubicacion, sencillamente no establescas <b>fileLocation</b>
     *
     * Visita los links de ejemplos para ver el codigo en el cual se baso esta
     * funcion.
     *
     * @author Samuel Perez <sperez@woodward.com.mx>
     *
     * @link https://goo.gl/Aoj5cq Pasar variables a funciones anonimas
     * @link https://goo.gl/zpEqnN Funcion anonima en array_walk
     *
     * @link https://goo.gl/xHpWIm Ejemplo para xsl
     * @link https://goo.gl/e6n5Mc Ejemplo para xlsx
     *
     * @param array $data Array con datos y configuracion de nuevo archivo excel
     * @return file|false|true Retorna el archivo o true en caso de exito.
     */
    public function excel($data) {

        /*
         * **************************
         *  PhpOffice\PhpSpreadsheet
         * **************************
         */


        require_once CORE_PATH . 'assets/vendor/autoload.php';
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

        if (!in_array($data['format'], ['xls', 'xlsx']) || $data['format'] === '') {
            exit("Formato no valido " . $data['format']);
        }


        // Crear objeto
        if (isset($data['template']) && !empty($data['template'])) {
            $objReader = PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $objPHPExcel = $objReader->load($data['template']);
        } else {
            $objPHPExcel = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        }

        // Establecer propiedades de documentos
        $objPHPExcel->getProperties()
                ->setCreator("Portal Woodward - " . $_SESSION['usuario']['sNombreUsuario'] . ' ' . $_SESSION['usuario']['sPaterno'] . ' ' . $_SESSION['usuario']['sMaterno'])
                ->setLastModifiedBy($_SESSION['usuario']['sNombreUsuario'] . ' ' . $_SESSION['usuario']['sPaterno'] . ' ' . $_SESSION['usuario']['sMaterno'])
                ->setTitle("Excel Portal")
                ->setSubject("Excel Portal")
                ->setDescription("Excel Portal")
                ->setKeywords("office PhpSpreadsheet php")
                ->setCategory("Excel Portal");

        $n1 = true;
        $i = 0;
        foreach ($data['pages'] as $key => $v) {

            // Obtenemos pagina actualmente activa
            $page = $objPHPExcel->getActiveSheet();
            $noHeader = true;

            if ($n1) {
                $n1 = false;
                $objPHPExcel->getActiveSheet()->setTitle($key);
            } else {
                $page = $objPHPExcel->createSheet($i);
                $objPHPExcel->setActiveSheetIndex($i);
                $objPHPExcel->getActiveSheet()->setTitle($key);
            }

            /* Se establecen las cabeceras */
            $h0 = $v['headersOrientation'];

            if (isset($v['headers']) && is_array($v['headers']) && count($v['headers']) > 0) {

                $s = (is_string($v['startAt']) && strlen($v['startAt']) === 2) ? $v['startAt'][0] : 'A';
                $in = (is_string($v['startAt']) && strlen($v['startAt']) === 2) ? intval($v['startAt'][1]) : 1;

                array_walk($v['headers'], function (&$hvalor, &$hkey)
                        use (&$h0, &$i, &$objPHPExcel, &$s, &$in) {
                    $this->excel_headerSet($hvalor, $h0, $i, $objPHPExcel, $s, $in);
                }
                );
                $noHeader = false;
            }


            /* Se agregan todos los los datos  */
            $fll = true;
            $col = (is_string($v['startAt']) && strlen($v['startAt']) === 2) ? $v['startAt'][0] : 'A';
            $fil = (is_string($v['startAt']) && strlen($v['startAt']) === 2) ? (int) $v['startAt'][1] : 1;


            foreach ($v["data"] as $key => $value) {

                if ($h0 === 'H') {
                    $fil++;
                    array_walk($value, function (&$value, &$key) use (&$objPHPExcel, &$col, &$fil, &$i) {

                        $currentCoord = $col++ . $fil;

                        if (is_array($value)) {

                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue($currentCoord, $value['value']);
                            unset($value['value']);

                            if (isset($value['merge'])) {
                                $mergeSteps = (int) $value['merge'];
                                for ($imerg = 1; $imerg <= $mergeSteps - 1; $imerg ++) {
                                    ++$col;
                                }
                                unset($value['merge']);
                            }

                            $objPHPExcel->getActiveSheet()
                                    ->getStyle($currentCoord)
                                    ->applyFromArray($value);

                            if (isset($mergeSteps)) {
                                $objPHPExcel->getActiveSheet()->mergeCells($currentCoord . ':' . $col . $fil);
                            }
                        } else {
                            $objPHPExcel->setActiveSheetIndex($i)->setCellValue($currentCoord, $value);
                            $objPHPExcel->getActiveSheet()
                                    ->getColumnDimension($col)
                                    ->setAutoSize(true);
                        }
                    });

                    $col = (is_string($v['startAt']) && strlen($v['startAt']) === 2) ? $v['startAt'][0] : 'A';
                }
                if ($h0 === 'V') {

                    if ($fll) {
                        $col = ($noHeader) ? $col : ++$col;
                        $fll = false;
                    }

                    $fil = (is_string($v['startAt']) && strlen($v['startAt']) === 2) ? (int) $v['startAt'][1] : 1;

                    array_walk($value, function (&$vvalor, &$kkey) use (&$objPHPExcel, &$col, &$fil, &$i) {
                        $objPHPExcel->setActiveSheetIndex($i)->setCellValue($col . $fil, $vvalor);
                        $objPHPExcel->getActiveSheet()
                                ->getColumnDimension($col)
                                ->setAutoSize(true);
                        $fil++;
                    });

                    $col++;
                }
            }
            $i++;
        }

        return $this->excel_save($data, $objPHPExcel);
    }

    /**
     * Guardado por archivo temporal
     *
     * Crea un archivo temporal de excel para luego enviarselo al usuario,
     * de esta manera se evitan posibles errores con php://output
     *
     * @author Samuel Perez <sperez@woodward.com.mx>
     * @param type $objWriter
     * @return void Nada
     */
    public static function SaveViaTempFile($objWriter) {
        $filePath = TMP_HARDPATH . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }

    /**
     * Guarda archivo excel
     *
     * Guarda datos procesados como archivo fisico en formato excel o retorna
     * dicho archivo para descarga directa. se separaron instrucciones de guardado
     * de la funcion excel() con fines de claridad
     *
     * @author Samuel Perez <sperez@woodward.com.mx>
     *
     * @param array $data Datos del excel
     * @param object $objPHPExcel Objeto de datos PHPExcel
     *
     * @return true|false Retorna true en caso de exito, y false en caso de error
     *
     */
    public function excel_save($data, $objPHPExcel) {

        /*
        * **************************
        *  PhpOffice\PhpSpreadsheet
        * **************************
        */

        $floc = (isset($data['fileLocation'])) ? $data['fileLocation'] : FALSE;


        if (isset($floc) && $floc !== '' && is_string($floc)) {

            $objWriter = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
            $f = $floc.$data['fileName'].'.'.$data['format'];
            $objWriter->save($f);
            if(!@chmod($f, 0777)){
                return false;
            }

        } else {

            if(!in_array($data['format'], ['xls','xlsx'])){
                return false;
            }

            if($data['format'] === 'xls'){
                header('Content-Type: application/vnd.ms-excel');
            }elseif($data['format'] === 'xlsx'){
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            }

            // Redirect output to a client’s web browser (Xlsx)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$data['fileName'].'.'.$data['format'].'"');
                header('Set-Cookie: fileDownload=true; path=/');
                header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

            $objWriter = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
            //$objWriter->save('php://output');
            $this->SaveViaTempFile($objWriter);
        }


        return true;
    }

    /**
     * Acomoda filtros de consultas dependiendo del tipo de regla
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     *
     * @param string $colum Columna por la que se desea filtrar
     * @param string $rule Regla por la cual se filtrar
     * @param string $value Valor por el cual se filtrara
     *
     * @return string   Retorna cadena de filtro acomodada
     */
    public function acomodarFiltro($colum, $rule, $value, $type) {
        switch ($rule) {
            case '=':
                if ($type != 'date' && $type != 'dateTime') {
                    $filtro = " " . $colum . " " . $rule . " '" . trim($value) . "' ";
                } else {
                    // MSSQL
                    //$filtro = " datediff(day, " . $colum . ", '" . trim($value) . "') = 0 ";
                    // MySQL
                    $filtro = " datediff(" . $colum . ", '" . trim($value) . "') = 0 ";
                }
                return $filtro;
                break;
            case '>':
                $filtro = " " . $colum . " " . $rule . " '" . trim($value) . "' ";
                return $filtro;
                break;
            case '<':
                $filtro = " " . $colum . " " . $rule . " '" . trim($value) . "' ";
                return $filtro;
                break;
            case 'null':
                $filtro = " " . $colum . " is null";
                return $filtro;
                break;
            case '!=':
                $filtro = " " . $colum . " " . $rule . " '" . $value . "' ";
                return $filtro;
                break;
            case '%LIKE%':
                $filtro = " " . $colum . " LIKE '%" . trim($value) . "%' ";
                return $filtro;
                break;
            case 'NOT LIKE':
                $filtro = " " . $colum . " NOT LIKE '%" . trim($value) . "%' ";
                return $filtro;
                break;
            case 'LIKE%':
                $filtro = " " . $colum . " LIKE '" . trim($value) . "%' ";
                return $filtro;
                break;
            case '%LIKE':
                $filtro = " " . $colum . " LIKE '%" . trim($value) . "' ";
                return $filtro;
                break;
            case 'BETWEEN':
                $value = explode(",", $value);
                $filtro = " " . $colum . " BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $value[0]))) . "' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $value[1]))) . "' ";
                return $filtro;
                break;
        }
        return false;
    }

    /**
     * Crea filtros para una consulta
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     */
    public function crear_filtros(){
        if(isset($_POST['filters']) && is_array($_POST['filters'])){
            $filtro = '';
            foreach ($_POST['filters'] as $key => $value) {
                $valorFiltro = $value['value'];
                if (($value['type'] == 'date' && $value['rule'] != 'BETWEEN') || ($value['type'] == 'dateTime' && $value['rule'] != 'BETWEEN')) {
                    $valorFiltro = date('Y-m-d', strtotime(str_replace('/', '-', $value['value'])));
                }
                $condicion = $this->acomodarFiltro($value['column'], $value['rule'], $valorFiltro, $value['type']);
                $filtro .= ($filtro ? " AND " . $condicion : $condicion);
            }
            if(!empty($filtro)){
                $filtro = ($filtro ? " AND ( " . $filtro . " ) " : "");
            }
            return $filtro;
        }else{
            return FALSE;
        }

    }

    /**
     * Crea consulta
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     */
    public function crear_consulta($consulta) {
        $filtro = "";
        $distinto = "";
        $conexion = "";

        if (isset($consulta['conexion'])) {
            $conexion = $consulta['conexion'];
        }
        /*if(!isset($_POST['filters'])){
            $queryFiltros="SELECT * FROM rel_usuariosFiltros_modulos WHERE skUsuarioCreacion = '".$_SESSION['usuario']['skUsuario']."' AND skModulo = '".$this->sysController."' AND iPredeterminado = 1 ";
            $result = Conn::query($queryFiltros);
            if(!$result){
                return FALSE;
            }
            $Filters = Conn::fetch_assoc($result);
            $arrayFilters = json_decode($Filters['sJsonFiltro'],true);
            $_POST['filters'] = $arrayFilters;
        }*/
        if (isset($_POST['filters'])) {
            if ($_POST['filters'] != 'single') {
                if (!is_array($_POST['filters'])) {
                    $_POST['filters'] = json_decode($_POST['filters'], true);
                }
                foreach ($_POST['filters'] as $key => $value) {
                    $valorFiltro = $value['value'];
                    if (($value['type'] == 'date' && $value['rule'] != 'BETWEEN') || ($value['type'] == 'dateTime' && $value['rule'] != 'BETWEEN')) {
                        $valorFiltro = date('Y-m-d', strtotime(str_replace('/', '-', $value['value'])));
                    }
                    $condicion = $this->acomodarFiltro($value['column'], $value['rule'], $valorFiltro, $value['type']);
                    $filtro .= ($filtro ? " AND " . $condicion : $condicion);
                }
            }
            if ($_POST['filters'] == 'single') {
                // QUERY DEL FILTRO
                $distinto = " DISTINCT " . $_POST['column'] . "";
                $filtro = " " . $_POST['column'] . " LIKE '%" . $_POST['value'] . "%'";
            }
        }
        if (!$distinto) {


            $sql = "SELECT " . ($distinto ? $distinto : '*') . " FROM ( " . $consulta['query'] . " ) Q1 WHERE 1 = 1 ";
            $sql .= ($filtro ? " AND ( " . $filtro . " ) " : "");

            if (isset($_POST['generarExcel']) || isset($_POST['envioAutomatico'])) {
                $columnaOrdenado = $_POST['order'];
                $sql .= " ORDER BY Q1." . $columnaOrdenado . " " . $_POST['orderDir'];
            } else {
                $sql.="ORDER BY ";
                if(isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])){
                    $primerOrdenado = $_POST['columns'][($_POST['order'][0]['column'] ? $_POST['order'][0]['column'] : 0)]['data'];
                    $sql.=$primerOrdenado . " " . $_POST['order'][0]['dir'];
                }
                if(isset($_POST['order'][1]['column'])&& isset($_POST['order'][1]['dir'])){
                    $segundoOrdenado = $_POST['columns'][($_POST['order'][1]['column'] ? $_POST['order'][1]['column'] : 1)]['data'];
                    $sql.=",".$segundoOrdenado . " " . $_POST['order'][1]['dir'];
                }
                if(isset($_POST['order'][2]['column'])&& isset($_POST['order'][2]['dir'])){
                    $tercerOrdenado = $_POST['columns'][($_POST['order'][2]['column'] ? $_POST['order'][2]['column'] : 2)]['data'];
                    $sql.=",".$tercerOrdenado . " " . $_POST['order'][2]['dir'];
                }



            }

            if (isset($consulta['log']) && $consulta['log'] == true) {
                $this->log($sql, TRUE);
            }

            if (!$conexion) {
                $resultTotal = Conn::query($sql);
            } else {
                $resultTotal = Conn::query($sql, $conexion);
            }

            if(is_array($resultTotal) && isset($resultTotal['success']) && $resultTotal['success'] == false){
                $resultTotal['draw'] = isset($_POST['draw']) ? $_POST['draw'] : 0;
                $resultTotal['recordsTotal'] = 0;
                $resultTotal['recordsFiltered'] = 0;
                $resultTotal['data'] = [];
                $resultTotal['filters'] = false;
                return $resultTotal;
            }

            $total = count($resultTotal->fetchall());
            $resultTotal->closeCursor();

            if (!isset($_POST['generarExcel']) && !isset($_POST['envioAutomatico'])) {
                $length = (isset($_POST['length']) ? $_POST['length'] : '');
                $start = (isset($_POST['start']) ? $_POST['start'] : '');
                $sql .= " LIMIT " . $start . " ," . $length . "  ";
            }
            //exit($sql);
            if (!$conexion) {
                $result = Conn::query($sql);
            } else {
                $result = Conn::query($sql, $conexion);
            }

            if(is_array($result) && isset($result['success']) && $result['success'] == false){
                $result['draw'] = isset($_POST['draw']) ? $_POST['draw'] : 0;
                $result['recordsTotal'] = 0;
                $result['recordsFiltered'] = 0;
                $result['data'] = [];
                $result['filters'] = false;
                return $result;
            }
            
            $data = array(
                'draw' => isset($_POST['draw']) ? $_POST['draw'] : 0,
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $result,
                'filters' => false
            );
            return $data;
        } else {
            $sql = "SELECT " . ($distinto ? $distinto : '*') . " FROM ( " . $consulta['query'] . " ) Q1 WHERE 1 = 1 ";
            $sql .= ($filtro ? " AND ( " . $filtro . " ) " : "");
            $sql .= " ORDER BY Q1." . $_POST['column'];
            
            if (!$conexion) {
                $result = Conn::query($sql);
            } else {
                $result = Conn::query($sql, $conexion);
            }
            
            if(is_array($result) && isset($result['success']) && $result['success'] == false){
                return $result;
            }
            
            $data = array('data' => array(array(), array()), 'filters' => true);
            while ($row = Conn::fetch_assoc($result)) {
                utf8($row, FALSE);

                if ($row[$_POST['column']] === 'null') {
                    continue;
                }
                array_push($data['data'][0], $row[$_POST['column']]);
                $data['data'][1][$row[$_POST['column']]] = $row[$_POST['column']];
            }
            $result->closeCursor();
            array_walk_recursive($data['data'], function(&$item, $key) {
                if ($item == 'null') {
                    $item = NULL;
                }
            });

            return $data;
        }
    }

    /**
     * Menu Emergente
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     */
    public function menuEmergente($Regla, $codigo = '') {

        if (!empty($_SESSION['modulos'][$this->sysController]['menuEmergente'])) {
            $stringMenu = "";
            foreach ($_SESSION['modulos'][$this->sysController]['menuEmergente'] as $key => $value) {
                if ($value['sTitulo'] != '-') {
                    if (isset($Regla["menuEmergente" . $value['iPosicion']]) && is_array($Regla["menuEmergente" . $value['iPosicion']])) {

                        if (isset($Regla["menuEmergente" . $value['iPosicion']]['estatus']) && $Regla["menuEmergente" . $value['iPosicion']]['estatus'] != 0) {
                            if ($Regla["menuEmergente" . $value['iPosicion']]['estatus'] == 1) {
                                $stringMenu .= '<li class="disabled"><a><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . (isset($Regla["menuEmergente" . $value['iPosicion']]['estatus']) ? $Regla["menuEmergente" . $value['iPosicion']]['titulo'] : $value['sTitulo']) . '</a></li>';
                            }
                            if ($Regla["menuEmergente" . $value['iPosicion']]['estatus'] == 2) {
                                //$stringMenu.= '<li class="disabled"><a>' . $value['sTitulo'] . '</a></li>';
                            }
                        } else {
                            $slash = '/';
                            /* if (is_array($codigo)) {

                              if (isset($codigo["menuEmergente" . $value['iPosicion']])) {
                              $id = $codigo["menuEmergente" . $value['iPosicion']];
                              $slash = '';
                              } else {
                              $id = $codigo["default"];
                              }
                              } else {
                              $id = $codigo;
                              } */
                            $slash = '/';
                            if (isset($Regla["menuEmergente" . $value['iPosicion']]['id'])) {
                                $id = "";
                                if (is_array($Regla["menuEmergente" . $value['iPosicion']]['id'])) {
                                    $i = 0;
                                    foreach ($Regla["menuEmergente" . $value['iPosicion']]['id'] as $value1) {
                                        if ($i > 0) {
                                            $id .= "/";
                                        }
                                        $id .= $value1;
                                        $i++;
                                    }
                                } else {
                                    $id = $Regla["menuEmergente" . $value['iPosicion']]['id'];
                                }
                            } else {
                                if (is_array($codigo)) {
                                    if (isset($codigo["menuEmergente" . $value['iPosicion']])) {
                                        $id = $codigo["menuEmergente" . $value['iPosicion']];
                                        $slash = '';
                                    } else {
                                        $id = $codigo["default"];
                                    }
                                } else {
                                    $id = $codigo;
                                }
                            }


                            switch ($value['skComportamiento']) {
                                case 'VEMO':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . (isset($Regla["menuEmergente" . $value['iPosicion']]['titulo']) ? $Regla["menuEmergente" . $value['iPosicion']]['titulo'] : $value['sTitulo']) . '</a></li>';
                                    break;
                                case 'PANE':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . (isset($Regla["menuEmergente" . $value['iPosicion']]['titulo']) ? $Regla["menuEmergente" . $value['iPosicion']]['titulo'] : $value['sTitulo']) . '</a></li>';
                                    break;
                                case 'MOWI':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . (isset($Regla["menuEmergente" . $value['iPosicion']]['titulo']) ? $Regla["menuEmergente" . $value['iPosicion']]['titulo'] : $value['sTitulo']) . '</a></li>';
                                    break;
                                case 'RELO':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . (isset($Regla["menuEmergente" . $value['iPosicion']]['titulo']) ? $Regla["menuEmergente" . $value['iPosicion']]['titulo'] : $value['sTitulo']) . '</a></li>';
                                    break;
                                case 'FUNC':
                                    $function = $value['sFuncion'] . "({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . (isset($Regla["menuEmergente" . $value['iPosicion']]['titulo']) ? $Regla["menuEmergente" . $value['iPosicion']]['titulo'] : $value['sTitulo']) . '</a></li>';
                                    break;
                                default:
                            }
                        }
                        /* Agregar Funcionar de Abajo pero con Array en posiciones, Titulo y Estatus. */
                    } else {
                        if (isset($Regla["menuEmergente" . $value['iPosicion']]) && $Regla["menuEmergente" . $value['iPosicion']] != 0) {
                            if ($Regla["menuEmergente" . $value['iPosicion']] == 1) {
                                $stringMenu .= '<li class="disabled"><a><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . $value['sTitulo'] . '</a></li>';
                            }
                            if ($Regla["menuEmergente" . $value['iPosicion']] == 2) {
                                //$stringMenu.= '<li class="disabled"><a>' . $value['sTitulo'] . '</a></li>';
                            }
                        } else {
                            $slash = '/';
                            if (is_array($codigo)) {

                                if (isset($codigo["menuEmergente" . $value['iPosicion']])) {
                                    $id = $codigo["menuEmergente" . $value['iPosicion']];
                                    $slash = '';
                                } else {
                                    $id = $codigo["default"];
                                }
                            } else {
                                $id = $codigo;
                            }


                            switch ($value['skComportamiento']) {
                                case 'VEMO':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . $value['sTitulo'] . '</a></li>';
                                    break;
                                case 'PANE':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . $value['sTitulo'] . '</a></li>';
                                    break;
                                case 'MOWI':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . $value['sTitulo'] . '</a></li>';
                                    break;
                                case 'RELO':
                                    $function = "core.menuLoadModule({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . $value['sTitulo'] . '</a></li>';
                                    break;
                                case 'FUNC':
                                    $function = $value['sFuncion'] . "({skModulo: '" . $value['skModuloPadre'] . "', url: '/" . DIR_PATH . SYS_PROJECT . '/' . $value['skModuloPrincipal'] . '/' . $value['skModuloPadre'] . '/' . $value['sNombreModulo'] . '/' . $id . $slash . "', skComportamiento: '" . $value['skComportamiento'] . "', id: '" . $id . "' });";
                                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '"><a tabindex="-1" role="button" onclick="' . $function . '" id="opc' . $value['iPosicion'] . '"><i class="' . $value['sIcono'] . '" aria-hidden="true"></i> ' . $value['sTitulo'] . '</a></li>';
                                    break;
                                default:
                            }
                        }
                    }
                } else {
                    $stringMenu .= '<li id="opc' . $value['iPosicion'] . '" class="divider"></li>';
                }
            }
            return $stringMenu;
        }
    }

    /**
     * Funcion de envio de correo
     *
     * Esta funcion recibe un array de datos con el cual envia correos electronicos,
     * utilizando la libreria de swiftmailer, la cual puedes leer en los anexos y descargar
     * desde sus repositorios oficiales.
     *
     * <pre>
     *
     * array(
     *     'envioInstantaneo' => true|false Envia el correo al instante,
     *     'fechaProgramacion' => Objeto Datetime
     *     'subject'     => 'Asunto del correo',
     *     'NoLog'        => true|false Default TRUE,
     *     'to'          => array('destinatario@destino.net'...),
     *     'msg'         => 'El mensje como <b>HTML</b>',
     *     'cc'          => array('cjimenez@woodward.com.mx'), <b>Con Copia</b>
     *     'bcc'         => array('jtopete@woodward.com.mx'), <b>Con Copia Oculta</b>
     *     'msgPriority' => 2 , <b>* 1 el mas alto 5 el mas bajo *</b>
     *     <hr style=" border: 0;  background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0)); height: 1px; ">
     *     <b>Si no quieres aduntar archivos, no definas este atributo</b>
     *
     *     'files'       => array(
     *         array('direccion/del/archivo.pdf', 'NuevoNombre.pdf')
     *     ),
     *    <hr style=" border: 0;  background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0)); height: 1px; ">
     *
     *     'send1by1' => true, <b>Envio de uno por uno o en conjuto</b>
     *
     *     'senderConf' => array(  <b>Configuracion del servidor smtp</b>
     *         '<b>port</b>' => 123,
     *         '<b>smtp</b>' => 'smtp.server.com',
     *         '<b>user</b>' => 'cuenta@server.com.mx',
     *         '<b>pass</b>' => 'ContraseñaIrrompibleBendecidaAlCuboPorALÁ',
     *         '<b>security</b>' => 'ssl||tls ...'
     *     )
     * );
     *
     * </pre>
     *
     * Asegurate de que tanto tu configuracion de SMTP sea correcta y que  la
     * dirreccion del que evía sea la misma que el usuario del SMTP, amenos que
     * tu server te permita enviar mails anonimos o quieras poner otro remitente.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     *
     * @link http://swiftmailer.org/docs/including-the-files.html Documentacion oficial de Swift Mailer
     *
     * @todo Implementar soporte para traer firma de correo desde BD mediante ID.
     * @param array $mConf Array de datos para el envio de correos
     * @return false|int Retorna false cuando hay error o un entero representando la cantidad de correos enviados correctamente
     *
     */
    public function sendMail($mConf) {
        $uid = true;

        require_once CORE_PATH . 'assets/vendor/autoload.php';

        $cf = [];
        if (empty($mConf['senderConf'])) {
            $cf = json_decode($this->getVariable('MAILER'), true);
        } else {
            $cf = $mConf['senderConf'];
        }

        if (isset($mConf['fechaProgramacion']) && is_a($mConf['fechaProgramacion'], 'DateTime')) {
            $dFechaProgramacion = $mConf['fechaProgramacion']->format('Y-m-d H:i:s');
        } else {
            $dFechaProgramacion = NULL;
        }

        $createLog = ( isset($mConf['NoLog']) ? false : @!$mConf['NoLog']);

        if ($createLog) {

            $sql = "CALL stpC_emailLog (
                /*@skMensaje     =*/ NULL,
                /*@skEstatus     =*/ NULL,
                /*@sEmisor     =*/ ". escape($cf['user']) .",
                /*@sAsunto     =*/ ".escape($mConf['subject']).",
                /*@sCopia     =*/ ".escape(json_encode($mConf['cc'])).",
                /*@sCopiaOculta     =*/ ".escape(json_encode($mConf['bcc'])).",
                /*@sDestinatario     =*/ ".escape(json_encode($mConf['to'])).",
                /*@dFechaProgramacion     =*/ " .escape(!empty($dFechaProgramacion) ? $dFechaProgramacion : NULL) . "  ,
                /*@sContenido     =*/ ".escape($mConf['msg']).",
                /*@sFiles     =*/ ".escape(json_encode($mConf['files'])).",
                /*@send1by1     =*/ ".escape(($mConf['send1by1']) ? 1 : 0).", 
            
                /*@axn                           =*/ 'guardar_correo',
                /*@skUsuario                     =*/ ".escape($_SESSION['usuario']['skUsuario']).",
                /*@skModulo                      =*/ ".escape($this->sysController).")";
              

                $result = Conn::query($sql);
                if(is_array($result) && isset($result['success']) && $result['success'] == false){
                    return $result;
                }
                
                $record = Conn::fetch_assoc($result);
                Conn::free_result($result);
                $uid = $record['skMensaje'];
 
        }

        if (empty($mConf['envioInstantaneo'])) {
            return true;
        }

        $transport = Swift_SmtpTransport::newInstance($cf['smtp'], $cf['port'], $cf['security'])
                ->setUsername($cf['user'])
                ->setPassword($cf['pass']);

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance()
                ->setSubject($mConf['subject'])
                ->setFrom($cf['user'])
                ->setBody($mConf['msg'], 'text/html')
                ->setCc($mConf['cc'])
                ->setBcc($mConf['bcc']);

        //Agregamos todos los archivos
        if (isset($mConf['files']) && !empty($mConf['files']) && is_array($mConf['files'])) {
            array_walk($mConf['files'], function (&$val, &$key) use (&$message) {

                $file = Swift_Attachment::fromPath($val[0]);

                if (count($val) > 1) {
                    $file->setFilename($val[1]);
                }
                $message->attach($file);
            });
        }

        $sended = 0;
        $failedRecipients = 0;

        try {
            if ($mConf['send1by1']) {
                foreach ($mConf['to'] as $address => $name) {
                    if (is_int($address)) {
                        $message->setTo($name);
                    } else {
                        $message->setTo(array($address => $name));
                    }

                    $sended += $mailer->send($message, $failedRecipients);
                }
            } else {

                $message->setTo($mConf['to']);
                $sended = $mailer->send($message);
            }
            if ($createLog) {
                if ($uid) {
                    
                    $sql = "UPDATE core_mensajesCorreos SET skEstatus = 'EN', dFechaEnvio = NOW() WHERE skMensaje = " .escape($uid). "";

                    $result = Conn::query($sql);
                    

                     
                     
                   
 
                }
            }
            if (isset($mConf['files']) && !empty($mConf['files']) && is_array($mConf['files'])) {
                foreach ($mConf['files'] AS $k => $v) {
                    unlink($v[0]);
                }
            }
        } catch (Swift_TransportException $e) {
            error_log(date('Y-m-d h:i:s') . " - Error al enviar correo electronico :" . $e->getMessage() . "\n", 3, ERROR_LOGFILE);
        }
        return $uid;
    }

    /**
     * Genera excel
     *
     * Genera un array de configuracion para ejecuta la funcion de
     * excel usando los datos de una tabla de algun modulo xxxx-inde.
     *
     * @author Luis Alberto Valdez Alvarez <lvaldez@woodward.com.mx>
     * @param string $title Titulo del documento
     * @param string $headers Cabeceras en formato json
     * @param object $data Objeto stdobject de resultados mssql
     */
    protected function generar_excel($title, $headers, $data, $save = FALSE) {

        $conf = array(
            'fileName' => $title,
            'format' => 'xlsx',
            'pages' => array(
                'Hoja 1' => array(
                    'startAt' => 'A1',
                    'headers' => array(),
                    'headersOrientation' => 'H',
                    'data' => array()
                )
            )
        );

        if ($save) {
            $conf['fileLocation'] = TMP_HARDPATH;
        }

        $headers = json_decode($headers, true);

        foreach ($headers AS $k => &$v) {
            array_push($conf['pages']['Hoja 1']['headers'], $v['title']);
        }

        $records_data = $data;
        if (isset($data->queryString)) {
            $records_data = Conn::fetch_assoc_all($data);
        }

        foreach ($records_data AS $row) {
            $records = array();
            foreach ($headers AS $k => &$v) {
                if ($v['dataType'] === 'date') {
                    $records[$v['column']] = ($row[$v['column']] ? date('d/m/Y', strtotime($row[$v['column']])) : '');
                    continue;
                }
                if ($v['dataType'] === 'dateTime') {
                    $records[$v['column']] = ($row[$v['column']] ? date('d/m/Y H:i:s', strtotime($row[$v['column']])) : '');
                    continue;
                }
                $records[$v['column']] = utf8($row[$v['column']], FALSE);
            }
            array_push($conf['pages']['Hoja 1']['data'], $records);
        }

        if ($save) {
            return $this->excel($conf);
        }

        $this->excel($conf);
    }

    /**
     * Generar pdf
     *
     * Genera un array de configuracion para ejecutar la funcion pdf apartir de
     * los datos de una tabla de algún módulo
     *
     * @author Samuel Perez <sperez@woodward.com.mx>
     * @param string $title Titulo del documento
     * @param string $headers Cabeceras en formato json
     * @param object $data Objeto stdobject de resultados mssql
     */
    protected function generar_pdf($title, $headers, $data, $save = false) {

        $JIDERS = json_decode($headers, true);
        $JIDERS_HTML = "";
        $ACHETEEMEELE = "";

        array_walk($JIDERS, function (&$v) use (&$JIDERS_HTML) {

            $JIDERS_HTML .= "<th height=\"80\" style=\"padding-right:15px;\"> $v[title]</th>";
        });

        $records_data = $data;
        if (isset($data->queryString)) {
            $records_data = Conn::fetch_assoc_all($data);
        }
        foreach ($records_data AS $d) {
            //while ($d = Conn::fetch_assoc($data)) {
            utf8($d);
            $ACHETEEMEELE .= "<tr style=\"margin:10px; padding-bottom:15px;\" >";
            array_walk($JIDERS, function (&$v) use (&$ACHETEEMEELE, &$d) {
                if ($v['dataType'] === 'date' && !empty($d[$v['column']])) {
                    $txt = date('d/m/Y', strtotime($d[$v['column']]));
                    $ACHETEEMEELE .= "<td style=\"border-bottom: .5px solid #afafaf;padding-right:15px;\">$txt</td>";
                } elseif ($v['dataType'] === 'dateTime' && !empty($d[$v['column']])) {
                    $txt = date('d/m/Y H:i:s', strtotime($d[$v['column']]));
                    $ACHETEEMEELE .= "<td style=\"border-bottom: .5px solid #afafaf;padding-right:15px;\">$txt</td>";
                } else {
                    $txt = $d[$v['column']];
                    $ACHETEEMEELE .= "<td style=\"border-bottom: .5px solid #afafaf;padding-right:15px;\">$txt</td>";
                }
            });
            $ACHETEEMEELE .= "</tr>";
        }

        $variableConNombreREQUETEFORMAL = "
           <table style=\"width:100%; \">
                <tbody>
                    <tr>
                        $JIDERS_HTML
                    </tr>
                        $ACHETEEMEELE
                </tbody>
            </table>";

        $fileName = $title;
        if ($save) {
            $fileName = rand(1, 100) . time();
        } else {
            header('Set-Cookie: fileDownload=true; path=/');
        }

        $this->pdf(array(
            'waterMark' => array(
                'imgsrc' => IMAGE_WATERMARK_PDF,
                'opacity' => .09,
                'size' => [120, 50]
            ),
            'content' => $variableConNombreREQUETEFORMAL,
            'header' => '
                <div class="pdf_cabecera">
                    <div class="pdf_left"><img style=""  src="' . IMAGE_LOGO_PDF . '" width="120" ></div>
                    <div class="pdf_centro">
                      <h3>' . $title . '</h3>
                    </div>
                    <div class="leFlotar"></div>
                </div>',
            'footer' => 'false',
            'pdf' => array(
                'contentMargins' => [10, 10, 25, 25],
                'format' => 'Letter',
                'vertical' => false,
                'footerMargin' => 5,
                'headerMargin' => 5,
                'location' => ($save) ? TMP_HARDPATH : false,
                'directDownloadFile' => true,
                'fileName' => $fileName . '.pdf'
            )
        ));

        if ($save) {
            return TMP_HARDPATH . $fileName . '.pdf';
        }

        return true;
    }

    /**
     * Escribe datos a archivo de texto
     *
     * Esta funcion escribe datos en un archivo de texto configurable o puede
     * generarlo y desgargarlo al instante. La estructura del array que recibe
     * esta funcion es esta:
     * <pre>
     * Array
     * (
     *    [data] => Array
     *        (
     *            array(''...)...
     *       )
     *
     *    [separator] => '|'
     *    [fileName] => 'le.xd'
     *
     *      <b>Si deseas que el archivo se descarge al vuelo, <i>fileLocation</i> a FALSE</b>
     *    [fileLocation] => FALSE || '/path/to/save/'
     * )
     * </pre>
     *
     *
     *
     * @author Samuel Perez <sperez@woodward.com.mx>
     * @param array $datos Array de datos y configuracion de archivo.
     * @return boolean|file Returna archivo o True en caso de exito y false en caso de error
     */
    public function toTextFile($datos = null) {

        if (strlen($datos['separator']) < 1 || !isset($datos['separator']) || strlen($datos['fileName']) < 1 || !isset($datos['fileName']) || $datos == null) {
            return false;
        }

        $loc = $datos['fileLocation'];
        $len = strlen($loc);

        $fName = (!$loc) ? TMP_HARDPATH . $loc :
                (substr($loc, $len - 1, $len) === '/' ?
                ($loc . $datos['fileName']) :
                ($loc . '/' . $datos['fileName']));

        try {
            $file = fopen($fName, 'w');
            array_walk($datos['data'], function (&$v, &$k) use (&$file, &$datos) {
                fwrite($file, implode($v, $datos['separator']) . "|\r\n");
            });
            fclose($file);
            chmod($fName, 0777);
        } catch (Exception $e) {
            echo "Error (File: " . $e->getFile() . ", line " . $e->getLine() . "): " . $e->getMessage();

            return false;
        }

        if (!$loc) {
            header("Content-Disposition: attachment; filename=\"" . basename($fName) . "\"");
            header("Content-Type: application/force-download");
            header("Connection: close");
            header("Content-Length: " . filesize($fName));
            ob_clean();
            flush();
            readfile($fName);
            unlink($fName);
            return true;
        } else {
            return true;
        }
    }

    /**
     * Cifra la contraseña del usuario
     *
     * Esta funcion se encarga de crear tanto en salt como el hash
     * necesarios para el inicio de sesion.
     *
     * @author Jonathan Topete <jtopete@woodward.com.mx>
     * @param $password
     * @return array Regresa un array con en salt y el hash.
     */
    public static function encriptar($password) {

        $salt = md5(uniqid(rand(), true)); // Obtenemos un identificador único
        $hash = hash('sha512', $salt . $password);

        return array(
            'salt' => $salt,
            'hash' => $hash
        );                    //Regresamos un Array con los 2 valores
    }

    /**
     * Cifra la contraseña del usuario
     *
     * Esta funcion se encarga de crear el hash de la conbinacion de contraseña
     * con el salt de la base de datos.
     *
     * @author Jonathan Topete <jtopete@woodward.com.mx>
     * @param $password Contraseña introducida por el usuario.
     * @param $db_salt Salt almacenada en la base de datos.
     * @return string regresa el hash para posteriormente ser comparada con la de la base de datos.
     */
    public static function desencriptar($password, $db_salt) {
        $pass = hash('sha512', $db_salt . $password);
        return $pass;
    }

    /**
     * notify
     *
     * Guarda una notificación en sistema.
     *
     * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param string $sClaveNotificacion Clave de la notificación.
     * @param mixed $conf Configuración de valores para el template del mensaje.
     * @param mixed $usuarios Usuarios que recibirán el mensaje.
     * @param mixed $gruposPublicaciones Grupos de Publicaciones que recibirán el mensaje.
     * @param mixed $excluirUsuarios Usuarios a excluir que NO recibirán el mensaje.
     * @param mixed $correosAdicionales Correos adicionales que recibirán el mensaje.
     * @return boolena  retorna true en caso de éxito, false en caso de haber algún error.
     */
    public function notify($sClaveNotificacion, $conf = [], $usuarios = [], $gruposPublicaciones = [], $excluirUsuarios = [], $correosAdicionales = []) {

   

        $sql = "SELECT * FROM cat_notificacionesMensajes WHERE skEstatus = 'AC' AND sClaveNotificacion = '" . $sClaveNotificacion . "'";
        
        $result = Conn::query($sql);

        if (!$result) {
            return FALSE;
        }

        $notificacion = Conn::fetch_assoc($result);

        if (!$notificacion) {
            return FALSE;
        }

        utf8($notificacion, FALSE);

        /*$sql = "SELECT * FROM rel_notificacionesMensajes_variables WHERE skNotificacionMensaje = '" . $notificacion['skNotificacionMensaje'] . "'";
        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }*/

        utf8($conf, FALSE);

        $sValores = array();
        //foreach (Conn::fetch_assoc_all($result) as $row) {
            //utf8($row, FALSE);

            foreach ($conf AS $k => $v) {

                $sValores[$k] = $v;

                if (!is_array($v)) {
                    $notificacion['sNombre'] = str_replace('[' . $k . ']', $v, $notificacion['sNombre']);
                    $notificacion['sAsunto'] = str_replace('[' . $k . ']', $v, $notificacion['sAsunto']);
                    $notificacion['sMensaje'] = str_replace('[' . $k . ']', $v, $notificacion['sMensaje']);
                    $notificacion['sMensajeCorreo'] = str_replace('[' . $k . ']', $v, $notificacion['sMensajeCorreo']);
                    $notificacion['sUrl'] = str_replace('[' . $k . ']', $v, $notificacion['sUrl']);
                    $notificacion['sIcono'] = str_replace('[' . $k . ']', $v, $notificacion['sIcono']);
                    $notificacion['sColor'] = str_replace('[' . $k . ']', $v, $notificacion['sColor']);
                }
            }
        //}

        $sValores['sNombre'] = $notificacion['sNombre'];
        $sValores['sMensaje'] = $notificacion['sMensaje'];

        $notificacion['sValores'] = json_encode($sValores);

         // excluirUsuarios
       /* array_push($excluirUsuarios, $_SESSION['usuario']['skUsuario']);
        $excluirUsuarios = array_unique($excluirUsuarios);
        foreach ($excluirUsuarios AS $k => $v) {
            $array_excluirUsuarios[$v] = $v;
        }
        $notificacion['excluirUsuarios'] = $array_excluirUsuarios;*/

        $sql = "CALL stpCU_notificacion (
            /*@skNotificacion    =*/ NULL,
            /*@skNotificacionMensaje     =*/ " . escape($notificacion['skNotificacionMensaje']) . ",
            /*@skEmpresaSocioPropietario     =*/ " . escape($_SESSION['usuario']['skEmpresaSocioPropietario']) . ",
            /*@skComportamientoModulo     =*/  " . escape($notificacion['skComportamiento']) . ",
            /*@skEstatus     =*/ 'EN',
            /*@skModuloNotificacion     =*/ " . escape($this->sysController) . ",
            /*@iNotificacionGeneral     =*/ " . escape($notificacion['iNotificacionGeneral']) . ",
            /*@sNombre     =*/ " . escape($notificacion['sNombre']) . ",
            /*@sMensaje     =*/ " . escape($notificacion['sMensaje']) . ",
            /*@sMensajeCorreo     =*/ " . escape($notificacion['sMensajeCorreo']) . ",
            /*@sUrl     =*/ " . escape($notificacion['sUrl']) . ",
            /*@sIcono     =*/ " . escape($notificacion['sIcono']) . ",
            /*@sColor     =*/ " . escape($notificacion['sColor']) . ",
             /*@sAsunto     =*/ " . escape($notificacion['sAsunto']) . ",
             /*@sValores     =*/ " . escape($notificacion['sValores']) . ",
        
            /*@axn                           =*/ 'guardar_notificacion',
            /*@skUsuario                     =*/ ".escape($_SESSION['usuario']['skUsuario']).",
            /*@skModulo                      =*/ ".escape($this->sysController).")";
           


        

 
        $result = Conn::query($sql);
        if(is_array($result) && isset($result['success']) && $result['success'] == false){
            return $result;
        }

        $skNotificacion = Conn::fetch_assoc($result);

        if (!$skNotificacion) {
            return FALSE;
        }

        $notificacion['skNotificacion'] = $skNotificacion['skNotificacion'];
        
        if ($usuarios) {
            foreach ($usuarios AS $k => $v) {

               
                $sql = "CALL stpCU_notificacionUsuario (
                    /*@skNotificacion    =*/ " . escape($skNotificacion['skNotificacion']) . ",
                     /*@skUsuario                     =*/ " . escape($v['skUsuario']) . ", 
                    /*@skModulo                      =*/ ".escape($this->sysController).")";

        
                $result = Conn::query($sql);

                if (!$result) {
                    return FALSE;
                }
            }
        }

        $sql = "SELECT DISTINCT N1.channel FROM (
              SELECT
            cn.skNotificacion, u.skUsuario AS channel, cn.dFechaCreacion, u.skUsuario
            FROM core_notificaciones cn
            INNER JOIN cat_notificacionesMensajes nm ON nm.skNotificacionMensaje = cn.skNotificacionMensaje
            INNER JOIN rel_notificaciones_usuarios nu ON nu.skNotificacion = cn.skNotificacion
            INNER JOIN cat_usuarios u ON u.skUsuario = nu.skUsuario AND u.skEstatus = 'AC'
            WHERE cn.skNotificacion = '" . $skNotificacion['skNotificacion'] . "'   
            ) AS N1
        WHERE N1.skNotificacion = '" . $skNotificacion['skNotificacion'] . "'";

        $result = Conn::query($sql);

        if (!$result) {
            return FALSE;
        }

        $channels = Conn::fetch_assoc_all($result);

        $arrayUsuario = array();
        /*echo "<PRE>";
        print_r($channels);
        die();*/

        foreach ($channels as $row) {

            utf8($row, FALSE);
            $notificacion['dFechaCreacion'] = date('d/m/Y H:i:s');
        
            $wmsg_response = $this->d_notify($notificacion,$row['channel'],'notify');
          
            if ($wmsg_response == true) {

                // SE CAMBIA EL ESTATUS COMO NOTIFICACIÓN ENVIADA PARA UN USUARIO (INDIVIDUAL) //
                $sql = "UPDATE rel_notificaciones_usuarios SET skEstatus = 'EN' WHERE skNotificacion = " . escape($notificacion['skNotificacion']) . " AND skUsuario = " . escape($row['channel']);
                $result = Conn::query($sql);
                if (!$result) {
                    $this->data['success'] = FALSE;
                    $this->data['message'] = 'Hubo un error actualizar el estatus de la notificación web del usuario a enviada';
                }

             
                 
            }
        }

         
        // Enviamos la notificación al celular

        if ($notificacion['iEnviarCorreo'] == 1) {
            $this->notifyMail($skNotificacion, $notificacion, $correosAdicionales);
        }
        return TRUE;
    }

    /**
     * sendPushMessage
     *
     * Envia un mensaje push por onesignal a un dispositivo [Celular, tablet, etc...]
     *
     * @author       Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param mixed $conf Configuración de valores para el template del mensaje.
     * @param mixed $ids Identificadores de los dispositivos (Usuarios que recibirán el mensaje)
     * @return boolena  retorna true en caso de éxito, false en caso de haber algún error.
     */
    public function sendPushMessage($conf, $ids) {

        if (!isset($conf['skAplicacion'])) {
            return TRUE;
        }

        switch ($conf['skAplicacion']) {
            case 'TRAC':
                $appId = $this->getVariable('TRKYID');
                break;
            case 'PREV':
                $appId = $this->getVariable('PRKYID');
                break;
        }

        $content = array(
            "en" => $conf['sMensaje'],
            "es" => $conf['sMensaje']
        );

        $title = array(
            "en" => $conf['sNombre'],
            "es" => $conf['sNombre']
        );

        $data = json_decode($conf['sValores'], TRUE, 512);

        $fields = array(
            'app_id' => $appId,
            'include_player_ids' => $ids,
            'headings' => $title,
            'contents' => $content,
            'data' => $data,
            'android_group' => '1'
        );


        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * notifyMail
     *
     * Envia la notificación por correo.
     *
     * @author          Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param string $skNotificacion ID de la notificación.
     * @param mixed $notificacion Configuración de la notificación.
     * @param mixed $correosAdicionales Correos adicionales que recibirán el mensaje.
     * @return boolena  retorna true en caso de éxito, false en caso de haber algún error.
     */
    protected function notifyMail($skNotificacion, $notificacion, $correosAdicionales) {

        $sql = "SELECT DISTINCT N1.* FROM (
             
            SELECT
            cn.skNotificacion, u.skUsuario, CONCAT(u.sNombre,' ',u.sApellidoPaterno,' ',u.sApellidoMaterno) AS nombreCompleto, u.sNombre, u.sApellidoPaterno, u.sApellidoMaterno, u.sCorreo
            FROM core_notificaciones cn
            INNER JOIN rel_notificaciones_usuarios nu ON nu.skNotificacion = cn.skNotificacion
            INNER JOIN cat_usuarios u ON u.skUsuario = nu.skUsuario
            WHERE cn.skNotificacion = '" . $skNotificacion['skNotificacion'] . "'  
            ) AS N1
        WHERE N1.skNotificacion = '" . $skNotificacion['skNotificacion'] . "'";
        
        $result = Conn::query($sql);

        if (!$result) {
            return FALSE;
        }

        $usuarios = Conn::fetch_assoc_all($result);

        $list = array();
        if (count($usuarios) > 0) {
            foreach ($usuarios as $row) {
                if (!empty(trim($row['sCorreo']))) {
                    $list[trim($row['sCorreo'])] = $row['sCorreo'];
                    //array_push($list, $row['sCorreo']);
                }
            }
        }

        // Correos Adicionales
        if ($correosAdicionales) {
           
            foreach ($correosAdicionales AS $k => $v) {
              
                if (!empty(trim($v))) {
                    $list[trim($v)] = $v;
                }
            }
        }
        

        if (count($list) == 0) {
            return TRUE;
        }

        $this->sendMail(array(
            'subject' => (!empty($notificacion['sAsunto']) ? $notificacion['sAsunto'] : $notificacion['sNombre']),
            'to' => array_keys($list),
            'msg' => (!empty($notificacion['sMensajeCorreo']) ? $notificacion['sMensajeCorreo'] : $notificacion['sMensaje']),
            'cc' => [],
            'bcc' => [],
            'msgPriority' => 1,
            'send1by1' => ($notificacion['iNotificacionGeneral']) ? FALSE : TRUE,
            'files' => [],
            'envioInstantaneo' => $notificacion['iEnviarInstantaneo'],
            'senderConf' => []
        ));
        return true;
    }

    /**
     * Consultar estatus
     *
     * Consulta los registros de la tabla core_status
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $where Array de valores a escojer
     * @param type $asArray Retornar como arrat asociativo php
     * @param type $redundantKey Retornar como array asociativo redundante
     * @return boolean | Object | array
     */
    public function consultar_core_estatus($where, $asArray = false, $redundantKey = false) {

        if (!is_array($where)) {
            return false;
        }

        $sql = 'SELECT * FROM core_estatus WHERE skEstatus IN (' . mssql_where_in($where) . ')';

        $result = Conn::query($sql);

        if (!$result) {
            return false;
        }

        if (!$asArray) {
            return $result;
        }

        $r = array();

        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);
            if ($redundantKey) {
                $r[$row[$redundantKey]] = $row;
            } else {
                array_push($r, $row);
            }
        }
        //$result->closeCursor();
        return $r;
    }

    /**
     * getVariable
     *
     * Obtiene el valor de una variable
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param type $skVariable Identificador de la variable
     * @return boolean | string Retorna el valor de la variable
     */
    public function getVariable($skVariable) {
        $select = "SELECT sValor FROM core_variables WHERE skVariable = '" . $skVariable . "'";

        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        //Conn::free_result($result);
         
        return (!empty($record['sValor']) ? $record['sValor'] : NULL);
    }

    /**
     * getCaracteristica
     *
     * Obtiene el valor de una caracteristica
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param type $skCaracteristica Identificador de la característica
     * @param type $tipoCaracteristica Identificador del tipo de característica empresas / usuarios / servicios
     * @param type $codigo Identificador de la Empresa / Usuario / skServicio
     * @return string Retorna el valor de la variable
     */
    public function getCaracteristica($skCaracteristica, $tipoCaracteristica, $codigo) {
        switch ($tipoCaracteristica) {
            case 'empresas':
                $sql = "SELECT sValor FROM rel_caracteristica_empresaSocio WHERE skCaracteristicaEmpresaSocio = " . escape($skCaracteristica) . " AND skEmpresaSocio = " . escape($codigo);
                break;
            case 'usuarios':
                $sql = "SELECT sValor FROM rel_caracteristicasUsuarios_usuarios WHERE skCaracteristicaUsuario = " . escape($skCaracteristica) . " AND skUsuario = " . escape($codigo);
                break;
            case 'servicios':
                $sql = "SELECT sValor FROM rel_servicios_caracteristicas WHERE skServicioCaracteristica = " . escape($skCaracteristica) . " AND skServicio = " . escape($codigo);
                break;
            default:
                break;
        }

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        if(!isset($record['sValor'])){
            return FALSE;
        }
        return $record['sValor'];
    }

    /**
     * getServidorVinculado
     *
     * Obtiene los datos de un servidor vinculado
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param type $skServidorVinculado Identificador del servidor vinculado
     * @return mixed Array | False
     */
    public function getServidorVinculado($skServidorVinculado) {
        $select = "SELECT * FROM cat_servidoresVinculados WHERE skServidorVinculado = " . escape($skServidorVinculado);
        $result = Conn::query($select);
        if (!$result) {
            return FALSE;
        }
        $record = Conn::fetch_assoc($result);
        Conn::free_result($result);
        utf8($record);
        return $record;
    }

    /**
     * Importar datos de desde archivos
     *
     * Recibe una ruta a archivo o array de $_FILES y retorna informacion
     * procesable como array asociativo o json. Esta funcion tomara el primer
     * registro de cada columna como la cabecera.
     *
     *
     * $config = [
     *      'fileName' => String || $_FILE array data,
     *      'asArray' => TRUE || FALSE False retornara un json,
     *      'specialSeparation' =>  ['DELIMITER', 'CLOSURE']  // Puedes no establecerlo
     *
     * ]
     *
     * Archivos soportados : Excel 2003 - 2005 - 2007 - 2012
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param type $config
     * @return boolean|array|string
     */
    public function importData($config) {


        if (empty($config['fileName'])) {
            return false;
        }

        if (is_array($config['fileName'])) {

            $ex = pathinfo($config['fileName']["name"], PATHINFO_EXTENSION);

            $filename = TMP_HARDPATH . sha1($config['fileName']["tmp_name"] . rand(1, 24024)) . ".$ex";

            if (!move_uploaded_file($config['fileName']["tmp_name"], $filename)) {

                return false;
            }
        }

        if (is_string($config['fileName'])) {
            $filename = $config['fileName'];
        }

        if (isset($config['specialSeparation']) && is_array($config['specialSeparation'])) {
            $result = $this->phpCharSeparated2Array($filename, $config['specialSeparation']);
        } else {
            $result = $this->phpExcelReader2Array($filename);
        }

        if (is_array($config['fileName'])) {
            unlink($filename);
        }

        if (!$config['asArray']) {
            return json_encode($result);
        }

        return $result;
    }

    /**
     * Archivos Excel
     *
     * Autodetecta y genera la instancia requerida para poder leer el
     * archivo excel que sea cargado, luego llama al iterador base para
     * retornar el array de datos
     *
     * @param string $filename Ruta dura al archivo
     * @return array Array de datos
     */
    private function phpExcelReader2Array($filename) {

        require_once CORE_PATH . 'assets/vendor/autoload.php';

        $objReader = PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filename);
        $objReader->setReadDataOnly(true);
        $reader = $objReader->load($filename);

        return $this->importDataEngine($reader);
    }

    /**
     * Archivos separados por caracteres especiales
     *
     * Genera una instancia de PHPExcel_Reader_CSV con la configuracion
     * del separado, llama a la funcion  importDataEngine para retornar
     * un array de datos.
     *
     * @param string $filename Ruta al archivo
     * @param array $args Argumentos de separado ['DELIMITADOR', 'CLOSURE']
     * @return array
     */
    private function phpCharSeparated2Array($filename, $args) {

        require_once CORE_PATH . 'assets/vendor/autoload.php';

        $objReader = new PhpOffice\PhpSpreadsheet\Reader\Csv();
        $objReader->setInputEncoding('CP1252');
        $objReader->setDelimiter($args[0]);
        $objReader->setEnclosure($args[1]);
        $reader = $objReader->load($filename);

        return $this->importDataEngine($reader);
    }

    /**
     * Iterador base
     *
     * Esta funcion recibe una referencia a un objeto de tipo PHPExcel
     * para iterar por hoja -> columna -> celda, retorna un array asociativo
     * de tipo :
     *
     * [
     *      'HOJA' => [
     *          'Cabecera 1' => [val, val1,val2]
     *      ]
     * ]
     *
     * @param object $iterable Referencia a un objeto de tipo PHPExcel
     * @return array
     */
    private function importDataEngine(&$iterable) {

        foreach ($iterable->getWorksheetIterator() as $hoja) {

            $avatar[$hoja->getTitle()] = [];

            foreach ($hoja->getColumnIterator() as $column) {

                $cellIterator = $column->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $titleColumn = '';

                foreach ($cellIterator as $k => $cell) {

                    if ($k === 1) {
                        $avatar[$hoja->getTitle()][$cell->getValue()] = [];
                        $titleColumn = $cell->getValue();
                        continue;
                    }

                    array_push($avatar[$hoja->getTitle()][$titleColumn], $cell->getValue());
                }
            }
        }

        return $avatar;
    }

    /**
     * Codigos de barras
     *
     * Retorna codigos de barras 2D en diversos formatos soportados por la libreria
     * tcpdf en formato HTML y base64.
     *
     * Argumentos pasados mediente array con la siguiente estructura
     *
     * [
     *  'data' => "Informacion a codificar en forma de cadena",
     *  'format' => 'FORMATO' Vease 'PDF417' 'QRCODE,[L,M,Q,H]', 'DATAMATRIX', leer documentacion oficial para mas formatos.
     *  'w' => int Ancho,
     *  'h' => int Alto,
     *  'color' => [R,G,B] Array de color RGB, Default [0,0,0],
     *  'colorhtml' => 'black' Nombre de color para salida como HTML, default 'black',
     *  'output' => 'base64'  | 'html' Default 'base64'     *
     * ]
     *
     *
     * @link https://tcpdf.org Documentacion oficial de TCPDF
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param array $args
     * @return string Representacion de codigo de barras.
     */
    public static function barcode2D($args) {

        if (!isset($args['data'], $args['format'], $args['w'], $args['h'])) {
            return false;
        }
        if (!isset($args['color'])) {
            $args['color'] = [0, 0, 0];
        }
        if (!isset($args['colorhtml'])) {
            $args['colorhtml'] = 'black';
        }
        if (!isset($args['output'])) {
            $args['output'] = '';
        }

        require_once CORE_PATH . 'assets/vendor/autoload.php';

        $tcpdf = new TCPDF2DBarcode($args['data'], $args['format']);

        switch ($args['output']) {
            case 'html':
                return $tcpdf->getBarcodeHTML($args['w'], $args['h'], $args['colorhtml']);
            default :
                return 'data:image/png;base64,' . base64_encode(
                                $tcpdf->getBarcodePngData($args['w'], $args['h'], $args['color'])
                );
        }
    }

    /**
     * Codigos de barras
     *
     * Retorna codigos de barras 2D en diversos formatos soportados por la libreria
     * tcpdf en formato HTML y base64.
     *
     * Argumentos pasados mediente array con la siguiente estructura
     *
     * [
     *  'data' => "Informacion a codificar en forma de cadena",
     *  'format' => 'FORMATO' Vease 'PDF417' 'QRCODE,[L,M,Q,H]', 'DATAMATRIX', leer documentacion oficial para mas formatos.
     *  'w' => int Ancho,
     *  'h' => int Alto,
     *  'color' => [R,G,B] Array de color RGB, Default [0,0,0],
     *  'colorhtml' => 'black' Nombre de color para salida como HTML, default 'black',
     *  'output' => 'base64'  | 'html' Default 'base64'     *
     * ]
     *
     *
     * @link https://tcpdf.org Documentacion oficial de TCPDF
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @param array $args
     * @return string Representacion de codigo de barras.
     */
    public static function barcode1D($args) {

        if (!isset($args['data'], $args['format'], $args['w'], $args['h'])) {
            return false;
        }
        if (!isset($args['color'])) {
            $args['color'] = [0, 0, 0];
        }
        if (!isset($args['colorhtml'])) {
            $args['colorhtml'] = 'black';
        }
        if (!isset($args['output'])) {
            $args['output'] = '';
        }

        require_once CORE_PATH . 'assets/vendor/autoload.php';

        $tcpdf = new TCPDFBarcode($args['data'], $args['format']);

        switch ($args['output']) {
            case 'html':
                return $tcpdf->getBarcodeHTML($args['w'], $args['h'], $args['colorhtml']);
            default :
                return 'data:image/png;base64,' . base64_encode(
                                $tcpdf->getBarcodePngData($args['w'], $args['h'], $args['color'])
                );
        }
    }

    /**
     * encrypt
     *
     * Encripta una cadena de texto usando el algorimo
     * aes-256-crt usando como llave el hash SHA512 de
     * la llave proporcionada y el hash WHIRPOOL de la
     * cadena de inizialisacion.
     *
     * Retorna una cadena codificada en base64 para su
     * correcto almacenamiento en bd     *
     *
     * @param string $data Datos encriptar
     * @param string $key Llave de encriptado, por default usa la constante PWE_KEY
     * @param string $iv Vector de inicializacion , por default usa la constante PWE_IV
     * @return string|bool Cadena encriptada y codificada en base64
     */
    public static function encrypt($data, $key = PWE_KEY, $iv = PWE_IV) {

        if (empty($data)) {
            return false;
        }

        return base64_encode(
                openssl_encrypt(
                        $data, 'aes-256-ctr', openssl_digest($key, 'SHA512'), 1, substr(openssl_digest($iv, 'whirlpool'), 0, 16)
                )
        );
    }

    /**
     * decrypt
     *
     * Desencripta una cadena de texto.
     *
     * @param string $data  Datos desencriptar
     * @param string $key Llave de encriptado, por default usa la constante PWE_KEY
     * @param string $iv Vector de inicializacion , por default usa la constante PWE_IV
     * @return string|boolean Texto decifrado o boleano
     */
    public static function decrypt($data, $key = PWE_KEY, $iv = PWE_IV) {
        if (empty($data)) {
            return false;
        }
        return openssl_decrypt(
                base64_decode($data), 'aes-256-ctr', openssl_digest($key, 'SHA512'), 1, substr(openssl_digest($iv, 'whirlpool'), 0, 16)
        );
    }

    /**
     * getGruposUsuarios
     *
     * Obtiene la vision que tiene un usuario con forme a los grupos donde este asignado o sea responsable.
     *
     * @author Christian Josue Jiménez Sánchez <cjimenez@woodward.com.mx>
     * @param type $skUsuario Identificador del usuario
     * @return mixed Array | False
     */
    public function getGruposUsuarios($skUsuario) {
        $select = " SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
		FROM cat_gruposUsuarios cg
		LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
		 WHERE cg.skEstatus = 'AC'
		AND  ( (rgu.skUsuario = '" . $skUsuario . "' AND rgu.iRecursivo = 0) OR (rgu.skUsuario = '" . $skUsuario . "' AND rgu.iRecursivo = 1) OR cg.skUsuarioResponsable = '" . $skUsuario . "') ";

        $result = Conn::query($select);

        $visionEjecutivoArray = array();
        foreach  (Conn::fetch_assoc_all($result) as $rowVisionEjecutivo) {
            if ($rowVisionEjecutivo['skUsuarioResponsable'] == $skUsuario && $rowVisionEjecutivo['iRecursivo'] == 1) {
                $visionEjecutivoArray[$rowVisionEjecutivo['skUsuario']] = $rowVisionEjecutivo['skUsuario'];
                $recursividad1 = "SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
                                                    FROM cat_gruposUsuarios cg
                                                    LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
                                                    Where cg.skEstatus = 'AC'
                                                    AND  ( (rgu.skUsuario = '" . $rowVisionEjecutivo['skUsuario'] . "' AND rgu.iRecursivo = 0) OR cg.skUsuarioResponsable = '" . $rowVisionEjecutivo['skUsuario'] . "' )";
                $result1 = Conn::query($recursividad1);
                $rarray = Conn::fetch_assoc_all($result1);
                $result1->closeCursor();
                foreach ($rarray as $rowVision1) {

                    if ($rowVision1['skUsuarioResponsable'] == $rowVisionEjecutivo['skUsuario'] && $rowVision1['iRecursivo'] == 1) {
                        $visionEjecutivoArray[$rowVision1['skUsuario']] = $rowVision1['skUsuario'];
                        $recursividad2 = "SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
                                            FROM cat_gruposUsuarios cg
                                            LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
                                            Where cg.skEstatus = 'AC'
                                            AND  ( (rgu.skUsuario = '" . $rowVision1['skUsuario'] . "' AND rgu.iRecursivo = 0) OR cg.skUsuarioResponsable = '" . $rowVision1['skUsuario'] . "' )";
                        $result2 = Conn::query($recursividad2);
                        $r2array = Conn::fetch_assoc_all($result2);
                        $result2->closeCursor();
                        foreach ($r2array as $rowVision2) {

                            if ($rowVision2['skUsuarioResponsable'] == $rowVision1['skUsuario'] && $rowVision2['iRecursivo'] == 1) {
                                $visionEjecutivoArray[$rowVision2['skUsuario']] = $rowVision2['skUsuario'];
                                $recursividad3 = "SELECT DISTINCT cg.skUsuarioResponsable,rgu.skUsuario, rgu.iRecursivo
                                                    FROM cat_gruposUsuarios cg
                                                    LEFT JOIN rel_gruposUsuarios_usuarios rgu ON rgu.skGrupoUsuario = cg.skGrupoUsuario
                                                    Where cg.skEstatus = 'AC'
                                                    AND  ( (rgu.skUsuario = '" . $rowVision2['skUsuario'] . "' AND rgu.iRecursivo = 0) OR cg.skUsuarioResponsable = '" . $rowVision2['skUsuario'] . "' )";
                                $result3 = Conn::query($recursividad3);
                                $R3A = Conn::fetch_assoc_all($result3);
                                $result3->closeCursor();
                                foreach ($R3A  as $rowVision3) {
                                    if ($rowVision3['skUsuarioResponsable'] == $rowVision2['skUsuario'] && $rowVision3['iRecursivo'] == 1) {
                                        $visionEjecutivoArray[$rowVision3['skUsuario']] = $rowVision3['skUsuario'];
                                    }
                                    if ($rowVision3['skUsuarioResponsable'] == $rowVision2['skUsuario'] && $rowVision3['iRecursivo'] == 0) {
                                        $visionEjecutivoArray[$rowVision3['skUsuario']] = $rowVision3['skUsuario'];
                                    }
                                    if ($rowVision3['skUsuario'] == $rowVision2['skUsuarioResponsable']) {
                                        $visionEjecutivoArray[$rowVision3['skUsuarioResponsable']] = $rowVision3['skUsuarioResponsable'];
                                    }
                                }

                            }
                            if ($rowVision2['skUsuarioResponsable'] == $rowVision1['skUsuario'] && $rowVision2['iRecursivo'] == 0) {
                                $visionEjecutivoArray[$rowVision2['skUsuario']] = $rowVision2['skUsuario'];
                            }
                            if ($rowVision2['skUsuario'] == $rowVision1['skUsuarioResponsable']) {
                                $visionEjecutivoArray[$rowVision2['skUsuarioResponsable']] = $rowVision2['skUsuarioResponsable'];
                            }
                        }
                    }
                    if ($rowVision1['skUsuarioResponsable'] == $rowVisionEjecutivo['skUsuario'] && $rowVision1['iRecursivo'] == 0) {
                        $visionEjecutivoArray[$rowVision1['skUsuario']] = $rowVision1['skUsuario'];
                    }
                    if ($rowVision1['skUsuario'] == $rowVisionEjecutivo['skUsuarioResponsable']) {
                        $visionEjecutivoArray[$rowVision1['skUsuarioResponsable']] = $rowVision1['skUsuarioResponsable'];
                    }
                }// CIERRA WHILE $rowVision1
            }//CIERRA IF usuarioResponsable y recursividad

            if ($rowVisionEjecutivo['skUsuario'] == $skUsuario) {
                $visionEjecutivoArray[$rowVisionEjecutivo['skUsuarioResponsable']] = $rowVisionEjecutivo['skUsuarioResponsable'];
            }
        }

        $visionEjecutivoArray[$skUsuario] = $skUsuario;

        return $visionEjecutivoArray;

    }

    /**
     * accionesComentarios
     *
     * Guarda comentarios.
     *
     * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
     * @return boolean
     */
    public function accionesComentarios() {
        $d = [];

        foreach( explode(',', 'sComentario,skComentario,skComentarioPadre,skIdentificador,skModulo,skPublicacion') as $campo ){
            $d[$campo] = escape((isset($_POST[$campo])  ? $_POST[$campo] : NULL ));
        }

        $u = escape($_SESSION['usuario']['skUsuario']);

        $i = Conn::query("EXEC stpCU_rel_publicaciones_comentarios
            @skComentario	= $d[skComentario],
            @skComentarioPadre	= $d[skComentarioPadre],
            @skPublicacion	= $d[skPublicacion],
            @skIdentificador    = $d[skIdentificador],
            @sComentario	= $d[sComentario],
            @skUsuarioCreacion	= $u,
            @skModulo		= '$this->sysController'");

        return ( !$i ? $i : Conn::fetch_assoc($i)['skComentario'] );

    }

    /**
     * getCatalogoSistema
     *
     * Obtiene catalogos de sistema
     *
     * @author Christian Josue Jimenez Sanchez <cjimenez@woodward.com.mx>
     * @param mixed array $conf datos para obtener catálogos de sistema
     * @return boolean TRUE | FALSE
     */
    public function getCatalogoSistema($conf = array()){
        $sql = "SELECT cs.sNombre AS sCatalogo, cso.* FROM cat_catalogosSistemas cs
            INNER JOIN rel_catalogosSistemasOpciones cso ON cso.skCatalogoSistema = cs.skCatalogoSistema
            WHERE cs.skEstatus = 'AC' AND cso.skEstatus = 'AC'";

        if (isset($conf['skCatalogoSistema']) && !empty($conf['skCatalogoSistema'])) {
            if (is_array($conf['skCatalogoSistema'])) {
                $sql .= " AND cs.skCatalogoSistema IN (".mssql_where_in($conf['skCatalogoSistema']).")";
            } else {
                $sql .= " AND cs.skCatalogoSistema = ".escape($conf['skCatalogoSistema']);
            }
        }

        $sql .= " ORDER BY cso.sNombre ASC";

        $result = Conn::query($sql);
        if (!$result) {
            return FALSE;
        }

        $records = Conn::fetch_assoc_all($result);
        utf8($records);
        return $records;
    }
    
    function obtenerFechaEnLetra($fecha){
            $dia = $this->conocerDiaSemanaFecha($fecha);
            $num = date("j", strtotime($fecha));
            $anno = date("Y", strtotime($fecha));
            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $mes = $mes[(date('m', strtotime($fecha))*1)-1];
            return $dia.', '.$num.' de '.$mes.' del '.$anno;
    }

    function conocerDiaSemanaFecha($fecha) {
            $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $dia = $dias[date('w', strtotime($fecha))];
            return $dia;
    }

}
