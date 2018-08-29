<?php
//Require the functions
require_once 'functions.inc.php';
require_once 'sendtoken.inc.php';
//Require var $conn
require 'dbh.inc.php';

if (isset($_POST['submit'])) {
    //Define variable from POST
    $firstname = $conn->real_escape_string($_POST['registerFirstname']);
    $lastname = $conn->real_escape_string($_POST['registerLastname']);
    $email = $conn->real_escape_string($_POST['registerEmail']);
    $password = $conn->real_escape_string($_POST['registerPassword']);

    //Make the values lower case
    $firstname = strtolower($firstname);
    $lastname = strtolower($lastname);
    $email = strtolower($email);

    //Get the users ip
    $ip = GetUserIP();

    //Check if the values are not empty
    if (CheckIfEmptySignup($firstname, $lastname, $email, $password)) {

        //Check if the name is a real name
        if (CheckIfRealName($firstname, $lastname)) {

            //Check if its a real email
            if (CheckIfRealEmail($email)) {

                //Check if the email is already present in the database. if not (false) proceed further.
                if (!CheckIfEmailUsed($email)) {

                    //Check if the password is long enough
                    if (CheckIfPasswordLongEnough($password)) {

                        //Generate a user ID
                        $uid = GenerateUID();

                        //Generate a activation token
                        $token = GenerateToken();

                        //Convert the values
                        $firstname = htmlspecialchars($firstname);
                        $lastname = htmlspecialchars($lastname);
                        $email = htmlspecialchars($email);

                        //Place all the data in the DB rows

                        //USER DATA
                        $stmt = $conn->prepare("INSERT INTO user (id, activated, admin, date, ip, firstname, lastname, email, password, last_login, last_ip) VALUES (?,0,?,?,?,?,?,?,?,?,?)");
                        $stmt->bind_param("sssssssss", $uid, GetUserIP(), GetCurrentDate(), $firstname, $lastname, $email, HashPassword($password), GetCurrentDate(), GetUserIP());
                        $stmt->execute();

                        //ACTIVATION DATA
                        $stmt = $conn->prepare("INSERT INTO activationtoken (id, date, user_id, email, used, value) VALUES ('',?,?,?,0,?)");
                        $stmt->bind_param("ssss", GetCurrentDate(),$uid, $email, $token);
                        $stmt->execute();

                        //LEVEL DATA
                        $stmt = $conn->prepare("INSERT INTO level (id, user_id, current_level, current_xp, amount_to_level_up, last_level_up, level_icon) VALUES ('',?,0,0,0,'0000-00-00 00:00:00','img/levels/rank000.png')");
                        $stmt->bind_param("s",$uid);
                        $stmt->execute();

                        //PROFILE DATA
                        $stmt = $conn->prepare("INSERT INTO profiles (id, user_id, profile_picture, intro) VALUES ('',?,'','') ");
                        $stmt->bind_param("s",$uid);
                        $stmt->execute();

                        //Send the activation token to the user
                        SendToken(htmlspecialchars($email), $firstname . " " . $lastname, $token, false, true);

                        //Set the success status
                        $_SESSION['success'] = "Signup was successful! <br> Please check your email!";

                        //Redirect the user to the login page
                        header("Location: ../login.php?signup=succesfull");
                        exit();

                    } else {
                        //Set the error status
                        $_SESSION['status'] = "Password not long enough!";
                        //Make the sessions, the sessions will be filled in at the form
                        RefillAtErrorSignup($firstname, $lastname, $email);
                        //Redirect the user back to index.php
                        header("Location: ../index.php?error=length");
                        exit();
                    }
                } else {
                    //Set the error status
                    $_SESSION['status'] = "Email taken!";
                    //Make the sessions, the sessions will be filled in at the form
                    RefillAtErrorSignup($firstname, $lastname, $email);
                    //Redirect the user back to index.php
                    header("Location: ../index.php?error=emailtaken");
                    exit();
                }
            } else {
                //Set the error status
                $_SESSION['status'] = "Email incorrect!";
                //Make the sessions, the sessions will be filled in at the form
                RefillAtErrorSignup($firstname, $lastname, $email);
                header("Location: ../index.php?error=emailincorrect");
                exit();
            }

        } else {
            //Set the error status
            $_SESSION['status'] = "False name!";
            //Make the sessions, the sessions will be filled in at the form
            RefillAtErrorSignup($firstname, $lastname, $email);
            header("Location: ../index.php?error=falsename");
            exit();
        }

    } else {
        //Set the error status
        $_SESSION['status'] = "Signup is empty!";
        //Make the sessions, the sessions will be filled in at the form
        RefillAtErrorSignup($firstname, $lastname, $email);
        header("Location: ../index.php?error=empty");
        exit();
    }

} else {
    header("Location: ../index.php");
    exit();
}