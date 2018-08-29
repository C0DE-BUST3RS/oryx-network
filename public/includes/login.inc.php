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

    //Check if the user is logged in
    if (!CheckIfLoggedIn()) {

        //Check if the email has been used
        if (CheckIfEmailUsed($emailPost)) {

            //Check if the login fields are not empty
            if (!CheckIfEmptyLogin($emailPost, $passwordPost)) {

                //Check if the account has been activated
                if (CheckIfActivated($emailPost)) {

                    //Get all data about the user
                    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
                    $stmt->bind_param("s", $emailPost);

                    //If query was successful
                    if ($stmt->execute()) {

                        //Get the results
                        $result = $stmt->get_result();

                        //Fetch the data
                        $row = $result->fetch_assoc();

                        //Get the password
                        $hashedPWD = $row['password'];

                        // Verify if the password matches the one the user typed.
                        if (UnHashPassword($passwordPost, $hashedPWD)) {

                            //Get some data about the user
                            $UserID = $_SESSION['user']['id'] = $row['id'];
                            $date = GetCurrentDate();
                            $ip = GetUserIP();

                            //Update the users last login time
                            $stmt = $conn->prepare("UPDATE user SET last_login = ? WHERE id = ?");
                            $stmt->bind_param("ss", $date, $UserID);
                            $stmt->execute();

                            //Update the users last ip
                            $stmt = $conn->prepare("UPDATE user SET last_ip = ? WHERE id = ?");
                            $stmt->bind_param("ss", $ip, $UserID);
                            $stmt->execute();

                            //Get the user data
                            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
                            $stmt->bind_param("s", $emailPost);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            //Rank
                            $_SESSION['user']['admin'] = $row['admin'];

                            //Signup date
                            $_SESSION['user']['date'] = $row['date'];

                            //IP
                            $_SESSION['user']['ip'] = $row['ip'];

                            //Firstname
                            $_SESSION['user']['firstname'] = $row['firstname'];

                            //Lastname
                            $_SESSION['user']['lastname'] = $row['lastname'];

                            //Fullname
                            $_SESSION['user']['fullname'] = $row['firstname']." ".$row['lastname'];

                            //Email
                            $_SESSION['user']['email'] = $row['email'];

                            //Lastlogin time
                            $_SESSION['user']['lastlogin'] = $row['last_login'];

                            //Lastlogin ip
                            $_SESSION['user']['lastip'] = $row['last_ip'];

                            //Get the profile data
                            $stmt = $conn->prepare("SELECT * FROM profiles WHERE user_id = ?");
                            $stmt->bind_param("s", $UserID);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            //Profile picture path
                            $_SESSION['user']['picture'] = $row['profile_picture'];

                            //Profile intro text
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
                        //If the query failed
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