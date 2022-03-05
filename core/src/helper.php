<?php


/**
 * utf8
 *
 * Convierte a formato UTF8 y a entidades html para poder mostrar acentos, caracteres especiales, y entidades html sin problemas en la vista.
 *
 * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
 * @link http://stackoverflow.com/questions/13377812/getting-data-with-utf-8-charset-from-mssql-server-using-php-freetds-extension
 * @link http://php.net/manual/en/functions.anonymous.php
 * @param string | integer | array      $value      Parámetro pasado por referencia string | integer | array
 * @param boolean   $value  Parámetro para convertir en entidades html
 * @return string | integer | array     Retorna string | integer | modifica los valores de un array pasado por referencia
 */
function utf8(&$value , $htmlentities = TRUE){
    if(is_null($value) || $value === FALSE){
        return $value;
    }
    if(is_array($value)){
        foreach($value AS $k=>&$v){
            if(is_array($v)){
                foreach($v AS $a=>&$b){
                    if(is_numeric($b)){
                        continue;
                    }
                    if($htmlentities){
                        $b = htmlentities(mb_convert_encoding(trim($b),'UTF-8'));
                    }else{
                        $b = mb_convert_encoding(trim($b),'UTF-8');
                    }
                }
            }else{
                if(is_numeric($v)){
                    continue;
                }
                if($htmlentities){
                    $v = htmlentities(mb_convert_encoding(trim($v),'UTF-8'));
                }else{
                    $v = mb_convert_encoding(trim($v),'UTF-8');
                }
            }
        }
        return true;
    }
    if(is_numeric($value)){
        return $value;
    }
    if($htmlentities){
        return htmlentities(utf8_encode(trim($value)));
    }else{
        return mb_convert_encoding(trim($value),'UTF-8');
    }
}

/**
 * escape
 *
 * Convierte a formato UTF8 y escapa comilla simple para la inserción a base de datos.
 *
 * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
 * @link http://stackoverflow.com/questions/13377812/getting-data-with-utf-8-charset-from-mssql-server-using-php-freetds-extension
 * @param string | integer      $value      Parámetro pasado por referencia string | integer | array
 * @param string | integer      $quotes     Parámetro para entrecomillar
 * @return string | integer     Retorna string | integer
 */
function escape($value, $quotes = true){
    if(is_array($value)){
        return $value;
    }
    if(is_numeric($value)){
        if($quotes){
            return "'".$value."'";
        }else{
            return $value;
        }
    }
    $value = trim($value);
    if(empty($value) || is_null($value)){
        return 'NULL';
    }
    $value = mb_convert_encoding($value,'UTF-8');
    if($quotes){
        return "'".str_replace("'","''",$value)."'";
    }
    return str_replace("'","''",$value);
}

/**
 * add_quotes
 *
 * Agrega comilla simple a un string.
 *
 * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
 * @link http://php.net/manual/en/function.sprintf.php
 * @param string    $value  String a agregar entre comillado simple.
 * @return string   Retorna string entre comillado simple.
 */
function add_quotes($value) {
    if(!empty($value)){
        return sprintf("'%s'", $value);
    }
    return $value;
}

/**
 * mssql_where_in
 *
 * Retorna valores ya formateados para usarlos en un query que contenga un 'IN' Eje: SELECT * FROM tabla WHERE id IN ( Aquí se usarían los valores ya formateados )
 *
 * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
 * @link http://gotofritz.net/blog/howto/removing-empty-array-elements-php/
 * @param string    $value  String a agregar entre comillado simple.
 * @param bool    $comma  True retorna entre comillado, False retorna sin comillas simples
 * @return string   Retorna string entre comillado simple.
 */
function mssql_where_in($value,$comma = TRUE){
    $value = (array)$value;
    $value = array_diff($value,array(''));
    if($comma){
        return implode(',',array_map('add_quotes',$value));
    }else{
        return implode(',',$value);
    }
}

/**
 * errorHandler
 *
 * Guarda en la carpeta de log el error, este se usa en producción.
 *
 * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
 * @link http://php.net/manual/en/function.set-error-handler.php
 * @param string  $errno Tipo de error.
 * @param string  $errstr Descripción del error.
 * @param string  $errfile Ruta del archivo.
 * @param integer $errline Linea donde está el error en el archivo.
 * @return bool Retorna TRUE para evitar que trabaje el internal error handler de PHP.
 */
