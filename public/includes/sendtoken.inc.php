<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Require DB connection.
require 'credentials.inc.php';

// This function will send an token but it needs some parameters.
function SendToken($receiveremail, $receivername, $token,$reset,$activate)
{
    // Secret email password.
    global $secretEmail;

    //Account activation part:
    if ($activate == true && $reset == false) {
        // URL for activating user account.
        $url = "localhost:8080/activate.php?email=" . $receiveremail . "&token=" . $token . "";

        $subject = "Your account activation";

        // Email body message (html supported).
        $body = "
        <h1>Welcome!</h1>
        <p>Welcome at Oryx Network " . $receivername . ".</p>
        <p>Click on the link below to activate your account</p>
        <p><a href=" . $url . " target='_blank'>" . $url . "</a></p>
        <p>Kind regards</p>
        <p>Oryx Network</p>
        ";

    }

    if ($reset == true && $activate == false) {
        // URL for resetting the users password.
        $url = "localhost:8080/resetpw.php?email=" . $receiveremail . "&token=" . $token . "";

        $subject = "Your password reset";

        // Email body message (html supported).
        $body = "
        <h1>Welcome!</h1>
        <p>Welcome at Oryx Network " . $receivername . ".</p>
        <p>Click on the link below to reset your password</p>
        <p><a href=" . $url . " target='_blank'>" . $url . "</a></p>
        <p>Kind regards</p>
        <p>Oryx Network</p>
        ";
    }

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
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

}