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

if (isset($_POST['registerSubmit'])) {
	// Define variable from POST
	$emailPost = mysqli_real_escape_string($conn, $_POST['']);
	$passwordPost = mysqli_real_escape_string($conn, $_POST['']);
	$firstnamePost = mysqli_real_escape_string($conn, $_POST['']);
	$lastnamePost = mysqli_real_escape_string($conn, $_POST['']);

	if (CheckIfRealEmail($emailPost) === true) {
		if (CheckIfEmailUsed($emailPost) === false) {
			// do shit
		}
	}

} else {
	header("Location ../index.php");
	exit();
}