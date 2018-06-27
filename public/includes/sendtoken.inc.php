<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require DB connection.
require 'dbh.inc.php';
// Require everything needed for composer + phpmailer.
require 'vendor/load-all.php';

// This function will send an activation token but needs some parameters.
function SendToken($receiveremail, $receivername, $token)
{
	// Secret email password.
    global $secretEmail;

    // URL for activating user account.
    $url = "localhost:8080/activate.php?email=" . $receiveremail . "?token=" . $token . "";

    // Email body message (html supported).
    $body = "
    <h1>Welcome!</h1>
    <p>Welcome at Oryx Network " . $receivername . ".</p>
    <p>Click on the link below to activate your account</p>
    <p><a href=".$url." target='_blank'>" . $url . "</a></p>
    <p>Kind regards</p>
    <p>Oryx Network</p>
    ";

    // Initialize PHPMailer instance.
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = gethostbyname('mail.oryx.network');
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@oryx.network';
        $mail->Password = $secretEmail;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        $mail->setFrom("noreply@oryx.network", "Oryx Network");
        $mail->addAddress($receiveremail, $receivername);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Your activation code';
        $mail->Body = $body;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

}