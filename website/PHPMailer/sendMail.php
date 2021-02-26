<?php
//exit("<pre>".print_r($_POST,1)."</pre>");
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.lgabogadosmanzanillo.com';        // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'contacto@lgabogadosmanzanillo.com';    // SMTP username
    $mail->Password = 'LCK#bXcvn6j0';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
        //This is the email your form sends From
            $mail->setFrom('contacto@lgabogadosmanzanillo.com', 'Contacto LG Abogados Manzanillo');

        // Add a recipient address
            $mail->addAddress('christianjimenezcjs@gmail.com', 'Christian Jimenez');
            $mail->addAddress('luisalberto1192@gmail.com', 'Luis Valdez');
    
    if(isset($_POST['correo']) && !empty($_POST['correo'])){
        $mail->addReplyTo($_POST['correo'], '');
        $mail->addReplyTo('christianjimenezcjs@gmail.com', 'Christian Jimenez');
    }
    
    
    $mail->addCC('christianjimenezcjs@gmail.com', 'Christian Jimenez');

    $mail->addBCC('christianjimenezcjs@gmail.com', 'Christian Jimenez');

    //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Contacto Web - Solar Future Manzanillo';

        $mensaje = '<style type="text/css">@font-face {  font-family: "Assistant";  font-style: normal;  font-weight: 400;  src: local("Assistant"), local("Assistant-Regular"), url(https://fonts.gstatic.com/s/assistant/v2/2sDcZGJYnIjSi6H75xkzamW5O7w.woff2) format("woff2");  unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;}/* latin */@font-face {  font-family: "Assistant";  font-style: normal;  font-weight: 400;  src: local("Assistant"), local("Assistant-Regular"), url(https://fonts.gstatic.com/s/assistant/v2/2sDcZGJYnIjSi6H75xkzaGW5.woff2) format("woff2");  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}body{  background-color: #f1f4f5;}.div1 {  width: 100%;  height:auto;  background-color:#064480 ;  margin: 0 auto;  border-radius: 5px 5px 0px 0px;  text-align: center;}.div2 {  width: 100%;  height:auto;  background-color:#FFFFFF ;  margin: 0 auto;  text-align: center;}.div3{  width: 100%;  height:auto;  background-color:#ffffff ;  margin: 0 auto;  border-radius: 0px 0px 5px 5px;  text-align: center;}.cont{  width: 50%;  min-width: 500px;  max-width: 700px;  height:auto;  margin: 0 auto;  border-radius: 5px 5px 5px 5px;}.imgMail{  width: 100px;}.imgFooter{  width: 100px;}.title-mail{  color: #ffffff;  font-family: "Assistant"; font-size: 22px;}.message-mail{  color: #000000;  font-family: "Assistant"; font-size: 16px;  font-weight: 600;}.footer-text-mail{  color: #76838f;  font-family: "Assistant"; font-size: 13px;}.footer{  background-color: #f5f5f5;  border-radius: 0px 0px 5px 5px;}.button {  background-color: #064480;  border: none;  color: white;  padding: 10px;  text-align: center;  text-decoration: none;  display: inline-block;  font-size: 16px;  margin: 4px 2px;  cursor: pointer;  border-radius: 4px;}.widget {  box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);  -webkit-box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);  -moz-box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);}</style><center><div style="background-color:#064480; border-radius:5px 5px 0px 0px; height:auto; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; text-align:center; width:700px" class="div1"><div style="text-align:center"><br></div>
            <div style="text-align:center"><br></div>
            <div style="text-align:center"><img data-cke-saved-src="https://teasermanzanillo.com.mx/images/mail.png" src="https://teasermanzanillo.com.mx/images/mail.png" style="width:100px" class="imgMail"></div>
            <div style="color:#ffffff; font-family:Tahoma,Verdana,Segoe,sans-serif; font-size:22px; text-align:center" class="title-mail">&nbsp;Solar Future Manzanillo</div>
            <div style="text-align:center"><br></div>
            <div style="text-align:center"><br></div>
            </div>
            <div style="height:auto; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; text-align:center; width:700px" class="div2"><div style="text-align:center"><br></div>
            </div>
            <div style="width: 700px; color:#000000; font-family:Tahoma,Verdana,Segoe,sans-serif; font-size:16px; text-align:center" class="message-mail">

            <p><span style="font-weight: bold;">Asunto</span><br>
            <span style="font-weight: normal;">'.(isset($_POST['asunto']) && !empty($_POST['asunto']) ? htmlentities($_POST['asunto'],ENT_QUOTES) : '-').'</span></p>

            <p><span style="font-weight: bold;">Nombre</span><br>
            <span style="font-weight: normal;">'.(isset($_POST['nombre']) && !empty($_POST['nombre']) ? htmlentities($_POST['nombre'],ENT_QUOTES) : '-').'</span></p>

            <p><span style="font-weight: bold;">'.htmlentities('Teléfono',ENT_QUOTES).'</span><br>
            <span style="font-weight: normal;">'.(isset($_POST['telefono']) && !empty($_POST['telefono']) ? htmlentities($_POST['telefono'],ENT_QUOTES) : '-').'</span></p>

            <p><span style="font-weight: bold;">Correo</span><br>
            <span style="font-weight: normal;">'.(isset($_POST['correo']) && !empty($_POST['correo']) ? htmlentities($_POST['correo'],ENT_QUOTES) : '-').'</span></p>

            <p><span style="font-weight: bold;">Mensaje</span><br>
            <span style="font-weight: normal;">'.(isset($_POST['mensaje']) && !empty($_POST['mensaje']) ? nl2br(htmlentities($_POST['mensaje'],ENT_QUOTES)) : '-').'</span></p>
            </div>

            <center><div style="border-radius:0px 0px 5px 5px; height:auto; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; text-align:center; width:700px" class="div3"><div style="text-align:center"><br></div>
            <div style="color:#76838f; font-family:Tahoma,Verdana,Segoe,sans-serif; font-size:13px; text-align:center" class="footer-text-mail">Solar Future Manzanillo</div>
            <div style="text-align:center"><br></div>
            <div style="background-color:#f5f5f5; border-radius:0px 0px 5px 5px; text-align:center" class="footer"><img data-cke-saved-src="https://teasermanzanillo.com.mx/images/logomail.png" src="https://teasermanzanillo.com.mx/images/logomail.png" style="width:100px" class="imgFooter"></div>
            </div>
            </center></center>';

        $mail->Body = $mensaje;

        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    header('Content-Type: application/json');
    echo json_encode(['success'=>TRUE,'message'=>'Mensaje Enviado, nos pondrémos en contacto lo más pronto posible.','datos'=>NULL]);
    return TRUE;

} catch (Exception $e) {

    header('Content-Type: application/json');
    echo json_encode(['success'=>FALSE,'message'=>'Hubo un error al enviar el mensaje, Intenta nuevamente.','datos'=>$mail->ErrorInfo]);
    return FALSE;
}
?>