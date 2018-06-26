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
						header("Location: ../index.php?signup=succesfull");
						exit();

					} else {
						// ERROR go back and fix.
						header("Location: ../index.php?error");
						exit();
					}
				} else {
					// ERROR go back and fix.
					header("Location: ../index.php?error");
					exit();
				}
			} else {
				// ERROR go back and fix.
				header("Location: ../index.php?error");
				exit();
			}

		} else {
			// ERROR go back and fix.
			header("Location: ../index.php?error");
			exit();
		}

	} else {
		// ERROR go back and fix.
		header("Location: ../index.php?error");
		exit();
	}

} else {
	header("Location: ../index.php");
	exit();
}