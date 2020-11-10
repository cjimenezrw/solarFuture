<?php
/*
// Required: anonymous function reference number as explained above.
$funcNum = $_GET['CKEditorFuncNum'] ;
// Optional: instance name (might be used to load a specific configuration file or anything else).
$CKEditor = $_GET['CKEditor'] ;
// Optional: might be used to provide localized messages.
$langCode = $_GET['langCode'] ;
// Optional: compare it with the value of `ckCsrfToken` sent in a cookie to protect your server side uploader against CSRF.
// Available since CKEditor 4.5.6.
$token = $_POST['ckCsrfToken'] ;

// Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
$url = 'files/';
// Usually you will only assign something here if the file could not be uploaded.
$message = 'The uploaded file has been renamed';
//echo $funcNum."||".$token."||".$langCode;
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
*/

$target_dir = "/home/lvaldez/public_html/sys/tick/view/files";
 $tmp_name = $_FILES["upload"]["tmp_name"];
$file_name = basename($_FILES["upload"]["name"]);

$uploadOk = 1;
$subida   = move_uploaded_file($tmp_name,$target_dir.$file_name);
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$data =  array(   "fileName" => $file_name, "uploaded" => $uploadOk,   "url" => $target_dir.$file_name );
header('Content-Type: application/json');
echo json_encode($data);
  return true;


?>
