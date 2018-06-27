<?php
// Require functions file. (includes DB + session_start)
require 'includes/functions.inc.php';

if (CheckIfLoggedIn() == true) {
	header("Location: feed.php");
	exit();
}

echo $_GET['email'];
echo $_GET['token'];

if ($_GET['email']) {

	$getEmail = htmlspecialchars($_GET['email']);
	$getToken = htmlspecialchars($_GET['token']);

	if (!empty($getEmail)) {
		if (!empty($getToken)) {

			// Check if activation token is same as in DB.
			if(CheckActivation($getEmail, $getToken) == true) {

				ActivateAccount($getEmail, $getToken);

				header("Location: /feed.php");
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