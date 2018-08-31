<?php
//Require the functions and start the session
require 'functions.inc.php';

//Check if the user has been logged in
If (!CheckIfLoggedIn()) {
	header("Location: ../index.php");
}

if (isset($_POST['deletePost']) && isset($_SESSION['user']['id'])) {
	global $conn;

	// Define POST variables to custom variables.
	$postMessageID = $conn->real_escape_string($_POST['messageID']);
	$postUserID = $conn->real_escape_string($_POST['userID']);

	// Delete a post from the post table.
	$stmt = $conn->prepare("DELETE FROM post WHERE id = ? AND user_id = ?");
	$stmt->bind_param("ss", $postMessageID, $postUserID);
	$stmt->execute();

	// Redirect user back to feed page.
	header("Location: ../feed.php?action=delete-successfull");
}