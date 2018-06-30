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
function SendToken($receiveremail, $receivername, $token, $reset, $activate)
{
    // Secret email password.
    global $secretEmail;

    //Account activation part:
    if ($activate == true && $reset == false) {
        // URL for activating user account.
        $url = "localhost:8080/includes/activate.php?email=" . $receiveremail . "&token=" . $token . "";

        $subject = "Your account activation";

        // Email body message (html supported).
        $body = "
        <ul id=\"bbt-builder-container\" class=\"builder-module-list ui-sortable\">
					                <li class=\"email-element\" data-module-id=\"235069\">
                    
    <table class=\"wrapper_table\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; max-width: 800px;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">
      
        <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
            <td class=\"bluebg\" data-color-bluebg=\"background-color\" align=\"center\" height=\"100%\" valign=\"top\" width=\"100%\" style=\"text-size-adjust: 100%;background-color: #5479ff\" bgcolor=\"#5479ff\">
                <!--[if mso]>
                <table role=\"presentation\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"800\">
                <tr>
                <td align=\"center\" valign=\"top\" width=\"800\">
                <![endif]-->
                <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; max-width: 620px;\">
                    <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                        <td align=\"center\" valign=\"top\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 0;\">
                            <!--[if mso]>
                            <table role=\"presentation\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"620\">
                            <tr>
                            <td align=\"left\" valign=\"top\" width=\"620\">
                            <![endif]-->
                            <div style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; display: inline-block; margin: 0 -2px; max-width: 100%; min-width: 226px; vertical-align: top; width: 100%;\" class=\"stack-column\">
                                <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                    <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                        <td style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding: 10px 10px 0;\">
                                            <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 14px; text-align: left;\">
                                                <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                    <td style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                    <div style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"mobile_centered_table\" align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                            <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"34\" class=\"space_class\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 1px; line-height: 1px;\"> &nbsp;
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                    <a href=\"#\" target=\"_blank\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; text-decoration: none !important;\">
                                                                        <img src=\"https://i.imgur.com/IawN3CR.png\" width=\"120\" style=\"text-size-adjust: 100%; border: 0px; display: block; max-width: 120px; width: 100%;\" class=\"center-on-narrow\" alt=\"\" height=\"120\" title=\"\">  
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"59\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" class=\"\">
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-bottom: 3px;\">
                                                                    <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                        <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                           <td height=\"4\" width=\"565\" class=\"whitebg space_class\" data-color-whitebg=\"background-color\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 5px; font-size: 1px; line-height: 1px;\" bgcolor=\"#ffffff\">&nbsp;
                                                                           </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-bottom: 3px;\">
                                                                    <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                        <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                           <td height=\"4\" width=\"585\" class=\"whitebg space_class\" data-color-whitebg=\"background-color\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 5px; font-size: 1px; line-height: 1px;\" bgcolor=\"#ffffff\">&nbsp;
                                                                           </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </div>
                                                    </td>
                                                </tr>
                                                <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                    <td class=\"whitebg\" data-color-whitebg=\"background-color\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 3px;\" bgcolor=\"#ffffff\">
                                                        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"mobile_centered_table\" align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                            <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"63\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" class=\"\">
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td class=\"roboto weight400 text21\" data-editable=\"\" data-color-text21=\"color\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #212121; font-family: 'Roboto', sans-serif; font-size: 31px; font-weight: 400; line-height: 31px;\" align=\"center\">Hi, $receivername!</td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"29\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" class=\"\">
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td class=\"roboto weight400 greytext9b\" data-editable=\"\" data-color-greytext9b=\"color\" data-font-paragraph=\"\" data-line-paragraph=\"\" style=\"text-size-adjust: 100%; color: rgb(155, 155, 155); font-family: Roboto, sans-serif; font-size: 13px; font-weight: 400; line-height: 24px;\" align=\"center\">Thanks for creating an account with us. To continue, <span class=\"nomobile\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\"> <br style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\"></span> please activate your account by clicking the button below.</td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"29\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                    <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"mobile_centered_table\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                        <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                            <td align=\"center\" data-editable=\"button\" class=\"button block pinkbg\" width=\"248\" height=\"50\" data-color-buttonpinkbg=\"background-color\" style=\"text-size-adjust: 100%; background-color: rgb(249, 159, 34); border-color: rgb(63, 63, 63); border-width: 0px; border-radius: 31px;\" bgcolor=\"#f99f22\">
                                                                                <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                                    <tbody><tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                                        <td class=\"roboto weight_500 whitetext uppercase\" data-color-whitetext=\"color\" align=\"center\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: 'Roboto', sans-serif; font-size: 18px; text-decoration: none; text-transform: uppercase;\">
                                                                                            <a data-color-buttonwhitetext=\"color\" href='$url' target='_blank' class=\"whitetext block\" style=\"text-size-adjust: 100%; color: rgb(255, 255, 255); text-decoration: none !important; line-height: 50px;\">
                                                                                               ACTIVATE ACCOUNT
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody></table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"30\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td class=\"roboto weight400 greytext9b\" data-editable=\"\" data-color-greytext9b=\"color\" data-font-paragraph=\"\" data-line-paragraph=\"\" style=\"text-size-adjust: 100%; color: rgb(155, 155, 155); font-family: Roboto, sans-serif; font-size: 13px; font-weight: 400; line-height: 22px;\" align=\"center\">Or if you wish, you can activate using this link: <span class=\"nomobile\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\"> <br style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\"></span><a href='$url'>$url</a></td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"26\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                </td>
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                
                                                            </tr>
                                                            <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                <td height=\"34\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </div>
                            <!--[if mso]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                    <tr style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                        <td height=\"148\" style=\"-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                        </td>
                    </tr>
                </tbody></table>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
     
    </tbody></table>
</ul>
        ";

    }

    //Password reset part
    if ($reset == true && $activate == false) {
        // URL for resetting the users password.
        $url = "localhost:8080/includes/resetpw.php?email=" . $receiveremail . "&token=" . $token . "";

        $subject = "Your password reset";

        // Email body message (html supported).
        $body = "
        <h1>Hi!</h1>
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