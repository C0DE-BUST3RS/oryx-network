<?php

//Require the functions
require 'functions.inc.php';
//Require var $conn
require 'dbh.inc.php';

if (isset($_POST['submit'])) {
    //Get the values using POST
    $emailPost = $conn->real_escape_string($_POST['loginEmail']);
    $passwordPost = $conn->real_escape_string($_POST['loginPassword']);

    //Make the value lower case
    $emailPost = strtolower($emailPost);

    //Check if the user is loggedin
    if (CheckIfLoggedIn() == false) {

        //Check if the email has been used
        if (CheckIfEmailUsed($emailPost) == true) {

            //Check if the login fields are not empty
            if (CheckIfEmptyLogin($emailPost, $passwordPost) == false) {

                //Check if the account has been activated
                if (CheckIfActivated($emailPost) == true) {

                    //Get all data about the user
                    $sql = $conn->query("SELECT * FROM user WHERE email = '$emailPost';");
                    $row = $sql->fetch_array();

                    $hashedPWD = $row['password'];

                    // Verify if the password matches the one the user typed.
                    if (UnHashPassword($passwordPost, $hashedPWD) == true) {

                        //ID from DB.user - example: 09221D38-D97D12BF-12BF2AFD
                        $_SESSION['user']['id'] = $row['id'];

                        //Update the user last_login time.
                        $UserID = $_SESSION['user']['id'];
                        $query = $conn->query("UPDATE user SET last_login = '" . GetCurrentDate() . "' WHERE `user`.`id` = '" . $UserID . "';");

                        //Update the user last_ip time.
                        $query = $conn->query("UPDATE user SET last_ip = '" . GetUserIP() . "' WHERE `user`.`id` = '" . $UserID . "';");

                        //Get all data about the user
                        $sql = $conn->query("SELECT * FROM user WHERE email = '$emailPost';");
                        $row = $sql->fetch_array();

                        //admin from DB.user - 0 = user, 1 = admin
                        $_SESSION['user']['admin'] = $row['admin'];

                        //Date from signup - DB.user
                        $_SESSION['user']['date'] = $row['date'];

                        //IP from DB.user - Like 10.2.2.2
                        $_SESSION['user']['ip'] = $row['ip'];

                        //Firstname from DB.user
                        $_SESSION['user']['firstname'] = $row['firstname'];

                        //Lastname from DB.user
                        $_SESSION['user']['lastname'] = $row['lastname'];

                        //Get the full name from DB.user
                        $_SESSION['user']['fullname'] = $row['firstname'] . " " . $row['lastname'];

                        //Email from DB.user - Like test@test.com
                        $_SESSION['user']['email'] = $row['email'];

                        //Lastlogin from DB.user - Like 2018-06-24 12:11:23
                        $_SESSION['user']['lastlogin'] = $row['last_login'];

                        //Last Logged in IP - Like 10.2.2.3
                        $_SESSION['user']['lastip'] = $row['last_ip'];

                        //Get all profile data
                        $query = $conn->query("SELECT * FROM profiles WHERE user_id = '$UserID';");
                        $row = $query->fetch_array();

                        // Get user profile picture
                        $_SESSION['user']['picture'] = $row['profile_picture'];

                        // Get user intro text on profile
                        $_SESSION['user']['introduction'] = $row['intro'];

                        //Redirect the user to the feed page.
                        header("Location: ../feed.php?login=successfull");
                        exit();

                    } else {
                        // If the password the user typed in DOES NOT match with the DB then redirect.
                        $_SESSION['loginfailed'] = "";
                        header("Location: ../login.php?login=failed");
                        exit();
                    }

                } else {
                    //If the account is not activated redirect the user
                    $_SESSION['loginfailed'] = "";
                    header("Location: ../login.php?login=failed");
                    exit();
                }

            } else {
                //If the fields were empty then redirect
                $_SESSION['loginfailed'] = "";
                header("Location: ../login.php?login=failed");
                exit();
            }

        } else {
            //If the email does not exist redirect
            $_SESSION['loginfailed'] = "";
            header("Location: ../login.php?login=failed");
            exit();
        }

    } else {
        //If the user is already logged in then redirect
        $_SESSION['loginfailed'] = "";
        header("Location: ../login.php?login=failed");
        exit();
    }

} else {
    //If the login button was not pressed redirect
    header("Location ../index.php");
    exit();
}