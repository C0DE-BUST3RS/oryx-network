<?php
session_start();
require 'dbh.inc.php';

//This function will check if the email is used
//This function can be used at the signup and login
function CheckIfEmailUsed($email)
{
	global $conn;
	$sql = "SELECT * FROM user WHERE email = '$email';";
	$result = $conn->query($sql);
	$resultCheck = $result->num_rows;

	//If the email has been used
	if ($resultCheck > 0) {
		return true;

		//If the email does not exist
	} else {
		return false;
	}
}

//This function will check if the user input at the Signup is not empty
function CheckIfEmptySignup($firstname, $lastname, $email, $password)
{
	if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
		return false;
	} else {
		return true;
	}
}

//This function will check if the user input at the Login is not empty
function CheckIfEmptyLogin($email, $password)
{
	if (empty($email) || empty($password)) {
		return true;
	} else {
		return false;
	}
}

//This function will check if the users name is real
function CheckIfRealName($firstname, $lastname)
{
	if (preg_match('/^[A-Za-z \'-]+$/i', $firstname) || preg_match('/^[A-Za-z \'-]+$/i', $lastname)) {
		return true;
	} else {
		return false;
	}
}

//This function will check if the users email is real
function CheckIfRealEmail($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	} else {
		return false;
	}
}

//This function will check if the users password has the minimum length
function CheckIfPasswordLongEnough($password)
{
	if (strlen($password) >= 4) {
		return true;
	} else {
		return false;
	}
}

// This function wil check if the user is an admin or not.
function CheckIfAdmin($userRank)
{
	if (isset($userRank) && !empty($userRank)) {
		if ($userRank == 1) {
			return true;
		} else {
			return false;
		}
	}
}

//This function will generate a random userid, example: F98F13DE-BABA5AFD-5AFDB4F9
function GenerateUID()
{
	$s = strtoupper(md5(uniqid(rand(), true)));
	$id =
		substr($s, 0, 8) . '-' .
		substr($s, 8, 8) . '-' .
		substr($s, 12, 8);
	return $id;
}

//This function will hash the user his password
function HashPassword($nothashedPWD)
{
	$hashedPWD = password_hash($nothashedPWD, PASSWORD_DEFAULT);
	return $hashedPWD;
}

// This function will un-hash the user password.
function UnHashPassword($UserTypedPassword, $hashedPassword)
{
	if (password_verify($UserTypedPassword, $hashedPassword)) {
		return true;
	} else {
		return false;
	}
}

// This function wil check if the user is already logged in, ifso then redirect to feed page automaticly.
function CheckIfLoggedIn()
{
	if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) {
		//header("Location: ../feed.php");
		return true;
	} else {
		return false;
	}
}

//This function will generate the current date and put it inside a variable.
function GetCurrentDate()
{
	date_default_timezone_set('Europe/Amsterdam');
	$date = date('Y-m-d H:i:s');
	return $date;
}

// This function will get the users ip.
function GetUserIP()
{
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ip = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = '0.0.0.0';
	}
	return $ip;
}

//This function will logout the user
function LogoutUser()
{
	session_start();
	session_unset();
	session_destroy();
}

//This function will echo the copyright year in the footer
function CopyrightYear()
{
	if (date('Y') == 2018) {
		echo "2018";
	} elseif (date('Y') != 2018) {
		echo "2018 - " . date('Y');
	}
}

//This function will generate a token that will be send to the user
function GenerateToken()
{
	$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$string = str_shuffle($string);
	$token = substr($string, 40);
	$tokenfinal = str_shuffle($token);
	return $tokenfinal;
}