function errorHandler($errno, $errstr, $errfile, $errline){

    if (!(error_reporting() & $errno)) {
        return;
    }

    $error_log = function($data){
        if(!file_exists(ERROR_LOGFILE)){
            $file = fopen(ERROR_LOGFILE, 'w');
            fclose($file);
            chmod(ERROR_LOGFILE , 0777);
        }
        @file_put_contents(ERROR_LOGFILE, print_r($data,true)."\n" , FILE_APPEND | LOCK_EX);
    };
    
    $errorType = [
        1  => 'E_ERROR',
        2  => 'E_WARNING',
        4  => 'E_PARSE',
        8  => 'E_NOTICE',
        16 => 'E_CORE_ERROR',
        32 => 'E_CORE_WARNING',
        64 => 'E_COMPILE_ERROR',
        128 => 'E_COMPILE_WARNING',
        256 => 'E_USER_ERROR',
        512 => 'E_USER_WARNING',
        1024 => 'E_USER_NOTICE',
        2048 => 'E_STRICT',
        4096 => 'E_RECOVERABLE_ERROR',
        8192 => 'E_DEPRECATED',
        16384 => 'E_USER_DEPRECATED',
    ];
    
    $data  = date('Y-m-d h:i:s')." [PHP " . PHP_VERSION . "] (" . PHP_OS . ")\n";
    $data .= "Error on line ($errline) in file $errfile\n";
    $data .= "Error Type ($errno) $errorType[$errno] => $errstr\n";
    $error_log($data);
    return TRUE;
}

/**
 * create_thumbnail
 *
 * Genera un thumbnail dinámicamente en memoria o lo guarda en un directorio.
 *
 * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
 * @link https://davidwalsh.name/create-image-thumbnail-php
 * @param string  $source Ruta fisica del archivo que se le quiere generar thumbnail.
 * @param string  $destination Ruta fisica donde se guardará el thumbnail generado, Si se pasa como NULL se generá un thumbnail en memoria.
 * @param string  $width Ancho del thumbnail.
 * @param integer $height Alto del thumbnail.
 * @return bool Retorna un thumbnail o TRUE en caso de haberse guardado en un directorio.
 */
function create_thumbnail($source, $destination = NULL, $width = NULL, $height = NULL) {

    /* get image type */
    $info = getimagesize($source);

    if(!$info){
        return true;
    }

    /* read the source image */
    switch ($info['mime']) {
        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $source_image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $source_image = imagecreatefromgif($source);
            break;
        default:
            return true;
    }

    /* get image size */
    $original_width = imagesx($source_image);
    $original_height = imagesy($source_image);

    /* get the width & height of the thumbnail */
    $width = is_null($width) ? 400 : $width;
    $height = is_null($height) ? floor($original_height * ($width / $original_width)) : $height;

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($width, $height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $width, $height, $original_width, $original_height);

    /* Output image */
    if(is_null($destination)){
        header('Content-Type: '.$info['mime']);
    }

    /* create the physical thumbnail image to its destination */
    switch ($info['mime']) {
        case 'image/jpeg':
            imagejpeg($virtual_image, $destination, 50);
            break;
        case 'image/png':
            imagepng($virtual_image, $destination, 9);
            break;
        case 'image/gif':
            imagegif($virtual_image, $destination);
            break;
    }

    /* Free from memory */
    imagedestroy($virtual_image);

    /* Change File Permissions */
    /*if(!is_null($destination)){
        chmod($destination, 0777);
    }*/

    return TRUE;
}

/**
 * create_txt
 *
 * Genera un archivo txt en memoria o lo guarda en un directorio.
 *
 * @author Christian Josué Jiménez Sánchez <cjimenez@woodward.com.mx>
 * @param string  $data Datos para el archivo.
 * @param string $fileName Nombre del archivo.
 * @param string $delimiter Delimitador para la separación de información del archivo, por default es por comas " , "
 * @param string  $destination Ruta fisica donde se guardará el archivo txt generado, Si se pasa como NULL se generá un archivo txt en memoria.
 * @return bool Retorna un archivo txt o TRUE en caso de haberse guardado en un directorio.
 */
function create_txt($data, $fileName, $delimiter = ',', $destination = NULL){
    $output = '';
    if(is_array($data)){
        foreach($data AS $k=>$v){
            $output .= implode($delimiter, $v)."\r\n";
        }
    }else{
        $output .= $data;
    }

    if(is_null($destination)){
        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename='.$fileName.'.txt');
        echo $output;
    }else{
        $file = fopen($destination . $fileName.'.txt', 'w+');
        fwrite($file,$output);
        fclose($file);
    }

    return TRUE;
}

/**
 * Establece configuracion
 *
 * Establece los valores necesarios para iniciar el streaming de datos.
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
function streamingStart(){
    //Configuracion necesaria para streaming de datos.
    ini_set('zlib.output_handler', '');
    ini_set('zlib.output_compression', 0);
    ini_set('output_handler', '');
    ini_set('output_buffering', false);
    ini_set('implicit_flush', true);
    apache_setenv( 'no-gzip', '1' );
    @ob_end_clean();

    header('Content-Type: text/HTML; charset=utf-8');
    //header('Content-Encoding: none; ' );//disable apache compressed
    header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
    ob_implicit_flush(1);
    return true;
}

/**
 * Streamig de datos
 *
 * Forza el echo de los datos al output de forma
 * instantanea.
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 * @param string $data
 */
