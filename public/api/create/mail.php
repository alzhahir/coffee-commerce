<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$DOMAIN = $_SERVER['HTTP_HOST'];
$PROTOCOL = $_SERVER['HTTPS'] ? 'https://' : 'http://';

$ROOTPATH = $_SERVER["DOCUMENT_ROOT"] . '/..';
require $ROOTPATH . '/vendor/autoload.php';
require $ROOTPATH . '/internal/buildemaillayout.php';
$creds = parse_ini_file($ROOTPATH."/.ini");

$smtpUser = $creds['smtp_user'];
$smtpPass = $creds['smtp_pass'];
$smtpAddr = $creds['smtp_addr'];
$smtpPort = $creds['smtp_port'];
$smtpEncr = $creds['smtp_encr'];
$mailSender = $creds['email_sender'];
$mailSenderName = $creds['email_sender_name'];
$mailReply = $creds['email_reply'];
$mailCc = $creds['email_cc'];
$mailBcc = $creds['email_bcc'];

$smtpAuth = true;

switch($smtpEncr){
    case 0:
        $smtpAuth = false;
        break;
    case 1:
        $smtpSecure = PHPMailer::ENCRYPTION_STARTTLS;
        break;
    case 2:
        $smtpSecure = PHPMailer::ENCRYPTION_SMTPS;
        break;
    default:
        $smtpSecure = PHPMailer::ENCRYPTION_STARTTLS;
        break;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["recipient_address"]) && isset($_POST["subject"]) && isset($_POST["context"])){
        $recipientAdd = $_POST["recipient_address"];
        $mailSubject = $_POST["subject"];
        $mailAlt = $_POST["alternative_body"];
        $mailContext = $_POST["context"];
        $mailContextBody = $_POST["context_object"];
        switch($mailContext){
            case 1:
                $mailStatus = $mailContextBody["status"];
                $mailOrderId = $mailContextBody["order_id"];
                //prepbody
                $mailbody = getEmailObject($mailContext, ['status' => $mailStatus, 'order_id' => $mailOrderId]);
                break;
            case 2:
                $resetPassUrl = $mailContextBody["reset_link"];
                //prepbody
                $mailbody = getEmailObject($mailContext, ['reset_url' => $resetPassUrl]);
                break;
            default:
                $mailbody = getEmailObject($mailContext);
                break;
        }
    } else {
        http_response_code(400);
        die();
    }

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $smtpAddr;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = $smtpAuth;                                   //Enable SMTP authentication
        if(isset($smtpSecure)){
            $mail->Username   = $smtpUser;                     //SMTP username
            $mail->Password   = $smtpPass;                               //SMTP password
            $mail->SMTPSecure = $smtpSecure;            //Enable implicit TLS encryption
        }
        $mail->Port       = $smtpPort;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($mailSender, $mailSenderName);
        $mail->addAddress($recipientAdd);
        $mail->addReplyTo($mailReply);
        if(!empty($mailBcc) && isset($mailBcc)){
            $mail->addBCC($mailBcc);
        }
        if(isset($mailCc) && !empty($mailCc)){
            $mail->addCC($mailCc);
        }

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mailSubject;
        $mail->Body    = $mailbody;
        $mail->AltBody = $mailAlt;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        error_log($mail->ErrorInfo);
        http_response_code('500');
        die();
    }
    echo 'Message has been sent';
    http_response_code(200);
    die();
} else {
    header('X-PHP-Response-Code: 405', true, 405);
    die();
}
?>