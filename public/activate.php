<?php
// Require functions file. (includes DB + session_start)
require 'includes/functions.inc.php';

if (CheckIfLoggedIn() == true) {
	header("Location: feed.php");
	exit();
}

if ($_GET['email'] && $_GET['token']) {

	$getEmail = htmlspecialchars($_GET['email']);
	$getToken = htmlspecialchars($_GET['token']);

	if (!empty($getEmail) && !empty($getToken)) {

        // Check if activation token is same as in DB.
        if(CheckbeforeActivation($getEmail, $getToken) == true) {

            if(ActivateAccount($getEmail) == true) {
                // Set session message.
                $_SESSION['status']['activated'] = "Account was successfully activated! <br> You can now login.";
                // Redirect to login page.
                header("Location: login.php?activate=succesful");
                exit();
            } else {
                // Account is not a.
            }

        } else {
            // Token is not same as DB.
        }

	} else {
		// Email is empty.
	}
}