<?php
// Require functions file. (includes DB + session_start)
require 'includes/functions.inc.php';

if (CheckIfLoggedIn() == true) {
    header("Location: feed.php");
    exit();
}

if ($_GET['email'] && $_GET['token']) {

    //Get all the data
    $getEmail = htmlspecialchars($_GET['email']);
    $getToken = htmlspecialchars($_GET['token']);

    if (!empty($getEmail) && !empty($getToken)) {

        //Check if the account is not already activated
        if (CheckIfActivated($getEmail) == false) {

            // Check if activation token is same as in DB.
            if (CheckbeforeActivation($getEmail, $getToken) == true) {

                //Activate the final account
                if (ActivateAccount($getEmail) == true) {
                    // Set session message.
                    $_SESSION['status']['activated'] = "Account was successfully activated! <br> You can now login.";
                    // Redirect to login page.
                    header("Location: login.php?activate=succesful");
                    exit();

                } else {
                    // Set session message.
                    $_SESSION['status']['activated'] = "There was a problem with activating the account";
                    // Redirect to login page.
                    header("Location: login.php?activate=failed");
                    exit();
                }

            } else {
                // Redirect to login page.
                header("Location: login.php");
                exit();
            }

        } else {
            // Redirect to login page.
            header("Location: login.php");
            exit();
        }

    } else {
        // Redirect to login page.
        header("Location: login.php");
        exit();
    }

} else {
    // Redirect to login page.
    header("Location: login.php");
    exit();
}