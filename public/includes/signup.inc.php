<?php
//Require the functions
require_once 'functions.inc.php';
//Require var $conn
require 'dbh.inc.php';

if (isset($_POST['submit'])) {
    // Define variable from POST
    $firstname = $conn->real_escape_string($_POST['registerFirstname']);
    $lastname = $conn->real_escape_string($_POST['registerLastname']);
    $email = $conn->real_escape_string($_POST['registerEmail']);
    $password = $conn->real_escape_string($_POST['registerPassword']);

    //Make the value lower case
    $email = strtolower($email);

    //Define variable from POST for Recaptcha
    $responseKey = $_POST['g-recaptcha-response'];
    $ip = GetUserIP();

    //Check if the recaptcha has been clicked
    if (RecaptchaCheck($responseKey,$ip) == true) {

        //Check if the values are not empty
        if (CheckIfEmptySignup($firstname, $lastname, $email, $password) == true) {

            //Check if the name is a real name
            if (CheckIfRealName($firstname, $lastname) == true) {

                //Check if its a real email
                if (CheckIfRealEmail($email) == true) {

                    // Check if the email is already present in the database. if not (false) proceed further.
                    if (CheckIfEmailUsed($email) == false) {

                        //Check if the password is long enough
                        if (CheckIfPasswordLongEnough($password) == true) {

                            //Generate a user ID
                            $uid = GenerateUID();

                            // Everything is good, proceed to signup query.
                            $accountquery = $conn->query("INSERT INTO `user` (`id`, `admin`, `ip`, `date`, `firstname`, `lastname`, `email`, `password`, `last_login`, `last_ip`) VALUES ('" . $uid . "', 0, '" . GetUserIP() . "', '" . GetCurrentDate() . "', '" . htmlspecialchars($firstname) . "', '" . htmlspecialchars($lastname) . "', '" . htmlspecialchars($email) . "', '" . HashPassword($password) . "', '" . GetCurrentDate() . "', '" . GetUserIP() . "')");
                            $tokenquery = $conn->query("INSERT INTO activationtoken (id, date, user_id, email, used, value) VALUES ('','" . GetCurrentDate() . "','" . $uid . "','" . htmlspecialchars($email) . "',0,'" . GenerateToken() . "')");

                            $_SESSION['success'] = "Signup was successful! <br> Please check your email!";
                            header("Location: ../index.php?signup=succesfull");
                            exit();

                        } else {
                            // ERROR go back and fix.
                            $_SESSION['status'] = "Password not long enough!";
                            header("Location: ../index.php?error=length");
                            exit();
                        }
                    } else {
                        // ERROR go back and fix.
                        $_SESSION['status'] = "Email taken!";
                        header("Location: ../index.php?error=emailtaken");
                        exit();
                    }
                } else {
                    // ERROR go back and fix.
                    $_SESSION['status'] = "Email incorrect!";
                    header("Location: ../index.php?error=emailincorrect");
                    exit();
                }

            } else {
                // ERROR go back and fix.
                $_SESSION['status'] = "False name!";
                header("Location: ../index.php?error=falsename");
                exit();
            }

        } else {
            // ERROR go back and fix.
            $_SESSION['status'] = "Signup is empty!";
            header("Location: ../index.php?error=empty");
            exit();
        }

    } else {
        // ERROR go back and fix.
        $_SESSION['status'] = "Recaptcha error!";
        header("Location: ../index.php?error=recaptcha");
        exit();
    }

} else {
    header("Location: ../index.php");
    exit();
}