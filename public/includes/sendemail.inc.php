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

//Require API key request accepted Email template
require 'email/api-key-accepted-template.php';

//Require API key request declined Email template
require 'email/api-key-declined-template.php';

// This function will send an token but it needs some parameters.
function SendEmail($receiveremail = false, $receivername = false, $token = false, $reset = false, $activate = false, $pwchanged = false, $keyaccepted = false, $keydeclined = false)
{
    // Secret email password.
    global $secretEmail;

    //Account activation part:
    if ($activate && !$reset) {
        // URL for activating user account.
        $url = "https://www.oryx.network/includes/activate.php?email=" . $receiveremail . "&token=" . $token . "";

        $subject = "Activate Account";

        // Email body message (html supported).
        $body = activateEmailTemplate($receivername, $url);

    }

    //Password reset part
    if ($reset && !$activate) {
        // URL for resetting the users password.
        $url = "https://www.oryx.network/changepw.php?email=" . $receiveremail . "&token=" . $token . "";

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

    //API key accepted part
    if ($keyaccepted && !$keydeclined) {
        $subject = "Your API key request status";

        //Email body message (html supported).
        $body = apiKeyRequestAcceptedTemplate();
    }

    //API key declined part
    if ($keydeclined && !$keyaccepted) {
        $subject = "Your API key request status";

        //Email body message (html supported).
        $body = apiKeyRequestDeclinedTemplate();
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