function streamData($data){
    echo $data;
    //ob_flush();
    flush();
    usleep(300000);
}

/**
 * Finaliza streaming
 *
 * Finaliza el streaming de datos, regresando las configuraciones
 * alteradas a su valor original.
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 */
function streamigStop(){
    //ini_set('zlib.output_handler','');
    //ini_set('zlib.output_compression', 0);
    ini_restore('output_handler');
    ini_restore('output_buffering');
    ini_restore('implicit_flush');
    ob_implicit_flush(false);
    return true;
}


/**
 * Inicia un cronometro.
 *
 * Agrega un nuevo registro al array DloreanChronoTab,
 * inserta el microtime actual en start, el array posee
 * esta estructura:
 *
 * [
 *      "FlagID" => [
 *          'start' => 213213123 //Microtime de inicio,
 *          'end'   => 31531561 // Microtime de salida,
 *          'wasted'=> 1.3263 // Tiempo gastado en segundos.
 *      ]
 * ]
 *
 * Si el FlagID no es provisto, se tomará el nombre de funcion
 * de donde chronStart sea llamado.
 *
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 * @param string $Flag
 */
function chronStart($Flag = false){

    if(!$Flag){
        $Flag = debug_backtrace(true,2)[1]['function'];
    }

    if(!isset($GLOBALS['DloreanChronoTab'])){
        $GLOBALS['DloreanChronoTab'] = [];
    }

    $tbl = &$GLOBALS['DloreanChronoTab'];

    $tbl[$Flag] = [
        'start' => microtime(true),
        'end'   => 0,
        'wasted'=> 0
    ];

    return true;

}


/**
 * Finaliza cronometro
 *
 * Agrega microtime de finalizado y su diferencia en segundos
 * como flotante con respecto a su inicio.
 *
 * @author Samuel Perez Saldivar <sperez@woodward.com.mx>
 * @param string $Flag
 * @return boolean
 */
function chronEnd($Flag = false){

    if(!$Flag){
        $Flag = debug_backtrace(true,2)[1]['function'];
    }

    if(!isset($GLOBALS['DloreanChronoTab'][$Flag])){
        return false;
    }

    $tbl = &$GLOBALS['DloreanChronoTab'][$Flag];
    $tbl['end'] = microtime(true);
    $tbl['wasted'] = round($tbl['end'] - $tbl['start'] ,4);

    return true;
}


/**
 * Obtener array de tiempos
 *
 * Retorna el array asociativo de la tabla de tiempos.
 *
 * Retorna array de tiempos
 * @return boolean|array
 */
function getChronArray(){

    if(!isset($GLOBALS['DloreanChronoTab'])){
        return false;
    }
    $r = $GLOBALS['DloreanChronoTab'];

    $GLOBALS['DloreanChronoTab'] = [];
    return $r;
}





/**
 * Clase que implementa un coversor de números
 * a letras.
 *
 * Soporte para PHP >= 5.4
 * Para soportar PHP 5.3, declare los arreglos
 * con la función array.
 *
 * @author AxiaCore S.A.S
 *
 */

class NumeroALetras
{
    private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
    ];

    private static $DECENAS = [
        'VEINTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
    ];

    private static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
    ];

    public static function convertir($number, $moneda = '', $centimos = '', $forzarCentimos = false)
    {
        $converted = '';
        $decimales = '';

        if (($number < 0) || ($number > 999999999)) {
            return 'No es posible convertir el numero a letras';
        }

        $div_decimales = explode('.',$number);

        if(count($div_decimales) > 1){
            $number = $div_decimales[0];
            $decNumberStr = (string) $div_decimales[1];
            if(strlen($decNumberStr) == 2){
                $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
                $decCientos = substr($decNumberStrFill, 6);
                $decimales = self::convertGroup($decCientos);
            }
        }
        else if (count($div_decimales) == 1 && $forzarCentimos){
            $decimales = 'CERO ';
        }

        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);

        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
            }
        }

        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', self::convertGroup($miles));
            }
        }

        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertGroup($cientos));
            }
        }

        if(empty($decimales)){
            $valor_convertido = $converted . strtoupper($moneda);
        } else {
            $valor_convertido = $converted . strtoupper($moneda) . ' CON ' . $decimales . ' ' . strtoupper($centimos);
        }

        return $valor_convertido;
    }

    private static function convertGroup($n)
    {
        $output = '';

        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }

        $k = intval(substr($n,1));

        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if(($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }

        return $output;
    }
}