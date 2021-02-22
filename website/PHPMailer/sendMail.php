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
            $mail->addAddress('contacto@lgabogadosmanzanillo.com', 'Contacto LG Abogados Manzanillo');
            $mail->addAddress('lgabogadosmanzanillo@gmail.com', 'LG Abogados');
            $mail->addAddress('adrianlgabogadosmanzanillo@gmail.com', 'Adrian Landa');
            $mail->addAddress('citlaliabogadafamiliar@gmail.com', 'Citlali');
            //$mail->addAddress('christianjimenezcjs@gmail.com', 'Christian Jimenez');
    
    if(isset($_POST['correo']) && !empty($_POST['correo'])){
        $mail->addReplyTo($_POST['correo'], '');
        $mail->addReplyTo('contacto@lgabogadosmanzanillo.com', 'Contacto LG Abogados Manzanillo');
        $mail->addReplyTo('lgabogadosmanzanillo@gmail.com', 'LG Abogados');
        $mail->addReplyTo('adrianlgabogadosmanzanillo@gmail.com', 'Adrian Landa');
        $mail->addReplyTo('citlaliabogadafamiliar@gmail.com', 'Citlali');
        //$mail->addAddress('christianjimenezcjs@gmail.com', 'Christian Jimenez');
    }
    
    
    //$mail->addCC('lgabogadosmanzanillo@gmail.com');
    //$mail->addCC('adrianlgabogadosmanzanillo@gmail.com');
    //$mail->addCC('citlaliabogadafamiliar@gmail.com');
    //$mail->addCC('christianjimenezcjs@gmail.com', 'Christian Jimenez');

    //$mail->addBCC('bcc@example.com');
    $mail->addBCC('christianjimenezcjs@gmail.com', 'Christian Jimenez');

    //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Contacto Web - LG Abogados Manzanillo';
        
        

        $mensaje = "<b>Asunto:</b><br> ".(isset($_POST['asunto']) && !empty($_POST['asunto']) ? htmlentities($_POST['asunto'],ENT_QUOTES) : '-');
        $mensaje .= "<br><br><b>Nombre:</b> ".(isset($_POST['nombre']) && !empty($_POST['nombre']) ? htmlentities($_POST['nombre'],ENT_QUOTES) : '-');
        $mensaje .= "<br><b>".htmlentities('Teléfono',ENT_QUOTES).":</b> ".(isset($_POST['telefono']) && !empty($_POST['telefono']) ? htmlentities($_POST['telefono'],ENT_QUOTES) : '-');
        $mensaje .= "<br><b>Correo:</b> ".(isset($_POST['correo']) && !empty($_POST['correo']) ? htmlentities($_POST['correo'],ENT_QUOTES) : '-');
        $mensaje .= "<br><br><b>Mensaje:</b><br> ".(isset($_POST['mensaje']) && !empty($_POST['mensaje']) ? nl2br(htmlentities($_POST['mensaje'],ENT_QUOTES)) : '-');

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