<?php
//Require the functions and start the session
require 'functions.inc.php';

//Check if the user has been logged in
If (!CheckIfLoggedIn()) {
	header("Location: ../index.php");
}

if (isset($_POST['messageSubmit']) && isset($_SESSION['user']['id'])) {
	global $conn;

	// Set timezone to Europe -> Amsterdam
	date_default_timezone_set('Europe/Amsterdam');

	// Define POST variables to custom variables.
	$postUserID = $conn->real_escape_string($_POST['userID']);
	$postMessage = $conn->real_escape_string($_POST['textarea']);

	// Create datetime for SQL.
	$date = date("Y-m-d H:i:s");

	// Add a new post submitted by the user.
	$stmt = $conn->prepare("INSERT INTO post (`id`, `date`, `user_id`, `likes`, `content`) VALUES (NULL, ?, ?, 0, ?)");
	$stmt->bind_param("sss", $date, $postUserID, $postMessage);
	$stmt->execute();

	// Redirect user back to feed page.
	header("Location: ../feed.php?action=post-successfull");
}