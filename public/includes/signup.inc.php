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

                        // Everything is good, proceed to signup query.
                        $query = $conn->query("INSERT INTO `user` (`id`, `admin`, `ip`, `date`, `firstname`, `lastname`, `email`, `password`, `last_login`, `last_ip`) VALUES ('" . GenerateUID() . "', 0, '" . GetUserIP() . "', '" . GetCurrentDate() . "', '" . htmlspecialchars($firstname) . "', '" . htmlspecialchars($lastname) . "', '" . htmlspecialchars($email) . "', '" . HashPassword($password) . "', '" . GetCurrentDate() . "', '" . GetUserIP() . "')");
                        $_SESSION['success'] = "Signup was successful!";
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
    header("Location: ../index.php");
    exit();
}