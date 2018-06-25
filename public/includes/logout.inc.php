<?php
// Require all functions.
require 'functions.inc.php';

// Check if the user is logged in, ifso proceed further.
If (CheckIfLoggedIn() == true) {
    // Calling a function to destory all sessions.
	LogoutUser();
	// Redirect user to the homepage.
    header("Location: ../index.php");
} else {
	// If the user was not logged in redirect also to homepage.
    header("Location: ../index.php");
}