<?php
/**
 * Created by IntelliJ IDEA.
 * User: Luuk Kenselaar <luuk.kenselaar@protonmail.com>
 * Date: 23-6-2018
 * Time: 00:45
 */

//Require the functions
require 'functions.inc.php';
//Require var $conn
require 'dbh.inc.php';

if (isset($_POST['submit'])) {
    $emailPost = $conn->real_escape_string($_POST['loginEmail']);
    $passwordPost = $conn->real_escape_string($_POST['loginPassword']);

    if (CheckIfLoggedIn() == false) {

        if (CheckIfEmptyLogin($emailPost, $passwordPost) == false) {

            // Query the password from DB if the email is registered.
            $query1 = mysqli_query($conn, "SELECT password FROM user WHERE email = '" . $emailPost . "'");

            if (mysqli_num_rows($query1) > 0) {

                // Get the password from the query.
                if ($row = mysqli_fetch_array($query1)) {
                    $hashedPWD = $row['password'];
                }

                // Verify if the password matches the one the user typed.
                if (UnHashPassword($passwordPost, $hashedPWD) == true) {
                    // If the password matches get all the info
                    $query2 = mysqli_query($conn, "SELECT * FROM user WHERE email = '" . $emailPost . "'");
                    // Query all the info from DB.
                    if ($row = mysqli_fetch_array($query2)) {
                        $_SESSION['user']['id'] = $row['id'];
                        $_SESSION['user']['rank'] = $row['admin'];
                        $_SESSION['user']['date'] = $row['date'];
                        $_SESSION['user']['firstname'] = $row['firstname'];
                        $_SESSION['user']['lastname'] = $row['lastname'];
                        $_SESSION['user']['email'] = $row['email'];
                        $_SESSION['user']['lastlogin'] = $row['last_login'];

                        // Update the user last_login time.
                        $UserID = $_SESSION['user']['id'];
                        $queryLastLogin = mysqli_query($conn, "UPDATE user SET last_login = '" . GetCurrentDate() . "' WHERE `user`.`id` = '" . $UserID . "';");

                        // Redirect the user to the feed page.
                        header("Location: ../feed.php");
                    }
                } else {
                    // If the password the user typed in DO NOT match with the DB then go back.
                    header("Location: ../login.php");
                }

            } else {
                header("Location: ../login.php");
                exit();
            }

        } else {
            header("Location: ../login.php");
            exit();
        }

    } else {
        header("Location: ../login.php");
        exit();
    }

} else {
    header("Location ../index.php");
    exit();
}