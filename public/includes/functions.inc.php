<?php
/**
 * Created by IntelliJ IDEA.
 * User: Luuk Kenselaar <luuk.kenselaar@protonmail.com>
 * Date: 23-6-2018
 * Time: 00:45
 */
//Require var $conn
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
function CheckIfEmptySignup($firstname,$lastname,$email,$password)
{
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

//This function will check if the user input at the Login is not empty
function CheckIfEmptyLogin($email,$password)
{
    if (empty($email) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

//This function will check if the users name is real
function CheckIfRealName($firstname,$lastname)
{
    if (preg_match("/^[a-z ,.'-]+$/i", $firstname) || !preg_match("/^[a-z ,.'-]+$/i", $lastname)) {
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
    if (strlen($password) >= 8) {
        return true;
    } else {
        return false;
    }
}

// This function will check if the Terms of Service is accepted.
function CheckIfAcceptedTOF($tof)
{
	if($tof === 'accepted') {
		return true;
	} else {
		return false;
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

//This function will generate the current date and put it inside a variable.
function GetCurrentDate()
{
    $date = date('Y-m-d H:i:s');
    return $date;
}

//This function will logout the user
function LogoutUser()
{
    session_start();
    session_unset();
    session_destroy();
}

function CopyrightYear()
{
    if (date('Y') == 2018) {
        echo "2018";
    } elseif (date('Y') != 2018) {
        echo "2018 - " . date('Y');
    }
}