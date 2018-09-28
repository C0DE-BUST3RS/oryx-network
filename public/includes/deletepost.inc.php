<?php
//Require the functions and start the session
require 'functions.inc.php';

//Check if the user has been logged in
If (!CheckIfLoggedIn()) {
	header("Location: ../index.php");
}

if (isset($_POST['deletePost']) && isset($_SESSION['user']['id']) && isset($_POST['redirectPage'])) {
	global $conn;

	// Define POST variables to custom variables.
	$postMessageID = $conn->real_escape_string($_POST['messageID']);
	$postUserID = $conn->real_escape_string($_POST['userID']);
	$postRedirect = $conn->real_escape_string($_POST['redirectPage']);

	// Delete a post from the post table.
	$stmt = $conn->prepare("DELETE FROM post WHERE id = ? AND user_id = ?");
	$stmt->bind_param("ss", $postMessageID, $postUserID);
	$stmt->execute();

	// Check if we need to redirect to feed of profile page.
	if($postRedirect === 'feed') {
		// Redirect user back to feed page.
    header("Location: ../feed.php?delete=successful");
    exit();
	} else if($postRedirect == 'admin')  {
		// Redirect user back to profile page.
    $_SESSION['deleted'] = "The post has been deleted";
    header("Location: ../admin/index.php?delete=successful");
		exit();
	} else {
		// Redirect user back to profile page.
		header("Location: ../profile.php?delete=successful");
    exit();
    }
}