<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

//Require DB connection.
require 'credentials.inc.php';

//Require Activate Email template
require 'email/activate-template.php';

//Require Forgot Password Email template.
require 'email/resetpw-template.php';

//Require Password Changed Email template
require 'email/password-changed-template.php';

// This function will send an token but it needs some parameters.
function SendEmail($receiveremail, $receivername, $token, $reset, $activate,$pwchanged)
{
    // Secret email password.
    global $secretEmail;

    //Account activation part:
    if ($activate && !$reset) {
        // URL for activating user account.
        $url = "localhost:8080/includes/activate.php?email=" . $receiveremail . "&token=" . $token . "";

        $subject = "Activate Account";

        // Email body message (html supported).
        $body = activateEmailTemplate($receivername, $url);

    }

    //Password reset part
    if ($reset && !$activate) {
        // URL for resetting the users password.
        $url = "localhost:8080/changepw.php?email=" . $receiveremail . "&token=" . $token . "";

        $subject = "Password Reset Request";

        //Email body message (html supported).
        $body = resetPasswordEmailTemplate($url);
    }

    //New password part
    if ($pwchanged && !$activate && !$reset) {
        $subject = "Your password has been changed";

        //Email body message (html supported).
        $body = passwordChangedEmailTemplate();
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