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

	if (!empty($getEmail)) {
		if (!empty($getToken)) {

			// Check if activation token is same as in DB.
			if(CheckActivation($getEmail, $getToken) == true) {

				if(ActivateAccount($getEmail) == true) {
					// Set session message.
					$_SESSION['activated'] = "Account is successful activated! <br> Login Now!";
					// Redirect to login page.
					header("Location: login.php");
				} else {
					// Account is not actived.
				}

			} else {
				// Token is not same as DB.
			}

		} else {
			// Token is empty.
		}

	} else {
		// Email is empty.
	}
}